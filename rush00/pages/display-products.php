<div class="goods-wrapper">
<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   goods.php                                          :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/21 21:50:20 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/21 22:09:30 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

$mysqli_ctx = mysqli_init();
if (mysqli_real_connect($mysqli_ctx, DB_HOST, DB_LOGIN, DB_PASSWD, DB_NAME, DB_PORT) === false) {
	$_SESSION['error'] = "Error, please, try again later";
	header("Location: " . $_SERVER['HTTP_REFERER']);
	exit ;
}

$user_isadmin = user_isadmin($_SESSION['user_logged']);

$query = mysqli_query($mysqli_ctx, "SELECT * FROM `products` WHERE `category` = '" . $category . "';");
$isproduct = false;
while ($product = mysqli_fetch_array($query)) {
	$isproduct = true;
	echo '
	<div class="card">';
	if ($user_isadmin === true) {
		echo '
			<form method="POST" action="/product/remove" id="remove-btn">
				<button type="submit" value="' . $product['id'] . '" name="remove-product">
					<img src="/resources/cancel.png" alt="cancel" />
				</button>
			</form>';
	}
	echo '	<div class="container">
			<img class="card-image" src="' . $product['img'] . '">
			<div class="overlay"></div>
			<a href="/product/' . $product['id'] . '">
				<button class="img-button button"> Details </button>
			</a>
		</div>
		<p class="description">' . $product['title'] . '</p>
		<p class="price"> ' . number_format($product['price']) . '$ </p>
		<button class="card-button button">Buy</button>
	</div>
	';
}
if ($isproduct === false) {
	echo '<h1>Sorry, no forks for this momment...</h1>';
}
?>
</div>
