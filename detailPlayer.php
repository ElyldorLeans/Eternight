<?php

require_once('inc/autoload.inc.php');
require_once ('inc/utility.inc.php');

$webpage = new Webpage("Eternight - Détail du joueur");

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
    $webpage->appendContent("<input id='rs' class='form-control' type='text' value='{$playerDisplay->getRoadSheet()}'>Feuille de route</input>");
    $webpage->appendContent("<button onclick='updateRoadSheet()'> Mettre à jour</button>");
    $webpage->appendContent("<button onclick='deletePlayer()'> Supprimer le joueur</button>");
}

$webpage->appendToHead(<<<HTML
<script>
function listRole(){
    var role = document.getElementById("role");
    role.innerHTML = "<select id='rolechange' size='1'>" +
     "<option value='Loup Garou'>Loup Garou</option>" +
     "<option value='Voyante'>Voyante</option>" +
     "<option value='Voyante Corrompue'>Voyante Corrompue</option>" +
     "<option value='Sorcière Corrompue'>Sorcière Corrompue</option>" +
     "<option value='Loup Blanc'>Loup Blanc</option>" +
     "<option value='Statistiscien'>Statistiscien</option>" +
      "</select><button id='undo' onclick='undo()'>Annuler</button><button id='change' onclick='change()'>Changer</button>";
}

function undo(){
    var role = document.getElementById("role");
    role.innerHTML = "<button onclick='listRole()'> Changer le rôle </button>";
}

function change(){

    roleDisplay = document.getElementById("roleDisplay");
    roleValue = document.getElementById("rolechange").options[document.getElementById("rolechange").selectedIndex].value;
    roleDisplay.innerHTML = "Rôle : " + roleValue;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     undo();
    }
  };
  xhttp.open("POST", "playerDetailDB.php?user=" + {$playerDisplay->getIdPlayer()} + "&role=" + roleValue + "&server=" + {$server->getIdServer()}, true);
  xhttp.send();
}

function deletePlayer(){
      var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     window.location.href = "listPlayers.php";
    }
  };
  xhttp.open("POST", "playerDeleteDB.php?user=" + {$playerDisplay->getIdPlayer()} + "&server=" + {$server->getIdServer()}, true);
  xhttp.send();
}

function updateRoadSheet(){

    rs = document.getElementById("rs").value;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
    }
  };
    
  xhttp.open("POST", "updateRoadSheet.php?user=" + {$playerDisplay->getIdPlayer()} + "&rs=" + rs + "&server=" + {$server->getIdServer()}, true);
  xhttp.send();
}

</script>
HTML
);

echo($webpage->toHTML());
