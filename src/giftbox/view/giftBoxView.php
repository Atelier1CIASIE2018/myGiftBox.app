<?php
namespace giftbox\view;
class GiftBoxView extends \mf\view\AbstractView {
    private $router;

    public function __construct( $data ){
        parent::__construct($data);
        $this->router = new \mf\router\Router();
    }

    private function renderHeader(){
        $res = "<a href='/giftBox/main.php/home/'><h1>My Gift Box App</h1></a>";
        if(isset($_SESSION["user_login"])){
            $res .= "<div><a href='".$this->router->urlFor("/profile/", [])."'><button>Mon Profil</button></a></div>
            <div><a href='".$this->router->urlFor("/boxes/", [])."'><button>Mes coffrets</button></a></div>
            <div><a href='".$this->router->urlFor("/box/new/", [])."'><button>Créer coffret</button></a></div>
            <div><a href='".$this->router->urlFor("/logout/", [])."'><button>Déconnexion</button></a></div>";
        }
        else{
            $res .= "<div><a href='/giftBox/main.php/register/'><button>Inscription</button></a></div>
            <div><a href='/giftBox/main.php/login/'><button>Connexion</button></a></div>";
        }
        return $res;
    }
    
    private function renderFooter(){
        return 'Atelier 1 CIASIE 2018 Toussaint Maillard Guebel &copy;2018';
    }
    
    private function renderHome(){
        $res = "<div id='home'> 
                <img src='/giftBox/img/cadeau.jpg' >
                <div> <h1> Nouveautés : </h1>";
        foreach ($this->data["prestations"] as $value) {
            $urlPrestation = $this->router->urlfor('/prestation/', ['Id'=>$value['Id']]);
            $urlCategorie = $this->router->urlfor('/categorie/', ['Id'=>$value['IdCategorie']]);
            $res .= "<div>
                <a href='".$urlPrestation."'>
                    <p>".$value['Nom']."</p>
                    <p>".$value['Prix']." €</p>
                </a>
                <p><a href='".$urlCategorie."'>".$this->data["categories"][$value["IdCategorie"] - 1]."</p>
                <a href='".$urlPrestation."'>
                    <img src ='/giftBox/img/".$value['Img']."' width='200'>
                    <p>".$value['Description']."</p>
                </a>
                <a href='/giftBox/main.php/box/add/?Id=".$value['Id']."'><button>+</button></a>
            </div><hr>";
        }
        $res .= " <a href='/giftBox/main.php/prestations/'><button>Voir plus...</button></a></div></div>";
        return $res;   // FINI
    }

    private function renderPrestation(){
        $res = "<div id='prestation'>
            <p>".$this->data['Nom']."</p>
            <p>".$this->data['Prix']." €</p>
            <img src ='/giftBox/img/".$this->data['Img']."'>
            <p>".$this->data['Description']."</p>
            <a href='/giftBox/main.php/box/add/?Id=".$this->data['Id']."'><button>+</button></a>
        </div>";
        return $res;  // FINI
    }

    private function renderPrestations(){
        $res = "<div id='prestations'><div>";
        foreach ($this->data["prestations"] as $value) {
            $urlPrestation = $this->router->urlfor('/prestation/', ['Id'=>$value['Id']]);
            $urlCategorie = $this->router->urlfor('/categorie/', ['Id'=>$value['IdCategorie']]);
            $res .="<div>
                <a href='".$urlPrestation."'>
                    <p>".$value['Nom']."</p>
                    <p>".$value['Prix']." €</p>
                </a>
                <p><a href='".$urlCategorie."'>".$this->data["categories"][$value["IdCategorie"] - 1]."</p>
                <a href='".$urlPrestation."'>
                    <img src ='/giftBox/img/".$value['Img']."' width='200'>
                    <p>".$value['Description']."</p>
                </a>
                <a href='/giftBox/main.php/box/add/?Id=".$value['Id']."'><button>+</button></a>
            </div><hr>";
        }
        $res .= "</div></div>";
        return $res;  // FINI
    }

