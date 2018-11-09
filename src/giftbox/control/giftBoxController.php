<?php
namespace giftbox\control;
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
        $auth = new \giftbox\auth\giftBoxAuthentification();
        $auth->loginUser($_POST["login"], $_POST["mdp"]);
        header("Location: ".$this->router->urlFor("/home/", []));
    }

    public function viewRegister(){
        $vue = new \giftbox\view\giftBoxView('');
        $vue->render('Register');
    }

    public function postRegister(){
        $auth = new \giftbox\auth\giftBoxAuthentification();
        $auth->createUser($_POST["nom"], $_POST["prenom"], $_POST["mail"], $_POST["log"], $_POST["mdp"]);
        header("Location: ".$this->router->urlFor("/login/", []));
    }

    public function logout(){
        $auth = new \giftbox\auth\giftBoxAuthentification();
        $auth->logout();
        header("Location: ".$this->router->urlFor("/home/", []));
    }

    public function viewBoxes(){
        $id = $_SESSION["user_login"]->Id;
        $boxes = \giftbox\model\Box::select('*')->where('IdUser', "=", $id)->where("Etat", "!=", 0)->get();
        $vue = new \giftbox\view\giftBoxView($boxes);
        $vue->render('Boxes');
    }

    public function viewBox(){
        $id = $_GET["Id"];
        $box = \giftbox\model\Box::where('Id', "=", $id)->first();
        $composer = \giftbox\model\Composer::where("IdBox", "=", $id)->get();
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
        $_SESSION["box"] = $box;
        $_SESSION["prestations"] = $prestations;
        $_SESSION["categories"] = $nomCategories;
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
        if($_SERVER["PATH_INFO"] == "/box/receiver/"){
            $vue->render('RenderDestinataire');
        }
    }

    public function newBox(){
        $_SESSION["box"] = null;
        $_SESSION["prestations"] = null;
        $box = new \giftbox\model\Box();
        $box->IdUser = $_SESSION["user_login"]->Id;
        $box->Etat = 0;
        $box->save();
        $_SESSION["box"] = $box;
        $vue = new \giftbox\view\giftBoxView("");
        $vue->render('FormBox');
    }

    public function formBox(){
        if(isset($_POST["choixForm"])){
            if($_POST["choixForm"] == "Ajouter une prestation"){
                $box = \giftBox\model\Box::where("Id", "=", $_SESSION["box"]["Id"])->first();
                $box->Nom = $_POST["nom"];
                $box->IdUser = $_SESSION["user_login"]->Id;
                $box->Message = $_POST["Texte"];
                $box->Date = $_POST["date"];
                $box->Etat = 1;
                $box->save();
                $_SESSION["box"] = $box;
                header("Location: ".$this->router->urlFor("/prestations/", []));
            }
            if($_POST["choixForm"] == "Sauvegarder"){
                if(isset($_SESSION["box"]) && !empty($_SESSION["box"])){
                    $_SESSION["box"]->Nom = $_POST["nom"];
                    $_SESSION["box"]->IdUser = $_SESSION["user_login"]->Id;
                    $_SESSION["box"]->Message = $_POST["Texte"];
                    $_SESSION["box"]->Date = $_POST["date"];
                    $_SESSION["box"]->Etat = 1;
                    $this->router->executeRoute("updateBox");
                    header("Location: ".$this->router->urlFor("/boxes/", []));
                }
                else{
                    $box = new \giftBox\model\Box();
                    $box->Nom = $_POST["nom"];
                    $box->IdUser = $_SESSION["user_login"]->Id;
                    $box->Message = $_POST["Texte"];
                    $box->Date = $_POST["date"];
                    $_SESSION["box"] = $box;
                    $this->router->executeRoute("postBox");
                }
            }
            if($_POST["choixForm"] == "Valider"){
                header("Location: ".$this->router->urlFor("/box/confirm/", ["Id"=>$_SESSION["box"]["Id"]]));
            }
        }
    }

    public function addPrestationBox(){
        $id = $_GET["Id"];
        $box = \giftBox\model\Box::where("Id", "=", $_SESSION["box"]["Id"])->first();
        if($box["Etat"] == 1 || $box["Etat"] == 0){
            $composer = new \giftbox\model\Composer();
            $composer->IdBox = $_SESSION["box"]["Id"];
            $composer->IdPrestation = $_GET["Id"];
            try{
                $composer->save();
                header("Location: ".$this->router->urlFor("/box/", ["Id"=>$_SESSION["box"]["Id"], "update"=>null]));
            }
            catch (\Exception $e){
                //$_SESSION["messageErreur"] = "Vous ne pouvez pas ajouter une 2e fois cette préstation";
                header("Location: ".$this->router->urlFor("/box/", ["Id"=>$_SESSION["box"]["Id"], "update"=>null]));
            } 
        }      
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
        $box->Date = $_POST["date"];
        $box->Etat = 1;
        $box->save();
        $_SESSION["box"] = null;
        $_SESSION["Prestations"] = null;    
    }

    public function postBox(){
        $box = new \giftbox\model\Box();
        $box->Nom = $_POST["nom"];
        $box->Message = $_POST["Texte"];
        $box->Date = $_POST["date"];
        $box->IdUser = $_SESSION["user_login"]->Id;
        $box->Etat = 1;
        $box->save();
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
        header("Location: ".$this->router->urlFor("/boxes/", []));
    }

    public function payBox(){
        $vue = new \giftbox\view\giftBoxView("");
        $vue->render('PayBox');
    }

    public function payBoxSend(){
        $id = $_GET["Id"];
        $box = \giftBox\model\Box::where("Id", "=", $id)->first();
        if($box->Etat == 1){
            $this->router->executeRoute("confirmBox");
        }
        $box->Etat = 3;
        $box->save();
        $this->router->executeRoute("urlBox");
        header("Location: ".$this->router->urlFor("/box/", ["Id"=>$id]));
    }

    public function urlBox(){
        
    }

    public function receiverUrl(){
        
    }

    public function profile(){
        $user = \giftBox\model\User::where("Id", "=", $_SESSION["user_login"]["Id"])->first();
        $vue = new \giftbox\view\giftBoxView($user);
        if($_SERVER["PATH_INFO"] == "/profile/"){    
            $vue->render('Profil');
        }
        if($_SERVER["PATH_INFO"] == "/profile/view/"){
            $vue->render('ProfilView');
        }
    }

    public function updateProfile(){
        $user = \giftBox\model\User::where("Id", "=", $_SESSION["user_login"]["Id"])->first();
        if($_POST["nom"] != ""){
            $user->Nom = $_POST["nom"];
        }
        if($_POST["prenom"] != ""){
            $user->Prenom = $_POST["prenom"];
        }
        if($_POST["email"] != ""){
            $user->Email = $_POST["email"];
        }
        if($_POST["login"] != "" && \giftBox\model\User::where("Login", "=", $_POST["login"])){
            $user->Login = $_POST["login"];
        }
        if($_POST["mdp"] != "" && $_POST["mdpconfirm"] != "" && $_POST["mdp"] == $_POST["mdpconfirm"]){
            $user->Mdp = password_hash($_POST["mdp"], PASSWORD_DEFAULT);
        }
        $user->save();
        header("Location: ".$this->router->urlFor("/profile/", []));
    }

    public function newPrestation(){
        $vue = new \giftbox\view\giftBoxView("");
        $vue->render('NewPrestation');
    }
}