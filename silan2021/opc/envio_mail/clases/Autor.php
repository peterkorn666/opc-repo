<?php

class Autor
{
    private $_bd;
    public function __construct()
    {
        $this->_bd = \DB::getInstance();
    }

    public function getAutoresConMail(){
        return $this->_bd->query("SELECT * FROM personas_trabajos_libres WHERE Mail IS NOT NULL AND Mail<>'' ORDER BY Apellidos, Nombre, Mail")->results();
    }

    public function getAutorByID($id_autor){
        return $this->_bd->get("personas_trabajos_libres", ["ID_Personas", "=", $id_autor])->first();
    }

    public function getTrabajoByAutorID($id_autor){
        return $this->_bd->query("SELECT t.id_trabajo, t.numero_tl, t.titulo_tl, t.archivo_tl FROM trabajos_libres t JOIN trabajos_libres_participantes tp ON t.id_trabajo=tp.ID_trabajos_libres JOIN personas_trabajos_libres p ON tp.ID_participante=p.ID_Personas WHERE p.ID_Personas = ?", [$id_autor])->first();
    }
}