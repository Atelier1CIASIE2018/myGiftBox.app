<?php

namespace giftbox\view;

class GiftBoxView extends \mf\view\AbstractView {
    private $router;

    public function __construct( $data ){
        parent::__construct($data);
        $this->router = new \mf\router\Router();
    }

    private function renderHeader(){
        return '<h1>My Gift Box App</h1>';
    }
    
    private function renderFooter(){
        return 'Atelier 1 CIASIE 2018 Toussaint Maillard Guebel &copy;2018';
    }
    
    private function renderHome(){
        $res = "<div>";
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
        $res = $res . "</div>";
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
        $array = array("Validé","Payé","Transmis","Ouvert");
        $res = "<div>";
        foreach ($this->data as $value) {
            if($value['Etat'] == 1){
                $res = $res.$value['Nom']." : <a href='#'><input type='button' value='modifier'/></a> <a href='#'><input type='button' value='payer'/></a>";
            }
            else if($value['Etat'] == 2){
                $res = $res. $value['Nom'] ." :   ".$array[$value["Etat"] - 2]."  <a href='#'><input type='button' value='Payer'/></a>";
            }
            else{
                $res = $res . $value['Nom'] ." :   ".$array[$value["Etat"] - 2]."  <a href='#'><input type='button' value='Voir URL'/></a>";
            }    
            $res .= "<br/><br/>";            
        }
        $res .= "</div>";
        return $res;
    }

    private function renderBox(){
        $res = "<div>";
        foreach ($this->data['prestations'] as $value1) {
            //echo $value1;
            $c = \giftbox\model\Prestation::where('Id' ,'=', $value1['Id'])->first();
            $urlCateg = $this->router->urlfor('/prestation/', ['Id'=>$value1['Id']]);

            $categorie = $c->Categorie()->first();
            $categ = $categorie['Nom'];

            //var_dump($value1);
            $res = $res . "<a href='".$urlCateg."'><div>
                <p>".$value1['Nom']."</p>
                <p>".$value1['Prix']." €</p>
                <p>".$categ."</p>
                <img src ='/giftBox/img/".$value1['Img']."' width='200'>
                <p>".$value1['Description']."</p>
            </div></a>";
        }
        $res = $res . "</div>";
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
        /*if ($selector == '')$string = $string . self::();
        if ($selector == '')$string = $string . self::();
        if ($selector == '')$string = $string . self::();*/
        $string = $string ."</article></section><footer>".self::renderFooter()."</footer>";
        return $string;
    }
}