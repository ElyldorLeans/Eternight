<?php

require_once('./inc/autoload.inc.php');

$webpage = new Webpage("Eternight - Accueil");
$server = Servers::getServers();

$webpage->appendContent(<<<HTML
        <h1>TEST</h1>
HTML
);

foreach($server as $s){
    $proprio = Users::getUserById($s->getIdOwner());
    $webpage->appendContent("<p>{$s->getNameServer()} de {$proprio->getLogin()}</p>");
}

echo($webpage->toHTML());