    private function renderCategories(){
        $res = "<div>";
        foreach ($this->data as $value) {
            $urlCategorie = $this->router->urlfor('/categorie/', ['Id'=>$value['Id']]);
            $res .= "<div>
                <a href='".$urlCategorie."'<p>".$value['Nom']."</p></a>
            </div>";
        }
        $res = $res."</div>";
        return $res;    // FINI
    }

    private function renderCategorie(){
        $res = "<div id='categorie'>";
        foreach ($this->data as $value) {            
            $urlPrestation = $this->router->urlfor('/prestation/', ['Id'=>$value['Id']]);
            $urlCategorie = $this->router->urlfor('/categorie/', ['Id'=>$value['IdCategorie']]);
            $res .="<div>
                <a href='".$urlPrestation."'>
                    <p>".$value['Nom']."</p>
                    <p>".$value['Prix']." €</p>
                </a>
                <a href='".$urlPrestation."'>
                    <img src ='/giftBox/img/".$value['Img']."' width='200'>
                    <p>".$value['Description']."</p>
                </a>
                <a href='/giftBox/main.php/box/add/?Id=".$value['Id']."'><button>+</button></a>
            </div><hr>";
        }
        $res = $res."</div>";
        return $res;    // FINI
    }

    private function renderLogin(){
        return "<h1> Connexion </h1>
                <form id='log' name='connexion' method='POST' action='/giftBox/main.php/loginPost/'>
                <p>Login : </p><input tpye='text' name='login'/>
                <p>Mot de passe : </p><input type='password' name='mdp'/>
                <input type='submit' name='valider' value='Valider'/>
                </form>";   // AUTHENTIFICATION 
    }

    private function renderRegister(){
        return "<h1> Inscription </h1>
                <form id='log' name='inscription' method='POST' action='/giftBox/main.php/registerPost/'>
                <p>Prénom : </p><input tpye='text' name='prenom'/>
                <p>Nom : </p><input type='text' name='nom'/>
                <p>E-mail : </p><input type='text' name='mail'/>
                <p>Login : </p><input type='text' name='log'/>
                <p>Mot de passe : </p><input type='text' name='mdp'/>                
                <input type='submit' name='valider' value='Valider'/>
                </form>"; // FINI
    }

    private function renderBoxes(){
        $res = "<div id='boxes'>";
        foreach ($this->data as $value) {
            $urlBox =  $this->router->urlfor('/box/', ['Id'=>$value['Id']]);
            $urlSummaryBox = $this->router->urlfor('/box/summary/', ['Id'=>$value["Id"]]);
            $urlConfirm = $this->router->urlfor('/box/confirm/', ['Id'=>$value["Id"]]);
            $res .= "<p>".$value['Nom'];
            switch ($value['Etat']){
                case 1:
                    $res .= "</p><div>
                    <a href='".$urlBox."'><button>Aperçu</button></a>
                    <a href='".$urlBox."&update'><button>Modifier</button></a>
                    <a href='".$urlConfirm."'><button>Valider</button></a>
                    <a href='".$urlSummaryBox."'><button>Payer</button></a></div>";
                    break;
                case 2:
                    $res .= " (Validé)</p><div>
                    <a href='".$urlBox."'><button>Aperçu</button></a>
                    <a href='".$urlSummaryBox."'><button>Payer</button></a></div>";
                    break;
                default:                    
                    if($value["Etat"] == 3){
                        $res .= " (Payé)</p>";
                    }
                    if($value["Etat"] == 4){
                        $res .= " (Transmis)</p>";
                    }
                    if($value["Etat"] == 5){
                        $res .= " (Ouvert)</p>";
                    }
                    $res .= "<div><a href='".$urlBox."'><button>Aperçu</button></a></div>";
                    break;
            }          
        }
        $res .= "</div>";
        return $res;    // FINI
    }

