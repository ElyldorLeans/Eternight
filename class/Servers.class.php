<?php

require_once(projectPath.'inc/autoload.inc.php');
require_once (projectPath.'inc/requestUtils.inc.php');

class Servers {
    private $idServer = null ;
    private $pwdServer = null ;
    private $nameServer = null ;
    private $descServer = null ;
    private $idOwner = null ;

    public static function createServer($idOwner,$nameServer){
        insertRequest(array("idOwner" => $idOwner, "nameServer" => $nameServer),"Servers(idOwner,nameServer)","(:idOwner, :nameServer)");
    }

    /**
     * @return null
     */
    public function getIdServer()
    {
        return $this->idServer;
    }

    /**
     * @param null $idServer
     */
    public function setIdServer($idServer)
    {
        $this->idServer = $idServer;
    }

    /**
     * @return null
     */
    public function getPwdServer()
    {
        return $this->pwdServer;
    }

    /**
     * @param null $pwdServer
     */
    public function setPwdServer($pwdServer)
    {
        $this->pwdServer = $pwdServer;
    }

    /**
     * @return null
     */
    public function getNameServer()
    {
        return $this->nameServer;
    }

    /**
     * @param null $nameServer
     */
    public function setNameServer($nameServer)
    {
        $this->nameServer = $nameServer;
    }

    /**
     * @return null
     */
    public function getDescServer()
    {
        return $this->descServer;
    }

    /**
     * @param null $descServer
     */
    public function setDescServer($descServer)
    {
        $this->descServer = $descServer;
    }

    /**
     * @return null
     */
    public function getIdOwner()
    {
        return $this->idOwner;
    }

    /**
     * @param null $idOwner
     */
    public function setIdOwner($idOwner)
    {
        $this->idOwner = $idOwner;
    }

    public static function getServerByName($name)
    {
        $res = selectRequest(array("name" => $name), array(PDO::FETCH_CLASS => 'Servers'), "*", "Servers", "nameServer = :name");
        if (isset($res[0]))
            return $res[0];
     else
         throw new Exception("Aucun serveur trouvé");
    }


    public static function getServerByIdOwner($idOwner)
    {
        $res = selectRequest(array("idOwner" => $idOwner), array(PDO::FETCH_CLASS => 'Servers'), "*", "Servers", "idOwner = :idOwner");
        if (isset($res[0]))
            return $res[0];
        else
            throw new Exception("Aucun serveur trouvé");
    }

    public static function getServers(){
        return selectRequest(array(),array(PDO::FETCH_CLASS => 'Servers'), "*","Servers","1");
    }
}