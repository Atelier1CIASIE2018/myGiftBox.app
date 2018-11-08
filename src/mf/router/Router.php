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
    	$path_info = $this->http_req->path_info;
    	if (array_key_exists($path_info, self::$routes) && checkAccessRight(self::$routes[$url][3])) {
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
        $url = '/giftBox/main.php';
        if(array_key_exists($route_name, self::$routes)){
            $url .= $route_name;
        }
        /*foreach (self::$routes as $key) {
            if ($key == $route_name){
                $url .= $key;
            }
        }*/
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