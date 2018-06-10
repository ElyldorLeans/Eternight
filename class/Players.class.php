<?php

require_once(projectPath . 'inc/autoload.inc.php');
require_once(projectPath . 'inc/requestUtils.inc.php');

class Players {
    /**
     * @var int
     */
    private $idPlayer = null;
    /**
     * @var int
     */
    private $idServer = null;
    /**
     * @var string
     */
    private $role = null;
    /**
     * @var int
     */
    private $phase = null;
    /**
     * @var int
     */
    private $numPlayer = null;
    /**
     * @var string
     */
    private $roadSheet = null;
    /**
     * @var bool
     */
    private $isDead = false;

    /**
     * @param $id int id of a player
     * @return Players
     * @throws Exception if no player has been found
     */
    public static function getPlayerById ($id) {
        $res = selectRequest(array("id" => $id), array(PDO::FETCH_CLASS => 'Players'), "*", "Players", "idPlayer = :id");
        if (isset($res[0])) {
            return $res[0];
        } else {
            throw new Exception("Aucun joueur trouvé");
        }
    }

    public static function createPlayersByServer ($idServer) {
        $res = selectRequest(array("idServer" => $idServer), array(PDO::FETCH_CLASS => 'Players'), "*", "Players", "idServer = :idServer", "ORDER BY numPlayer");
        if (isset($res)) {
            return $res;
        } else {
            throw new Exception("Serveur inexistant");
        }
    }

    public static function addPlayer ($idServer, $idPlayer, $numPlayer) {
        try {
            insertRequest(array("idServer" => $idServer, "idPlayer" => $idPlayer, "numPlayer" => $numPlayer), "Players(idPlayer,idServer,numPlayer)", "(:idPlayer,:idServer,:numPlayer)");

        } catch (Exception $e) {
            throw new Exception("Vous êtes déjà dans ce serveur");
        }
    }

    /**
     * Returns the village targets for the player with the given id.
     * @param int $idPlayer
     * @param int $idServer
     * @return array(Players)
     */
    static public function getTargetsForPlayer ($idPlayer, $idServer) {
        $res = selectRequest(array("idPlayer" => $idPlayer, "idServer" => $idServer), array(PDO::FETCH_CLASS => 'Players'), "P.idServer, P.idPlayer, P.role, P.phase, P.numPlayer, P.roadSheet, P.isDead",
            "VillageTargets V, Players P", "V.idTargeter = :idPlayer AND V.idServer = :idServer AND P.idPlayer = V.idTargeted");

        if (isset($res)) {
            return $res;
        } else {
            return null;
        }
    }

    /**
     * Returns the name of the given player.
     * @param int $idServer
     * @return array(Players)
     */
    static public function getPlayersForServer ($idServer) {
        $res = selectRequest(array("idServer" => $idServer), array(PDO::FETCH_CLASS => 'Players'), "*", "Players", "idServer = :idServer");
        if (isset($res)) {
            return $res;
        } else {
            throw new Exception("Aucun joueur pour le serveur donné.");
        }
    }

    /**
     * @return null
     */
    public function getIdPlayer () {
        return $this->idPlayer;
    }

    /**
     * @param null $idPlayer
     */
    public function setIdPlayer ($idPlayer) {
        $this->idPlayer = $idPlayer;
    }

    /**
     * @return null
     */
    public function getIdServer () {
        return $this->idServer;
    }

    /**
     * @param null $idSrver
     */
    public function setIdServer ($idServer) {
        $this->idServer = $idServer;
    }

    /**
     * @return null
     */
    public function getRole () {
        return $this->role;
    }

    /**
     * @param null $idRole
     */
    public function setIdRole ($role) {
        $this->role = $role;
    }

    /**
     * @return null
     */
    public function getPhase () {
        return $this->phase;
    }

    /**
     * @param null $phase
     */
    public function setPhase ($phase) {
        $this->phase = $phase;
    }

    /**
     * @return null
     */
    public function getNumPlayer () {
        return $this->numPlayer;
    }

    /**
     * @param null $numPlayer
     */
    public function setNumPlayer ($numPlayer) {
        $this->numPlayer = $numPlayer;
    }

    /**
     * @return null
     */
    public function getRoadSheet () {
        return $this->roadSheet;
    }

    /**
     * @param null $roadSheet
     */
    public function setRoadSheet ($roadSheet) {
        $this->roadSheet = $roadSheet;
    }

