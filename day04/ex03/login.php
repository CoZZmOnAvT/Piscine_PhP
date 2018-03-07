<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   login.php                                          :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/20 17:52:34 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/20 18:08:05 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

session_start();

if (!$_GET[login] || !$_GET[passwd]) {
	echo "ERROR\n";
	return ;
}

include("auth.php");

if (auth($_GET[login], $_GET[passwd]) === true) {
	$_SESSION[loggued_on_user] = $_GET[login];
	echo "OK\n";
} else {
	$_SESSION[loggued_on_user] = "";
	echo "ERROR\n";
}
