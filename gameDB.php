<?php
require_once('inc/autoload.inc.php');
require_once('inc/requestUtils.inc.php');
if(isset($_REQUEST['server']) && !empty($_REQUEST['server'])) {
    $server = $_REQUEST['server'];
    $players = Players::getPlayersForServer($server);
    if(Players::isRepartPhaseEnded($server)){
        echo("REPART_ENDED");
    }
    else {
        echo("NOT_READY");
    }
}


