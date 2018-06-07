<?php

require_once('inc/autoload.inc.php');

$webpage = new Webpage("Eternight - Accueil");

$webpage->appendContent(<<<HTML
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand">
        <img src="https://placeholdit.imgix.net/~text?txtsize=33&amp;txt=350%C3%97150&amp;w=150&amp;h=150">
    </a>
    <a>
        <h1>Eternight</h1>
        <p>Parce qu'on avait pas de meilleur nom</p>
    </a>
</nav>
<div class="bs-component">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="./purpose.php">A propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./rules.php">Règles</a>
                </li>
            </ul>
        </div>
    </nav>
</div>
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
