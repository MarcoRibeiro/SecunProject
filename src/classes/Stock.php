<?php

class Stock {

    var $id;
    var $equipamento;
    var $ocas;
    var $arosBrancos;
    var $arosPretos;
    var $vidrosBrancos;
    var $vidrosPretos;
    var $peliculaPolarizada;
    var $peliculaTemperada;

    function __construct($id, $equipamento, $ocas, $arosBrancos,$arosPretos,$vidrosBrancos,$vidrosPretos,$peliculaPolarizada,$peliculaTemperada)
    {
        $this->id = $id;
        $this->equipamento = $equipamento;
        $this->ocas = $ocas;
        $this->arosBrancos = $arosBrancos;
        $this->arosPretos = $arosPretos;
        $this->vidrosBrancos = $vidrosBrancos;
        $this->vidrosPretos = $vidrosPretos;
        $this->peliculaPolarizada = $peliculaPolarizada;
        $this->peliculaTemperada = $peliculaTemperada;

    }

}