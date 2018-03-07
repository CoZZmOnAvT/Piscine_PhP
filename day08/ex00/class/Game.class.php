<?php

class Game
{
	private			$_id = 0;
	private			$_map = array();
	private			$_raw_map = array();
	private			$_players = array();
	public static 	$verbose = true;

	function			__construct(int $id)
	{
		$query = DB::query('SELECT * FROM `games` WHERE `id` = :id', array('id' => $id));
		$data = DB::fetch_array($query);

		if (is_array($data)) {
			$this->_id = $id;
			$this->_map = json_decode($data['map'], true);
			$this->_raw_map = $this->_map;
		}

		$this->get_players();
		$this->place_players();
	}

	public function		dumpJSON() {
		return (json_encode($this->_raw_map, true));
	}

	public function		restart($width = 100, $height = 150, $density = 812) {
		$gd = array();

		for ($i = 0; $i < $height; $i++) { 
			for ($j = 0; $j < $width; $j++) {
				if (rand(0, $density) === 1) {
					$gd[$i][] = 3;
				} else {
					$gd[$i][] = 0;
				}
			}
		}		

		$this->_map = $gd;
		$this->_raw_map = $gd;

		$this->get_players();
		$this->place_players();

		DB::query('UPDATE `games` SET `map` = :map WHERE `id` = :id',
					array('map' => json_encode($this->_raw_map), 'id' => $this->_id));
		DB::query('UPDATE `players` SET `info` = "" WHERE `game_id` = :game_id',
					array('game_id' => $this->_id));		
	}

	private function	get_players() {
		$query = DB::query('SELECT `player1`, `player2` FROM `games` WHERE `id` = :id',
							array('id' => $this->_id));
		$data = DB::fetch_array($query);
		$query = DB::query('SELECT `id`, `name`, `info` FROM `players` WHERE `id` = :id1 OR `id` = :id2',
							array('id1' => $data['player1'], 'id2' => $data['player2']));
		$this->_players = array();
		$limit = 2;
		while (($player = DB::fetch_array($query)) && $limit--) {
			$tmp = new Player($player['name'], $player['info'], $player['id']);
			$this->_players[] = $tmp;
		}
		$this->_players[0]->position = array(0, 0);
		$this->_players[1]->position = array(134, 94);
	}

	private function	place_players($raw = 0) {
		foreach ($this->_players as $player) {
			$position	= $player->position;
			$size		= $player->get_size();

			$this->_raw_map[$position[0]][$position[1]] = $player->id;

			for ($i = $position[0]; $i <= $position[0] + $size[0]; $i++) {
				for ($j = $position[1]; $j <= $position[1] + $size[1]; $j++) {
					if ($this->_map[$i][$j] == 3) {
						$this->_raw_map[$i][$j] = 0;
					}
					$this->_map[$i][$j] = $player->id;
				}
			}
		}
	}
}
