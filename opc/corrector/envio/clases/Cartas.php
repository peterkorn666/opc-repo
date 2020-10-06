<?php

class Cartas
{
    private $_bd;
    public function __construct()
    {
        $this->_bd = \DB::getInstance();

    }

    public function getConfig(){
        return $this->_bd->get("config", ["id", "=", 1])->first();
    }

    public function cargarUna($idCarta){
        return $this->_bd->get("cartas", ["idCarta", "=", $idCarta])->first();
    }

    /*
     * public function getEvaluadores(){
        return $this->_bd->query("SELECT * FROM evaluadores WHERE nivel = 2 ORDER BY id")->results();
    }
     */
}