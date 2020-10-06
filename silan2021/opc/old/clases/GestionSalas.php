<?
class GestionSalas{	
	
	/*Arrays*/
	function GestionSalas(){
		$this->nCon = conectarDB();
	}


	function profesiones(){

		$sql = "SELECT * FROM profesiones ORDER by Profesion ASC";
		$rs = mysql_query($sql,$this->nCon);
		while ($row = mysql_fetch_array($rs)){

			echo "<script>llenarArrayProfesiones('" . $row["Profesion"] . "')</script>";

		}
	}

	function cargos(){

		$sql = "SELECT * FROM cargos ORDER by Cargos ASC";
		$rs = mysql_query($sql,$this->nCon);
		while ($row = mysql_fetch_array($rs)){

			echo "<script>llenarArrayCargos('" . $row["Cargos"] . "')</script>";

		}
	}

	function instituciones(){

		$sql = "SELECT * FROM instituciones ORDER by Institucion ASC";
		$rs = mysql_query($sql,$this->nCon);
		while ($row = mysql_fetch_array($rs)){

			echo "<script>llenarArrayInstituciones('" . $row["Institucion"] . "')</script>";

		}

	}
	
	function horas(){

		$sql = "SELECT DISTINCT Hora FROM horas ORDER by Hora ASC";
		$rs = mysql_query($sql,$this->nCon);
		while ($row = mysql_fetch_array($rs)){
			echo "<script>llenarArrayHoras('". $row["Hora"] . "')</script>";
		}
	}
	
	function staff(){
		$sql = "SELECT * FROM staff ORDER by nombre ASC";
		$rs = mysql_query($sql,$this->nCon);
		while ($row = mysql_fetch_array($rs)){

			echo "<script>llenarArrayStaff('" . $row["nombre"] . "')</script>";

		}
	
	}

	function salas(){
		$sql = "SELECT * FROM salas ORDER by Sala_orden ASC";
		$rs = mysql_query($sql,$this->nCon);
		while ($row = mysql_fetch_array($rs)){

			echo "<script>llenarArraySalas_combo('" . $row["Sala"] . "')</script>";

		}
	
	}
	
	function rubros(){
		$sql = "SELECT * FROM rubros ORDER by rubro ASC";
		$rs = mysql_query($sql,$this->nCon);
		while ($row = mysql_fetch_array($rs)){

			echo "<script>llenarArrayRubros('" . $row["rubro"] . "')</script>";

		}
	}
	
	function dias(){
		$sql = "SELECT * FROM dias ORDER by Dia_orden ASC";
		$rs = mysql_query($sql,$this->nCon);
		while ($row = mysql_fetch_array($rs)){

			echo "<script>llenarArrayDias('" . $row["Dia"] . "')</script>";

		}
	
	}
	
	function paises(){
		$sql = "SELECT * FROM paises ORDER by Pais ASC";
		$rs = mysql_query($sql,$this->nCon);
		while ($row = mysql_fetch_array($rs)){

			echo "<script>llenarArrayPaises('" . $row["Pais"] . "')</script>";

		}
	
	}
	
	function UNA_persona_TLS($cualID){
		$sql = "SELECT * FROM personas_trabajos_libres WHERE ID_Personas = $cualID";
		$rs = mysql_query($sql,$this->nCon);
		
		return $rs;
		
	}
	
	
	/*unificar personas TL*/

	function selectUnificar($cuales){		
		$filtro = " WHERE ID_Personas = ";		
		for ($i=0; $i<count($cuales); $i++){			
			if($i>0){
				$filtro .= " or ID_Personas = ";				
			}			
			$filtro .= $cuales[$i];			
		}		
		$sql = "SELECT * FROM personas $filtro ORDER by Apellidos, Nombre ASC";
		$rs = mysql_query($sql,$this->nCon);		
		return $rs;		
	}
		
	/*function selectUnificarEnviar($cuales, $porCual){
		
		foreach ($cuales as $i){
		
			if($i != $porCual){
			
				$sql = "UPDATE trabajos_libres_participantes SET ID_participante=$porCual WHERE ID_participante=$i;";
				mysql_query($sql,$this->nCon);

				$sql2 = "DELETE FROM personas_trabajos_libres WHERE ID_Personas=$i;";
				mysql_query($sql2,$this->nCon);
			
			}
			
			
		}
		
	}*/
	function selectUnificarEnviar($cuales, $porCual){
		$nuInfo = "SELECT * FROM personas WHERE ID_Personas = $porCual";	
		$rsNuInfo = mysql_query($nuInfo,$this->nCon);	
		if ($row = mysql_fetch_array($rsNuInfo)) {			
			foreach ($cuales as $i){		
				if($i != $porCual){			
					//$sql = "UPDATE trabajos_libres_participantes SET ID_participante=$porCual WHERE ID_participante=$i;";
					$sql = "UPDATE congreso SET ID_persona=$porCual, Nombre='".$row["Nombre"]."',Apellidos='".$row["Apellidos"]."', Mail='".$row["Mail"]."',Pais='".$row["Mail"]."',Institucion='".$row["Institucion"]."',Profesion='".$row["Profesion"]."'  WHERE ID_persona=$i;";
					mysql_query($sql,$this->nCon);
					$sql2 = "DELETE FROM personas WHERE ID_Personas=$i;";
					mysql_query($sql2,$this->nCon);			
				}			
			}		
		}
	}
	
}
?>