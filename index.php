<?php

require_once('inc/autoload.inc.php');

$webpage = new Webpage("Eternight - Accueil");

$webpage->appendContent(<<<HTML
    <div class="jumbotron text-center">
        <h1>Eternight</h1>
         <p>Parce qu'on avait pas de meilleur nom</p>
    </div>
        <a href="./purpose.php">A propos</a>
        <a href="./rules.php">Règles</a>
        <a href="./connexion.php">Inscription</a>
HTML
    );

if(Users::isConnected()){
    try {
        Servers::getServerByIdOwner($_SESSION['User']->getIdUser());
        $webpage->appendContent('<a href="./manageServer.php">Gestion</a>');
        $webpage->appendContent('<a href="./listPlayers.php">Liste des joueurs</a>');
    }
    catch (Exception $e){
        $webpage->appendContent('<a href="./create.php">Créer / Rejoindre un salon</a>');
    }

}




echo($webpage->toHTML());