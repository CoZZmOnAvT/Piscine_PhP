<?php


trait	Errors
{
	static function	displayError() {
		if (isset($_SESSION['error'])) {
			$error = $_SESSION['error'];
			unset($_SESSION['error']);
			return ($error);
		} else {
			return ('');
		}
	}
}
