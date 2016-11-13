<?php

class Fault {

    var $id;
    var $equipmentID;
    var $statusID;
    var $userID;
    var $dateIn;
    var $dateOut;
    var $prediction;
    var $values;
    var $obj;
    var $clientID;

    function __construct($id, $equipmentID, $statusID, $userID, $dateIn, $dateOut, $values,$obj,$clientID, $prediction){
        $this->id = $id;
        $this->equipmentID = $equipmentID;
        $this->statusID = $statusID;
        $this->userID = $userID;
        $this->dateIn = $dateIn;
        $this->dateOut = $dateOut;
        $this->values = $values;
        $this->obj = $obj;
        $this->clientID = $clientID;
        $this->prediction = $prediction;
    }


/**
     * @return mixed
     */
    public function getClientID()
    {
        return $this->clientID;
    }

    /**
     * @param mixed $id
     */
    public function setClientID($clientID)
    {
        $this->clientID = $clientID;
    }

    /**
     * @return mixed
     */
    public function getPrediction()
    {
        return $this->prediction;
    }

    /**
     * @param mixed $id
     */
    public function setPrediction($prediction)
    {
        $this->prediction = $prediction;
    }

    /**
     * @return mixed
     */
    public function getObj()
    {
        return $this->obj;
    }

    /**
     * @param mixed $id
     */
    public function setObj($obj)
    {
        $this->obj = $obj;
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
    public function getEquipmentID()
    {
        return $this->equipmentID;
    }

    /**
     * @param mixed $equipmentID
     */
    public function setEquipmentID($equipmentID)
    {
        $this->equipmentID = $equipmentID;
    }

    /**
     * @return mixed
     */
    public function getStatusID()
    {
        return $this->statusID;
    }

    /**
     * @param mixed $statusID
     */
    public function setStatusID($statusID)
    {
        $this->statusID = $statusID;
    }

    /**
     * @return mixed
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * @param mixed $userID
     */
    public function setUserID($userID)
    {
        $this->userID = $userID;
    }

    /**
     * @return mixed
     */
    public function getDateIn()
    {
        return $this->dateIn;
    }

    /**
     * @param mixed $dateIn
     */
    public function setDateIn($dateIn)
    {
        $this->dateIn = $dateIn;
    }

    /**
     * @return mixed
     */
    public function getDateOut()
    {
        return $this->dateOut;
    }

    /**
     * @param mixed $dateOut
     */
    public function setDateOut($dateOut)
    {
        $this->dateOut = $dateOut;
    }

    /**
     * @return mixed
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param mixed $values
     */
    public function setValues($values)
    {
        $this->values = $values;
    }

    public function toArray(){
        $result = array();

        return result;
    }





}