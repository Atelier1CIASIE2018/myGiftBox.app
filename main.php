<?php
require_once "src/mf/utils/ClassLoader.php";
require_once "src/mf/router/Router.php";
$loader = new ClassLoader('src');
$loader->register();

use \giftbox\model\Box as Box;
use \giftbox\model\Prestation as Prestation;
use \giftbox\model\Categorie as Categorie;
use \giftbox\model\Composer as Composer;
use \giftbox\model\User as User;

use mf\router\Router as Router;

/* pour le chargement automatique des classes dans vendor */
require_once 'vendor/autoload.php';

$config = parse_ini_file("conf/config.ini");

/* une instance de connexion  */
$db = new Illuminate\Database\Capsule\Manager();

$db->addConnection( $config ); /* configuration avec nos paramètres */
$db->setAsGlobal();            /* visible de tout fichier */
$db->bootEloquent();           /* établir la connexion */

$router = new \mf\router\Router();

$router->addRoute('home', '/home/', '\giftbox\control\giftBoxController', 'viewHome'); //GET
$router->addRoute('prestations', '/prestations/', '\giftbox\control\giftBoxController', 'viewPrestations'); //GET
$router->addRoute('prestation', '/prestation/', '\giftbox\control\giftBoxController', 'viewPrestation'); //GET
$router->addRoute('categories', '/categories/', '\giftbox\control\giftBoxController', 'viewCategories'); //GET
$router->addRoute('categorie', '/categorie/', '\giftbox\control\giftBoxController', 'viewCategorie'); //GET
$router->addRoute('login', '/login/', '\giftbox\control\giftBoxController', 'viewLogin'); //GET
$router->addRoute('loginPost', '/loginPost/', '\giftbox\control\giftBoxController', 'postLogin'); //POST
$router->addRoute('register', '/register/', '\giftbox\control\giftBoxController', 'viewRegister'); //GET
$router->addRoute('registerPost', '/registerPost/', '\giftbox\control\giftBoxController', 'postRegister'); //POST
$router->addRoute('box', '/box/', '\giftbox\control\giftBoxController', 'viewBox'); //getallheaders()
$router->addRoute('newBox', '/box/new/', '\giftbox\control\giftBoxController', 'newBox'); //GET
$router->addRoute('postBox', '/box/post/', '\giftbox\control\giftBoxController', 'postBox'); //POST
$router->addRoute('addBox', '/box/add/', '\giftbox\control\giftBoxController', 'addBox'); //GET
$router->addRoute('removeBox', '/box/remove/', '\giftbox\control\giftBoxController', 'removeBox'); //GET
$router->addRoute('updateBox', '/box/update/', '\giftbox\control\giftBoxController', 'updateBox'); //UPDATE
$router->addRoute('profile', '/profile/', '\giftbox\control\giftBoxController', 'viewProfile'); //GET
$router->addRoute('profileGet', '/profile/get/', '\giftbox\control\giftBoxController', 'getProfile'); //GET
$router->addRoute('profileUpdate', '/profile/update', '\giftbox\control\giftBoxController', 'updateProfile'); //UPDATE
$router->addRoute('login', '/login/', '\giftbox\control\giftBoxController', 'viewLogin'); //GET

$router->setDefaultRoute('/home/');

echo ($router->run());