<?php

require_once('./inc/autoload.inc.php');

// Si l'utilisateur n'est pas connecté, on le renvoie vers la page de connexion
if (!Users::isConnected()) {
    header('Location: connexion.php?e=1');
    exit();
}

$webpage = new Webpage("Eternight - Création");


// On vérifie que l'utilisateur est connecté
if (!Users::isConnected()) {
    header('Location: connexion.php?a=1' . SID);
} else {
    $user = Users::getInstance();
}

if ($user->inServer() || $user->ownServer()) {
    header('Location: index.php' . SID);
}


// On vérifie qu'on a reçu des données
if (isset($_POST['serverName']) && isset($_POST['serverMode'])) {
    try {
        // On test que le serveur existe
        $server = Servers::getServerByName($_POST['serverName']);
        $max = selectRequest(array("id" => $server->getIdServer()), array(PDO::FETCH_ASSOC), "MAX(numPlayer) AS M", "Players", "idServer = :id");
        if ($_POST['serverMode'] == "join") {
            Players::addPlayer($server->getIdServer(), $user->getIdUser(), $max[0]["M"] + 1);
            header('Location: repartition.php' . SID);
        } else {
            echo("Le serveur existe déjà");
        }
    } catch (Exception $e) {
        if ($_POST['serverMode'] == "create") {
            //On créé le server, puis on ajoute le propriétaire à sa partie dans la table Players
            Servers::createServer($user->getIdUser(), $_POST['serverName']);
            header('Location: listPlayers.php' . SID);
        } else {
            echo($e->getMessage());
        }
    }
}

$servers = Servers::getServers();

$webpage->appendContent(<<<HTML
    <div class="container" style="margin-top: 20px">
        <h1 class="text-primary">CRÉER / REJOINDRE UN SALON</h1>
        <hr class="alert-success">
        
        <div id="accordion">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button id="createBtn" class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            Créer un salon
                        </button>
                    </h5>
                </div>
                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <form class="form-inline my-2 my-lg-10" action="create.php" method="post">
                            <input name="serverMode" value="create" type="hidden"/>
                            <label for="create" class="col-sm-2 col-form-label">Nom du salon</label>
                            <input class="form-control" type="text" name="serverName" id="create" required/>
                            <button type="submit" class="btn btn-success">Créer</button>
                        </form>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button id="joinBtn" class="btn btn-link" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Rejoindre un salon
                            </button>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            <form class="form-inline my-2 my-lg-10" action="create.php" method="post">
                                <input name="serverMode" value="join" type="hidden"/>
                                <label for="join" class="col-sm-2 col-form-label">Nom du salon</label>
                                <input class="form-control" type="text" id="join" name="serverName" required/> 
                                <button type="submit" class="btn btn-success">Rejoindre</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
HTML
);

if (!empty($servers)) {
    foreach ($servers as $s) {
        //$proprio = Users::getUserById($s->getIdOwner());
        //$webpage->appendContent("<p>{$s->getNameServer()} de {$proprio->getLogin()}</p>");
        $webpage->appendContent("<form action='create.php' method='post'><input type='text' name='serverName' value='{$s->getNameServer()}' hidden> {$s->getNameServer()} <button name='serverMode' type='submit' value='join' class='btn'>Rejoindre</button></form>");
    }
}

echo($webpage->toHTML());
