<div>
    <?php
		echo "<h1>" . $parameters["title"] . "</h1>";
	
		// Réussite ajout BDD
		if($parameters["succeed"])
		{
			echo '<div style="display:inline-block; vertical-align:middle;">';
			echo '<img src="http://www.gestan.fr/wp-content/uploads/2012/02/Valid.png" style="height:128px; width:128px;" />';
			echo '</div>';
			
			echo '<div style="display:inline-block; vertical-align:middle;">';
			echo '<p style="font-size:x-large; font-weight:bold;">' . $parameters["successMess"] . '</p>';
			echo '</div>';
		}
		
		// Annulation
		else
		{
			echo '<div style="display:inline-block; vertical-align:middle;">';
			echo '<img src="http://blog.colortonerexpert.com/wp-content/uploads/2014/02/warning.png" style="height:128px; width:128px;" />';
			echo '</div>';
			
			echo '<div style="display:inline-block; vertical-align:middle;">';
			echo '<p style="font-size:x-large; font-weight:bold;">' . $parameters["failMess"] . '</p>';
			echo '</div>';
		}
	?>
</div>