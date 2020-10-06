<?php

class Cartas
{
    private $_bd;
    public function __construct()
    {
        $this->_bd = \DB::getInstance();

    }

    public function cargarUna($idCarta){
        return $this->_bd->get("cartas", ["idCarta", "=", $idCarta])->first();
    }

}