<?php

namespace giftbox\control;

class giftBoxController extends \mf\control\AbstractController {
    
    public function __construct(){
        parent::__construct();
    }
    
    public function viewHome(){
        $prestations = \giftbox\model\Prestation::take(3)->orderBy('Id', 'desc')->get();
        $vue = new \giftbox\view\giftBoxView($prestations);
        $vue->render('home');
    }
    
    /*public function viewTweet(){
        $id = $_GET['id'];
        $tweet = \tweeterapp\model\Tweet::select('id', 'text', 'author', 'created_at', 'score')->where('id', "=", $id)->first();
        $vue = new \tweeterapp\view\TweeterView($tweet);
        $vue->render('tweet');
    }*/
    
    /*public function viewUserTweets(){
        $id = $_GET['id'];
        $tweets = \tweeterapp\model\Tweet::select('id', 'text', 'author', 'created_at')->where('author', "=", $id)->get();
        $vue = new \tweeterapp\view\TweeterView($tweets);
        $vue->render('user');
    }*/
}
