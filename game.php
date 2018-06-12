<?php
require_once('inc/autoload.inc.php');
require_once('inc/utility.inc.php');

$webpage = new Webpage("Eternight - Jeu");
$webpage->appendContent(<<<HTML
    <div class="container" style="margin-top: 20px">
        <h1 class="text-primary"></h1>
        <hr class="alert-success" >
HTML
);

if (Users::isConnected()) {
    try {
        $user = $_SESSION['User'];
        $server = Servers::getServerByIdPlayer($_SESSION['User']->getIdUser());
        $player = Players::getPlayerById($_SESSION['User']->getIdUser());
        $players = Players::getPlayersForServer($server->getIdServer());
        $idUser = $_SESSION['User']->getIdUser();
        $playersHTML = array();
        $select = "<select id='playerSelect' name='playerSelect'>";
        $selectMultiple = "<select multiple id='playerSelect' name='playerSelect'>";
        foreach ($players as $p) {
            $playersHTML[$p->getIdPlayer()] = Players::getNamePlayer($p);
            if ($p->getIdPlayer() != $idUser) {
                $select = $select . "<option value ='" . $p->getIdPlayer() . "'>" . Players::getNamePlayer($p) . "</option>";
                $selectMultiple = $selectMultiple . "<option value ='" . $p->getIdPlayer() . "'>" . Players::getNamePlayer($p) . "</option>";
            }
        }


    } //Si la personne ne possède pas de serveur, on la redirige vers l'index
    catch (Exception $e) {
        header('Location: index.php' . SID);
    }
} //On redirige les personnes déco
else {
    header('Location: connexion.php?a=1' . SID);
}

$webpage->appendToHead(<<<HTML
<script>
var myVar;

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

    function checkPowerPhaseEnded(){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                div = document.getElementById("divPlayer");
                if(this.responseText == "POWER_ENDED"){
                    clearInterval(myVar);
                    document.getElementById("phase").innerHTML = "Phase de délibération";
                    myVar = setInterval(checkDelibPhaseEnded(),1000);
                }
                else {
                    div.innerHTML = "En attente de la fin de la phase de pouvoirs";
                }
            }
        };
        xhttp.open("POST", "phaseDB.php?server=" + {$server->getIdServer()} + "&p=2", true);
        xhttp.send();
    }
    
        function checkDelibPhaseEnded(){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                div = document.getElementById("divPlayer");
                if(this.responseText == "DELIB_ENDED"){
                    clearInterval(myVar);
                    document.getElementById("phase").innerHTML = "Phase de vote";
                }
                else {
                    div.innerHTML = "En attente de la fin de la phase";
                }
            }
        };
        xhttp.open("POST", "phaseDB.php?server=" + {$server->getIdServer()} + "&p=3", true);
        xhttp.send();
    }

    function voteWhiteLych() {
        var div = document.getElementById("divPlayer");
        div.innerHTML = "{$select}<option value='-1'>Personne</option></select><button onclick='submitVoteWhiteLych()'>Valider</button>";
    }
    
    function voteCorruptedPsy(){
        const div = document.getElementById("divPlayer");
        div.innerHTML = "{$select}</select><button onclick='submitVoteCorruptedPsy()'>Valider</button>";
    }
    
    function voteCorruptedSorc(){
        if ({$player->getValueInRoleInfos("sorcererPower")}) {
            voteLych();
            return;
        }
        const div = document.getElementById("divPlayer");
        div.innerHTML = "{$select}<option value='-1'>Personne</option></select><button onclick='submitVoteCorruptedSorc()'>Valider</button>";
    }
    
    function voteLych() {
        const div = document.getElementById("divPlayer");
        div.innerHTML = "{$select}<option value='-1'>Personne</option></select><button onclick='submitVoteLych()'>Valider</button>";
    }
    
    function votePsy(){
        const div = document.getElementById("divPlayer");
        div.innerHTML = "{$select}</select><button onclick='submitVotePsy()'>Valider</button>";
    }
    
    function voteStat(){
        const div = document.getElementById("divPlayer");
        div.innerHTML = "{$selectMultiple}</select><button onclick='submitVoteStat()'>Valider</button>";
    }
    
    
function submitVoteWhiteLych() {
    const idt = document.getElementById("playerSelect").options[document.getElementById("playerSelect").selectedIndex].value;
    if(idt != -1){
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                //alert(this.responseText);
                voteLych();
            }
        };
        xhttp.open("POST", "gameDB.php?server=" + {$server->getIdServer()} + "&idwl=" + {$idUser} + "&idt=" + idt, true);
        xhttp.send();
    } else {
        voteLych();
    }  
}

