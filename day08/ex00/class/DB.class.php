<?php

/**
* 
*/
class DB
{
	private	static	$_db_link = NULL;
	private	static	$_db_host = NULL;
	private	static	$_db_name = NULL;
	private	static	$_db_user = NULL;
	private	static	$_db_pass = NULL;
	public	static	$verbose = true;

	static function	set_data($db_host = 'localhost', $db_name = '', $db_user = 'root', $db_pass = '') {		
		self::$_db_host = $db_host;
		self::$_db_name = $db_name;
		self::$_db_user = $db_user;
		self::$_db_pass = $db_pass;
	}

	static function	query($sql, $params = NULL, $db_host = NULL, $db_name = NULL,
							$db_user = NULL, $db_pass = NULL) {
		try {			

			if (self::$_db_link === NULL) {
				$host = ($db_host == NULL ? self::$_db_host : $db_host);
				$name = ($db_name == NULL ? self::$_db_name : $db_name);
				$user = ($db_user == NULL ? self::$_db_user : $db_user);
				$pass = ($db_pass == NULL ? self::$_db_pass : $db_pass);

				self::$_db_link = new PDO('mysql:host=' . $host . ';dbname=' . $name, $user, $pass);
			}

			$query = self::$_db_link->prepare($sql);
			$query->execute($params);
			return ($query);

		} catch (Exception $e) {
			if (self::$verbose === true) {
				echo $e;
			}
			return (NULL);
		}		
	}

	static function	fetch_array(PDOStatement $query) {
		try {
			return ($query->fetch(PDO::FETCH_ASSOC));
		} catch (Exception $e) {
			if (self::$verbose === true) {
				echo $e;
			}
		}
	}

	static function close_connection() {
		self::$_db_link = NULL;
	}
}