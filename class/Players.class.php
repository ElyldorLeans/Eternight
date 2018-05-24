<?php

require_once(projectPath.'inc/autoload.inc.php');
require_once (projectPath.'inc/requestUtils.inc.php');

class Players
{
    private $idPlayer = null;
    private $idServer = null;
    private $role = null;
    private $phase = null;
    private $numPlayer = null;
    private $roadSheet = null;


    public static function createPlayersByServer($idServer){
        $res = selectRequest(array("idServer" => $idServer), array(PDO::FETCH_CLASS => 'Players'),"idPlayer","Players","idServer = :idServer");
        if(isset($res)){
            return $res;
        } else {
            throw new Exception("Serveur inexistant");
        }
    }


    public static function addPlayer($idServer,$idPlayer){
        try{
            insertRequest(array("idServer" => $idServer,"idPlayer" => $idPlayer),"Players(idPlayer,idServer)","(:idPlayer,:idServer)");

        } catch(Exception $e) {
            throw new Exception("Vous êtes déjà dans ce serveur");
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
     * TODO
     */
    static public function action() {
        // Un gros gros switch case
    }

    /**
     * The "Lycanthrope"'s action.
     */
    static public function actionLycanthrope() {
        // Voter pour une victime => résolution à la fin de qui miam miam
    }

    /**
     * The "Voyante"'s action.
     * @param bool $lycanthrope
     */
    static public function actionPsychic($lycanthrope = false) {
        // Voir le rôle de quelqu'un, ou 3 rôle si lycanthrope
    }

    /**
     * The "Statisticien"'s action.
     */
    static public function actionStatistician() {
        // Avoir BEAUCOUP TRPO D'INFOS
    }

    /**
     * The "Loup Blanc"'s action.
     */
    static public function actionWhiteWerewolf() {
        // Manger du loup ?
    }
}