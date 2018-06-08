<?php

require_once('inc/autoload.inc.php');
require_once('inc/requestUtils.inc.php');

if(isset($_REQUEST['server']) && !empty($_REQUEST['server'])){
    $server = $_REQUEST['server'];
    if(isset($_REQUEST['r']) && !empty($_REQUEST['r'])){
        $un = Servers::getServerById($server);
        if($un->getUnjoinable() == 0) {
            $un->unjoinable();
            $players = Players::createPlayersByServer($server);
            $numPlayers = sizeof($players);
            $role;
            switch ($numPlayers) {
                case 4 :
                    $role = array("Loup Garou", "Voyante", "Statistiscien", "Statistiscien");
                    break;

                case 5 :
                    $role = array("Loup Garou", "Loup Garou", "Voyante", "Statistiscien", "Statistiscien");
                    break;

                case 6 :
                    $role = array("Loup Garou", "Voyante Corrompue", "Voyante", "Voyante", "Statistiscien", "Statistiscien");
                    break;

                case 7 :
                    $role = array("Loup Garou", "Voyante Corrompue", "Voyante Corrompue", "Voyante", "Voyante", "Statistiscien", "Statistiscien");
                    break;

                case 8 :
                    $role = array("Loup Garou", "Voyante Corrompue", "Voyante Corrompue", "Voyante", "Voyante", "Statistiscien", "Statistiscien", "Statistiscien");
                    break;

                case 9 :
                    $role = array("Loup Garou", "Voyante Corrompue", "Voyante Corrompue", "Voyante", "Voyante", "Voyante", "Statistiscien", "Statistiscien", "Statistiscien");
                    break;
                case 10 :
                    $role = array("Loup Garou", "Voyante Corrompue", "Voyante Corrompue", "Sorcière Corrompue", "Voyante", "Voyante", "Voyante", "Statistiscien", "Statistiscien", "Statistiscien"); // 10PJ
                    break;
                case 11 :
                    $role = array("Loup Garou", "Voyante Corrompue", "Voyante Corrompue", "Sorcière Corrompue", "Voyante", "Voyante", "Voyante", "Statistiscien", "Statistiscien", "Statistiscien", "Statistiscien"); // 11PJ
                    break;
                case 12 :
                    $role = array("Loup Garou", "Voyante Corrompue", "Voyante Corrompue", "Sorcière Corrompue", "Sorcière Corrompue", "Voyante", "Voyante", "Voyante", "Statistiscien", "Statistiscien", "Statistiscien", "Statistiscien"); // 12PJ
                    break;
                case 13 :
                    $role = array("Loup Blanc", "Loup Garou", "Voyante Corrompue", "Voyante Corrompue", "Sorcière Corrompue", "Sorcière Corrompue", "Voyante", "Voyante", "Voyante", "Voyante", "Statistiscien", "Statistiscien", "Statistiscien"); // 13PJ
                    break;
                case 14 :
                    $role = array("Loup Blanc", "Loup Garou", "Voyante Corrompue", "Voyante Corrompue", "Sorcière Corrompue", "Sorcière Corrompue", "Voyante", "Voyante", "Voyante", "Voyante", "Statistiscien", "Statistiscien", "Statistiscien", "Statistiscien"); // 14PJ
                    break;
                case 15 :
                    $role = array("Loup Blanc", "Loup Garou", "Voyante Corrompue", "Voyante Corrompue", "Sorcière Corrompue", "Sorcière Corrompue", "Voyante", "Voyante", "Voyante", "Voyante", "Statistiscien", "Statistiscien", "Statistiscien", "Statistiscien", "Statistiscien"); // 15PJ
                    break;

                default :
                    break;
            }
            shuffle($role);
            for ($i = 0; $i < $numPlayers; $i++) {
                updateRequest(array("idServer" => $server, "idUser" => $players[$i]->getIdPlayer(), "role" => $role[$i]), "Players", "role = :role,phase = 1", "idPlayer = :idUser AND idServer = :idServer");
            }
        }
        $players = Players::createPlayersByServer($server);
        $html = "<ul>";
        foreach ($players as $p) {
            $html = $html . "<li><a href='detailPlayer.php?id=" . $p->getIdPlayer() . "' target='_blank'>" . $p->getNumPlayer() . " - " . $p->getRole() . "</a><input type='checkbox' disabled></li>";
        }
        $html = $html . "</ul>";
        echo($html);
    }
    else {
        $players = Players::createPlayersByServer($server);
        //Si on est en phase de pouvoir
        if(isset($_REQUEST['p']) && !empty($_REQUEST['p'])){
            //on regarde si tous les joueurs ont voté
            if(Players::isPowerPhaseEnded($server)){
                echo("PHASEEND");
                updateRequest(array("idServer" => $server), "Players", "phase = 3", "idServer = :idServer");
            }
            else {
                //On met à jour les différents inputs
                $html = "<ul>";
                foreach ($players as $p) {
                    $html = $html . "<li><a href='detailPlayer.php?id=" . $p->getIdPlayer() . "' target='_blank'>" . $p->getNumPlayer() . " - " . $p->getRole() . "</a>";
                    if($p->getPhase() == 2) $html= $html."<input type='checkbox' checked disabled></li>";
                    else  $html= $html."<input type='checkbox' disabled></li>";
                }
                $html = $html . "</ul>";
                echo($html);
            }
        }
        else{
            //On regarde si on est en phase de délibération
            if(isset($_REQUEST['d']) && !empty($_REQUEST['d'])){
                updateRequest(array("idServer" => $server), "Players", "phase = 4", "idServer = :idServer");
            }
            else{
                //On regarde si on est en phase de vote
                if(isset($_REQUEST['v']) && !empty($_REQUEST['v'])){
                    //Si tous les joueurs ont voté
                    if(Players::isVotePhaseEnded($server)){
                        echo("PHASEEND");
                        updateRequest(array("idServer" => $server), "Players", "phase = 1", "idServer = :idServer");
                    }
                    else {
                        //On met à jour les différents inputs
                        $html = "<ul>";
                        foreach ($players as $p) {
                            $html = $html . "<li><a href='detailPlayer.php?id=" . $p->getIdPlayer() . "' target='_blank'>" . $p->getNumPlayer() . " - " . $p->getRole() . "</a>";
                            if($p->getPhase() == 5) $html= $html."<input type='checkbox' checked disabled></li>";
                            else  $html= $html."<input type='checkbox' disabled></li>";
                        }
                        $html = $html . "</ul>";
                        echo($html);
                    }
                }
                else{
                    $html = "<ul>";
                    foreach($players as $p){
                        $html = $html."<li><a href='detailPlayer.php?id=".$p->getIdPlayer()."' target='_blank'>".$p->getNumPlayer()." - ".$p->getRole()."</a></li>";
                    }
                    $html = $html."</ul>";
                    echo($html);
                }

            }
        }
    }
}