<?php 

include_once("model/Host.php");

class HostManager
{ 
    protected $_db; 

    public function __construct()
    { 
        $this->_db= new PDO(SQL_DSN, SQL_USERNAME, SQL_PASSWORD);
		$this->_db->exec("set names utf8");
    }

    /*
     * Récupère un hebergeur
     */
    public function getHost($id) 
    { 
        $host = NULL;

		if($id != NULL)
		{
			$q = $this->_db->prepare(HOST_BASIC_REQUEST . ' WHERE id=:id'); 
			$q->bindValue(':id', $id, PDO::PARAM_INT); 
			$q->execute(); 
			
			if($q != NULL)
			{
				$data = $q->fetch(PDO::FETCH_ASSOC); 
				$host = new Host($data);
			}
        }
		
        return $host;
    }
	
	/*
     * Ajoute un lien à une vidéo
     */
    public function setLinkVideo($idVideo, $idHost, $url)
    { 
        if($idVideo != NULL && $idHost != NULL && $url != NULL)
		{
			$q = $this->_db->prepare('INSERT INTO `lienfilm`(`idFilm`, `idHebergeur`, `url`) VALUES (:idV,:idH,:url)'); 
			$q->bindValue(':idV', $idVideo, PDO::PARAM_INT); 
			$q->bindValue(':idH', $idHost, PDO::PARAM_INT);
			$q->bindValue(':url', $url, PDO::PARAM_STR);
			$q->execute();
			
			return true;
        }
		
		return false;
    }
    
    /*
     * Récupère tous les hebergeurs
     */
    public function getHostList() 
    { 
        $hosts = NULL;
        $q = $this->_db->query(HOST_BASIC_REQUEST . ' ORDER BY id');
		
        if($q != NULL)
        {
			$hosts = array();
			
            while ($data = $q->fetch(PDO::FETCH_ASSOC))
            { 
                $hosts[] = new Host($data); 
            } 
        }
		
        return $hosts;
    }
	
	/*
     * Récupère tous les hebergeurs et liens pour un film
     */
    public function getHostListByMovie($movieId) 
    { 
        $hosts = NULL;
        $q = $this->_db->query(LINK_BASIC_REQUEST . "WHERE l.idFilm = " . $movieId);
		
        if($q != NULL)
        {
			$hosts = array();
			
            while ($data = $q->fetch(PDO::FETCH_ASSOC))
            { 
                $hosts[] = new Host($data); 
            } 
        }
		
        return $hosts;
    }
} 
?>