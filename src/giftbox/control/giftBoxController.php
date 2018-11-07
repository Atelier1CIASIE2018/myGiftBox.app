<?php
namespace giftbox\control;

$_SESSION["user"] = new \giftbox\model\User();
$_SESSION["user"]->Id = 1;

class giftBoxController extends \mf\control\AbstractController {
    private $router;

    public function __construct(){
        parent::__construct();
        $this->router = new \mf\router\Router();
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
        if($_SERVER["PATH_INFO"] == "/prestation/"){
            $vue->render('Prestation');
        }
        if($_SERVER["PATH_INFO"] == "/admin/prestation/"){
            $vue->render('AdminPrestation');
        }
    }

    public function viewPrestations(){
        $prestations = \giftbox\model\Prestation::all();
        $categories = \giftbox\model\Categorie::all();
        $nomCategories = array();
        foreach ($categories as $categorie){
            array_push($nomCategories, $categorie->Nom);
        }
        $vue = new \giftbox\view\giftBoxView(array("prestations" => $prestations, "categories" => $nomCategories));
        if($_SERVER["PATH_INFO"] == "/prestations/"){
            $vue->render('Prestations');
        }
        if($_SERVER["PATH_INFO"] == "/admin/"){
            $vue->render('Admin');
        }
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
        $id = $_SESSION["user"]->Id;
        $boxes = \giftbox\model\Box::select('*')->where('IdUser', "=", $id)->get();
        $vue = new \giftbox\view\giftBoxView($boxes);
        $vue->render('Boxes');
    }

    public function viewBox(){
        if(isset($_SESSION["box"]["Id"])){
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
            $dates = array();
            $composer = \giftbox\model\Composer::select(["IdPrestation", "Date"])->where("IdBox", "=", $id)->get();
            foreach ($composer as $c) {
                $dates[$c->IdPrestation] = $c->Date;
            }
            $_SESSION["box"] = $box;
            $_SESSION["prestations"] = $prestations;
            $_SESSION["categories"] = $nomCategories;
            $_SESSION["date"] = $dates;
        }        
        $vue = new \giftbox\view\giftBoxView("");
        if($_SERVER["PATH_INFO"] == "/box/"){
            if(isset($_GET["update"])){
                $vue->render('FormBox');
            }
            else{
                $vue->render('Box');
            }
        }
        if($_SERVER["PATH_INFO"] == "/box/summary/"){
            $vue->render('SummaryBox');
        }
        if($_SERVER["PATH_INFO"] == "/box/pay/"){
            $vue->render('PayBox');
        }
    }

    public function newBox(){
        $vue = new \giftbox\view\giftBoxView("");
        $vue->render('FormBox');
    }

    public function formBox(){
        if(isset($_POST["choixForm"])){
            if($_POST["choixForm"] == "Ajouter"){
                if(isset($_SESSION["box"])){
                    $_SESSION["box"]->Nom = $_POST["titre"];
                    $_SESSION["box"]->IdUser = $_SESSION["user"]->Id;
                    $_SESSION["box"]->Message = $_POST["Texte"];
                }
                else{
                    $box = new \giftBox\model\Box();
                    $box->Nom = $_POST["titre"];
                    $box->IdUser = $_SESSION["user"]->Id;
                    $_SESSION["box"]->Message = $_POST["Texte"];
                    if($_POST["choixDate"] == 1){
                        $_SESSION["date"] = date("Y-m-d");
                    }
                    if($_POST["choixDate"] == 2){
                        if($_POST["date"] > date("Y-m-d")){
                            $_SESSION["date"] = $_POST["date"];
                        } 
                        else{
                            $_SESSION["date"] = 0;
                        }                          
                    }
                    if($_POST["choixDate"] == 3){
                        $_SESSION["date"] = array();
                    }
                }
                header("Location: ".$this->router->urlFor("/prestations/", []));
            }
            if($_POST["choixForm"] == "Valider"){
                if(isset($_SESSION["box"])){
                    $_SESSION["box"]->Nom = $_POST["titre"];
                    $_SESSION["box"]->IdUser = $_SESSION["user"]->Id;
                    $_SESSION["box"]->Message = $_POST["Texte"];
                }
                else{
                    $box = new \giftBox\model\Box();
                    $box->Nom = $_POST["titre"];
                    $box->IdUser = $_SESSION["user"]->Id;
                    $box->Message = $_POST["Texte"];
                    $_SESSION["box"] = $box;
                    if($_POST["choixDate"] == 1){
                        $_SESSION["date"] = date("Y-m-d");
                    }
                    if($_POST["choixDate"] == 2){
                        if($_POST["date"] > date("Y-m-d")){
                            $_SESSION["date"] = $_POST["date"];
                        } 
                        else{
                            $_SESSION["date"] = 0;
                        }                          
                    }
                    if($_POST["choixDate"] == 3){
                        $_SESSION["date"] = array();
                    }
                }
                $this->router->executeRoute("updateBox");
            }
        }
    }

    public function addPrestationBox(){
    
    }

    public function removePrestationBox(){
        
    }

    public function updateBox(){
        echo "updateBox";
    }

    public function postBox(){
        
    }

    public function confirmBox(){
        $id = $_GET["Id"];
        $box = \giftbox\model\Box::find($id);
        $box->Etat = 3;
        $box->save();
        header("Location: ".$this->router->urlFor("/boxes/", [])."/");
    }

    public function urlBox(){
        
    }

    public function receiverUrl(){
        
    }

    public function profile(){
        if($_SERVER["PATH_INFO"] == "/profile/"){
            $vue = new \giftbox\view\giftBoxView("");
            $vue->render('Profil');
        }
        if($_SERVER["PATH_INFO"] == "/profile/view/"){
            $vue = new \giftbox\view\giftBoxView("");
            $vue->render('ProfilView');
        }
    }

    public function updateProfile(){
        
    }

    public function newPrestation(){
        $vue = new \giftbox\view\giftBoxView("");
        $vue->render('NewPrestation');
    }
}