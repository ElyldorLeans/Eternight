<?php

require_once('inc/autoload.inc.php');

$webpage = new Webpage("Eternight - Accueil");


echo($webpage->toHTML());
