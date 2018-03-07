<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   auth.php                                           :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/20 18:33:42 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/21 19:12:01 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

require_once("../conf/db.php");

function	user_isadmin(array $user_data) {
	$mysqli_ctx = mysqli_init();
	if (mysqli_real_connect($mysqli_ctx, DB_HOST, DB_LOGIN, DB_PASSWD, DB_NAME, DB_PORT) === false) {
		return (array());
	}
	if (empty($user_data)) {
		mysqli_close($mysqli_ctx);
		return ($user_data);
	}

	$query = mysqli_query($mysqli_ctx, "SELECT `attributes` FROM `users`
										WHERE `id` = " . $user_data['id']);
	$attributes = mysqli_fetch_array($query);
	$attributes = $attributes[0];

	mysqli_close($mysqli_ctx);

	if ($attributes == 1) {
		return (true);
	} else {
		return (false);
	}	
}

function	user_islogged(array $user_data) {
	$mysqli_ctx = mysqli_init();
	if (mysqli_real_connect($mysqli_ctx, DB_HOST, DB_LOGIN, DB_PASSWD, DB_NAME, DB_PORT) === false) {
		return (array());
	}
	if (empty($user_data)) {
		mysqli_close($mysqli_ctx);
		return ($user_data);
	}

	$query = mysqli_query($mysqli_ctx, "SELECT `ip` FROM `logged_users`
										WHERE `user_id` = " . $user_data['id']);
	$query = mysqli_fetch_array($query);

	$ipAddress = $_SERVER['REMOTE_ADDR'];
	if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
		$ipAddress = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
	}

	if ($query['ip'] === $ipAddress) {
		if (empty($user_data['login'])) {
			$user_data['login'] = mysqli_query($mysqli_ctx, "SELECT `login` FROM `users`
															WHERE `id` = " . $user_data['id']);
			$user_data['login'] = mysqli_fetch_array($user_data['login']);
			$user_data['login'] = $user_data['login']['login'];
			if (!isset($user_data['login']) || empty($user_data['login'])) {
				mysqli_close($mysqli_ctx);
				return (array());
			}
		}
		mysqli_close($mysqli_ctx);
		return ($user_data);
	} else {
		mysqli_close($mysqli_ctx);
		return (array());
	}
}

function	login() {
	sleep(1);
	$mysqli_ctx	= mysqli_init();
	if (mysqli_real_connect($mysqli_ctx, DB_HOST, DB_LOGIN, DB_PASSWD, DB_NAME, DB_PORT) === false) {
		$_SESSION['error'] = "Error, please, try again later";
		header("Location: /signin");
		exit ;
	}

	$username	= strtolower(mysqli_real_escape_string($mysqli_ctx, trim($_POST['login'])));
	$passwd		= mysqli_real_escape_string($mysqli_ctx, $_POST['passwd']);

	$username_len	= strlen($username);
	$passwd_len		= strlen($passwd);

	if (empty($username) || empty($passwd) || !$_POST['submit']) {
		$_SESSION['error'] = "Enter username and password!";
		header("Location: /signin");
		exit ;
	}

	preg_match("/[^a-zA-Z]/is", $username, $matches);
	if (!empty($matches) || $username_len < 3 || $username_len > 16) {
		$_SESSION['error'] = "Incorect username or password";
		header("Location: /signin");
		exit ;
	}

	preg_match("/[^a-zA-Z0-9 !@#$%^&*()-=+_]/is", $passwd, $matches);
	if (!empty($matches) || $passwd_len < 10 || $passwd_len > 16) {
		$_SESSION['error'] = "Incorect username or password";
		header("Location: /signin");
		exit ;
	}

	$passwd_hash = hash("whirlpool", $passwd);
	$query = mysqli_query($mysqli_ctx, "SELECT `id` FROM `users` WHERE
										`login` = '" . $username . "' AND
										`password` = '" . $passwd_hash . "';");
	$query = mysqli_fetch_array($query);
	if (!empty($query)) {		
		$_SESSION['user_logged']['login'] = $username;
		$_SESSION['user_logged']['id'] = $query['id'];

		$ipAddress = $_SERVER['REMOTE_ADDR'];
		if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
			$ipAddress = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
		}
		$ipAddress	= mysqli_real_escape_string($mysqli_ctx, $ipAddress);
		mysqli_query($mysqli_ctx, "	INSERT INTO `logged_users`(user_id, ip)
									VALUES(" . $query['id'] . ", '" . $ipAddress . "')
									ON DUPLICATE KEY
									UPDATE
										`log_date` = CURRENT_TIMESTAMP,
										`ip` =
									VALUES(ip);");

		mysqli_query($mysqli_ctx, "UPDATE `users` SET `log_date` = CURRENT_TIMESTAMP WHERE `id` = " . $query['id']);
		header("Location: /");
	} else {
		$_SESSION['error'] = "Incorect username or password";
		header("Location: /signin");
	}
}

function	register() {
	sleep(1);
	$mysqli_ctx	= mysqli_init();
	if (mysqli_real_connect($mysqli_ctx, DB_HOST, DB_LOGIN, DB_PASSWD, DB_NAME, DB_PORT) === false) {
		$_SESSION['error'] = "Error, please, try again later";
		header("Location: /signin");
		exit ;
	}

	$username	= strtolower(mysqli_real_escape_string($mysqli_ctx, trim($_POST['login'])));
	$email		= strtolower(mysqli_real_escape_string($mysqli_ctx, trim($_POST['email'])));
	$passwd_1	= mysqli_real_escape_string($mysqli_ctx, $_POST['passwd_1']);
	$passwd_2	= mysqli_real_escape_string($mysqli_ctx, $_POST['passwd_2']);

	$_SESSION['reg_data']['username'] = htmlspecialchars(strip_tags($username));
	$_SESSION['reg_data']['email'] = htmlspecialchars(strip_tags($email));

	$username_len	= strlen($username);
	$email_len		= strlen($email);
	$passwd_1_len	= strlen($passwd_1);
	$passwd_2_len	= strlen($passwd_2);

	if (empty($username) || empty($email) || empty($passwd_1) || empty($passwd_2) || !$_POST['submit']) {
		$_SESSION['error'] = "Enter username, email and password!";
		mysqli_close($mysqli_ctx);
		header("Location: /signup");
		exit ;
	}

	preg_match("/[^a-zA-Z]/is", $username, $matches);
	if (!empty($matches)) {
		$_SESSION['error'] = "Username must contain only english letters";
		mysqli_close($mysqli_ctx);
		header("Location: /signup");
		exit ;
	} else if ($username_len < 3 || $username_len > 16) {
		$_SESSION['error'] = "Username length should be between 3 and 16 characters";
		mysqli_close($mysqli_ctx);
		header("Location: /signup");
		exit ;
	}

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$_SESSION['error'] = "Enter correct email!";
		mysqli_close($mysqli_ctx);
		header("Location: /signup");
		exit ;
	}

	preg_match("/[^a-zA-Z0-9 !@#$%^&*()-=+_]/is", $passwd, $matches);
	if ($passwd_1 !== $passwd_2 || $passwd_1_len !== $passwd_2_len) {
		$_SESSION['error'] = "Passwords don't match";
		mysqli_close($mysqli_ctx);
		header("Location: /signup");
		exit ;
	} else if (!empty($matches)) {
		$_SESSION['error'] = "Password must contain only english letters,<br />
								numbers and default special characters";
		mysqli_close($mysqli_ctx);
		header("Location: /signup");
		exit ;
	} else if ($passwd_1_len < 10 || $passwd_1_len > 16) {
		$_SESSION['error'] = "Password length should be between 10 and 16 characters";
		mysqli_close($mysqli_ctx);
		header("Location: /signup");
		exit ;
	}

	$query = mysqli_query($mysqli_ctx, "SELECT `id` FROM `users` WHERE
										`login` = '" . $username. "';");	
	$query = mysqli_fetch_array($query);
	if (!empty($query)) {
		$_SESSION['error'] = "Username " . $username . " is busy";
		mysqli_close($mysqli_ctx);
		header("Location: /signup");
		exit ;
	}
	$passwd_hash = hash("whirlpool", $passwd_1);
	mysqli_query($mysqli_ctx, "	INSERT INTO `users`(login, password, email, info)
								VALUES('" . $username . "', '" . $passwd_hash . "', '" . $email . "', ' ');");
	$query = mysqli_query($mysqli_ctx, "SELECT `id` FROM `users`
										WHERE `login` = '" . $username . "';");
	$query = mysqli_fetch_array($query);
	$user_id = $query['id'];

	$ipAddress = $_SERVER['REMOTE_ADDR'];
	if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
		$ipAddress = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
	}
	$ipAddress	= mysqli_real_escape_string($mysqli_ctx, $ipAddress);

	mysqli_query($mysqli_ctx, "	INSERT INTO `logged_users`(user_id, ip)
								VALUES(" . $user_id . ", '" . $ipAddress . "');");
	$_SESSION['user_logged']['login']	= $username;
	$_SESSION['user_logged']['id']		= $user_id;
	mysqli_close($mysqli_ctx);
	unset($_SESSION['reg_data']);
	header("Location: /");
}

function	logout(array &$user_data)
{
	sleep(1);
	$mysqli_ctx	= mysqli_init();
	if (mysqli_real_connect($mysqli_ctx, DB_HOST, DB_LOGIN, DB_PASSWD, DB_NAME, DB_PORT) === false) {
		$_SESSION['error'] = "Error, please, try again later";
		header("Location: /signin");
		exit ;
	}
	mysqli_query($mysqli_ctx, "	DELETE FROM `logged_users`
								WHERE `user_id`=" . $user_data['id']);
	$user_data = array();
	mysqli_close($mysqli_ctx);
	header("Location: /");
}
