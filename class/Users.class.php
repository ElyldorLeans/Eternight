<?php

require_once(projectPath.'inc/autoload.inc.php');
require_once (projectPath.'inc/requestUtils.inc.php');

class Users
{
    private $idUser = null;
    private $login = null;
    private $pwdUser = null;
    private $email = null;
    private $isManual = null;

    public function inServer(){
        $res1 = selectRequest(array("id" => $this->idUser),array(PDO::FETCH_NUM),"idPlayer","Players","idPlayer = :id");
        if(isset($res1[0]) && ($res1[0][0] != null )) return true;
        else return false;
    }

    public function ownServer(){
        $res1 = selectRequest(array("id" => $this->idUser),array(PDO::FETCH_NUM),"idOwner","Servers","idOwner = :id");
        if(isset($res1[0]) && ($res1[0][0] != null )) return true;
        else return false;
    }

    /**
     * @return null
     */
    public function getisManual()
    {
        return $this->isManual;
    }

    /**
     * @param null $isManual
     */
    public function setIsManual($isManual)
    {
        $this->isManual = $isManual;
    }


    public static function createUser($login,$pwd){
        insertRequest(array("login" => $login, "pwd" =>$pwd),"Users(login,pwdUser)","(:login,:pwd)");
    }


    public static function getUserById($id){
        $res = selectRequest(array("id" => $id),array(PDO::FETCH_CLASS => 'Users'), "*","Users","idUser = :id");
        if(isset($res[0])){
            return $res[0];
        } else {
            throw new Exception("Aucun utilisateur trouvé");
        }
    }

    public static function getUserConnect($login, $pwd){
        $res = selectRequest(array("login" => $login, "pwd" => $pwd),array(PDO::FETCH_CLASS => 'Users'),"*","Users","login = :login AND pwdUser = :pwd");
        if(isset($res[0])){
            return $res[0];
        } else {
            throw new Exception("Aucun utilisateur trouvé");
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
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param null $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return null
     */
    public function getPwdUser()
    {
        return $this->pwdUser;
    }

    /**
     * @param null $pwdUser
     */
    public function setPwdUser($pwdUser)
    {
        $this->pwdUser = $pwdUser;
    }

    /**
     * @return null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param null $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Démarre la session
     *
     * @throws Exception Si la session n'a pas pu être démarrée
     */
    private static function startSession() {
        if(session_status() == PHP_SESSION_NONE) {
            if(!headers_sent())
                session_start();
            else
                throw new Exception("Erreur de session");
        }
    }
    /**
     * Indique si l'utilisateur est connecté
     *
     * @return bool true s'il est connecté, false sinon
     */
    public static function isConnected() {
        self::startSession();
        if(isset($_SESSION['User']) && !empty($_SESSION['User']) && $_SESSION['User'] != null){
            return true;
        }
        else return false;
    }
    /**
     * Stock l'instance courante dans une variable de session
     */
    public function saveIntoSession() {
        self::startSession();
        $_SESSION['User'] = $this;
    }
    /**
     * Déconnecte le membre
     */
    public static function disconnect() {
        self::startSession();
        $_SESSION['User'] = null;
    }
    /**
     * Retourne l'instance du membre sauvegardée dans un variable de session
     * @return User|null L'instance du membre
     */
    public static function getInstance() {
        self::startSession();
        if(self::isConnected())
            return $_SESSION['User'];
        else
            return null;
    }
}