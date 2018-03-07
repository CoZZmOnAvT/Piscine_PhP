<!DOCTYPE html>
<html>
	<head>
		<title>Register</title>
		<link rel="stylesheet" type="text/css" href="/resources/game.css">
		<link href="https://fonts.googleapis.com/css?family=UnifrakturCook:700" rel="stylesheet">
	</head>
	<body>
		<form class="auth-form" method="POST" action="/register">
			<h2 class="header">Register Your Account</h2>
			<p class="error-msg"><?php echo Request::displayError(); ?></p>
			<input type="text" name="login" placeholder="Username" value="<?php echo @$_SESSION['reg_data']['username']; ?>" required />
			<br />
			<input type="password" name="passwd_1" placeholder="Password" required />
			<br />
			<input type="password" name="passwd_2" placeholder="Password (Confirm)" required />
			<br />
			<input type="submit" name="submit" value="Register" />
			<br />
			<a href="/login">I have an account</a>
		</form>
	</body>
</html>
