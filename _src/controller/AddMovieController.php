<?php
//include_once("model/MovieManager.php");
include_once("model/HostManager.php");
include_once("model/GenreManager.php");
include_once("model/NationManager.php");
include_once("model/PersonManager.php");
include_once("model/RequestManager.php");

class AddMovieController
{
    // Constructeur
    public function __construct()   
    {
    }
	
	// Add movie
	public function addMovie($alloId)
    {
		// Paramètre de succès
		$parameters["succeed"] 	= false;
		$sg = false;
		$sn = false;
		$sc = false;
		$sl = false;
		
		// Récupération des données Allociné
		$allocine = new Allocine(ALLOCINE_PARTNER_KEY, ALLOCINE_SECRET_KEY);
		$result   = $allocine->get($alloId);
		$obj 	  = json_decode($result);
		
		// Création du film
		$this->MovieManager = new MovieManager();
		$idMovie = $this->MovieManager->addFilm($obj);
		
		// Tables secondaires
		if($idMovie != null && $idMovie != 0)
		{
			// Ajout des genres
			$sg = $this->addGenre($obj, $idMovie);
			
			// Ajout des nationalitées
			$sn = $this->addNationality($obj, $idMovie);
			
			// Ajout du casting
			$sc = $this->addCasting($obj, $idMovie);
			
			// Ajout des liens
			$sl = $this->addLinks($idMovie);
		}
		
		// Si réussite : modification requête
		if($sg && $sn && $sc && $sl)
		{
			$this->RequestManager = new RequestManager();
			$this->RequestManager->validRequest($alloId, $idMovie);
		}
		
		// Affichage succès
		$parameters["succeed"]  	= $sg && $sn && $sc && $sl;
		$parameters["title"] 		= 'Publication d\'un film';
		$parameters["successMess"] 	= 'Le film a bien été ajouté ...';
		$parameters["failMess"] 	= 'Une erreur s\'est produite. Merci de bien vouloir recommencer ...';
		showPage('view/page/resultView.php', $parameters);
	}
	
	// Add Genre
	public function addGenre($obj, $idMovie)
    {
		// Réussite fonction
		$success = false;
		
		// Récupération des genres et ajout à la vidéo
		$this->GenreManager = new GenreManager();
		$genres = $obj->{'movie'}->{'genre'};
		foreach($genres as $g)
		{
			// Récupération genre
			$genre = $this->GenreManager->getSetGenre($g->{'code'}, $g->{'$'});
			
			// Ajout au film
			$success = $this->GenreManager->setGenreVideo($idMovie, $g->{'code'});
		}
		
		return $success;
	}
	
	// Add Nationality
	public function addNationality($obj, $idMovie)
    {
		// Réussite fonction
		$success = false;
		
		// Récupération des nationalitées et ajout à la vidéo
		$this->NationManager = new NationManager();
		$natios = $obj->{'movie'}->{'nationality'};
		foreach($natios as $n)
		{
			// Récupération nationalité
			$nation = $this->NationManager->getSetNationalite($n->{'code'}, $n->{'$'});
			
			// Ajout au film
			$success = $this->NationManager->setNatioVideo($idMovie, $n->{'code'});
		}
		
		return $success;
	}
	
	// Add Casting
	public function addCasting($obj, $idMovie)
    {
		// Réussite fonction
		$success = false;
	
		// Récupération des personnes et ajout à la vidéo
		$this->PersonManager = new PersonManager();
		$cast = $obj->{'movie'}->{'castMember'};
		
		// Filtrage sur le casting
		$reals  	= 0;
		$actors 	= 0;
		$MAX_REALS  = 1;
		$MAX_ACTORS = 3;
		$prior		= NULL;
		
		foreach($cast as $c)
		{
			$continue = false;	// Inscrire la personne
			$role = NULL;
			
			if(isset($c->{'activity'}->{'code'}))
			{
				// Switch selon niveau d'accès
				switch ($c->{'activity'}->{'code'})
				{
					// Acteur
					case 8001:
						if($actors < $MAX_ACTORS)
						{
							$continue = true;
							$prior = $actors + 1;
							
							if(isset($c->{'role'}))
							{
								$role = $c->{'role'};
							}
						}
						
						$actors++;
						break;
					
					// Réalisateur
					case 8002:
						if($reals < $MAX_REALS)
						{
							$prior = $reals + 1;
							$continue = true;
						}
						
						$reals++;
						break;
				}
			}
			
			// Si acteur/real a ajouté : ajout
			if($continue)
			{
				// Récupération de la personne
				$p = $c->{'person'};
				$person = $this->PersonManager->getSetPerson($p->{'code'}, $p->{'name'});
				
				// Création du rôle
				$success = $this->PersonManager->setPersonVideo($idMovie, $p->{'code'}, $c->{'activity'}->{'code'}, $role, $prior);
			}			
		}
	
		return $success;
	}

	// Add Links
	public function addLinks($idMovie)
    {
		// Réussite fonction
		$success = false;
	
		// Récupération des hébergeurs
		$this->HostManager = new HostManager();
		$hosts = $this->HostManager->getHostList();
		
		// Parcours des hebergeurs, et ajout des liens correspondant existant
		foreach($hosts as $host)
		{
			if(isset($_POST[$host->getId()]) && $_POST[$host->getId()] != NULL)
			{
				$link = $_POST[$host->getId()];
				
				// Ajout du lien
				if($this->HostManager->setLinkVideo($idMovie, $host->getId(), $link))
				{
					$success = true;
				}
			}
		}
	
		return $success;
	}

    // Execution formulaire de requete
    public function searchMovie()
    {
		$allocine	= new Allocine(ALLOCINE_PARTNER_KEY, ALLOCINE_SECRET_KEY);
		$result 	= $allocine->search($_POST['filmSearch']);
		$obj 		= json_decode($result);
		$movieList 	= -1;
		
		if(isset($obj->{'feed'}->{'movie'}))
		{
			$movieList = $obj->{'feed'}->{'movie'};
		}
		
		$parameters["validPage"] 	 = "admin/newMovie";
		$parameters["searchKey"] 	 = $_POST['filmSearch'];
		$parameters["alloMovieList"] = $movieList;
		showPage('view/page/alloMovieSearchView.php', $parameters);
	}
	
	// Page préparation film
    public function newMovie()
    {
		// Récupération film allociné
		$allocine = new Allocine(ALLOCINE_PARTNER_KEY, ALLOCINE_SECRET_KEY);
		$result   = $allocine->get($_GET['num']);
		$obj 	  = json_decode($result);
		
		if($obj != null)
		{
			$this->HostManager = new HostManager();
			$hosts = $this->HostManager->getHostList();
			$parameters["hosts"] = $hosts;
			
			$parameters["movieCode"] = $_GET['num'];
			$parameters["movieName"] = $obj->{'movie'}->{'title'};
			showPage('view/page/addMovieView.php', $parameters);
		}
		else
		{
			$parameters["succeed"]  	= false;
			$parameters["title"] 		= 'Ajout d\'un film';
			$parameters["failMess"] 	= 'Allociné n\'a pas de film correspondant à cet identifiant ...';
			showPage('view/page/resultView.php', $parameters);
		}	
    }
}