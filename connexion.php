<?php

require_once('inc/autoload.inc.php');

$webpage = new Webpage("Eternight - Connexion");

$webpage->appendJsUrl("js/inscription.js");

if(isset($_GET['a']) == 1){
    $webpage->appendContent(<<<HTML
        <script>alert("Vous devez vous connecter")</script>
HTML
);
}

$webpage->appendContent(<<<HTML
<div class="container" style="margin-top: 20px">
        <h1 class="text-primary">CONNEXION</h1>
        <hr class="alert-success">
        <form class="form-inline my-2 my-lg-0" name="inscription" method="post">
            <div class="form-group row">
                <label for="login" class="col-sm-2 col-form-label">Nom d'utilisateur</label>
                <div class="col-sm-10">
                  <input class="form-control mr-sm-2" type="text" id="login" name="login" required>
                </div>
                <label for="pwd" class="col-sm-2 col-form-label">Mot de passe</label>
                <div class="col-sm-10">
                  <input class="form-control mr-sm-2" type="password" id="pwd" name="pwd" required>
                </div>
                <div class="col-sm-10 mr-sm-2 float-right" style="margin-top: 20px">
                    <button class="btn btn-success" type="submit" formaction="authentification.php">Connexion</button>
                    <button class="btn btn-success" onclick="crypt()">Inscription</button>
                </div>
            </div>            
        </form>
</div>
HTML
);

echo($webpage->toHTML());
