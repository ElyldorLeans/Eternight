<?php

require_once('inc/autoload.inc.php');

$webpage = new Webpage("Eternight - Connexion");

$webpage->appendJsUrl("js/inscription.js");
$webpage->appendContent(<<<HTML
        <a href="purpose.php">A propos</a>
        <a href="rules.php">Règles</a>
HTML
);

if(isset($_GET['a']) == 1){
    $webpage->appendContent(<<<HTML
        <script>alert("Vous devez vous connecter")</script>
HTML
);
}

$webpage->appendContent(<<<HTML
        <form name="inscription" method="post">
            Login <input type="text" id="login" name="login" required>
            Password <input type="password" id="pwd" name="pwd" required>
            <button onclick="crypt()">Inscription</button>
            <button type="submit" formaction="authentification.php">Connexion</button>
            </form>
HTML
);

echo($webpage->toHTML());
