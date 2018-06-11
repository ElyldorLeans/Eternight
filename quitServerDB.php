<?php

require_once('inc/autoload.inc.php');
require_once('inc/requestUtils.inc.php');

if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
    $id = $_REQUEST['id'];
    deleteRequest(array("idPlayer" => $id),"Players","idPlayer = :idPlayer");
}