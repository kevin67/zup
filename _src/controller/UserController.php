<?php
include_once("model/UserManager.php");

class UserController
{
    // Constructeur
    public function __construct()   
    {
		$this->UserManager = new UserManager();
    }
	
    // Connexion
    public function login()
    {
        if( isset($_POST['login'])  && $_POST['login'] != '' &&
            isset($_POST['pwd'])    && $_POST['pwd']   != '' )
        {
            $login  = html_entity_decode($_POST['login']);
            $pwd    = html_entity_decode($_POST['pwd']);
        
			$user = $this->UserManager->getUserByLogin($login);
			
			if($user != null && $user->getPwd() == sha1($pwd))
            {
                $_SESSION['user'] = serialize($user);

				// Ajout des droits de l'utilisateur
				$this->RightManager = new RightManager();
				$right = $this->RightManager->getRight($user->getRight());
				$_SESSION['right'] = serialize($right);
            }
        }
        
        redirectToPrevious();
    }

    // Deconnexion
    public function logout()
    {
        session_destroy();
        redirect(URL_PATH . '/');
    }
}
?>