<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   insert.php                                         :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/27 18:16:31 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/27 18:51:55 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

if($_POST['action'] === 'insertData' && $_POST['data']) {
	$db = explode("\n", trim(file_get_contents('list.csv')));

	$data = htmlspecialchars(strip_tags($_POST['data']));
	$it = count($db) - 1;
	$it = explode(';', $db[$it])[0];
	if ($it === false) {
		$it = 0;
	} else {
		$it += 1;
	}
	$db[] = $it . ';' . $data;
	file_put_contents('list.csv', implode("\n", $db));
} else {
	include ('index.html');
}
