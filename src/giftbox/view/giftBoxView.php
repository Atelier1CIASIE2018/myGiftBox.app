<?php
namespace giftbox\view;
class GiftBoxView extends \mf\view\AbstractView {
    private $router;

    public function __construct( $data ){
        parent::__construct($data);
        $this->router = new \mf\router\Router();
    }

    private function renderHeader(){
        /*
         affiche "My Gift Box App" qui redirige vers l'accueil du site

        SI un utilisateur est connecté afficher les bouttons :
            Mon profil
            Mes coffrets
            Créer coffret
            Deconnexion

        SINON
            afficher les bouttons :
                Inscription
                Connexion
        */

        $res = "<div><a href='".$this->router->urlFor("/home/", [])."'><h1>My Gift Box App</h1></a>";

        if(isset($_SESSION["user_login"])){
            $res .= "
            <div><a href='".$this->router->urlFor("/logout/", [])."'><button>Déconnexion</button></a></div>
            <div><a href='".$this->router->urlFor("/profile/", [])."'><button>Mon Profil</button></a></div>
            <div><a href='".$this->router->urlFor("/box/new/", [])."'><button>Créer coffret</button></a></div>
            <div><a href='".$this->router->urlFor("/boxes/", [])."'><button>Mes coffrets</button></a></div>
            
            
            ";
        }
        else{
            $res .= "<div><a href='".$this->router->urlFor("/login/",[])."'><button>Connexion</button></a></div>
            <div><a href='".$this->router->urlFor("/register/",[])."'><button>Inscription</button></a></div>
            ";
        }
        $res = $res . "
        <div><a href='".$this->router->urlFor("/categories/", [])."'><button>Liste des catégories</button></a></div>
        <div><a href='".$this->router->urlFor("/prestations/", [])."'><button>Liste des prestations</button></a></div></div>";
        return $res;
    }
    
    private function renderFooter(){

        // affiche cette ligne a la fin de chacune des pages

        return 'Atelier 1 CIASIE 2018 Toussaint Maillard Guebel &copy;2018';
    }
    
