<?php
	// **********************
	// CLASS DECLARATION
	// **********************

	class mails_datos extends objeto
	{ // class : begin


	// **********************
	// ATTRIBUTE DECLARATION
	// **********************


	
	// **********************
	// CONSTRUCTOR METHOD
	// **********************

	function mails_datos()
	{

		parent::objeto();

		$this->tabla="mails";
		$this->campoClave="IdMail";
		$this->id=null;
		
		
$v=new Variable(2,$this->tabla,"IdMail",1);
			
$v->clave=true;
			
			
$v->autonumerica=true;
			
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Referencia",2);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Asunto",3);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"CuerpoTexto",4);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"CuerpoTextoPreparado",5);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"CuerpoHTML",6);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"CuerpoHTMLPreparado",7);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"FromNombre",8);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"FromEmail",9);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"ReplyToNombre",10);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"ReplyToEmail",11);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"SenderNombre",12);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"SenderEmail",13);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Importancia",14);
$v->valorPorDefecto="3";
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Prioridad",15);
$v->valorPorDefecto="3";
$this->agregarVariable2($v);
$v=new Variable(2,$this->tabla,"ConfirmacionLectura",16);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Comentarios",17);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"FechaCreacion",18);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"FechaModificacion",19);
$this->agregarVariable2($v);

	}

	
	// **********************
	// GETTER METHODS
	// **********************

	
	function getIdMail()
	{
	return $this->darValorVariable("IdMail");
	}
	
	function getReferencia()
	{
	return $this->darValorVariable("Referencia");
	}
	
	function getAsunto()
	{
	return $this->darValorVariable("Asunto");
	}
	
	function getCuerpoTexto()
	{
	return $this->darValorVariable("CuerpoTexto");
	}
	
	function getCuerpoTextoPreparado()
	{
	return $this->darValorVariable("CuerpoTextoPreparado");
	}
	
	function getCuerpoHTML()
	{
	return $this->darValorVariable("CuerpoHTML");
	}
	
	function getCuerpoHTMLPreparado()
	{
	return $this->darValorVariable("CuerpoHTMLPreparado");
	}
	
	function getFromNombre()
	{
	return $this->darValorVariable("FromNombre");
	}
	
	function getFromEmail()
	{
	return $this->darValorVariable("FromEmail");
	}
	
	function getReplyToNombre()
	{
	return $this->darValorVariable("ReplyToNombre");
	}
	
	function getReplyToEmail()
	{
	return $this->darValorVariable("ReplyToEmail");
	}
	
	function getSenderNombre()
	{
	return $this->darValorVariable("SenderNombre");
	}
	
	function getSenderEmail()
	{
	return $this->darValorVariable("SenderEmail");
	}
	
	function getImportancia()
	{
	return $this->darValorVariable("Importancia");
	}
	
	function getPrioridad()
	{
	return $this->darValorVariable("Prioridad");
	}
	
	function getConfirmacionLectura()
	{
	return $this->darValorVariable("ConfirmacionLectura");
	}
	
	function getComentarios()
	{
	return $this->darValorVariable("Comentarios");
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

	
	function setIdMail($val)
	{
	$this->asignarValorVariable("IdMail","$val");
	}
	
	function setReferencia($val)
	{
	$this->asignarValorVariable("Referencia","$val");
	}
	
	function setAsunto($val)
	{
	$this->asignarValorVariable("Asunto","$val");
	}
	
	function setCuerpoTexto($val)
	{
	$this->asignarValorVariable("CuerpoTexto","$val");
	}
	
	function setCuerpoTextoPreparado($val)
	{
	$this->asignarValorVariable("CuerpoTextoPreparado","$val");
	}
	
	function setCuerpoHTML($val)
	{
	$this->asignarValorVariable("CuerpoHTML","$val");
	}
	
	function setCuerpoHTMLPreparado($val)
	{
	$this->asignarValorVariable("CuerpoHTMLPreparado","$val");
	}
	
	function setFromNombre($val)
	{
	$this->asignarValorVariable("FromNombre","$val");
	}
	
	function setFromEmail($val)
	{
	$this->asignarValorVariable("FromEmail","$val");
	}
	
	function setReplyToNombre($val)
	{
	$this->asignarValorVariable("ReplyToNombre","$val");
	}
	
	function setReplyToEmail($val)
	{
	$this->asignarValorVariable("ReplyToEmail","$val");
	}
	
	function setSenderNombre($val)
	{
	$this->asignarValorVariable("SenderNombre","$val");
	}
	
	function setSenderEmail($val)
	{
	$this->asignarValorVariable("SenderEmail","$val");
	}
	
	function setImportancia($val)
	{
	$this->asignarValorVariable("Importancia","$val");
	}
	
	function setPrioridad($val)
	{
	$this->asignarValorVariable("Prioridad","$val");
	}
	
	function setConfirmacionLectura($val)
	{
	$this->asignarValorVariable("ConfirmacionLectura","$val");
	}
	
	function setComentarios($val)
	{
	$this->asignarValorVariable("Comentarios","$val");
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