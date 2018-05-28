<?php
require_once('inc/autoload.inc.php');
require_once('inc/utility.inc.php');
// Si le membre n'est pas connecté
if(!Users::isConnected()) {
    // Authentifie le membre et le redirige sur index.php ( si les données sont valides)
    if (verify($_POST, 'hiddenCrypt')) {
        try {
            $user = Users::createFromAuth($_POST['hiddenCrypt']);
            $user->saveIntoSession();
            header('Location: index.php');
            exit();
        } catch (Exception $e) {
           echo("lol");
        }
    }
}
//Si le membre est connecté, le deconnecte
else{
    Users::disconnect();
    header('Location: index.php');
    exit();
}