<?php 
include_once("model/RightManager.php");
include_once("model/User.php");

class UserManager 
{ 
    protected $_db; 

    public function __construct()
    { 
        $this->_db= new PDO(SQL_DSN, SQL_USERNAME, SQL_PASSWORD);
		$this->_db->exec("set names utf8");
    }

    /*
     * Récupère un utilisateur en fonction de son ID
     */
    public function getUser($id) 
    { 
        $user = NULL;

        $q = $this->_db->prepare('SELECT id, login, pwd, droitSite FROM user WHERE id=:uid'); 
        $q->bindValue(':uid', $id, PDO::PARAM_INT); 
        $q->execute(); 
        
        if($q != NULL)
        {
            $data = $q->fetch(PDO::FETCH_ASSOC);
			
			if($data != NULL)
			{
				$user = new User($data);
			}
        }
         
        return $user;
    }

    /*
     * Récupère un utilisateur en fonction de son login
     */
    public function getUserByLogin($login)
    {
        $user = NULL;

        $q = $this->_db->prepare('SELECT id, login, pwd, droitSite FROM user WHERE login = :ulogin'); 
        $q->bindValue(':ulogin', $login, PDO::PARAM_STR); 
        $q->execute(); 
        
        if($q != NULL)
        {
            $data = $q->fetch(PDO::FETCH_ASSOC);
			
			if($data != NULL)
			{
				$user = new User($data);
			}
        }
         
        return $user;
    }
    
    /*
     * Récupère tous les utilisateurs
     */
    public function getUserList() 
    { 
        $users = array();
        $q = $this->_db->query('SELECT id, login, pwd, droitSite FROM user ORDER BY id'); 
        if($q != NULL)
        {
            while ($data = $q->fetch(PDO::FETCH_ASSOC))
            { 
                $users[] = new User($data);
            } 
        }
        else
        {
            $users = NULL;
        }
        return $users;
    }

    /*
     * Ajout d'un utilisateur
     */
    public function addUser(user $u)
    { 
        $q = $this->_db->prepare('INSERT INTO user (id, login, pwd) VALUES (:id,:login,:pwd)'); 
        $q->bindValue(':id',    $u->getId(),    PDO::PARAM_INT); 
        $q->bindValue(':login', $u->getLogin(), PDO::PARAM_STR); 
        $q->bindValue(':pwd',  $u->getPass(),  PDO::PARAM_STR);
        $q->execute(); 
    }
    
    /*
     * Modification user
     */
    public function updateUser($pwd) 
    { 
        $q = $this->_db->prepare('UPDATE user SET pwd = :pw WHERE id = :id');
        $q->bindValue(':id', $_SESSION['user']->getId(),    PDO::PARAM_INT);
        $q->bindValue(':pw', $_SESSION['user']->getPass(),  PDO::PARAM_STR);
        $q->execute(); 
    }
	
    /*
     * Suppression user
     */
    public function deleteUser() 
    { 
        $q = $this->_db->prepare('DELETE FROM user WHERE id = :id'); 
        $q->bindValue(':id', $_SESSION['user']->getId()); 
        $q->execute(); 
    }
} 
?>