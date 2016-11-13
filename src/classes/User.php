<?php

class User {

    var $name;
    var $id;
    var $userName;
    var $type;
    var $password;

    function __construct($id, $name, $userName, $password, $type)
    {
        $this->name = $name;
        $this->id = $id;
        $this->userName = $userName;
        $this->password = $password;
        $this->type = $type;
    }


    public  function printUser(){
        echo 'Nome: '.$this->name . '</br>';
        echo 'Id: '.$this->id . '</br>';
        echo 'userName: '.$this->userName . '</br>';
        echo 'password: '.$this->password . '</br>';
        echo 'tipo: '.$this->type . '</br>';
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }


}