    private function renderBox(){
        $res = "<div id='viewBox'>
            <p>Nom : ".$_SESSION["box"]["Nom"]."</p>
            <p>Message : ".$_SESSION["box"]["Message"]."</p>
            <p>Date : ".$_SESSION["box"]["Date"]."</p>";
        if(!empty($_SESSION["prestations"])){
            foreach ($_SESSION['prestations'] as $value) {
                $urlPrestation = $this->router->urlfor('/prestation/', ['Id'=>$value['Id']]);
                $urlCategorie = $this->router->urlfor('/categorie/', ['Id'=>$value['IdCategorie']]);
                $res .= "<div>
                        <p>Nom: ".$value['Nom']."</p>
                        <p>Prix: ".$value['Prix']." €</p>
                        <p>Catégorie: ".$_SESSION["categories"][$value["IdCategorie"] - 1]."</p>
                        <img src ='/giftBox/img/".$value['Img']."'width='200'>
                        <p>".$value['Description']."</p>
                    </div>";
            }
            $urlBox =  $this->router->urlfor('/box/', ['Id'=>$_SESSION["box"]['Id']]);
            $urlSummaryBox = $this->router->urlfor('/box/summary/', ['Id'=>$_SESSION["box"]['Id']]);
            $urlConfirm = $this->router->urlfor('/box/confirm/', ['Id'=>$_SESSION["box"]["Id"]]);
            switch($_SESSION["box"]["Etat"]){
                case 1:
                    $res .= "<div><a href='".$urlBox."&update'><button>Modifier</button></a>
                    <a href='".$urlConfirm."'><button>Valider</button></a>
                    <a href='".$urlSummaryBox."'><button>Payer</button></a><div>";
                    break;
                case 2:
                    $res .= "<div><a href='".$urlSummaryBox."'><button>Payer</button></a><div>";
                    break;
                default:
                    switch($_SESSION["box"]["Etat"]){
                        case 4:
                            $res .= "<p>Votre coffret a été ou peut être transmis au destinataire</p>";
                            break;
                        case 5:
                            $res .= "<p>Votre coffret a été ouvert par le destinataire</p>";
                            break;
                    }
                    $res .= "<p>url</p>";
                    break;
            }
        }
        else{
            $res .= "<p>Aucune prestations</p>";
        }
        $res .= "</div><br>";
        return $res;    
    }

    private function renderFormBox(){
        $res = "<form id='box' name='creer' method='POST' action='/giftBox/main.php/box/form/'>
                <p> Nom : <p> <input type='text' name='nom' value='";
        if(isset($_SESSION["box"]["Nom"])){
            $res .= $_SESSION["box"]["Nom"];
        }
        $res .= "'/>
            <p> Message : </p><textarea name='Texte' rows='10' cols='50'";
        if(isset($_SESSION['box']["Message"]) && $_SESSION['box']['Message'] != ""){
            $res .= ">".$_SESSION['box']['Message'];
        }
        else{
            $res .= " placeholder='Veuillez entrer votre message pour le destinataire'>";
        }
        $res .= "</textarea>
            <p>Choix de la date d'activation du coffret, la date d'aujourd'hui activera le coffret lors de la validation</p>
            <input type='date' name='date' min='".date("Y-m-d")."' value='";
        if(isset($_SESSION["box"]["Date"]) && $_SESSION["box"]["Date"] != null){
            $res .= $_SESSION["box"]["Date"]."'>";
        }
        else{
            $res .= date("Y-m-d")."'>";
        }
        $res .= "<input type='submit' name='choixForm' value='Ajouter'/>";
        /*if(isset($_SESSION["messageErreur"]) && $_SESSION["messageErreur"] != ""){
            echo "<p>".$_SESSION["messageErreur"]."</p>";
        }*/
        if(isset($_SESSION['prestations']) && !empty($_SESSION["prestations"])){
            foreach ($_SESSION['prestations'] as $value) {
                $res .= "<div>
                    <p>Titre: ".$value['Nom']."</p>
                    <p>Prix: ".$value['Prix']." €</p>
                    <p>Catégorie: ".$_SESSION["categories"][$value["IdCategorie"] - 1]."</p>
                    <a href='/giftBox/main.php/box/remove/?Id=".$value['Id']."'>X</a>
                    <img src ='/giftBox/img/".$value['Img']."' width='200'>
                    <p>".$value['Description']."</p>
                </div>";
            }
        }
        if(isset($_SESSION['prestations'][0])){
            $total = 0;
            foreach ($_SESSION['prestations'] as $value) {
                $total += $value['Prix'];
            }
            $res .= "<h2> Tarif : ".$total." € </h2>";
        }
        else{
            $res .= "<h2> Tarif : 00,00 € </h2>";
        }
        if(isset($_SESSION["box"]["Id"])){
            $res .= "<input type='submit' name='choixForm' value='Sauvegarder'/>";
        }
        if(isset($_SESSION["box"]["Etat"]) && $_SESSION["box"]["Etat"] != 0){
            $res .= "<input type='submit' name='choixForm' value='Valider'/>";
        }
        $res .= "</form>";
        return $res;
    }

