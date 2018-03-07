<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   bootstrap.php                                      :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/26 13:59:06 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/28 15:19:21 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

session_start();

require_once($GLOBALS['document_root'] . 'conf/db.php');
require_once($GLOBALS['document_root'] . 'conf/main.php');

foreach (glob($GLOBALS['document_root'] . "class/*.trait.php") as $trait_file) {
	require_once($trait_file);
}

foreach (glob($GLOBALS['document_root'] . "class/*.class.php") as $class_file) {
	require_once($class_file);
}

DB::set_data(DB_HOST, DB_NAME, DB_USER, DB_PASS);
DB::$verbose = DEBUG_MODE;

require_once($GLOBALS['document_root'] . 'scripts/route.php');
