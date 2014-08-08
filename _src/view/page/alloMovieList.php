<?php
	// Affichage liste de films allociné
	if(isset($parameters["alloMovieList"]) && isset($parameters["validPage"]))
	{
		// Si résultats trouvés
		if($parameters["alloMovieList"] != -1 && count($parameters["alloMovieList"]) > 0)
		{
			$movieList = $parameters["alloMovieList"];
			echo '<h3>' . count($parameters["alloMovieList"]) . ' résultat(s) trouvé(s) pour : "' . $parameters["searchKey"] . '"</h3>';
			
			echo '<div class="itemList">';
			foreach($movieList as $movie)
			{
				$itemLink = URL_PATH . "/" . $parameters["validPage"] . "/" . $movie->{'code'};
			
				echo '<div class="itemListUnit">';
					// Choix image film
					if(isset($movie->{'poster'}) && isset($movie->{'poster'}->{'href'}))
					{
						$poster = $movie->{'poster'}->{'href'};
					}
					else
					{
						$poster = "http://fr.web.img4.acsta.net/r_160_240/b_1_d6d6d6/commons/emptymedia/empty_photo.jpg";
					}
					
					// Image film
					echo '<div class="itemListUnitPosterZone">';
					echo '<a href="' . $itemLink . '">';
					echo '<img class="itemListUnitPicture" src="' . $poster . '" />';
					echo '</a>';
					echo '</div>';
					
					// Données film
					echo '<div class="itemListUnitData">';
						echo '<span class="itemListUnitTitle">';
						echo '<a href="' . $itemLink . '">';
							echo $movie->{'originalTitle'};
							
							// Date de production
							if(isset($movie->{'productionYear'}))
							{
								echo ' (' . $movie->{'productionYear'} . ')';
							}
						echo '</a>';
						echo '</span> <br/>';
						
						// Liste des réalisateurs
						if(isset($movie->{'castingShort'}) && isset($movie->{'castingShort'}->{'directors'}))
						{
							echo '<span class="filmListReal">Réalisateur(s) : ' . $movie->{'castingShort'}->{'directors'} . '</span><br/>';
						}
						
						// Liste des acteurs
						if(isset($movie->{'castingShort'}) && isset($movie->{'castingShort'}->{'actors'}))
						{
							echo '<span class="filmListCast">Acteur(s) : ' . $movie->{'castingShort'}->{'actors'} . '</span><br/>';
						}
						
						// Lien page allociné
						if(isset($movie->{'link'}) && isset($movie->{'link'}[0]) && isset($movie->{'link'}[0]->{'href'}) )
						{
							echo '<span class="filmListLink">Fiche allociné : <a target="_blank" href="' . $movie->{'link'}[0]->{'href'} . '">' . $movie->{'link'}[0]->{'href'} . '</a></span><br/>';
						}
					echo '</div>';
					
					// Bouton d'ajout
					echo '<div class="itemListUnitButton">';
					echo '<a href="' . $itemLink . '">';
					echo '<img src="http://www.gestan.fr/wp-content/uploads/2012/02/Valid.png" style="width:80px;"/>';
					echo '<p>Faire une requête pour ce film</p>';
					echo '</a>';
					echo '</div>';
				echo '</div>';
			}
			echo '</div>';
		}
		
		// Si aucun résultats
		else
		{
			echo '<h3>Aucun résultats pour : "' . $parameters["searchKey"] . '"</h3>';
		}
	}
?>