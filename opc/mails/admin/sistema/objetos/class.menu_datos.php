<?php

	// **********************
	// CLASS DECLARATION
	// **********************

	class menu_datos extends objeto
	{ // class : begin


	// **********************
	// ATTRIBUTE DECLARATION
	// **********************


	
	// **********************
	// CONSTRUCTOR METHOD
	// **********************

	function menu_datos()
	{

		parent::objeto();

		$this->tabla="menu";
		$this->campoClave="IdMenu";
		$this->id=null;
		
		
$v=new Variable(2,$this->tabla,"IdMenu",1);
			
$v->clave=true;
			
			
$v->autonumerica=true;
			
$this->agregarVariable2($v);
$v=new Variable(2,$this->tabla,"IdMenuPadre",2);
$this->agregarVariable2($v);
$v=new Variable(2,$this->tabla,"Orden",3);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Menu_es",4);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Menu_en",5);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Menu_pt",6);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"RutaId",7);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Ruta_es",8);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Ruta_en",9);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Ruta_pt",10);
$this->agregarVariable2($v);
$v=new Variable(2,$this->tabla,"OrdenAbsoluto",11);
$this->agregarVariable2($v);
$v=new Variable(2,$this->tabla,"CantidadHijosDirectos",12);
$this->agregarVariable2($v);
$v=new Variable(2,$this->tabla,"CantidadHijosTotales",13);
$this->agregarVariable2($v);
$v=new Variable(2,$this->tabla,"LinkIdMenu",14);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Tipo",15);
$this->agregarVariable2($v);
$v=new Variable(1,$this->tabla,"Detalle",16);
$this->agregarVariable2($v);

	}

	
	// **********************
	// GETTER METHODS
	// **********************

	
	function getIdMenu()
	{
	return $this->darValorVariable("IdMenu");
	}
	
	function getIdMenuPadre()
	{
	return $this->darValorVariable("IdMenuPadre");
	}
	
	function getOrden()
	{
	return $this->darValorVariable("Orden");
	}
	
	function getMenu_es()
	{
	return $this->darValorVariable("Menu_es");
	}
	
	function getMenu_en()
	{
	return $this->darValorVariable("Menu_en");
	}
	
	function getMenu_pt()
	{
	return $this->darValorVariable("Menu_pt");
	}
	
	function getRutaId()
	{
	return $this->darValorVariable("RutaId");
	}
	
	function getRuta_es()
	{
	return $this->darValorVariable("Ruta_es");
	}
	
	function getRuta_en()
	{
	return $this->darValorVariable("Ruta_en");
	}
	
	function getRuta_pt()
	{
	return $this->darValorVariable("Ruta_pt");
	}
	
	function getOrdenAbsoluto()
	{
	return $this->darValorVariable("OrdenAbsoluto");
	}
	
	function getCantidadHijosDirectos()
	{
	return $this->darValorVariable("CantidadHijosDirectos");
	}
	
	function getCantidadHijosTotales()
	{
	return $this->darValorVariable("CantidadHijosTotales");
	}
	
	function getLinkIdMenu()
	{
	return $this->darValorVariable("LinkIdMenu");
	}
	
	function getTipo()
	{
	return $this->darValorVariable("Tipo");
	}
	
	function getDetalle()
	{
	return $this->darValorVariable("Detalle");
	}
	
	// **********************
	// SETTER METHODS
	// **********************

	
	function setIdMenu($val)
	{
	$this->asignarValorVariable("IdMenu","$val");
	}
	
	function setIdMenuPadre($val)
	{
	$this->asignarValorVariable("IdMenuPadre","$val");
	}
	
	function setOrden($val)
	{
	$this->asignarValorVariable("Orden","$val");
	}
	
	function setMenu_es($val)
	{
	$this->asignarValorVariable("Menu_es","$val");
	}
	
	function setMenu_en($val)
	{
	$this->asignarValorVariable("Menu_en","$val");
	}
	
	function setMenu_pt($val)
	{
	$this->asignarValorVariable("Menu_pt","$val");
	}
	
	function setRutaId($val)
	{
	$this->asignarValorVariable("RutaId","$val");
	}
	
	function setRuta_es($val)
	{
	$this->asignarValorVariable("Ruta_es","$val");
	}
	
	function setRuta_en($val)
	{
	$this->asignarValorVariable("Ruta_en","$val");
	}
	
	function setRuta_pt($val)
	{
	$this->asignarValorVariable("Ruta_pt","$val");
	}
	
	function setOrdenAbsoluto($val)
	{
	$this->asignarValorVariable("OrdenAbsoluto","$val");
	}
	
	function setCantidadHijosDirectos($val)
	{
	$this->asignarValorVariable("CantidadHijosDirectos","$val");
	}
	
	function setCantidadHijosTotales($val)
	{
	$this->asignarValorVariable("CantidadHijosTotales","$val");
	}
	
	function setLinkIdMenu($val)
	{
	$this->asignarValorVariable("LinkIdMenu","$val");
	}
	
	function setTipo($val)
	{
	$this->asignarValorVariable("Tipo","$val");
	}
	
	function setDetalle($val)
	{
	$this->asignarValorVariable("Detalle","$val");
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

	function delete()
	{
	return parent::delete();
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

	function update()
	{
	return parent::update();
	}

	} // class : end

	?>