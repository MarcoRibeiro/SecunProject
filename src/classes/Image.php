<?php

class Client {

    var $image;
    var $id;
    var $evtID;

    function __construct($id, $image, $evtID)
    {
        $this->evtID = $evtID;
        $this->id = $id;
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $name
     */
    public function setImage($image)
    {
        $this->image = $image;
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
    public function getEvtID()
    {
        return $this->evtID;
    }

    /**
     * @param mixed $contact
     */
    public function setEvtID($evtID)
    {
        $this->evtID = $evtID;
    }

}