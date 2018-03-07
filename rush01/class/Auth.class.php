<?php

/**
* 
*/
class Auth
{
	use Errors;

	static private	$_sess_key = 'logged_user';

	static function			check() {
		return (self::_islogged());
	}

	static function			getData() {
		if (isset($_SESSION[self::$_sess_key]) && !empty($_SESSION[self::$_sess_key])) {
			return ($_SESSION[self::$_sess_key]);
		} else {
			return (NULL);
		}
	}

	static function			route() {
		self::_islogged();

		Request::get('/logout', function(){self::logout();});

		Request::post('/login', function(){self::login();});
		Request::post('/register', function(){self::register();});

		if (file_exists($GLOBALS['document_root'] . 'pages/login.php')) {
			Request::get('/login', 'pages/login.php');
		} else {
			Request::get('/login', 'pages/login.html');
		}

		if (file_exists($GLOBALS['document_root'] . 'pages/register.php')) {
			Request::get('/register', 'pages/register.php');
		} else {
			Request::get('/register', 'pages/register.html');
		}
	}

	static function			login() {
		if (self::_islogged() === true) {
			self::logout();
		}

		$username = trim($_POST['login']);
		$passwd = $_POST['passwd'];

		if (self::validateLogin($username) === false
			|| self::validatePasswd($passwd) === false) {
			self::_abort('Password or login incorrect');
		}

		$passwd_hash = password_hash($passwd, PASSWORD_BCRYPT);

		$query = DB::query('SELECT `user_id`, `login`, `passwd` FROM `users` WHERE `login` = :login LIMIT 1',
							array('login' => $username));
		$data = DB::fetch_array($query);

		if ($data === false || empty($data)) {
			self::_abort('Password or login incorrect');
		} else {
			if (password_verify($passwd, $data['passwd']) === true) {
				self::_write_user($username, intval($data['user_id']));
			} else {
				self::_abort('Password or login incorrect');
			}
		}

		Request::redirect('/');
	}

	static function			register() {		
		if (self::_islogged() === true) {
			self::logout();
		}
		
		$username = trim($_POST['login']);
		$passwd_1 = $_POST['passwd_1'];
		$passwd_2 = $_POST['passwd_2'];

		$_SESSION['reg_data']['username'] = $username;

		if (self::validateLogin($username) === false) {
			self::_abort('Username must contain only Engilsh letters or/and numbers');
		} else if ($passwd_1 !== $passwd_2) {
			self::_abort('Passwords doesn\'t match');
		} else if (self::validatePasswd($passwd_1) === false) {
			self::_abort('Password must contain only ASCII characters <br />
							Lenght should be between 6 and 256 characters');
		}

		$query = DB::query('SELECT `user_id` FROM `users` WHERE `login` = :login',
							array('login' => $username));
		$data = DB::fetch_array($query);
		if ($data !== false || !empty($data)) {
			unset($_SESSION['reg_data']);
			self::_abort('Username is busy');
		}

		$passwd_hash = password_hash($passwd_1, PASSWORD_BCRYPT);

		DB::query('	INSERT INTO `users`(login, passwd)
					VALUES(:login, :passwd)',
					array('login' => $username, 'passwd' => $passwd_hash));

		self::_write_user($username, self::_get_user_id($username));
		unset($_SESSION['reg_data']);
		Request::redirect('/');
	}

	static function			logout() {
		if (isset($_SESSION[self::$_sess_key]) && !empty($_SESSION[self::$_sess_key])) {
			DB::query('DELETE FROM `logged_users` WHERE `user_id` = :user_id',
						array('user_id' => $_SESSION[self::$_sess_key]['user_id']));
			unset($_SESSION[self::$_sess_key]);
			Request::redirect('/');
		}
	}

	static private function	validateLogin(string $username) {
		preg_match('/[^a-zA-Z0-9]+/i', $username, $matches);
		if (!empty($matches)) {
			return (false);
		} else {
			return (true);
		}
	}

	static private function	validatePasswd(string $passwd) {
		$passwd_len = mb_strlen($passwd);
		if ($passwd_len < 6 || $passwd_len > 256 || preg_match('/[^\x20-\x7f]/', $passwd)) {
			return (false);
		} else {
			return (true);
		}
	}

	static private function	_write_user(string $username, int $user_id) {
		$_SESSION[self::$_sess_key]['username']	= $username;
		$_SESSION[self::$_sess_key]['user_id']		= $user_id;

		DB::query('	INSERT INTO `logged_users`(user_id, ip)
					VALUES(:user_id, :ip)
					ON DUPLICATE KEY
					UPDATE
						`log_time` = CURRENT_TIMESTAMP,
						`ip` = VALUES(ip);',
					array('user_id' => $user_id, 'ip' => Request::getIp()));
	}

	static private function	_islogged() {
		if (!isset($_SESSION[self::$_sess_key]) || empty($_SESSION[self::$_sess_key])) {
			return (false);
		} else {
			$query = DB::query('SELECT `ip` FROM `logged_users` WHERE `user_id` = :user_id',
								array('user_id' => $_SESSION[self::$_sess_key]['user_id']));
			$data = DB::fetch_array($query);
			if ($data === false || empty($data)) {
				unset($_SESSION[self::$_sess_key]);
				return (false);
			} else {
				if ($data['ip'] !== Request::getIp()) {
					unset($_SESSION[self::$_sess_key]);
					return (false);
				}
			}
		}
		return (true);
	}

	static function			_get_user_id(string $username) {
		$query = DB::query('SELECT `user_id` FROM `users` WHERE `login` = :login',
							array('login' => $username));
		$data = DB::fetch_array($query);
		if ($data !== false && !empty($data)) {
			return $data['user_id'];
		} else {
			return (false);
		}
	}


	static private function	_abort(string $msg = '') {
		$_SESSION['error'] = $msg;
		Request::back();
	}
}