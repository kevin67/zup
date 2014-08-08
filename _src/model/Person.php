<?php
class Person
{
    // Attributs
    private $_id;
    private $_name;
    
    public function __construct(array $data)
    { 
        $this->_id 	 = $data['id'];
        $this->_name = $data['nom'];
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
}
?>