<div>
    <h1>Ajout d'un film</h1>
	
	<?php
		// Présentation rapide du film
		if(isset($parameters["request"]) && $parameters["request"] != NULL)
		{
			$movie = $parameters["request"];
			
			echo "<p>";
			echo "<h2>" . $movie->getName() . "</h2>";
			echo "Demandé par : " . $movie->getAsker() . "<br/>";
			echo "Demandé le : " . $movie->getDate()  . "<br/>";
			echo "Page allociné : <a href='" . $movie->getUrl() . "'><img class='logo' src='" . URL_PATH . "/ressources/logo-allocine.png' /></a><br/>";
			echo "</p>";
		}
		else if(isset($parameters["movieName"]) && $parameters["movieName"] != NULL)
		{
			echo "<h2>" . $parameters["movieName"] . "</h2>";
		}
		
		// Formulaire d'ajout par hote
		if(isset($parameters["hosts"]))
		{
			echo "<form method='POST' action='" . URL_PATH . "/admin/addMovie/" . $parameters["movieCode"] . "'>";
			
			foreach($parameters["hosts"] as $host)
			{
				echo "<label for='" . $host->getId() . "'>" . $host->getName() . "</label>";
				echo "<input type='text' name='" . $host->getId() . "' id='" . $host->getId() . "'/>";
				echo "<button onclick=\"testPage('" . $host->getId() . "');\" type=button>Tester l'URL</button>";
				echo "<br />";
			}
			echo "<input type='submit' />";
			
			echo "</form>";
		}
		else
		{
			echo "La fonctionnalité d'ajout est actuellement indisponible, merci de réessayer ultérieurement !";
		}
	?>
</div>

<script>
// Test fonctionnement d'une page
function testPage(id)
{
	url = document.getElementById(id);
	window.open(url.value);
}
</script>