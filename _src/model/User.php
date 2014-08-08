<?php
class User
{
    // Attributs
    private $_id;
    private $_login;
    private $_pwd;
	private $_right;
    
    /*
     * Ajouter :
     * - tableau de "Mes séries"
     * - variables d'apparence
     */

    // Constructeurs
    public function __construct()
    {
        $ctp = func_num_args();
        $args = func_get_args();
        switch($ctp)
        {
            case 1: $this->constructeurFromArray($args[0]);
                break;

            case 2: $this->constructeurFromData($args[0],$args[1]);
                break;

            default: break;
        }
    }
    
    public function constructeurFromArray(array $data)
    { 
        $this->_id = $data['id']; 
        $this->_login = $data['login']; 
        $this->_pwd = $data['pwd'];
		$this->_right = $data['droitSite'];
    }

    public function constructeurFromData($login, $pwd)
    { 
        $this->_id = NULL; 
        $this->_login = $login;
        $this->_pwd = $pwd;
    }
    
    // Méthodes d'écritures
    public function setId($id)
    { 
        $id = (int) $id; 
        if ($id > 0)
        {
            $this->_id = $id; 
        } 
    } 

    public function setLogin($log)
    { 
        if(is_string($log))
        { 
            $this->_login = $log; 
        } 
    } 

     public function setPwd($pwd)
    { 
        if(is_string($pwd))
        { 
            $this->_pwd = $pwd;
        } 
    } 

    // Méthodes de lecture
    public function getId()
    { 
        return $this->_id; 
    } 

    public function getLogin()
    { 
        return $this->_login; 
    }

    public function getPwd()
    { 
        return $this->_pwd; 
    }
	
    public function getRight()
    { 
        return $this->_right; 
    }
}
?>