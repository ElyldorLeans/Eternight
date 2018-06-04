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
HTML
    );

if(Users::isConnected()){
    $user = Users::getInstance();
    if(!$user->inServer() && !$user->ownServer()) $webpage->appendContent('<a href="./create.php">Créer / Rejoindre un salon</a>');
    else {
        if ($user->ownServer()) {
            $webpage->appendContent('<a href="./manageServer.php">Gestion</a>');
            $webpage->appendContent('<a href="./listPlayers.php">Liste des joueurs</a>');
        }
    }
    $webpage->appendContent('<form action="authentification.php"> <button type="submit">Déconnexion</button></form>');
}
else {
    $webpage->appendContent(<<<HTML
        <a href="./connexion.php">Inscription</a>
HTML
);
}




echo($webpage->toHTML());