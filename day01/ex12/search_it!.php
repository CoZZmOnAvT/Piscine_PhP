#!/usr/bin/php
<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   search_it!.php                                     :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/16 22:19:34 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/16 22:19:39 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

$search = addslashes($argv[1]);

$db = array();
for ($i = 2; $i < $argc; $i++) {
	$tmp = explode(":", addslashes($argv[$i]));
	$db[$tmp[0]] = $tmp[1];
}

$result = $db[$search];

if ($result !== NULL)
	echo $result . "\n";
