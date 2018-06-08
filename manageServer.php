<?php

require_once('inc/autoload.inc.php');
require_once ('inc/utility.inc.php');

$webpage = new Webpage("Eternight - Gestion du serveur");
$webpage->appendContent(<<<HTML
    <div class="container" style="margin-top: 20px">
        <h1 class="text-primary">GESTION DU SERVEUR</h1>
        <hr class="alert-success">
HTML
);

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

$webpage->appendToHead("<script>function deleteServer(){      
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        alert(this.responseText);
     window.location.href = 'index.php';
    }
  };
  xhttp.open('POST', 'playerDeleteDB.php?server=' + {$server->getIdServer()}, true);
  xhttp.send();
}}</script>");
$webpage->appendContent("<h2>{$server->getNameServer()}</h2>");
$webpage->appendContent("<button onclick='deleteServer()'>Fermer le salon</button>");
echo($webpage->toHTML());

