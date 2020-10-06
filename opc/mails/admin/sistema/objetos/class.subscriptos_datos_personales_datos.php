<?PHP
	// **********************
	// CLASS DECLARATION
	// **********************

	class subscriptos_datos_personales_datos extends objeto
	{ // class : begin


	// **********************
	// ATTRIBUTE DECLARATION
	// **********************

	// **********************
	// CONSTRUCTOR METHOD
	// **********************

	function subscriptos_datos_personales_datos()
	{

		parent::objeto();

		$this->tabla="subscriptos_datos_personales";
		$this->campoClave="subscriptos_datos_personales.IdSubscripto";
		$this->id=null;
		
	
		$v=new Variable(2,$this->tabla,"IdSubscripto",1);
		
		$v->clave=true;
		
		$v->largoTotal=11;
		
		$v->requerida=true;
		
		$this->agregarVariable2($v);
	
		$v=new Variable(1,$this->tabla,"Nombre",2);
		
		$v->largoTotal=100;
		
		$v->requerida=true;
		
		$this->agregarVariable2($v);
	
		$v=new Variable(1,$this->tabla,"Apellido",3);
		
		$v->largoTotal=100;
		
		$v->requerida=true;
		
		$this->agregarVariable2($v);
	
		$v=new Variable(1,$this->tabla,"Pais",4);
		
		$v->largoTotal=100;
		
		$v->requerida=true;
		
		$this->agregarVariable2($v);
	
		$v=new Variable(1,$this->tabla,"Ciudad",5);
		
		$v->largoTotal=100;
		
		$v->requerida=true;
		
		$this->agregarVariable2($v);
	
		$v=new Variable(1,$this->tabla,"Direccion",6);
		
		$v->largoTotal=255;
		
		$v->requerida=true;
		
		$this->agregarVariable2($v);
	
		$v=new Variable(1,$this->tabla,"CP",7);
		
		$v->largoTotal=10;
		
		$v->requerida=true;
		
		$this->agregarVariable2($v);
	
		$v=new Variable(1,$this->tabla,"Telefono",8);
		
		$v->largoTotal=20;
		
		$v->requerida=true;
		
		$this->agregarVariable2($v);
	
		$v=new Variable(1,$this->tabla,"Celular",9);
		
		$v->largoTotal=20;
		
		$v->requerida=true;
		
		$this->agregarVariable2($v);
	
		$v=new Variable(1,$this->tabla,"Fax",10);
		
		$v->largoTotal=20;
		
		$v->requerida=true;
		
		$this->agregarVariable2($v);
	
		$v=new Variable(1,$this->tabla,"Web",11);
		
		$v->largoTotal=100;
		
		$v->requerida=true;
		
		$this->agregarVariable2($v);
	
		$v=new Variable(1,$this->tabla,"Idioma",12);
		
		$v->largoTotal=2;
		
		$v->requerida=true;
		
		$this->agregarVariable2($v);
	
		$v=new Variable(1,$this->tabla,"Sexo",13);
		
		$v->largoTotal=1;
		
		$v->requerida=true;
		
		$this->agregarVariable2($v);
	
		$v=new Variable(2,$this->tabla,"Edad",14);
		
		$v->largoTotal=11;
		
		$v->requerida=true;
		
		$this->agregarVariable2($v);
	
		$v=new Variable(1,$this->tabla,"RangoEdad",15);
		
		$v->largoTotal=20;
		
		$v->requerida=true;
		
		$this->agregarVariable2($v);
	
		$v=new Variable(1,$this->tabla,"Profesion",16);
		
		$v->largoTotal=50;
		
		$v->requerida=true;
		
		$this->agregarVariable2($v);
	
		$v=new Variable(1,$this->tabla,"Especialidad",17);
		
		$v->largoTotal=50;
		
		$v->requerida=true;
		
		$this->agregarVariable2($v);
	
		$v=new Variable(1,$this->tabla,"Institucion",18);
		
		$v->largoTotal=100;
		
		$v->requerida=true;
		
		$this->agregarVariable2($v);
	
		$v=new Variable(1,$this->tabla,"TipoInstitucion",19);
		
		$v->largoTotal=50;
		
		$v->requerida=true;
		
		$this->agregarVariable2($v);
	
		$v=new Variable(1,$this->tabla,"Libre1",20);
		
		$v->largoTotal=100;
		
		$v->requerida=true;
		
		$this->agregarVariable2($v);
	
		$v=new Variable(1,$this->tabla,"Libre2",21);
		
		$v->largoTotal=100;
		
		$v->requerida=true;
		
		$this->agregarVariable2($v);
	
		$v=new Variable(1,$this->tabla,"Libre3",22);
		
		$v->largoTotal=100;
		
		$v->requerida=true;
		
		$this->agregarVariable2($v);
	
		$v=new Variable(1,$this->tabla,"Libre4",23);
		
		$v->largoTotal=100;
		
		$v->requerida=true;
		
		$this->agregarVariable2($v);
	
		$v=new Variable(1,$this->tabla,"Libre5",24);
		
		$v->largoTotal=100;
		
		$v->requerida=true;
		
		$this->agregarVariable2($v);
	

	}
	
	// **********************
	// GETTER METHODS
	// **********************

	
		function getIdSubscripto()
		{
			return $this->darValorVariable("IdSubscripto");
		}
	
		function getNombre()
		{
			return $this->darValorVariable("Nombre");
		}
	
		function getApellido()
		{
			return $this->darValorVariable("Apellido");
		}
	
		function getPais()
		{
			return $this->darValorVariable("Pais");
		}
	
		function getCiudad()
		{
			return $this->darValorVariable("Ciudad");
		}
	
		function getDireccion()
		{
			return $this->darValorVariable("Direccion");
		}
	
		function getCP()
		{
			return $this->darValorVariable("CP");
		}
	
		function getTelefono()
		{
			return $this->darValorVariable("Telefono");
		}
	
		function getCelular()
		{
			return $this->darValorVariable("Celular");
		}
	
		function getFax()
		{
			return $this->darValorVariable("Fax");
		}
	
		function getWeb()
		{
			return $this->darValorVariable("Web");
		}
	
		function getIdioma()
		{
			return $this->darValorVariable("Idioma");
		}
	
		function getSexo()
		{
			return $this->darValorVariable("Sexo");
		}
	
		function getEdad()
		{
			return $this->darValorVariable("Edad");
		}
	
		function getRangoEdad()
		{
			return $this->darValorVariable("RangoEdad");
		}
	
		function getProfesion()
		{
			return $this->darValorVariable("Profesion");
		}
	
		function getEspecialidad()
		{
			return $this->darValorVariable("Especialidad");
		}
	
		function getInstitucion()
		{
			return $this->darValorVariable("Institucion");
		}
	
		function getTipoInstitucion()
		{
			return $this->darValorVariable("TipoInstitucion");
		}
	
		function getLibre1()
		{
			return $this->darValorVariable("Libre1");
		}
	
		function getLibre2()
		{
			return $this->darValorVariable("Libre2");
		}
	
		function getLibre3()
		{
			return $this->darValorVariable("Libre3");
		}
	
		function getLibre4()
		{
			return $this->darValorVariable("Libre4");
		}
	
		function getLibre5()
		{
			return $this->darValorVariable("Libre5");
		}
	
		
	// **********************
	// SETTER METHODS
	// **********************
	
	
		function setIdSubscripto($val)
		{
			return $this->asignarValorVariable("IdSubscripto",$val);
		}
	
		function setNombre($val)
		{
			return $this->asignarValorVariable("Nombre",$val);
		}
	
		function setApellido($val)
		{
			return $this->asignarValorVariable("Apellido",$val);
		}
	
		function setPais($val)
		{
			return $this->asignarValorVariable("Pais",$val);
		}
	
		function setCiudad($val)
		{
			return $this->asignarValorVariable("Ciudad",$val);
		}
	
		function setDireccion($val)
		{
			return $this->asignarValorVariable("Direccion",$val);
		}
	
		function setCP($val)
		{
			return $this->asignarValorVariable("CP",$val);
		}
	
		function setTelefono($val)
		{
			return $this->asignarValorVariable("Telefono",$val);
		}
	
		function setCelular($val)
		{
			return $this->asignarValorVariable("Celular",$val);
		}
	
		function setFax($val)
		{
			return $this->asignarValorVariable("Fax",$val);
		}
	
		function setWeb($val)
		{
			return $this->asignarValorVariable("Web",$val);
		}
	
		function setIdioma($val)
		{
			return $this->asignarValorVariable("Idioma",$val);
		}
	
		function setSexo($val)
		{
			return $this->asignarValorVariable("Sexo",$val);
		}
	
		function setEdad($val)
		{
			return $this->asignarValorVariable("Edad",$val);
		}
	
		function setRangoEdad($val)
		{
			return $this->asignarValorVariable("RangoEdad",$val);
		}
	
		function setProfesion($val)
		{
			return $this->asignarValorVariable("Profesion",$val);
		}
	
		function setEspecialidad($val)
		{
			return $this->asignarValorVariable("Especialidad",$val);
		}
	
		function setInstitucion($val)
		{
			return $this->asignarValorVariable("Institucion",$val);
		}
	
		function setTipoInstitucion($val)
		{
			return $this->asignarValorVariable("TipoInstitucion",$val);
		}
	
		function setLibre1($val)
		{
			return $this->asignarValorVariable("Libre1",$val);
		}
	
		function setLibre2($val)
		{
			return $this->asignarValorVariable("Libre2",$val);
		}
	
		function setLibre3($val)
		{
			return $this->asignarValorVariable("Libre3",$val);
		}
	
		function setLibre4($val)
		{
			return $this->asignarValorVariable("Libre4",$val);
		}
	
		function setLibre5($val)
		{
			return $this->asignarValorVariable("Libre5",$val);
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