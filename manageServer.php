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

var myVar = setInterval(checkRepart, 1000);
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
            document.getElementById("validate").style.visibility="hidden";
            document.getElementById("validate").onclick = function(){validePower();};
            repart = document.getElementById("repart");
            repart.innerHTML = this.responseText;
            phase = document.getElementById("phase");
            phase.innerHTML = "Phase de Pouvoirs";
            myVar = setInterval(checkPower, 1000);
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
            phase.innerHTML = "Phase des délibérations";
            repart = document.getElementById("repart");
            repart.innerHTML = "Délibérations en cours ...";
        }
    };
    xhttp.open("POST", "repartPlayerDB.php?server=" + {$server->getIdServer()} + "&d=true", true);
    xhttp.send();
}

function valideVote(){
   clearInterval(myVar);
   document.getElementById("validate").onclick = function(){validePower();};
   document.getElementById("validate").style.visibility="hidden";
   phase = document.getElementById("phase");
   phase.innerHTML = "Phase de Pouvoirs";
   myVar = setInterval(checkPower, 1000);
}


function endDeliberation(){
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

</script>
HTML
);

//$webpage->appendJsUrl("js/repetedFunctions.js");
/*****************************************/

$webpage->appendContent("<h2>{$server->getNameServer()}</h2>");
$webpage->appendContent("<button onclick='deleteServer()'>Fermer le salon</button>");
$webpage->appendContent("<hr class=\"alert-success\">");
$webpage->appendContent("<h2 id='phase'>Phase de répartition</h2>");
$webpage->appendContent("<button id='validate' onclick='valideRepart()'> Valider </button>");
$webpage->appendContent("<div id='repart'></div>");


echo($webpage->toHTML());

