<?php
	// **********************
	// CLASS DECLARATION
	// **********************

	class grupos_datos extends objeto
	{ // class : begin


	// **********************
	// ATTRIBUTE DECLARATION
	// **********************


	
	// **********************
	// CONSTRUCTOR METHOD
	// **********************

	function grupos_datos()
	{

		parent::objeto();

		$this->tabla="grupos";
		$this->campoClave="IdGrupo";
		$this->id=null;
		
		
$v=new Variable(2,$this->tabla,"IdGrupo",1);
			
$v->clave=true;
			
			
$v->autonumerica=true;
			
$this->agregarVariable2($v);

$v=new Variable(1,$this->tabla,"Grupo",2);
$this->agregarVariable2($v);


	}

	
	// **********************
	// GETTER METHODS
	// **********************

	
	function getIdGrupo()
	{
	return $this->darValorVariable("IdGrupo");
	}
	
	function getGrupo()
	{
	return $this->darValorVariable("Grupo");
	}

	
	// **********************
	// SETTER METHODS
	// **********************

	
	function setIdGrupo($val)
	{
	$this->asignarValorVariable("IdGrupo","$val");
	}
	
	function setGrupo($val)
	{
	$this->asignarValorVariable("Grupo","$val");
	}

	
	// **********************
	// SELECT METHOD / LOAD
	// **********************

	function select($id)
	{
	return parent::select($id);
	}

	function buscarDatos($camposSeleccionar,$condiciones,$orden="",$primero="",$ultimo="") {
	return parent::buscarDatos($camposSeleccionar,$condiciones,$orden,$primero,$ultimo);
	}


	function selectAll()
	{
	return parent::selectAll();
	}

	// **********************
	// DELETE
	// **********************

	function delete($id)
	{
	return parent::delete($id);
	}

	// **********************
	// INSERT
	// **********************

	function insert()
	{
	return parent::insert();
	}

	// **********************
	// UPDATE
	// **********************

	function update($id)
	{
	return parent::update($id);
	}

	} // class : end

	?>