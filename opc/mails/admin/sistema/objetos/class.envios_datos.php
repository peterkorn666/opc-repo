<?php
	// **********************
	// CLASS DECLARATION
	// **********************

	class envios_datos extends objeto
	{ // class : begin


	// **********************
	// ATTRIBUTE DECLARATION
	// **********************


	
	// **********************
	// CONSTRUCTOR METHOD
	// **********************

	function envios_datos()
	{

		parent::objeto();

		$this->tabla="envios";
		$this->campoClave="IdEnvio";
		$this->id=null;
		
		
$v=new Variable(2,$this->tabla,"IdEnvio",1);
			
$v->clave=true;
			
			
$v->autonumerica=true;
			
$this->agregarVariable2($v);
$v=new Variable(2,$this->tabla,"IdMail",2);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Envio",3);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Descripcion",4);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"TablaDatosExtras",5);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"CondicionDatosExtras",6);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"FechaCreacion",7);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"FechaModificacion",8);
$this->agregarVariable2($v);

	}

	
	// **********************
	// GETTER METHODS
	// **********************

	
	function getIdEnvio()
	{
	return $this->darValorVariable("IdEnvio");
	}
	
	function getIdMail()
	{
	return $this->darValorVariable("IdMail");
	}
	
	function getEnvio()
	{
	return $this->darValorVariable("Envio");
	}
	
	function getDescripcion()
	{
	return $this->darValorVariable("Descripcion");
	}
	
	function getTablaDatosExtras()
	{
	return $this->darValorVariable("TablaDatosExtras");
	}
	
	function getCondicionDatosExtras()
	{
	return $this->darValorVariable("CondicionDatosExtras");
	}
	
	function getFechaCreacion()
	{
	return $this->darValorVariable("FechaCreacion");
	}
	
	function getFechaModificacion()
	{
	return $this->darValorVariable("FechaModificacion");
	}
	
	// **********************
	// SETTER METHODS
	// **********************

	
	function setIdEnvio($val)
	{
	$this->asignarValorVariable("IdEnvio","$val");
	}
	
	function setIdMail($val)
	{
	$this->asignarValorVariable("IdMail","$val");
	}
	
	function setEnvio($val)
	{
	$this->asignarValorVariable("Envio","$val");
	}
	
	function setDescripcion($val)
	{
	$this->asignarValorVariable("Descripcion","$val");
	}
	
	function setTablaDatosExtras($val)
	{
	$this->asignarValorVariable("TablaDatosExtras","$val");
	}
	
	function setCondicionDatosExtras($val)
	{
	$this->asignarValorVariable("CondicionDatosExtras","$val");
	}
	
	function setFechaCreacion($val)
	{
	$this->asignarValorVariable("FechaCreacion","$val");
	}
	
	function setFechaModificacion($val)
	{
	$this->asignarValorVariable("FechaModificacion","$val");
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