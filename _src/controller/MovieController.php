<?php
include_once("model/MovieManager.php");

class MovieController
{
    // Constructeur
    public function __construct()   
    {
		$this->MovieManager = new MovieManager();
    }

    // Liste des films
    public function listMovies()
    {
		$movies = $this->MovieManager->getFilmList();
		
		$parameters["movies"] = $movies;
		showPage('view/page/movieListView.php', $parameters);
    }
    
    // Affiche film
    public function movie($id)
    {
		// Film random
		if($id == "random")
		{
			$pre1 = isset($_SESSION["pre1"]) ? $_SESSION["pre1"] : -1 ;
			$pre2 = isset($_SESSION["pre2"]) ? $_SESSION["pre2"] : -1 ;
			$pre3 = isset($_SESSION["pre3"]) ? $_SESSION["pre3"] : -1 ;		
			$id = $this->MovieManager->getRandomFilmId($pre1, $pre2, $pre3);
			
			$_SESSION["pre1"] = $id;
			$_SESSION["pre2"] = $pre1;
			$_SESSION["pre3"] = $pre2;
		}
		
		// Récupération du film
		if($id != NULL)
		{
			$movie = $this->MovieManager->getFilm($id);
		}
		
		// Affichage du film
		if(isset($movie) && $movie != NULL)
		{
			$parameters["movie"] = $movie;
			showPage('view/page/movieView.php', $parameters);
		}
		
		// Film introuvable
		else
		{
			echo 'Erreur : film-introuvable ...';
		}
    }
}
?>