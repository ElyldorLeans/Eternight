<?php
 require_once('inc/autoload.inc.php');

$webpage = new Webpage("Eternight - A propos");

$webpage->appendContent(<<<HTML
        <h1>A PROPOS</h1>
        <p>A MODIFIER</p>
        <a href="./index.php">Accueil</a>
        <a href="./rules.php">Règles</a>
HTML
);

echo($webpage->toHTML());