function submitVoteCorruptedSorc() {
    const idt = document.getElementById("playerSelect").options[document.getElementById("playerSelect").selectedIndex].value;
    if(idt != -1){
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                //alert(this.responseText);
                voteLych();
            }
        };
        xhttp.open("POST", "gameDB.php?server=" + {$server->getIdServer()} + "&idcs" + {$idUser} + "&idt=" + idt, true);
        xhttp.send();
    } else {
        voteLych();
    }  
}
    
function submitVoteCorruptedPsy() {
    const idt = document.getElementById("playerSelect").options[document.getElementById("playerSelect").selectedIndex].value;
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            //alert(this.responseText);
            voteLych();
        }
    };
    xhttp.open("POST", "gameDB.php?server=" + {$server->getIdServer()} + "&idcp=" + {$idUser} + "&idt=" + idt, true);
    xhttp.send();
}
    
function submitVotePsy() {
    const idt = document.getElementById("playerSelect").options[document.getElementById("playerSelect").selectedIndex].value;
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            //alert(this.responseText);
            myVar = setInterval(checkPowerPhaseEnded,1000);
        }
    };
    xhttp.open("POST", "gameDB.php?server=" + {$server->getIdServer()} + "&idp=" + {$idUser} + "&idt=" + idt, true);
    xhttp.send();
}

function submitVoteLych() {
    const idt = document.getElementById("playerSelect").options[document.getElementById("playerSelect").selectedIndex].value;
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            //alert(this.responseText);
            myVar = setInterval(checkPowerPhaseEnded,1000);
        }
    };
    xhttp.open("POST", "gameDB.php?server=" + {$server->getIdServer()} + "&idww=" + {$idUser} + "&idt=" + idt, true);
    xhttp.send(); 
}
    
function submitVoteStat() {
    const selectedValues = [];
    $("#playerSelect :selected").each(function(){
        selectedValues.push($(this).val()); 
    });
    // alert(selectedValues);
    if (selectedValues.length !== 3) {
        return;
    }
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            // alert(this.responseText);
            myVar = setInterval(checkPowerPhaseEnded, 1000);
        }
        xhttp.open("POST", "gameDB.php?server=" + {$server->getIdServer()} + "&idstat=" + {$idUser} + "&idt1="
            + selectedValues[0] + "&idt2=" + selectedValues[1] + "&idt3=" + selectedValues[2], true);
        xhttp.send();
    }
}

function getFormByRole(){
    const role = "{$player->getRole()}";
    document.getElementById("phase").innerHTML = "Phase de Pouvoirs";
    const div = document.getElementById("divPlayer");
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
            voteLych();
            break;
        case "Statistiscien":
            voteStat();
            break;
    }
}

    
$(document).ready(function () {
    const phase = "{$player->getPhase()}";
    switch(phase){
        case "0":
            myVar = setInterval(checkReady,1000);
            break;
        case "1":
            getFormByRole();
            break;
        case "2":
            clearInterval(myVar);
            myVar = setInterval(checkPowerPhaseEnded,1000);
            break;
        case "3":
            myVar = setInterval(checkReady,1000);
            break;
        case "4":
            myVar = setInterval(checkReady,1000);
            break;
        case "5":
            myVar = setInterval(checkReady,1000);
            break;
        default :
            break;
    }
    
    function checkReady(){
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                div = document.getElementById("divPlayer");
                if(this.responseText == "REPART_ENDED"){
                    clearInterval(myVar);
                    getFormByRole();
                }
                else {
                    div.innerHTML = "En attente de la répartition";
                }
            }
        };
        xhttp.open("POST", "phaseDB.php?server=" + {$server->getIdServer()} + "&p=1", true);
        xhttp.send();
        
    }
    
    // Have max 3 choices in choice for Statistiscien
    arr = [];
    $("select[multiple]").change(function() {
        $(this).find("option:selected");
        if ($(this).find("option:selected").length > 3) {
            $(this).find("option").removeAttr("selected");
            $(this).val(arr);
        }
        else {
            arr = [];
            $(this).find("option:selected").each(function(index, item) {
                arr.push($(item).val());
            });
        }
    });
});
</script>
HTML
);

$webpage->appendContent("<h2>{$server->getNameServer()}</h2>");
$webpage->appendContent("<h3>{$player->getNumPlayer()} - {$user->getLogin()}</h3>");
$webpage->appendContent("<button class='btn btn-warning' onclick='quitServer()'>Quitter le salon</button>");
$webpage->appendContent("<h2 id='phase'>Phase de répartition</h2>");
$webpage->appendContent("<div id='divPlayer'></div>");


echo($webpage->toHTML());