<?php
	// **********************
	// CLASS DECLARATION
	// **********************

	class subscriptos_grupos_datos extends objeto
	{ // class : begin


	// **********************
	// ATTRIBUTE DECLARATION
	// **********************


	
	// **********************
	// CONSTRUCTOR METHOD
	// **********************

	function subscriptos_grupos_datos()
	{

		parent::objeto();

		$this->tabla="subscriptos_datos";
		$this->campoClave=array("IdSubscripto","IdGrupo");
		$this->id=null;
		
		
$v=new Variable(2,$this->tabla,"IdSubscripto",1);
$v->clave=true;
$this->agregarVariable2($v);
$v=new Variable(2,$this->tabla,"IdGrupo",1);
$v->clave=true;
$this->agregarVariable2($v);

	}

	
	// **********************
	// GETTER METHODS
	// **********************

	
	function getIdSubscripto()
	{
	return $this->darValorVariable("IdSubscripto");
	}
	
	function getIdGrupo()
	{
	return $this->darValorVariable("IdGrupo");
	}

	
	// **********************
	// SETTER METHODS
	// **********************

	function setIdSubscripto($val)
	{
	$this->asignarValorVariable("IdSubscripto","$val");
	}	
	
	function setIdGrupo($val)
	{
	$this->asignarValorVariable("IdGrupo","$val");
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