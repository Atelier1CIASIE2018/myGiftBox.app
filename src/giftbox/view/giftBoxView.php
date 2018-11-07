<?php

namespace giftbox\view;

class GiftBoxView extends \mf\view\AbstractView {
    private $router;

    public function __construct( $data ){
        parent::__construct($data);
        $this->router = new \mf\router\Router();
    }

    private function renderHeader(){
        return '<head> <link rel="stylesheet" type="text/css" href="/html/css/style.css"> </head>
                <h1>My Gift Box App</h1>';
    }
    
    private function renderFooter(){
        return 'Atelier 1 CIASIE 2018 Toussaint Maillard Guebel &copy;2018';
    }
    
    private function renderHome(){
        $res = "<div> <h1> Nouveauté : </h1>";
        foreach ($this->data["prestations"] as $value) {
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
            </div><hr>";
        }
        $res = $res . " <a href='main.php/prestations/'><button>Voir plus...</button></a></div>";
        return $res;
    }

    private function renderPrestation(){
        $res = "<div>
            <p>".$this->data['Nom']."</p>
            <p>".$this->data['Prix']." €</p>
            <img src ='/giftBox/img/".$this->data['Img']."' width='200'>
            <p>".$this->data['Description']."</p>
        </div>";
        return $res;
    }

    private function renderPrestations(){        $res = "<div>";
        foreach ($this->data["prestations"] as $value) {
            $urlPrestation = $this->router->urlfor('/prestation/', ['Id'=>$value['Id']]);
            $urlCategorie = $this->router->urlfor('/categorie/', ['Id'=>$value['IdCategorie']]);
            $res .="<div>
                <a href='".$urlPrestation."'>
                    <p>".$value['Nom']."</p>
                    <p>".$value['Prix']."</p>
                </a>
                <p><a href='".$urlCategorie."'>".$this->data["categories"][$value["IdCategorie"] - 1]."</p>
                <a href='".$urlPrestation."'>
                    <img src ='/giftBox/img/".$value['Img']."' width='200'>
                    <p>".$value['Description']."</p>
                </a>
            </div><hr>";
        }
        $res .= "</div>";
        return $res;
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
        return $res;
    }

    private function renderCategorie(){
        $res = "<div>";
        foreach ($this->data as $value1) {            
            $urlPrestation = $this->router->urlfor('/prestation/', ['Id'=>$value1['Id']]);
            $res = $res . "<div>
                <a href='".$urlPrestation."'>
                    <p>".$value1['Nom']."</p>
                    <p>".$value1['Prix']." €</p>
                    <img src ='/giftBox/img/".$value1['Img']."' width='200'>
                    <p>".$value1['Description']."</p>
                </a>
            </div><hr>";
        }
        $res = $res."</div>";
        return $res;
    }

    private function renderLogin(){
        return "<h1> Connexion </h1>
                <form name='connexion' method='POST' action='/loginPost/'>
                Login : <input tpye='text' name='login'/><br/>
                Mot de passe : <input type='text' name='mdp'/><br/>
                <input type='submit' name='valider' value='Valider'/>
                </form>";
    }

    private function renderRegister(){
        return "<h1> Inscription </h1>
                <form name='inscription' method='POST' action='/registerPost/'>
                Prénom : <input tpye='text' name='prenom'/><br/>
                Nom : <input type='text' name='nom'/><br/>
                Login : <input type='text' name='log'/><br/>
                Mot de passe : <input type='text' name='mdp'/><br/>
                E-mail : <input type='text' name='mail'/><br/>
                <input type='submit' name='valider' value='Valider'/>
                </form>";
    }

    private function renderBoxes(){
        $res = "<div>";
        foreach ($this->data as $value) {
            $urlBox =  $this->router->urlfor('/box/', ['Id'=>$value['Id']]);
            $urlSummaryBox = $this->router->urlfor('/box/summary/', ['Id'=>$value["Id"]]);
            $res .= $value['Nom'];
            switch ($value['Etat']){
                case 1:
                    $res .= ": 
                    <a href='".$urlBox."'><button>Aperçu</button></a>
                    <a href='".$urlBox."&update'><button>Modifier</button></a>
                    <a href='".$urlSummaryBox."'><button>Payer</button></a>";
                    break;
                case 2:
                    $res .= " (Validé) : 
                    <a href='".$urlBox."'><button>Aperçu</button></a>
                    <a href='".$urlSummaryBox."'><button>Payer</button></a>";
                    break;
                default:                    
                    if($value["Etat"] == 3){
                        $res .= " (Payé) : ";
                    }
                    if($value["Etat"] == 4){
                        $res .= " (Transmis) : ";
                    }
                    if($value["Etat"] == 5){
                        $res .= " (Ouvert) : ";
                    }
                    $res .= "<a href='".$urlBox."'><button>Aperçu</button></a>";
                    break;
            }    
            $res .= "<br/><br/>";            
        }
        $res .= "</div>";
        return $res;
    }

    private function renderBox(){
        $res = "<div>";
        if(!empty($this->data["prestations"])){
            foreach ($this->data['prestations'] as $value) {
                $urlPrestation = $this->router->urlfor('/prestation/', ['Id'=>$value['Id']]);
                $urlCategorie = $this->router->urlfor('/categorie/', ['Id'=>$value['IdCategorie']]);
                $res .= "<a href='".$urlPrestation."'><div>
                        <p>".$value['Nom']."</p>
                        <p>".$value['Prix']." €</p>
                    </a>
                    <a href='".$urlCategorie."'>
                        <p>".$this->data["categories"][$value["IdCategorie"] - 1]."</p>
                    </a>
                    <a href='".$urlPrestation."'>
                        <img src ='/giftBox/img/".$value['Img']."'width='200'>
                        <p>".$value['Description']."</p>
                    </a></div>";
                $res .= "<hr>";
            }
            $urlBox =  $this->router->urlfor('/box/', ['Id'=>$this->data["box"]['Id']]);
            $urlSummaryBox = $this->router->urlfor('/box/summary/', ['Id'=>$this->data["box"]['Id']]);
            switch($this->data["box"]["Etat"]){
                case 1:
                    $res .= "<a href='".$urlBox."&update'><button>Modifier</button></a>
                    <a href='".$urlSummaryBox."'><button>Payer</button></a>";
                    break;
                case 2:
                    $res .= "<a href='".$urlSummaryBox."'><button>Payer</button></a>";
                    break;
                default:
                    switch($this->data["box"]["Etat"]){
                        case 4:
                            $res .= "<p>Votre coffret a été ou peut être transmis au destinataire</p>";
                            break;
                        case 5:
                            $res .= "<p>Votre coffret a été ouvert par le destinataire</p>";
                            break;
                    }
                    $res .= "<p>".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]."/box/receiver/?Id=".$this->data["box"]["Id"]."</p>";
                    break;
            }
        }
        $res .= "</div><br>";
        return $res;
    }

    private function renderNewBox(){
        return "<form name='creer' method='POST'>
                <p> Titre : <p>
                <textarea name='Texte' rows='10' cols='50'>
                Écrire votre message ici
                </textarea>
                <h2> Tarif : 00,00 € </h2>
                <input type='radio' name='maintenant' value='Maintenant' checked /> Maintenant
                <input type='radio' name='datePrecise' value='Maintenant'/> Date précise
                <input type='radio' name='uneParUne' value='Maintenant'/> Une par une
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
        if ($selector == 'NewBox')$string = $string . self::renderNewBox();
        $string = $string ."</article></section><footer>".self::renderFooter()."</footer>";
        return $string;
    }
}