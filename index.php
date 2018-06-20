<?php
require_once('inc/autoload.inc.php');

$webpage = new Webpage("Eternight - Accueil");

$webpage->appendContent(<<<HTML
        <div class="container" style="margin-top: 20px">
            <h1 class="text-primary">À Propos</h1>
            <hr class="alert-success">

            <p>Le projet Eternight est un projet réalisé dans le cadre de l'UV NF28. Il a pour but de servir d'aide lors de jeux Loup Garou nuit permanente organisés par l'association UTCéenne Le Coin du Joueur.</p>
            <h2>Objectifs</h2>
            <p>Le Loup Garou Nuit Permanente est une variante du célèbre jeu Les Loups-Garous de Thiercelieux. Il s’agit d’un jeu où les joueurs vont chacun avoir un rôle avec des pouvoirs, et vont devoir remplir certaines conditions, suivant leur rôle, pour gagner la partie. C’est une variante que propose l’association Le Coin du Joueur lors d’évènements organisés plusieurs fois dans le semestre à l’UTC.</p>
            <p>Ce jeu nécessite une organisation et une coordination importante entre les organisateurs ou maîtres du jeu et les joueurs. En effet, chaque joueur, afin de valider son pouvoir, doit communiquer ses actions aux maîtres du jeu. Ces derniers lui tiendront une feuille de route qu’il peut consulter. Ainsi, cette phase du jeu est longue et se répète à chaque tour.</p>
            <p>Afin de gagner en efficacité, l’association voulait pouvoir disposer d’une application permettant d’automatiser les phases les plus longues du jeu.</p>
            <p>Eternight est une application web dont le but est de répondre à ces besoins. L’idée centrale du projet est l'asymétrie de l’application, avec d’un côté l’application pour les joueurs et d’un autre côté l’application pour les organisateurs.</p>
            <p>Les organisateurs peuvent créer des serveurs qui sont joignables par les joueurs. Ces derniers doivent utiliser leurs smartphones, ou un quelconque autre appareil connecté à internet, afin de se connecter au serveur. Leur smartphone deviendra leur support de jeu. Ils y voient les informations dont ils disposent, peuvent consulter les règles du jeu et effectuer leurs actions suivant le rôle qui leur aura été attribué.</p>
            <p>Ainsi, les actions peuvent être saisies en simultané et leurs conséquences sont calculées automatiquement, ce qui était l'élément le plus chronophage dans l’organisation du jeu.</p>
            <h2>Utilisateurs</h2>
            <p>Le jeu Loup Garou Nuit Permanente est organisé, comme dit plus haut, lors de soirées organisées par l'association UTCéenne de jeu de société et jeu de rôle Le Coin du Joueur. Les utilisateurs sont donc des étudiants ayant en moyenne entre 17 et 23 ans, jeunes et habitués aux nouvelles technologies. Ils sont munis d'un smartphone et peuvent se connecter au Wi-Fi gratuit de l'UTC où est organisé le jeu.</p>
            <p>Le public visé est en priorité les élèves de l'UTC participant aux soirées évènement, mais l'application est conçue pour qu'elle soit utilisable dans d'autres cadres, permettant à quiconque connaît un minimum le jeu de pouvoir l'organiser aisément, sans les problèmes que posent l'organisation purement sur papier.</p>
            <h2>Fonctionnement du jeu</h2>
            <p>Le jeu Loup Garou Nuit Permanente se découpe en 4 étapes.</p>
            <ul>
                <li>
                    Tout d'abord, <b>la phase de répartition</b>. Une fois le serveur créé, toute personne qui n'est pas l'organisateur peut rejoindre ce serveur et en devenir joueur. Une fois que l'organisateur décide que tous les joueurs ont rejoint le serveur, il peut avancer vers la première phase de pouvoirs. Lorsqu'il décide d'avancer, un rôle est attribué aléatoirement à chaque joueur selon une répartition prédifinie. On fait également fermer les yeux de l'ensemble des joueurs afin de montrer aux lycanthropes un signe assez discret pour se reconnaître.
                </li>
                <li>
                    Ensuite, <b>la phase de pouvoirs</b>. Pendant cette phase, les joueurs vont parler entre eux par groupes de 3-4 maximum. C'est pendant cette phase que les joueurs vont essayer de glâner et échanger des informations. Les lycanthropes vont essayer de se reconnaître et de se retrouver grâce au symbole montré en début de partie. Tout se base sur les capacités de bluff et de communication des joueurs, sachant que les morts pourront prétendre ne pas l'être, et vice-versa. Les morts n'ont cependant plus accès à leurs pouvoirs. Lors de cette phase, les joueurs vont devoir effectuer leur pouvoir, propre à leur rôle, à travers l'application. Les lycanthropes devront également désigner une personne qu'ils aimeraient voir mangée par le loup garou. Lorsque tout le monde fait ses actions et que l'organisateur considère qu'il est temps de passer à la prochaine phase, ce dernier peut décider d'avancer. Ceci déclenche la résolution automatique des pouvoirs, tue la cible des lycanthropes s'ils ont réussi à se mettre d'accord, et rempli de précieuses informations les feuilles de routes des joueurs.
                </li>
                <li>
                    Suit <b>la phase de délibérations</b>. Pendant cette phase, les joueurs vont s'asseoir en cercle au milieu de la salle. Un token - peluche, clés, objet quelconque - sera donné à la première personne voulant parler. Ce token sera passé de personne en personne, selon qui veut prendre la parole, et seul la personne le possédant pourra s'exprimer. Cette phase est la seule phase où les joueurs pourront avoir une influence sur l'ensemble des autres joueurs, ce qui stratégiquement parlant est très important. Lorsque l'organisateur décide que les délibérations ont assez duré, il peut décider d'avancer vers la phase suivante.
                </li>
                <li>
                    Enfin, <b>la phase de votes</b>. Pendant cette phase, toute personne non morte devra désigner une personne qu'il aimerait voir pendu sur la place du village. Lorsque tout le monde a voté, l'organisateur peut décider d'avancer. Si le village a réussi à se mettre d'accord sur une cible, elle meurt. On commence alors un nouveau tour en revenant à la phase de pouvoirs !
                </li>
            </ul>
            <p>Le jeu se termine quand l'organisateur voit que soit les lycanthropes, soit les villageois ont été exterminés. Toute personne ayant réussi son objectif va donc gagner la partie.</p>
            <h2>Architecture</h2>
            <p>Le projet a été réalisé en PHP5, HTML5, CSS3, Javascript. Nous avons utilisé Ajax pour mettre les pages à jour en temps réel, MySQL pour la base de données, ainsi que Bootstrap et un <a href="https://bootswatch.com/solar/">thème Bootswatch</a> pour le style graphique du site. Le projet est hébergé sur le site de l'association Le Coin du Joueur.</p>
            <p>Toutes nos pages sont générées à partir de classes héritant de la classe mère Webpage, ce qui permet de factoriser le style et le header de la page. Le fichier autoload permet de charger les bons fichiers sur la page courante, et le notre gestion de base de données se fait à travers le PDO. Nous avons également des classes php Players, Servers et Users, ayant les mêmes attributs que leurs équivalent dans la base de données, permettant de récupérer facilement une instance d'une de ces classes à travers le PDO.</p>
            <h2>Limites et améliorations possibles</h2>
            <p>Le projet en l'état est une version alpha. L'objectif est de réaliser une version complète afin de pouvoir l'utiliser dans le cadre des soirées de l'association Le Coin du Joueur dès Septembre 2018. Ils reste encore plusieurs choses à implémenter :</p>
            <ul>
                <li>
                    Seulement cinq rôles sont implémentés pour l'instant sur vingt dans le jeu complet. Certains sont complexes car ils changent la façon dont les actions doivent être résolus et impactent beaucoup d'aspects du jeu.
                </li>
                <li>
                    Un guide digne de ce nom pour l'organisateur devra être écrit, afin d'expliquer de façon concise et claire quel est son rôle et comment se déroule le jeu en détails.
                </li>
                <li>
                    Un système de prise de note pour le joueur devra être mis en place, afin de l'aider à organiser ses informations.
                </li>
                <li>
                    Il reste des détails, petits bugs, et autres fonctionnalités qui relèvent purement de l'affichage à mettre en place pour une expérience plus agréable.
                </li>
            </ul>
        </div>
HTML
);

echo($webpage->toHTML());
