<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   whoami.php                                         :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/20 18:00:15 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/20 18:08:15 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

session_start();

if ($_SESSION[loggued_on_user] !== "") {
	echo $_SESSION[loggued_on_user] . "\n";
} else {
	echo "ERROR\n";
}
