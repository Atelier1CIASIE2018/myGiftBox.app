<?php

namespace mf\router;
require_once'AbstractRouter.php';

class Router Extends AbstractRouter{


	public function __construct(){
		parent::__construct();
	}

	public function addRoute($name, $url, $ctrl, $mth){
		self::$routes[$url]=[$ctrl, $mth];
		self::$aliases[$name]=$url;

	}

    public function setDefaultRoute($url){
    	self::$aliases['default']=$url;
    }

    public function run(){
    	$path_info = $this->http_req->path_info;
    	if (array_key_exists($path_info, self::$routes)) {
    		$route = self::$routes[$path_info];
    	}
    	else{
    		$url = self::$aliases['default'];
    		$route = self::$routes[$url];
    	}
    	$ctrl = new $route[0];
    	$method = $route[1];
    	return $ctrl->$method();
    }

    public function urlFor($route_name, $param_list=[]){
        $url = '/tweeter/main.php';
        foreach (self::$routes as $key => $value) {
            if ($key == $route_name){
                $url = $url . $key;
            }
        }
        if ($param_list != null) {
            $url = $url . "?";
            foreach ($param_list as $key => $value) {
                $url = $url . $key . "=" . $value . "&";
            }
        }
        $url = substr($url, 0, -1);
        //echo $url;
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