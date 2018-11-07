<?php

namespace giftbox\control;

class giftBoxController extends \mf\control\AbstractController {
    
    public function __construct(){
        parent::__construct();
    }
    
    public function viewHome(){
        $prestations = \giftbox\model\Prestation::take(3)->orderBy('Id', 'desc')->get();
        $categories = \giftbox\model\Categorie::all();
        $nomCategories = array();
        foreach ($categories as $categorie){
            array_push($nomCategories, $categorie->Nom);
        }
        $vue = new \giftbox\view\giftBoxView(array("prestations" => $prestations, "categories" => $nomCategories));
        $vue->render('Home');
    }
    
    public function viewPrestation(){
        $id = $_GET['Id'];
        $prestation = \giftbox\model\Prestation::where('id', "=", $id)->first();
        $vue = new \giftbox\view\giftBoxView($prestation);
        $vue->render('Prestation');
    }

    public function viewPrestations(){
        $prestations = \giftbox\model\Prestation::all();
        $categories = \giftbox\model\Categorie::all();
        $nomCategories = array();
        foreach ($categories as $categorie){
            array_push($nomCategories, $categorie->Nom);
        }
        $vue = new \giftbox\view\giftBoxView(array("prestations" => $prestations, "categories" => $nomCategories));
        $vue->render('Prestations');
    }

    public function viewCategories(){
        $categorie = \giftbox\model\Categorie::all();
        $vue = new \giftbox\view\giftBoxView($categorie);
        $vue->render('Categories');
    }
    public function viewCategorie(){
        $id = $_GET['Id'];
        $prestations = \giftbox\model\Prestation::where('IdCategorie', "=", $id)->get();
        $vue = new \giftbox\view\giftBoxView($prestations);
        $vue->render('Categorie');
    }

    public function viewLogin(){
        $vue = new \giftbox\view\giftBoxView('');
        $vue->render('Login');
    }

    public function postLogin(){
        $data = json_decode(file_get_contents('php://input'));
    }

    public function viewRegister(){
        $vue = new \giftbox\view\giftBoxView('');
        $vue->render('Register');
    }

    public function postRegister(){
        $data = json_decode(file_get_contents('php://input'));
    }

    public function viewBoxes(){
        $id = $_GET['Id'];
        $boxes = \giftbox\model\Box::select('*')->where('IdUser', "=", $id)->get();
        $vue = new \giftbox\view\giftBoxView($boxes);
        $vue->render('Boxes');
    }

    public function viewBox(){
        $id = $_GET["Id"];
        $box = \giftbox\model\Box::where('Id', "=", $id)->first();
        $composer = \giftbox\model\Composer::where("IdBox", "=", $box->Id)->get();
        $idPrestations = array();
        foreach ($composer as $c) {
            array_push($idPrestations, $c->IdPrestation);
        }
        $prestations = \giftbox\model\Prestation::whereIn("Id", $idPrestations)->get();
        $categories = \giftbox\model\Categorie::all();
        $nomCategories = array();
        foreach ($categories as $categorie){
            array_push($nomCategories, $categorie->Nom);
        }
        $vue = new \giftbox\view\giftBoxView(array("box" => $box, "prestations" => $prestations, "categories" => $nomCategories));
        $vue->render('Box');
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
}