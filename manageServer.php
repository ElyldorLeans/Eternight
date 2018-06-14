<?php

require_once('inc/autoload.inc.php');
require_once ('inc/utility.inc.php');

$webpage = new Webpage("Eternight - Gestion du serveur");
$webpage->appendContent(<<<HTML
    <div class="container" style="margin-top: 20px">
        <h1 class="text-primary">GESTION DU SALON</h1>
        <hr class="alert-success">
HTML
);

if(Users::isConnected()) {
    try{
        $server = Servers::getServerByIdOwner($_SESSION['User']->getIdUser());
		$minphase = Players::getMinimumPhase($server->getIdServer());
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

// JAVASCRIPT
$webpage->appendToHead(<<<HTML
<script>
function deleteServer(){
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function(){
    if (this.readyState == 4 && this.status == 200) {
     window.location.href = "index.php";
    }
  };
  xhttp.open("POST", "deleteServerDB.php?server=" + {$server->getIdServer()}, true);
  xhttp.send();
}

var myVar;

function checkRepart() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            repart = document.getElementById("repart");
            repart.innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "repartPlayerDB.php?server=" + {$server->getIdServer()}, true);
    xhttp.send();
    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText > 3){
                document.getElementById("validate").style.visibility="visible";
            }  
        }
    };
    xhttp.open("POST", "repartPlayerDB.php?server=" + {$server->getIdServer()} + "&number=true", true);
    xhttp.send();
}

function checkPower() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            repart = document.getElementById("repart");
            if(this.responseText == "PHASEEND"){
                clearInterval(myVar);
                document.getElementById("validate").style.visibility="visible";
                document.getElementById("validate").onclick = function(){validePower();};
            }
            else{
                repart.innerHTML = this.responseText;
            }
        }
    };
    xhttp.open("POST", "repartPlayerDB.php?server=" + {$server->getIdServer()} + "&p=true", true);
    xhttp.send();
}

function checkVote() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            repart = document.getElementById("repart");
            if(this.responseText == "PHASEEND"){
                clearInterval(myVar);
                document.getElementById("validate").style.visibility="visible";
                document.getElementById("validate").onclick = function(){valideVote();};
            }
            else{
                repart.innerHTML = this.responseText;
            }
        }
    };
    xhttp.open("POST", "repartPlayerDB.php?server=" + {$server->getIdServer()} + "&v=true", true);
    xhttp.send();
}


function valideRepart(){
   clearInterval(myVar);
   var xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText != "ERROR_NUM_PLAYER"){
                document.getElementById("validate").style.visibility="hidden";
                document.getElementById("validate").onclick = function(){validePower();};
                repart = document.getElementById("repart");
                repart.innerHTML = this.responseText;
                phase = document.getElementById("phase");
                phase.innerHTML = "Phase de Pouvoirs";
                myVar = setInterval(checkPower, 1000);
            }
        }
    };
    xhttp.open("POST", "repartPlayerDB.php?server=" + {$server->getIdServer()} + "&r=true", true);
    xhttp.send();
}

function validePower(){
   clearInterval(myVar);
   var xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("validate").onclick = function(){endDeliberation();};
            phase = document.getElementById("phase");
            phase.innerHTML = "Phase des Délibérations";
            repart = document.getElementById("repart");
            repart.innerHTML = "Délibérations en cours ..." + this.responseText;
        }
    };
    xhttp.open("POST", "repartPlayerDB.php?server=" + {$server->getIdServer()} + "&vp=true", true);
    xhttp.send();
}

function valideVote(){
   clearInterval(myVar);
   var xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
			document.getElementById("validate").style.visibility="hidden";
            document.getElementById("validate").onclick = function(){validePower();};
            document.getElementById("phase").innerHTML = "Phase de Pouvoirs";		
			myVar = setInterval(checkPower, 1000);
        }
    };
    xhttp.open("POST", "repartPlayerDB.php?server=" + {$server->getIdServer()} + "&vv=true", true);
    xhttp.send();
}


function endDeliberation(){
   var xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function(){
     if (this.readyState == 4 && this.status == 200) {
        document.getElementById("validate").style.visibility="hidden";
        document.getElementById("validate").onclick = function(){valideVote();};
        phase = document.getElementById("phase");
        phase.innerHTML = "Phase de Vote";
        myVar = setInterval(checkVote, 1000);
        }
    };
    xhttp.open("POST", "repartPlayerDB.php?server=" + {$server->getIdServer()} + "&d=true", true);
    xhttp.send();
}

$(document).ready(function () {
	var phase = "{$minphase}";
    switch(phase){
        case "":
        case "0":
            clearInterval(myVar);
            myVar = setInterval(checkRepart, 1000);
            break;
        case "1":
            clearInterval(myVar);
            document.getElementById("phase").innerHTML = "Phase de Pouvoirs ";
            myVar = setInterval(checkPower,1000);
            break;
        case "2":
            clearInterval(myVar);
            document.getElementById("phase").innerHTML = "Phase de Pouvoirs";
            myVar = setInterval(checkPower,1000);
            break;
        case "3":
			clearInterval(myVar);
            document.getElementById("validate").onclick = function(){endDeliberation();};
            document.getElementById("validate").style.visibility="visible";
            phase = document.getElementById("phase");
            phase.innerHTML = "Phase des Délibérations";
            repart = document.getElementById("repart");
            repart.innerHTML = "Délibérations en cours ...";
            break;
        case "4":
            clearInterval(myVar);
            document.getElementById("phase").innerHTML = "Phase de Vote";
            myVar = setInterval(checkVote,1000);
        case "5":
            clearInterval(myVar);
            document.getElementById("phase").innerHTML = "Phase de Vote";
            myVar = setInterval(checkVote,1000);
        default :
			alert(phase);
            break;
    }
});

</script>
HTML
);

//$webpage->appendJsUrl("js/repetedFunctions.js");
/*****************************************/

$webpage->appendContent("<h2>{$server->getNameServer()}</h2>");
$webpage->appendContent("<button class='btn btn-warning' onclick='deleteServer()'>Fermer le salon</button>");
$webpage->appendContent("<hr class=\"alert-success\">");
$webpage->appendContent("<h2 id='phase'>Phase de répartition</h2>");
$webpage->appendContent("<button class='btn btn-success' id='validate' onclick='valideRepart()' style='visibility:hidden'> Valider </button>");
$webpage->appendContent("<div id='repart'></div>");


echo($webpage->toHTML());
