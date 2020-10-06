<?php
	// **********************
	// CLASS DECLARATION
	// **********************

	class subscriptos_datos extends objeto
	{ // class : begin


	// **********************
	// ATTRIBUTE DECLARATION
	// **********************


	
	// **********************
	// CONSTRUCTOR METHOD
	// **********************

	function subscriptos_datos()
	{

		parent::objeto();

		$this->tabla="subscriptos";
		$this->campoClave="IdSubscripto";
		$this->id=null;
		
		
$v=new Variable(2,$this->tabla,"IdSubscripto",1);
			
$v->clave=true;
			
			
$v->autonumerica=true;
			
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Email",2);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Password",3);
$this->agregarVariable2($v);
$v=new Variable(2,$this->tabla,"Activo",4);
$this->agregarVariable2($v);
$v=new Variable(2,$this->tabla,"IdEstadoSuscripto",5);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"FechaHoraSolicitudAlta",6);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"IPSolicitudAlta",7);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"ClaveConfirmacionAlta",8);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"FechaHoraConfirmacionAlta",9);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"IPConfirmacionAlta",10);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"FechaHoraSolicitudBaja",11);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"IPSolicitudBaja",12);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"FechaHoraConfirmacionBaja",13);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"IPConfirmacionBaja",14);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Comentarios",15);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"EnviosPendientes",16);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"EnviosHechos",17);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"EnviosRebotados",18);
$this->agregarVariable2($v);
	}

	
	// **********************
	// GETTER METHODS
	// **********************

	
	function getIdSubscripto()
	{
	return $this->darValorVariable("IdSubscripto");
	}
	
	function getEmail()
	{
	return $this->darValorVariable("Email");
	}
	
	function getPassword()
	{
	return $this->darValorVariable("Password");
	}
	
	function getActivo()
	{
	return $this->darValorVariable("Activo");
	}
	
	function getIdEstadoSuscripto()
	{
	return $this->darValorVariable("IdEstadoSuscripto");
	}
	
	function getFechaHoraSolicitudAlta()
	{
	return $this->darValorVariable("FechaHoraSolicitudAlta");
	}
	
	function getIPSolicitudAlta()
	{
	return $this->darValorVariable("IPSolicitudAlta");
	}
	
	function getClaveConfirmacionAlta()
	{
	return $this->darValorVariable("ClaveConfirmacionAlta");
	}
	
	function getFechaHoraConfirmacionAlta()
	{
	return $this->darValorVariable("FechaHoraConfirmacionAlta");
	}
	
	function getIPConfirmacionAlta()
	{
	return $this->darValorVariable("IPConfirmacionAlta");
	}
	
	function getFechaHoraSolicitudBaja()
	{
	return $this->darValorVariable("FechaHoraSolicitudBaja");
	}
	
	function getIPSolicitudBaja()
	{
	return $this->darValorVariable("IPSolicitudBaja");
	}
	
	function getFechaHoraConfirmacionBaja()
	{
	return $this->darValorVariable("FechaHoraConfirmacionBaja");
	}
	
	function getIPConfirmacionBaja()
	{
	return $this->darValorVariable("IPConfirmacionBaja");
	}
	
	function getComentarios()
	{
	return $this->darValorVariable("Comentarios");
	}
	
	function getEnviosPendientes()
	{
	return $this->darValorVariable("EnviosPendientes");
	}
	
	function getEnviosHechos()
	{
	return $this->darValorVariable("EnviosHechos");
	}

	function getEnviosRebotados()
	{
	return $this->darValorVariable("EnviosRebotados");
	}
	
	// **********************
	// SETTER METHODS
	// **********************

	
	function setIdSubscripto($val)
	{
	$this->asignarValorVariable("IdSubscripto","$val");
	}
	
	function setEmail($val)
	{
	$this->asignarValorVariable("Email","$val");
	}
	
	function setPassword($val)
	{
	$this->asignarValorVariable("Password","$val");
	}
	
	function setActivo($val)
	{
	$this->asignarValorVariable("Activo","$val");
	}
	
	function setIdEstadoSuscripto($val)
	{
	$this->asignarValorVariable("IdEstadoSuscripto","$val");
	}
	
	function setFechaHoraSolicitudAlta($val)
	{
	$this->asignarValorVariable("FechaHoraSolicitudAlta","$val");
	}
	
	function setIPSolicitudAlta($val)
	{
	$this->asignarValorVariable("IPSolicitudAlta","$val");
	}
	
	function setClaveConfirmacionAlta($val)
	{
	$this->asignarValorVariable("ClaveConfirmacionAlta","$val");
	}
	
	function setFechaHoraConfirmacionAlta($val)
	{
	$this->asignarValorVariable("FechaHoraConfirmacionAlta","$val");
	}
	
	function setIPConfirmacionAlta($val)
	{
	$this->asignarValorVariable("IPConfirmacionAlta","$val");
	}
	
	function setFechaHoraSolicitudBaja($val)
	{
	$this->asignarValorVariable("FechaHoraSolicitudBaja","$val");
	}
	
	function setIPSolicitudBaja($val)
	{
	$this->asignarValorVariable("IPSolicitudBaja","$val");
	}
	
	function setFechaHoraConfirmacionBaja($val)
	{
	$this->asignarValorVariable("FechaHoraConfirmacionBaja","$val");
	}
	
	function setIPConfirmacionBaja($val)
	{
	$this->asignarValorVariable("IPConfirmacionBaja","$val");
	}
	
	function setComentarios($val)
	{
	$this->asignarValorVariable("Comentarios","$val");
	}

	function setEnviosPendientes($val)
	{
	$this->asignarValorVariable("EnviosPendientes","$val");
	}

	function setEnviosHechos($val)
	{
	$this->asignarValorVariable("EnviosHechos","$val");
	}
	
	function setEnviosRebotados($val)
	{
	$this->asignarValorVariable("EnviosRebotados","$val");
	}
	
	// **********************
	// SELECT METHOD / LOAD
	// **********************

	function select($id)
	{
	return parent::select($id);
	}

	function buscarDatos($camposSeleccionar,$condiciones,$orden="",$primero="",$ultimo="",$limite="") {
	return parent::buscarDatos($camposSeleccionar,$condiciones,$orden,$primero,$ultimo,$limite);
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