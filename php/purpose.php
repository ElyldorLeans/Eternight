<?php
 require_once('inc/autoload.inc.php');

$webpage = new Webpage("Eternight - A propos");

$webpage->appendContent(<<<HTML
        <div class="bs-component">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
        
                <div class="collapse navbar-collapse" id="navbarColor02">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="./index.php">Accueil </a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="#">À propos<span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./rules.php">Règles</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="container">
            <h3>À PROPOS</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam pharetra tempor tortor, ut rutrum orci sodales sit amet. Quisque sem diam, bibendum at sollicitudin a, ornare eu justo.</p>
            <p>Vivamus vulputate gravida justo iaculis malesuada. Quisque nec dolor dolor. Integer tempus dignissim mi nec aliquet. Etiam ultrices justo ac velit sagittis, non dictum tellus laoreet. </p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id sapien porta, dictum ex id, finibus eros. Nam porta purus eget pellentesque sollicitudin.</p>
        </div>
HTML
);

echo($webpage->toHTML());
