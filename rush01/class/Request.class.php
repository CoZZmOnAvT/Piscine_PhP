
<?php

/**
* 
*/
class Request
{
	use Errors;

	private static	$page_found = false;

	static function	request_type() {
		return ($_SERVER['REQUEST_METHOD']);
	}

	static function	parse_uri(string $uri) {
		$uri = trim($uri, "/");

		if ($uri == false) {
			$uri = "/";
		}
		return ($uri);
	}

	static function	uri() {
		return (self::parse_uri($_SERVER['REQUEST_URI']));
	}

	static function	run_action($action, $arguments) {		
		if (is_string($action)) {
			if ($arguments !== NULL && isset($arguments['auth']) && $arguments['auth'] === true) {
				if (Auth::check() === false) {
					Request::redirect('/login');
				}
			}
			include_once($GLOBALS['document_root'] . $action);
		} else if (is_callable($action)) {
			$action($arguments);
		}
	}	

	static function	parse_request($request = 'GET', $uri = '/') {
		if (self::$page_found === false && self::request_type() === $request
				&& self::uri() == self::parse_uri($uri)) {
			self::$page_found = true;
			return (true);
		} else {			
			return (false);
		}
	}

	static function	get(string $uri, $action, $arguments = NULL) {
		if (self::parse_request('GET', $uri) === true) {
			self::run_action($action, $arguments);
		}
	}

	static function	post(string $uri, $action, $arguments = NULL) {
		if (self::parse_request('POST', $uri) === true) {
			self::run_action($action, $arguments);
		}
	}

	static function	notFound($action, $arguments = NULL) {
		if (self::$page_found === false) {
			self::run_action($action, $arguments);
		}
	}

	static function	back() {
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		exit();
	}

	static function	redirect(string $url) {
		header('Location: ' . $url);
		exit();
	}

	static function	getIp() {
		$ipAddress = $_SERVER['REMOTE_ADDR'];

		if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
			$ipAddress = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
		}
		return ($ipAddress);
	}
}
