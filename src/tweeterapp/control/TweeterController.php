<?php

namespace tweeterapp\control;

/* Classe TweeterController :
 *  
 * Réalise les algorithmes des fonctionnalités suivantes: 
 *
 *  - afficher la liste des Tweets 
 *  - afficher un Tweet
 *  - afficher les tweet d'un utilisateur 
 *  - afficher la le formulaire pour poster un Tweet
 *  - afficher la liste des utilisateurs suivis 
 *  - évaluer un Tweet
 *  - suivre un utilisateur
 *   
 */

class TweeterController extends \mf\control\AbstractController {


    /* Constructeur :
     * 
     * Appelle le constructeur parent
     *
     * c.f. la classe \mf\control\AbstractController
     * 
     */
    
    public function __construct(){
        parent::__construct();
    }


    /* Méthode viewHome : 
     * 
     * Réalise la fonctionnalité : afficher la liste de Tweet
     * 
     */
    
    public function viewHome(){
        $tweets = \tweeterapp\model\Tweet::all();
        $vue = new \tweeterapp\view\TweeterView($tweets);
        $vue->render('home');
    }


    /* Méthode viewTweet : 
     *  
     * Réalise la fonctionnalité afficher un Tweet
     *
     */
    
    public function viewTweet(){
        $id = $_GET['id'];
        $tweet = \tweeterapp\model\Tweet::select('id', 'text', 'author', 'created_at', 'score')->where('id', "=", $id)->first();
        $vue = new \tweeterapp\view\TweeterView($tweet);
        $vue->render('tweet');
    }


    /* Méthode viewUserTweets :
     *
     * Réalise la fonctionnalité afficher les tweet d'un utilisateur
     *
     */
    
    public function viewUserTweets(){
        $id = $_GET['id'];
        /*$user = \tweeterapp\model\User::select('username', 'followers')->where('id', "=", $id)->first();
        $vueUser = new \tweeterapp\view\TweeterView($user);
        $vueUser->render('userInfo');*/
        /*echo "Login : ".$user['username']."<br/>";
        echo "Followers : ".$user['followers']."<br/><br/>";*/


        $tweets = \tweeterapp\model\Tweet::select('id', 'text', 'author', 'created_at')->where('author', "=", $id)->get();
        $vue = new \tweeterapp\view\TweeterView($tweets);
        $vue->render('user');
        /**/
    }
}
