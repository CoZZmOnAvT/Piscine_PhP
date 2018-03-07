<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   game.php                                           :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/26 14:00:44 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/26 19:57:59 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

if (isset($_POST['action'])) {
	$game = new Game(1);

	switch ($_POST['action']) {
		case 'getMap':
			echo $game->dumpJSON();
			break;
		case 'restart':
			$game->restart();
			break;
		default:
			break;
	}
}
