#!/usr/bin/php
<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   oddeven.php                                        :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/16 14:31:46 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/16 14:34:15 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */



while (true)
{
	echo ("Enter a number: ");

	$string = fgets(STDIN);
	$num = trim($string);

	if (is_numeric($num)) {
		echo("The number " . $num);
		if ($num % 2 === 0)
			echo(" is even\n");
		else
			echo(" is odd\n");
	} else if ($string) {
		echo("'" . $num . "' is not a number\n");
	} else {
		echo("\n");
		break ;
	}
}
