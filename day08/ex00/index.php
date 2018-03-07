<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   index.php                                          :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/25 18:48:07 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/26 19:28:32 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

require_once('bootstrap.php');

Request::get('/', 'pages/game.html');
Request::post('/ajax', 'scripts/game.php');
Request::notFound('pages/game.html');

DB::close_connection();