    private function renderHome(){
        /*
        Initialise les variable session box et prestations a ""

        affiche les 3 dernieres prestations ajouté par l'administrateur 
        avec leur nom - prix - activité - image - description

        possibilité de cliquer sur nom - prix - image - description pour afficher les détails d'une préstation

        possibilité de cliquer sur le nom de l'activité pour faire appraitre toute les préstations d'une activité

        possibilité d'ajouter une préstation a un coffret a l'aide du boutton "+"

        */
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
                <a href='".$urlCategorie."'><p>".$this->data["categories"][$value["IdCategorie"] - 1]."</p></a>
                <a href='".$urlPrestation."'>
                    <img src ='/giftBox/img/".$value['Img']."'>
                    <p>".$value['Description']."</p>
                </a>
            </div><hr>";
        }
        $res .= " <a href='".$this->router->urlFor("/prestations/",[])."'><button>Voir plus...</button></a></div></div>";
        return $res;   
    }

    private function renderPrestation(){
        /*
        initialise les variables session box et prestations a ""

        affiche un préstation précise avec son nom - description - prix - image - activité

        possibilité d'ajouter une préstation a un coffret a l'aide du boutton "+"
        */
        $res = "<div id='prestation'>
            <p>".$this->data['Nom']."</p>
            <p>".$this->data['Prix']." €</p>
            <img src ='/giftBox/img/".$this->data['Img']."'>
            <p>".$this->data['Description']."</p>";
        if(isset($_SESSION["newPrestation"])){
            $res .= "<div><a href='".$this->router->urlFor("/box/add/",['Id' => $this->data['Id']])."'><button>+</button></a></div>";
        }
        else{
            $res .= "<div></div>";
        }
        $res .= "</div>";
        return $res;  // FINI
    }

    private function renderPrestations(){
        /*
        initialise les variables session box et prestations a ""
        
        affiche un catalogue de toute les préstations avec leur nom - prix - activité - image - description

        possibilité de cliquer sur nom - prix - image - description pour afficher les détails d'une préstation

        possibilité de cliquer sur le nom de l'activité pour faire appraitre toute les préstations d'une activité

        possibilité d'ajouter une préstation a un coffret a l'aide du boutton "+"

        */
        $res = "<div id='prestations'>";
        if($this->data["page"] == "/prestations/"){
            $res .= "<a href='".$this->router->urlFor($this->data["page"], ["order"=>"asc"])."'><button>Prix croissants</button></a>
                <a href='".$this->router->urlFor($this->data["page"], ["order"=>"desc"])."'><button>Prix décroissants</button></a>";
        }
        if($this->data["page"] == "/categorie/"){
            $res .= "<a href='".$this->router->urlFor($this->data["page"], ["Id"=>$_GET["Id"], "order"=>"asc"])."'><button>Prix croissants</button></a>
            <a href='".$this->router->urlFor($this->data["page"], ["Id"=>$_GET["Id"], "order"=>"desc"])."'><button>Prix décroissants</button></a>";
        }
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
                    <img src ='/giftBox/img/".$value['Img']."'>
                    <p>".$value['Description']."</p>
                </a>";
            if(isset($_SESSION["newPrestation"])){
                $res .= "<span><a href='".$this->router->urlFor("/box/add/",['Id' => $value['Id']])."'><button>+</button></a></span>";
            }
            else{
                $res .= "<span></span>";
            }
            $res .= "</div>";
        }
        $res .= "</div>";
        return $res;
    }

    private function renderCategories(){
        /*
        affiche toute les catégories de la bdd
        possibilité de cliquer sur une catégorie pour afficher toute ses préstations
        */
        $res = "<div id='categories'>";
        foreach ($this->data as $value) {
            $urlCategorie = $this->router->urlfor('/categorie/', ['Id'=>$value['Id']]);
            $res .= "<div>
                <a href='".$urlCategorie."'<p>".$value['Nom']."</p></a>
            </div>";
        }
        $res = $res."</div>";
        return $res;
    }

    private function renderLogin(){

        /*
        affiche un formulaire de connexion
        */

        return "<h1> Connexion </h1>
                <form id='log' name='connexion' method='POST' action='".$this->router->urlFor("/loginPost/",[])."'>
                <p>Login : </p><input tpye='text' name='login'/>
                <p>Mot de passe : </p><input type='password' name='mdp'/>
                <input type='submit' name='valider' value='Valider'/>
                </form>";
    }

    private function renderRegister(){

        /*
        affiche un formulaire d'inscription
        */

        return "<h1> Inscription </h1>
                <form id='log' name='inscription' method='POST' action='".$this->router->urlFor("/registerPost/",[])."'>
                <p>Prénom : </p><input tpye='text' name='prenom'/>
                <p>Nom : </p><input type='text' name='nom'/>
                <p>E-mail : </p><input type='text' name='mail'/>
                <p>Mot de passe : </p><input type='password' name='mdp'/>                
                <input type='submit' name='valider' value='Valider'/>
                </form>";
    }

    private function renderBoxes(){

        /*
        affiche touts les coffrets d'un utilisateur
        selon l'état du coffret plusiquers action son possible :
        
            etat = 1 :
                affiche les bouttons Aperçu - Modifier - Valider - Payer
            etat = 2
                affiche les bouttons Aperçu - Payer
            etat = 3 / 4 / 5 :
                affiche le boutton Aperçu et son état
        */

        $res = "<div id='boxes'>";
        foreach ($this->data as $value) {
            $urlBox =  $this->router->urlfor('/box/', ['Id'=>$value['Id']]);
            $urlSummaryBox = $this->router->urlfor('/box/summary/', ['Id'=>$value["Id"]]);
            $aAperçu = "<a href='".$urlBox."'><button>Aperçu</button></a>";
            $res .= "<p>".$value['Nom'];
            switch ($value['Etat']){
                case 1:
                    $res .= "</p><div>".$aAperçu."
                    <a href='".$this->router->urlfor('/box/', ['Id'=>$value['Id'], "update"=>null])."'><button>Modifier</button></a>
                    <a href='".$this->router->urlfor('/box/confirm/', ['Id'=>$value["Id"]])."'><button>Valider</button></a>
                    <a href='".$urlSummaryBox."'><button>Payer</button></a></div>";
                    break;
                case 2:
                    $res .= " (Validé)</p><div>".$aAperçu."
                    <a href='".$urlSummaryBox."'><button>Payer</button></a></div>";
                    break;
                default:                    
                    if($value["Etat"] == 3){
                        $res .= " (Payé)</p><div>".$aAperçu."
                            <a href='".$this->router->urlfor('/box/url/', ['Id'=>$value['Id']])."'><button>Générer l'url</button></a></div>";
                    }
                    if($value["Etat"] == 4){
                        $res .= " (Transmis)</p><div>".$aAperçu."</div>";
                    }
                    if($value["Etat"] == 5){
                        $res .= " (Ouvert)</p><div>".$aAperçu."</div>";
                    }
                    
                    break;
            }          
        }
        $res .= "</div>";
        return $res;
    }

    private function renderBox(){
        $res = "<div id='viewBox'>
            <p>Nom : ".$this->data["box"]["Nom"]."</p>
            <p>Message : ".$this->data["box"]["Message"]."</p>
            <p>Date : ".$this->data["box"]["Date"]."</p>";
        if(!empty($this->data["prestations"])){
            foreach ($this->data['prestations'] as $value) {
                $urlPrestation = $this->router->urlfor('/prestation/', ['Id'=>$value['Id']]);
                $urlCategorie = $this->router->urlfor('/categorie/', ['Id'=>$value['IdCategorie']]);
                $res .= "<div>
                        <p>Nom: ".$value['Nom']."</p>
                        <p>Prix: ".$value['Prix']." €</p>
                        <p>Catégorie: ".$this->data["categories"][$value["IdCategorie"] - 1]."</p>
                        <img src ='/giftBox/img/".$value['Img']."'>
                        <p>".$value['Description']."</p>
                    </div>";
            }
            $urlSummaryBox = $this->router->urlfor('/box/summary/', ['Id'=>$this->data["box"]['Id']]);
            switch($this->data["box"]["Etat"]){
                case 1:
                    $res .= "<div><a href='".$this->router->urlfor('/box/', ['Id'=>$this->data["box"]['Id']])."&update'><button>Modifier</button></a>
                    <a href='".$this->router->urlfor('/box/confirm/', ['Id'=>$this->data["box"]["Id"]])."'><button>Valider</button></a>
                    <a href='".$urlSummaryBox."'><button>Payer</button></a><div>";
                    break;
                case 2:
                    $res .= "<div><a href='".$urlSummaryBox."'><button>Payer</button></a><div>";
                    break;
                default:
                    if($this->data["box"]["Url"] != ""){
                        $res .= "<p>Url: ".$this->data["box"]["Url"]."</p>";
                    }
                    else{
                        $res .= "<a href='".$this->router->urlfor('/box/receiver/', ['Id'=>$this->data["box"]["Id"]])."'><button>Générer l'url</button></a>";
                    }                 
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
                <p>Nom : </p> <input type='text' name='nom' value='";
        if(isset($this->data["box"]["Nom"])){
            $res .= $this->data["box"]["Nom"];
        }
        $res .= "'/>
            <p>Message : </p><textarea name='Texte' rows='10' cols='50'";
        if(isset($this->data['box']["Message"]) && $this->data['box']['Message'] != ""){
            $res .= ">".$this->data['box']['Message'];
        }
        else{
            $res .= " placeholder='Veuillez entrer votre message pour le destinataire'>";
        }
        $res .= "</textarea>
            <p>Choix de la date d'activation du coffret, la date d'aujourd'hui activera le coffret lors de la validation</p>
            <input type='date' name='date' min='".date("Y-m-d")."' value='";
        if(isset($this->data["box"]["Date"]) && $this->data["box"]["Date"] != null){
            $res .= $this->data["box"]["Date"]."'>";
        }
        else{
            $res .= date("Y-m-d")."'>";
        }
        $res .= "<input type='submit' name='choixForm' value='Ajouter une prestation'/>";
        if(isset($this->data['prestations']) && !empty($this->data["prestations"])){
            foreach ($this->data['prestations'] as $value) {
                $res .= "<div>
                    <p>Titre: ".$value['Nom']."</p>
                    <p>Prix: ".$value['Prix']." €</p>
                    <p>Catégorie: ".$this->data["categories"][$value["IdCategorie"] - 1]."</p>
                    <a href='".$this->router->urlFor("/box/remove/",['Id' =>$value['Id']])."'>X</a>
                    <img src ='/giftBox/img/".$value['Img']."'>
                    <p>".$value['Description']."</p>
                </div>";
            }
        }
        if(isset($this->data['prestations'][0])){
            $total = 0;
            foreach ($this->data['prestations'] as $value) {
                $total += $value['Prix'];
            }
            $res .= "<h2> Tarif : ".$total." € </h2>";
        }
        else{
            $res .= "<h2> Tarif : 00,00 € </h2>";
        }
        if(isset($this->data["box"]["Id"])){
            $res .= "<input type='submit' name='choixForm' value='Sauvegarder'/>";
        }
        if(isset($this->data["box"]["Etat"]) && $this->data["box"]["Etat"] != 0){
            $res .= "<input type='submit' name='choixForm' value='Valider'/>";
        }
        $res .= "</form>";
        return $res;
    }

    private function renderSummaryBox(){
        $res = "<div><h1>Récapitulatif du coffret: </h1><div id='summary'>";
        $total = 0;
        foreach ($this->data["prestations"] as $value) {
            $router = new \mf\router\Router();
            $urlPrestation = $this->router->urlfor('/prestation/', ['Id'=>$value['Id']]);
            $urlCategorie = $this->router->urlfor('/categorie/', ['Id'=>$value['IdCategorie']]);
            $res = $res . "<div>
                <p>Nom : ".$value['Nom']."</p>
                <p>Prix : ".$value['Prix']." €</p>
            </div>";
            $total += $value["Prix"];
        }
        $res .= "<p>Total: ".$total." €</p></div>";
        if($_SESSION['box']['Etat'] > 2){
            $res .= "<p>Url du coffret pour le destinataire: ".$this->data["box"]["Url"]."</p>";
        }
        else{
            $res .= "<div><a href='".$this->router->urlFor("/box/pay/",['Id' => $_SESSION['box']['Id']])."'><button>Passer au paiement</button></a></div>";      
        }
        $res .= "</div>";
        return $res;
    }

    private function renderBoxPay(){
        $res = "<div id='achat' >";
        $total = 0;
        foreach ($this->data["prestations"] as $value) {
            $total += $value['Prix'];
        }
        $res .= "<p>Tarif total : ".$total." € </p>
            <form name='acheter' method='POST' action='".$this->router->urlFor("/box/pay/send/",['Id' => $this->data['box']['Id']])."'>
                <div><img src='/giftBox/img/modePaiement/paypal.jpg'><br />
                <input type='radio' name='test' value='paypal' checked /></div>
                <div><img src='/giftBox/img/modePaiement/visa.png'><br />
                <input type='radio' name='test' value='visa'/></div>
                <div><img src='/giftBox/img/modePaiement/mastercard.png'><br />
                <input type='radio' name='test' value='mastercard'/></div>
                <div><img src='/giftBox/img/modePaiement/cartebleu.jpeg'><br />
                <input type='radio' name='test' value='cartebleu'/></div>
                <input type='submit' name='payer' value='Payer'/>
            </form></div>";
        return $res;
    }

    private function renderProfil(){
        $res = "<div id='profile'><h1> Voici votre profil : </h1>
            <p>Nom : ".$this->data->Nom."</p>
            <p>Prénom : ".$this->data->Prenom."</p>
            <p>E-mail : ".$this->data->Email."</p>
            <a href='".$this->router->urlFor("/profile/view/",[])."'><button>Modifier</button></a>";
        return $res;
    }

    private function renderProfilView(){
        $res = "<form method='POST' action='".$this->router->urlFor("/profile/update/", [])."' id='viewProfile'><h1>Modification de votre profil : </h1> 
            <p>Nom : </p><input type='text' name='nom' value='".$this->data->Nom."' />
            <p>Prénom : </p><input type='text' name='prenom' value='".$this->data->Prenom."' />
            <p>E-mail : </p><input type='email' name='email' value='".$this->data->Email."' />
            <p>Mot de passe : </p><input type='password' name='mdp' value='' />
            <p>Confirmation mot de passe : </p><input type='password' name='mdpconfirm' value='' />
            <input type='submit' name='envoyer'/></form>";
        return $res;
    }

    private function renderAdmin(){
        $res = "<a href='".$this->router->urlFor("/admin/prestations/new/",[])."'><button>Ajouter une préstation</button></a><div>";
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
                    <img src ='/giftBox/img/".$value['Img']."'>
                    <p>".$value['Description']."</p>
                </a>
                <a href='".$this->router->urlFor("/register/",[])."'><button>Modifier</button></a>
                <a href='".$this->router->urlFor("/admin/prestation/remove/",[])."'><button>X</button></a></div><hr>";
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
        return "<h1> Voici votre coffret :</h1>
                <form name='update' method='POST'>
                    <textarea
                    <input type='textarea' name='nom' value='".$this->data['Nom']."'/> <br/>
                    <p>Description : </p><input type='text' name='nom' value='".$this->data['Description']."'/> <br/>
                    <p>Prix : </p><input type='text' name='nom' value='".$this->data['Prix']."'/> <br/>
                    <p>Image : </p><input type='file' name='image'/><br/>
                </form>";
    }

    private function renderDestinataire(){
        $res = "<h1>Contenu du coffret</h1>";
        $res .= "<p>Nom : ".$this->data["box"]["Nom"]."</p>
            <p>Message : ".$this->data["box"]["Message"]."</p>";
        if($this->data["box"]["MessageRetour"] == null){
            $res .= "<form name='update' method='POST' action='".$this->router->urlFor("/box/receiver/message/", ["Id"=>$this->data["box"]["Id"]])."'>
                <textarea name='texte' rows='10' cols='50' placeholder='Veuillez saisir votre message de retour'></textarea>
                <input type='submit' name='message' value='Envoyer'/>
                </form>";
        }
        else{
            $res .= "<p>Votre message de retour: ".$this->data["box"]["MessageRetour"]."</p>";
        }
        foreach ($this->data['prestations'] as $value){
            $res .= "<div><p>Nom: ".$value['Nom']."</p>
                    <img src ='/giftBox/img/".$value['Img']."'>
                    <p>".$value['Description']."</p>
                    <a href='".$this->router->urlfor('/prestation/', ['Id'=>$value['Id']])."'><button>Visualiser la prestation</button></a>
                </div>";
        }
        return $res;
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
        if ($selector == 'RenderDestinataire')$string = $string . self::renderDestinataire();
        $string = $string ."</article></section><footer>".self::renderFooter()."</footer>";
        return $string;
    }
}