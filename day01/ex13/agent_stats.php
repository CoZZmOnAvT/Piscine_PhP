#!/usr/bin/php
<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   agent_stats.php                                    :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/16 22:29:14 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/16 22:29:16 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function is_value(string $val) {
	return ($val !== "");
}

if ($argc < 2)
	return ;

$db = array();
$i = 0;
while (($line = fscanf(STDIN, "%s\n")) !== false)
{
	if ($i++ < 1) {
		continue ;
	}

	$tmp = explode(";", $line[0]);
	$db[$tmp[0]]["mark"][$tmp[2]] = $tmp[1];
	$db[$tmp[2]]["feedback"][$tmp[0]] = $tmp[3];
}

ksort($db);

foreach ($db as &$value) {
	if (isset($value["mark"])) {
		$value["mark"] = array_filter($value["mark"], "is_value");
	}
	if (isset($value["feedback"])) {
		$value["feedback"] = array_filter($value["feedback"], "is_value");
	}
}

$marks_without_muli = $db;
foreach ($marks_without_muli as &$marks) {
	unset($marks["mark"]["moulinette"]);
}

unset($marks_without_muli["moulinette"]);

$muli_marks = array();
foreach ($db as $user => $user_marks) {
	$muli_marks[$user] = $user_marks["mark"]["moulinette"];
}

$raw_marks = array();
foreach ($marks_without_muli as $user_marks) {
	if (is_array($user_marks["mark"])) {
		foreach ($user_marks["mark"] as $mark) {
			$raw_marks[] = $mark;
		}
	}
}

$average_per_user = array();
foreach ($marks_without_muli as $user => $user_marks) {
	$average_per_user[$user] = array_sum($user_marks["mark"]) / count($user_marks["mark"]);
}

switch ($argv[1]) {
	case 'average':
		echo array_sum($raw_marks) / count($raw_marks) . "\n";
		break;
	case 'average_user':
		foreach ($average_per_user as $user => $average) {
			if ($average !== "") {
				echo $user . ":" . $average . "\n";
			}
		}
		break;
	case 'moulinette_variance':
		foreach ($average_per_user as $user => $average) {
			if ($average !== "" || $muli_marks[$user]) {
				echo $user . ":" . ($average - $muli_marks[$user]) . "\n";
			}
		}
		break ;
	default:
		break;
}
