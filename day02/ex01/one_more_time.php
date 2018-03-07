#!/usr/bin/php
<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   one_more_time.php                                  :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/17 11:13:25 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/17 11:13:29 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

//Day_of_the_week Number_of_day Month Year Hours:Minutes:Seconds

if ($argc < 2)
	return ;

$input = trim(addslashes($argv[1]));

preg_match("/([A-Z]{0,1}[a-z]{4,8})[ ]([0-9]{1,2})[ ]([A-Z]{0,1}[a-z\p{Ll}]{2,9})
			[ ]([0-9]{4})[ ]([0-9]{2}[:][0-9]{2}[:][0-9]{2})/xu", $input, $date);

if (count($date) != 6 || $input != $date[0]) {
	echo "Wrong Format\n";
	return ;
}

$days = [
	"Monday"	=> "lundi",
	"Tuesday"	=> "mardi",
	"Wednesday"	=> "mercredi",
	"Thursday"	=> "jeudi",
	"Friday"	=> "vendredi",
	"Saturday"	=> "samedi",
	"Sunday"	=> "dimanche"
];

if (!in_array($date[1] = mb_strtolower($date[1]), $days)) {
	echo "Wrong Format\n";
	return ;
}

$months = [
	"January"	=> "janvier",
	"February"	=> "février",
	"March"		=> "mars",
	"April"		=> "avril",
	"May"		=> "mai",
	"June"		=> "juin",
	"July"		=> "juillet",
	"August"	=> "août",
	"September"	=> "septembre",
	"October"	=> "octobre",
	"November"	=> "novembre",
	"December"	=> "décembre"
];

if (!in_array($date[3] = mb_strtolower($date[3]), $months)) {
	echo "Wrong Format\n";
	return ;
}

if ($date[2] > 12 || $date[2] <= 0 || $date[4] < 1970) {
	echo "Wrong Format\n";
	return ;
}

$detailed_data = explode(":", $date[5]);

if ($detailed_data[0] > 23 || $detailed_data[1] > 59 || $detailed_data[2] > 59) {
	echo "Wrong Format\n";
	return ;
}

$date_array = array(array_search($date[1], $days), $date[2],
				array_search($date[3], $months), $date[4], $date[5]);

$date_string = implode(" ", $date_array);

$date_class = new DateTime($date_string, new DateTimeZone("GMT+1"));
$time = $date_class->format('U');

echo $time . "\n";
