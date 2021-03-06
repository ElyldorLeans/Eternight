<?php
require_once('inc/autoload.inc.php');
require_once('inc/utility.inc.php');
$webpage = new Webpage("Eternight - Jeu");
$webpage->appendContent(<<<HTML
    <div class="container" style="margin-top: 20px">
        <h1 class="text-primary">JEU</h1>
        <hr class="alert-success">
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
        $select = "<label for='playerSelect' class='col-sm-1 col-form-label'>Cible</label><select class='custom-select col-sm-3' id='playerSelect' name='playerSelect'>";
        $selectMultiple = "<label for='playerSelect' class='col-sm-1 col-form-label'>Cibles</label><select class='custom-select col-sm-3' multiple id='playerSelect' name='playerSelect'>";
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

function getFormByRole(){
    var role = "{$player->getRole()}";
    document.getElementById("phase").innerHTML = "Phase de Pouvoirs";
    var div = document.getElementById("divPlayer");
    div.innerHTML = "test";
    switch(role){
        case "Loup Blanc":
            //alert("lol");
            voteWhiteLych();
            break;
        case "Voyante Corrompue":
            //alert("lol");
            voteCorruptedPsy();
            break;
        case "Sorcière Corrompue":
            //alert("lol");
            voteCorruptedSorc();
            break;
        case "Voyante":
            //alert("lol");
            votePsy();
            break;
        case "Loup Garou":
            //alert("lol");
            voteLych();
            break;
        case "Statisticien":
            //alert("lol");
            voteStat();
            break;
    }
}
    function checkPowerPhaseEnded(){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                div = document.getElementById("divPlayer");
                if(this.responseText == "POWER_ENDED"){
					clearInterval(myVar);
					document.getElementById("phase").innerHTML = "Phase de Délibérations";
                    myVar = setInterval(checkDelibPhaseEnded,1000);
                }
                else {
					if ({$player->getIsDead()}) {
						div.innerHTML = "Tu es mort et ne peux donc pas faire ton pouvoir.";
					} else {
						div.innerHTML = "En attente de la fin de la phase de pouvoirs";
					}
                }
            }
        };
        xhttp.open("POST", "phaseDB.php?server=" + {$server->getIdServer()} + "&p=2", true);
        xhttp.send();
    }
    
        function checkDelibPhaseEnded(){
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                div = document.getElementById("divPlayer");
                if(this.responseText == "DELIB_ENDED"){
                    clearInterval(myVar);
                    document.getElementById("phase").innerHTML = "Phase de vote du village";
                    voteVillage();
                }
                else {
                    div.innerHTML = "En attente de la fin de la phase de délibérations";
                }
            }
        };
        xhttp.open("POST", "phaseDB.php?server=" + {$server->getIdServer()} + "&p=3", true);
        xhttp.send();
    }
    
    function checkVotePhaseEnded(){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                div = document.getElementById("divPlayer");
                if(this.responseText == "VOTE_ENDED"){
                    clearInterval(myVar);
                    document.getElementById("phase").innerHTML = "Phase de Pouvoirs";
                    getFormByRole();
                }
                else {
					if ({$player->getIsDead()}) {
						div.innerHTML = "Tu es mort et ne peux donc pas voter.";
					} else {
						div.innerHTML = "En attente de la fin de la phase de vote.";
					}
                }
            }
        };
        xhttp.open("POST", "phaseDB.php?server=" + {$server->getIdServer()} + "&p=4", true);
        xhttp.send();
    }
    function voteWhiteLych() {
        var div = document.getElementById("divPlayer");
        div.innerHTML = "{$select}<option value='-1'>Personne</option></select><button class='btn btn-success' style='margin-left: 5px' onclick='submitVoteWhiteLych()'>Valider</button>";
    }
    
    function voteCorruptedPsy(){
        var div = document.getElementById("divPlayer");
        div.innerHTML = "{$select}</select><button class='btn btn-success' style='margin-left: 5px' onclick='submitVoteCorruptedPsy()'>Valider</button>";
    }
    
    function voteCorruptedSorc(){
        if ({$player->getValueInRoleInfos("sorcererPower")}) {
            voteLych();
            return;
        }
        var div = document.getElementById("divPlayer");
        div.innerHTML = "{$select}<option value='-1'>Personne</option></select><button class='btn btn-success' style='margin-left: 5px' onclick='submitVoteCorruptedSorc()'>Valider</button>";
    }
    
    function voteLych() {
      var div = document.getElementById("divPlayer");
        div.innerHTML = "Vote pour la cible du loup garou<br>{$select}<option value='-1'>Personne</option></select><button class='btn btn-success' style='margin-left: 5px' onclick='submitVoteLych()'>Valider</button>";
    }
    
    function votePsy(){
        var div = document.getElementById("divPlayer");
        div.innerHTML = "{$select}</select><button class='btn btn-success' style='margin-left: 5px' onclick='submitVotePsy()'>Valider</button>";
    }
    
    function voteStat(){
        var div = document.getElementById("divPlayer");
        div.innerHTML = "{$selectMultiple}</select><button class='btn btn-success' style='margin-left: 5px' onclick='submitVoteStat()'>Valider</button>";
    }
    
    function voteVillage(){
        var div = document.getElementById("divPlayer");
        div.innerHTML = "{$select}<option value='-1'>Personne</option></select><button class='btn btn-success' style='margin-left: 5px' onclick='submitVoteVillage()'>Valider</button>";
    }
    
    
