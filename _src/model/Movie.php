<?php
require_once 'model/HostManager.php';

class Movie
{
    // Attributs
    private $_id;
    private $_titre;
    private $_titreOriginal;
	private $_image;
	private $_description;
    private $_bandeAnnonce;
    private $_notePresse;
    private $_noteSpec;
    private $_noteZUP;
    private $_genre;
    private $_nationalite;
	private $_acteurs;
	private $_real;
    
    private $_dateSortie;
    private $_links;
	
    // Constructeurs
    public function __construct(array $data)
    {
		// Données requêtes
        $this->_id =            (isset($data['id']))			? $data['id']			: NULL;
        $this->_titre =         (isset($data['titre']))			? $data['titre']		: NULL;
		$this->_titreOriginal = (isset($data['titreOriginal']))	? $data['titreOriginal']: NULL;
		$this->_image = 		(isset($data['image']))			? $data['image']		: NULL;
        $this->_description =   (isset($data['description']))	? $data['description']	: NULL;
        $this->_bandeAnnonce =  (isset($data['bandeAnnonce']))	? $data['bandeAnnonce']	: NULL;
        $this->_notePresse =    (isset($data['notePresse']))	? $data['notePresse']	: NULL;
        $this->_noteSpec =      (isset($data['noteSpec']))		? $data['noteSpec']		: NULL;
        $this->_noteZUP =       (isset($data['noteZUP']))		? $data['noteZUP']		: NULL;
        $this->_genre =         (isset($data['genre']))			? $data['genre']		: NULL;
        $this->_nationalite =   (isset($data['nationalite']))	? $data['nationalite']	: NULL;
		$this->_acteurs =		(isset($data['acteurs']))		? $data['acteurs']		: NULL;
        $this->_real =   		(isset($data['real']))			? $data['real']			: NULL;
        $this->_dateSortie =    (isset($data['dateSortie']))	? $data['dateSortie']	: NULL;
		
		// Ajout des liens
		$hostMan = new HostManager();
		$this->_links = $hostMan->getHostListByMovie($this->getId());
    }
	
	// Méthodes de lecture
    public function getId()
    { 
        return $this->_id; 
    }

    public function getTitle()
    { 
        return $this->_titre; 
    } 

    public function getOriginalTitle()
    { 
        return $this->_titreOriginal; 
    }

    public function getImage()
    { 
        return $this->_image; 
    } 
	
	public function getDescription()
    { 
        return $this->_description; 
    }
	
	public function getBandeAnnonce()
    { 
        return $this->_bandeAnnonce; 
    } 

    public function getGenre()
    { 
        return $this->_genre; 
    } 

    public function getNationalite()
    { 
        return $this->_nationalite; 
    }

    public function getActeurs()
    { 
        return $this->_acteurs; 
    } 

    public function getReal()
    { 
        return $this->_real; 
    }
	
	public function getDateSortie()
    { 
        return $this->_dateSortie; 
    }

    public function getNoteP()
    { 
        return $this->_notePresse; 
    }
	
	public function getNoteS()
    { 
        return $this->_noteSpec; 
    }
	
	public function getNoteZ()
    { 
        return $this->_noteZUP; 
    }
	
	public function getLinks()
    { 
        return $this->_links; 
    }
}
?>