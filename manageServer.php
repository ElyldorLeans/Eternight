<?php

require_once('inc/autoload.inc.php');
require_once ('inc/utility.inc.php');

$webpage = new Webpage("Eternight - Gestion du serveur");

if(Users::isConnected()) {
    try{
        $server = Servers::getServerByIdOwner($_SESSION['User']->getIdUser());
    }
        //Si la personne ne possède pas de serveur, on la redirige vers l'index
    catch (Exception $e) {
        header('Location: index.php'.SID);
    }
}
//On redirige les personnes déco
else {
    header('Location: connexion.php?a=1'.SID);
}

echo($webpage->toHTML());

