<?php

class Evaluaciones
{
    private $_bd;
    public function __construct()
    {
        $this->_bd = \DB::getInstance();
    }

    public function getConfig(){
        return $this->_bd->get("config", ["id", "=", 1])->first();
    }

    public function crearEvaluacion($campos){
        return $this->_bd->insert("evaluaciones", $campos);
    }

    public function eliminarEvaluacion($numero_tl, $id_evaluador){
        $evaluacion = $this->getEvaluacion($numero_tl, $id_evaluador);
        if (count($evaluacion) > 0){

            return $this->_bd->delete("evaluaciones", ['idEvaluacion', '=', $evaluacion['idEvaluacion']]);
        } else {

            return false;
        }
    }

    public function getEvaluaciones(){
        return $this->_bd->query("SELECT * FROM evaluaciones ev JOIN trabajos_libres t ON ev.numero_tl=t.numero_tl JOIN evaluadores e ON ev.idEvaluador=e.id ORDER BY ev.idEvaluador, t.tipo_tl, t.area_tl, t.numero_tl")->results();
    }

    public function getEvaluacionesByEvaluador($id_evaluador){
        return $this->_bd->query("SELECT ev.numero_tl, ev.fecha, ev.fecha_asignado, ev.estadoEvaluacion, ev.evaluar_trabajo, ev.comentarios, tr.titulo_tl, tr.area_tl FROM evaluaciones as ev LEFT JOIN trabajos_libres as tr ON ev.numero_tl=tr.numero_tl WHERE ev.idEvaluador = ? ORDER BY tr.tipo_tl, tr.area_tl", [$id_evaluador])->results();
    }

    public function getEvaluacion($numero_tl, $idEvaluador){
        return $this->_bd->query("SELECT * FROM evaluaciones WHERE numero_tl = ? AND idEvaluador = ?", [$numero_tl, $idEvaluador])->first();
    }

    public function actualizarEvaluacion($id_evaluacion, $datos){
        return $this->_bd->update("evaluaciones", "idEvaluacion"."=".$id_evaluacion, $datos);
    }
}