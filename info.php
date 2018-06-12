<?php

require_once('inc/autoload.inc.php');

$webpage = new Webpage("Eternight - Informations");

$webpage->appendContent(<<<HTML
    <div class="container" style="margin-top: 20px">
        <h1 class="text-primary">INFORMATIONS</h1>
        <hr class="alert-success">
    </div>
HTML
);

echo($webpage->toHTML());