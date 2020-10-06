<?php

class Trabajos
{
    private $_bd;
    public function __construct()
    {
        $this->_bd = \DB::getInstance();
    }

    public function getTrabajosSinEvaluacion(){
        return $this->_bd->query("SELECT t.area_tl, t.numero_tl, at.Area_es FROM trabajos_libres t LEFT JOIN evaluaciones ev ON t.numero_tl=ev.numero_tl LEFT JOIN areas_trabjos_libres at ON t.area_tl = at.id WHERE ev.idEvaluacion IS NULL ORDER BY t.tipo_tl, at.orden")->results();
    }

    public function getTrabajosNoAsignadosAlEvaluador($id_evaluador){
        return $this->_bd->query("SELECT t.numero_tl, t.area_tl FROM trabajos_libres t LEFT JOIN evaluaciones ev ON t.numero_tl=ev.numero_tl WHERE (ev.idEvaluador IS NULL OR ev.idEvaluador <> ?) ORDER BY t.numero_tl", [$id_evaluador])->results();
    }

    public function getTrabajoByNumeroTL($numero_tl){
        return $this->_bd->get("trabajos_libres", ["numero_tl", "=", $numero_tl])->first();
    }

    public function getModalidadByID($id_modalidad){
        return $this->_bd->get("trabajos_libres_modalidades", ["id", "=", $id_modalidad])->first();
    }

    public function getAreaTLByID($id_area_tl){
        return $this->_bd->get("areas_trabjos_libres", ["id", "=", $id_area_tl])->first();
    }

    public function getLineaTransversalByID($id_linea_transversal){
        return $this->_bd->get("trabajos_libres_lineas_transversales", ["id", "=", $id_linea_transversal])->first();
    }

    public function getModalidesTL(){
        return $this->_bd->query("SELECT * FROM trabajos_libres_modalidades ORDER BY modalidad_es")->results();
    }

    public function getAreasTL(){
        return $this->_bd->query("SELECT * FROM areas_trabjos_libres ORDER BY Area_es")->results();
    }

    public function getLineasTransversalesTL(){
        return $this->_bd->query("SELECT * FROM trabajos_libres_lineas_transversales ORDER BY linea_transversal_es")->results();
    }

    public function updateEstadoTL($id_trabajo, $estado_nuevo){
        $array_estado = array(
            "estado" => $estado_nuevo
        );
        return $this->_bd->update("trabajos_libres", "id_trabajo"."=".$id_trabajo, $array_estado);
    }
}