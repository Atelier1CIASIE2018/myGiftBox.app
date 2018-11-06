<?php

namespace giftbox\view;

class GiftBoxView extends \mf\view\AbstractView {
    public function __construct( $data ){
        parent::__construct($data);
    }

    private function renderHeader(){
        return '<h1>My Gift Box App</h1>';
    }
    
    private function renderFooter(){
        return 'Atelier 1 CIASIE 2018 Toussaint Maillard Guebel &copy;2018';
    }
    
    private function renderHome(){
        $res = "<div>";
        foreach ($this->data as $value1) {
            $c = \giftbox\model\Prestation::where('Id' ,'=', $value1['Id'])->first();

            $router = new \mf\router\Router();
            $urlCateg = $router->urlfor('/prestation/', ['Id'=>$value1['Id']]);

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

    private function renderPrestation(){
        $res = $this->data['Nom'];
        return $res;
    }

    private function renderPrestations(){
        $res = "<div>";
        foreach ($this->data as $value1) {
            $res = $res . "<div>
                <p>".$value1['Nom']."</p>
            </div>";
        }
        $res = $res . "</div>";
        return $res;
    }

    private function renderCategories(){
        $res = "<div>";
        //var_dump($this->data);
        foreach ($this->data as $value) {
            $res = $res."<div> <p>".$value['Nom']."</p> </div>";
        }
        $res = $res."</div>";
        return $res;
    }

    private function renderCategorie(){
        $res = "<div>";
        //var_dump($this->data);
        foreach ($this->data as $value1) {

            $c = \giftbox\model\Prestation::where('Id' ,'=', $value1['Id'])->first();

            $router = new \mf\router\Router();
            $urlCateg = $router->urlfor('/prestation/', ['Id'=>$value1['Id']]);

            //var_dump($value1);
            $res = $res . "<a href='".$urlCateg."'><div>
                <p>".$value1['Nom']."</p>
                <p>".$value1['Prix']." €</p>
                <img src ='/giftBox/img/".$value1['Img']."' width='200'>
                <p>".$value1['Description']."</p>
            </div></a>";
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
    
    protected function renderBody($selector=null){

        $string = "<header>".self::renderHeader()."</header><section><article>";
        if ($selector == 'Home')$string = $string . self::renderHome();
        if ($selector == 'Prestation')$string = $string . self::renderPrestation();
        if ($selector == 'Prestations')$string = $string . self::renderPrestations();
        if ($selector == 'Categories')$string = $string . self::renderCategories();
        if ($selector == 'Categorie')$string = $string . self::renderCategorie();
        if ($selector == 'Login')$string = $string . self::renderLogin();
        if ($selector == 'Register')$string = $string . self::renderRegister();
        /*if ($selector == '')$string = $string . self::();
        if ($selector == '')$string = $string . self::();
        if ($selector == '')$string = $string . self::();
        if ($selector == '')$string = $string . self::();
        if ($selector == '')$string = $string . self::();*/
        $string = $string ."</article></section><footer>".self::renderFooter()."</footer>";
        return $string;
    }
}