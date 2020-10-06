<?php
	// **********************
	// CLASS DECLARATION
	// **********************

	class iniciales_datos extends objeto
	{ // class : begin


	// **********************
	// ATTRIBUTE DECLARATION
	// **********************


	
	// **********************
	// CONSTRUCTOR METHOD
	// **********************

	function iniciales_datos()
	{

		parent::objeto();

		$this->tabla="iniciales";
		$this->campoClave="Inicial";
		$this->id=null;
		
		
$v=new Variable(1,$this->tabla,"Inicial",1);
			
$v->clave=true;
			
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Mostrar",2);
$this->agregarVariable2($v);

	}

	
	// **********************
	// GETTER METHODS
	// **********************

	
	function getInicial()
	{
	return $this->darValorVariable("Inicial");
	}
	
	function getMostrar()
	{
	return $this->darValorVariable("Mostrar");
	}
	
	// **********************
	// SETTER METHODS
	// **********************

	
	function setInicial($val)
	{
	$this->asignarValorVariable("Inicial","$val");
	}
	
	function setMostrar($val)
	{
	$this->asignarValorVariable("Mostrar","$val");
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