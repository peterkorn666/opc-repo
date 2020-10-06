<?
class autores{

	var $nCon;	
	var $cuantosAutores;
	var $id_persona;
	var $nombres;
	var $apellidos ;
	var $instituciones;
	var $mails;
	var $paises;
	var $ciudades;
	var $agradecimientos;
	var $lee;
	var $inscriptos;


	function autores(){

		$this->id_persona =	   $_SESSION["id_persona"];
		$this->nombres =	   $_SESSION["nombre"];
		$this->apellidos  =	   $_SESSION["apellido"];
		$this->instituciones = $_SESSION["institucion"];
		$this->mails =		   $_SESSION["mail"];
		$this->paises =		   $_SESSION["pais"];
		$this->ciudades = 	   $_SESSION["ciudad"];
		$this->agradecimientos = 	   $_SESSION["agradecimientos"];
		$this->lee =		   $_SESSION["lee"];
		$this->inscriptos =    $_SESSION["inscripto"];

		$this->setCuantosAutores();

	}
	
	
	function setSessionAutores($id_persona, $nombre,$apellido,$institucion,$mail,$pais,$ciudad,$agradecimientos,$lee,$inscripto){		
		$_SESSION["id_persona"] = $id_persona;
		$_SESSION["nombre"] = $nombre;
		$_SESSION["apellido"] = $apellido;
		$_SESSION["institucion"] = $institucion;
		$_SESSION["mail"] = $mail;
		$_SESSION["pais"] = $pais;
		$_SESSION["ciudad"] = $ciudad;
		$_SESSION["agradecimientos"] = $agradecimientos;
		$_SESSION["lee"] = $lee;
		$_SESSION["inscripto"] = $inscripto;
		return "Ok";
	}


	function setCuantosAutores(){

		$this->cuantosAutores = count($this->nombres);

		return "Ok";

	}

	
	function setArrays(){

		echo "<script>\n";

		for($i=0; $i<$this->cuantosAutores; $i++){
									
			echo "ArrayID.push('" . $this->id_persona[$i] . "');\n";
			
			echo "ArrayNombres.push('" . $this->nombres[$i] . "');\n";

			echo "ArrayApellidos.push('" . $this->apellidos[$i] . "');\n";

			echo "ArrayInstituciones.push('" . $this->instituciones[$i] . "');\n";

			echo "ArrayMails.push('" . $this->mails[$i] . "');\n";

			echo "ArrayPaises.push('" . $this->paises[$i] . "');\n";

			echo "ArrayCiudades.push('" . $this->ciudades[$i] . "');\n";
			
			echo "ArrayAgradecimientos.push('" . $this->agradecimientos[$i] . "');\n";

			echo "ArrayInscriptos.push('" . $this->inscriptos[$i] . "');\n";

		}
		
		echo "ArrayLees='" . $this->lee . "';\n";
		
		echo "</script>\n";

		return "ok";

	}

	function verificar_id_autor_repetido($unID){
	
	$this->nCon = conectarDB();
	
	$repetido = "false";
	
		$sql = "SELECT * FROM trabajos_libres_participantes WHERE ID_participante = '$unID'";
		$rs = $this->nCon->query($sql);
		$cant_row = $rs->num_row;
			
		if($cant_row>1){
			$repetido = "true";
		}
				
		
	 return $repetido;  

	}



}
?>