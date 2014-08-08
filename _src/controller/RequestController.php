<?php
include_once("model/RequestManager.php");
include_once("model/HostManager.php");
include_once("controller/AddMovieController.php");
    
class RequestController
{
    // Constructeur
    public function __construct()   
    {
		$this->RequestManager = new RequestManager();
    }

    // Execution formulaire de requete
    public function formRequest()
    {
		$allocine	= new Allocine(ALLOCINE_PARTNER_KEY, ALLOCINE_SECRET_KEY);
		$result 	= $allocine->search($_POST['filmSearch']);
		$obj 		= json_decode($result);
		$movieList 	= -1;
		
		if(isset($obj->{'feed'}->{'movie'}))
		{
			$movieList = $obj->{'feed'}->{'movie'};
		}
		
		$parameters["validPage"] 	 = "request";
		$parameters["searchKey"] 	 = $_POST['filmSearch'];
		$parameters["alloMovieList"] = $movieList;
		showPage('view/page/alloMovieSearchView.php', $parameters);
    }
    
    // Ajout de la requete
    public function executeRequest()
    {
		$allocine = new Allocine(ALLOCINE_PARTNER_KEY, ALLOCINE_SECRET_KEY);
		$result   = $allocine->get($_GET['num']);
		$obj 	  = json_decode($result);
		
		// Ajout de la requete
		$this->RequestManager->addRequest($obj);
		
		// Vérification et affichage de confirmation
		$code = $obj->{'movie'}->{'code'};
		$name = $obj->{'movie'}->{'originalTitle'};
		
		$parameters["succeed"]  	= $this->RequestManager->verifyRequest($code);
		$parameters["title"] 		= 'Résultat requête';
		$parameters["successMess"] 	= 'Votre requête a bien été soumise ...';
		$parameters["failMess"] 	= 'Votre requête n\'a pas pu être envoyé au serveur ...';
		showPage('view/page/resultView.php', $parameters);
    }
	
	// Liste des requetes
    public function getAllRequest()
    {
		$parameters["requests"] = $this->RequestManager->getAllRequest();
		showPage('view/page/requestListView.php', $parameters);
    }
	
	// Complétion requete
    public function completeRequest()
    {
		$requestId = $_GET['num'];
		$request   = $this->RequestManager->getRequest($requestId);
		
		if($request != null)
		{
			$this->HostManager = new HostManager();
			$hosts = $this->HostManager->getHostList();
			$parameters["hosts"] = $hosts;
			
			$parameters["movieCode"] = $request->getId();
			$parameters["request"] 	 = $request;
			showPage('view/page/addMovieView.php', $parameters);
		}
		else
		{
			$parameters["succeed"]  	= false;
			$parameters["title"] 		= 'Recherche de requête';
			$parameters["failMess"] 	= 'Votre requête n\'a pas pu être trouvé sur le serveur ...';
			showPage('view/page/resultView.php', $parameters);
		}
    }
}
?>