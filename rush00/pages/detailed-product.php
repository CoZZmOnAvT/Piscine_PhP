<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   detailed-product.php                               :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/21 22:37:15 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/21 23:20:01 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

$mysqli_ctx = mysqli_init();
if (mysqli_real_connect($mysqli_ctx, DB_HOST, DB_LOGIN, DB_PASSWD, DB_NAME, DB_PORT) === false) {
	$_SESSION['error'] = "Error, please, try again later";
	header("Location: " . $_SERVER['HTTP_REFERER']);
	exit ;
}

$query = mysqli_query($mysqli_ctx, "SELECT * FROM `products` WHERE `id` = " . $product_id);
$product_data = mysqli_fetch_array($query);

if (empty($product_data)) {
	$_SESSION['error'] = "Sorry, couldn't find this fork";
	header("Location: /category/dining");
	exit ;
}

?>

<div id="detailed-block">
	<div class="img-container">
		<img class="top-image" src="<?php echo $product_data['img']; ?>"> 
	</div>
	<div class="info-container">
		<div class="top-right">
			<h1 class="name"><?php echo $product_data['title']; ?></h1>
			<h2 class="description">
				<?php echo $product_data['description']; ?>
			</h2>
			<p class="price">Price: <?php echo number_format($product_data['price']); ?>$</p>
		</div>
		<div class="bottom">
			<button class="button">Add to cart</button>
		</div>
	</div>	
</div>

