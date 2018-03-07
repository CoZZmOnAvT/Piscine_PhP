<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   edit.php                                           :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/21 18:30:59 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/21 18:39:04 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

if (empty($_SESSION['user_logged'])) {
	header("Location: /signin");
	exit ;
}

$mysqli_ctx = mysqli_init();
if (mysqli_real_connect($mysqli_ctx, DB_HOST, DB_LOGIN, DB_PASSWD, DB_NAME, DB_PORT) === false) {
	exit ;
}

$username = mysqli_real_escape_string($mysqli_ctx, strip_tags(trim($_POST['name'])));
$phone = mysqli_real_escape_string($mysqli_ctx, strip_tags(trim($_POST['phone'])));
$address = mysqli_real_escape_string($mysqli_ctx, strip_tags(trim($_POST['address'])));

$user_info = mysqli_real_escape_string($mysqli_ctx,
				json_encode(array("name" => $username, "phone" => $phone, "address" => $address)));

mysqli_query($mysqli_ctx, "	UPDATE `users`
							SET `info` = '" . $user_info . "'
							WHERE `id` = " . $_SESSION['user_logged']['id']);

mysqli_close($mysqli_ctx);

header("Location: /profile");
