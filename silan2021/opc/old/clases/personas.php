<?
class personas{	
	
	/*Arrays*/
	function personas(){
		$this->nCon = conectarDB();
	}


	function profesiones(){

		$sql = "SELECT * FROM profesiones ORDER by Profesion ASC";
		$rs = $this->nCon->query($sql);
		while ($row = $rs->fetch_array()){

			echo "<script>llenarArrayProfesiones('" . $row["Profesion"] . "')</script>";

		}
	}

	function cargos(){

		$sql = "SELECT * FROM cargos ORDER by Cargos ASC";
		$rs = $this->nCon->query($sql);
		while ($row = $rs->fetch_array()){

			echo "<script>llenarArrayCargos('" . $row["Cargos"] . "')</script>";

		}
	}

	function instituciones(){

		$sql = "SELECT * FROM instituciones ORDER by Institucion ASC";
		$rs = $this->nCon->query($sql);
		while ($row = $rs->fetch_array()){

			echo "<script>llenarArrayInstituciones('" . $row["Institucion"] . "')</script>";

		}

	}

	
	function paises(){
		$sql = "SELECT * FROM paises ORDER by Pais ASC";
		$rs = $this->nCon->query($sql);
		while ($row = $rs->fetch_array()){

			echo "<script>llenarArrayPaises('" . $row["Pais"] . "')</script>";

		}
	
	}
	
	function UNA_persona_TLS($cualID){
		$sql = "SELECT * FROM personas_trabajos_libres WHERE ID_Personas = $cualID";
		$rs = $this->nCon->query($sql);
		
		return $rs;
		
	}
	
	function trabajosPersona($cualID){
		$sql = "SELECT t.numero_tl, t.titulo_tl FROM trabajos_libres t JOIN trabajos_libres_participantes tp ON t.id_trabajo=tp.ID_trabajos_libres WHERE tp.ID_participante= $cualID";
		$rs = $this->nCon->query($sql);
		$result = $rs->fetch_array();
		return $result;
	}
	
	
	/*unificar personas TL*/
	function selectUnificarTL($cuales){		
		$filtro = " WHERE ID_Personas = ";		
		for ($i=0; $i<count($cuales); $i++){			
			if($i>0){			
				$filtro .= " or ID_Personas = ";				
			}			
			$filtro .= $cuales[$i];			
		}		
		$sql = "SELECT * FROM personas_trabajos_libres $filtro ORDER by Apellidos, Nombre ASC";
		$rs = $this->nCon->query($sql);
		if(!$rs){
			die($this->nCon->error);
		}
		return $rs;		
	}
	
	/*unificar personas*/
	function selectUnificar($cuales){		
		$filtro = " WHERE ID_Personas = ";		
		for ($i=0; $i<count($cuales); $i++){			
			if($i>0){
				$filtro .= " or ID_Personas = ";				
			}			
			$filtro .= $cuales[$i];			
		}		
		$sql = "SELECT * FROM personas $filtro ORDER by apellido, nombre ASC";
		$rs = $this->nCon->query($sql);
		if(!$rs){
			die($this->nCon->error);
		}
		return $rs;		
	}
		
	function selectUnificarEnviarTL($cuales, $porCual){
		
		foreach ($cuales as $i){	
			if($i != $porCual){			
				$sql = "UPDATE trabajos_libres_participantes SET ID_participante=$porCual WHERE ID_participante=$i;";
				$updatesql = $this->nCon->query($sql);
				if(!$updatesql){
					die($this->nCon->error);
				}
				$sql2 = "DELETE FROM personas_trabajos_libres WHERE ID_Personas=$i;";
				$update_sql2 = $this->nCon->query($sql2);
				if(!$update_sql2){
					die($this->nCon->error);
				}			
			}			
		}
	}
	function selectUnificarEnviar($cuales, $porCual){
		$nuInfo = "SELECT * FROM personas WHERE ID_Personas = $porCual";	
		$rsNuInfo = $this->nCon->query($nuInfo);	
		if ($row = $rsNuInfo->fetch_array()) {			
			foreach ($cuales as $i){		
				if($i != $porCual){			
					//$sql = "UPDATE trabajos_libres_participantes SET ID_participante=$porCual WHERE ID_participante=$i;";
					$sql = "UPDATE congreso SET ID_persona=$porCual, Nombre='".$row["Nombre"]."',Apellidos='".$row["Apellidos"]."', Mail='".$row["Mail"]."',Pais='".$row["Mail"]."',Institucion='".$row["Institucion"]."',Profesion='".$row["Profesion"]."'  WHERE ID_persona=$i;";
					$this->nCon->query($sql);
					$sql2 = "DELETE FROM personas WHERE ID_Personas=$i;";
					$this->nCon->query($sql2);			
				}			
			}		
		}
	}
	
	function marcarInscripto($id){
		$sql = "UPDATE personas_trabajos_libres SET inscripto=1 WHERE ID_Personas='$id';";
		$estado = $this->nCon->query($sql);
		if(!$estado){
			die($this->nCon->error);
		}
		return $estado;
	}
	
}
?>