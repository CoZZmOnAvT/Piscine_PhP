<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   product.php                                        :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/21 21:13:22 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/21 22:42:02 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

$user_isadmin = user_isadmin($_SESSION['user_logged']);

if ($user_isadmin === false) {
	$_SESSION['error'] = "You are not authorized!";
	header("Location: /");
	exit ;
}

if (isset($_POST['add-product'])) {
	$_SESSION['add_product_data']['title'] = trim(htmlspecialchars(strip_tags($_POST['title'])));
	$_SESSION['add_product_data']['category'] = trim(htmlspecialchars(strip_tags($_POST['category'])));
	$_SESSION['add_product_data']['description'] = trim(htmlspecialchars(strip_tags($_POST['description'])));
	$_SESSION['add_product_data']['price'] = trim(htmlspecialchars(strip_tags($_POST['price'])));

	if (!$_POST['title'] || !$_POST['category'] || !$_FILES['img']
		|| !$_POST['description'] || !$_POST['price']) {
		$_SESSION['error'] = "Fill all fields";
		header("Location: " . $_SERVER['HTTP_REFERER']);
		exit ;
	}
	$mysqli_ctx = mysqli_init();
	if (mysqli_real_connect($mysqli_ctx, DB_HOST, DB_LOGIN, DB_PASSWD, DB_NAME, DB_PORT) === false) {
		$_SESSION['error'] = "Error, please, try again later";
		header("Location: " . $_SERVER['HTTP_REFERER']);
		exit ;
	}
	$title = mysqli_real_escape_string($mysqli_ctx, strip_tags(trim($_POST['title'])));
	$category = strtolower(mysqli_real_escape_string($mysqli_ctx, strip_tags(trim($_POST['category']))));
	$description = mysqli_real_escape_string($mysqli_ctx, strip_tags(trim($_POST['description'])));
	$price = intval(trim($_POST['price']));

	if ($category !== "dining" && $category !== "decorative" && $category !== "git") {
		$category = "dining";
	}

	if ($_FILES['img']['error'] > 0) {
		$_SESSION['error'] = "Can't load image";
		header("Location: " . $_SERVER['HTTP_REFERER']);
		exit ;
	}

	$img_type = mime_content_type($_FILES['img']['tmp_name']);
	if ($img_type !== "image/jpeg" && $img_type !== "image/png") {
		$_SESSION['error'] = "Avalible img formats are: jpg/jpeg, png";
		header("Location: " . $_SERVER['HTTP_REFERER']);
		exit ;
	}

	if (!file_exists('../public/resources/products/')) {
		mkdir('../public/resources/products/');
	}

	$uploadfile = '../public/resources/products/' . basename($_FILES['img']['name']);
	if (move_uploaded_file($_FILES['img']['tmp_name'], $uploadfile) !== true) {
		$_SESSION['error'] = "Error, please, try again later";
		header("Location: " . $_SERVER['HTTP_REFERER']);
		exit ;
	}
	$img_src = '/resources/products/' . mysqli_real_escape_string($mysqli_ctx, basename($_FILES['img']['name']));
	mysqli_query($mysqli_ctx, "	INSERT INTO `products`(
									`category`,
									`title`,
									`description`,
									`img`,
									`price`
								)
								VALUES(
									'" . $category . "',
									'" . $title . "',
									'" . $description . "',
									'" . $img_src . "',
									'" . $price . "');");
	unset($_SESSION['add_product_data']);
	mysqli_close($mysqli_ctx);
	header("Location: " . $_SERVER['HTTP_REFERER']);
} else if (isset($_POST['remove-product'])) {
	$mysqli_ctx = mysqli_init();
	if (mysqli_real_connect($mysqli_ctx, DB_HOST, DB_LOGIN, DB_PASSWD, DB_NAME, DB_PORT) === false) {
		$_SESSION['error'] = "Error, please, try again later";
		header("Location: " . $_SERVER['HTTP_REFERER']);
		exit ;
	}

	$product_id = intval($_POST['remove-product']);
	if ($product_id <= 0) {
		$_SESSION['error'] = "You are not authorized!";
		header("Location: " . $_SERVER['HTTP_REFERER']);
		exit ;
	}

	$query = mysqli_query($mysqli_ctx, "SELECT `img` FROM `products` WHERE `id` = " . $product_id);
	$query = mysqli_fetch_array($query);
	$img_src = $query['img'];
	unlink('../public/resources/products/' . basename($img_src));

	mysqli_query($mysqli_ctx, "DELETE FROM `products` WHERE `id` = " . $product_id);
	mysqli_close($mysqli_ctx);
	header("Location: " . $_SERVER['HTTP_REFERER']);
}

