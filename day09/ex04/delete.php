<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   delete.php                                         :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/27 18:16:38 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/27 18:48:59 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

if($_POST['action'] === 'deleteData' && $_POST['id']) {
	$db = explode("\n", trim(file_get_contents('list.csv')));

	$id = intval($_POST['id']);
	
	foreach ($db as $key => $row) {
		if (intval(explode(';', $row)[0]) === $id) {
			unset($db[$key]);
		}
	}

	file_put_contents('list.csv', implode("\n", $db));
} else {
	include ('index.html');
}
