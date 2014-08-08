<?php 

include_once("model/Nation.php");

class NationManager
{ 
    protected $_db; 

    public function __construct()
    { 
        $this->_db= new PDO(SQL_DSN, SQL_USERNAME, SQL_PASSWORD);
		$this->_db->exec("set names utf8");
    }

    /*
     * Récupère un Nationalite
     */
    public function getNationalite($id) 
    { 
        $natio = NULL;

		if($id != NULL)
		{
			$q = $this->_db->prepare(NATIO_BASIC_REQUEST . ' WHERE id=:id'); 
			$q->bindValue(':id', $id, PDO::PARAM_INT); 
			$q->execute(); 
			
			if($q != NULL)
			{
				$data = $q->fetch(PDO::FETCH_ASSOC);
				if ($data != NULL)
				{
					$natio = new Nation($data);
				}
			}
        }
		
        return $natio;
    }
	
	/*
     * Récupère un Nationalite, le crée si il n'existe pas
     */
    public function getSetNationalite($id, $label) 
    { 
        $natio = $this->getNationalite($id);

		if($natio == NULL && $id != NULL)
		{
			$q = $this->_db->prepare('INSERT INTO nationalite (id, label) VALUES (:id,:label)'); 
			$q->bindValue(':id',    $id,    PDO::PARAM_INT); 
			$q->bindValue(':label', $label, PDO::PARAM_STR);
			$q->execute();
			
			$natio = $this->getNationalite($id);
        }
		
        return $natio;
    }
	
	/*
     * Ajoute un nationalité à une vidéo
     */
    public function setNatioVideo($idVideo, $idNatio) 
    { 
        if($idVideo != NULL && $idNatio != NULL)
		{
			$q = $this->_db->prepare('INSERT INTO `nationalitevideo`(`idVideo`, `idNationalite`) VALUES (:idV,:idN)'); 
			$q->bindValue(':idV', $idVideo, PDO::PARAM_INT); 
			$q->bindValue(':idN', $idNatio, PDO::PARAM_INT);
			$q->execute();
			
			return true;
        }
		
		return false;
    }
    
    /*
     * Récupère tous les Nationalites
     */
    public function getNationaliteList() 
    { 
        $natios = NULL;
        $q = $this->_db->query(NATIO_BASIC_REQUEST . ' ORDER BY id');
		
        if($q != NULL)
        {
			$natios = array();
			
            while ($data = $q->fetch(PDO::FETCH_ASSOC))
            { 
                $natios[] = new Nation($data); 
            } 
        }
		
        return $natios;
    }
} 
?>