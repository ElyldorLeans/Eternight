<?php

require_once('inc/autoload.inc.php');

$webpage = new Webpage("Eternight - Connexion");

$webpage->appendJsUrl("js/inscription.js");
$webpage->appendContent(<<<HTML
    <div class="jumbotron text-center">
        <h1>Eternight</h1>
         <p>Parce qu'on n'avait pas de meilleur nom</p>
    </div>
        <a href="./purpose.php">A propos</a>
        <a href="./rules.php">Règles</a>
        <a href="./create.php">Créer un salon</a>
        <a href="./inscription.php">Inscription</a>
HTML
);

if(isset($_GET['a']) == 1){
    $webpage->appendContent(<<<HTML
        <script>alert("Vous devez vous connecter")</script>
HTML
);
}

if(isset($_POST['login']) && !empty($_POST['login']) && isset($_POST['pwd']) && !empty($_POST['pwd'])){
    try{
        $user = Users::getUserConnect($_POST['login'],$_POST['pwd']);
        $user->SaveIntoSession();
        header('Location: index.php'.SID);
    } catch(Exception $e){
        $webpage->appendContent(<<<HTML
        <script>alert("Utilisateur inconnu")</script>
HTML
        );
    }
}

$webpage->appendContent(<<<HTML
        <form name="inscription" method="post">
            Login <input type="text" id="login" name="login" required></input>
            Password <input type="password" id="pwd" name="pwd" required></input>
            <button onclick="crypt()">Inscription</button>
            <button onclick="connexion.php">Connexion</button>
            </form>
HTML
);

echo($webpage->toHTML());