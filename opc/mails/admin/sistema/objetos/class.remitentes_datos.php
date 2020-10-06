<?php
	// **********************
	// CLASS DECLARATION
	// **********************

	class remitentes_datos extends objeto
	{ // class : begin


	// **********************
	// ATTRIBUTE DECLARATION
	// **********************


	
	// **********************
	// CONSTRUCTOR METHOD
	// **********************

	function remitentes_datos()
	{

		parent::objeto();

		$this->tabla="remitentes";
		$this->campoClave="IdRemitente";
		$this->id=null;
		
		
$v=new Variable(2,$this->tabla,"IdRemitente",1);
			
$v->clave=true;
			
			
$v->autonumerica=true;
			
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Mail",2);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Nombre",3);
$this->agregarVariable2($v);

	}

	
	// **********************
	// GETTER METHODS
	// **********************

	
	function getIdRemitente()
	{
	return $this->darValorVariable("IdRemitente");
	}
	
	function getMail()
	{
	return $this->darValorVariable("Mail");
	}
	
	function getNombre()
	{
	return $this->darValorVariable("Nombre");
	}
	
	// **********************
	// SETTER METHODS
	// **********************

	
	function setIdRemitente($val)
	{
	$this->asignarValorVariable("IdRemitente","$val");
	}
	
	function setMail($val)
	{
	$this->asignarValorVariable("Mail","$val");
	}
	
	function setNombre($val)
	{
	$this->asignarValorVariable("Nombre","$val");
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