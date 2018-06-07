<?php

class Webpage {

    /**
     * @var string Texte compris entre <head> et </head>
     */
    protected $head  = null ;

    /**
     * @var string Texte compris entre <title> et </title>
     */
    protected $title = null ;

    /**
     * @var string Texte compris entre <body> et </body>
     */
    protected $body  = null ;

    /**
     * Constructeur
     * @param string $title Le titre de la page
     */
    public function __construct($title="DEFAULT") {
        $this->title= $title;
        $this->appendContent(<<<HTML
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="./index.php" title="Eternight">
            <img style="max-width:150px; margin-top: -7px;"
                 src="./images/eternight.png">
        </a>
        <a>
            <h1>Eternight</h1>
            <p><b>「エターナイト」</b></p>
        </a>
    </nav>
HTML
);
        $this->getMenu();
    }

    /**
     * Protéger les caractères spéciaux pouvant dégrader la page Web
     * @param string $string La chaîne à protéger
     * @return string La chaîne protégée
     */
    public function escapeString($string) {
        return htmlentities($string, ENT_QUOTES | ENT_HTML5, "utf-8");
    }

    /**
     * Ajouter un contenu dans head
     * @param string $string le contenu à ajouter
     */
    public function appendToHead($string) {
        $this->head .= $string;
    }

    /**
     * Ajouter l'URL d'un script CSS dans head
     * @param $url string l'URL du script CSS
     * @param null $media media du css
     */
    public function appendCssUrl($url, $media = null) {
        $media = ($media === null) ? "" : "media=\"" . $media . "\"";
        $this->appendToHead(<<<HTML
    <link rel="stylesheet" type="text/css" $media href="{$url}">

HTML
        ) ;
    }

    /**
     * Ajouter l'URL d'un script JavaScript dans head
     * @param string $url L'URL du script JavaScript
     */
    public function appendJsUrl($url) {
        $this->appendToHead(<<<HTML
    <script type='text/javascript' src='$url'></script>

HTML
        ) ;
    }

    /**
     * Ajouter un contenu dans body
     * @param string $content Le contenu à ajouter
     */
    public function appendContent($content) {
        $this->body .= $content;
    }

    /**
     * Générer le menu de la page courante
     */
    public function getMenu() {
        $user = Users::getInstance();
        $this->appendContent(<<<HTML
            <div class="bs-component">
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
            
                    <div class="collapse navbar-collapse" id="navbarColor02">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="./index.php">Accueil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./purpose.php">À propos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./rules.php">Règles</a>
                            </li>
                        
                    
HTML
);
        if(Users::isConnected()){

            if(!$user->inServer() && !$user->ownServer()) $this->appendContent(<<<HTML
                            <li class="nav-item">
                                <a class="nav-link" href="./create.php">Créer / Rejoindre un salon</a>
                            </li>
                </u1>
            </div>
        </nav>
    </div>
HTML
);
            else {
                if ($user->ownServer()) {
                    $this->appendContent(<<<HTML
                            <li class="nav-item">
                                <a class="nav-link" href="./manageServer.php">Gestion</a>
                            </li>
HTML
                    );
                    $this->appendContent(<<<HTML
                            <li class="nav-item">
                                <a class="nav-link" href="./listPlayers.php">Liste des joueurs</a>
                            </li>
HTML
                    );
                } else {
                    if($user->inServer()){
                        $this->appendContent(<<<HTML
                            <li class="nav-item">
                                <a class="nav-link" href="./game.php">Jeu</a>
                            </li>
HTML
                        );
                        $this->appendContent(<<<HTML
                            <li class="nav-item">
                                <a class="nav-link" href="./info.php">Informations</a>
                            </li>
HTML
                        );
                        $this->appendContent(<<<HTML
                            <li class="nav-item">
                                <a class="nav-link" href="./listPlayers.php">Liste des joueurs</a>
                            </li>
HTML
                        );
                    }
                }
            }
            $this->appendContent(<<<HTML
                            <li class="nav-item">
                                <a class="nav-link" href="./authentification.php">Déconnexion</a>
                            </li>
                </u1>
            </div>
        </nav>
    </div>
HTML
);
        }
        else {
            $this->appendContent(<<<HTML
                            <li class="nav-item">
                                <a class="nav-link" href="./connexion.php">Inscription</a>
                            </li>
                </u1>
            </div>
        </nav>
    </div>
HTML
);
        }
    }

    /**
     * Produire la page Web complète
     * @return string htmlcode
     */
    public function toHTML() {
        return <<<HTML
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <script type='text/javascript' src="js/jQuery.js"></script>
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
        <script type="text/javascript" src="bootstrap/js/bootstrap.js" charset="UTF-8"></script>
        <title>{$this->title}</title>
    {$this->head}
    </head>
    <body>
    {$this->body}
    </body>
</html>
HTML;
    }
}