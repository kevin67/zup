<?php
require_once("model/UserManager.php");

/*
 * Vérifie si l'utilisateur est connecté
 */
function user_verify()
{        
    $userExist = isset($_SESSION['user']);
    $existDB = false;

    if($userExist)
    {
        // Récupère l'utilisateur en variable de session
        $session = unserialize($_SESSION["user"]);
        
        // Vérifie l'utilisateur dans la BDD
        $userMgr = new UserManager();
        $user = $userMgr->getUser( $session->getId() );
        
        if( $user != NULL &&
            $user->getLogin() == $session->getLogin() &&
            $user->getPwd()  == $session->getPwd()  )
        {
            $existDB = true;
        }
    }

    return ($userExist && $existDB);
}

/*
 * Rafraichit la page
 */
function redirect($page)
{
    if (!headers_sent())
	{ 
        header('Location: ' . $page);
        exit;
    }
    else
    { 
        echo '<meta http-equiv="refresh" content="0;url=' . $page . '">'; 
    }
}

/*
 * Retourne sur la page précédente
 */
function redirectToPrevious()
{
    redirect($_SERVER["HTTP_REFERER"]);
}

/*
 * Affiche une page
 */
function showPage($page, $parameters)
{
    // Menu
    include_once 'view/_layout.php';

    // Contenu
    echo "<section class='column' id='leftCol'>";
        include 'view/column/menuColumn.php';
    echo"</section>";

    echo "<section class='page' id='page'>";
        include $page;
    echo"</section>";

    echo "<section class='column' id='rightCol'>";
        include 'view/column/newsColumn.php';
    echo"</section>";
}

/*
 *	Vérifie si la bariable est set (isset() ) et qu'elle n'est pas nulle
 */
function setNN($var)
{
    return isset($var) && ($var != NULL);
}

/*
 *	Vérifie si on a le droit d'effectuer une action
 *  1 : Accès Panneau d'administration
 *  2 : Gestion des requêtes
 *  3 : Modification des données Allociné
 *  4 : Ajout/Suppression des utilisateurs
 *  5 : Gestion des droits
 */
function allowLevel($var)
{
	$allowed = false;
	
	// Existence Session
    if(isset($_SESSION["right"]) && ($_SESSION["right"] != NULL))
	{
		// Récupération des droits
		$right = unserialize($_SESSION["right"]);
		
		// Switch selon niveau d'accès
		switch ($var)
		{
			case 1:
				$allowed = $right->getPanelAdmin();
				break;
			case 2:
				$allowed = $right->getRequestManager();
				break;
			case 3:
				$allowed = $right->getDataExaminer();
				break;
			case 4:
				$allowed = $right->getRecruitmentManager();
				break;
			case 5:
				$allowed = $right->getRightsManager();
				break;
		}
	}
	
	return $allowed;
}
 
?>