#!/usr/bin/php
<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   another_world.php                                  :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/17 10:44:48 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/17 10:44:53 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

if ($argc < 2)
	return ;

$sentance = trim(addslashes($argv[1]));

$parts = preg_split("/[ \t]+/", $sentance);

echo(implode(" ", $parts) . "\n");
