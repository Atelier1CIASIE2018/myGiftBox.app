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
            $categorie = $c->Categorie()->first();
            $categ = $categorie['Nom'];

            //var_dump($value1);
            $router = new \mf\router\Router();
            $res = $res . "<div>
                <p>".$value1['Nom']."</p>
                <p>".$value1['Prix']." €</p>
                <p>".$categ."</p>
                <img src ='img/".$value1['Img']."' width='200'>
                <p>".$value1['Description']."</p>
            </div>";
        }
        $res = $res . "</div>";
        return $res;
    }
    
    protected function renderBody($selector=null){

        $string = "<header class='theme-backcolor1'>".self::renderHeader()."</header><section><article class='theme-backcolor2'>";
        if ($selector == 'home')$string = $string . self::renderHome();
        if ($selector == 'user')$string = $string . self::renderUserTweets();
        if ($selector == 'tweet')$string = $string . self::renderViewTweet();
        if ($selector == 'userInfo')$string = $string . self::renderUserInfo();
        $string = $string ."</article></section><footer class='theme-backcolor1'>".self::renderFooter()."</footer>";
        return $string;
    }
}