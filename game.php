<?php
require_once('inc/autoload.inc.php');
require_once ('inc/utility.inc.php');

$webpage = new Webpage("Eternight - Jeu");

if(Users::isConnected()) {
    try{
        $user = $_SESSION['User'];
        $server = Servers::getServerByIdPlayer($_SESSION['User']->getIdUser());
        $player = Players::getPlayerById($_SESSION['User']->getIdUser());
        $players = Players::getPlayersForServer($server->getIdServer());
        $idUser = $_SESSION['User']->getIdUser();
        $playersHTML = array();
        $select = "<select id='playerSelect' name='playerSelect'>";
        foreach ($players as $p){
            $playersHTML[$p->getIdPlayer()] = Players::getNamePlayer($p);
            if($p->getIdPlayer() != $idUser){
                $select = $select."<option value ='".$p->getIdPlayer()."'>".Players::getNamePlayer($p)."</option>";
            }
        }


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

    function voteWhiteLych() {
        var div = document.getElementById("divPlayer");
        div.innerHTML = "{$select}<option value='-1'>Personne</option></select><button onclick='submitVoteWhiteLych()'>Valider</button>";
    }
    
    function voteCorruptedPsy(){
        alert("bite");
    }
    
    function voteCorruptedSorc(){
       alert("bite"); 
    }
    
    function voteLych() {
      var div = document.getElementById("divPlayer");
        div.innerHTML = "{$select}<option value='-1'>Personne</option></select><button onclick='submitVoteLych()'>Valider</button>";
    }
    
    function votePsy(){
        alert("bite");
    }
    
    function voteStat(){
    alert("bite");
    }
    
    
    function submitVoteWhiteLych() {
        var idt = document.getElementById("playerSelect").options[document.getElementById("playerSelect").selectedIndex].value;
        if(idt != -1){
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                alert(this.responseText);
                voteLych();
            }
        };
        xhttp.open("POST", "gameDB.php?server=" + {$server->getIdServer()} + "&idwl=" + {$idUser} + "&idt=" + idt, true);
        xhttp.send();
    }
    else {
            voteLych();
    }  
}

    function submitVoteLych() {
        var idt = document.getElementById("playerSelect").options[document.getElementById("playerSelect").selectedIndex].value;
        if(idt != -1){
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                alert(this.responseText);
                voteLych();
            }
        };
        xhttp.open("POST", "gameDB.php?server=" + {$server->getIdServer()} + "&idwl=" + {$idUser} + "&idt=" + idt, true);
        xhttp.send();
    }
    else {
            voteLych();
    }  
}

function getFormByRole(){
    var role = "{$player->getRole()}";
    document.getElementById("phase").innerHTML = "Phase de Pouvoirs";
    var div = document.getElementById("divPlayer");
    switch(role){
        case "Loup Blanc":
            voteWhiteLych();
            break;
        case "Voyante Corrompue":
            voteCorruptedPsy();
            break;
        case "Sorcière Corrompue":
            voteCorruptedSorc();
            break;
        case "Voyante":
            votePsy();
            break;
        case "Loup Garou":
            voteLych()
            break;
        case "Statistiscien":
            voteStat();
            break;
    }
}

    
$(document).ready(function () {
    var myVar;
    var phase = "{$player->getPhase()}";
    switch(phase){
        case "0":
            myVar = setInterval(checkReady,1000);
            break;
        case "1":
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
                    clearInterval(myVar);
                    getFormByRole();
                }
            }
        };
        xhttp.open("POST", "gameDB.php?server=" + {$server->getIdServer()}, true);
        xhttp.send();
        
    }  
});
</script>
HTML
);
$webpage->appendContent(<<<HTML
    <div class="container" style="margin-top: 20px">
        <h1 class="text-primary">{$player->getNumPlayer()} - {$user->getLogin()}</h1>
        <hr class="alert-success">
        
        <h2>Salon : {$server->getNameServer()}</h2>
        <button class="btn btn-warning" onclick='quitServer()'>Quitter le salon</button>
        <hr class="alert-success">
        <h2 id='phase'>Phase de répartition</h2>
        <div id='divPlayer'></div>
    </div>
</div>
HTML
);




echo($webpage->toHTML());