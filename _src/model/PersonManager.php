<?php 

include_once("model/Person.php");

class PersonManager
{ 
    protected $_db; 

    public function __construct()
    { 
        $this->_db= new PDO(SQL_DSN, SQL_USERNAME, SQL_PASSWORD);
		$this->_db->exec("set names utf8");
    }

    /*
     * Récupère une Personne
     */
    public function getPerson($id) 
    { 
        $pers = NULL;

		if($id != NULL)
		{
			$q = $this->_db->prepare(PERS_BASIC_REQUEST . ' WHERE id=:id'); 
			$q->bindValue(':id', $id, PDO::PARAM_INT); 
			$q->execute(); 
			
			if($q != NULL)
			{
				$data = $q->fetch(PDO::FETCH_ASSOC);
				if ($data != NULL)
				{
					$pers = new Person($data);
				}
			}
        }
		
        return $pers;
    }
	
	/*
     * Récupère une Personne, le crée si il n'existe pas
     */
    public function getSetPerson($id, $nom) 
    { 
        $pers = $this->getPerson($id);

		if($pers == NULL && $id != NULL)
		{
			$q = $this->_db->prepare('INSERT INTO personne (id, nom) VALUES (:id,:nom)'); 
			$q->bindValue(':id',    $id,    PDO::PARAM_INT); 
			$q->bindValue(':nom', $nom, PDO::PARAM_STR);
			$q->execute();
			
			$pers = $this->getPerson($id);
        }
		
        return $pers;
    }
	
	/*
     * Ajoute un personne à une vidéo
     */
    public function setPersonVideo($idVideo, $idPerson, $job, $role, $prior) 
    { 
        if($idVideo != NULL && $idPerson != NULL && $job != NULL)
		{
			$q = $this->_db->prepare('INSERT INTO `role`(`idPersonne`, `idVideo`, `fonction`, `prior`, `role`) VALUES (:idP,:idV,:job,:prior,:role)');
			$q->bindValue(':idV', 	$idVideo, 	PDO::PARAM_INT); 
			$q->bindValue(':idP', 	$idPerson, 	PDO::PARAM_INT);
			$q->bindValue(':job', 	$job, 		PDO::PARAM_INT); 
			$q->bindValue(':prior',	$prior, 	PDO::PARAM_INT);
			$q->bindValue(':role', 	$role, 		PDO::PARAM_STR);
			$q->execute();
			
			return true;
        }
		
		return false;
    }
    
    /*
     * Récupère tous les Personnes
     */
    public function getPersonList() 
    { 
        $pers = NULL;
        $q = $this->_db->query(PERS_BASIC_REQUEST . ' ORDER BY id');
		
        if($q != NULL)
        {
			$pers = array();
			
            while ($data = $q->fetch(PDO::FETCH_ASSOC))
            { 
                $pers[] = new Person($data); 
            } 
        }
		
        return $pers;
    }
} 
?>