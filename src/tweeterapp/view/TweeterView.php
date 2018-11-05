<?php

namespace tweeterapp\view;

class TweeterView extends \mf\view\AbstractView {
  
    /* Constructeur 
    *
    * Appelle le constructeur de la classe parent
    */
    public function __construct( $data ){
        parent::__construct($data);
    }

    /* Méthode renderHeader
     *
     *  Retourne le fragment HTML de l'entête (unique pour toutes les vues)
     */ 
    private function renderHeader(){
        return '<h1>MiniTweeTR</h1>';
    }
    
    /* Méthode renderFooter
     *
     * Retourne le fragment HTML du bas de la page (unique pour toutes les vues)
     */
    private function renderFooter(){
        return 'La super app créée en Licence Pro &copy;2018';
    }


    /* Méthode renderHome
     *
     * Vue de la fonctionalité afficher tous les Tweets. 
     *  
     */
    
    private function renderHome(){
        $res = "";
        foreach ($this->data as $value1) {
            $u = \tweeterapp\model\Tweet::where('id' ,'=', $value1['id'])->first();
            $user = $u->user()->first();
            $router = new \mf\router\Router();
            $urlUser = $router->urlfor('/user/', ['id'=>$value1['author']]);
            $urlTweet = $router->urlfor('/tweet/', ['id'=>$value1['id']]);
            //echo $url."<br />";
            $res = $res . "<div class='tweet'>
            <div class='tweet-text'><a href='".$urlTweet."'>".$value1['text']."</a></div>
            <div class='tweet-footer'>
                <span class='tweet-timestamp'>".$value1['created_at']."
                <span class='tweet-author'><a href='".$urlUser."'>".$user['username']."</a></span>
            </div></div>";
        }
        return $res;
    }
  
    /* Méthode renderUeserTweets
     *
     * Vue de la fonctionalité afficher tout les Tweets d'un utilisateur donné. 
     * 
     */
     
    private function renderUserTweets(){
        $u = \tweeterapp\model\Tweet::where('id' ,'=', $this->data[0]['id'])->first();
        $user = $u->user()->first();
        $res = "";
        $res = $res . "Profil de : ".$user['username'] . "<br />";
        $res = $res . "Nombre de followers : " . $user['followers'];
        foreach ($this->data as $value1) {
            
            $router = new \mf\router\Router();
            $urlUser = $router->urlfor('/user/', ['id'=>$value1['author']]);
            $urlTweet = $router->urlfor('/tweet/', ['id'=>$value1['id']]);
            $res = $res . "<div class='tweet'>
            <div class='tweet-text'><a href='".$urlTweet."'>".$value1['text']."</a></div>
            <div class='tweet-footer'>
                <span class='tweet-timestamp'>".$value1['created_at']."
                <span class='tweet-author'><a href='".$urlUser."'>".$user['username']."</a></span>
            </div></div>";
        }
        return $res;
    }
  
    /* Méthode renderViewTweet 
     * 
     * Rréalise la vue de la fonctionnalité affichage d'un tweet
     *
     */
    
    private function renderViewTweet(){
        $u = \tweeterapp\model\Tweet::where('id' ,'=', $this->data['id'])->first();
$user = $u->user()->first();
        
        $router = new \mf\router\Router();
        $urlUser = $router->urlfor('/user/', ['id'=>$this->data['author']]);
        $res = "<div class='tweet'>
            <div class='tweet-text'>".$this->data['text']."</div>
            <div class='tweet-footer'>
                <span class='tweet-timestamp'>".$this->data['created_at']."
                <span class='tweet-author'><a href='".$urlUser."'>".$user['username']."</a></span>
            </div><hr><span class='tweet-score tweet-control'>".$this->data['score']."</span></div>";
        return $res;
    }



    /* Méthode renderPostTweet
     *
     * Realise la vue de régider un Tweet
     *
     */
    protected function renderPostTweet(){
        
        /* Méthode renderPostTweet
         *
         * Retourne la framgment HTML qui dessine un formulaire pour la rédaction 
         * d'un tweet, l'action du formulaire est la route "send"
         *
         */
        
    }


    /* Méthode renderBody
     *
     * Retourne la framgment HTML de la balise <body> elle est appelée
     * par la méthode héritée render.
     *
     */
    
    protected function renderBody($selector=null){

        $string = "<header class='theme-backcolor1'>".self::renderHeader()."</header><section><article class='theme-backcolor2'>";
        if ($selector == 'home')$string = $string . self::renderHome();
        if ($selector == 'user')$string = $string . self::renderUserTweets();
        if ($selector == 'tweet')$string = $string . self::renderViewTweet();
        if ($selector == 'userInfo')$string = $string . self::renderUserInfo();
        $string = $string ."</article></section><footer class='theme-backcolor1'>".self::renderFooter()."</footer>";
         /* Méthode renderBody 
         * 
         * Retourne le contenu HTML de la 
         * balise body autrement dit le contenu du document. 
         *
         * Elle prend un sélecteur en paramètre dont la 
         * valeur indique quelle vue il faut générer.
         * 
         * Note cette méthode est a définir dans les classes concrètes des vues, 
         * elle est appelée depuis la méthode render ci-dessous.
         * 
         * Paramètre : 
         * 
         * $selector (String) : une chaîne qui permet de savoir quelle vue générer
         * 
         * Retourne : 
         *
         * - (String) : le contenu HTML complet entre les balises <body> </body> 
         *
         */
        return $string;
    }











    
}
