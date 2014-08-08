<?php
    // Page d'ajout des liens
	if($_GET['page'] == 'completeRequest' && allowLevel(2) && isset($_GET['num']) && $_GET['num'] != NULL && $_GET['num'] != 0)
	{
		$requestCtrl->completeRequest();
	}
		
	// Ajout d'un l'élement - Fiche de liens
	else if($_GET['page'] == 'newMovie' && allowLevel(2))
	{
		// Recherche par mot clé
		if(isset($_POST['filmSearch']) && $_POST['filmSearch'] != "")
		{
			$addMovieCtrl->searchMovie();
		}
		
		// Ajout d'un élément
		else if(isset($_GET['num']) && $_GET['num'] != NULL && $_GET['num'] != 0)
		{
			$addMovieCtrl->newMovie($_GET['num']);
		}
		
		// Page vide
		else
		{
			$parameters["validPage"] = "admin/newMovie";
			showPage('view/page/alloMovieSearchView.php', $parameters);
		}
	}
	
	// Ajout d'un l'élement - Enregistrement BDD
	else if($_GET['page'] == 'addMovie' && allowLevel(2) && isset($_GET['num']) && $_GET['num'] != NULL && $_GET['num'] != 0)
	{
		$addMovieCtrl->addMovie($_GET['num']);
	}
		
	// Page inexistante
	else
	{
		echo "Cette page n'existe pas ou vous n'avez pas les droits pour accéder à cette partie du site.<br/>Consultez la Z-Team ...";
		
		showPage('view/page/homeView.php', NULL);
	}
?>