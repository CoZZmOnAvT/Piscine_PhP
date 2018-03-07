<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   index.php                                          :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/19 13:44:33 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/19 19:48:57 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

session_start();

if ($_GET['submit'] === "OK") {
	$_SESSION['login']	= $_GET["login"];
	$_SESSION['passwd']	= $_GET["passwd"];
}

?>

<html><body>
<form method="GET">
	Username: <input type="text" name="login" value="<?php echo $_SESSION['login']; ?>" />
	<br />
	Password: <input type="password" name="passwd" value="<?php echo $_SESSION['passwd']; ?>" />
	<input type="submit" name="submit" value="OK" />
</form>
</body></html>
