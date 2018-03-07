/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   todo.js                                            :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/27 16:19:25 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/27 18:15:18 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function getTODO() {
	let	todolist = document.getElementById("ft_list");
	let	elems = document.cookie.split(';');

	if (elems == false) {
		return ;
	}
	elems.forEach(function(elem){
		let content = elem.split('=')[1];

		let newElem = document.createElement('div');
		newElem.className = 'todo'
		newElem.innerHTML = content;
		newElem.setAttribute('onclick', 'removeTODO(this);');

		todolist.appendChild(newElem);
	});
}

function addTODO() {
	let	todo = prompt("Enter something");

	if (todo != false) {
		document.cookie = `${getRandomInt(0, 9999)}=${todo}`;

		let	todolist = document.getElementById("ft_list");
		let	elems = todolist.querySelectorAll('.todo');

		let newElem = document.createElement('div');
		newElem.className = 'todo'
		newElem.innerHTML = todo;
		newElem.setAttribute('onclick', 'removeTODO(this);');

		todolist.insertBefore(newElem, elems[0]);
	}
}

function removeTODO(todo) {
	let	todolist = document.getElementById("ft_list");

	todolist.removeChild(todo);

	let	elems = todolist.querySelectorAll('.todo');

	clearListCookies();

	elems.forEach(function(elem, i){
		document.cookie = `${getRandomInt(0, 9999)}=${elem.innerHTML}`;
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
