<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo SITE_NAME ?></title>
        <link href="<?php echo URL_PATH ?>/content/basicCSS.css" rel="stylesheet" type="text/css">
		<link href="<?php echo URL_PATH ?>/content/itemList.css" rel="stylesheet" type="text/css">
		<link href="<?php echo URL_PATH ?>/content/request.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        <h1>
            <a href='<?php echo URL_PATH ?>/'> <?php echo SITE_NAME ?> </a>
        </h1>

        <!-- Gestion compte -->
        <a href='<?php echo URL_PATH ?>/settings'>Mon Compte (<?php echo unserialize($_SESSION["user"])->getLogin() ?>)</a>
        <a href='<?php echo URL_PATH ?>/logout'>Déconnexion</a>
		
        <!-- Menu -->
        <ul>
            <li> <a href='<?php echo URL_PATH ?>/'>Accueil</a> </li>

            <li> <a href='<?php echo URL_PATH ?>/films'>Films</a> </li>

            <li> <a href='<?php echo URL_PATH ?>/series'>Séries</a> </li>

            <li> <a href='<?php echo URL_PATH ?>/film/random'>Film aléatoire</a> </li>

            <li> <a href='<?php echo URL_PATH ?>/request'>Requête</a> </li>

			<li> <a href='<?php echo URL_PATH ?>/requestList'>Liste des requêtes</a> </li>
			
            <?php
                // Planning de mes séries, si complétés
                if(FALSE)
                {
                    echo '<li>';
                    echo '<a href="' . URL_PATH . '/film/0">Mes séries</a>';
                    echo '</li>';
                }
            ?>
			
			<?php
                // Accès administration site
                if(allowLevel(1))
                {
					echo '-----------------<br/>';
					
					if (allowLevel(2))
					{
						echo '<li>';
						echo '<a href="' . URL_PATH . '/admin/newMovie">Ajouter un film</a>';
						echo '</li>';
					}
				}
            ?>
        </ul>

        <!-- Barre de recherche -->
    </body>
</html>