<?php

namespace giftBox\auth;

class giftBoxAuthentification extends \mf\auth\Authentification {

    /*
     * Classe TweeterAuthentification qui dÃ©finie les mÃ©thodes qui dÃ©pendent
     * de l'application (liÃ©e Ã  la manipulation du modÃ¨le User) 
     *
     */

    /* niveaux d'accÃ¨s de TweeterApp 
     *
     * Le niveau USER correspond a un utilisateur inscrit avec un compte
     * Le niveau ADMIN est un plus haut niveau (non utilisÃ© ici)
     * 
     * Ne pas oublier le niveau NONE un utilisateur non inscrit est hÃ©ritÃ© 
     * depuis AbstractAuthentification 
     */

    const ACCESS_LEVEL_USER  = 100;   
    const ACCESS_LEVEL_ADMIN = 200;

    /* constructeur */
    public function __construct(){
        parent::__construct();
    }

    /* La mÃ©thode createUser 
     * 
     *  Permet la crÃ©ation d'un nouvel utilisateur de l'application
     * 
     *  
     * @param : $username : le nom d'utilisateur choisi 
     * @param : $pass : le mot de passe choisi 
     * @param : $fullname : le nom complet 
     * @param : $level : le niveaux d'accÃ¨s (par dÃ©faut ACCESS_LEVEL_USER)
     * 
     * Algorithme :
     *
     *  Si un utilisateur avec le mÃªme nom d'utilisateur existe dÃ©jÃ  en BD
     *     - soulever une exception 
     *  Sinon      
     *     - crÃ©er un nouvel modÃ¨le User avec les valeurs en paramÃ¨tre 
     *       ATTENTION : Le mot de passe ne doit pas Ãªtre enregistrÃ© en clair.
     * 
     */
    
    public function createUser($nom,$prenom,$email,$login, $pass,$level=self::ACCESS_LEVEL_USER) {

        $resultRQ = \giftbox\model\User::where('Login', "=", $username)->first();
        if($resultRQ != null){
            echo "erreur";
        }
        else{
            $user = new \giftbox\model\User();
            $user->Nom = $nom; 
            $user->Prenom = $prenom; 
            $user->Email = $email; 
            $user->Login = $login; 
            $user->Mdp = $this->hashPassword($pass);     
            $user->Level = $level; 

            $user->save();
        }

    }

    /* La mÃ©thode loginUser
     *  
     * permet de connecter un utilisateur qui a fourni son nom d'utilisateur 
     * et son mot de passe (depuis un formulaire de connexion)
     *
     * @param : $username : le nom d'utilisateur   
     * @param : $password : le mot de passe tapÃ© sur le formulaire
     *
     * Algorithme :
     * 
     *  - RÃ©cupÃ©rer l'utilisateur avec l'identifiant $username depuis la BD
     *  - Si aucun de trouvÃ© 
     *      - soulever une exception 
     *  - sinon 
     *      - rÃ©aliser l'authentification et la connexion
     *
     */
    
    public function loginUser($username, $password){
    }

    $res = \giftbox\model\User::where('Login', "=", $username)->where('Mdp', '=', $password)->first();

    if($res == null){
        echo "erreur";
    }
    else{
        $this->login($username,$res['Mdp'],$password,$res['Level']);
    }
}
