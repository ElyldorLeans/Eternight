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
        <a href="./listPlayers.php">Liste des joueurs</a>
        <a href="./manageServer.php">Gestion du serveur</a>
HTML
);
$server = Servers::getServerByIdOwner(1);
$players = Players::createPlayersByServer($server->getIdServer());


foreach($players as $p){
    $webpage->appendContent($p->getIdPlayer());
}

echo($webpage->toHTML());