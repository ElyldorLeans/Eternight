<?php

require_once('./inc/autoload.inc.php');

// Si l'utilisateur n'est pas connecté, on le renvoie vers la page de connexion
if(!Users::isConnected()){
    header('Location: connexion.php?e=1');
    exit();
}

$webpage = new Webpage("Eternight - Accueil");

$webpage->appendContent(<<<HTML
    <div class="jumbotron text-center">
        <h1>Eternight</h1>
         <p>Parce qu'on avait pas de meilleur nom</p>
    </div>
HTML
);

//On vérifie que l'utilisateur est connecté
if(!Users::isConnected()){
    header('Location: connexion.php?a=1'.SID);
}
else {
    $user = Users::getInstance();
}

if($user->inServer() || $user->ownServer()){
    header('Location: index.php'.SID);
}



//On vérifie qu'on à reçu des données
if(isset($_POST['serverName']) && isset($_POST['serverMode'])){
  try{
      //On test que le serveur existe
      $server = Servers::getServerByName($_POST['serverName']);
      $max =  selectRequest(array("id" => $server->getIdServer()),array(PDO::FETCH_ASSOC), "MAX(numPlayer) AS M","Players","idServer = :id");
      if($_POST['serverMode'] == "join"){
          Players::addPlayer($server->getIdServer(),$user->getIdUser(),$max[0]["M"]+1);
          header('Location: repartition.php'.SID);
      }
      else {
          echo("Le serveur existe déjà");
      }
  } catch (Exception $e){
        if($_POST['serverMode'] == "create"){
            //On créé le server, puis on ajoute le propriétaire à sa partie dans la table Players
            Servers::createServer($user->getIdUser(),$_POST['serverName']);
            header('Location: listPlayers.php'.SID);
        }
        else {
            echo ($e->getMessage());
        }
    }
}

$servers = Servers::getServers();

$webpage->appendContent(<<<HTML
            <form action="create.php" method="post">
               <input type="radio" name="serverMode" id="create" value="create" required>
               <label for="create">Créer un serveur</label>
               <input type="radio" name="serverMode" id="join" value="join" required>
               <label for="create">Rejoindre un serveur</label>
               <input type="text" name="serverName" required>  
               <button type="submit" class="btn">X</button>                
            </form>
HTML
);

foreach($servers as $s){
    //$proprio = Users::getUserById($s->getIdOwner());
    //$webpage->appendContent("<p>{$s->getNameServer()} de {$proprio->getLogin()}</p>");
    $webpage->appendContent("<form action='create.php' method='post'><input type='text' name='serverName' value='{$s->getNameServer()}' hidden> {$s->getNameServer()} <button name='serverMode' type='submit' value='join' class='btn'>Rejoindre</button></form>");
}

$webpage->appendContent(">Accueil</a>");

echo($webpage->toHTML());
