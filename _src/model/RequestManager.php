<?php 
include_once("model/Request.php");

class RequestManager 
{ 
    protected $_db; 

    public function __construct()
    { 
        $this->_db= new PDO(SQL_DSN, SQL_USERNAME, SQL_PASSWORD);
		$this->_db->exec("set names utf8");
    }

    /*
     * Envoi d'une requete
     */
    public function addRequest($obj)
    {
		$code = $obj->{'movie'}->{'code'};
		$name = $obj->{'movie'}->{'originalTitle'} . " (" . $obj->{'movie'}->{'productionYear'} . ")";
		$user = unserialize($_SESSION['user'])->getId();
		$url  = "http://www.allocine.fr/film/fichefilm_gen_cfilm=" . $obj->{'movie'}->{'code'} . ".html";
		
        $q = $this->_db->prepare('INSERT INTO `requete`(`idAllocine`, `nom`, `demandeur`, `url`, `data`) VALUES (:id,:name,:user,:url,:data)'); 
        $q->bindValue(':id',    $code, PDO::PARAM_INT); 
        $q->bindValue(':name', 	$name, PDO::PARAM_STR); 
        $q->bindValue(':user',  $user, PDO::PARAM_INT); 
        $q->bindValue(':url', 	$url,  PDO::PARAM_STR); 
        $q->bindValue(':data', 	json_encode($obj), PDO::PARAM_STR);
        $q->execute(); 
    }
    
    /*
     * Vérification requete
     */
    public function verifyRequest($id)
    {
		$res = false;

        $q = $this->_db->prepare('SELECT EXISTS(SELECT idAllocine FROM requete WHERE idAllocine = :id) AS "exist";'); 
        $q->bindValue(':id', $id, PDO::PARAM_INT); 
        $q->execute(); 
        
        if($q != NULL)
        {
            $data = $q->fetch(PDO::FETCH_ASSOC);
			
            if($data["exist"] == 1)
			{
				$res = true;
			}
        }
		
        return $res;
    }
	
	/*
     * Récupération d'une requete
     */
    public function getRequest($id)
    {
		$request = NULL;

        $q = $this->_db->prepare(REQUEST_BASIC_REQUEST . 'WHERE idAllocine = :id'); 
        $q->bindValue(':id', $id, PDO::PARAM_INT); 
        $q->execute(); 
        
        if($q != NULL)
        {
			$data = $q->fetch(PDO::FETCH_ASSOC);
			if($data != null)
			{
				$request = new Request($data);
			}
        }
		
        return $request;
    }
    
    /*
     * Liste des requêtes
     */
    public function getAllRequest() 
    {
		$requests = NULL;
		
		$q = $this->_db->query(REQUEST_BASIC_REQUEST . 'ORDER BY r.completer, r.id');
		
        if($q != NULL)
        {
			$requests = array();
        
            while ($data = $q->fetch(PDO::FETCH_ASSOC))
            {
				if($data != null)
				{
					$requests[] = new Request($data);
				}
            } 
        }
		
        return $requests;
    }
    
	/*
     * Validation requete
     */
    public function validRequest($idR, $idV) 
    {
		if($this->verifyRequest($idR))
		{
			$q = $this->_db->prepare('UPDATE `requete` SET `completer`=:idV WHERE `idAllocine`=:idR;'); 
			$q->bindValue(':idV', $idV, PDO::PARAM_INT); 
			$q->bindValue(':idR', $idR, PDO::PARAM_INT);
			$q->execute();
		}
    }
} 
?>