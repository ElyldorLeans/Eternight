<?php
 require_once('inc/autoload.inc.php');

$webpage = new Webpage("Eternight - A propos");

$webpage->appendContent(<<<HTML
        <div class="container" style="margin-top: 20px">
            <h1 class="text-primary">À PROPOS</h1>
            <hr class="alert-success">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam pharetra tempor tortor, ut rutrum orci sodales sit amet. Quisque sem diam, bibendum at sollicitudin a, ornare eu justo.</p>
            <p>Vivamus vulputate gravida justo iaculis malesuada. Quisque nec dolor dolor. Integer tempus dignissim mi nec aliquet. Etiam ultrices justo ac velit sagittis, non dictum tellus laoreet. </p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id sapien porta, dictum ex id, finibus eros. Nam porta purus eget pellentesque sollicitudin.</p>
        </div>
HTML
);

echo($webpage->toHTML());
