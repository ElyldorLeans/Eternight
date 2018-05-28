<?php

require_once('inc/autoload.inc.php');

$webpage = new Webpage("Eternight - Connexion");

$webpage->appendContent(<<<HTML
    <div class="jumbotron text-center">
        <h1>Eternight</h1>
         <p>Parce qu'on avait pas de meilleur nom</p>
    </div>
        <a href="./purpose.php">A propos</a>
        <a href="./rules.php">Règles</a>
        <a href="./create.php">Créer un salon</a>
        <a href="./inscription.php">Inscription</a>
HTML
);

if(isset($_GET['e']) && $_GET['e'] == 1){
    $webpage->appendContent(<<<HTML
        <p>Vous devez vous connecter avant de pouvoir créer ou rejoindre un salon</p>
HTML
    );
}

$webpage->appendContent(<<<HTML
        <form name="connexion" action="authentification.php" method="post">
            Login <input type="text" name="login" required></input>
            Password <input type="password" name="pwd" required></input>
            <button onclick="crypt()">Inscription</button>
            </form>
HTML
);

echo($webpage->toHTML());