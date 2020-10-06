<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache"); 
$pass=0;
include "../conexion.php";
require "clases/class.autores.php";

$array_ID_persona = array();
$array_nombre = array();
$array_apellido = array();
$array_institucion = array();
$array_mail = array();
$array_pais = array();
$array_ciudad= array();
$array_agradecimientos = array();
$array_lee = array();
$array_inscripto= array();

$_SESSION["txtCod"]=$_GET["txtCod"];
$sql = "SELECT * FROM evaluaciones WHERE numero_tl='" . $_GET["txtCod"] ."' AND idEvaluador = '" . $_SESSION["idEvaluador"] ."' ;";
$rs = $con->query($sql);
$correcto= false;
if ($row = $rs->fetch_array() ){
	$correcto=true;
	$opcion = $row["evaluacion"];
	$nota = $row["nota"];
	$correccion = $row["comentario"];
	$opcion2 = $row["evaluacion2"];
	$nota2 = $row["nota2"];
	$_SESSION["premio"] = $row["premio"];
	$correccion2 = $row["comentario2"];	
}
if ($correcto==true) { 
	$sql3 = "SELECT * FROM trabajos_libres WHERE numero_tl='" . $_GET["txtCod"] ."';";
	$rs3 = $con->query($sql3);
	$row = $rs3->fetch_array();
	$pass=1;
	//$_SESSION["idEvaluador"] = $idEvaluador;
	$_SESSION["opcion"] = $opcion;
	$_SESSION["nota"] = $nota;
	$_SESSION["correccion"] = str_replace("<br />", "", $correccion);	
	$_SESSION["opcion2"] = $opcion2;
	$_SESSION["nota2"] = $nota2;
	$_SESSION["correccion2"] = str_replace("<br />", "", $correccion2);	
	//$_SESSION["nombreEvaluador"] = $nombreEvaluador;
	$_SESSION["registrado"] = true;
	$_SESSION["habilitado"] = true;
	$_SESSION["ID_TL"] = $row["id_trabajo"];	
	$_SESSION["emailContacto"] = $row["mailContacto_tl"];
	$_SESSION["ApellidoContacto"] = $row["apellidoContacto"];
	$_SESSION["NombreContacto"] = $row["nombreContacto"];
	$_SESSION["InstContacto"] = $row["institucionContacto"];
	$_SESSION["paisContacto"] = $row["paisContacto"];
	$_SESSION["ciudadContacto"] = $row["ciudadContacto"];
	$_SESSION["agraContacto"] = $row["agraContacto"];
	$_SESSION["telContacto"] = $row["telefono"];
	$_SESSION["numero"] = $row["numero_tl"];
	$_SESSION["titulo"] = $row["titulo_tl"];
	$_SESSION["resumen"] = $row["resumen"];
	$_SESSION["resumen2"] = $row["resumen2"];
	$_SESSION["resumen3"] = $row["resumen3"];
	$_SESSION["resumen4"] = $row["resumen4"];
	$_SESSION["resumen5"] = $row["resumen5"];
	$_SESSION["resumen6"] = $row["resumen6"];
	$_SESSION["resumen7"] = $row["resumen7"];
	$_SESSION["resumen_en"] = $row["resumen_en"];
	$_SESSION["titulo_residente"] = $row["titulo_tl_residente"];
	$_SESSION["resumen_residente"] = $row["resumen_residente"];
	$_SESSION["resumenIng"] = $row["resumenIng"];
	$_SESSION["tema"] = $row["area_tl"];
	$_SESSION["area_tl"] = $row["area_tl"];
	$_SESSION["idiomaTL"] = $row["idioma"];
	$_SESSION["tipoTL"] = $row["tipo_tl"];
	$_SESSION["archivo_tl_ampliado"] = $row["archivo_tl_ampliado"];
	$_SESSION["archivo_tl"] = $row["archivo_tl"];
	$_SESSION["dirArchivo"] = $row["dirArchivo"];
	$_SESSION["clave"] = $row["clave"];
	$_SESSION["premio"] = $row["premio"];
	$keys = $row["palabrasClave"];
	
	$_SESSION["objetivos"] = $row["antecedentes"];
	$_SESSION["desarrollo"] = $row["material"];
	$_SESSION["conclusiones"] = $row["conclusiones"];
	$_SESSION["bibliografia"] = $row["referencias"];
	
	$_SESSION["tipo_trabajo"] = $row["tipo_trabajo"];
	$_SESSION["categoria"] = $row["categoria"];

	
	list($_SESSION["key1"], $_SESSION["key2"], $_SESSION["key3"], $_SESSION["key4"], $_SESSION["key5"] ) = explode(',',$keys);
	$enAutor=1;
	$sql0 ="SELECT * FROM trabajos_libres_participantes WHERE ID_trabajos_libres=" . $row["id_trabajo"] . "  ORDER BY ID ASC;";
	$rs0 = $con->query($sql0);
	while ($row0 = $rs0->fetch_array()){
		$sql1 ="SELECT * FROM personas_trabajos_libres WHERE ID_Personas = " . $row0["ID_participante"] . ";";
		$rs1 = $con->query($sql1);
		while ($row1 = $rs1->fetch_array()){
			array_push($array_ID_persona, $row1["ID_Personas"]);
			array_push($array_nombre, $row1["Nombre"]);
			array_push($array_apellido, $row1["Apellidos"]);
			array_push($array_institucion,  $row1["Institucion"]);
			array_push($array_mail,  $row1["Mail"]);
			array_push($array_pais, $row1["Pais"]);
			array_push($array_ciudad,  $row1["ciudad"]);
			array_push($array_agradecimientos,  $row1["agradecimientos"]);			
			if($row0["lee"]==1){
				$array_lee = $enAutor;
			}			
			array_push($array_inscripto, $row0["inscripto"]);
		}
		$enAutor=$enAutor+1;
	}
	$autores = new autores();
	$autores->setSessionAutores($array_ID_persona, $array_nombre,$array_apellido,$array_institucion,$array_mail,$array_pais,$array_ciudad,$array_agradecimientos,$array_lee,$array_inscripto);//
	header("Location: index.php");	
}
if ($pass==0){
	header("Location:login.php");
}
?>