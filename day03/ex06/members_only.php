<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   members_only.php                                   :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/19 12:23:24 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/19 12:57:12 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

$username = $_SERVER["PHP_AUTH_USER"];
$password = $_SERVER["PHP_AUTH_PW"];

if ($username === "zaz" && $password === "jaimelespetitsponeys") {
	echo  "<html><body>
Hello Zaz<br />
<img src='data:image/png;base64," .
	base64_encode(file_get_contents("../img/42.png")). "</body></html>\n";
} else {
	header('HTTP/1.0 401 Unauthorized');
	echo "<html><body>That area is accessible for members only</body></html>\n";
}
