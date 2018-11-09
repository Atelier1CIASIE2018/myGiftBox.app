<?php

$router = new \mf\router\Router();

//page d'accueil
$router->addRoute('home', '/home/', '\giftbox\control\giftBoxController', 'viewHome'); //GET

//route par défaut
$router->setDefaultRoute('/home/');

//liste des prestations
$router->addRoute('prestations', '/prestations/', '\giftbox\control\giftBoxController', 'viewPrestations',\giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_NONE); //GET

//détails d'une prestation : /prestation/?id=x
$router->addRoute('prestation', '/prestation/', '\giftbox\control\giftBoxController', 'viewPrestation',\giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_NONE); //GET

//liste des catégorie
$router->addRoute('categories', '/categories/', '\giftbox\control\giftBoxController', 'viewCategories',\giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_NONE); //GET

//liste des prestations d'une catégorie : /categorie/?id=x
$router->addRoute('categorie', '/categorie/', '\giftbox\control\giftBoxController', 'viewCategorie',\giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_NONE); //GET

//page de connexion
$router->addRoute('login', '/login/', '\giftbox\control\giftBoxController', 'viewLogin',\giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_NONE); //GET

//post pour se connecter
$router->addRoute('loginPost', '/loginPost/', '\giftbox\control\giftBoxController', 'postLogin',\giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_NONE); //POST

//page d'inscription
$router->addRoute('register', '/register/', '\giftbox\control\giftBoxController', 'viewRegister',\giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_NONE); //GET
	
//post pour s'inscrire
$router->addRoute('registerPost', '/registerPost/', '\giftbox\control\giftBoxController', 'postRegister',\giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_NONE); //POST

//déconnexion de l'utilisateur
$router->addRoute('logout', '/logout/', '\giftbox\control\giftBoxController', 'logout',\giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_USER);

//liste des boxes du profil
$router->addRoute('boxes', '/boxes/', '\giftbox\control\giftBoxController', 'viewBoxes', \giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_USER); //GET   // TEST AUTHENTIFICATION

//détails d'une box : /box/?id=x avec ou sans &update
$router->addRoute('box', '/box/', '\giftbox\control\giftBoxController', 'viewBox', \giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_USER); //GET

//page d'ajout d'une box
$router->addRoute('newBox', '/box/new/', '\giftbox\control\giftBoxController', 'newBox', \giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_USER); //GET

//post une nouvelle box
$router->addRoute('postBox', '/box/post/', '\giftbox\control\giftBoxController', 'postBox', \giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_USER); //POST

//récupère l'action du formulaire d'une box pour éxecuter la méthode demandée
$router->addRoute('formBox', '/box/form/', '\giftbox\control\giftBoxController', 'formBox', \giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_USER);

//ajoute une prestation à une box : box/add/?id=x
$router->addRoute('addBox', '/box/add/', '\giftbox\control\giftBoxController', 'addPrestationBox', \giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_USER); //UPDATE

//retire une prestation à une box : box/remove/?id=x
$router->addRoute('removeBox', '/box/remove/', '\giftbox\control\giftBoxController', 'removePrestationBox', \giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_USER); //DELETE

//modifie les données d'une box
$router->addRoute('updateBox', '/box/update/', '\giftbox\control\giftBoxController', 'updateBox', \giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_USER); //UPDATE

//modifie l'état d'une box à 2 (validé) : /box/confirm/?id=x
$router->addRoute('confirmBox', '/box/confirm/', '\giftbox\control\giftBoxController', 'confirmBox', \giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_USER); //UPDATE

//page de récapitulatif avant le payement : box/summary/?id=x
$router->addRoute('summaryBox', '/box/summary/', '\giftbox\control\giftBoxController', 'viewBox', \giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_USER); //GET

//page pour payer : /box/pay/?id=x
$router->addRoute('payBox', '/box/pay/', '\giftbox\control\giftBoxController', 'viewBoxes', \giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_USER); //GET

//modifie l'état d'une box à 3 (payé) : /box/pay/send/?id=x
$router->addRoute('payBox', '/box/pay/send/', '\giftbox\control\giftBoxController', 'viewBox', \giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_USER); //UPDATE

//génère l'url de la box et le stocke dans la BDD et passe l'état à 4 (remis) : /box/url/?id=x
$router->addRoute('urlBox', '/box/url/', '\giftbox\control\giftBoxController', 'urlBox', \giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_USER); //UPDATE

//page de la box pour le destinataire : /box/receiver/?id=x
$router->addRoute('receiverUrl', '/box/receiver/', '\giftbox\control\giftBoxController', 'receiverUrl', \giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_NONE); //UPDATE

//ajoute un message de retour de la part du destinataire : /box/receiver/message/?id=x
$router->addRoute('receiverMessage', '/box/receiver/message/', '\giftbox\control\giftBoxController', 'receiverMessage', \giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_NONE); //UPDATE

//modifie l'état d'une box à 5 (ouvert) : /box/receiver/open/?id=x
$router->addRoute('urlBox', '/box/receiver/open/', '\giftbox\control\giftBoxController', 'urlBox', \giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_NONE); //UPDATE

//page du profil
$router->addRoute('profile', '/profile/', '\giftbox\control\giftBoxController', 'profile', \giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_USER); //GET

//page de modification du profil
$router->addRoute('viewProfile', '/profile/view/', '\giftbox\control\giftBoxController', 'profile', \giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_USER); //GET

//modifie les données du profil
$router->addRoute('profileUpdate', '/profile/update/', '\giftbox\control\giftBoxController', 'updateProfile', \giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_USER); //UPDATE

//page d'administration
$router->addRoute('admin', '/admin/', '\giftbox\control\giftBoxController', 'viewPrestations', \giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_USER); //GET

//page d'ajout d'une prestation
$router->addRoute('newPrestation', '/admin/prestation/new/', '\giftbox\control\giftBoxController', 'newPrestation', \giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_ADMIN); //GET

//ajoute une prestation à la BDD
$router->addRoute('postPrestation', '/admin/prestation/post/', '\giftbox\control\giftBoxController', 'postPrestation', \giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_ADMIN); //UPDATE

//page admin d'une prestation : /admin/prestation/?id=x
$router->addRoute('prestationAdmin', '/admin/prestation/', '\giftbox\control\giftBoxController', 'viewPrestation', \giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_ADMIN); //GET

//modifie les données d'une prestation
$router->addRoute('updatePrestation', '/admin/prestation/update/', '\giftbox\control\giftBoxController', 'updatePrestation', \giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_ADMIN); //UPDATE

//retire une prestation du catalogue : /admin/prestation/remove/
$router->addRoute('removePrestation', '/admin/prestation/remove/', '\giftbox\control\giftBoxController', '',\giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_ADMIN); //DELETE
?>