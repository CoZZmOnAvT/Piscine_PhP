<?php

/**
* 
*/
class Game
{
	use Errors;

	static function	playerStatus(string $status = 'in_lobby') {
		if (($user_data = Auth::getData()) !== NULL) {
			$query = DB::query('SELECT * FROM `players` WHERE `user_id` = :user_id AND `status` = :status',
								array('user_id' => $user_data['user_id'], 'status' => $status));
			$query = DB::fetch_array($query);
			if ($query !== false && !empty($query)) {
				return (true);
			} else {
				return (false);
			}
		} else {
			return (false);
		}
	}

	static function	create_session(int $enemy_id = 0) {
		if (isset($_POST['enemy_id'])) {
			$enemy_id = abs(intval($_POST['enemy_id']));
		}

		if (($user_data = Auth::getData()) === NULL) {
			return ;
		}
		$query = DB::query('SELECT COUNT(*) AS `count`
							FROM `players`
							WHERE (
								`user_id` = :user_id OR `user_id` = :enemy_id
								) 
								AND `status` = \'in_lobby\'
								AND CURRENT_TIMESTAMP - `timestamp` <= 2;',
			array('user_id' => $user_data['user_id'], 'enemy_id' => $enemy_id));
		$data = DB::fetch_array($query);
		if ($data === false || empty($data) || $data['count'] != 2) {
			return ;
		} else {
			DB::query('UPDATE `players`
						SET
							`status` = \'in_game\'
						WHERE `user_id` = :user_id OR `user_id` = :enemy_id',
					array('user_id' => $user_data['user_id'], 'enemy_id' => $enemy_id));
			DB::query('INSERT INTO `games` (player1, player2, map)
						VALUES (:player1, :player2, :map);',
					array('player1' => $user_data['user_id'], 'player2' => $enemy_id,
							'map' => json_encode(self::_generateMap())));
			Request::redirect('/game');
		}
	}

	static function			playerInLobby() {
		if (($user_data = Auth::getData()) !== NULL) {
			if (isset($_POST['user']) && $_POST['user'] === 'active') {
				$query = DB::query('SELECT `status` FROM `players` WHERE `user_id` = :user_id',
									array('user_id' => $user_data['user_id']));
				$data = DB::fetch_array($query);
				if ($data !== false && !empty($data) && $data['status'] !== 'in_lobby') {
					echo json_encode(array('user_in_game' => true));
				} else {
					DB::query('	INSERT INTO `players` (`user_id`, `timestamp`)
								VALUES (:user_id, CURRENT_TIMESTAMP)
								ON DUPLICATE KEY
								UPDATE
									`timestamp` = CURRENT_TIMESTAMP;',
							array('user_id' => $user_data['user_id']));
				}				
			}
		}
	}

	static function			loadPlayers() {
		if (($user_data = Auth::getData()) !== NULL) {
			if (isset($_POST['action']) && $_POST['action'] === 'showall') {
				$query = DB::query('SELECT `login`, `users`.`user_id` FROM `players`
								JOIN `users` ON `players`.`user_id` = `users`.`user_id`
								WHERE `status` = \'in_lobby\' AND CURRENT_TIMESTAMP - `timestamp` <= 3');

				$players = array();
				$players_in_lobby = 0;
				$user_data = Auth::getData();
				while ($data = DB::fetch_array($query)) {
					if ($user_data['username'] != $data['login']) {
						$players_in_lobby++;
						$players['html'][] = "<button class='player' value='" . $data['user_id'] . "' name='enemy_id'>" . $data['login'] . "</button>";
					}
				}
				$players['count'] = $players_in_lobby;
				echo json_encode($players);
			}
		}
	}

	static private function	_generateMap() {
		$gd = array();

		for ($i = 0; $i < 150; $i++) { 
			for ($j = 0; $j < 100; $j++) {
				if (rand(0, 1024) === 1) {
					$gd[$i][] = 3;
				} else {
					$gd[$i][] = 0;
				}
			}
		}

		$gd[0][0] = 1;
		$gd[134][94] = 2;

		for ($i = 0; $i < 15; $i++) {
			for ($j = 0; $j < 5; $j++) {
				if ($gd[$i][$j] == 3) {
					$gd[$i][$j] = 0;
				}
				if ($gd[$i + 134][$j + 94] == 3) {
					$gd[$i + 134][$j + 94] = 0;
				}
			}
		}
		
		return ($gd);
	}

	static function			dumpMap() {
		if (self::playerStatus('in_game') === true) {
			$query = DB::query('SELECT `map` FROM `games` WHERE `player1` = :user_id OR `player2` = :user_id',
							array('user_id' => Auth::getData()['user_id']));
			$data = DB::fetch_array($query);
			return ($data['map']);
		} else {
			return (NULL);
		}
	}

