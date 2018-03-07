<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   get_request.php                                    :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/20 11:15:33 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/21 23:20:42 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

$uri = $_SERVER['REQUEST_URI'];

$uri = rtrim($uri, "/");
if (!$uri) {
	$uri = "/";
}
preg_match("/[0-9]+/i", $uri, $param);

$body = NULL;
switch ($uri) {
	case '/':
		$body = "pages/home.html";
		break;
	case '/profile':
		$body = "pages/profile.php";
		break;
	case '/category/dining':
		$body = "pages/display-products.php";
		$category = 'dining';
		break;
	case '/category/decorative':
		$body = "pages/display-products.php";
		$category = 'decorative';
		break;
	case '/category/git':
		$body = "pages/display-products.php";
		$category = 'git';
		break;
	case '/product':
		header("Location: /category/dining");
		exit ;
		break;
	case '/product/' . @$param[0]:
		$product_id = intval($param[0]);
		$body = "pages/detailed-product.php";
		break;
	case '/signin':
		$body = "pages/signin.html";
		break;
	case '/signup':
		$body = "pages/signup.php";
		break;
	case '/logout':
		require_once("scripts/auth.php");
		logout($_SESSION['user_logged']);
		break;
	default:
		$body = ERROR_404;
		break;
}

require_once("scripts/template.php");
