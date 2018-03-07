#!/usr/bin/php
<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   do_op.php                                          :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/16 19:51:46 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/16 19:51:48 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

if ($argc != 4) {
	echo("Incorrect Parameters\n");
	return ;
}

$num1 = intval($argv[1]);
$num2 = intval($argv[3]);

$operation = trim($argv[2]);

switch ($operation) {
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
		break;
}
