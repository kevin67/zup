<?php
class Genre
{
    // Attributs
    private $_id;
    private $_label;
    
    public function __construct(array $data)
    { 
        $this->_id 	 = $data['id'];
        $this->_label = $data['label'];
    }

    // Méthodes de lecture
    public function getId()
    { 
        return $this->_id; 
    } 

    public function getLabel()
    { 
        return $this->_label; 
    }
}
?>