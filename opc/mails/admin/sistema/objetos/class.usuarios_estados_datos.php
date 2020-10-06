<?php
	// **********************
	// CLASS DECLARATION
	// **********************

	class usuarios_estados_datos extends objeto
	{ // class : begin


	// **********************
	// ATTRIBUTE DECLARATION
	// **********************


	
	// **********************
	// CONSTRUCTOR METHOD
	// **********************

	function usuarios_estados_datos()
	{

		parent::objeto();

		$this->tabla="usuarios_estados";
		$this->campoClave="Id";
		$this->id=null;
		
		
$v=new Variable(2,$this->tabla,"Id",1);
			
$v->clave=true;
			
			
$v->autonumerica=true;
			
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Estado",2);
$this->agregarVariable2($v);

	}

	
	// **********************
	// GETTER METHODS
	// **********************

	
	function getId()
	{
	return $this->darValorVariable("Id");
	}
	
	function getEstado()
	{
	return $this->darValorVariable("Estado");
	}
	
	// **********************
	// SETTER METHODS
	// **********************

	
	function setId($val)
	{
	$this->asignarValorVariable("Id","$val");
	}
	
	function setEstado($val)
	{
	$this->asignarValorVariable("Estado","$val");
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