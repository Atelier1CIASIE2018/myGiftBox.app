<?php
namespace mf\auth;
require_once "AbstractAuthentification.php";
class authentification extends AbstractAuthentification{


	function __construct($user_login){

    if(isset($_SESSION['user_login'])){
        $this->user_login = $user_login;
        $this->access_level = $_SESSION['level'];
        $this->logged_in = true;
    }
    else{
        $this->user_login = null;
        $this->access_level = -9999;
        $this->logged_in = false;
    }


	function updateSession($username, $level)
	{
		$this->user_login = $username;
		$this->access_level = $access_level;
		$this->logged_in = true;
		$_SESSION['user_login'] = $username;
     	$_SESSION['access_level'] = $level;
	}

	function logout()
    {
        $_SESSION['user_login'] = null;
        $_SESSION['access_level'] = -9999;
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

	public function login($username, $db_pass, $pass, $level)
    {
        if(password_verify($pass, $db_pass))
        {
            $this->updateSession($username, $level);
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
?>