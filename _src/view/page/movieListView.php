<h2>Films</h2>

<?php
	if(isset($parameters["movies"]) && $parameters["movies"] != null)
	{
		echo '<ul>';
		
		foreach($parameters["movies"] as $mv)
		{
			echo '<li>';
			echo '<a href="' . URL_PATH . '/film/' . $mv->getId() . '">' . $mv->getTitle() . '</a>';
			echo '</li>';
		}
		
		echo '</ul>';
	}
	
	// Aucun film trouvé
	else
	{
		echo 'aucun film trouvé : essaye de faire une requete ...';
	}
?>