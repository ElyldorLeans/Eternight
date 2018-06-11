<?php
require_once('inc/autoload.inc.php');
require_once('inc/requestUtils.inc.php');
if(isset($_REQUEST['server']) && !empty($_REQUEST['server'])) {
    $server = $_REQUEST['server'];
    if(isset($_REQUEST['idt']) && !empty($_REQUEST['idt'])){
        $idt = $_REQUEST['idt'];
        if(isset($_REQUEST['idwl']) && !empty($_REQUEST['idwl'])){
            $idwl = $_REQUEST['idwl'];
            insertRequest(array("idWW" => $idwl,"idT" => $idt,"idServer" => $server),"VillageTargets(idTargeted,idTargeter,idServer)","(:idT,:idWW,:idServer)");
            //echo("insertOK");
        }
        else{
            if(isset($_REQUEST['idww']) && !empty($_REQUEST['idww'])) {
                $idww = $_REQUEST['idww'];
                insertRequest(array("idWW" => $idww,"idT" => $idt,"idServer" => $server),"WerewolfTargets(idTargeted,idTargeter,idServer)","(:idT,:idWW,:idServer)");

            }
        }

    }
    else{
        $players = Players::getPlayersForServer($server);
        if(Players::isRepartPhaseEnded($server)){
            echo("REPART_ENDED");
        }
        else {
            echo("NOT_READY");
        }
    }

}


