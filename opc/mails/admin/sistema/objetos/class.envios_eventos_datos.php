<?php
	// **********************
	// CLASS DECLARATION
	// **********************

	class envios_eventos_datos extends objeto
	{ // class : begin


	// **********************
	// ATTRIBUTE DECLARATION
	// **********************


	
	// **********************
	// CONSTRUCTOR METHOD
	// **********************

	function envios_eventos_datos()
	{

		parent::objeto();

		$this->tabla="envios_eventos";
		$this->campoClave="IdEnvioEvento";
		$this->id=null;
		
		
$v=new Variable(2,$this->tabla,"IdEnvioEvento",1);
			
$v->clave=true;
			
			
$v->autonumerica=true;
			
$this->agregarVariable2($v);
$v=new Variable(2,$this->tabla,"IdEnvioSubscripto",2);
$this->agregarVariable2($v);
$v=new Variable(2,$this->tabla,"IdEvento",3);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"FechaHora",4);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"IP",5);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Browser",6);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Referer",7);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Detalles",8);
$this->agregarVariable2($v);

	}

	
	// **********************
	// GETTER METHODS
	// **********************

	
	function getIdEnvioEvento()
	{
	return $this->darValorVariable("IdEnvioEvento");
	}
	
	function getIdEnvioSubscripto()
	{
	return $this->darValorVariable("IdEnvioSubscripto");
	}
	
	function getIdEvento()
	{
	return $this->darValorVariable("IdEvento");
	}
	
	function getFechaHora()
	{
	return $this->darValorVariable("FechaHora");
	}
	
	function getIP()
	{
	return $this->darValorVariable("IP");
	}
	
	function getBrowser()
	{
	return $this->darValorVariable("Browser");
	}
	
	function getReferer()
	{
	return $this->darValorVariable("Referer");
	}
	
	function getDetalles()
	{
	return $this->darValorVariable("Detalles");
	}
	
	// **********************
	// SETTER METHODS
	// **********************

	
	function setIdEnvioEvento($val)
	{
	$this->asignarValorVariable("IdEnvioEvento","$val");
	}
	
	function setIdEnvioSubscripto($val)
	{
	$this->asignarValorVariable("IdEnvioSubscripto","$val");
	}
	
	function setIdEvento($val)
	{
	$this->asignarValorVariable("IdEvento","$val");
	}
	
	function setFechaHora($val)
	{
	$this->asignarValorVariable("FechaHora","$val");
	}
	
	function setIP($val)
	{
	$this->asignarValorVariable("IP","$val");
	}
	
	function setBrowser($val)
	{
	$this->asignarValorVariable("Browser","$val");
	}
	
	function setReferer($val)
	{
	$this->asignarValorVariable("Referer","$val");
	}
	
	function setDetalles($val)
	{
	$this->asignarValorVariable("Detalles","$val");
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