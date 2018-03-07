<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   route.php                                          :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/27 20:33:16 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/28 22:07:40 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

// All requests related with authentication
Auth::route();

// All 'GET' requests
if (Game::playerStatus('in_game') === true) {
	$default_page = 'pages/game.html';
} else {
	$default_page = 'pages/lobby.php';	
}

Request::get('/', $default_page, ['auth' => true]);

Request::get('/game/close', function(){ Game::closeGame(); }, ['auth' => true]);

// All 'POST' requests
Request::post('/game', function(){ echo Game::dumpMap(); }, ['auth' => true]);

Request::post('/game/action', function(){ echo Game::action(); }, ['auth' => true]);

Request::post('/game/create', function(){ Game::create_session(); }, ['auth' => true]);

Request::post('/lobby', function(){ Game::playerInLobby(); }, ['auth' => true]);

Request::post('/lobby/players', function(){ Game::loadPlayers(); }, ['auth' => true]);

// Server response if page hasn't found
Request::notFound(function(){ Request::redirect('/'); });
