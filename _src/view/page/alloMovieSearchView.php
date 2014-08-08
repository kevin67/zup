<div>
<?php	
	if(isset($parameters["validPage"]))
	{
		if($parameters["validPage"] == "request")
		{
			echo'<h1>Déposer une requête</h1>';
			echo'<div id="texteRequete">';
			echo'<p>Explications fonctionnement requêtes ...</p>';
			echo'</div>';
			echo'<p>Avant de soumettre une requête, merci de bien vouloir vérifier que celle-ci n\'a pas déjà été faite ! <b><a href="' . URL_PATH . '/requestList">Liste des requêtes</a></b></p>';
		}
		else
		{
			echo'<h1>Ajouter un film</h1>';
		}
?>		
		<div id="requete">
			<form action="<?php echo URL_PATH . "/" . $parameters["validPage"] ?>" method="POST">
				<label for="filmSearch">Nom du film : </label>
				<input type="text" id="filmSearch" name="filmSearch" />
				
				<input type="submit" value="Rechercher" />
			</form>
		</div>
	
<?php
		include "alloMovieList.php";
	}
	else
	{
		echo "<p>Le système de recherche de film est actuellement indisponible ...</p>";
	}
?>	
</div>