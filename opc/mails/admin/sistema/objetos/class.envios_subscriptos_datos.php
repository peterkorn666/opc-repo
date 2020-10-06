<?php
	// **********************
	// CLASS DECLARATION
	// **********************

	class envios_subscriptos_datos extends objeto
	{ // class : begin


	// **********************
	// ATTRIBUTE DECLARATION
	// **********************


	
	// **********************
	// CONSTRUCTOR METHOD
	// **********************

	function envios_subscriptos_datos()
	{

		parent::objeto();

		$this->tabla="envios_subscriptos";
		$this->campoClave="IdEnvioSubscripto";
		$this->id=null;
		
		
$v=new Variable(2,$this->tabla,"IdEnvioSubscripto",1);
			
$v->clave=true;
			
			
$v->autonumerica=true;
			
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Guid",2);
$this->agregarVariable2($v);
$v=new Variable(2,$this->tabla,"IdEnvio",3);
$this->agregarVariable2($v);
$v=new Variable(2,$this->tabla,"IdSubscripto",4);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Email",5);
$this->agregarVariable2($v);
$v=new Variable(2,$this->tabla,"IdEstadoEnvio",6);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"FechaHora",7);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Comentarios",8);
$this->agregarVariable2($v);

	}

	
	// **********************
	// GETTER METHODS
	// **********************

	
	function getIdEnvioSubscripto()
	{
	return $this->darValorVariable("IdEnvioSubscripto");
	}
	
	function getGuid()
	{
	return $this->darValorVariable("Guid");
	}
	
	function getIdEnvio()
	{
	return $this->darValorVariable("IdEnvio");
	}
	
	function getIdSubscripto()
	{
	return $this->darValorVariable("IdSubscripto");
	}
	
	function getEmail()
	{
	return $this->darValorVariable("Email");
	}
	
	function getIdEstadoEnvio()
	{
	return $this->darValorVariable("IdEstadoEnvio");
	}
	
	function getFechaHora()
	{
	return $this->darValorVariable("FechaHora");
	}
	
	function getComentarios()
	{
	return $this->darValorVariable("Comentarios");
	}
	
	// **********************
	// SETTER METHODS
	// **********************

	
	function setIdEnvioSubscripto($val)
	{
	$this->asignarValorVariable("IdEnvioSubscripto","$val");
	}
	
	function setGuid($val)
	{
	$this->asignarValorVariable("Guid","$val");
	}
	
	function setIdEnvio($val)
	{
	$this->asignarValorVariable("IdEnvio","$val");
	}
	
	function setIdSubscripto($val)
	{
	$this->asignarValorVariable("IdSubscripto","$val");
	}
	
	function setEmail($val)
	{
	$this->asignarValorVariable("Email","$val");
	}
	
	function setIdEstadoEnvio($val)
	{
	$this->asignarValorVariable("IdEstadoEnvio","$val");
	}
	
	function setFechaHora($val)
	{
	$this->asignarValorVariable("FechaHora","$val");
	}
	
	function setComentarios($val)
	{
	$this->asignarValorVariable("Comentarios","$val");
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