<?php

require_once(projectPath.'inc/autoload.inc.php');
require_once (projectPath.'inc/requestUtils.inc.php');

class Players
{
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
     * @param $id int id of a player
     * @return Players
     * @throws Exception if no player has been found
     */
    public static function getPlayerById($id){
        $res = selectRequest(array("id" => $id),array(PDO::FETCH_CLASS => 'Players'), "*","Players","idPlayer = :id");
        if(isset($res[0])){
            return $res[0];
        } else {
            throw new Exception("Aucun joueur trouvé");
        }
    }

    public static function createPlayersByServer($idServer){
        $res = selectRequest(array("idServer" => $idServer), array(PDO::FETCH_CLASS => 'Players'),"*","Players","idServer = :idServer");
        if(isset($res)){
            return $res;
        } else {
            throw new Exception("Serveur inexistant");
        }
    }

    public static function addPlayer($idServer,$idPlayer,$numPlayer){
        try{
            insertRequest(array("idServer" => $idServer,"idPlayer" => $idPlayer,"numPlayer" => $numPlayer),"Players(idPlayer,idServer,numPlayer)","(:idPlayer,:idServer,:numPlayer)");

        } catch(Exception $e) {
            throw new Exception("Vous êtes déjà dans ce serveur");
        }
    }

    /**
     * Returns the village targets for the player with the given id.
     * @param int id
     * @param int idServer
     * @return array(int)
     */
    static public function getTargetIdsForPlayer($id, $idServer) {
        $res = selectRequest(array("id" => $id, "idServer" => $idServer), array(PDO::FETCH_NUM), "idTargeted","VillageTargets","idTargeter = :id AND idServer = :idServer");
        // TODO Uniq and shit
        if(isset($res)) {
            return $res;
        } else {
            return null;
        }
    }

    /**
     * @return null
     */
    public function getIdPlayer()
    {
        return $this->idPlayer;
    }

    /**
     * @param null $idPlayer
     */
    public function setIdPlayer($idPlayer)
    {
        $this->idPlayer = $idPlayer;
    }

    /**
     * @return null
     */
    public function getIdServer()
    {
        return $this->idServer;
    }

    /**
     * @param null $idSrver
     */
    public function setIdServer($idServer)
    {
        $this->idServer = $idServer;
    }

    /**
     * @return null
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param null $idRole
     */
    public function setIdRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return null
     */
    public function getPhase()
    {
        return $this->phase;
    }

    /**
     * @param null $phase
     */
    public function setPhase($phase)
    {
        $this->phase = $phase;
    }

    /**
     * @return null
     */
    public function getNumPlayer()
    {
        return $this->numPlayer;
    }

    /**
     * @param null $numPlayer
     */
    public function setNumPlayer($numPlayer)
    {
        $this->numPlayer = $numPlayer;
    }

    /**
     * @return null
     */
    public function getRoadSheet()
    {
        return $this->roadSheet;
    }

    /**
     * @param null $roadSheet
     */
    public function setRoadSheet($roadSheet)
    {
        $this->roadSheet = $roadSheet;
    }

    /**
     * Does the action associated to the role of the player with the given id.
     */
    static public function action($playerId) {
        $player = Players::getPlayerById($playerId);

//        if (in_array($player->role, array("Loup Garou", "Loup Blanc", "Voyante Corrompue", "Sorcière Corrompue"))) {
//            self::actionLycanthrope($player);
//        }

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
                break;
        }
    }

    /**
     * The "Loup Blanc"'s action.
     * @param Players $player
     */
    static public function actionWhiteWerewolf($player) {
        // Manger du loup ?
    }

    /**
     * The "Voyante"'s action.
     * @param Players $player
     * @param bool $lycanthrope
     */
    static public function actionPsychic($player, $lycanthrope = false) {
        // Voir le rôle de quelqu'un, ou 3 rôle si lycanthrope

    }

    /**
     * The "Statisticien"'s action.
     * @param Players $player
     */
    static public function actionStatistician($player) {
        // Avoir BEAUCOUP TROP D'INFOS
    }

    /**
     * The "Sorcière"'s action.
     * @param Players $player
     * @param bool $lycanthrope
     */
    static public function actionSorcerer($player, $lycanthrope = false) {
        if (lycanthrope == false) {
            throw new BadMethodCallException("Sorcière action not implemented yet");
        }
    }
}