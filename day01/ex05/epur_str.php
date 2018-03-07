#!/usr/bin/php
<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   epur_str.php                                       :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/16 15:50:41 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/16 15:50:44 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

if ($argc != 2)
	return ;

$words = array_filter(explode(" ", $argv[1]));
$words_count = count($words);
$i = 0;
foreach ($words as $key => $word) {
	echo $word;
	if ($i++ < $words_count - 1)
		echo " ";
}
echo "\n";
