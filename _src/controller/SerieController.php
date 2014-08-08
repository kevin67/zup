<?php

class SerieController
{
    // Constructeur
    public function __construct()   
    {
    }

    // Liste des films
    public function listSeries()
    {
        showPage('view/page/serieListView.php', NULL);
    }
    
    // Affiche film
    public function serie($id)
    {
        $parameters = array(
            'id' => $id
        );
        
        showPage('view/page/serieView.php', $parameters);
    }
}
?>