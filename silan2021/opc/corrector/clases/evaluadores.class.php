<?php
class Evaluadores{
	private $_bd;
    public function __construct()
    {
        $this->_bd = \DB::getInstance();
		
    }

    public function crearEvaluador($campos){
        return $this->_bd->insert("evaluadores", $campos);
    }

    public function editarEvaluador($id_evaluador, $campos){
        return $this->_bd->update("evaluadores", "id = ".$id_evaluador, $campos);
    }

    public function getEvaluadores(){
        return $this->_bd->query("SELECT * FROM evaluadores WHERE nivel = 2 ORDER BY id")->results();
    }

	public function getEvaluador($usuario_evaluador, $password_evaluador){
		return $this->_bd->query("SELECT * FROM evaluadores WHERE mail = ? AND clave = ?", [$usuario_evaluador, $password_evaluador])->first();
	}

    public function getEvaluadorByID($id_evaluador){
        return $this->_bd->query("SELECT * FROM evaluadores WHERE id = ?", [$id_evaluador])->first();
    }
	
	public function getTrabajosEvaluador($id_evaluador){
        return $this->_bd->query("SELECT * FROM evaluadores WHERE id = ?", [$id_evaluador])->first();
    }
}