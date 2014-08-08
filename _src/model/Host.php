<?php
class Host
{
    // Attributs
    private $_id;
    private $_name;
    private $_url;
	private $_link;
    
    public function __construct(array $data)
    { 
        $this->_id 	 = $data['id'];
        $this->_name = $data['nom']; 
        $this->_url  = $data['url'];
		$this->_link = (isset($data['link']))	? $data['link']: NULL;
    }

    // Méthodes de lecture
    public function getId()
    { 
        return $this->_id; 
    } 

    public function getName()
    { 
        return $this->_name; 
    } 

    public function getUrl()
    { 
        return $this->_url; 
    }

    public function getLink()
    { 
        return $this->_link; 
    }
}
?>