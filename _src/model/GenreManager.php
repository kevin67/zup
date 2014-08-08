<?php 

include_once("model/Genre.php");

class GenreManager
{ 
    protected $_db; 

    public function __construct()
    { 
        $this->_db= new PDO(SQL_DSN, SQL_USERNAME, SQL_PASSWORD);
		$this->_db->exec("set names utf8");
    }

    /*
     * Récupère un genre
     */
    public function getGenre($id) 
    { 
        $genre = NULL;

		if($id != NULL)
		{
			$q = $this->_db->prepare(GENRE_BASIC_REQUEST . ' WHERE id=:id'); 
			$q->bindValue(':id', $id, PDO::PARAM_INT); 
			$q->execute(); 
			
			if($q != NULL)
			{
				$data = $q->fetch(PDO::FETCH_ASSOC);
				if ($data != NULL)
				{
					$genre = new Genre($data);
				}
			}
        }
		
        return $genre;
    }
	
	/*
     * Récupère un genre, le crée si il n'existe pas
     */
    public function getSetGenre($id, $label) 
    { 
        $genre = $this->getGenre($id);

		if($genre == NULL && $id != NULL)
		{
			$q = $this->_db->prepare('INSERT INTO genre (id, label) VALUES (:id,:label)'); 
			$q->bindValue(':id',    $id,    PDO::PARAM_INT); 
			$q->bindValue(':label', $label, PDO::PARAM_STR);
			$q->execute();
			
			$genre = $this->getGenre($id);
        }
		
        return $genre;
    }
	
	/*
     * Ajoute un genre à une vidéo
     */
    public function setGenreVideo($idVideo, $idGenre) 
    { 
        if($idVideo != NULL && $idGenre != NULL)
		{
			$q = $this->_db->prepare('INSERT INTO `genrevideo`(`idVideo`, `idGenre`) VALUES (:idV,:idG)'); 
			$q->bindValue(':idV', $idVideo, PDO::PARAM_INT); 
			$q->bindValue(':idG', $idGenre, PDO::PARAM_INT);
			$q->execute();
			
			return true;
        }
		
		return false;
    }
    
    /*
     * Récupère tous les genres
     */
    public function getGenreList() 
    { 
        $genres = NULL;
        $q = $this->_db->query(GENRE_BASIC_REQUEST . ' ORDER BY id');
		
        if($q != NULL)
        {
			$genres = array();
			
            while ($data = $q->fetch(PDO::FETCH_ASSOC))
            { 
                $genres[] = new Genre($data); 
            } 
        }
		
        return $genres;
    }
} 
?>