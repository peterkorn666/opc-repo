<?php

class Auxiliar
{
    private $_bd;
    public function __construct()
    {
        $this->_bd = \DB::getInstance();
    }

    public function getPaisByID($id_pais){
        return $this->_bd->get("paises", ["ID_Paises", "=", $id_pais])->first();
    }
    public function getInstitucionByID($id_institucion){
        return $this->_bd->get("instituciones", ["ID_Instituciones", "=", $id_institucion])->first();
    }
    public function getTipoActividad($id_tipo_actividad){
        return $this->_bd->get("tipo_de_actividad", ["id_tipo_actividad", "=", $id_tipo_actividad])->first();
    }
    public function getCasilleroByID($id_crono){
        return $this->_bd->query("SELECT c.start_date, c.end_date, c.tipo_actividad, c.titulo_actividad, s.name FROM cronograma c JOIN salas s ON c.section_id=s.salaid WHERE c.id_crono = ? ORDER BY c.start_date, s.orden", [$id_crono])->first();
    }

    public function getRolesConferencistas(){
        return $this->_bd->query("SELECT * FROM calidades_conferencistas ORDER BY calidad")->results();
    }
    public function getPaises(){
        return $this->_bd->query("SELECT * FROM paises ORDER BY Pais")->results();
    }
}