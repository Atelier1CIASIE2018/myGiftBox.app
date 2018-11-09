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
        $vue = new \giftbox\view\giftBoxView(array("prestations" => $prestations, "categories" => $this->categories()));
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
        if(isset($_GET["order"])){
            $prestations = \giftBox\model\Prestation::orderby("Prix", $_GET["order"])->get();
        }
        else{
            $prestations = \giftBox\model\Prestation::all();
        }
        $vue = new \giftbox\view\giftBoxView(array("prestations" => $prestations, "categories" => $this->categories(), "page" => "/prestations/"));
        if($_SERVER["PATH_INFO"] == "/prestations/"){
            $vue->render('Prestations');
        }
        if($_SERVER["PATH_INFO"] == "/admin/"){
            $vue->render('Admin');
        }
    }

    public function viewCategories(){
        $categories = \giftbox\model\Categorie::all();
        $vue = new \giftbox\view\giftBoxView($categories);
        $vue->render('Categories');
    }

    public function viewCategorie(){
        $id = $_GET["Id"];
        if(isset($_GET["order"])){
            $prestations = \giftBox\model\Prestation::where('IdCategorie', "=", $id)->orderby("Prix", $_GET["order"])->get();
        }
        else{
            $prestations = \giftbox\model\Prestation::where('IdCategorie', "=", $id)->get();
        }
        $vue = new \giftbox\view\giftBoxView(array("prestations"=>$prestations, "categories" => $this->categories(), "page" => "/categorie/"));
        $vue->render('Prestations');
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
        $auth->createUser($_POST["nom"], $_POST["prenom"], $_POST["mail"], $_POST["mdp"]);
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
        $vue = new \giftbox\view\giftBoxView(["box" => $box, "prestations" => $prestations, "categories" => $this->categories()]);
        $path_info = $_SERVER["PATH_INFO"];
        $_SESSION["box"] = $box;
        if($path_info == "/box/"){
            if(isset($_GET["update"])){
                $vue->render('FormBox');
            }
            else{
                $vue->render('Box');
            }
        }
        if($path_info == "/box/summary/"){
            $vue->render('SummaryBox');
        }
        if($path_info == "/box/pay/"){
            $vue->render('PayBox');
        }
        if($path_info == "/box/receiver/"){
            if($box->Etat == 4){
                $this->router->executeRoute("visitedBox");
            }
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
                $_SESSION["newPrestation"] = 1;
                header("Location: ".$this->router->urlFor("/prestations/", []));
            }
            if($_POST["choixForm"] == "Sauvegarder"){
                if(isset($_SESSION["box"]) && $_SESSION["box"] != null){
                    $_SESSION["box"]["Nom"] = $_POST["nom"];
                    $_SESSION["box"]["IdUser"] = $_SESSION["user_login"]->Id;
                    $_SESSION["box"]["Message"] = $_POST["Texte"];
                    $_SESSION["box"]["Date"] = $_POST["date"];
                    $_SESSION["box"]["Etat"] = 1;
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
        unset($_SESSION["newPrestation"]);
        $box = \giftBox\model\Box::where("Id", "=", $_SESSION["box"]["Id"])->first();;
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
        \giftbox\model\Composer::where("IdBox", "=", $_SESSION["box"]["Id"])->where("IdPrestation", "=", $_GET["Id"])->delete();
        header("Location: ".$this->router->urlFor("/box/", ["Id"=>$_SESSION["box"]["Id"], "update"=>null]));
    }

    public function updateBox(){
        $box = \giftbox\model\Box::where("Id", "=", $_SESSION["box"]["Id"])->first(); 
        $box->Nom = $_SESSION["box"]["Nom"];
        $box->Message = $_SESSION["box"]["Message"];
        $box->Date = $_SESSION["box"]["Date"];
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
        $id = $_GET["Id"];
        $box = \giftBox\model\Box::where("Id", "=", $id)->first();
        $box->Etat = 4;
        $box->Url = $this->router->urlFor("/box/receiver/", ["Id"=>$id]);
        $box->save();
        header("Location: ".$this->router->urlFor("/box/", ["Id"=>$id]));
    }

    public function visitedBox(){
        $id = $_GET["Id"];
        $box = \giftBox\model\Box::where("Id", "=", $id)->first();
        $box->Etat = 5;
        $box->save();   
    }

    public function receiverMessage(){
        $id = $_GET["Id"];
        if($_POST["texte"] != ""){
            $box = \giftBox\model\Box::where("Id", "=", $id)->first();
            $box->MessageRetour = $_POST["texte"];
            $box->save();
        }
        header("Location: ".$this->router->urlFor("/box/receiver/", ["Id"=>$id]));
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
        if($_POST["email"] != "" && \giftBox\model\User::where("Email", "=", $_POST["login"])){
            $user->Email = $_POST["email"];
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

    private function categories(){
        $categories = \giftbox\model\Categorie::all();
        $nomCategories = array();
        foreach ($categories as $categorie){
            array_push($nomCategories, $categorie->Nom);
        }
        return $nomCategories;
    }
}