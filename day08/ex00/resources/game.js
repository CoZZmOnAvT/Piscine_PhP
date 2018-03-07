/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   game.js                                            :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/25 19:53:54 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/26 20:06:05 by pgritsen         ###   ########.fr       */
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
						parseInt(j * this.height_coef));
				} else if (map[i][j] == 2) {
					this.battlefield.context.drawImage(
						this.player2,
						parseInt(i * this.width_coef),
						parseInt(j * this.height_coef));
				}
			}
		}
	}

	getData() {
		let	object = this;

		$.post("/ajax", { action: "getMap" })
			.done(function(data){
				object.display($.parseJSON(data));
			});
	}

	restart() {
		$.post("/ajax", { action: "restart" });
		this.getData();
	}

}

var	game = new Game();