    /**
     * @return null
     */
    public function getIsDead () {
        return $this->isDead;
    }

    /**
     * @param null $isDead
     */
    public function setIsDead ($isDead) {
        $this->isDead = $isDead;
    }

    /**
     * Resolves the actions of all the players of the given server.
     * @param int $serverId
     */
    static public function resolveActions ($serverId) {
        $players = self::getPlayersForServer($serverId);
        foreach ($players as $player) {
            self::action($player);
        }
    }

    /**
     * Does the action associated to the role of the player with the given id.
     * @param Players player
     */
    static public function action ($player) {
        if ($player->isDead) {
            self::writeInRoadSheet($player->idPlayer, $player->idServer, "Tour :\n\nTu es mort. Tu n'as rien pu faire ce tour-ci. Mais qui sait, peut-être te feras-tu ressusciter par une sorcière ?\n\n");
            return;
        }

        switch ($player->role) {
            case "Loup Blanc":
                self::actionWhiteWerewolf($player);
                break;
            case "Voyante":
                self::actionPsychic($player);
                break;
            case "Statistiscien":
                self::actionStatistician($player);
                break;
            case "Voyante Corrompue":
                self::actionPsychic($player, true);
                break;
            case "Sorcière Corrompue":
                self::actionSorcerer($player, true);
                break;
        }
    }

    /**
     * The "Loup Blanc"'s action.
     * @param Players $player
     */
    static public function actionWerewolf ($player) {
        $infoToWrite = "Tour :\n\n";
        // TODO Get cible lycanthropes
        // TODO Know it died
        // TODO Know cibles sorcières
        $infoToWrite .= "\n\n";
        self::writeInRoadSheet($player->idPlayer, $player->idServer, $infoToWrite);
    }

    /**
     * The "Loup Blanc"'s action.
     * @param Players $player
     */
    static public function actionWhiteWerewolf ($player) {
        $infoToWrite = "Tour :\n\n";
        $targets = self::getTargetsForPlayer($player->idPlayer, $player->idServer);
        if ($targets == null) {
            $infoToWrite .= "\nTu as décidé de ne manger aucun loup.";
        } else {
            $infoToWrite .= "\nTu as décidé de manger " . self::getNamePlayer($targets[0]) . ".";
            // TODO Si la cible est un loup
            // TODO Alors tuer
            // TODO Sinon rien lol
        }
        $infoToWrite .= "\n\n";
        self::writeInRoadSheet($player->idPlayer, $player->idServer, $infoToWrite);
    }

    /**
     * The "Voyante"'s action.
     * @param Players $player
     * @param bool $lycanthrope
     */
    static public function actionPsychic ($player, $lycanthrope = false) {
        $infoToWrite = "Tour :\n\n";
        $targets = self::getTargetsForPlayer($player->idPlayer, $player->idServer);
        $infoToWrite .= "\nTu as visé " . self::getNamePlayer($targets[0]) . ".";
        // TODO Voir le rôle de quelqu'un, ou 3 rôle si lycanthrope
        $infoToWrite .= "\n\n";
        self::writeInRoadSheet($player->idPlayer, $player->idServer, $infoToWrite);
    }

    /**
     * The "Statisticien"'s action.
     * @param Players $player
     */
    static public function actionStatistician ($player) {
        $infoToWrite = "Tour :\n\n";
        $targets = self::getTargetsForPlayer($player->idPlayer, $player->idServer);
        $infoToWrite .= "\nTu as visé " . self::getNamePlayer($targets[0]) . ", " . self::getNamePlayer($targets[1]) . " et " . self::getNamePlayer($targets[2]) . ".";
        $infoToWrite .= "\nAu moins un lycanthrope dans les personnes visées ? " . (self::hasLycanthrope($targets[0], $targets[1], $targets[2]) ? "Oui" : "Non");
        $infoToWrite .= "\nNombre de personnes mortes : " . self::getNumberDead($player->idServer);
        $infoToWrite .= "\nNombre de lycanthropes : " . self::getNumberLycanthrope($player->idServer);
        // TODO résultat du vote du village précédent ?
        $infoToWrite .= "\n\n";
        self::writeInRoadSheet($player->idPlayer, $player->idServer, $infoToWrite);
    }

