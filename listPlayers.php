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

if(Users::isConnected()) {
    $server = Servers::getServerByIdOwner();
    $players = Players::createPlayersByServer($server->getIdServer());
    foreach ($players as $p) {
        $webpage->appendContent($p->getIdPlayer());
    }
}
else {
    header('Location: connexion.php?a=1'.SID);
}

echo($webpage->toHTML());