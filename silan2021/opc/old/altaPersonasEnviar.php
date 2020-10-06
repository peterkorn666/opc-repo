<?
include('inc/sesion.inc.php');
include('conexion.php');
require "clases/class.baseController.php";
function normalizarString($str){
	$nuevoStr = str_replace(" ", "_", $str);
	$nuevoStr = str_replace("á", "a", $nuevoStr);
	$nuevoStr = str_replace("Á", "A", $nuevoStr);
	$nuevoStr = str_replace("à", "a", $nuevoStr);
	$nuevoStr = str_replace("À", "A", $nuevoStr);
	$nuevoStr = str_replace("â", "a", $nuevoStr);
	$nuevoStr = str_replace("Â", "A", $nuevoStr);	
	$nuevoStr = str_replace("É", "E", $nuevoStr);
	$nuevoStr = str_replace("é", "e", $nuevoStr);
	$nuevoStr = str_replace("È", "E", $nuevoStr);
	$nuevoStr = str_replace("è", "e", $nuevoStr);
	$nuevoStr = str_replace("Ê", "E", $nuevoStr);
	$nuevoStr = str_replace("ê", "e", $nuevoStr);	
	$nuevoStr = str_replace("ì", "i", $nuevoStr);
	$nuevoStr = str_replace("Í", "I", $nuevoStr);
	$nuevoStr = str_replace("í", "i", $nuevoStr);
	$nuevoStr = str_replace("Ì", "I", $nuevoStr);
	$nuevoStr = str_replace("î", "i", $nuevoStr);
	$nuevoStr = str_replace("Î", "I", $nuevoStr);	
	$nuevoStr = str_replace("ó", "o", $nuevoStr);
	$nuevoStr = str_replace("Ó", "O", $nuevoStr);
	$nuevoStr = str_replace("ò", "o", $nuevoStr);
	$nuevoStr = str_replace("Ò", "O", $nuevoStr);
	$nuevoStr = str_replace("ô", "o", $nuevoStr);
	$nuevoStr = str_replace("Ô", "O", $nuevoStr);	
	$nuevoStr = str_replace("ú", "u", $nuevoStr);
	$nuevoStr = str_replace("Ú", "U", $nuevoStr);
	$nuevoStr = str_replace("ù", "u", $nuevoStr);
	$nuevoStr = str_replace("Ù", "U", $nuevoStr);
	$nuevoStr = str_replace("ü", "u", $nuevoStr);
	$nuevoStr = str_replace("Ü", "U", $nuevoStr);	
	$nuevoStr = str_replace("ñ", "n", $nuevoStr);
	$nuevoStr = str_replace("ç", "c", $nuevoStr);
	$nuevoStr = str_replace("Ç", "C", $nuevoStr);
	$nuevoStr = str_replace("ã", "a", $nuevoStr);
	$nuevoStr = str_replace("Ã", "A", $nuevoStr);
	$nuevoStr = str_replace("õ", "o", $nuevoStr);
	$nuevoStr = str_replace("/", "_", $nuevoStr);
	$nuevoStr = str_replace("|", "_", $nuevoStr);
	$nuevoStr = str_replace(":", "_", $nuevoStr);
	$nuevoStr = str_replace("*", "_", $nuevoStr);
	$nuevoStr = str_replace("<", "_", $nuevoStr);
	$nuevoStr = str_replace(">", "_", $nuevoStr);
	$nuevoStr = str_replace("\"", "_", $nuevoStr);
	$nuevoStr = str_replace("`", "_", $nuevoStr);
	$nuevoStr = str_replace("´", "_", $nuevoStr);
	return $nuevoStr;
}
$base = new baseController();
$tabla = "personas";
$_POST = array_map("utf8_encode",$_POST);
$valores = array(
	"profesion"=>$_POST["profesion_"],
	"nombre"=>$_POST["nombre_"],
	"apellido"=>$_POST["apellidos_"],
	"cargo"=>$_POST["cargo_"],
	"institucion"=>$_POST["institucion_"],
	"pais"=>$_POST["pais_"],
	"email"=>$_POST["mail_"], 	
	"idioma_hablado"=>$_POST["idioma_"], 		
	
);
$rs = $base ->insertarEnBase($tabla, $valores);

$sql = "SELECT max(ID_Personas) as ultimoID FROM personas";
$rs = mysql_query($sql,$con);
if ($row = mysql_fetch_array($rs)){
	$ultimoID = $row["ultimoID"];
}


if($_FILES["archivo"]["name"] != ""){
	$name = $ultimoID . "_" . normalizarString($_FILES["archivo"]["name"]);
	$valores2 = array(
		"Curriculum"=>$name
	);
	$endonde = $base->validarPedido("ID_Personas", $ultimoID);
	$rs = $base ->updateEnBase($tabla, $valores2, $endonde);
	if(copy($_FILES["archivo"]["tmp_name"],"cv/" . $name)){
		$ArchCv = array("cv"=>$name);
		$rs = $base ->updateEnBase($tabla, $ArchCv,"ID_Personas=".$ultimoID);
	}
}



//******//


if($_POST["sola"]==1){	
	//no se de q venia esta
	/*if ($institucion_!=""){
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
	$persona = "<strong>".$apellidos_ . ", " . $nombre_ ."</strong>". $profesion . $pais . $institucion;*/

}else{	
	header("Location: altaPersonas.php"); 	
}
?>
