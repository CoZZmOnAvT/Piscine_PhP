<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   order.php                                          :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/21 19:41:07 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/21 20:01:14 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function	update_status(string $status, int $order_id) {
	if (user_isadmin($_SESSION['user_logged']) === false) {
		$_SESSION['error'] = "You are not authorized!";
		header("Location: /");
		exit ;
	}
	$mysqli_ctx = mysqli_init();
	if ($order_id <= 0
		|| mysqli_real_connect($mysqli_ctx, DB_HOST, DB_LOGIN, DB_PASSWD, DB_NAME, DB_PORT) === false) {
		$_SESSION['error'] = "Error, please, try again later";
		header("Location: " . $_SERVER['HTTP_REFERER']);
		exit ;
	}
	$status = mysqli_real_escape_string($mysqli_ctx, $status);
	mysqli_query($mysqli_ctx, "UPDATE `orders` SET `status` = '" . $status . "' WHERE `id` = " . $order_id);
	mysqli_close($mysqli_ctx);
	header("Location: " . $_SERVER['HTTP_REFERER']);
}

if (isset($_POST['done'])) {
	update_status("done", intval($_POST['done']));
} else if (isset($_POST['cancel'])) {
	update_status("canceled", intval($_POST['cancel']));
}
