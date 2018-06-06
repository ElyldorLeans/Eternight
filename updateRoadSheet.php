<?php

require_once('inc/autoload.inc.php');
require_once('inc/requestUtils.inc.php');
if(isset($_REQUEST['user']) && !empty($_REQUEST['user'])){
    $user = $_REQUEST['user'];
    if(isset($_REQUEST['rs']) && !empty($_REQUEST['rs'])) {
        $rs = $_REQUEST['rs'];
        if(isset($_REQUEST['server']) && !empty($_REQUEST['server'])){
            $server = $_REQUEST['server'];
            updateRequest(array("idServer" => $server, "idUser" => $user, "rs" => $rs),"Players","roadSheet = :rs","idPlayer = :idUser AND idServer = :idServer");
        }
    }
}

echo("lol");
