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
    
    public function viewPrestation(){
        $id = $_GET['Id'];
        $prestation = \giftbox\model\Prestation::select('*')->where('id', "=", $id)->first();
        $vue = new \giftbox\view\giftBoxView($prestation);
        $vue->render('Prestation');
    }

    public function viewPrestations(){
        $categorie = \giftbox\model\Prestation::all();
        $vue = new \giftbox\view\giftBoxView($categorie);
        $vue->render('Prestations');
    }

    public function viewCategories(){
        
    }

    public function viewLogin(){
        
    }

    public function postLogin(){
        
    }

    public function viewRegister(){
        
    }

    public function postRegister(){
        
    }

    public function viewBoxes(){
        
    }

    public function viewBox(){
        
    }

    public function newBox(){
        
    }

    public function addBox(){
        
    }

    public function removeBox(){
        
    }

    public function updateBox(){
        
    }

    public function confirmBox(){
        
    }

    public function summaryBox(){
        
    }

    public function urlBox(){
        
    }

    public function postBox(){
        
    }

    public function receiverUrl(){
        
    }

    public function viewProfile(){
        
    }

    public function updateProfile(){
        
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
