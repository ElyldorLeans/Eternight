<?php

require_once('inc/autoload.inc.php');

$webpage = new Webpage("Eternight - 404");

$webpage->appendContent(<<<HTML
<div class="bs-component">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Accueil <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
        <div>
            Tu t'es perdu, retourne à l'accueil.
        </div>
    </nav>
</div>
HTML
);





echo($webpage->toHTML());

