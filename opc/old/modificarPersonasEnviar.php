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
$valores = array(
	"profesion"=>$_POST["profesion_"],
	"nombre"=>$_POST["nombre_"],
	"apellido"=>$_POST["apellidos_"],
	"cargo"=>$_POST["cargo_"],
	"institucion"=>$_POST["institucion_"],
	"pais"=>$_POST["pais_"],
	"email"=>$_POST["mail_"]	,
	"idioma_hablado"=>$_POST["idioma_"] ,
);

$endonde = $base->validarPedido("ID_Personas", $_POST["idViejo"]);

if($_POST["eliminar_curr"]=="si"){
	$valores["Curriculum"] = "";
}

$rs = $base ->updateEnBase($tabla, $valores, $endonde);


if($_FILES["archivo"]["name"] != ""){
	$name = $_POST["idViejo"] . "_" . normalizarString($_FILES["archivo"]["name"]);
	$valores2 = array(
		"Curriculum"=>$name
	);
	$rs = $base ->updateEnBase($tabla, $valores2, $endonde);
	copy($_FILES["archivo"]["tmp_name"],"cv/" . $name);
}

$valores3 = array(
	"Profesion"=>$_POST["profesion_"],
	"Nombre"=>$_POST["nombre_"],
	"Apellidos"=>$_POST["apellidos_"],
	"Cargos"=>$_POST["cargo_"],
	"Institucion"=>$_POST["institucion_"],
	"Pais"=>$_POST["pais_"],
	"Mail"=>$_POST["mail_"]	
);

if($_POST["eliminar_curr"]=="si"){
	$valores3["Curriculum"] = "";
} else {
	$valores3["Curriculum"] = $name;
}
$endonde3 = $base->validarPedido("ID_Persona", $_POST["idViejo"]);
$tabla2 = "congreso";

$rs = $base ->updateEnBase($tabla2, $valores3, $endonde3);



header("Location: altaPersonas.php");
?>