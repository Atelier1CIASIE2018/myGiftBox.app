<?php 

class ClassLoader{
	public $prefix;
	
	public function __construct($Valprefix)
	{
		$this->prefix = $Valprefix;
	}
	public function loadClass($chain)
	{
		$res = str_replace(array('/', '\\'),DIRECTORY_SEPARATOR,$chain);
		$res = "src/".$res.".php";
		if (file_exists ($res))
		{
			require_once $res;
		}
	}
	public function register ()
	{
		spl_autoload_register(array($this, 'loadClass'));
	}
}
