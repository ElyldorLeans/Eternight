<?php

class Servers {
    private $idServer = null ;
    private $pwdServer = null ;
    private $nameServer = null ;
    private $descServer = null ;
    private $idOwner = null ;

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

}