    private function renderSummaryBox(){
        $res = "<div><h1>Prestations sélectionnées : </h1><div>";
        $total = 0;
        foreach ($_SESSION["prestations"] as $value) {
            $router = new \mf\router\Router();
            $urlPrestation = $this->router->urlfor('/prestation/', ['Id'=>$value['Id']]);
            $urlCategorie = $this->router->urlfor('/categorie/', ['Id'=>$value['IdCategorie']]);
            $res = $res . "<div>
                <p>".$value['Nom']."</p>
                <p>".$value['Prix']." €</p>
            </div><hr>";
            $total += $value["Prix"];
        }
        $res .= "Total: ".$total." €</div>";
        if($_SESSION['box']['Etat'] > 2){
            $res .= "<p>Url du coffret pour le destinataire: ".$_SESSION["box"]["Url"]."</p>";
        }
        else{
            $res .= "<a href='/giftBox/main.php/box/pay/?Id=".$_SESSION['box']['Id']."'><button>Passer au paiement</button></a>";      
        }
        $res .= "</div>";
        return $res;
    }

    private function renderBoxPay(){
        $res = "<div> <h1> Préstations sélectionnée : </h1>";
        $total = 0;
        foreach ($_SESSION["prestations"] as $value) {
            $total += $value['Prix'];
            $router = new \mf\router\Router();
            $urlPrestation = $this->router->urlfor('/prestation/', ['Id'=>$value['Id']]);
            $urlCategorie = $this->router->urlfor('/categorie/', ['Id'=>$value['IdCategorie']]);
            $res = $res . "<div>
                <p>".$value['Nom']."</p>
                <p>".$value['Prix']." €</p>
            </div><hr>";
        }

        $res .= "Tarif total : " . $total . " € <br/><br/>
            <form name='acheter' method='POST' action='/giftBox/main.php/box/pay/send/?Id=".$_SESSION['box']['Id']."'>
                <input type='radio' name='test' value='' checked /> <img src='/giftBox/img/modePaiement/paypal.jpg' width='200'> <br/>
                <input type='radio' name='test' value=''/> <img src='/giftBox/img/modePaiement/visa.png' width='200'> <br/>
                <input type='radio' name='test' value=''/> <img src='/giftBox/img/modePaiement/mastercard.png' width='200'> <br/> <br/>
                <input type='radio' name='test' value=''/> <img src='/giftBox/img/modePaiement/cartebleu.jpeg' width='200'> <br/> <br/>
                <input type='submit' name='payer' value='Payer'/>
            </form></div>";
        return $res;
    }

    private function renderProfil(){
        $res = "<div><h1> Voici votre profil : </h1> <br/> 
        Nom : ".$_SESSION['user_login']['Nom']."<br/> 
        Prénom : ".$_SESSION['user_login']['Prenom']."<br/> 
        E-mail : ".$_SESSION['user_login']['Email']."<br/> 
        Pseudo : ".$_SESSION['user_login']['Login']."<br/>
        <a href='/giftBox/main.php/profile/view/'><button>Modifier</button></a>";
        return $res;
    }