function submitVoteWhiteLych() {
    var idt = document.getElementById("playerSelect").options[document.getElementById("playerSelect").selectedIndex].value;
    if(idt != -1){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                ////alert(this.responseText);
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
    var idt = document.getElementById("playerSelect").options[document.getElementById("playerSelect").selectedIndex].value;
    if(idt != -1){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                ////alert(this.responseText);
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
    var idt = document.getElementById("playerSelect").options[document.getElementById("playerSelect").selectedIndex].value;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            ////alert(this.responseText);
            voteLych();
        }
    };
    xhttp.open("POST", "gameDB.php?server=" + {$server->getIdServer()} + "&idcp=" + {$idUser} + "&idt=" + idt, true);
    xhttp.send();
}
    
function submitVotePsy() {
    var idt = document.getElementById("playerSelect").options[document.getElementById("playerSelect").selectedIndex].value;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            ////alert(this.responseText);
            myVar = setInterval(checkPowerPhaseEnded,1000);
        }
    };
    xhttp.open("POST", "gameDB.php?server=" + {$server->getIdServer()} + "&idp=" + {$idUser} + "&idt=" + idt, true);
    xhttp.send();
}
function submitVoteLych() {
    var idt = document.getElementById("playerSelect").options[document.getElementById("playerSelect").selectedIndex].value;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            ////alert(this.responseText);
            myVar = setInterval(checkPowerPhaseEnded,1000);
        }
    };
    xhttp.open("POST", "gameDB.php?server=" + {$server->getIdServer()} + "&idww=" + {$idUser} + "&idt=" + idt, true);
    xhttp.send(); 
}
    
function submitVoteStat() {
    var selectedValues = [];
    $("#playerSelect :selected").each(function(){
        selectedValues.push($(this).val()); 
    });
    ////alert(selectedValues);
    if (selectedValues.length !== 3) {
        return;
    }
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            ////alert(this.responseText);
            myVar = setInterval(checkPowerPhaseEnded, 1000);
        }
        xhttp.open("POST", "gameDB.php?server=" + {$server->getIdServer()} + "&idstat=" + {$idUser} + "&idt1="
            + selectedValues[0] + "&idt2=" + selectedValues[1] + "&idt3=" + selectedValues[2], true);
        xhttp.send();
    }
}
function submitVoteVillage(){
    var idt = document.getElementById("playerSelect").options[document.getElementById("playerSelect").selectedIndex].value;
    var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                ////alert(this.responseText);
                myVar = setInterval(checkVotePhaseEnded,1000);
            }
        };
        xhttp.open("POST", "gameDB.php?server=" + {$server->getIdServer()} + "&idvil=" + {$idUser} + "&idt=" + idt, true);
        xhttp.send(); 
}
    
$(document).ready(function () {
	
	
    var phase = "{$player->getPhase()}";
    switch(phase){
        case "0":
            clearInterval(myVar);
            myVar = setInterval(checkReady,1000);
            break;
        case "1":
            clearInterval(myVar);
            document.getElementById("phase").innerHTML = "Phase de Pouvoirs";
            getFormByRole();
            break;
        case "2":
            clearInterval(myVar);
            document.getElementById("phase").innerHTML = "Phase de Pouvoirs";
            myVar = setInterval(checkPowerPhaseEnded,1000);
            break;
        case "3":
            clearInterval(myVar);
            document.getElementById("phase").innerHTML = "Phase de Délibérations";
            myVar = setInterval(checkDelibPhaseEnded,1000);
            break;
        case "4":
            clearInterval(myVar);
            document.getElementById("phase").innerHTML = "Phase de vote";
            voteVillage();
            break;
        case "5":
            clearInterval(myVar);
            document.getElementById("phase").innerHTML = "Phase de vote";
            myVar = setInterval(checkVotePhaseEnded,1000);
            break;
        default :
            break;
    }
    
    function checkReady(){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                div = document.getElementById("divPlayer");
                if(this.responseText == "REPART_ENDED"){
                    clearInterval(myVar);
                    window.location.href = "game.php";
                }
                else {
                    div.innerHTML = "En attente de la répartition";
                }
            }
        };
        xhttp.open("POST", "phaseDB.php?server=" + {$server->getIdServer()} + "&p=1", true);
        xhttp.send();
        
    }
    
    // Have max 3 choices in choice for Statisticien
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

$webpage->appendContent(<<<HTML
        <h2>Joueur : {$player->getNumPlayer()} - {$user->getLogin()}</h2>
        <h2>Rôle : {$player->getRole()}</h2>
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