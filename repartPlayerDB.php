<?php

require_once('inc/autoload.inc.php');
require_once('inc/requestUtils.inc.php');

if(isset($_REQUEST['server']) && !empty($_REQUEST['server'])){
    $server = $_REQUEST['server'];
    if(isset($_REQUEST['r']) && !empty($_REQUEST['r'])){
        $un = Servers::getServerById($server);
        if($un->getUnjoinable() == 0) {
            $un->unjoinable();
            $players = Players::getPlayersForServer($server);
            $numPlayers = sizeof($players);
            $role;
            switch ($numPlayers) {
                case 4 :
//                    $role = array("Loup Garou", "Voyante", "Statisticien", "Statisticien");
                    $role = array("Loup Garou", "Voyante", "Voyante", "Voyante");
                    break;

                case 5 :
//                    $role = array("Loup Garou", "Loup Garou", "Voyante", "Statisticien", "Statisticien");
                    $role = array("Loup Garou", "Loup Garou", "Voyante", "Voyante", "Voyante");
                    break;

                case 6 :
//                    $role = array("Loup Garou", "Voyante Corrompue", "Voyante", "Voyante", "Statisticien", "Statisticien");
                    $role = array("Loup Garou", "Voyante Corrompue", "Voyante", "Voyante", "Voyante", "Voyante");
                    break;

                case 7 :
//                    $role = array("Loup Garou", "Voyante Corrompue", "Voyante Corrompue", "Voyante", "Voyante", "Statisticien", "Statisticien");
                    $role = array("Loup Garou", "Voyante Corrompue", "Voyante Corrompue", "Voyante", "Voyante", "Voyante", "Voyante");
                    break;

                case 8 :
//                    $role = array("Loup Garou", "Voyante Corrompue", "Voyante Corrompue", "Voyante", "Voyante", "Statisticien", "Statisticien", "Statisticien");
                    $role = array("Loup Garou", "Voyante Corrompue", "Voyante Corrompue", "Voyante", "Voyante", "Voyante", "Voyante", "Voyante");
                    break;

                case 9 :
//                    $role = array("Loup Garou", "Voyante Corrompue", "Voyante Corrompue", "Voyante", "Voyante", "Voyante", "Statisticien", "Statisticien", "Statisticien");
                    $role = array("Loup Garou", "Voyante Corrompue", "Voyante Corrompue", "Voyante", "Voyante", "Voyante", "Voyante", "Voyante", "Voyante");
                    break;
                case 10 :
//                    $role = array("Loup Garou", "Voyante Corrompue", "Voyante Corrompue", "Sorcière Corrompue", "Voyante", "Voyante", "Voyante", "Statisticien", "Statisticien", "Statisticien"); // 10PJ
                    $role = array("Loup Garou", "Voyante Corrompue", "Voyante Corrompue", "Sorcière Corrompue", "Voyante", "Voyante", "Voyante", "Voyante", "Voyante", "Voyante"); // 10PJ
                    break;
                case 11 :
//                    $role = array("Loup Garou", "Voyante Corrompue", "Voyante Corrompue", "Sorcière Corrompue", "Voyante", "Voyante", "Voyante", "Statisticien", "Statisticien", "Statisticien", "Statisticien");
                    $role = array("Loup Garou", "Voyante Corrompue", "Voyante Corrompue", "Sorcière Corrompue", "Voyante", "Voyante", "Voyante", "Voyante", "Voyante", "Voyante", "Voyante");
                    break;
                case 12 :
//                    $role = array("Loup Garou", "Voyante Corrompue", "Voyante Corrompue", "Sorcière Corrompue", "Sorcière Corrompue", "Voyante", "Voyante", "Voyante", "Statisticien", "Statisticien", "Statisticien", "Statisticien");
                    $role = array("Loup Garou", "Voyante Corrompue", "Voyante Corrompue", "Sorcière Corrompue", "Sorcière Corrompue", "Voyante", "Voyante", "Voyante", "Voyante", "Voyante", "Voyante", "Voyante");
                    break;
                case 13 :
//                    $role = array("Loup Blanc", "Loup Garou", "Voyante Corrompue", "Voyante Corrompue", "Sorcière Corrompue", "Sorcière Corrompue", "Voyante", "Voyante", "Voyante", "Voyante", "Statisticien", "Statisticien", "Statisticien");
                    $role = array("Loup Blanc", "Loup Garou", "Voyante Corrompue", "Voyante Corrompue", "Sorcière Corrompue", "Sorcière Corrompue", "Voyante", "Voyante", "Voyante", "Voyante", "Voyante", "Voyante", "Voyante");
                    break;
                case 14 :
//                    $role = array("Loup Blanc", "Loup Garou", "Voyante Corrompue", "Voyante Corrompue", "Sorcière Corrompue", "Sorcière Corrompue", "Voyante", "Voyante", "Voyante", "Voyante", "Statisticien", "Statisticien", "Statisticien", "Statisticien");
                    $role = array("Loup Blanc", "Loup Garou", "Voyante Corrompue", "Voyante Corrompue", "Sorcière Corrompue", "Sorcière Corrompue", "Voyante", "Voyante", "Voyante", "Voyante", "Voyante", "Voyante", "Voyante", "Voyante");
                    break;
                case 15 :
//                    $role = array("Loup Blanc", "Loup Garou", "Voyante Corrompue", "Voyante Corrompue", "Sorcière Corrompue", "Sorcière Corrompue", "Voyante", "Voyante", "Voyante", "Voyante", "Statisticien", "Statisticien", "Statisticien", "Statisticien", "Statisticien");
                    $role = array("Loup Blanc", "Loup Garou", "Voyante Corrompue", "Voyante Corrompue", "Sorcière Corrompue", "Sorcière Corrompue", "Voyante", "Voyante", "Voyante", "Voyante", "Voyante", "Voyante", "Voyante", "Voyante", "Voyante");
                    break;

                default :
                    $role = array("En attente");
                    break;
            }
            shuffle($role);
            for ($i = 0; $i < $numPlayers; $i++) {
                updateRequest(array("idServer" => $server, "idUser" => $players[$i]->getIdPlayer(), "role" => $role[$i]), "Players", "role = :role,phase = 1", "idPlayer = :idUser AND idServer = :idServer");
            }
        }
        $players = Players::getPlayersForServer($server);
        $html = "<ul>";
        foreach ($players as $p) {
            $html = $html . "<li><a href='detailPlayer.php?id=" . $p->getIdPlayer() . "' target='_blank'>" . $p->getNumPlayer() . " - " . $p->getRole() . " </a><input type='checkbox' disabled></li>";
        }
        $html = $html . "</ul>";
        echo($html);
    }
    else {
        $players = Players::getPlayersForServer($server);
        //Si on est en phase de pouvoir
        if(isset($_REQUEST['p']) && !empty($_REQUEST['p'])){
            //on regarde si tous les joueurs ont voté
            if(Players::isPowerPhaseEnded($server)){
                echo("PHASEEND");
                Players::resolveActions($server);
                updateRequest(array("idServer" => $server), "Players", "phase = 3", "idServer = :idServer");
            }
            else {
                //On met à jour les différents inputs
                $html = "<ul>";
                foreach ($players as $p) {
                    $html = $html . "<li><a href='detailPlayer.php?id=" . $p->getIdPlayer() . "' target='_blank'>" . $p->getNumPlayer() . " - " . $p->getRole() . " </a>";
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
                echo(Players::getActionsSynopsis($server));
            }
            else{
                //On regarde si on est en phase de vote
                if(isset($_REQUEST['v']) && !empty($_REQUEST['v'])){
                    //Si tous les joueurs ont voté
                    if(Players::isVotePhaseEnded($server)){
                        echo("PHASEEND");
                        Players::resolveVote($server);
                        updateRequest(array("idServer" => $server), "Players", "phase = 1", "idServer = :idServer");
                    }
                    else {
                        //On met à jour les différents inputs
                        $html = "<ul>";
                        foreach ($players as $p) {
                            $html = $html . "<li><a href='detailPlayer.php?id=" . $p->getIdPlayer() . "' target='_blank'>" . $p->getNumPlayer() . " - " . $p->getRole() . " </a>";
                            if($p->getPhase() == 5) $html= $html."<input type='checkbox' checked disabled></li>";
                            else  $html= $html."<input type='checkbox' disabled></li>";
                        }
                        $html = $html . "</ul>";
                        echo($html);
                    }
                }
                else{
                    if(isset($_REQUEST['number']) && !empty($_REQUEST['number'])){
                        echo(sizeof(Players::getPlayersForServer($server)));
                    }
                    else{
                        $html = "<ul>";
                        foreach($players as $p){
                            $html = $html."<li><a href='detailPlayer.php?id=".$p->getIdPlayer()."' target='_blank'>".$p->getNumPlayer()." - ".$p->getRole()." </a></li>";
                        }
                        $html = $html."</ul>";
                        echo($html);
                    }

                }

            }
        }
    }
}