#!/usr/bin/php
<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   rostring.php                                       :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/16 16:34:51 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/16 16:34:57 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

if ($argc < 2)
	return ;

$words = array_filter(explode(" ", $argv[1]));

$i = 0;
foreach ($words as $key => $word) {
	if ($i++ > 0)
		echo $word . " ";
}

echo $words[0] . "\n";
