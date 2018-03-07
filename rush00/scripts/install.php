<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   install.php                                        :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/20 11:17:56 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/21 21:09:57 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

require_once("../conf/db.php");

define("ADMIN_NAME", "admin");
define("ADMIN_PASSWD", "1234567890");
define("ADMIN_EMAIL", "admin@example.com");

$connect_retries = 0;
function	db_connect(mysqli &$mysqli_context) {
	@$db_connection = mysqli_real_connect($mysqli_context, DB_HOST, DB_LOGIN,
										DB_PASSWD, DB_NAME, DB_PORT);
	if ($db_connection === false && $connect_retries < 4) {
		$connect_retries++;
		$db_connection = mysqli_real_connect($mysqli_context, DB_HOST, DB_LOGIN,
											DB_PASSWD, NULL, DB_PORT);
		mysqli_query($mysqli_context, "CREATE DATABASE IF NOT EXISTS " . DB_NAME
						. " COLLATE utf8_unicode_ci;");
		mysqli_select_db($mysqli_context, DB_NAME);
		return ($db_connection);
	}
	return ($db_connection);
}

$mysqli_context = mysqli_init();

db_connect($mysqli_context);

mysqli_query($mysqli_context, "CREATE TABLE IF NOT EXISTS `users` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`login` VARCHAR(32) NOT NULL,
	`password` VARCHAR(128) NOT NULL,
	`email` VARCHAR(256) NOT NULL,
	`info` VARCHAR(2048) NOT NULL,
	`reg_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`log_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`attributes` INT NOT NULL DEFAULT '0',
	PRIMARY KEY(`id`),
	UNIQUE(`login`)
) ENGINE = InnoDB;");

mysqli_query($mysqli_context, "CREATE TABLE IF NOT EXISTS `products` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`category` VARCHAR(256) NOT NULL,
	`title` VARCHAR(32) NOT NULL,
	`description` VARCHAR(1024) NOT NULL,
	`img` VARCHAR(1024) NOT NULL,
	`price` INT NOT NULL,
	`post_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`edit_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(`id`)
) ENGINE = InnoDB;");

mysqli_query($mysqli_context, "CREATE TABLE IF NOT EXISTS `orders`(
	`id` INT NOT NULL AUTO_INCREMENT,
	`user_id` INT NOT NULL,
	`order_info` VARCHAR(2048) NOT NULL,
	`user_info` VARCHAR(256) NOT NULL,
	`status` VARCHAR(128) NOT NULL,
	`date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(`id`)
) ENGINE = InnoDB;");

mysqli_query($mysqli_context, "CREATE TABLE IF NOT EXISTS `logged_users`(
	`id` INT NOT NULL AUTO_INCREMENT,
	`user_id` INT NOT NULL,
	`log_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`ip` VARCHAR(45) NOT NULL,
	PRIMARY KEY(`id`),
	UNIQUE(`user_id`)
) ENGINE = InnoDB;");

$hashed_pass = hash("whirlpool", ADMIN_PASSWD);

mysqli_query($mysqli_context, "INSERT INTO `users`(
	`login`,
	`password`,
	`email`,
	`info`,
	`attributes`)
	VALUES ('" . ADMIN_NAME . "', '" . $hashed_pass . "', '" . ADMIN_EMAIL . "', '', 1)");

mysqli_close($mysqli_context);
