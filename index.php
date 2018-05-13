<?php

require_once('inc/autoload.inc.php');

$webpage = new Webpage("Eternight - Accueil");

$webpage->appendContent(<<<HTML
        <h1>TEST</h1>
        <p>A MODIFIER</p>
HTML
    );

echo($webpage->toHTML());