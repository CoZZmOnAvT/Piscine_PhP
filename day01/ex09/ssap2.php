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

function get_category($val) {
	if (($val >= 65 && $val <= 90) || ($val >= 97 && $val <= 122)) {
		return (0);
	} else if ($val >= 48 && $val <= 57) {
		return (1);
	} else {
		return (2);
	}
}

function words_cmp($a, $b) {
	for ($i = 0; $a[$i] || $b[$i]; $i++) {
		$a_symb = ord(lcfirst($a[$i]));
		$b_symb = ord(lcfirst($b[$i]));

		$a_cat = get_category($a_symb);
		$b_cat = get_category($b_symb);

		if ($a_cat == $b_cat) {
			if ($tmp = $a_symb - $b_symb) {
				return ($tmp);
			} else {
				continue ;
			}
		} else if ($a_cat < $b_cat) {
			return (-1);
		} else {
			return (1);
		}
	}
	return (0);
}

// Filling array $words
$words = array();
for ($i = 1; $i < $argc; $i++) {
	$words = array_merge($words, array_filter(explode(" ", $argv[$i])));
}

//Sorting array $words with custom function 'words_cmp'
usort($words, "words_cmp");

//Display all elements
foreach ($words as $word) {
	echo $word . "\n";
}
