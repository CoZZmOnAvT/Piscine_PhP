<!DOCTYPE html>
<html>
	<head>
		<title>Login page</title>
		<link rel="stylesheet" type="text/css" href="/resources/game.css">
		<link href="https://fonts.googleapis.com/css?family=UnifrakturCook:700" rel="stylesheet">
	</head>
	<body>
		<form class="auth-form" method="POST" action="/login">
			<h2 class="header">Login to Your Account</h2>
			<p class="error-msg"><?php echo Request::displayError(); ?></p>
			<input type="text" name="login" placeholder="Username" required />
			<br />
			<input type="password" name="passwd" placeholder="Password" required />
			<br />
			<input type="submit" name="submit" value="Log In" />
			<br />
			<a href="/register">Register</a>
		</form>
	</body>
</html>