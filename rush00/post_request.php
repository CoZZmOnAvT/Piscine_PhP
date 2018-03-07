<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   post_request.php                                   :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/20 11:49:33 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/21 22:21:00 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

require_once("scripts/auth.php");

$uri = $_SERVER['REQUEST_URI'];

switch ($uri) {
	case '/signin':
		login();
		break;
	case '/signup':
		register();
		break;
	case '/edit':
		require_once("scripts/edit.php");
		break;
	case '/order/status':
		require_once("scripts/order.php");
		break;
	case '/product/add':
		require_once("scripts/product.php");
		break;
	case '/product/remove':
		require_once("scripts/product.php");
		break;
	default:
		include_once(ERROR_404);
		break;
}
