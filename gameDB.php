<?php
require_once('inc/autoload.inc.php');
require_once('inc/requestUtils.inc.php');
if(isset($_REQUEST['server']) && !empty($_REQUEST['server'])) {
    $server = $_REQUEST['server'];
    echo($server);
    if(isset($_REQUEST['idt']) && !empty($_REQUEST['idt'])){
        $idt = $_REQUEST['idt'];
        echo($idt);
        if(isset($_REQUEST['idwl']) && !empty($_REQUEST['idwl'])){
            $idwl = $_REQUEST['idwl'];
            echo($idwl);
            //echo(Players::alreadyVoteWW($server,$idwl,$idt));
            if(!Players::alreadyVoteVil($server,$idwl,$idt)) insertRequest(array("idWW" => $idwl,"idT" => $idt,"idServer" => $server),"VillageTargets(idTargeted,idTargeter,idServer)","(:idT,:idWW,:idServer)");
        }
        else{
            if(isset($_REQUEST['idww']) && !empty($_REQUEST['idww'])) {
                $idww = $_REQUEST['idww'];
                echo($idww);
                if($idt != -1){
                    if(!Players::alreadyVoteWW($server,$idww,$idt)) insertRequest(array("idWW" => $idww,"idT" => $idt,"idServer" => $server),"WerewolfTargets(idTargeted,idTargeter,idServer)","(:idT,:idWW,:idServer)");
                }
                updateRequest(array("idServer" => $server, "idPlayer" => $idww, "phase" => 2),"Players","phase = :phase","idServer = :idServer AND idPlayer = :idPlayer");
            }
            else{
                if(isset($_REQUEST['idcp']) && !empty($_REQUEST['idcp'])){
                    $idcp = $_REQUEST['idcp'];
                    if(!Players::alreadyVoteVil($server,$idcp,$idt)) insertRequest(array("idWW" => $idcp,"idT" => $idt,"idServer" => $server),"VillageTargets(idTargeted,idTargeter,idServer)","(:idT,:idWW,:idServer)");
                }
                else {
                    if(isset($_REQUEST['idcs']) && !empty($_REQUEST['idcs'])){
                        $idcs = $_REQUEST['idcs'];
                        if(!Players::alreadyVoteVil($server,$idcs,$idt)) insertRequest(array("idWW" => $idcs,"idT" => $idt,"idServer" => $server),"VillageTargets(idTargeted,idTargeter,idServer)","(:idT,:idWW,:idServer)");
                    }
                    else{
                        if(isset($_REQUEST['idp']) && !empty($_REQUEST['idp'])){
                            $idp = $_REQUEST['idp'];
                            if(!Players::alreadyVoteVil($server,$idp,$idt)) insertRequest(array("idWW" => $idp,"idT" => $idt,"idServer" => $server),"VillageTargets(idTargeted,idTargeter,idServer)","(:idT,:idWW,:idServer)");
                            updateRequest(array("idServer" => $server, "idPlayer" => $idp, "phase" => 2),"Players","phase = :phase","idServer = :idServer AND idPlayer = :idPlayer");
                        }
                        else{
                            if(isset($_REQUEST['idvil']) && !empty($_REQUEST['idvil'])){
                                $idvil = $_REQUEST['idvil'];
                                echo($idvil);
                                if($idt != -1) {
                                    if(!Players::alreadyVoteVil($server,$idvil,$idt)) insertRequest(array("idWW" => $idvil,"idT" => $idt,"idServer" => $server),"VillageTargets(idTargeted,idTargeter,idServer)","(:idT,:idWW,:idServer)");
                                }
                                updateRequest(array("idServer" => $server, "idPlayer" => $idvil, "phase" => 5),"Players","phase = :phase","idServer = :idServer AND idPlayer = :idPlayer");
                            }
                        }
                    }
                }
            }
        }

    }
    else {
        if(isset($_REQUEST['idt1']) && !empty($_REQUEST['idt1']) && isset($_REQUEST['idt2']) && !empty($_REQUEST['idt2']) && isset($_REQUEST['idt3']) && !empty($_REQUEST['idt3'])){
            $idt1 = $_REQUEST['idt1'];
            $idt2 = $_REQUEST['idt2'];
            $idt3 = $_REQUEST['idt3'];
            if(isset($_REQUEST['idstat']) && !empty($_REQUEST['idstat'])){
                $idstat = $_REQUEST['idstat'];
                if(!Players::alreadyVoteVil($server,$idstat,$idt1)) insertRequest(array("idWW" => $idstat,"idT" => $idt1,"idServer" => $server),"VillageTargets(idTargeted,idTargeter,idServer)","(:idT,:idWW,:idServer)");
                if(!Players::alreadyVoteVil($server,$idstat,$idt2)) insertRequest(array("idWW" => $idstat,"idT" => $idt2,"idServer" => $server),"VillageTargets(idTargeted,idTargeter,idServer)","(:idT,:idWW,:idServer)");
                if(!Players::alreadyVoteVil($server,$idstat,$idt3)) insertRequest(array("idWW" => $idstat,"idT" => $idt3,"idServer" => $server),"VillageTargets(idTargeted,idTargeter,idServer)","(:idT,:idWW,:idServer)");

                updateRequest(array("idServer" => $server, "idPlayer" => $idstat, "phase" => 2),"Players","phase = :phase","idServer = :idServer AND idPlayer = :idPlayer");
            }
        }
    }
}


