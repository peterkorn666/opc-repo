<?
class casillero{

	var $nCon;

	function casillero(){
		$this->nCon = conectarDB();
	}

	function dias(){

		$sql = "SELECT * FROM dias ORDER by Dia_orden ASC";
		$rs = mysql_query($sql,$this->nCon);
		return $rs;
	}
	


	function salas(){

		$sql = "SELECT * FROM salas WHERE Sala<>'' ORDER by Sala_orden ASC";
		$rs = mysql_query($sql,$this->nCon);
		return $rs;
	}

	function horas(){

		$sql = "SELECT DISTINCT(Hora) FROM horas ORDER by Hora ASC";
		$rs = mysql_query($sql,$this->nCon);
		return $rs;

	}

	function tipoDeActividades(){
		$sql = "SELECT * FROM tipo_de_actividad ORDER by Tipo_de_actividad ASC";
		$rs = mysql_query($sql,$this->nCon);
		return $rs;
	}
	
	function actividades(){

	$sql = "SELECT a.*, p.Nombre, p.Apellidos FROM actividades a , personas p WHERE a.idPersona = p.ID_Personas ORDER BY p.Apellidos";
	$rs = mysql_query($sql, $con);
	while ($row = mysql_fetch_array($rs)){
			/*echo "<script>llenarArrayActividades_Conferencistas('" . $row["Nombre"]. " " .$row["Apellidos"]. " - " .$row["Titulo_de_trabajo"]. "', '" . $row["id"] ."')</script>";*/
		}
	}

	function areas(){
		$sql = "SELECT * FROM areas ORDER by Area ASC";
		$rs = mysql_query($sql,$this->nCon);
		return $rs;
	}

	function tematicas(){

		$sql = "SELECT * FROM tematicas ORDER by Tematica ASC";
		$rs = mysql_query($sql,$this->nCon);
		return $rs;
	}

	function enCalidades(){

		$sql = "SELECT * FROM en_calidades ORDER by En_calidad ASC";
		$rs = mysql_query($sql,$this->nCon);
		return $rs;
	}
	
	function paises(){

		$sql = "SELECT DISTINCT(Pais) FROM congreso ORDER by Pais ASC";
		$rs = mysql_query($sql,$this->nCon);
		while ($row = mysql_fetch_array($rs)){

			/*echo "<script>llenarArrayPaises('".$row["Pais"]."')</script>";*/

		}
	}
	
	function personas(){

		$sql = "SELECT * FROM personas ORDER by apellido, nombre  ASC";
		$rs = mysql_query($sql,$this->nCon) or die(mysql_error());

		while ($row = mysql_fetch_array($rs)){

			if ($row["Institucion"]!=""){
				$institucion = " - "  . $row["Institucion"];
			}else{
				$institucion = "";
			}

			if ($row["Pais"]!=""){
				$pais = " ("  . $row["Pais"] . ")";
			}else{
				$pais = "";
			}

			if ($row["Profesion"]!=""){
				$profesion = " (".$row["Profesion"].")";
			}else{
				$profesion = "";
			}

			/*echo "<script>llenarArrayPersonas('" . $row["Apellidos"] . "," . $row["Nombre"] . $profesion . $pais . $institucion  . "', '" . $row["ID_Personas"] ."')</script>";*/

		}
	}
	
	function seleccionar_casilleros_del_filtrado($arrayIDS){
	
		foreach($arrayIDS as $i){
			$sql1 = "SELECT * FROM congreso WHERE Casillero = '$i' AND Mail <> ''";
			$rs1 = mysql_query($sql1,$this->nCon) or die("Ha ocurrido un error en Mail");
			while($row1 = mysql_fetch_array($rs1)){				
					$filtro .= " ID = ".$row1["ID"]." OR ";				
			}
		}
		$largo = strlen($filtro) - 3;
		$filtro = substr($filtro, 0, $largo);
		
		$sql = "SELECT * FROM  congreso WHERE $filtro ORDER BY Casillero, Orden_aparicion";	
		//$rs = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error en seleccionar_trabajos_libres_del_filtrado");	
		$rs = mysql_query($sql,$this->nCon) or false;			
		return $rs;
		
	}


}

?>