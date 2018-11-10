<?php
namespace giftbox\view;
class GiftBoxView extends \mf\view\AbstractView {
    private $router;

    public function __construct( $data ){
        parent::__construct($data);
        $this->router = new \mf\router\Router();
    }

    private function renderHeader(){
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
        $res .= "<div><a href='".$this->router->urlFor("/categories/", [])."'><button>Liste des catégories</button></a></div>
        <div><a href='".$this->router->urlFor("/prestations/", [])."'><button>Liste des prestations</button></a></div>";
        if(isset($_SESSION["user_login"]->level) && $_SESSION["user_login"]->level >= \giftbox\auth\giftBoxAuthentification::ACCESS_LEVEL_ADMIN){
            $res .= "<div><a href='".$this->router->urlFor("/admin/", [])."'><button>Administration</button></a></div></div>";
        }
        $res .= "</div>";
        return $res;
    }
    
    private function renderFooter(){
        return 'Atelier 1 CIASIE 2018 Toussaint Maillard Guebel &copy;2018';
    }
    
    private function renderHome(){
        $res = "<div id='home'> 
                <img src='".$this->router->urlFor("/img/", [])."cadeau.jpg' >
                <div><h1>Nouveautés : </h1>";
        foreach ($this->data["prestations"] as $prestation) {
            $urlPrestation = $this->router->urlfor('/prestation/', ['id' => $prestation->id]);
            $res .= "<div>
                <a href='".$urlPrestation."'>
                    <p>".$prestation->nom."</p>
                    <p>".$prestation->prix." €</p>
                </a>
                <a href='".$this->router->urlfor('/categorie/', ['id' => $prestation->idCategorie])."'><p>".$this->data["categories"][$prestation->idCategorie - 1]."</p></a>
                <a href='".$urlPrestation."'>
                    <img src ='".$this->router->urlFor("/img/", []).$prestation->img."'>
                    <p>".$prestation->description."</p>
                </a>
            </div><hr>";
        }
        $res .= " <a href='".$this->router->urlFor("/prestations/",[])."'><button>Voir plus...</button></a></div></div>";
        return $res;   
    }

    private function renderPrestation(){
        $res = "<div id='prestation'>
            <p>".$this->data->nom."</p>
            <p>".$this->data->prix." €</p>
            <img src ='".$this->router->urlFor("/img/", []).$this->data->img."'>
            <p>".$this->data->description."</p>";
        if(isset($_SESSION["newPrestation"])){
            $res .= "<div><a href='".$this->router->urlFor("/box/add/",['id' => $this->data->id])."'><button>+</button></a></div>";
        }
        else{
            $res .= "<div></div>";
        }
        $res .= "</div>";
        return $res;  // FINI
    }

