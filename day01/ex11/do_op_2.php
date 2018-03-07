#!/usr/bin/php
<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   do_op_2.php                                        :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/16 20:12:07 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/16 20:12:11 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

if ($argc != 2) {
	echo "Incorrect Parameters\n";
	return ;
}

$input = addslashes(trim($argv[1]));

preg_match("/([\-+]?[0-9]+)[ ]*([+\-*\/%])[ ]*([\-+]?[0-9]+)/", $input, $matches);

$expression = $matches[0];

if ($expression !== $input) {
	echo "Syntax Error\n";
	return ;
}

$num1 = $matches[1];
$num2 = $matches[3];
$operator = $matches[2];

switch ($operator) {
	case '+':
		echo ($num1 + $num2) . "\n";
		break;
	case '-':
		echo ($num1 - $num2) . "\n";
		break;
	case '*':
		echo ($num1 * $num2) . "\n";
		break;
	case '/' && $num2:
		echo ($num1 / $num2) . "\n";
		break;
	case '%' && $num2:
		echo ($num1 % $num2) . "\n";
		break;
	default:
		echo "Syntax Error\n";
		break;
}
