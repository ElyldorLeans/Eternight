<?php
require_once('inc/autoload.inc.php');
require_once('inc/utility.inc.php');
if(!Users::isConnected()) {
    if(isset($_POST['login']) && !empty($_POST['login']) && isset($_POST['pwd']) && !empty($_POST['pwd'])){
        try{
            $user = Users::getUserConnect($_POST['login'],$_POST['pwd']);
            $user->SaveIntoSession();
            header('Location: index.php');
        } catch(Exception $e){
            $webpage->appendContent(<<<HTML
        <script>alert("Utilisateur inconnu")</script>
HTML
            );
        }
    }
}
//Si le membre est connecté, le deconnecte
else{
    Users::disconnect();
    header('Location: index.php');
    exit();
}