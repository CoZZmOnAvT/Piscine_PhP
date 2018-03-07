/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   game.js                                            :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/25 19:53:54 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/28 22:50:50 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

class Game {

	constructor() {
		this.battlefield = $('#battlefield canvas')[0];
		this.battlefield.context = this.battlefield.getContext('2d');

		if (window.devicePixelRatio) {
			let canvasWidth		= $(this.battlefield).css('width');
			let canvasHeight	= $(this.battlefield).css('height');
			let canvasCssWidth	= canvasWidth;
			let canvasCssHeight	= canvasHeight;

			$(this.battlefield).attr('width', parseInt(canvasWidth) * window.devicePixelRatio);
			$(this.battlefield).attr('height', parseInt(canvasHeight) * window.devicePixelRatio);
			$(this.battlefield).css('width', canvasCssWidth);
			$(this.battlefield).css('height', canvasCssHeight);

			this.battlefield.context.scale(window.devicePixelRatio, window.devicePixelRatio);
		}

		this.width_coef = parseInt($(this.battlefield).css('width')) / 150;
		this.height_coef = parseInt($(this.battlefield).css('height')) / 100;

		this.player1 = new Image(15 * this.width_coef, 5 * this.height_coef);
		this.player2 = new Image(15 * this.width_coef, 5 * this.height_coef);
		this.player1.src = "/resources/player1.png";
		this.player2.src = "/resources/player2.png";
	}

	display(map) {
		this.battlefield.context.clearRect(
			0,
			0,
			this.battlefield.width,
			this.battlefield.height);

		for (let i = 0; i < 150; i++) {
			for (var j = 0; j < 100; j++) {
				if (map[i][j] == 3) {
					this.battlefield.context.fillRect(
						parseInt(i * this.width_coef),
						parseInt(j * this.height_coef),
						parseInt(this.width_coef),
						parseInt(this.height_coef));
				} else if (map[i][j] == 1) {
					this.battlefield.context.drawImage(
						this.player1,
						parseInt(i * this.width_coef),
						parseInt(j * this.height_coef),
						parseInt(this.width_coef * 15),
						parseInt(this.height_coef * 5));
				} else if (map[i][j] == 2) {
					this.battlefield.context.drawImage(
						this.player2,
						parseInt(i * this.width_coef),
						parseInt(j * this.height_coef),
						parseInt(this.width_coef * 15),
						parseInt(this.height_coef * 5));
				}
			}
		}
	}

	getData() {
		let	object = this;

		$.post("/game")
			.done(function(data){
				if (data == false) {
					document.location.href = '/';
				}

				object.display($.parseJSON(data));
			});
	}
}

let	game = new Game();

$(document).ready(function(){
	setInterval(function(){
		game.getData();
	}, 100);

	$("#controlls button").click(function(){
		event.preventDefault();

		let	action = $(this).val();
		let	data;

		switch (action){
			case 'w':
				data = {action: 'move:w'};
				break;
			case 'a':
				data = {action: 'move:a'};
				break;
			case 's':
				data = {action: 'move:s'};
				break;
			case 'd':
				data = {action: 'move:d'};
				break;
			case 'shoot':
				data = {action: 'shoot'};
				break;
		}

		$.post("/game/action", data)
			.done(function(data){
				if (data != false) {
					alert(data);
					document.location.href = '/';
					return ;
				}
				game.getData();
			});
	});
});
