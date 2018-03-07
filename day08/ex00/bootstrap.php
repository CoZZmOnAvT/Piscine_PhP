<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   bootstrap.php                                      :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/26 13:59:06 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/26 14:34:37 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

require_once('conf/db.php');
require_once('conf/main.php');

foreach (glob("class/*.class.php") as $class_file) {
	require_once($class_file);
}

DB::set_data(DB_HOST, DB_NAME, DB_USER, DB_PASS);
DB::$verbose = DEBUG_MODE;
GAME::$verbose = DEBUG_MODE;
