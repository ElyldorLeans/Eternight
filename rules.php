<?php
require_once('inc/autoload.inc.php');

$webpage = new Webpage("Eternight - Règles");

$webpage->appendContent(<<<HTML
        <h1>Règles</h1>
        <p>A MODIFIER</p>
        <a href="./index.php">Accueil</a>
        <a href="./purpose.php">A propos</a>
HTML
);

// FIXME Test.
$webpage->appendContent(" AVANT   ");
$targets = Players::getTargetIdsForPlayer(3, 1);
foreach ($targets as $target) {
        $webpage->appendContent($target[0] + " ");
}
$webpage->appendContent(" FIN   ");

echo($webpage->toHTML());
