<?php
	// **********************
	// CLASS DECLARATION
	// **********************

	class usuarios_datos extends objeto
	{ // class : begin


	// **********************
	// ATTRIBUTE DECLARATION
	// **********************


	
	// **********************
	// CONSTRUCTOR METHOD
	// **********************

	function usuarios_datos()
	{

		parent::objeto();

		$this->tabla="usuarios";
		$this->campoClave="Id";
		$this->id=null;
		
		
$v=new Variable(1,$this->tabla,"Id",1);
			
$v->clave=true;
			
			
$v->autonumerica=true;
			
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Usuario",2);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Clave",3);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Nombre",4);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Apellido",5);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Mail",6);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"IdNivel",7);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"IdEstadoUsuario",8);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Creacion",9);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Actualizacion",10);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"UltimoIntento",11);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"UltimoIngreso",12);
$this->agregarVariable2($v);

	}

	
	// **********************
	// GETTER METHODS
	// **********************

	
	function getId()
	{
	return $this->darValorVariable("Id");
	}
	
	function getUsuario()
	{
	return $this->darValorVariable("Usuario");
	}
	
	function getClave()
	{
	return $this->darValorVariable("Clave");
	}
	
	function getNombre()
	{
	return $this->darValorVariable("Nombre");
	}
	
	function getApellido()
	{
	return $this->darValorVariable("Apellido");
	}
	
	function getMail()
	{
	return $this->darValorVariable("Mail");
	}
	
	function getIdNivel()
	{
	return $this->darValorVariable("IdNivel");
	}
	
	function getIdEstadoUsuario()
	{
	return $this->darValorVariable("IdEstadoUsuario");
	}
	
	function getCreacion()
	{
	return $this->darValorVariable("Creacion");
	}
	
	function getActualizacion()
	{
	return $this->darValorVariable("Actualizacion");
	}
	
	function getUltimoIntento()
	{
	return $this->darValorVariable("UltimoIntento");
	}
	
	function getUltimoIngreso()
	{
	return $this->darValorVariable("UltimoIngreso");
	}
	
	// **********************
	// SETTER METHODS
	// **********************

	
	function setId($val)
	{
	$this->asignarValorVariable("Id","$val");
	}
	
	function setUsuario($val)
	{
	$this->asignarValorVariable("Usuario","$val");
	}
	
	function setClave($val)
	{
	$this->asignarValorVariable("Clave","$val");
	}
	
	function setNombre($val)
	{
	$this->asignarValorVariable("Nombre","$val");
	}
	
	function setApellido($val)
	{
	$this->asignarValorVariable("Apellido","$val");
	}
	
	function setMail($val)
	{
	$this->asignarValorVariable("Mail","$val");
	}
	
	function setIdNivel($val)
	{
	$this->asignarValorVariable("IdNivel","$val");
	}
	
	function setIdEstadoUsuario($val)
	{
	$this->asignarValorVariable("IdEstadoUsuario","$val");
	}
	
	function setCreacion($val)
	{
	$this->asignarValorVariable("Creacion","$val");
	}
	
	function setActualizacion($val)
	{
	$this->asignarValorVariable("Actualizacion","$val");
	}
	
	function setUltimoIntento($val)
	{
	$this->asignarValorVariable("UltimoIntento","$val");
	}
	
	function setUltimoIngreso($val)
	{
	$this->asignarValorVariable("UltimoIngreso","$val");
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