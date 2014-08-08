<?php
    $movie = $parameters["movie"];
?>

<div id="title">
	<h2><?php echo $movie->getTitle() ?></h2>
</div>

<div id="info">
	<?php
		// Titre original
		if(setNN($movie->getOriginalTitle()))
		{
			echo '<div class="info" id="originalTitle">';
			echo 'Titre original : ' . $movie->getOriginalTitle();
			echo '</div>';
		}
		
		// Date de sortie
		if(setNN($movie->getDateSortie()))
		{
			echo '<div class="info" id="dateSortie">';
			echo 'Date de sortie : ' . $movie->getDateSortie();
			echo '</div>';
		}
		
		// Durée
		/*if(setNN($movie->getDuree()))
		{
			$h = (int) ($movie->getDuree() / 60);
			$m = $movie->getDuree() % 60;
			echo '<div class="info" id="duree">';
			echo 'Durée : ' . $h . "h" . $m;
			echo '</div>';
		}*/
		
		// Réalisateur
		if(setNN($movie->getReal()))
		{
			echo '<div class="info" id="realisateur">';
			echo 'Réalisateur : ' . $movie->getReal();
			echo '</div>';
		}
		
		// Acteurs
		if(setNN($movie->getActeurs()))
		{
			echo '<div class="info" id="acteurs">';
			echo 'Acteurs : ' . $movie->getActeurs();
			echo '</div>';
		}
		
		// Genre
		if(setNN($movie->getGenre()))
		{
			echo '<div class="info" id="genre">';
			echo 'Genre : ' . $movie->getGenre();
			echo '</div>';
		}
		
		// Nationalité
		if(setNN($movie->getNationalite()))
		{
			echo '<div class="info" id="nationalite">';
			echo 'Nationalité : ' . $movie->getNationalite();
			echo '</div>';
		}
		
		// Note Presse
		if(setNN($movie->getNoteP()))
		{
			echo '<div class="info" id="noteP">';
			echo 'Note Presse : ' . str_replace(".", ",", $movie->getNoteP()) . "/5";
			echo '</div>';
		}
		
		// Note Spectateur
		if(setNN($movie->getNoteS()))
		{
			echo '<div class="info" id="noteS">';
			echo 'Note Spectateur : ' . str_replace(".", ",", $movie->getNoteS()) . "/5";
			echo '</div>';
		}
		
		// Note Z-UP
		if(setNN($movie->getNoteZ()))
		{
			echo '<div class="info" id="noteZ">';
			echo 'Note Z-UP : ' . str_replace(".", ",", $movie->getNoteZ()) . "/5";
			echo '</div>';
		}
	?>
</div>

<div id="img">
	<?php
		// Résumé
		if(setNN($movie->getImage()))
		{
			echo '<image src="' . $movie->getImage() . '" alt="Affiche Film"/>';
		}
	?>
</div>

<?php
	// Bande-Annonce
	if(setNN($movie->getBandeAnnonce()))
	{
		echo '<div id="trailer">';
		echo '<iframe src="' . $movie->getBandeAnnonce() . '" frameborder="0"></iframe>';
		echo '</div>';
	}
?>

<div id="resume">
	<?php
		// Résumé
		if(setNN($movie->getDescription()))
		{
			echo '<p>' . $movie->getDescription() . '</p>';
		}
	?>
</div>

<div id="liens">
------------------------- Liens -------------------------<br/>
<?php
	// Affichage des liens du film
	$links = $movie->getLinks();
	if(setNN($links))
	{
		foreach($links as $link)
		{
			echo "<div class='link'>" . $link->getName() . " : <a href='" . $link->getLink() . "' target='_blank'>Télécharger</a><br/>";
		}
	}
?>
</div>