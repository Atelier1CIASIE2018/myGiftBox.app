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

$router->addRoute('home', '/home/', '\giftbox\control\GiftboxController', 'viewHome'); //GET
$router->addRoute('prestations', '/prestations/', '\giftbox\control\GiftboxController', 'viewPrestations'); //GET
$router->addRoute('prestation', '/prestation/', '\giftbox\control\GiftboxController', 'viewPrestation'); //GET
$router->addRoute('categories', '/categories/', '\giftbox\control\GiftboxController', 'viewCategories'); //GET
$router->addRoute('categorie', '/categorie/', '\giftbox\control\GiftboxController', 'viewCategorie'); //GET
$router->addRoute('login', '/login/', '\giftbox\control\GiftboxController', 'viewLogin'); //GET
$router->addRoute('loginPost', '/loginPost/', '\giftbox\control\GiftboxController', 'postLogin'); //POST
$router->addRoute('register', '/register/', '\giftbox\control\GiftboxController', 'viewRegister'); //GET
$router->addRoute('registerPost', '/registerPost/', '\giftbox\control\GiftboxController', 'postRegister'); //POST
$router->addRoute('box', '/box/', '\giftbox\control\GiftboxController', 'viewBox'); //GET
$router->addRoute('newBox', '/box/new/', '\giftbox\control\GiftboxController', 'newBox'); //GET
$router->addRoute('postBox', '/box/post/', '\giftbox\control\GiftboxController', 'postBox'); //POST
$router->addRoute('addBox', '/box/add/', '\giftbox\control\GiftboxController', 'addBox'); //GET
$router->addRoute('removeBox', '/box/remove/', '\giftbox\control\GiftboxController', 'removeBox'); //GET
$router->addRoute('updateBox', '/box/update/', '\giftbox\control\GiftboxController', 'updateBox'); //UPDATE
$router->addRoute('profile', '/profile/', '\giftbox\control\GiftboxController', 'viewProfile'); //GET
$router->addRoute('profileUpdate', '/profile/update/', '\giftbox\control\GiftboxController', ''); //GET

$router->setDefaultRoute('/home/');

echo ($router->run());