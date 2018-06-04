<?php

require_once('inc/autoload.inc.php');
require_once ('inc/utility.inc.php');

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

if(verify($_GET,"id")){
    $userDisplay = Users::getUserById($_GET["id"]);
    $playerDisplay = Players::getPlayerById($_GET["id"]);
    $webpage->appendContent("<h1>".$playerDisplay->getNumPlayer()." - ".$userDisplay->getLogin()."</h1>");
    $webpage->appendContent("<h2 id='roleDisplay'> Rôle : ".$playerDisplay->getRole()."</h2>");
    $webpage->appendContent("<div id='role'><button onclick='listRole()'> Changer le rôle </button></div>");
    $webpage->appendContent("<input type='text' value='{$playerDisplay->getRoadSheet()}'></input>");
    $webpage->appendContent("<button onclick='delete()'> Supprimer le joueur</button>");
}

$webpage->appendToHead(<<<HTML
<script>
function listRole(){
    var role = document.getElementById("role");
    role.innerHTML = "<select id='rolechange' size='1'><option value='Loup Garou'>Loup Garou</option><option value='Voyante'>Voyante</option></select><button id='undo' onclick='undo()'>Annuler</button><button id='change' onclick='change()'>Changer</button>";
}

function undo(){
    var role = document.getElementById("role");
    role.innerHTML = "<button onclick='listRole()'> Changer le rôle </button>";
}

function change(){

    roleDisplay = document.getElementById("roleDisplay");
    roleValue = document.getElementById("rolechange").options[document.getElementById("rolechange").selectedIndex].value;
    roleDisplay.innerHTML = "Rôle : " + roleValue;
    $.ajax({
        url : 'playerDetailDB.php',
        type : 'POST',
        data : 'user=' + {$playerDisplay->getNumPlayer()} + '&server=' + {$server->getIdServer()} + '&role=' + roleValue,
        success : undo()
    });
}
</script>
HTML
);

echo($webpage->toHTML());