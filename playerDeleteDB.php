<?php

require_once('inc/autoload.inc.php');
require_once('inc/requestUtils.inc.php');

if(isset($_REQUEST['user']) && !empty($_REQUEST['user'])){
    $user = $_REQUEST['user'];
        if(isset($_REQUEST['server']) && !empty($_REQUEST['server'])){
            $server = $_REQUEST['server'];
            deleteRequest(array("idServer" => $server, "idUser" => $user),"Players","idServer = :idServer AND idPlayer = :idUser" );
        }
}
