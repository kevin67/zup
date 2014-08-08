<?php
    header('Content-Type:text/html; charset=utf-8');
    session_start();

    // Imports
    require_once 'model/SQLRequestTemplate.php';
	require_once 'controller/UserController.php';
    require_once 'controller/MovieController.php';
    require_once 'controller/SerieController.php';
    require_once 'controller/RequestController.php';
	require_once 'controller/AddMovieController.php';
    require_once 'controller/_functions.php';
	
    // Identifiants pour la base de données 
    define('SQL_DSN', 'mysql:dbname=z-up;host=localhost');
    define('SQL_USERNAME', 'root');
    define('SQL_PASSWORD', '');

	// Variables globales
    define('SITE_NAME', 'Z-UP');
    define('URL_PATH',  '/zup');
    
    // Contrôleurs
    $userCtrl		= new UserController();
    $movieCtrl		= new MovieController();
    $serieCtrl		= new SerieController();
	$requestCtrl	= new RequestController();
	$addMovieCtrl	= new AddMovieController();
	
	//-------------------------------------------------------------------
    // API Allociné
	require_once("model/Allocine.php");
	define('ALLOCINE_PARTNER_KEY', '100043982026');
	define('ALLOCINE_SECRET_KEY', '29d185d98c984a359e6e6f26a0474269');
	//-------------------------------------------------------------------
	
    // Connecté
    if(user_verify())
    {
        // Déconnexion
        if(isset($_GET['userAction']) && $_GET['userAction'] == 'logout')
        {
            $userCtrl->logout();
        }
        
        // Sauvegarde paramètres
        else if(isset($_GET['userAction']) && $_GET['userAction'] == 'saveSettings')
        {
            $userCtrl->logout();
        }
        
        require_once '_indexes/pageIndex.php';
    }
    
    // Déconnecté
    else
    {
        // Connexion
        if(isset($_GET['userAction']) && $_GET['userAction'] == 'login')
        {
            $userCtrl->login();
        }
        
        // Affichage formulaire de connexion
        else
        {
            include("view/connectionView.php");
        }
    }
?>