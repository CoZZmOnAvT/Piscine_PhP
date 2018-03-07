<form class="auth-form" method="POST" action="/signup">
	<h2 class="header">Register Your Account</h2>
	<input type="text" name="login" placeholder="Username" value="<?php echo @$_SESSION['reg_data']['username']; ?>" required />
	<br />
	<input type="email" name="email" placeholder="Email" value="<?php echo @$_SESSION['reg_data']['email']; ?>" required />
	<br />
	<input type="password" name="passwd_1" placeholder="Password" required />
	<br />
	<input type="password" name="passwd_2" placeholder="Password (Confirm)" required />
	<br />
	<input type="submit" name="submit" value="Register" />
	<br />
	<a href="/signin">I have an account</a>
</form>