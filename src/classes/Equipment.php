<?php

class equipment {

    var $model;
    var $id;
    var $emei;
    var $obj;
    var $clienteID;

    function __construct($id, $model, $emei, $obj,$clienteID)
    {
        $this->model = $model;
        $this->id = $id;
        $this->emei = $emei;
        $this->obj = $obj;
        $this->clienteID = $clienteID;
    }


    public  function printEquipment(){
        echo 'Modelo: '.$this->model . '</br>';
        echo 'Id: '.$this->id . '</br>';
        echo 'Emei: '.$this->emei . '</br>';
        echo 'Obj: '.$this->obj . '</br>';
    }

/**
     * @return mixed
     */
    public function getClienteID()
    {
        return $this->clienteID;
    }

    /**
     * @param mixed $id
     */
    public function setClienteID($clienteID)
    {
        $this->clienteID = $clienteID;
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
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getEmei()
    {
        return $this->emei;
    }

    /**
     * @param mixed $emei
     */
    public function setEmei($emei)
    {
        $this->emei = $emei;
    }

    /**
     * @return mixed
     */
    public function getObj()
    {
        return $this->obj;
    }

    /**
     * @param mixed $obj
     */
    public function setObj($obj)
    {
        $this->obj = $obj;
    }



}