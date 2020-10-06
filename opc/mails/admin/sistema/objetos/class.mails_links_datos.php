<?php
	// **********************
	// CLASS DECLARATION
	// **********************

	class mails_links_datos extends objeto
	{ // class : begin


	// **********************
	// ATTRIBUTE DECLARATION
	// **********************


	
	// **********************
	// CONSTRUCTOR METHOD
	// **********************

	function mails_links_datos()
	{

		parent::objeto();

		$this->tabla="mails_links";
		$this->campoClave="IdMailLink";
		$this->id=null;
		
		
$v=new Variable(2,$this->tabla,"IdMailLink",1);
			
$v->clave=true;
			
			
$v->autonumerica=true;
			
$this->agregarVariable2($v);
$v=new Variable(2,$this->tabla,"IdMail",2);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Nombre",3);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Url",4);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Comentarios",5);
$this->agregarVariable2($v);

	}

	
	// **********************
	// GETTER METHODS
	// **********************

	
	function getIdMailLink()
	{
	return $this->darValorVariable("IdMailLink");
	}
	
	function getIdMail()
	{
	return $this->darValorVariable("IdMail");
	}
	
	function getNombre()
	{
	return $this->darValorVariable("Nombre");
	}
	
	function getUrl()
	{
	return $this->darValorVariable("Url");
	}
	
	function getComentarios()
	{
	return $this->darValorVariable("Comentarios");
	}
	
	// **********************
	// SETTER METHODS
	// **********************

	
	function setIdMailLink($val)
	{
	$this->asignarValorVariable("IdMailLink","$val");
	}
	
	function setIdMail($val)
	{
	$this->asignarValorVariable("IdMail","$val");
	}
	
	function setNombre($val)
	{
	$this->asignarValorVariable("Nombre","$val");
	}
	
	function setUrl($val)
	{
	$this->asignarValorVariable("Url","$val");
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