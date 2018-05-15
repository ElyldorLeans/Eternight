<?php

require_once('inc/autoload.inc.php');

$webpage = new Webpage("Eternight - Accueil");

$webpage->appendContent(<<<HTML
        <h1>TEST</h1>
        <p>A MODIFIER</p>
        <a href="./purpose.php">A propos</a>
        <a href="./rules.php">Règles</a>
        <a href="./create.php">Créer un salon</a>
HTML
    );

echo($webpage->toHTML());