/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   game.js                                            :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/16 00:05:52 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/16 00:06:20 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */


var		id;

function hide_message(time) {
	var		msg_popup;

	msg_popup = document.getElementById("anwser-msg");
	setTimeout(function() {
		msg_popup.querySelectorAll("#msg")[0].style.display = "none";
		msg_popup.querySelectorAll("#wrong")[0].style.display = "none";
		msg_popup.querySelectorAll("#correct")[0].style.display = "none";
		msg_popup.querySelectorAll("#towel-img")[0].style.display = "none";
		msg_popup.style.display = "none";
	}, time * 1000);
}

function hide_popup() {
	var popup;

	popup = document.getElementById("popup");
	popup.style.display = "none";
}

function ask_question() {
	var		popup;
	var		questions = [
		"What is author name?",
		"What age of the earth?",
		"What is author favourite color?",
		"How old are you?"
	];

	popup = document.getElementById("popup");
	popup.style.display = "block";

	id = Math.floor((Math.random() * 4));

	popup.querySelectorAll('.msg i')[0].innerHTML = questions[id];
}

function check_anwser() {
	var		popup;
	var		anwser_input;
	var		msg_popup;
	var		decodedCookie;
	var		anwsers = [
		"Pavlo",
		"2018",
		"dark dark black",
		"12"
	];

	popup = document.getElementById("popup");
	anwser_input = popup.querySelectorAll('input[type=\"text\"]')[0];
	msg_popup = document.getElementById("anwser-msg");
	msg_popup.style.display = "block";
	if (anwsers[id] == anwser_input.value)
		msg_popup.querySelectorAll("#correct")[0].style.display = "block";
	else
		msg_popup.querySelectorAll("#wrong")[0].style.display = "block";
	popup.style.display = "none";
	anwser_input.value = "";
	hide_message(1);
}

function bb_watching() {
	var		msg_popup;
	var		msg;

	msg_popup = document.getElementById("anwser-msg");
	msg_popup.style.display = "block";
	msg = msg_popup.querySelectorAll("#msg")[0];
	msg.style.display = "block";
	msg.innerHTML = "Big Brother is watching!";
	hide_message(1);
}

function wall() {
	var		msg_popup;
	var		msg;

	msg_popup = document.getElementById("anwser-msg");
	msg_popup.style.display = "block";
	msg = msg_popup.querySelectorAll("#msg")[0];
	msg.style.display = "block";
	msg.innerHTML = "Winter is Comming!";
	hide_message(1);
}

function towel_surprise() {
	var		msg_popup;
	var		towel;

	msg_popup = document.getElementById("anwser-msg");
	msg_popup.style.display = "block";
	towel = msg_popup.querySelectorAll("#towel-img")[0];
	towel.style.display = "block";
	hide_message(2);
}

function lenny_face()
{
	var lenny;

	lenny = document.getElementById("lenny-face");
	lenny.style.top = "20px";
	setTimeout(function(){
		lenny.style.top = "-130px";
	}, 1000);
}