    private function renderProfilView(){
        $res = "<div><h1> Voici votre profil : </h1> <br/> 
            Pseudo : <input type='text' nam='pseudo' value='".$_SESSION['user_login']['Login']."' /><br/>
            E-mail : <input type='text' nam='email' value='".$_SESSION['user_login']['Email']."' /><br/>
            Mot de passe : <input type='password' nam='mdp' value='' /><br/>
            Confirmation mot de passe : <input type='text' nam='mdpconfirm' value='' /><br/>
            <a href='/giftBox/main.php/profile/update/'><button>Valider</button></a>";
        return $res;
    }

    private function renderAdmin(){
        $res = "<a href='/giftBox/main.php/admin/prestation/new/'><button>Ajouter une préstation</button></a><div>";
            foreach ($this->data['prestations'] as $value) {
                $router = new \mf\router\Router();
                $urlPrestation = $this->router->urlfor('/prestation/', ['Id'=>$value['Id']]);
                $urlCategorie = $this->router->urlfor('/categorie/', ['Id'=>$value['IdCategorie']]);
                 $res = $res . "<div>
                <a href='".$urlPrestation."'>
                    <p>".$value['Nom']."</p>
                    <p>".$value['Prix']." €</p>
                </a>
                <p><a href='".$urlCategorie."'>".$this->data["categories"][$value["IdCategorie"] - 1]."</a></p>
                <a href='".$urlPrestation."'>
                    <img src ='/giftBox/img/".$value['Img']."' width='200'>
                    <p>".$value['Description']."</p>
                </a>
                <a href='/giftBox/main.php/admin/prestation/'><button>Modifier</button></a>
                <a href='/giftBox/main.php/admin/prestation/remove/'><button>X</button></a></div><hr>";
            }
        return $res;
    }

    private function renderNewPrestation(){
        return "<h1> Ajout d'une préstation : </h1>
                <form name='ajout' method='POST'>
                    <p>Categorie : </p><input type='text' name='categ'/> <br/>
                    <p>Nom : </p><input type='text' name='nom'/> <br/>
                    <p>Description : </p><input type='text' name='desc'/><br/>
                    <p>Prix : </p><input type='text' name='prix'/><br/>
                    <p>Image : </p><input type='file' name='image'/><br/>
                    <input type='submit' name='valider' value='valider'/><br/>
                </form>";
    }

    private function renderAdminPrestation(){
        return "<h1> Modification de la préstation </h1>
                <form name='update' method='POST'>
                    <p>Nom : </p><input type='text' name='nom' value='".$this->data['Nom']."'/> <br/>
                    <p>Description : </p><input type='text' name='nom' value='".$this->data['Description']."'/> <br/>
                    <p>Prix : </p><input type='text' name='nom' value='".$this->data['Prix']."'/> <br/>
                    <p>Image : </p><input type='file' name='image'/><br/>
                </form>";
    }
    
    protected function renderBody($selector=null){
        $string = "<header>".self::renderHeader()."</header><section><article>";
        if ($selector == 'Home')$string = $string . self::renderHome();
        if ($selector == 'Prestation')$string = $string . self::renderPrestation();
        if ($selector == 'Prestations')$string = $string . self::renderPrestations();
        if ($selector == 'Categories')$string = $string . self::renderCategories();
        if ($selector == 'Categorie')$string = $string . self::renderCategorie();
        if ($selector == 'Login')$string = $string . self::renderLogin();
        if ($selector == 'Register')$string = $string . self::renderRegister();
        if ($selector == 'Boxes')$string = $string . self::renderBoxes();
        if ($selector == 'Box')$string = $string . self::renderBox();
        if ($selector == 'FormBox')$string = $string . self::renderFormBox();
        if ($selector == 'SummaryBox')$string = $string . self::renderSummaryBox();
        if ($selector == 'PayBox')$string = $string . self::renderBoxPay();
        if ($selector == 'Profil')$string = $string . self::renderProfil();
        if ($selector == 'ProfilView')$string = $string . self::renderProfilView();
        if ($selector == 'Admin')$string = $string . self::renderAdmin();
        if ($selector == 'NewPrestation')$string = $string . self::renderNewPrestation();
        if ($selector == 'AdminPrestation')$string = $string . self::renderAdminPrestation();
        $string = $string ."</article></section><footer>".self::renderFooter()."</footer>";
        return $string;
    }
}