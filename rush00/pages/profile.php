<?php
/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   profile.php                                        :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: pgritsen <pgritsen@student.42.fr>          +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2018/01/21 16:19:27 by pgritsen          #+#    #+#             */
/*   Updated: 2018/01/21 21:31:49 by pgritsen         ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

if (empty($_SESSION['user_logged'])) {
	header("Location: /signin");
	exit ;
}

$mysqli_ctx = mysqli_init();
if (mysqli_real_connect($mysqli_ctx, DB_HOST, DB_LOGIN, DB_PASSWD, DB_NAME, DB_PORT) === false) {
	header("Location: /");
	exit ;
}

$query = mysqli_query($mysqli_ctx, "SELECT `info` FROM `users` WHERE `id` = " . $_SESSION['user_logged']['id']);
$query = mysqli_fetch_array($query);
$user_info = json_decode($query['info'], true);

$user_isadmin = user_isadmin($_SESSION['user_logged']);

?>

<div class="profile-info">
	<div id="tabs">
		<div class="tab active" onclick="openCity('profile', this)"><span class="icon">&#9432;</span> Profile</div>
		<div class="tab" onclick="openCity('history', this)"><span class="icon">&Equilibrium;</span> History</div>
<?php

if ($user_isadmin === true) {
	echo '
		<div class="tab" onclick="openCity(\'add-product\', this)"><span class="icon">&#10753;</span> Add Product</div>';
}

?>
	</div>

	<div id="content">
		<div class="tab-container profile">
			<form method="POST" action="/edit">
				<p class="row">
					<label for="name"><span class="icon">&#9787;</span> Name:</label>
					<input id="name" type="text" placeholder="Enter your name" name="name" value="<?php echo $user_info['name']; ?>" />
				</p>
				<p class="row">
					<label for="phone"><span class="icon">&#9990;</span> Phone:</label>
					<input id="phone" type="text" placeholder="Enter your phone number" name="phone" value="<?php echo $user_info['phone']; ?>" />
				</p>
				<p class="row">
					<label for="address"><span class="icon">&#9993;</span> Address:</label>
					<input id="address" type="text" placeholder="Enter your address" name="address" value="<?php echo $user_info['address']; ?>" />
				</p>
				<p class="row">
					<input type="submit" name="submit" value="Save changes" />
				</p>
			</form>
		</div>
		<div class="tab-container history" style="display:none">
			<ul id="orders-table">
<?php
if ($user_isadmin === true) {
	echo '
				<li class="header">
					<div class="td">Order number</div>
					<div class="td">Status</div>
					<div class="td">Order date</div>
					<div class="td">User id</div>
					<div class="td">User name</div>
					<div class="td">User email</div>
					<div class="td">Sum</div>
					<div class="td">Action</div>
				</li>';

	$query = mysqli_query($mysqli_ctx, "SELECT * FROM `orders`");
	while ($order = mysqli_fetch_array($query))
	{
		$order_info	= json_decode($order['order_info'], true);
		$user_info	= json_decode($order['user_info'], true);
		$date		= date("H:i d.m.Y", strtotime($order['date']));		
		echo '
				<li class="table-row">
					<div class="td">'	. $order['id'] .						'</div>
					<div class="td">'	. $order['status'] .					'</div>
					<div class="td">'	. $date .								'</div>
					<div class="td">'	. $order['user_id'] .					'</div>
					<div class="td">'	. $user_info['name'] .					'</div>
					<div class="td">'	. $user_info['email'] .					'</div>
					<div class="td">'	. number_format($order_info['price']) .	'$</div>
					<div class="td actions">
						<form class="order_controlls" method="POST" action="/order/status">
							<button type="submit" value="' . $order['id'] . '" name="done">
								<img src="/resources/done.png" alt="done" />
							</button>
							<button type="submit" value="' . $order['id'] . '" name="cancel">
								<img src="/resources/cancel.png" alt="cancel" />
							</button>
						</form>
					</div>
				</li>';
	}	
} else {
	echo '
				<li class="header">
					<div class="td">Order number</div>
					<div class="td">Sum</div>
					<div class="td">Order date</div>
					<div class="td">Status</div>
				</li>';

	$query = mysqli_query($mysqli_ctx, "SELECT * FROM `orders` WHERE `user_id` = " . $_SESSION['user_logged']['id']);
	while ($order = mysqli_fetch_array($query))
	{
		$order_price = json_decode($order['order_info'], true);
		$order_price = $order_price['price'];
		$date = date("H:i d.m.Y", strtotime($order['date']));
		echo '
				<li class="table-row">
					<div class="td">'	. $order['id'] .					'</div>
					<div class="td">'	. number_format($order_price) .		'$</div>
					<div class="td">'	. $date .							'</div>
					<div class="td">'	. $order['status'] .				'</div>
				</li>';
	}
}
?>
			</ul>
		</div>
<?php
if ($user_isadmin === true) {
	echo '
		<div class="tab-container add-product" style="display:none">
			<form method="POST" action="/product/add" enctype="multipart/form-data">
				<p class="row">
					<label for="title">Title:</label>
					<input id="title" type="text" placeholder="Enter title" name="title" value="' . @$_SESSION['add_product_data']['title'] . '" />
				</p>
				<p class="row">
					<label for="category">Category:</label>
					<input id="category" type="text" placeholder="Enter category" name="category" value="' . @$_SESSION['add_product_data']['category'] . '" />
				</p>
				<p class="row">
					<label for="img">Choose image:</label>
					<input id="img" type="file" name="img" />
				</p>
				<p class="row">
					<label for="description">Description:</label>
					<textarea id="description" rows=10 name="description" placeholder="Enter Description">' . @$_SESSION['add_product_data']['description'] . '</textarea>
				</p>
				<p class="row">
					<label for="price">Price:</label>
					<input id="price" type="number" placeholder="Enter price" name="price" value="' . @$_SESSION['add_product_data']['price'] . '" />
				</p>
				<p class="row">
					<input type="submit" name="add-product" value="Add product" />
				</p>
			</form>
		</div>';
	unset($_SESSION['add_product_data']);
}
?>
	</div>
	
	<script>
		function openCity(tabName, button) {
			var block = document.getElementsByClassName("profile-info")[0];
			var tab_containers = block.getElementsByClassName("tab-container");
			var tabs = block.getElementsByClassName("tab");

			for (var i = 0; i < tab_containers.length; i++) {
				tab_containers[i].style.display = "none";  
			}
			for (var i = 0; i < tabs.length; i++) {
				tabs[i].setAttribute("class", "tab");
			}
			block.getElementsByClassName(tabName)[0].style.display = "block";
			button.setAttribute("class", "tab active");
		}
	</script>
</div>

<?php
	mysqli_close($mysqli_ctx);
