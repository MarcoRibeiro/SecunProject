<?php

class Client {

    var $name;
    var $id;
    var $contact;
    var $email;
    var $local;

    function __construct($id, $name, $contact, $email, $local)
    {
        $this->name = $name;
        $this->id = $id;
        $this->contact = $contact;
        $this->email = $email;
        $this->local = $local;
    }


    public  function printClient(){
        echo 'Nome: '.$this->name . '</br>';
        echo 'Id: '.$this->id . '</br>';
        echo 'Contacto: '.$this->contact . '</br>';
        echo 'Email: '.$this->email . '</br>';
        echo 'Morada :'.$this->local . '</br>';
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
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param mixed $contact
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getLocal()
    {
        return $this->local;
    }

    /**
     * @param mixed $local
     */
    public function setLocal($local)
    {
        $this->local = $local;
    }



}