<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   auth.php                                           :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/20 17:48:53 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/20 17:52:22 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function	auth($login, $passwd) {
	if (file_exists("../private/passwd")) {
		$users = unserialize(file_get_contents("../private/passwd"));
	}
	if (!$users) {
		return (false);
	}
	$hashed_pass = hash("whirlpool", $passwd);
	foreach ($users as $user) {
		if ($user['login'] === $login) {
			if ($user['passwd'] === $hashed_pass) {
				return (true);
			} else {
				return (false);
			}
		}
	}
}
