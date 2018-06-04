<?php

require_once('inc/autoload.inc.php');
if(isset($_POST['user']) && !empty($_POST['user'])){
    $user = $_POST['user'];
    if(isset($_POST['role']) && !empty($_POST['role'])) {
        $role = $_POST['role'];
        if(isset($_POST['server']) && !empty($_POST['server'])){
            $server = $_POST['server'];
            updateRequest(array("idServer" => $server, "idUser" => $user, "role" => $role),"Players","role = :role","idPlayer = :idUser AND idServer = :idServer");
        }
    }
}
