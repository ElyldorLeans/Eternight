<?php

require_once('inc/autoload.inc.php');

$webpage = new Webpage("Eternight - Accueil");
$webpage->appendJsUrl(projectPath."js/inscription.js");
$webpage->appendContent(<<<HTML
<div class="jumbotron text-center">
    <h1>Eternight</h1>
    <p>Parce qu'on avait pas de meilleur nom</p>
</div>
<a href="./purpose.php">A propos</a>
<a href="./rules.php">Règles</a>
<a href="./create.php">Créer un salon</a>
HTML
);

$webpage->appendContent(<<<HTML
        <form name="inscription" action="inscription.php" method="get">
            Login <input type="text" id="login" name="login" required></input>
            Password <input type="password" id="pwd" name="pwd" required></input>
            <button onclick="crypt()">Inscription</button>
            </form>
HTML
);

echo($webpage->toHTML());