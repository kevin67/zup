<?php
class Request
{
    // Attributs
    private $_idAllocine;
    private $_name;
    private $_asker;
    private $_date;
	private $_url;
    private $_completed;
	
	public function __construct(array $data)
    { 
        $this->_idAllocine 	= $data['idAllocine']; 
        $this->_name		= $data['nom'];
        $this->_asker 		= $data['login'];		
        $this->_date 		= $data['date'];
		$this->_url 		= $data['url'];
		$this->_completed 	= $data['completer'];
    }

    // Méthodes de lecture
    public function getId()
    { 
        return $this->_idAllocine; 
    } 

    public function getName()
    { 
        return $this->_name; 
    }

    public function getAsker()
    { 
        return $this->_asker; 
    }
	
    public function getDate()
    { 
        return $this->_date; 
    }

    public function getUrl()
    { 
        return $this->_url; 
    }

    public function getCompleted()
    { 
        return $this->_completed; 
    }
}
?>