<?php
$router = new \mf\router\Router();

//page d'accueil
$router->addRoute('home', '/home/', '\giftbox\control\giftBoxController', 'viewHome'); //GET
//liste des prestations
$router->addRoute('prestations', '/prestations/', '\giftbox\control\giftBoxController', 'viewPrestations'); //GET
//détails d'une prestation : /prestation/?id=x
$router->addRoute('prestation', '/prestation/', '\giftbox\control\giftBoxController', 'viewPrestation'); //GET
//liste des catégorie
$router->addRoute('categories', '/categories/', '\giftbox\control\giftBoxController', 'viewCategories'); //GET
//liste des prestations d'une catégorie : /categorie/?id=x
$router->addRoute('categorie', '/categorie/', '\giftbox\control\giftBoxController', 'viewCategorie'); //GET
//page de connexion
$router->addRoute('login', '/login/', '\giftbox\control\giftBoxController', 'viewLogin'); //GET
//post pour se connecter
$router->addRoute('loginPost', '/loginPost/', '\giftbox\control\giftBoxController', 'postLogin'); //POST
//page d'inscription
$router->addRoute('register', '/register/', '\giftbox\control\giftBoxController', 'viewRegister'); //GET
//post pour s'inscrire
$router->addRoute('registerPost', '/registerPost/', '\giftbox\control\giftBoxController', 'postRegister'); //POST
//liste des boxes
$router->addRoute('boxes', '/boxes/', '\giftbox\control\giftBoxController', 'viewBoxes'); //GET
//détails d'une box : /box/?id=x
$router->addRoute('box', '/box/', '\giftbox\control\giftBoxController', 'viewBox'); //GET
//page d'ajout d'une box
$router->addRoute('newBox', '/box/new/', '\giftbox\control\giftBoxController', 'newBox'); //GET
//post une nouvelle box
$router->addRoute('postBox', '/box/post/', '\giftbox\control\giftBoxController', 'postBox'); //POST
//ajoute une prestation à une box : box/add/?id=x&add=x
$router->addRoute('addBox', '/box/add/', '\giftbox\control\giftBoxController', 'addBox'); //UPDATE
//retire une prestation à une box : box/remove/?id=x&rm=x
$router->addRoute('removeBox', '/box/remove/', '\giftbox\control\giftBoxController', 'removeBox'); //GET
//modifie les données d'une box
$router->addRoute('updateBox', '/box/update/', '\giftbox\control\giftBoxController', 'updateBox'); //UPDATE
//modifie l'état d'une box à 2 (validé) : /box/confirm/?id=x
$router->addRoute('confirmBox', '/box/confirm/', '\giftbox\control\giftBoxController', 'confirmBox'); //UPDATE
//modifie l'état d'une box à 3 (payé) : /box/pay/?id=x
$router->addRoute('payBox', '/box/pay/', '\giftbox\control\giftBoxController', 'pay'); //UPDATE
//page du profil 
$router->addRoute('profile', '/profile/', '\giftbox\control\giftBoxController', 'viewProfile'); //
//modifie les données du profil
$router->addRoute('profileUpdate', '/profile/update', '\giftbox\control\giftBoxController', 'updateProfile'); //UPDATE
?>