<?php
namespace giftbox\control;
class giftBoxController extends \mf\control\AbstractController {
    private $router;

    public function __construct(){
        parent::__construct();
        $this->router = new \mf\router\Router();
    }
    
    public function viewHome(){
        $prestations = \giftbox\model\Prestation::take(3)->orderBy('id', 'desc')->get();
        $vue = new \giftbox\view\giftBoxView(array("prestations" => $prestations, "categories" => $this->categories()));
        $vue->render('Home');
    }
    
    public function viewPrestation(){
        $prestation = \giftbox\model\Prestation::where('id', "=", $_GET['id'])->first();
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
            $prestations = \giftBox\model\Prestation::orderby("prix", $_GET["order"])->get();
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
        $id = $_GET["id"];
        if(isset($_GET["order"])){
            $prestations = \giftBox\model\Prestation::where('idCategorie', "=", $id)->orderby("prix", $_GET["order"])->get();
        }
        else{
            $prestations = \giftbox\model\Prestation::where('idCategorie', "=", $id)->get();
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
        $boxes = \giftbox\model\Box::where('idUser', "=", $_SESSION["user_login"]->id)->where("etat", "!=", 0)->get();
        $vue = new \giftbox\view\giftBoxView($boxes);
        $vue->render('Boxes');
    }

    public function viewBox(){
        $id = $_GET["id"];
        $box = \giftbox\model\Box::where('id', "=", $id)->first();
        $composer = \giftbox\model\Composer::where("idBox", "=", $id)->get();
        $idPrestations = array();
        foreach ($composer as $c) {
            array_push($idPrestations, $c->idPrestation);
        }
        $prestations = \giftbox\model\Prestation::whereIn("id", $idPrestations)->get();
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
        $box->idUser = $_SESSION["user_login"]->id;
        $box->etat = 0;
        $box->save();
        $_SESSION["box"] = $box;
        $vue = new \giftbox\view\giftBoxView("");
        $vue->render('FormBox');
    }

    public function formBox(){
        if(isset($_POST["choixForm"])){
            if($_POST["choixForm"] == "Ajouter une prestation"){
                $box = \giftBox\model\Box::where("id", "=", $_SESSION["box"]->id)->first();
                $box->nom = $_POST["nom"];
                $box->idUser = $_SESSION["user_login"]->id;
                $box->message = $_POST["texte"];
                $box->date = $_POST["date"];
                $box->etat = 1;
                $box->save();
                $_SESSION["box"] = $box;
                $_SESSION["newPrestation"] = 1;
                header("Location: ".$this->router->urlFor("/prestations/", []));
            }
            if($_POST["choixForm"] == "Sauvegarder"){
                if(isset($_SESSION["box"]) && $_SESSION["box"] != null){
                    $_SESSION["box"]->nom = $_POST["nom"];
                    $_SESSION["box"]->idUser = $_SESSION["user_login"]->id;
                    $_SESSION["box"]->message = $_POST["Texte"];
                    $_SESSION["box"]->date = $_POST["date"];
                    $_SESSION["box"]->etat = 1;
                    $this->router->executeRoute("updateBox");
                    header("Location: ".$this->router->urlFor("/boxes/", []));
                }
                else{
                    $box = new \giftBox\model\Box();
                    $box->nom = $_POST["nom"];
                    $box->idUser = $_SESSION["user_login"]->id;
                    $box->message = $_POST["Texte"];
                    $box->date = $_POST["date"];
                    $_SESSION["box"] = $box;
                    $this->router->executeRoute("postBox");
                }
            }
            if($_POST["choixForm"] == "Valider"){
                header("Location: ".$this->router->urlFor("/box/confirm/", ["id" => $_SESSION["box"]->id]));
            }
        }
    }

    public function addPrestationBox(){
        unset($_SESSION["newPrestation"]);
        $box = \giftBox\model\Box::where("id", "=", $_SESSION["box"]->id)->first();;
        if($box->etat == 1 || $box->etat == 0){
            $composer = new \giftbox\model\Composer();
            $composer->idBox = $_SESSION["box"]->id;
            $composer->idPrestation = $_GET["id"];
            try{
                $composer->save();
                header("Location: ".$this->router->urlFor("/box/", ["id" => $_SESSION["box"]->id, "update"=>null]));
            }
            catch (\Exception $e){
                //$_SESSION["messageErreur"] = "Vous ne pouvez pas ajouter une 2e fois cette préstation";
                header("Location: ".$this->router->urlFor("/box/", ["id" => $_SESSION["box"]->id, "update"=>null]));
            } 
        }
    }      

    public function removePrestationBox(){
        \giftbox\model\Composer::where("idBox", "=", $_SESSION["box"]->id)->where("idPrestation", "=", $_GET["id"])->delete();
        header("Location: ".$this->router->urlFor("/box/", ["id"=>$_SESSION["box"]->id, "update"=>null]));
    }

    public function updateBox(){
        $box = \giftbox\model\Box::where("id", "=", $_SESSION["box"]->id)->first(); 
        $box->nom = $_SESSION["box"]->nom;
        $box->message = $_SESSION["box"]->message;
        $box->date = $_SESSION["box"]->date;
        $box->etat = 1;
        $box->save();
        $_SESSION["box"] = null;
        $_SESSION["Prestations"] = null;   
    }

    public function postBox(){
        $box = new \giftbox\model\Box();
        $box->nom = $_POST["nom"];
        $box->message = $_POST["texte"];
        $box->date = $_POST["date"];
        $box->idUser = $_SESSION["user_login"]->id;
        $box->etat = 1;
        $box->save();
    }

    public function confirmBox(){
        $id = $_GET["id"];
        $save = false;
        $box = \giftbox\model\Box::find($id);
        $composer = \giftbox\model\Composer::where("idBox", "=", $box->id)->get();
        $idPrestations = array();
        foreach ($composer as $c) {
            array_push($idPrestations, $c->idPrestation);
        }
        $prestations = \giftbox\model\Prestation::whereIn("id", $idPrestations)->get();
        if($prestations->count() >= 2){
            $idCategorieTest = $prestations[0]->idCategorie;
            $i = 1;
            while($save == false && $i < $prestations->count()){
                if($prestations[$i]->idCategorie != $idCategorieTest){
                    $save = true;
                    $box->etat = 2;
                    $box->save();
                }
                $i++;
            }
        }
        header("Location: ".$this->router->urlFor("/boxes/", []));
    }

    public function payBoxSend(){
        $id = $_GET["id"];
        $box = \giftBox\model\Box::where("id", "=", $id)->first();
        if($box->etat == 1){
            $this->router->executeRoute("confirmBox");
        }
        $box->etat = 3;
        $box->save();
        $this->router->executeRoute("urlBox");
        header("Location: ".$this->router->urlFor("/box/", ["id" => $id]));
    }

    public function urlBox(){
        $id = $_GET["id"];
        $box = \giftBox\model\Box::where("id", "=", $id)->first();
        $box->etat = 4;
        $box->url = $this->router->urlFor("/box/receiver/", ["id" => $id]);
        $box->save();
        header("Location: ".$this->router->urlFor("/box/", ["id" => $id]));
    }

    public function visitedBox(){
        $id = $_GET["id"];
        $box = \giftBox\model\Box::where("id", "=", $id)->first();
        $box->Etat = 5;
        $box->save();   
    }

    public function receiverMessage(){
        $id = $_GET["id"];
        if($_POST["texte"] != ""){
            $box = \giftBox\model\Box::where("id", "=", $id)->first();
            $box->MessageRetour = $_POST["texte"];
            $box->save();
        }
        header("Location: ".$this->router->urlFor("/box/receiver/", ["id" => $id]));
    }

    public function profile(){
        $user = \giftBox\model\User::where("id", "=", $_SESSION["user_login"]->id)->first();
        $vue = new \giftbox\view\giftBoxView($user);
        if($_SERVER["PATH_INFO"] == "/profile/"){    
            $vue->render('Profil');
        }
        if($_SERVER["PATH_INFO"] == "/profile/view/"){
            $vue->render('ProfilView');
        }
    }

    public function updateProfile(){
        $user = \giftBox\model\User::where("id", "=", $_SESSION["user_login"]->id)->first();
        if($_POST["nom"] != ""){
            $user->nom = $_POST["nom"];
        }
        if($_POST["prenom"] != ""){
            $user->prenom = $_POST["prenom"];
        }
        if($_POST["email"] != "" && \giftBox\model\User::where("email", "=", $_POST["login"])){
            $user->email = $_POST["email"];
        }
        if($_POST["mdp"] != "" && $_POST["mdpconfirm"] != "" && $_POST["mdp"] == $_POST["mdpconfirm"]){
            $user->mdp = password_hash($_POST["mdp"], PASSWORD_DEFAULT);
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
            array_push($nomCategories, $categorie->nom);
        }
        return $nomCategories;
    }
}