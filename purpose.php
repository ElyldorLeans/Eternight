<?php
 require_once('inc/autoload.inc.php');

$webpage = new Webpage("Eternight - A propos");

$webpage->appendContent(<<<HTML
        <div class="container" style="margin-top: 20px">
            <h1 class="text-primary">À PROPOS</h1>
            <hr class="alert-success">
            <h2>Objectifs</h2>
            <p>Le Loup Garou Nuit Permanente est une variante du célèbre jeu Les Loups-Garous de Thiercelieux. Il s’agit d’un jeu où les joueurs vont chacun avoir un rôle avec des pouvoirs, et vont devoir remplir certaines conditions, suivant leur rôle, pour gagner la partie. C’est une variante que propose l’association Le Coin du Joueur lors d’évènements organisés plusieurs fois dans le semestre à l’UTC.</p>
            <p>Ce jeu nécessite une organisation et une coordination importante entre les organisateurs ou maîtres du jeu et les joueurs. En effet, chaque joueur, afin de valider son pouvoir, doit communiquer ses actions aux maîtres du jeu. Ces derniers lui tiendront une feuille de route qu’il peut consulter. Ainsi, cette phase du jeu est longue et se répète à chaque tour.</p>
            <p>Afin de gagner en efficacité, l’association aimerait pouvoir disposer d’une application permettant d’automatiser les phases les plus longues du jeu.</p>
            <p>Eternight est une application web dont le but est de répondre à ces besoins. L’idée centrale du projet est l'asymétrie de l’application, avec d’un côté l’application pour les joueurs et d’un autre côté l’application pour les organisateurs.</p>
            <p>Les organisateurs pourront créer des serveurs qui seront joignables par les joueurs. Ces derniers devront utiliser leurs smartphones, ou un quelconque autre appareil connecté à internet, afin de se connecter au serveur. Leur smartphone deviendra leur support de jeu. Ils y verront les informations dont ils disposent, pourront consulter les règles du jeu et effectuer leurs actions suivant le rôle qui leur aura été attribué.</p>
            <p>Ainsi, les actions pourront être saisies en simultanées et leurs conséquences calculées automatiquement, élément le plus chronophage dans l’organisation du jeu.</p>
            <h2>Synthèse du cahier des charges</h2>
            <p>Vivamus vulputate gravida justo iaculis malesuada. Quisque nec dolor dolor. Integer tempus dignissim mi nec aliquet. Etiam ultrices justo ac velit sagittis, non dictum tellus laoreet. </p>
            <h2>Architecture</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id sapien porta, dictum ex id, finibus eros. Nam porta purus eget pellentesque sollicitudin.</p>
            <h2>Limites et améliorations possibles</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id sapien porta, dictum ex id, finibus eros. Nam porta purus eget pellentesque sollicitudin.</p>
            <p>(lien vers la maquette?)</p>
        </div>
HTML
);

echo($webpage->toHTML());
