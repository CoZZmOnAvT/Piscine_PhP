/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   lobby.js                                           :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/28 19:20:38 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/28 20:55:36 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

$(document).ready(function(){
	setInterval(function(){
		$.post('/lobby', {'user' : 'active'}).done(function(data){
			if (data == false) {
				return ;
			}
			let jsone_version = $.parseJSON(data);

			if (jsone_version != null && jsone_version['user_in_game'] === true) {
				document.location.href = '/game';
			}
		});
	}, 1000);

	setInterval(function(){
		$.post('/lobby/players', {'action' : 'showall'}).done(function(data){
			if (data == false) {
				return ;
			}
			let jsone_version = $.parseJSON(data);

			if (jsone_version != null) {
				$('.lobby_sign #count').html(jsone_version['count']);
				$('.all-players').html('');
				if (jsone_version['html']) {
					jsone_version['html'].forEach( function(element) {
						$('.all-players').append($(element));
					});
				}
			}
		});
	}, 1000)
});
