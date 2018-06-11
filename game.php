<?php
require_once('inc/autoload.inc.php');
require_once ('inc/utility.inc.php');

$webpage = new Webpage("Eternight - Jeu");
$webpage->appendContent(<<<HTML
    <div class="container" style="margin-top: 20px">
        <h1 class="text-primary"></h1>
        <hr class="alert-success">
HTML
);

if(Users::isConnected()) {
    try{
        $user = $_SESSION['User'];
        $server = Servers::getServerByIdPlayer($_SESSION['User']->getIdUser());
        $player = Players::getPlayerById($_SESSION['User']->getIdUser());
        $players = Players::getPlayersForServer($server->getIdServer());
        $idUser = $_SESSION['User']->getIdUser();
        $playersHTML = array();
        $select = "<select name='player'>";
        foreach ($players as $p){
            $playersHTML[$p->getIdPlayer()] = Players::getNamePlayer($p);
            if(!$p->getIdPlayer() == $idUser){
                $select = $select."<option value ='".$p->getIdPlayer()."'>".Players::getNamePlayer($p)."</option>";
            }
        }
        $select = $select."</select>";


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

$webpage->appendToHead(<<<HTML
<script>
function quitServer(){
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function(){
    if (this.readyState == 4 && this.status == 200) {
     window.location.href = "index.php";
    }
  };
  xhttp.open("POST", "quitServerDB.php?id=" + {$idUser}, true);
  xhttp.send();
}
function getFormByRole(){
    var role = {$player->getRole()}
    document.getElementById("phase").innerHTML = "Phase de Pouvoirs";
    var div = document.getElementById("divPlayer");
    switch(role){
        case "Loup Blanc":
            
            break;
        case "Voyante Corrompue":
            break;
        case "Sorcière Corrompue":
            break;
        case "Voyante":
            break;
        case "Loup Garou":
            break;
        case "Statistiscien":
            break;
    }
}
var myVar;
var phase = {$player->getPhase()};
switch(phase){
    case 0:
        myVar = setInterval(checkReady,1000);
        break;
    case 1:
        getFormByRole();
        break;
    case 2:
        myVar = setInterval(checkReady,1000);
        break;
    case 3:
        myVar = setInterval(checkReady,1000);
        break;
    case 4:
        myVar = setInterval(checkReady,1000);
        break;
    case 5:
        myVar = setInterval(checkReady,1000);
        break;
    default :
        break;
}

 myVar = setInterval(checkReady, 1000);

function checkReady(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            div = document.getElementById("divPlayer");
            if(this.responseText == "NOT_READY"){
                div.innerHTML = "En attente de la répartition";
            }
            else {
                clearInterval(ready);
                getFormByRole();
            }
        }
    };
    xhttp.open("POST", "gameDB.php?server=" + {$server->getIdServer()}, true);
    xhttp.send();
    
}

</script>
HTML
);

$webpage->appendContent("<h2>{$server->getNameServer()}</h2>");
$webpage->appendContent("<h3>{$player->getNumPlayer()} - {$user->getLogin()}</h3>");
$webpage->appendContent("<button class='btn btn-warning' onclick='quitServer()'>Quitter le salon</button>");
$webpage->appendContent("<h2 id='phase'>Phase de répartition</h2>");
$webpage->appendContent("<div id='divPlayer'></div>");




echo($webpage->toHTML());