    /**
     * The "Sorcière"'s action.
     * @param Players $player
     * @param bool $lycanthrope
     */
    static public function actionSorcerer ($player, $lycanthrope = false) {
        if (lycanthrope == false) {
            throw new BadMethodCallException("Sorcière action not implemented yet");
        }
        $infoToWrite = "Tour :\n\n";
        $targets = self::getTargetsForPlayer($player->idPlayer, $player->idServer);
        if ($targets == null) {
            $infoToWrite .= "\nTu n'as visé personne.";
        } else {
            $infoToWrite .= "\nTu as visé " . self::getNamePlayer($targets[0]) . ".";
            // TODO Si la cible est déjà en vie, garder le pouvoir
            // TODO Sinon, dépenser le pouvoir définitivement (How tho ?)
        }
        $infoToWrite .= "\n\n";
        self::writeInRoadSheet($player->idPlayer, $player->idServer, $infoToWrite);
    }

    /**
     * Returns the name of the given player.
     * @param Players $player
     * @return string
     */
    static public function getNamePlayer ($player) {
        $res = selectRequest(array("id" => $player->idPlayer), array(PDO::FETCH_ASSOC), "login", "Users", "idUser = :id");
        if (isset($res)) {
            return $res[0][0] . ", n°" . $player->numPlayer;
        } else {
            return null;
        }
    }

    /**
     * Returns the number of dead players.
     * @param int $idServer
     * @return int
     */
    static public function getNumberDead ($idServer) {
        $res = selectRequest(array("idServer" => $idServer), array(PDO::FETCH_ASSOC), "COUNT(idPlayer)", "Players", "idServer = :idServer AND isDead = 1");
        if (isset($res)) {
            return $res[0][0];
        } else {
            return 0;
        }
    }

    /**
     * Returns the number of lycanthropes.
     * @param int $idServer
     * @return int
     */
    static public function getNumberLycanthrope ($idServer) {
        $res = selectRequest(array("idServer" => $idServer), array(PDO::FETCH_ASSOC), "COUNT(idPlayer)", "Players", "idServer = :idServer "
            . "AND (role = 'Loup Garou' OR role = 'Loup Blanc' OR role = 'Voyante Corrompue' OR role = 'Sorcière Corrompue')");
        if (isset($res)) {
            return $res[0][0];
        } else {
            return 0;
        }
    }

    /**
     * Indicates whether there is a lycanthrope in the given players or not.
     * @param Players $player1
     * @param Players $player2
     * @param Players $player3
     * @return bool
     */
    static public function hasLycanthrope ($player1, $player2, $player3) {
        //"AND (role = 'Loup Garou' OR role = 'Loup Blanc' OR role = 'Voyante Corrompue' OR role = 'Sorcière Corrompue')");
        if (in_array($player1->role, array("Loup Garou", "Loup Blanc", "Voyante Corrompue", "Sorcière Corrompue"))) {
            return true;
        }
        if (in_array($player2->role, array("Loup Garou", "Loup Blanc", "Voyante Corrompue", "Sorcière Corrompue"))) {
            return true;
        }
        if (in_array($player3->role, array("Loup Garou", "Loup Blanc", "Voyante Corrompue", "Sorcière Corrompue"))) {
            return true;
        }
        return false;
    }

    /**
     * Appends the given text in the RoadSheet.
     * @param int $idPlayer
     * @param int $idServer
     * @param string $text
     */
    static public function writeInRoadSheet ($idPlayer, $idServer, $text) {
        updateRequest(array("idPlayer" => $idPlayer, "idServer" => $idServer, "text" => $text), "Players", "roadSheet = IFNULL( CONCAT(roadSheet, :text), :text )", "idServer = :idServer AND idPlayer = :idPlayer");
    }

    /**
     * @param int $idServer
     * @return bool true if all players have used their powers, false if they didn't
     * @throws Exception
     */
    public static function isPowerPhaseEnded ($idServer) {
        $a = selectRequest(array("idServer" => $idServer), array(PDO::FETCH_CLASS => 'Players'), "*", "Players", "idServer = :idServer AND phase != 2", "ORDER BY numPlayer");
        if (isset($a) && !empty($a)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param int $idServer
     * @return bool true if all players have used their powers, false if they didn't
     * @throws Exception
     */
    public static function isVotePhaseEnded ($idServer) {
        $a = selectRequest(array("idServer" => $idServer), array(PDO::FETCH_CLASS => 'Players'), "*", "Players", "idServer = :idServer AND phase != 5", "ORDER BY numPlayer");
        if (isset($a) && !empty($a)) {
            return false;
        } else {
            return true;
        }
    }

}