<div>
    <h1>Liste des requêtes</h1>
	
	<?php
		// Parcours de la liste des requêtes
		if(setNN($parameters["requests"]))
		{
			$header = true;
			$second = false;
			
			echo "<table class='requestList'>";
				echo "<tr>";
				echo "<th>Film</th>";
				echo "<th>Lien Allociné</th>";
				echo "<th>Demandé par</th>";
				echo "<th>Demandé le</th>";
				echo "<th>Complété</th>";
				echo "</tr>";
				
				foreach($parameters["requests"] as $request)
				{
					$done = $request->getCompleted() != 0 ? 1 : 0;
					if($done) $second = true;
					
					
					if($header && $second)
					{
						echo "<tr id='spacing'></tr>";
						
						echo "<tr>";
						echo "<th>Film</th>";
						echo "<th>Lien Allociné</th>";
						echo "<th>Demandé par</th>";
						echo "<th>Demandé le</th>";
						echo "<th>Complété</th>";
						echo "</tr>";
				
						$header = !$header;
					}
					
					echo "<tr>";
						echo "<td>" . $request->getName() . "</td>";
						echo "<td><a href='" . $request->getUrl() . "'><img class='logo' src='" . URL_PATH . "/ressources/logo-allocine.png' /></a></td>";
						echo "<td>" . $request->getAsker() . "</td>";
						echo "<td>" . $request->getDate() . "</td>";
						echo "<td class='requestValid" . $done . "'>";
						
						// Si requete n'est pas complétée
						if(!$done && allowLevel(1))
						{
							echo "<td class='validBtn'>";
							echo "<a href= '" . URL_PATH . "/admin/completeRq/" . $request->getId() . "'>Ajouter</a>";
							echo "</td>";
						}
						
						if($done)
						{
							echo "<td class='validBtn'>";
							echo "<a class='button'href= '" . URL_PATH . "/film/" . $request->getCompleted() . "'>Voir la fiche</a>";
							echo "</td>";
						}						
					echo "</tr>";
				}
			echo "</table>";
		}
	?>
</div>