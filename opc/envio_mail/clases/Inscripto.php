<?php

class Inscripto
{
    private $_bd;
    public function __construct()
    {
        $this->_bd = \DB::getInstance();
    }

    public function getCostosInscripcion(){
        return $this->_bd->query("SELECT id, precio, nombre_es FROM inscripcion_costos WHERE deleted_at IS NULL ORDER BY id")->results();
    }

    public function getInscriptosConMail(){
        return $this->_bd->query("SELECT * FROM inscriptos WHERE email IS NOT NULL AND email<>'' ORDER BY apellido, nombre, email")->results();
    }

    public function getInscriptoByID($id_inscripto){
        return $this->_bd->get("inscriptos", ["id", "=", $id_inscripto])->first();
    }

    public function formatedPrecio($precio){
        return "USD ".$precio;
    }
}