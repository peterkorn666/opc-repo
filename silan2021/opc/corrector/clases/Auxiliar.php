<?php

class Auxiliar
{
    private $_bd;
    public function __construct()
    {
        $this->_bd = \DB::getInstance();
    }

    public function getConfig(){
        return $this->_bd->get("config", ["id", "=", 1])->first();
    }
}