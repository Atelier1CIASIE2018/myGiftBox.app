<?php

namespace mf\router;
require_once'AbstractRouter.php';

class Router Extends AbstractRouter{


	public function __construct(){
		parent::__construct();
	}

	public function addRoute($name, $url, $ctrl, $mth, $acces=""){
		self::$routes[$url]=[$ctrl, $mth, $acces];
		self::$aliases[$name]=$url;

	}

    public function setDefaultRoute($url){
    	self::$aliases['default']=$url;
    }

    public function run(){
        $auth = new \mf\auth\Authentification();
    	$path_info = $this->http_req->path_info;
    	if (array_key_exists($path_info, self::$routes) && $auth->checkAccessRight(self::$routes[$path_info][2])) {
    		$route = self::$routes[$path_info];
    	}
    	else{
            if(substr($path_info, 0,9) == "/box/add/"){
                header('Location: '.$this->urlFor('/home/',[]));
            }
            else{

            }
    		$url = self::$aliases['default'];
    		$route = self::$routes[$url];
    	}
    	$ctrl = new $route[0];
    	$method = $route[1];
    	return $ctrl->$method();
    }

    public function urlFor($route_name, $param_list=[]){
        $url = '/giftBox/main.php';
        if(array_key_exists($route_name, self::$routes)){
            $url .= $route_name;
        }
        if ($param_list != null) {
            $url .= "?";
            foreach ($param_list as $key => $value) {
                if(substr($url, strlen($url) - 1, 1) == "?"){
                    $url .= $key."=".$value;
                }
                else{
                    $url .= "&".$key;
                    if($key != "update"){
                        $url .= "=".$value;
                    }
                }
            }
        }
        return $url;
    }

    public static function executeRoute($alias){
    	$url = self::$aliases[$alias];
    	$route = self::$routes[$url];
    	$ctrl = new $route[0];
    	$method = $route[1];
    	return $ctrl->$method();
    }
}