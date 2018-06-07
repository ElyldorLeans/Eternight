<?php

require_once('inc/autoload.inc.php');
require_once('inc/requestUtils.inc.php');
if(isset($_REQUEST['user']) && !empty($_REQUEST['user'])){
    $user = $_REQUEST['user'];
    if(isset($_REQUEST['role']) && !empty($_REQUEST['role'])) {
        $role = $_REQUEST['role'];
        if(isset($_REQUEST['server']) && !empty($_REQUEST['server'])){
            $server = $_REQUEST['server'];
            updateRequest(array("idServer" => $server, "idUser" => $user, "role" => $role),"Players","role = :role","idPlayer = :idUser AND idServer = :idServer");
        }
    }
}
