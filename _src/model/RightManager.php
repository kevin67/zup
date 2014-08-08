<?php 

include_once("model/Right.php");

class RightManager
{ 
    protected $_db; 

    public function __construct()
    { 
        $this->_db= new PDO(SQL_DSN, SQL_USERNAME, SQL_PASSWORD);
		$this->_db->exec("set names utf8");
    }

    /*
     * Récupère un droit
     */
    public function getRight($id) 
    { 
        $right = NULL;

		if($id != NULL)
		{
			$q = $this->_db->prepare(RIGHT_BASIC_REQUEST . ' WHERE id=:id'); 
			$q->bindValue(':id', $id, PDO::PARAM_INT); 
			$q->execute(); 
			
			if($q != NULL)
			{
				$data = $q->fetch(PDO::FETCH_ASSOC); 
				$right = new Right($data);
			}
        }
		
        return $right;
    }
    
    /*
     * Récupère tous les droits
     */
    public function getRightList() 
    { 
        $rights = NULL;
        $q = $this->_db->query(RIGHT_BASIC_REQUEST . ' ORDER BY id');
		
        if($q != NULL)
        {
			$rights = array();
			
            while ($data = $q->fetch(PDO::FETCH_ASSOC))
            { 
                $rights[] = new Right($data); 
            } 
        }
		
        return $rights;
    }
} 
?>