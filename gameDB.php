<?php
require_once('inc/autoload.inc.php');
require_once('inc/requestUtils.inc.php');
if(isset($_REQUEST['server']) && !empty($_REQUEST['server'])) {
    $server = $_REQUEST['server'];
    if(isset($_REQUEST['idt']) && !empty($_REQUEST['idt'])){
        $idt = $_REQUEST['idt'];
        if(isset($_REQUEST['idwl']) && !empty($_REQUEST['idwl'])){
            $idwl = $_REQUEST['idwl'];
            //echo(Players::alreadyVoteWW($server,$idwl,$idt));
            if(!Players::alreadyVoteVil($server,$idwl,$idt)) insertRequest(array("idWW" => $idwl,"idT" => $idt,"idServer" => $server),"VillageTargets(idTargeted,idTargeter,idServer)","(:idT,:idWW,:idServer)");
        }
        else{
            if(isset($_REQUEST['idww']) && !empty($_REQUEST['idww'])) {
                $idww = $_REQUEST['idww'];
                if($idt != -1){
                    if(!Players::alreadyVoteWW($server,$idww,$idt)) insertRequest(array("idWW" => $idww,"idT" => $idt,"idServer" => $server),"WerewolfTargets(idTargeted,idTargeter,idServer)","(:idT,:idWW,:idServer)");
                }
                updateRequest(array("idServer" => $server, "idPlayer" => $idww, "phase" => 2),"Players","phase = :phase","idServer = :idServer AND idPlayer = :idPlayer");
            }
        }

    }
}


