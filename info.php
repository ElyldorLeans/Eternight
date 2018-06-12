<?php

require_once('inc/autoload.inc.php');

$webpage = new Webpage("Eternight - Informations");

$webpage->appendContent(<<<HTML
    <div class="container" style="margin-top: 20px">
        <h1 class="text-primary">INFORMATIONS</h1>
        <hr class="alert-success">
HTML
);

if(Users::isConnected()) {
    try{
        $player = Players::getPlayerById($_SESSION['User']->getIdUser());
    }
    catch(Exception $e){
        header('Location: index.php'.SID);
    }
}
else {
    header('Location: connexion.php?a=1'.SID);
}

$text = nl2br($player->getRoadSheet());
$webpage->appendContent(<<<HTML
        <h2>Feuille de route</h2>
        <!-- FIXME les sauts à la ligne ne sont pas sauvegardés aaaahhhhhh -->
        <textarea class="col-sm-8 form-control" id="rs" type='text' rows="7" style="margin-top: 20px; white-space: pre-line;" value='{$text}'>{$player->getRoadSheet()}</textarea>
        <button class="btn btn-success" onclick='updateRoadSheet()' style="margin-top: 5px"> Mettre à jour</button>
    </div>
    <script>
        function updateRoadSheet(){
            rs = document.getElementById("rs").value;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                }
            };
            
            xhttp.open("POST", "updateRoadSheet.php?user=" + {$player->getIdPlayer()} + "&rs=" + rs + "&server=" + {$player->getIdServer()}, true);
            xhttp.send();
        }
    
    </script>
HTML
);

echo($webpage->toHTML());
