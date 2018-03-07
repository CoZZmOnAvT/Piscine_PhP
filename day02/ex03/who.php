#!/usr/bin/php
<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   who.php                                            :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/18 21:58:04 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/18 21:58:05 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

date_default_timezone_set("Europe/Kiev");
$fd = fopen("/var/run/utmpx", 'r');
for ($i = 0; $raw = fread($fd, 628); $i++)
	$data[$i] = unpack("a256login/a4id/a32tty/ipid/itype/itime", $raw);
sort($data);
foreach($data as $arr) {
	if ($arr["type"] == 7) {
		echo implode(" ", array($arr["login"], $arr["tty"], "",
			date('M j H:i', $arr["time"]))) . "\n";
	}
}
