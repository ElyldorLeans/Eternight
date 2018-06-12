<?php
require_once('inc/autoload.inc.php');

$webpage = new Webpage("Eternight - Règles");

$webpage->appendContent(<<<HTML
        <div class="container" style="margin-top: 20px">
            <h1 class="text-primary">RÈGLES</h1>
            <hr class="alert-success">
            <p>Le jeu Loup Garou nuit permanente est un jeu d'identité cachée opposant deux camps : les villageois et les lycanthropes. Chacun veut voir le camp adverse éradiqué, même si certains rôles ont des objectifs uniques.</p>
            <p>Le jeu se déroule en trois phases : la phase de pouvoirs, la phase de délibérations et la phase de vote. Durant la phase de pouvoirs, chaque joueur va pouvoir effectuer son pouvoir à partir de l'onglet Jeu. Pendant cette phase, les joueurs vont aussi devoir discuter entre eux en groupes de 4 maximum. La phase de délibérations sera la seule phase où tous les joueurs se réunissent pour parler à tour de rôle, et débattre ensemble. Durant la phase de vote, chacun va voter pour une personne qu'il aimerait voir pendu sur la place du village.</p>
            <p>Tous les rôles n'ont pas encore été ajoutés dans le jeu, cette version est une version alpha.</p>
            
            <h2 class="text-primary">RÔLES</h2>
            
            <br/>
            <h4 class="text-info">Villageois</h4>
            
            <h5>La Voyante</h5>
            <p>Chaque nuit, la voyante demande l'identité de quelqu'un.</p>
            <p>Sur sa feuille de route, elle récupère le rôle de la personne qu'elle a visée.</p>
            
            <h5>Le Statisticien</h5>
            <p>Chaque nuit, le statisticien choisit trois personnes.</p>
            <p>Sur sa feuille de route, il va savoir s'il y avait un lycanthrope dans les trois personnes visées. Il va également connaître le nombre de personnes mortes et le nombre de lycanthropes vivants.</p>
            
            <br/>
            <h4 class="text-warning">Lycanthropes</h4>
            
            <h5>Le Loup Garou</h5>
            <p>Chaque nuit, le loup garou va voter pour qui il veut dévorer.</p>
            <p>Sur sa feuille de route, il va savoir qui a été voté en majorité stricte par les lycanthropes et si cette personne est bien morte ou pas. Il va également connaître les personnes ciblées par les sorcières corrompues pour de la résurrection.</p>
            
            <h5>La Voyante Corrompue</h5>
            <p>Chaque nuit, la voyante corrompue va demander l'identité de quelqu'un. Elle va également voter pour qui elle veut que les loups garous dévorent.</p>
            <p>Sur sa feuille de route, elle récupère trois rôles dont celui de la personne qu'elle a visée.</p>
            
            <h5>La Sorcière Corrompue</h5>
            <p>Une fois dans la partie, la sorcière corrompue peut choisir de ressusciter un mort. Si la personne visée n'est pas morte, son pouvoir n'est pas dépensé et elle peut réessayer dès la nuit suivante. Elle va également voter pour qui elle veut que les loups garous dévorent.</p>
            <p>Sur sa feuille de route, elle saura si son pouvoir a été utile.</p>
            
            <h5>Le Loup Blanc</h5>
            <p>Le Loup Blanc ne gagne que s'il termine seul. Son but est donc de garder un certain équilibre entre le nombre de villageois et le nombre de lycanthropes, pour éviter qu'un des groupes ne gagne avant lui !</p>
            <p>Une fois dans la partie, le loup blanc peut choisir de tuer un lycanthrope. Si la personne visée n'est pas lycanthrope, elle ne mourra pas. Il va également voter pour qui il veut que les loups garous dévorent.</p>
            <p>Sur sa feuille de route, il aura le compte de lycanthropes vivants.</p>
        </div>
HTML
);

echo($webpage->toHTML());
