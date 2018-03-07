<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   ft_is_sort.php                                     :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/16 16:41:56 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/16 16:52:20 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function ft_is_sort($array)
{
	$sorted_array = $array;
	sort($sorted_array);

	foreach ($sorted_array as $key => $value) {
		if ($sorted_array[$key] !== $array[$key]) {
			return (0);
		}
	}
	return (1);
}
