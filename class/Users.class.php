<?php

require_once(projectPath.'inc/autoload.inc.php');
require_once (projectPath.'inc/requestUtils.inc.php');

class Users
{
    private $idUser = null;
    private $login = null;
    private $pwdUser = null;
    private $email = null;

    public static function getUserById($id){
        $res = selectRequest(array("id" => $id),array(PDO::FETCH_CLASS => 'Users'), "*","Users","idUser = :id");
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
}