#!/usr/bin/php
<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   photos.php                                         :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/18 23:17:27 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/18 23:17:57 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

if ($argc < 2) {
	return ;
}

$dom = new DOMDocument;

$argv[1] = trim($argv[1], "/");

@$dom->loadHTMLFile($argv[1]);

$imgs = $dom->getElementsByTagName("img");

$links = array();

foreach ($imgs as $img) {
	if ($img->hasAttribute("src")) {
		if (!preg_match("/http[s]?:\/\//i", $img->getAttribute("src"))) {
			$links[] = $argv[1] . "/" . trim($img->getAttribute("src"), "/");
		} else {
			$links[] = $img->getAttribute("src");
		}
	}
}

@mkdir(basename($argv[1]));

foreach ($links as $link) {
	file_put_contents(basename($argv[1]) . "/" . basename($link), @file_get_contents($link));
}
