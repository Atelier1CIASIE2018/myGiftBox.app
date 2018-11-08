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
        $id = $_GET["Id"];
        $box = \giftbox\model\Box::where('Id', "=", $id)->first();
        $composer = \giftbox\model\Composer::where("IdBox", "=", $box->Id)->get();
        $idPrestations = array();
        $dates = array();
        foreach ($composer as $c) {
            array_push($idPrestations, $c->IdPrestation);
            array_push($dates, array("IdPrestation" => $c->IdPrestation, "Date" => $c->Date));
        }
        $prestations = \giftbox\model\Prestation::whereIn("Id", $idPrestations)->get();
        $categories = \giftbox\model\Categorie::all();
        $nomCategories = array();
        foreach ($categories as $categorie){
            array_push($nomCategories, $categorie->Nom);
        }
        $_SESSION["box"] = $box;
        $_SESSION["prestations"] = $prestations;
        $_SESSION["categories"] = $nomCategories;
        $_SESSION["date"] = $dates;  
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
                    $_SESSION["box"]->Nom = $_POST["nom"];
                    $_SESSION["box"]->IdUser = $_SESSION["user"]->Id;
                    $_SESSION["box"]->Message = $_POST["Texte"];
                }
                else{
                    $box = new \giftBox\model\Box();
                    $box->Nom = $_POST["nom"];
                    $box->IdUser = $_SESSION["user"]->Id;
                    $_SESSION["box"]->Message = $_POST["Texte"];
                    if($_POST["choixDate"] == 1){
                        $_SESSION["date"] = array(date("Y-m-d"));
                    }
                    if($_POST["choixDate"] == 2){
                        if($_POST["date"] > date("Y-m-d")){
                            $_SESSION["date"] = array($_POST["date"]);
                        } 
                        else{
                            $_SESSION["date"] = array("1970-01-01");
                        }                          
                    }
                    if($_POST["choixDate"] == 3){
                        $_SESSION["date"] = array();
                    }
                }
                header("Location: ".$this->router->urlFor("/prestations/", [])."/");
            }
            if($_POST["choixForm"] == "Sauvegarder"){
                if(isset($_SESSION["box"])){
                    $_SESSION["box"]->Nom = $_POST["nom"];
                    $_SESSION["box"]->IdUser = $_SESSION["user"]->Id;
                    $_SESSION["box"]->Message = $_POST["Texte"];
                }
                else{
                    $box = new \giftBox\model\Box();
                    $box->Nom = $_POST["nom"];
                    $box->IdUser = $_SESSION["user"]->Id;
                    $box->Message = $_POST["Texte"];
                    $_SESSION["box"] = $box;
                    if($_POST["choixDate"] == 1){
                        $_SESSION["date"] = date("Y-m-d");
                    }
                    if($_POST["choixDate"] == 2){
                        if(date("Y-m-d", strtotime($_POST["date"])) > date("Y-m-d")){
                            $_SESSION["date"] = $_POST["date"];
                        } 
                        else{
                            $_SESSION["date"] = "1970-01-01";
                        }                          
                    }
                    if($_POST["choixDate"] == 3){
                        $_SESSION["date"] = array();
                    }
                }
                $this->router->executeRoute("updateBox");
            }
            if($_POST["choixForm"] == "Valider"){
                header("Location: ".$this->router->urlFor("/box/confirm/", [])."/?Id=".$_SESSION["box"]["Id"]);
            }
        }
    }

    public function addPrestationBox(){
        $id = $_GET["Id"];
        $composer = new \giftbox\model\Composer();
        $composer->IdBox = $_SESSION["box"]["Id"];
        $composer->IdPrestation = $_GET["Id"];
        $composer->Date = "1970-01-01";
        $composer->save();
        header("Location: ".$this->router->urlFor("/box/", ["Id"=>$_SESSION["box"]["Id"], "update"=>null]));
    }

    public function removePrestationBox(){
        $id = $_GET["Id"];
        $composer = \giftbox\model\Composer::where("IdBox", "=", $_SESSION["box"]["Id"])->where("IdPrestation", "=", $id)->first();
        \giftbox\model\Composer::where("IdBox", "=", $_SESSION["box"]["Id"])->where("IdPrestation", "=", $id)->delete();
        header("Location: ".$this->router->urlFor("/box/", ["Id"=>$_SESSION["box"]["Id"], "update"=>null]));
    }

    public function updateBox(){
        $box = \giftbox\model\Box::where("Id", "=", $_SESSION["box"]["Id"])->first();
        $box->Nom = $_POST["nom"];
        $box->Message = $_POST["Texte"];
        $box->save();
        if(is_array($_SESSION["date"])){
            foreach ($_SESSION["date"] as $key => $value) {
                $composer = \giftbox\model\Composer::where("IdBox", "=", $box->Id)->where("IdPrestation", "=", $key);
                $composer->Date = $_SESSION["date"][$key];
                $composer->save();
            }
        }
        unset($_SESSION["box"]);
        unset($_SESSION["prestations"]);
        unset($_SESSION["date"]);
        unset($_SESSION["categories"]);
        header("Location: ".$this->router->urlFor("/boxes/", [])."/");
    }

    public function postBox(){
        
    }

    public function confirmBox(){
        $id = $_GET["Id"];
        $save = false;
        $box = \giftbox\model\Box::find($id);
        $composer = \giftbox\model\Composer::where("IdBox", "=", $box->Id)->get();
        $idPrestations = array();
        foreach ($composer as $c) {
            array_push($idPrestations, $c->IdPrestation);
        }
        $prestations = \giftbox\model\Prestation::whereIn("Id", $idPrestations)->get();
        if($prestations->count() >= 2){
            $idCategorieTest = $prestations[0]["IdCategorie"];
            $i = 1;
            while($save == false && $i < $prestations->count()){
                if($prestations[$i]["IdCategorie"] != $idCategorieTest){
                    $save = true;
                    $box->Etat = 2;
                    $box->save();
                }
                $i++;
            }
        }
        unset($_SESSION["box"]);
        unset($_SESSION["prestations"]);
        unset($_SESSION["date"]);
        unset($_SESSION["categories"]);
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