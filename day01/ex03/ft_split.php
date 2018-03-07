<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   ft_split.php                                       :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/16 15:21:28 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/16 16:44:02 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

function ft_split($string) {
	$words_array = array_filter(explode(" ", $string));

	sort($words_array);
	return ($words_array);
}
