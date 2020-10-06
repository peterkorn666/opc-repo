<?
include('conexion.php');

$profesion_ = $_POST["profesion_"];
$nombre_ = $_POST["nombre_"];
$apellidos_ = $_POST["apellidos_"];
$cargo_ = $_POST["cargo_"];
$institucion_= $_POST["institucion_"];
$pais_ = $_POST["pais_"]; 
$mail_ = $_POST["mail_"];

$sql = "INSERT INTO personas_trabajos_libres (Profesion,Nombre,Apellidos,Cargos,Institucion,Pais, Mail) VALUES ";
$sql .= "('" . $profesion_ . "','" . $nombre_ .  "','" . $apellidos_ . "','" . $cargo_ . "','" . $institucion_ . "','" . $pais_ . "','" . $mail_ . "');";

$estadoPersonas = mysql_query($sql, $con);


$sql = "SELECT ID_Personas FROM personas_trabajos_libres ORDER BY ID_Personas ASC";
$rs = mysql_query($sql,$con);
while ($row = mysql_fetch_array($rs)){
	$ultimoID = $row["ID_Personas"];
}


if($_POST["archivo"]["name"] != ""){
	$sql =  "UPDATE personas_trabajos_libres SET ";
	$sql .= "Curriculum = '" . $ultimoID . "_" . $_POST["archivo"]["name"] . "' where ID_Personas=" . $ultimoID . ";";
	$estadoPersonas = mysql_query($sql,$con);
	
	copy($_POST["archivo"]["tmp_name"],"cv/" . $ultimoID . "_" . $_POST["archivo"]["name"]);
}


if($_POST["sola"]==1){
	
	if ($institucion_!=""){
			$institucion = " - "  . $institucion_;
		}else{
			$institucion = "";
		}
		
		if ($pais_!=""){
			$pais = " ("  . $pais_ . ")";
		}else{
			$pais = "";
		}
		
		if ($profesion_!=""){
			$profesion = " (".$profesion_.")";
		}else{
			$profesion = "";
		}

	
	echo "<script>\n";
	
	
	$persona = "  <font size=2><strong>" . htmlentities($apellidos_) . ", " . htmlentities($nombre_) . "</strong> " . htmlentities($pais) . " - " . htmlentities($institucion_) . "</font>"; 


	
	/*	echo "window.opener.tempSeleccion();\n";
		echo "window.opener.llenarArrayPersonas('" . $apellidos_ . ", " . $nombre_ . $profesion . $pais . $institucion . "', '$ultimoID');\n";
		echo "window.opener.llenarPersonas();\n";
		echo "window.opener.seleccionarPersonas('$ultimoID', '".$_POST["combo"]."');\n";*/
		
		echo "window.parent.cargar_persona_buscada(".$_POST["combo"].", $ultimoID, '$persona');\n";
		echo "window.parent.closePopup($estadoPersonas);";
		//echo "window.close();\n";
	echo "</script>\n";

}else{

	header("Location: altaPersonasTL.php"); 
	
}
?>
