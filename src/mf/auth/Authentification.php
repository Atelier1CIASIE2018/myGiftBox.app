<?php
require_once "AbstractAuthentification.php";
class authentification extends AbstractAuthentification{
	function __construct($user_login, $access_level, $logged_in){
		if ($_SESSION['user_login']) {
			$this->user_login = $user_login;
			$this->access_level = $_SESSION['access_level'];
			$this->logged_in = true;
		}
		else
		{

		}
	}

	function updateSession($username, $level)
	{
		$this->user_login = $username;
		$this->access_level = $access_level;
		$this->logged_in = true;
	}

	function logout()
	{
		$_SESSION['user_login'] = null;
		$_SESSION['access_right'] = null;
		$this->user_login = null;
		$this->access_level = -9999;
		$this->logged_in = false;
	}

	function checkAccessRight($requested)
	{
		if ($requested > $this->access_level) 
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function login($username, $db_pass, $given_pass, $level)
	{
		$passhach = password_hash ($given_pass,PASSWORD_DEFAULT);
		if ($db_pass != $passhach) 
		{
			return exception;
		}
		else
		{
			update_session($username, $level);
		}
	}

	function hashPassword($password)
	{
		return password_hash($password,PASSWORD_DEFAULT);
	}

	function verifyPassword($password, $hash)
	{
		return password_verify ($password,$hach);
	}
}
?>