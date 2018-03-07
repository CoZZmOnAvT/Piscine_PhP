#!/usr/bin/php
<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   magnifying_glass.php                               :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/17 12:30:34 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/17 12:30:39 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */



function link_uppercase(string &$html) {
	$html = preg_replace_callback('/<a[^>]*>.*?<\/a>/is', function($val) {
			$val[0] = preg_replace_callback('/>[^<]*</is', function ($val) {
				return (mb_strtoupper($val[0]));
			}, $val[0]);
			$val[0] = preg_replace_callback('/title="([^"]*)"/i', function ($val) {
				$val[0] = preg_replace('/' . preg_quote($val[1]) . '/',
										mb_strtoupper($val[1]), $val[0]);
				return ($val[0]);
			}, $val[0]);
			return ($val[0]);
	}, $html);
}

if ($argc < 2) {
	return ;
}

if (!is_file($argv[1])) {
	return ;
}
$handle = fopen($argv[1], "r");
$input = fread($handle, filesize($argv[1]));
fclose($handle);

link_uppercase($input);

echo $input . "\n";