	static function			updateMap(array $map, int $game_id) {
		if (self::playerStatus('in_game') === true) {
			DB::query('UPDATE `games` SET `map` = :map WHERE `id` = :game_id',
						array('map' => json_encode($map), 'game_id' => $game_id));
		}
	}

	static function			closeGame($redirect = 1) {
		if (self::playerStatus('in_game') === true) {
			$query = DB::query('SELECT * FROM `games`
								WHERE `player1` = :user_id OR `player2` = :user_id',
						array('user_id' => Auth::getData()['user_id']));
			$data = DB::fetch_array($query);
			if ($data !== false && !empty($data)) {
				DB::query('	UPDATE `players`
							SET `status` = \'in_lobby\'
							WHERE `user_id` = :player1 OR `user_id` = :player2',
						array('player1' => $data['player1'], 'player2' => $data['player2']));
				DB::query('DELETE FROM `games` WHERE `id` = :id', array('id' => $data['id']));
			}
		}
		if ($redirect === 1) {
			Request::redirect('/');
		}
	}

	static private function			_game_lose(int $enemy_id) {
		self::closeGame(0);
		DB::query('UPDATE `users`
					SET `games_won` = `games_won` + 1
					WHERE `user_id` = :enemy_id',
				array('enemy_id' => $enemy_id));
		echo "You lose";
	}

	static private function			_game_win() {
		self::closeGame(0);
		$user_data =  Auth::getData();
		DB::query('UPDATE `users`
					SET `games_won` = `games_won` + 1
					WHERE `user_id` = :user_id',
				array('user_id' => $user_data['user_id']));
		echo "You win!";
	}

	static private function			_place_ship(array &$map, $i, $j, $side, $enemy_id) {
		$can_place = true;

		if ($i < 0 || $j < 0 || $i + 15 >= 150 || $j + 5 >= 100) {
			self::_game_lose($enemy_id);
			exit();
		}

		for ($_i = $i; $_i < $i + 15; $_i++) {
			for ($_j = $j; $_j < $j + 5; $_j++) {
				if ($map[$_i][$_j] !== 0) {
					$can_place = false;
				}
			}
		}

		if ($can_place === true) {
			$map[$i][$j] = $side;
		} else {
			self::_game_lose($enemy_id);
		}
	}

	static private function			_findShip(array $map, int $side) {
		$i = -1;
		$j = -1;
		while (++$i < 150) {
			$j = -1;
			while (++$j < 100) {
				if ($map[$i][$j] == $side) {
					return (array($i, $j));
				}
			}
		}
	}

	static private function			_move(string $direction, array &$map, int $side, int $game_id, $enemy_id) {
		$postition = self::_findShip($map, $side);

		$i = $postition[0];
		$j = $postition[1];
		$map[$i][$j] = 0;
		switch ($direction) {
			case 'w':
				self::_place_ship($map, $i, $j - 1, $side, $enemy_id);
				break;
			case 'a':
				self::_place_ship($map, $i - 1, $j, $side, $enemy_id);
				break;
			case 's':
				self::_place_ship($map, $i, $j + 1, $side, $enemy_id);
				break;
			case 'd':
				self::_place_ship($map, $i + 1, $j, $side, $enemy_id);
				break;
			default:
				break;
		}
		return ;
	}

	static private function			_shoot(array &$map, int $side, int $game_id, $enemy_id) {
		$postition = self::_findShip($map, $side);

		$i = $postition[0];
		$j = $postition[1] + 2;

		$it = ($side == 1 ? 1 : -1);
		$enemy_side = intval(2 / $side);
		for ($_i = $i; $_i != $i + 30 * $it; $_i += $it) { 
			if ($map[$_i][$j] == $enemy_side) {
				self::_game_win();
			}
		}
	}

	static function			action() {
		if (isset($_POST['action']) && self::playerStatus('in_game') === true) {
			$user_data =  Auth::getData();

			$query = DB::query('SELECT * FROM `games` WHERE `player1` = :user_id OR `player2` = :user_id',
							array('user_id' => $user_data['user_id']));
			$data = DB::fetch_array($query);

			$enemy_id = 0;
			$side = 1;
			if ($data['player1'] == $user_data['user_id']) {
				$side = 1;
				$enemy_id = $data['player2'];
			} else {
				$side = 2;
				$enemy_id = $data['player1'];
			}

			$map = json_decode($data['map'], true);

			switch ($_POST['action']) {
				case 'move:w':
					self::_move('w', $map, $side, $data['id'], $enemy_id);
					break;
				case 'move:a':
					self::_move('a', $map, $side, $data['id'], $enemy_id);
					break;
				case 'move:s':
					self::_move('s', $map, $side, $data['id'], $enemy_id);
					break;
				case 'move:d':
					self::_move('d', $map, $side, $data['id'], $enemy_id);
					break;
				case 'shoot':
					self::_shoot($map, $side, $data['id'], $enemy_id);
					break;
				default:
					break;
			}

			self::updateMap($map, $data['id']);
		}
	}
}