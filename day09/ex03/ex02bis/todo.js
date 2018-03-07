/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   todo.js                                            :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/27 16:19:25 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/27 18:14:59 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function getTODO() {
	let	todolist = $("#ft_list");
	let	elems = document.cookie.split(';');

	if (elems == false) {
		return ;
	}
	elems.forEach(function(elem){
		let content = elem.split('=')[1];

		let newElem = $(`<div class='todo' onclick='removeTODO(this);'>${content}</div>`);
		let entrypoint = $(todolist).find('.todo')[0];
		if (entrypoint !== undefined) {
			$(newElem).insertBefore($(todolist).find('.todo')[0]);
		} else {
			$(todolist).append(newElem);
		}
	});
}

function addTODO() {
	let	todo = prompt("Enter something");

	if (todo != false) {
		document.cookie = `${getRandomInt(0, 9999)}=${todo}`;

		let	todolist = $("#ft_list");
		let newElem = $(`<div class='todo' onclick='removeTODO(this);'>${todo}</div>`);
		let entrypoint = $(todolist).find('.todo')[0];
		if (entrypoint !== undefined) {
			$(newElem).insertBefore($(todolist).find('.todo')[0]);
		} else {
			$(todolist).append(newElem);
		}
	}
}

function removeTODO(todo) {
	let	todolist = $("#ft_list");

	$(todo).remove();

	let	elems = $(todolist).find('.todo');

	clearListCookies();

	$($(elems).get().reverse()).each(function(i, elem){
		document.cookie = `${getRandomInt(0, 9999)}=${$(elem).html()}`;
	});
}

function clearListCookies()
{
	let cookies = document.cookie.split(";");
	for (let i = 0; i < cookies.length; i++)
	{
		let spcook =  cookies[i].split("=");
		deleteCookie(spcook[0]);
	}
	function deleteCookie(cookiename)
	{
		let d = new Date();
		d.setDate(d.getDate() - 1);
		let expires = ";expires=" + d;
		let name = cookiename;
		let value = "";
		document.cookie = name + "=" + value + expires;
	}
}

function getRandomInt(min, max) {
  return Math.floor(Math.random() * (max - min)) + min;
}

$(document).ready(getTODO);
