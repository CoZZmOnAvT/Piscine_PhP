<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   modif.php                                          :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/19 20:03:01 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/19 20:17:34 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

define("private_path", "../private");
define("ERR_MSG", "ERROR\n");

if ($_POST["submit"] === "OK") {
	if (!$_POST["login"] || !$_POST["oldpw"] || !$_POST["newpw"]) {
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
	$old_password = hash("whirlpool", $_POST["oldpw"]);
	$new_password = hash("whirlpool", $_POST["newpw"]);
	$user_found = 0;
	foreach ($log_data as &$user) {
		if ($username === $user["login"]) {
			$user_found = 1;
			if ($old_password === $user["passwd"]) {
				$user["passwd"] = $new_password;
			} else {
				echo ERR_MSG;
				return ;
			}
			break ;
		}
	}
	if (!$user_found) {
		echo ERR_MSG;
		return ;
	}
	file_put_contents(private_path . "/passwd", serialize($log_data));
	echo "OK\n";
} else {
	echo ERR_MSG;
}

