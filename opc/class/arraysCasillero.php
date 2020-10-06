<?
class casillero{

	var $nCon;

	function __construct(){
		$this->db = conectaDb();
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
		$sql = $this->db->prepare("SELECT * FROM tipo_de_actividad ORDER by tipo_actividad ASC");
		if(!$sql->execute())
			return print_r($sql->errorInfo());
		return $sql;
	}
	
	function actividades(){

	$sql = "SELECT a.*, p.Nombre, p.Apellidos FROM actividades a , personas p WHERE a.idPersona = p.ID_Personas ORDER BY p.Apellidos";
	$rs = mysql_query($sql, $con);
	while ($row = mysql_fetch_array($rs)){
			/*echo "<script>llenarArrayActividades_Conferencistas('" . $row["Nombre"]. " " .$row["Apellidos"]. " - " .$row["Titulo_de_trabajo"]. "', '" . $row["id"] ."')</script>";*/
		}
	}

	function areas(){
		$sql = $this->db->prepare("SELECT * FROM areas ORDER by Area ASC");
		if(!$sql->execute())
			return print_r($sql->errorInfo());
		return $sql;
	}

	function tematicas(){

		$sql = $this->db->prepare("SELECT * FROM tematicas ORDER by Tematica ASC");
		if(!$sql->execute())
			return print_r($sql->errorInfo());
		return $sql;
	}

	function enCalidades(){

		$sql = $this->db->prepare("SELECT * FROM calidades_conferencistas ORDER by calidad ASC");
		if(!$sql->execute())
			return print_r($sql->errorInfo());
		return $sql;
	}
	
	function titulosConferencista(){

		$sql = $this->db->prepare("SELECT * FROM conferencistas_titulos ORDER by titulo ASC");
		if(!$sql->execute())
			return print_r($sql->errorInfo());
		return $sql;
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