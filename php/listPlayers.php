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
    try{
        $server = Servers::getServerByIdOwner($_SESSION['User']->getIdUser());
        $players = Players::createPlayersByServer($server->getIdServer());
        $tableHL = "<table><tr><td>Joueurs Hors Ligne</td></tr>";
        $tableIL = "<table><tr><td>Joueurs En Ligne</td></tr>";
        foreach ($players as $p) {
            $c = Users::getUserById($p->getIdPlayer());
            if($c->getIsManual())$tableHL = $tableHL."<tr><td>{$p->getNumPlayer()} - {$p->getRole()}</td></tr>";
            else $tableIL = $tableIL."<tr><td><a href='detailPlayer.php?id={$p->getIdPlayer()}'> {$p->getNumPlayer()} - {$p->getRole()}</a></td></tr>";
        }
        $webpage->appendContent($tableHL."</table>");
        $webpage->appendContent($tableIL."</table>");
    }
    catch(Exception $e){
        header('Location: index.php'.SID);
    }

}
else {
    header('Location: connexion.php?a=1'.SID);
}

echo($webpage->toHTML());
