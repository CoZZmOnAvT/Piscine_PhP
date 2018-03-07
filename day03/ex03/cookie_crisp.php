<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   cookie_crisp.php                                   :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/18 19:26:09 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/19 19:58:53 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

if ($_GET["action"] === NULL)
	return ;

switch ($_GET["action"]) {
	case 'set':
		setcookie($_GET["name"], $_GET["value"], time() + 60*60);
		break;
	case 'get':
		if ($_COOKIE[$_GET["name"]]) {
			echo $_COOKIE[$_GET["name"]] . "\n";
		}
		break;
	case 'del':
		if ($_GET["name"]) {
			setcookie($_GET["name"], NULL, -1);
		}
		break;
	default:
		break;
}
