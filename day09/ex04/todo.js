/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   todo.js                                            :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/27 18:16:18 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/27 18:55:52 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function getTODO() {
	let	todolist = $("#ft_list");
	
	$.post('/ex04/select.php', {'action' : 'getData'}).done(function(raw_data){
		let	data = $.parseJSON(raw_data);

		if (data == false || data[0] == null) {
			return ;
		}
		data.forEach(function(content){
			let newElem = $(`<div class='todo' onclick='removeTODO(this);' data-id='${content[0]}'>${content[1]}</div>`);
			let entrypoint = $(todolist).find('.todo')[0];
			if (entrypoint !== undefined) {
				$(newElem).insertBefore($(todolist).find('.todo')[0]);
			} else {
				$(todolist).append(newElem);
			}
		});
	});
}

function addTODO() {
	let	todo = prompt("Enter something");

	if (todo != false) {

		$.post('/ex04/insert.php', {'action' : 'insertData', 'data' : todo});

		let	todolist = $("#ft_list");		
		let entrypoint = $(todolist).find('.todo')[0];
		let newElem = $(`<div class='todo' onclick='removeTODO(this);' data-id='${parseInt($(entrypoint).attr('data-id')) + 1}'>${todo}</div>`);
		if (entrypoint !== undefined) {
			$(newElem).insertBefore($(todolist).find('.todo')[0]);
		} else {
			$(todolist).append(newElem);
		}
	}
}

function removeTODO(todo) {
	let	id = $(todo).attr('data-id');
	$.post('/ex04/delete.php', {'action' : 'deleteData', 'id' : id});
	$(todo).remove();
}

$(document).ready(getTODO);

