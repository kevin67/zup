<div>
    <h1>Contenu de la page d'accueil ...</h1>
    <p>Blablabla</p>
    
    <?php
        if(true)
        {
            include 'view/page/homeSeriesView.php';
            include 'view/page/homeMoviesView.php';
        }
        else
        {
            include 'view/page/homeMoviesView.php';
            include 'view/page/homeSeriesView.php';
        }
    ?>
</div>