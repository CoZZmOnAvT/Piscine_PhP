<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   select.php                                         :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/27 18:16:25 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/27 18:45:09 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

if($_POST['action'] === 'getData') {
	$db = explode("\n", trim(file_get_contents('list.csv')));

	$ret = array();

	foreach ($db as $row) {
		$ret[] = explode(';', $row);
	}

	echo json_encode($ret);
} else {
	include ('index.html');
}
