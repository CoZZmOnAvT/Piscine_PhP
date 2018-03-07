<?php
	$query = DB::query('SELECT login, games_won FROM `users`
						ORDER BY games_won DESC LIMIT 10');
	$i = 1;
	$top_ten_players = array();
	while ($data = DB::fetch_array($query)) {
		$top_ten_players[] = "<div class='top_ten_players_logins'>" . $i . ": " . $data['login'] . "<br /> games_won: " . $data['games_won'] . "</div>";
		$i++;
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="/resources/game.css">
		<title>Lobby</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script type="text/javascript" src="/resources/lobby.js"></script>
	</head>
	<body>
		<form >
			<input type="button" value="Logout" onClick='location.href="logout"' class="logout_button">
		</form>
		<div class="top_ten">
			<div class="top_ten_sign">Top 10 players:</div>
			<?php echo implode("\n", $top_ten_players) . "\n"; ?>
		</div>
		<div class="lobby">
			<div class="lobby_sign"><span id="count">0</span> players in the lobby</div>
			<form action="/game/create" method="POST" class="all-players">
			</form>
		</div>
	</body>
</html>