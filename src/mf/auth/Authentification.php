<?php
namespace mf\auth;
require_once "AbstractAuthentification.php";
class authentification extends AbstractAuthentification{

	function __construct(){

	    if(isset($_SESSION['user_login'])){
	        $this->user_login = $_SESSION['user_login']->login;
	        $this->access_level = $_SESSION['user_login']->Level;	
	        $this->logged_in = true;
	    }
	    else{
	        $this->user_login = null;
	        $this->access_level = -9999;
	        $this->logged_in = false;
	    }
	}

	function updateSession($username, $level, $id)
	{
		$this->user_login = $username;
		$this->access_level = $level;
		$this->logged_in = true;
		$user = new \giftBox\model\User();
		$user->Login = $username;
     	$user->Level = $level;
     	$user->Id = $id;
     	$_SESSION["user_login"] = $user;
	}

	function logout()
    {
        $_SESSION['user_login']->login = null;
        $_SESSION['user_login']->Level = -9999;
        $this->user_login = null;
        $this->access_level = -9999;
        $this->logged_in = false;
    }

	function checkAccessRight($requested)
    {
        if ($requested > $this->access_level) 
        {
            return false;
        }
        else
        {
            return true;
        }
    }

	function login($username, $db_pass, $pass, $level, $id)
    {
        if(password_verify($pass, $db_pass))
        {
            $this->updateSession($username, $level, $id);
        }
        else
        {
            // exception
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
