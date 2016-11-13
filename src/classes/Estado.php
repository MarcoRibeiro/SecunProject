<?php

class Estado {

    var $id;
    var $descricao;
    var $class;

    function __construct($id, $descricao, $class)
    {
        $this->id = $id;
        $this->descricao = $this->getDescricaoById($id);
        $this->class = $class;
    }

   /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }
    /**
     * @param mixed $name
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
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
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param mixed $contact
     */
    public function setContact($class)
    {
        $this->class = $class;
    }

    public function getDescricaoById($id){
        $descricao = null;
        switch ($id) {
            case 2:
                $descricao = 'Em Reparação';
                break;
            case 3:
                $descricao = 'Sem Reparação';
                break;
            case 4:
                $descricao = 'Reparado';
                break;
            case 5:
                $descricao = 'Entregue';
                break;
            case 6:
                $descricao = 'Entregue s/Reparação';
                break;
            default:
                $descricao = 'Em Analise';
                break;
        }
        return $descricao;
    }

}