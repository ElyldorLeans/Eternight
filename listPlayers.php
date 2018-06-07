<?php

require_once('inc/autoload.inc.php');

$webpage = new Webpage("Eternight - Liste des Joueurs");


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
