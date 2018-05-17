<?php

require_once(projectPath.'inc/autoload.inc.php');
require_once (projectPath.'inc/requestUtils.inc.php');

class Players
{
    private $idUser = null;
    private $idServer = null;
    private $idRole = null;
    private $phase = null;
    private $numPlayer = null;
    private $roadSheet = null;


    public static function addPlayer($idServer,$idUser){
        try{
            insertRequest(array("idServer" => $idServer,"idPlayer" => $idUser),"Players(idPlayer,idServer)","(:idPlayer,:idServer)");

        } catch(Exception $e) {
            throw new Exception("Vous êtes déjà dans ce serveur");
        }
    }

    /**
     * @return null
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param null $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return null
     */
    public function getIdSrver()
    {
        return $this->idSrver;
    }

    /**
     * @param null $idSrver
     */
    public function setIdSrver($idSrver)
    {
        $this->idSrver = $idSrver;
    }

    /**
     * @return null
     */
    public function getIdRole()
    {
        return $this->idRole;
    }

    /**
     * @param null $idRole
     */
    public function setIdRole($idRole)
    {
        $this->idRole = $idRole;
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


}