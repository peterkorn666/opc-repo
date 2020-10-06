<?php

class Evaluador
{
    private $_bd;
    public function __construct()
    {
        $this->_bd = \DB::getInstance();
    }

    public function getEvaluadoresMail(){
        return $this->_bd->query("SELECT * FROM evaluadores WHERE mail IS NOT NULL AND mail<>'' AND nivel = 2 ORDER BY id")->results();
    }
    public function getEvaluadoresMailByIDS($ids_evaluadores){
        $txt_evaluador = "";
        if(count($ids_evaluadores) > 0){
            foreach($ids_evaluadores as $id_evaluador){
                $txt_evaluador .= $id_evaluador.", ";
            }
            $txt_evaluador = substr($txt_evaluador, 0, -2);
            return $this->_bd->query("SELECT * FROM evaluadores WHERE mail IS NOT NULL AND mail<>'' AND nivel = 2 AND id IN (".$txt_evaluador.") ORDER BY id")->results();
        }
    }

    public function getEvaluadorByID($id_evaluador){
        return $this->_bd->get("evaluadores", ["id", "=", $id_evaluador])->first();
    }

    public function getEvaluacionesByEvaluador($id_evaluador){
        return $this->_bd->get("evaluaciones", ["idEvaluador", "=", $id_evaluador])->results();
    }
}