    private function renderPrestations(){
        $res = "<div id='prestations'>";
        if($this->data["page"] == "/prestations/"){
            $res .= "<a href='".$this->router->urlFor($this->data["page"], ["order" => "asc"])."'><button>Prix croissants</button></a>
                <a href='".$this->router->urlFor($this->data["page"], ["order" => "desc"])."'><button>Prix décroissants</button></a>";
        }
        if($this->data["page"] == "/categorie/"){
            $res .= "<a href='".$this->router->urlFor($this->data["page"], ["id" => $_GET["id"], "order" => "asc"])."'><button>Prix croissants</button></a>
            <a href='".$this->router->urlFor($this->data["page"], ["id" => $_GET["id"], "order" => "desc"])."'><button>Prix décroissants</button></a>";
        }
        foreach ($this->data["prestations"] as $prestation) {
            $urlPrestation = $this->router->urlfor('/prestation/', ['id' => $prestation['id']]);
            $res .= "<div>
                <a href='".$urlPrestation."'>
                    <p>".$prestation->nom."</p>
                    <p>".$prestation->prix." €</p>
                </a>
                <p><a href='".$this->router->urlfor('/categorie/', ['id' => $prestation['idCategorie']])."'>".$this->data["categories"][$prestation->idCategorie - 1]."</p>
                <a href='".$urlPrestation."'>
                    <img src ='".$this->router->urlFor("/img/", []).$prestation->img."'>
                    <p>".$prestation->description."</p>
                </a>";
            if(isset($_SESSION["newPrestation"])){
                $res .= "<span><a href='".$this->router->urlFor("/box/add/",['id' => $prestation->id])."'><button>+</button></a></span>";
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
        $res = "<div id='categories'>";
        foreach ($this->data as $categorie) {
            $urlCategorie = $this->router->urlfor('/categorie/', ['id' => $categorie->id]);
            $res .= "<div>
                <a href='".$urlCategorie."'<p>".$categorie->nom."</p></a>
            </div>";
        }
        $res = $res."</div>";
        return $res;
    }

    private function renderLogin(){
        return "<h1> Connexion </h1>
                <form id='log' name='connexion' method='POST' action='".$this->router->urlFor("/loginPost/",[])."'>
                <p>Login : </p><input tpye='text' name='login'/>
                <p>Mot de passe : </p><input type='password' name='mdp'/>
                <input type='submit' name='valider' value='Valider'/>
                </form>";
    }

    private function renderRegister(){
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
        $res = "<div id='boxes'>";
        foreach ($this->data as $box) {
            $urlBox =  $this->router->urlfor('/box/', ['id' => $box->id]);
            $urlSummaryBox = $this->router->urlfor('/box/summary/', ['id'=>$box->id]);
            $aAperçu = "<a href='".$urlBox."'><button>Aperçu</button></a>";
            $res .= "<p>".$box->nom;
            switch ($box->etat){
                case 1:
                    $res .= "</p><div>".$aAperçu."
                    <a href='".$this->router->urlfor('/box/', ['id'=>$box->id, "update"=>null])."'><button>Modifier</button></a>
                    <a href='".$this->router->urlfor('/box/confirm/', ['id'=>$box->id])."'><button>Valider</button></a>
                    <a href='".$urlSummaryBox."'><button>Payer</button></a></div>";
                    break;
                case 2:
                    $res .= " (Validé)</p><div>".$aAperçu."
                    <a href='".$urlSummaryBox."'><button>Payer</button></a></div>";
                    break;
                default:             
                    if($box->etat == 3){
                        $res .= " (Payé)</p><div>".$aAperçu."
                            <a href='".$this->router->urlfor('/box/url/', ['id'=>$box->id])."'><button>Générer l'url</button></a></div>";
                    }
                    if($box->etat == 4){
                        $res .= " (Transmis)</p><div>".$aAperçu."</div>";
                    }
                    if($box->etat == 5){
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
            <p>Nom : ".$this->data["box"]->nom."</p>
            <p>Message : ".$this->data["box"]->message."</p>
            <p>Date : ".$this->data["box"]->date."</p>";
        if(!empty($this->data["prestations"])){
            foreach ($this->data['prestations'] as $prestation){
                $res .= "<div>
                        <p>Nom: ".$prestation->nom."</p>
                        <p>Prix: ".$prestation->prix." €</p>
                        <p>Catégorie: ".$this->data["categories"][$prestation->idCategorie - 1]."</p>
                        <img src ='".$this->router->urlFor("/img/", []).$prestation->img."'>
                        <p>".$prestation->description."</p>
                    </div>";
            }
            $urlSummaryBox = $this->router->urlfor('/box/summary/', ['id'=>$this->data["box"]->id]);
            switch($this->data["box"]->etat){
                case 1:
                    $res .= "<div><a href='".$this->router->urlfor('/box/', ['id'=>$this->data["box"]->id])."&update'><button>Modifier</button></a>
                    <a href='".$this->router->urlfor('/box/confirm/', ['id'=>$this->data["box"]->id])."'><button>Valider</button></a>
                    <a href='".$urlSummaryBox."'><button>Payer</button></a><div>";
                    break;
                case 2:
                    $res .= "<div><a href='".$urlSummaryBox."'><button>Payer</button></a><div>";
                    break;
                default:
                    if($this->data["box"]->url != ""){
                        $res .= "<p>Url: ".$this->data["box"]->url."</p>";
                    }
                    else{
                        $res .= "<a href='".$this->router->urlfor('/box/url/', ['id'=>$this->data["box"]->id])."'><button>Générer l'url</button></a>";
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
        if(isset($this->data["box"]->nom)){
            $res .= $this->data["box"]->nom;
        }
        $res .= "'/>
            <p>Message : </p><textarea name='texte' rows='10' cols='50'";
        if(isset($this->data['box']->message) && $this->data['box']->message != ""){
            $res .= ">".$this->data['box']->message;
        }
        else{
            $res .= " placeholder='Veuillez entrer votre message pour le destinataire'>";
        }
        $res .= "</textarea>
            <p>Choix de la date d'activation du coffret, la date d'aujourd'hui activera le coffret lors de la validation</p>
            <input type='date' name='date' min='".date("Y-m-d")."' value='";
        if(isset($this->data["box"]->date) && $this->data["box"]->date != null){
            $res .= $this->data["box"]->date."'>";
        }
        else{
            $res .= date("Y-m-d")."'>";
        }
        $res .= "<input type='submit' name='choixForm' value='Ajouter une prestation'/>";
        if(isset($this->data['prestations']) && !empty($this->data["prestations"])){
            foreach ($this->data['prestations'] as $prestation) {
                $res .= "<div>
                    <p>Titre: ".$prestation->nom."</p>
                    <p>Prix: ".$prestation->prix." €</p>
                    <p>Catégorie: ".$this->data["categories"][$prestation->idCategorie - 1]."</p>
                    <a href='".$this->router->urlFor("/box/remove/",['id' => $prestation->id])."'>X</a>
                    <img src ='/giftBox/img/".$prestation->img."'>
                    <p>".$prestation->description."</p>
                </div>";
            }
        }
        if(isset($this->data['prestations'][0])){
            $total = 0;
            foreach ($this->data['prestations'] as $prestation) {
                $total += $prestation->prix;
            }
            $res .= "<h2> Tarif : ".$total." € </h2>";
        }
        else{
            $res .= "<h2> Tarif : 00,00 € </h2>";
        }
        if(isset($_SESSION["box"]->id)){
            $res .= "<input type='submit' name='choixForm' value='Sauvegarder'/>";
        }
        if(isset($this->data["box"]->id) && $this->data["box"]->etat != 0){
            $res .= "<input type='submit' name='choixForm' value='Valider'/>";
        }
        $res .= "</form>";
        return $res;
    }

    private function renderSummaryBox(){
        $res = "<div><h1>Récapitulatif du coffret: </h1><div id='summary'>";
        $total = 0;
        foreach ($this->data["prestations"] as $prestation) {
            $router = new \mf\router\Router();
            $urlPrestation = $this->router->urlfor('/prestation/', ['id' => $prestation->id]);
            $urlCategorie = $this->router->urlfor('/categorie/', ['id' => $prestation->idCategorie]);
            $res = $res . "<div>
                <p>Nom : ".$prestation->nom."</p>
                <p>Prix : ".$prestation->prix." €</p>
            </div>";
            $total += $prestation->prix;
        }
        $res .= "<p>Total: ".$total." €</p></div>";
        if($_SESSION['box']->etat > 2){
            $res .= "<p>Url du coffret pour le destinataire: ".$this->data["box"]->url."</p>";
        }
        else{
            $res .= "<div><a href='".$this->router->urlFor("/box/pay/",['id' => $_SESSION['box']->id])."'><button>Passer au paiement</button></a></div>";      
        }
        $res .= "</div>";
        return $res;
    }

    private function renderBoxPay(){
        $res = "<div id='achat' >";
        $total = 0;
        foreach ($this->data["prestations"] as $prestation) {
            $total += $prestation['Prix'];
        }
        $res .= "<p>Tarif total : ".$total." € </p>
            <form name='acheter' method='POST' action='".$this->router->urlFor("/box/pay/send/",['id' => $this->data['box']->id])."'>
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
            <p>Nom : ".$this->data->nom."</p>
            <p>Prénom : ".$this->data->prenom."</p>
            <p>E-mail : ".$this->data->email."</p>
            <a href='".$this->router->urlFor("/profile/view/",[])."'><button>Modifier</button></a>";
        return $res;
    }

    private function renderProfilView(){
        $res = "<form method='POST' action='".$this->router->urlFor("/profile/update/", [])."' id='viewProfile'><h1>Modification de votre profil : </h1> 
            <p>Nom : </p><input type='text' name='nom' value='".$this->data->nom."' />
            <p>Prénom : </p><input type='text' name='prenom' value='".$this->data->prenom."' />
            <p>E-mail : </p><input type='email' name='email' value='".$this->data->email."' />
            <p>Mot de passe : </p><input type='password' name='mdp' value='' />
            <p>Confirmation mot de passe : </p><input type='password' name='mdpconfirm' value='' />
            <input type='submit' name='envoyer'/></form>";
        return $res;
    }

    private function renderAdmin(){
        $res = "<h1>CETTE PARTIE PEUT NE PAS ETRE COMPLETEMENT FONCTIONNELLE</h1>
            <a href='".$this->router->urlFor("/admin/prestation/new/", [])."'><button>Ajouter une préstation</button></a><div>";
        foreach ($this->data['prestations'] as $prestation) {
            $router = new \mf\router\Router();
            $urlPrestation = $this->router->urlfor('/prestation/', ['id'=>$prestation->id]);
             $res = $res . "<div>
            <a href='".$urlPrestation."'>
                <p>".$prestation->nom."</p>
                <p>".$prestation->prix." €</p>
            </a>
            <p><a href='".$this->router->urlfor('/categorie/', ['id'=>$prestation->idCategorie])."'>".$this->data["categories"][$prestation->idCategorie - 1]."</a></p>
            <a href='".$urlPrestation."'>
                <img src ='".$this->router->urlFor("/img/", []).$prestation->img."'>
                <p>".$prestation->description."</p>
            </a>
            <a href='".$this->router->urlFor("/admin/prestation/",["id" => $prestation->id])."'><button>Modifier</button></a>
            <a href='".$this->router->urlFor("/admin/prestation/remove/",[])."'><button>X</button></a></div><hr>";
        }
        return $res;
    }

    private function renderNewPrestation(){
        $res =  "<h1> Ajout d'une préstation : </h1>
            <form name='ajout' method='POST' action='".$this->router->urlFor("/admin/prestation/post/", [])."'>
                <p>Categorie : </p><select name='categorie'>";
        foreach ($this->data["categories"] as $categorie){
            $res .= "<option value='".$categorie->id."'>".$categorie->nom."</option>";
        }
        $res .= "</select>
                <p>Nom : </p><input type='text' name='nom'/>
                <p>Description : </p><textarea name='description'cols=50 rows=10></textarea>
                <p>Prix : </p><input type='number' name='prix' min=0 step='1' pattern='^\d*(\.\d{0})?$'/>
                <p>Image : </p><input type='file' name='image'/><br>
                <input type='submit' name='valider' value='Ajouter'/>
            </form>";
        return $res;
    }

    private function renderAdminPrestation(){
        $res = "<h1> Voici votre coffret :</h1>
                <form name='update' method='POST'>
                    <textarea name='nom'>".$this->data->nom."</textarea>
                    <p>Description : </p><input type='text' name='nom' value='".$this->data->description."'/> <br/>
                    <p>Prix : </p><input type='text' name='nom' value='".$this->data->prix."'/> <br/>
                    <p>Image : </p><input type='file' name='image'/><br/>
                </form>";
        return $res;
    }

    private function renderDestinataire(){
        $res = "<h1>Contenu du coffret</h1>";
        $res .= "<p>Nom : ".$this->data["box"]->nom."</p>
            <p>Message : ".$this->data["box"]->message."</p>";
        if($this->data["box"]->messageRetour == null){
            $res .= "<form name='update' method='POST' action='".$this->router->urlFor("/box/receiver/message/", ["id" => $this->data["box"]->id])."'>
                <textarea name='texte' rows='10' cols='50' placeholder='Veuillez saisir votre message de retour'></textarea>
                <input type='submit' name='message' value='Envoyer'/>
                </form>";
        }
        else{
            $res .= "<p>Votre message de retour: ".$this->data["box"]->messageRetour."</p>";
        }
        foreach ($this->data['prestations'] as $prestation){
            $res .= "<div><p>Nom: ".$prestation->nom."</p>
                    <img src ='".$this->router->urlFor("/img/", []).$prestation->img."'>
                    <p>".$prestation->description."</p>
                    <a href='".$this->router->urlfor('/prestation/', ['id' => $prestation->id])."'><button>Visualiser la prestation</button></a>
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