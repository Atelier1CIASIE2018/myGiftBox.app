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

require_once "src/mf/router/routes.php";

echo ($router->run());

?>