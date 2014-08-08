<?php
    // Pages
    if(isset($_GET['page']))
    {
		// Panneaux
		if (isset($_GET['panel']))
		{
			if($_GET['panel'] == 'admin' && allowLevel(1))
			{
				// Panneau d'administration
				require_once '_indexes/adminIndex.php';
			}
		
			// Page inexistante
			else
			{
				echo "Cette page n'existe pas ou vous n'avez pas les droits pour accéder à cette partie du site.<br/>Consultez la Z-Team ...";
				
				showPage('view/page/homeView.php', NULL);
			}
		}
		
		/*
		 *		PAGES MEMBRES
		 */
		
        // Page d'accueil
        else if($_GET['page'] == 'home')
        {
            showPage('view/page/homeView.php', NULL);
        }
        
        // Déconnexion
        else if($_GET['page'] == 'settings')
        {
            showPage("view/page/userAccountView.php", NULL);
        }
        
        // Liste des films
        else if($_GET['page'] == 'movieList')
        {
            $movieCtrl->listMovies();
        }

        // Liste des séries
        else if($_GET['page'] == 'serieList')
        {
            $serieCtrl->listSeries();
        }

        // Fiche de film
        else  if($_GET['page'] == 'movieCard')
        {
            if(isset($_GET['num']))
            {
                $movieCtrl->movie($_GET['num']);
            }
            else
            {
                redirect(URL_PATH . '/films');
            }
        }

        // Fiche de série
        else if($_GET['page'] == 'serieCard')
        {
            if(isset($_GET['num']))
            {
                $serieCtrl->serie($_GET['num']);
            }
            else
            {
                redirect(URL_PATH . '/series');
            }
        }
		
		// Requete
        else if($_GET['page'] == 'request')
        {
            // Recherche par mot clé
			if(isset($_POST['filmSearch']) && $_POST['filmSearch'] != "")
			{
				$requestCtrl->formRequest();
			}
			
			// Ajout d'un élément
			else if(isset($_GET['num']) && $_GET['num'] != NULL && $_GET['num'] != 0)
			{
				$requestCtrl->executeRequest();
			}
			
			// Page vide
			else
			{
				$parameters["validPage"] = "request";
				showPage('view/page/alloMovieSearchView.php', $parameters);
			}
        }
		
		// Liste des requêtes
		else if($_GET['page'] == 'requestList')
		{
			$requestCtrl->getAllRequest();
		}
		
        // Page inexistante
        else
        {
            echo "Cette page n'existe pas !";
        }
    }
    
    // Erreur d'accès, redirection page d'accueil
    else
    {
        redirect(URL_PATH . '/');
    }
?>