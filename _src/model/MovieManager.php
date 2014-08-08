<?php 

include_once("model/Movie.php");

class MovieManager 
{ 
    protected $_db; 

	public function __construct()
    { 
        $this->_db= new PDO(SQL_DSN, SQL_USERNAME, SQL_PASSWORD);
		$this->_db->exec("set names utf8");
    }

	/*
     * Recherche d'un ID aléatoire
     */
	public function getRandomFilmId($pre1, $pre2, $pre3)
    {
		$req = "SELECT FLOOR(0 + COUNT(flm.idVideo) * RAND()) AS 'VAL' FROM film flm WHERE flm.idVideo NOT IN (" . $pre1 . "," . $pre2 . "," . $pre3 . ")";
		
		$q = $this->_db->query($req); 
        if($q != NULL)
        {
            $data = $q->fetch(PDO::FETCH_ASSOC);
            
			$req = "SELECT flm.idVideo FROM film flm WHERE flm.idVideo NOT IN (" . $pre1 . "," . $pre2 . "," . $pre3 . ") LIMIT " . $data['VAL'] . ",1";
			
			$q = $this->_db->query($req); 
			if($q != NULL)
			{
				$data = $q->fetch(PDO::FETCH_ASSOC);
				return $data['idVideo'];
			}
        }
		
		return NULL;
	}
	
	/*
     * Récupère un film par id
     */
    public function getFilm($id) 
    {
		$req = MOVIE_BASIC_REQUEST . "WHERE v.id = " . $id . ";";
		
		$movies = array();
        $q = $this->_db->query($req); 
        if($q != NULL)
        {
			while ($data = $q->fetch(PDO::FETCH_ASSOC))
            { 
                $movies[] = new Movie($data);
            }
			
			if(count($movies) == 1)
			{
				return $movies[0];
			}
        }
		
		return NULL;
    }
	
	/*
     * Récupère un film par id Allociné
     */
    public function getAllocineId($id) 
    {
		$req = "SELECT `id` FROM `video` WHERE idAllocine = " . $id . ";";
		
		$movies = array();
        $q = $this->_db->query($req); 
        if($q != NULL)
        {
			while ($data = $q->fetch(PDO::FETCH_ASSOC))
            { 
                $ids[] = $data['id'];
            }
			
			if(isset($ids) && $ids != null && count($ids) == 1)
			{
				return $ids[0];
			}
        }
		
		return NULL;
    }
	
	/*
     * Récupère une liste de films
     */
    public function getFilmList() 
    { 
        $req = MOVIE_BASIC_REQUEST . ";";
		
		if(false)
		{
			$req .= " WHERE v.titre CONTAINS '" + false + "';";
		}
		
		$movies = array();
        $q = $this->_db->query($req); 
        if($q != NULL)
        {
            while ($data = $q->fetch(PDO::FETCH_ASSOC))
            { 
                $movies[] = new Movie($data); 
            } 
        }
        else
        {
            $movies = NULL;
        }
		
		return $movies;
    }
	
	/*
	 *	Insertion Film
	 */
	public function addFilm($obj)
	{
		if(!isset($obj))
		{
			return null;
		}
		
		$movie = $obj->{'movie'};
		
		if(isset($movie->{'code'}))
		{
			$id 			= $movie->{'code'};
			$title 			= isset($movie->{'title'}) 			? $movie->{'title'} 		: NULL;
			$originalTitle 	= isset($movie->{'originalTitle'}) 	? $movie->{'originalTitle'} : NULL;
			$description 	= isset($movie->{'synopsis'}) 		? $movie->{'synopsis'} 		: NULL;
			$picture 		= isset($movie->{'poster'}->{'href'}) 			? $movie->{'poster'}->{'href'}				: NULL;
			$noteP 			= isset($movie->{'statistics'}->{'pressRating'})? $movie->{'statistics'}->{'pressRating'}	: NULL; 
			$noteS 			= isset($movie->{'statistics'}->{'userRating'}) ? $movie->{'statistics'}->{'userRating'}	: NULL;
		}
		else
		{
			return null;
		}
		
		// Requête vidéo
		$req = "INSERT INTO `video`
		(`idAllocine`, `titre`, `titreOriginal`, `image`, `description`, `bandeAnnonce`, `notePresse`, `noteSpectateur`) 
		VALUES (:id, :title, :originalTitle, :picture, :description, :ba, :noteP, :noteS);";
		
		// Ajout de la vidéo
		$q = $this->_db->prepare($req);
		$q->bindValue(':id',    		$id,    		  	  PDO::PARAM_INT); 
		$q->bindValue(':title',    		$title,    		  	  PDO::PARAM_STR); 
		$q->bindValue(':originalTitle', $originalTitle, 	  PDO::PARAM_STR); 
		$q->bindValue(':description', 	$description,    	  PDO::PARAM_STR); 
		$q->bindValue(':ba', 			$this->getBA($movie), PDO::PARAM_STR);
		$q->bindValue(':picture',  		$picture, 			  PDO::PARAM_STR);
		$q->bindValue(':noteP',  		$noteP,  			  PDO::PARAM_STR);
		$q->bindValue(':noteS',    		$noteS,   			  PDO::PARAM_STR);
		$q->execute();
		
		// Récupération du film BDD
		$id = $this->getAllocineId($movie->{'code'});
		
		// Ajout du film
		if($id != null)
		{
			$q = $this->_db->prepare("INSERT INTO `film`(`idVideo`, `anneeProd`) VALUES (:id, :year)");
			$q->bindValue(':id',    $id,    		  			PDO::PARAM_INT); 
			$q->bindValue(':year',	$movie->{'productionYear'}, PDO::PARAM_INT); 
			$q->execute();
		}
		
		// retour de l'id
		return $id;
		
    }
	
	/*
	 *	Récupère la bande annonce depuis allociné
	 */
	public function getBA($movie)
	{
		$ba = NULL;
		
		// Si il y a des médias
		if(isset($movie->{'media'}))
		{
			// Parcours des médias
			foreach($movie->{'media'} as $media)
			{
				// Si bande annonce et Francais
				if( isset($media->{'type'}->{'code'}) 		&& $media->{'type'}->{'code'} 	 == 31003
				 && isset($media->{'version'}->{'code'}) 	&& $media->{'version'}->{'code'} == 6001 )
				{
					// Remplacement par la bande annonce
					$ba = $media->{'thumbnail'}->{'href'};
					break;
				}
			}
		}
		
		// Si aucun media trouvé et que le trailer est rempli, utilisation du trailer
		if($ba == NULL && isset($movie->{'trailer'}->{'href'}))
		{
			$ba = $movie->{'trailer'}->{'href'};
		}
		
		// Renvoi résultat
		return $ba;
	}
}
?>