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
    $webpage->appendContent(<<<HTML
    <div class="container" style="margin-top: 20px">
        <h1 class="text-primary">{$playerDisplay->getNumPlayer()} - {$userDisplay->getLogin()}</h1>
        <hr class="alert-success">
        
        <h2 id='roleDisplay'>Rôle : {$playerDisplay->getRole()}</h2>
        <div id='role'  style="margin-top: 20px">
            <button class="btn btn-success" onclick='listRole()'> Changer le rôle </button>
        </div>
        <button class="btn btn-warning" onclick='deletePlayer()' style="margin-top: 5px"> Supprimer le joueur</button>
        <hr class="alert-success">
        <div class="form-group">
            <h2>Feuille de route</h2>
            <textarea class="col-sm-8 form-control" id="rs" type='text' rows="7" style="margin-top: 20px" value='{$playerDisplay->getRoadSheet()}'>{$playerDisplay->getRoadSheet()}</textarea>
            <button class="btn btn-success" onclick='updateRoadSheet()' style="margin-top: 5px"> Mettre à jour</button>
        </div>
    </div>
HTML
    );
}

$webpage->appendToHead(<<<HTML
<script>
function listRole(){
    var role = document.getElementById("role");
    role.innerHTML = "<select class='custom-select col-sm-3' id='rolechange' size='1'>" +
     "<option value='Loup Garou'>Loup Garou</option>" +
     "<option value='Voyante'>Voyante</option>" +
     "<option value='Voyante Corrompue'>Voyante Corrompue</option>" +
     "<option value='Sorcière Corrompue'>Sorcière Corrompue</option>" +
     "<option value='Loup Blanc'>Loup Blanc</option>" +
     "<option value='Statisticien'>Statisticien</option>" +
      "</select><button class='btn btn-info' id='undo' onclick='undo()' style='margin-left: 5px'>Annuler</button><button class='btn btn-success' id='change' onclick='change()' style='margin-left: 3px'>Changer</button>";
}

function undo(){
    var role = document.getElementById("role");
    role.innerHTML = "<button class='btn btn-success' onclick='listRole()'> Changer le rôle </button>";
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
  role.innerHTML = "<button class='btn btn-success' onclick='listRole()' style='margin-left: 3px'> Changer le rôle </button>";
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
