#!/usr/bin/php
<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   ssap.php                                           :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/16 16:03:50 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/16 16:03:55 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */


$i = 0;
$words = array();
foreach ($argv as $key => $argument) {
	if ($i++ < 1)
		continue ;
	$words = array_merge($words, array_filter(explode(" ", $argument)));
}
sort($words);
foreach ($words as $word) {
	echo $word . "\n";
}
