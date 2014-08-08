<?php
class Serie
{
    // Attributs
    private $_id;
    private $_titre;
    private $_description;
    private $_bandeAnnonce;
    private $_notePresse;
    private $_noteSpec;
    private $_noteZUP;
    private $_genre;
    private $_nationalite;
    
    private $_dateDebut;
    private $_statut;
    private $_format;
    
    // Constructeurs
    public function __construct(array $data)
    { 
        $this->_id =            $data['id']; 
        $this->_titre =         $data['login'];
        $this->_description =   $data['description'];
        $this->_bandeAnnonce =  $data['bandeAnnonce'];
        $this->_notePresse =    $data['notePresse'];
        $this->_noteSpec =      $data['noteSpec'];
        $this->_noteZUP =       $data['noteZUP'];
        $this->_genre =         $data['genre'];
        $this->_nationalite =   $data['nationalite'];
        
        $this->_dateDebut =     $data['dateDebut'];
        $this->_statut =        $data['statut'];
        $this->_format =        $data['format'];
    }
}
?>