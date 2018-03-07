<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   create.php                                         :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/19 15:54:13 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/19 20:12:32 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

define("private_path", "../private");
define("ERR_MSG", "ERROR\n");

if ($_POST["submit"] === "OK") {
	if (!$_POST["login"] || !$_POST["passwd"]) {
		echo ERR_MSG;
		return ;
	}
	if (!file_exists(private_path)) {
		mkdir(private_path);
	}
	if (!file_exists(private_path . "/.htaccess")) {
		file_put_contents(private_path . "/.htaccess", "Deny from all");
	}
	if (file_exists(private_path . "/passwd")) {
		$log_data = unserialize(file_get_contents(private_path . "/passwd"));
	}
	$username = $_POST["login"];
	$password = hash("whirlpool", $_POST["passwd"]);
	foreach ($log_data as $user) {
		if ($username == $user["login"]) {
			echo ERR_MSG;
			return ;
		}
	}
	$log_data[] = array("login" => $username, "passwd" => $password);
	file_put_contents(private_path . "/passwd", serialize($log_data));
	echo "OK\n";
} else {
	echo ERR_MSG;
}
