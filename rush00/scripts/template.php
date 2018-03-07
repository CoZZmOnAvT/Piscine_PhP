<!DOCTYPE html>
<html>
	<head>
		<title>Serious Fork</title>
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="/resources/main.css">
	</head>
	<body>
<?php
	include("../pages/includes/header.php");
?>
	<div id="site-content">
<?php
	include("../" . $body);
?>
	</div>
<?php
	include("../pages/includes/footer.html");
?>
	</body>
</html>