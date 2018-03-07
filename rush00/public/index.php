<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   index.php                                          :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/20 10:38:16 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/21 19:12:06 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

session_start();

require_once("../conf/defines.php");
require_once("../scripts/auth.php");

if (!isset($_SESSION['user_logged'])) {
	$_SESSION['user_logged'] = array();
}

$_SESSION['user_logged'] = user_islogged($_SESSION['user_logged']);

if ($_SERVER['REQUEST_METHOD'] === "GET") {
	require_once("../get_request.php");
} else if ($_SERVER['REQUEST_METHOD'] === "POST") {
	require_once("../post_request.php");
}

?>
