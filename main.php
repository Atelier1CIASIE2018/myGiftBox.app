<?php
require_once "src/mf/utils/ClassLoader.php";
require_once "src/mf/router/Router.php";
$loader = new ClassLoader('src');
$loader->register();

use ;

use mf\router\Router as Router;

/* pour le chargement automatique des classes dans vendor */
require_once 'vendor/autoload.php';
$config = parse_ini_file("conf/config.ini");

/* une instance de connexion  */
$db = new Illuminate\Database\Capsule\Manager();

$db->addConnection( $config ); /* configuration avec nos paramètres */
$db->setAsGlobal();            /* visible de tout fichier */
$db->bootEloquent();           /* établir la connexion */

/*$u = new User();
$l = new Like();*/

/*var_dump($u);
var_dump($l);*/


//$ctrl = new tweeterapp\control\TweeterController();
//echo $ctrl->viewHome();




/* configuration d'Eloquent (cf partie 1 du projet ) */

$router = new \mf\router\Router();

$router->addRoute('home', '/home/', '\tweeterapp\control\TweeterController', 'viewHome');

$router->addRoute('tweet', '/tweet/', '\tweeterapp\control\TweeterController', 'viewTweet');
// Recup le tweet 65 -> main.php/tweet/?id=65

$router->addRoute('user', '/user/', '\tweeterapp\control\TweeterController', 'viewUserTweets');
// Recup le profil du user 7 -> main.php/user/?id=7

$router->setDefaultRoute('/home/');

echo ($router->run());

/*$c = Tweet::where('id' ,'=', 49)->first();
$tweet = $c->user()->first();
echo ($tweet);*/

$router->urlfor('/user/', ['id'=>'1', 'id2'=>'2']);
/* Après exécution de cette instruction, l'attribut statique $routes et
   $aliases de la classe Router auront les valeurs suivantes: */

/*var_dump(Router::$routes);
var_dump(Router::$aliases);*/