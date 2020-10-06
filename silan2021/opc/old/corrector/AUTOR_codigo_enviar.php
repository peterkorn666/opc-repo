<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache"); 
$congreso = "[SLEP 2012]";

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

$_SESSION["txtCod"]=$_POST["txtCod"];
$sql2 = "SELECT * FROM evaluaciones WHERE numero_tl='" . $_POST["txtCod"] ."';";
$rs2 = mysql_query($sql2,$con);
$correcto= false;
while(($correcto==false)&&($row2 = mysql_fetch_array($rs2))) {
	$sql = "SELECT * FROM evaluadores WHERE id = '".$row2["idEvaluador"]."' AND clave = '".$_POST["txtClave"]."';";
	$rs = mysql_query($sql,$con);
	if ($row = mysql_fetch_array($rs) ){
		$correcto=true;
		$nombreEvaluador = $row["nombre"];
		$idEvaluador = $row2["idEvaluador"];
		$opcion = $row2["evaluacion"];
		$correccion = $row2["comentario"];
	}
}
if ($correcto==true) { 
	$sql3 = "SELECT * FROM trabajos_libres WHERE numero_tl='" . $_POST["txtCod"] ."';";
	$rs3 = mysql_query($sql3,$con);
	$row = mysql_fetch_array($rs3);
	$pass=1;
	$_SESSION["idEvaluador"] = $idEvaluador;
	$_SESSION["opcion"] = $opcion;
	$_SESSION["correccion"] = str_replace("<br />", "", $correccion);	
	$_SESSION["nombreEvaluador"] = $nombreEvaluador;
	$_SESSION["registrado"] = true;
	$_SESSION["habilitado"] = true;
	$_SESSION["ID_TL"] = $row["ID"];	
	$_SESSION["emailContacto"] = $row["mailContacto_tl"];
	$_SESSION["ApellidoContacto"] = $row["apellidoContacto"];
	$_SESSION["NombreContacto"] = $row["nombreContacto"];
	$_SESSION["InstContacto"] = $row["institucionContacto"];
	$_SESSION["paisContacto"] = $row["paisContacto"];
	$_SESSION["ciudadContacto"] = $row["ciudadContacto"];
	$_SESSION["agraContacto"] = $row["agraContacto"];
	$_SESSION["telContacto"] = $row["telefono"];
	$_SESSION["apremio"] = $row["premio"];
	$_SESSION["numero"] = $row["numero_tl"];
	$_SESSION["titulo"] = $row["titulo_tl"];
	$_SESSION["titulo_residente"] = $row["titulo_tl_residente"];
	$_SESSION["resumen"] = $row["resumen"];
	
	$_SESSION["objetivos"] = $row["antecedentes"];
	$_SESSION["desarrollo"] = $row["material"];
	$_SESSION["conclusiones"] = $row["conclusiones"];
	$_SESSION["bibliografia"] = $row["referencias"];
	
	
	
	$_SESSION["resumen_residente"] = $row["resumen_residente"];
	$_SESSION["resumenIng"] = $row["resumenIng"];
	$_SESSION["tema"] = $row["area_tl"];
	$_SESSION["idiomaTL"] = $row["idioma"];
	$_SESSION["tipoTL"] = $row["tipo_tl"];
	$_SESSION["dirArchivo"] = $row["archivo_trabajo_comleto"];
	$_SESSION["clave"] = $row["clave"];
	
	$_SESSION["tipo_trabajo"] = $row["tipo_trabajo"];
	$_SESSION["categoria"] = $row["categoria"];
	
	$keys = $row["palabrasClave"]; 
	list($_SESSION["key1"], $_SESSION["key2"], $_SESSION["key3"], $_SESSION["key4"], $_SESSION["key5"] ) = @split( ',', $keys );


	$enAutor=1;

	$sql0 ="SELECT * FROM trabajos_libres_participantes WHERE ID_trabajos_libres=" . $row["ID"] . "  ORDER BY ID ASC;";
	$rs0 = mysql_query($sql0,$con);
	while ($row0 = mysql_fetch_array($rs0)){
	
//	echo $row0["ID_participante"] . "-" ;

		$sql1 ="SELECT * FROM personas_trabajos_libres WHERE ID_Personas = " . $row0["ID_participante"] . ";";
		$rs1 = mysql_query($sql1,$con);
		while ($row1 = mysql_fetch_array($rs1)){

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
		//	,  $row0["lee"]);
			
			array_push($array_inscripto, $row0["inscripto"]);
			

		}
		$enAutor=$enAutor+1;

	}

	$autores = new autores();
	$autores->setSessionAutores($array_ID_persona, $array_nombre,$array_apellido,$array_institucion,$array_mail,$array_pais,$array_ciudad,$array_agradecimientos,$array_lee,$array_inscripto);
//
	header("Location: index.php");
	
} 



if ($pass==0){

	header("Location:index.php?pass=0");

}
?>