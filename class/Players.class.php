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
     * @var string
     */
    private $roleInfos = null;
    /**
     * All the available roles.
     * ATTENTION Ce tableau détermine l'ordre de résolution des actions par rôle.
     * @var string[]
     */
    public static $roles = array("Loup Blanc", "Voyante Corrompue", "Sorcière Corrompue", "Voyante", "Loup Garou", "Statistiscien");
    /**
     * All the available roles.
     * @var string[]
     */
    public static $lycanthropeRoles = array("Loup Garou", "Loup Blanc", "Voyante Corrompue", "Sorcière Corrompue");

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

    /**
     * Returns the name of the given player.
     * @param int $idServer
     * @return Players[]
     */
    static public function getPlayersForServer ($idServer) {
        $res = selectRequest(array("idServer" => $idServer), array(PDO::FETCH_CLASS => 'Players'), "*", "Players", "idServer = :idServer", "ORDER BY numPlayer");
        if (isset($res)) {
            return $res;
        } else {
            throw new Exception("Aucun joueur pour le serveur donné.");
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
     * @return Players[]
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
     * Returns the werewolf target for the player with the given id.
     * @param int $idPlayer
     * @param int $idServer
     * @return Players
     */
    static public function getWerewolfTargetForPlayer ($idPlayer, $idServer) {
        $res = selectRequest(array("idPlayer" => $idPlayer, "idServer" => $idServer), array(PDO::FETCH_CLASS => 'Players'), "P.idServer, P.idPlayer, P.role, P.phase, P.numPlayer, P.roadSheet, P.isDead",
            "WerewolfTargets W, Players P", "V.idTargeter = :idPlayer AND W.idServer = :idServer AND P.idPlayer = W.idTargeted");

        if (isset($res[0])) {
            return $res[0];
        } else {
            return null;
        }
    }

    /**
     * Returns the village targets for the given role.
     * @param string $role
     * @param int $idServer
     * @return Players[]
     */
    static public function getTargetsForRole ($role, $idServer) {
        $res = selectRequest(array("role" => $role, "idServer" => $idServer), array(PDO::FETCH_CLASS => 'Players'), "P.idServer, P.idPlayer, P.role, P.phase, P.numPlayer, P.roadSheet, P.isDead",
            "VillageTargets V, Players P", "V.idTargeter = :idPlayer AND V.idServer = :idServer AND P.role = :role");

        if (isset($res)) {
            return $res;
        } else {
            return null;
        }
    }

    /**
     * Returns the werewolf main target for the given server.
     * @param int $idServer
     * @return int|null
     */
    static public function getMainWerewolfTarget ($idServer) {
        $res = selectRequest(array("idServer" => $idServer), array(PDO::FETCH_ASSOC), "idTargeted", "WerewolfTargets", "idServer = :idServer");

        if (!isset($res)) {
            return null;
        }
        foreach ($res as &$r) {
            $r = $r[0];
        }
        $res = array_count_values($res);
        $maxKey = key($res);
        $maxValue = $res[0];
        $doubleValue = false;
        foreach ($res as $key => $value) {
            if ($value > $maxValue) {
                $maxValue = $value;
                $maxKey = $key;
                $doubleValue = false;
            } else if ($value == $maxValue) {
                $doubleValue = true;
            }
        }
        if ($doubleValue) {
            return null;
        }
        return $maxKey;
    }

    /**
     * @return int
     */
    public function getIdPlayer () {
        return $this->idPlayer;
    }

    /**
     * @param int $idPlayer
     */
    public function setIdPlayer ($idPlayer) {
        $this->idPlayer = $idPlayer;
    }

    /**
     * @return int
     */
    public function getIdServer () {
        return $this->idServer;
    }

    /**
     * @param int $idServer
     */
    public function setIdServer ($idServer) {
        $this->idServer = $idServer;
    }

    /**
     * @return int
     */
    public function getRole () {
        return $this->role;
    }

    /**
     * @param int $role
     */
    public function setIdRole ($role) {
        $this->role = $role;
    }

    /**
     * @return int
     */
    public function getPhase () {
        return $this->phase;
    }

    /**
     * @param int $phase
     */
    public function setPhase ($phase) {
        $this->phase = $phase;
    }


    /**
     * @return int
     */
    public function getNumPlayer () {
        return $this->numPlayer;
    }

    /**
     * @param int $numPlayer
     */
    public function setNumPlayer ($numPlayer) {
        $this->numPlayer = $numPlayer;
    }

    /**
     * @return string
     */
    public function getRoadSheet () {
        return $this->roadSheet;
    }

    /**
     * @param string $roadSheet
     */
    public function setRoadSheet ($roadSheet) {
        $this->roadSheet = $roadSheet;
    }

    /**
     * @return bool
     */
    public function getIsDead () {
        return $this->isDead;
    }

    /**
     * @param bool $isDead
     */
    public function setIsDead ($isDead) {
        $this->isDead = $isDead;
    }

    /**
     * @return string
     */
    public function getRoleInfos () {
        return $this->roleInfos;
    }

    /**
     * @param string $key
     * @return string
     */
    public function getValueInRoleInfos ($key) {
        $values = json_decode($this->roleInfos, true);
        if ($values == null) {
            return null;
        }
        return $values[$key];
    }

    /**
     * @param string $roleInfos
     */
    public function setRoleInfos ($roleInfos) {
        $this->roleInfos = $roleInfos;
    }

    /**
     * @param int $serverId
     * @return string
     */
    public function getActionsSynopsis ($serverId) {
        $res = "";
        $players = self::getPlayersForServer($serverId);
        foreach ($players as $player) {
            $res .= $player->numPlayer . " - " . $player->role . "<br/>";
            $targets = self::getTargetsForPlayer($player->idPlayer, $player->idServer);
            foreach ($targets as $target) {
                $res .= "&nbsp;&nbsp;&nbsp;&nbsp;Vise" . $target->numPlayer . " - " . $target->role . "<br/>";
            }
            $werewolfTarget = self::getWerewolfTargetForPlayer($player->idPlayer, $serverId);
            if ($werewolfTarget != null) {
                $res .= "&nbsp;&nbsp;&nbsp;&nbsp;Vote loup" . $werewolfTarget->numPlayer . " - " . $werewolfTarget->role . "<br/>";
            }
            $res .= "<br/>";
        }
    }

    /**
     * Resolves the actions of all the players of the given server.
     * @param int $serverId
     */
    static public function resolveActions ($serverId) {
        $players = self::getPlayersForServer($serverId);
        $werewolfTargetId = self::getMainWerewolfTarget($serverId);
        if ($werewolfTargetId != null) {
            self::kill($werewolfTargetId, $serverId);
        }
        $playersByRole = array();
        foreach ($players as $player) {
            $playersByRole[$player->role][] = $player;
        }
        foreach (self::$roles as $role) {
            if (isset($playersByRole[$role])) {
                foreach ($playersByRole[$role] as $player) {
                    self::action($player);
                }
            }
        }
        self::emptyTargets($serverId);
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
            case "Loup Garou":
                self::actionWerewolf($player);
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
        $infoToWrite = "Tour :\n";
        $targetId = self::getMainWerewolfTarget($player->idServer);
        if ($targetId == null) {
            $infoToWrite .= "\nLes lycanthropes ne se sont pas mis d'accord sur qui manger cette nuit.";
        } else {
            $werewolfTarget = self::getPlayerById($targetId);
            $infoToWrite .= "\nLa cible des lycanthropes est " . self::getNamePlayer($werewolfTarget) . ". ";
            if ($werewolfTarget->isDead) {
                $infoToWrite .= "Elle est bien morte.";
            } else {
                $infoToWrite .= "Elle n'est pas morte.";
            }
        }

        $sorcererTargets = self::getTargetsForRole("Sorcière", $player->idServer);
        if ($sorcererTargets != null) {
            $infoToWrite .= "\n" . self::getNamePlayer(array_pop($sorcererTargets));
            foreach ($sorcererTargets as $target) {
                $infoToWrite .= ", " . self::getNamePlayer($target);
            }
            $infoToWrite .= (count($sorcererTargets) == 0 ? "a été visé" : "ont été visés") . " par une/des sorcière(s).";
        } else {
            $infoToWrite .= "\nPersonne n'a été visé par une sorcière cette nuit.";
        }
        $infoToWrite .= "\n\n";
        self::writeInRoadSheet($player->idPlayer, $player->idServer, $infoToWrite);
    }

    /**
     * The "Loup Blanc"'s action.
     * @param Players $player
     */
    static public function actionWhiteWerewolf ($player) {
        $infoToWrite = "Tour :\n";
        $targets = self::getTargetsForPlayer($player->idPlayer, $player->idServer);
        if ($targets == null) {
            $infoToWrite .= "\nTu as décidé de ne tuer aucun loup.";
        } else {
            $infoToWrite .= "\nTu as décidé de tuer " . self::getNamePlayer($targets[0]) . ".";
            // Ne tue que si la cible est lycanthrope
            if (in_array($targets[0]->role, Players::$lycanthropeRoles)) {
                self::kill($targets[0]->idPlayer, $targets[0]->idServer);
            }
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
        $infoToWrite = "Tour :\n";
        $targets = self::getTargetsForPlayer($player->idPlayer, $player->idServer);
        $name = self::getNamePlayer($targets[0]);
        $infoToWrite .= "\nTu as visé " . $name . ".";
        if (!$lycanthrope) {
            $infoToWrite .= "\nTu sais que " . $name . " a pour rôle \"" . $targets[0]->role . "\".";
        } else {
            $roleList = self::$roles;
            if (($key = array_search($player->role, $roleList)) !== false) {
                unset($roleList[$key]);
            }
            $randomRoles = array($targets[0]->role);
            shuffle($roleList);
            array_push($randomRoles, array_pop($roleList));
            shuffle($roleList);
            array_push($randomRoles, array_pop($roleList));
            shuffle($randomRoles);

            $infoToWrite .= "\nTu sais que " . $name . " a pour rôle soit \"" . $randomRoles[0] . "\", soit \"" . $randomRoles[1] . "\", soit \"" . $randomRoles[2] . "\".";
        }
        $infoToWrite .= "\n\n";
        self::writeInRoadSheet($player->idPlayer, $player->idServer, $infoToWrite);
    }

    /**
     * The "Statisticien"'s action.
     * @param Players $player
     */
    static public function actionStatistician ($player) {
        $infoToWrite = "Tour :\n";
        $targets = self::getTargetsForPlayer($player->idPlayer, $player->idServer);
        $infoToWrite .= "\nTu as visé " . self::getNamePlayer($targets[0]) . ", " . self::getNamePlayer($targets[1]) . " et " . self::getNamePlayer($targets[2]) . ".";
        $infoToWrite .= "\nAu moins un lycanthrope dans les personnes visées ? " . (self::hasLycanthrope($targets[0], $targets[1], $targets[2]) ? "Oui" : "Non");
        $infoToWrite .= "\nNombre de personnes mortes : " . self::getNumberDead($player->idServer);
        $infoToWrite .= "\nNombre de lycanthropes : " . self::getNumberLycanthrope($player->idServer);
        // TODO résultat du vote du village précédent ? #chiant/20
        $infoToWrite .= "\n\n";
        self::writeInRoadSheet($player->idPlayer, $player->idServer, $infoToWrite);
    }

    /**
     * The "Sorcière"'s action.
     * @param Players $player
     * @param bool $lycanthrope
     */
    static public function actionSorcerer ($player, $lycanthrope = false) {
        if (!$lycanthrope) {
            throw new BadMethodCallException("Sorcière action not implemented yet");
        }
        $infoToWrite = "Tour :\n";
        if ($player->getValueInRoleInfos("sorcererPower") == true) {
            $infoToWrite .= "\nTon pouvoir étant déjà utilisé, tu n'as rien pu faire ce tour-ci.";
        } else {
            $targets = self::getTargetsForPlayer($player->idPlayer, $player->idServer);
            if ($targets == null) {
                $infoToWrite .= "\nTu n'as visé personne.";
            } else {
                $target = $targets[0];
                $infoToWrite .= "\nTu as visé " . self::getNamePlayer($target) . ".";
                // Ne ressusciter la cible que si elle est morte.
                if ($target->isDead) {
                    self::resurrect($player->idPlayer, $player->idServer);
                    self::writeInRoleInfos($player, array("sorcererPower" => true));
                }
            }
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
        if (in_array($player1->role, Players::$lycanthropeRoles)) {
            return true;
        }
        if (in_array($player2->role, Players::$lycanthropeRoles)) {
            return true;
        }
        if (in_array($player3->role, Players::$lycanthropeRoles)) {
            return true;
        }
        return false;
    }

    /**
     * Adds the given values in the roleInfos field for the given player.
     * @param Players $player
     * @param array $values
     */
    static public function writeInRoleInfos ($player, $values) {
        if ($player->roleInfos != null) {
            $jsonValues = json_decode($player->roleInfos, true);
        } else {
            $jsonValues = array();
        }
        $jsonValues = array_merge($jsonValues, $values);
        $text = json_encode($jsonValues);
        updateRequest(array("idPlayer" => $player->idPlayer, "idServer" => $player->idServer, "text" => $text), "Players", "roleInfos = :text", "idServer = :idServer AND idPlayer = :idPlayer");
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
     * Appends the given text in the RoadSheet.
     * @param int $idPlayer
     * @param int $idServer
     */
    static public function resurrect ($idPlayer, $idServer) {
        updateRequest(array("idPlayer" => $idPlayer, "idServer" => $idServer), "Players", "isDead = false", "idServer = :idServer AND idPlayer = :idPlayer");
    }

    /**
     * Appends the given text in the RoadSheet.
     * @param int $idPlayer
     * @param int $idServer
     */
    static public function kill ($idPlayer, $idServer) {
        updateRequest(array("idPlayer" => $idPlayer, "idServer" => $idServer), "Players", "isDead = true", "idServer = :idServer AND idPlayer = :idPlayer");
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

    public static function isRepartPhaseEnded($idServer){
        $a = selectRequest(array("idServer" => $idServer), array(PDO::FETCH_CLASS => 'Players'), "*", "Players", "idServer = :idServer AND phase != 1", "ORDER BY numPlayer");
        if (isset($a) && !empty($a)) {
            return false;
        } else {
            return true;
        }
    }

    public static function isDelibPhaseEnded($idServer){
        $a = selectRequest(array("idServer" => $idServer), array(PDO::FETCH_CLASS => 'Players'), "*", "Players", "idServer = :idServer AND phase != 4", "ORDER BY numPlayer");
        if (isset($a) && !empty($a)) {
            return false;
        } else {
            return true;
        }
    }

    public static function getMinimumPhase($idServer){
        $res = selectRequest(array("idServer" => $idServer), array(PDO::FETCH_ASSOC), "min(phase)", "Players", "idServer = :idServer");
        if(isset($res) && !empty($res)){
            return $res[0];
        }
        else {
            return -1;
        }
    }

    public static function alreadyVoteWW($idServer,$idTargeter,$idTargeted){
        $a = selectRequest(array("idServer" => $idServer, "idTargeter" => $idTargeter,"idTargeted" => $idTargeted), array(PDO::FETCH_ASSOC), "*", "WerewolfTargets", "idServer = :idServer AND idTargeted = :idTargeted AND idTargeter = :idTargeter");
        if (isset($a) && !empty($a)) {
            return true;
        } else {
            return false;
        }
    }

    public static function alreadyVoteVil($idServer,$idTargeter,$idTargeted){
        $a = selectRequest(array("idServer" => $idServer, "idTargeter" => $idTargeter,"idTargeted" => $idTargeted), array(PDO::FETCH_ASSOC), "*", "VillageTargets", "idServer = :idServer AND idTargeted = :idTargeted AND idTargeter = :idTargeter");
        if (isset($a) && !empty($a)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Empties the VillageTargets and WerewolfTargets table for the players in the given server.
     * @param int $idServer
     */
    public static function emptyTargets ($idServer) {
        deleteRequest(array("idServer" => $idServer), "VillageTargets", "idServer = :idServer");
        deleteRequest(array("idServer" => $idServer), "WerewolfTargets", "idServer = :idServer");
    }

}