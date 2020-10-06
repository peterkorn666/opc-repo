<?php
	// **********************
	// CLASS DECLARATION
	// **********************

	class envios_estados_datos extends objeto
	{ // class : begin


	// **********************
	// ATTRIBUTE DECLARATION
	// **********************


	
	// **********************
	// CONSTRUCTOR METHOD
	// **********************

	function envios_estados_datos()
	{

		parent::objeto();

		$this->tabla="envios_estados";
		$this->campoClave="IdEstadoEnvio";
		$this->id=null;
		
		
$v=new Variable(2,$this->tabla,"IdEstadoEnvio",1);
			
$v->clave=true;
			
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Descripcion",2);
$this->agregarVariable2($v);

	}

	
	// **********************
	// GETTER METHODS
	// **********************

	
	function getIdEstadoEnvio()
	{
	return $this->darValorVariable("IdEstadoEnvio");
	}
	
	function getDescripcion()
	{
	return $this->darValorVariable("Descripcion");
	}
	
	// **********************
	// SETTER METHODS
	// **********************

	
	function setIdEstadoEnvio($val)
	{
	$this->asignarValorVariable("IdEstadoEnvio","$val");
	}
	
	function setDescripcion($val)
	{
	$this->asignarValorVariable("Descripcion","$val");
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