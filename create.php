<?php

require_once('./inc/autoload.inc.php');

$webpage = new Webpage("Eternight - Accueil");

$webpage->appendContent(<<<HTML
    <div class="jumbotron text-center">
        <h1>Eternight</h1>
         <p>Parce qu'on avait pas de meilleur nom</p>
    </div>
HTML
);


$exist = false;
$correctName = true;
//On vérifie qu'on à reçu des données
if(isset($_POST['serverName']) && isset($_POST['serverMode'])){
  try{
      //On test que le serveur existe
      $server = Servers::getServerByName($_POST['serverName']);
      if($_POST['serverMode'] == "join"){
          insertRequest(array("idServer" => $server->getIdServer()),"Players(idPlayer,idServer,idRole,roadSheet)","(1,:idServer,1,'lol')");
      }
      else {
          $exist = true;
      }
  } catch (Exception $e){
        if($_POST['serverMode'] == "create"){
            //On créé le server, puis on ajoute le propriétaire à sa partie dans la table Players
            Servers::createServer(1,$_POST['serverName']);
        }
        else {
            $correctName = false;
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

//Créer l'alerte que le serveur existe déjà (eavec une div)
if($exist){echo("Le serveur existe déjà");}
//Créer l'alerte que le nom du serveur n'existe pas (avec une div)
if(!$correctName){echo("Le serveur n'existe pas");}

foreach($servers as $s){
    //$proprio = Users::getUserById($s->getIdOwner());
    //$webpage->appendContent("<p>{$s->getNameServer()} de {$proprio->getLogin()}</p>");
    $webpage->appendContent("<form action='create.php' method='post'><input type='text' name='serverName' value='{$s->getNameServer()}' hidden> {$s->getNameServer()} <button name='serverMode' type='submit' value='join' class='btn'>Rejoindre</button></form>");
}

$webpage->appendContent("        <a href=\"./index.php\">Accueil</a>");

echo($webpage->toHTML());