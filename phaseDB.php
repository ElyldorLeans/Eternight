<?php
require_once('inc/autoload.inc.php');
require_once('inc/requestUtils.inc.php');

if(isset($_REQUEST['server']) && !empty($_REQUEST['server'])){
    if(isset($_REQUEST['p']) && !empty($_REQUEST['p'])){
        $phase = $_REQUEST['p'];
        $server = $_REQUEST['server'];
        $players = Players::getPlayersForServer($server);
        switch ($phase) {
            case "1":
                if (Players::isRepartPhaseEnded($server)){
                    echo("REPART_ENDED");
                }
                else {
                    echo("NOT_READY_REPART");
                }
                break;
            case "2":
                if (Players::isDelibPhaseTime($server)) {
                    echo("POWER_ENDED");
                }
                else {
                    echo("NOT_READY_POWER");
                }
                break;
            case "3":
                if (Players::isVotePhaseTime($server)){
                    echo("DELIB_ENDED");
                }
                else {
                    echo("NOT_READY");
                }
                break;
            case "4":
                if (Players::isRepartPhaseEnded($server)) {
                    echo("VOTE_ENDED");
                }
                else {
                    echo("NOT_READY");
                }
                break;
            default:
                echo("NOT_READY");
                break;
        }
    }
}
