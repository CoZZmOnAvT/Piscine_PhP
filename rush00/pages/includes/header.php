<header id="main-header">
	<div id="nav-bar-wrapper">
		<ul id="nav-bar">
			<a href="/"><li class="element <?php if ($_SERVER['REQUEST_URI'] == "/") echo "active"; ?>">Home</li></a>
			<a href="/profile"><li class="element <?php if ($_SERVER['REQUEST_URI'] == "/profile") echo "active"; ?>">Personal area</li></a>
			<li class="delim"></li>
<?php
	if (empty($_SESSION['user_logged'])) {
		echo '
			<li class="auth">
				<a href="/signin">Sign In</a>
				<a href="/signup">Sign Up</a>
			</li>';
	} else {
		echo '
			<li class="auth">
				<p id="user-name">Logged as:
					<a href="/profile">' . $_SESSION['user_logged']['login'] . '</a>
					<a href="/logout" class="logout">Log out</a>
				</p>
			</li>';
	}
?>
		</ul>
	</div>
	<div id="user-bar-wrapper">
		<div id="user-bar">
			<form id="search" method="GET" action="/search">
				<input type="text" name="name" placeholder="Search..." />
				<input type="submit" value="Search" />
			</form>
			<div id="basket">
				<p><b>Basket:</b> <i>124$</i></p>
				<a href="/basket"><img src="/resources/basket.png" /></a>
			</div>
		</div>
	</div>
	<div id="categories-wrapper">
		<ul id="categories">
			<a href="/category/dining"><li class="element <?php if ($_SERVER['REQUEST_URI'] == "/category/dining") echo "active"; ?>">Dining</li></a>
			<a href="/category/decorative"><li class="element <?php if ($_SERVER['REQUEST_URI'] == "/category/decorative") echo "active"; ?>">Decorative</li></a>
			<a href="/category/git"><li class="element <?php if ($_SERVER['REQUEST_URI'] == "/category/git") echo "active"; ?>">Git</li></a>
		</ul>
	</div>
<?php
if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
	echo '
	<div class="error">
		<p>' . $_SESSION['error'] . '</p>
	</div>
	<script type="text/javascript">
		var error = document.querySelectorAll("#main-header > .error")[0];
		setTimeout(function(){
			error.style.left = 0;
			setTimeout(function(){
				error.style.left = "-100%";
				setTimeout(function(){
					error.style.display = "none";
				}, 1000);
			}, 5000);
		}, 100);
	</script>';
	unset($_SESSION['error']);
}
?>
</header>