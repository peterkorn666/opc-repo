<?php
session_start();
//header('Content-Type: text/html; charset=iso-8859-1');
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");

if (!isset($_SESSION["registrado"])){
	$_SESSION["registrado"]=false;
}
if ($_SESSION["registrado"]==false){
	header ("Location: login.php");
}


function normalizarString($str){
	$nuevoStr = str_replace(".", "_", $str);
	$nuevoStr = str_replace(" ", "_", $nuevoStr);
	
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
	$nuevoStr = str_replace("Ñ", "N", $nuevoStr);

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

require('conexion.php');
require("clases/trabajosLibres.php");
$trabajos = new trabajosLibre();

$estado_de_TL = $_POST["estado_de_TL"];
$tipo_de_TL = $_POST["tipo_de_TL"];
$numero_TL = $_POST["numero_TL"];
$idioma = $_POST["idioma"];

	if($_POST["chkSinHora"] != "checked" ){
		$hora_inicio = $_POST["hora_inicio_"];
		$hora_fin = $_POST["hora_fin_"];
	}
	else
	{
		$hora_inicio = "00:00";
		$hora_fin = "00:00";
	}

$id_trabajo = $_POST["id_trabajo"];
$area_ = $_POST["area_"];
$ID_casillero = $_POST["ID_casillero"];

$archivo_tl = $_FILES['archivo_tl']['name'];
$archivo_tl_ampliado = $_FILES['archivo_tl_ampliado']['name'];



$mailContacto_TL = $_POST["contacto_mail"];
$telContacto_TL = $_POST["contacto_telefono"];

$titulo_TL = $_POST["titulo_TL"];
$tipo_tl = $_POST["tipo_tl"];
$cual_premio = $_POST["cual_premio"];
$palabrasClave_TL = $_POST["palabrasClave_TL"];
$persona = $_POST["persona"];
$lee = $_POST["lee_"];
$viejoArchivo = "";
$resumen = $_POST["resumen"];
$resumen_en = $_POST["resumen_en"];
$resumen2 = $_POST["resumen2"];
$resumen3 = $_POST["resumen3"];
$resumen4 = $_POST["resumen4"];

$area_tl = $_POST["area_"];
$premio = $_POST["premio"];

$dropbox = $_POST["dropbox"];

$clave = $_POST["clave"];

$oral_tl = $_POST["oral_tl"];
$poster_tl = $_POST["poster_tl"];

$rem = array("'");
$remPor = array("´");

$comentarios_admin = $_POST["comentarios_admin"];


$NombreContacto = $_POST["contacto_nombre"];
$ApellidoContacto = $_POST["contacto_apellido"];
$InstContacto = $_POST["contacto_institucion"];
$paisContacto = $_POST["contacto_pais"];
$ciudadContacto = $_POST["contacto_ciudad"];


$categoria = $_POST["categoria"];
$tipo_trabajo = $_POST["tipo_trabajo"];

$will_sendContacto = $_POST["will_sendContacto"];


function remplazarNomArchivo($donde){
	$valor = str_replace(" ", "_" , $donde);
	$valor = str_replace(".", "_" , $valor);
	$valor = str_replace(",", "_" , $valor);
	$valor = str_replace("á", "a" , $valor);
	$valor = str_replace("é", "e" , $valor);
	$valor = str_replace("í", "i" , $valor);
	$valor = str_replace("ó", "o" , $valor);
	$valor = str_replace("ú", "u" , $valor);
	$valor = str_replace("ñ", "ñ" , $valor);
	$valor = str_replace("´", "" , $valor);
	$valor = str_replace(" ", "_" , $valor);
	return $valor;
}


//ARCHIVOS
if($_FILES["archivo_tl"]["tmp_name"]!=""){
	$extension = explode(".",$archivo_tl);
	$extension = end($extension);
	
	if(strtolower($extension)!="pdf"){
		@header("Location: index.php");
		die();
	}
	
	$archivo_tl = remplazarNomArchivo($numero_TL."_".$NombreContacto."_".$ApellidoContacto);
	$archivo_tl = $archivo_tl.".".$extension;
	if(!copy($_FILES["archivo_tl"]["tmp_name"], "tl/$archivo_tl")){
		$puede_ingresar=false;
	}
	if($puede_ingresar){
		//ELIMINO EL ARCHIVO ARRIBA SI INGRESA OTRO
		if($_POST["archivo_tl_viejo"]!=""){
			if($archivo_tl!=$_SESSION["tabla_trabajo_comleto"]){
				unlink("tl/" . $_POST["archivo_tl_viejo"]);
			}
		}
	}
}else{
	if($_POST["archivo_tl_viejo"]!=""){
		$archivo_tl =  $_POST["archivo_tl_viejo"];
	}
}

$puede_ingresar_amp=true;
if($_FILES["archivo_tl_ampliado"]["tmp_name"]!=""){
	$extension = explode(".",$archivo_tl_ampliado);
	$extension = end($extension);
	
	if(strtolower($extension)!="pdf"){
		header("Location: index.php");
		die();
	}
	
	$archivo_tl_ampliado = substr($trabajos->areaID($area_)->Area,0,2)."_".remplazarNomArchivo($numero_TL."_".$NombreContacto."_".$ApellidoContacto);
	$archivo_tl_ampliado = $archivo_tl_ampliado.".".$extension;
	if(!copy($_FILES["archivo_tl_ampliado"]["tmp_name"], "../tl_ampliado/$archivo_tl_ampliado")){
		$puede_ingresar_amp=false;
	}
	if($puede_ingresar_amp){
		//ELIMINO EL ARCHIVO ARRIBA SI INGRESA OTRO
		if($_POST["archivo_tl_ampliado_viejo"]!=""){
			if($archivo_tl_ampliado!=$_POST["archivo_tl_ampliado_viejo"]){
				unlink("../tl_ampliado/" . $_POST["archivo_tl_ampliado_viejo"]);
			}
		}
	}
}else{
	if($_POST["archivo_tl_ampliado_viejo"]!=""){
		$archivo_tl_ampliado =  $_POST["archivo_tl_ampliado_viejo"];
	}
}

//ARCHIVOS---



$viejoActualizacion = $_POST["viejoActualizacion"];



/*ingreso datos principales*/

$parametros = array(
	"ID_casillero"=>$ID_casillero,
	"Hora_inicio"=>$hora_inicio,
	"Hora_fin"=>$hora_fin,
	"numero_tl"=>$numero_TL,
	"titulo_tl"=>$titulo_TL,
	"area_tl"=>$area_tl,
	"tipo_tl"=>$tipo_tl,
	"estado"=>$estado_de_TL,
	"palabrasClave"=>$palabrasClave_TL,
	"resumen"=>$resumen,
	"resumen_en"=>$resumen_en,
	"contacto_mail"=>$mailContacto_TL,
	"contacto_nombre"=>$NombreContacto,
	"contacto_apellido"=>$ApellidoContacto,
	"contacto_telefono"=>$telContacto_TL,
	"contacto_ciudad"=>$ciudadContacto,
	"contacto_institucion"=>$InstContacto,
	"contacto_pais"=>$paisContacto,
//	"premio"=>$premio,
	
	//"ultima_actualizacion"=>$viejoActualizacion,
);

if($archivo_tl!=""){
	$parametros["archivo_tl"] = $archivo_tl;	
}
if($archivo_tl!=""){
	$parametros["archivo_trabajo_comleto"] = $archivo_tl;
}
if($archivo_tl_ampliado!=""){
	$parametros["archivo_tl_ampliado"] = $archivo_tl_ampliado;
}

/*var_dump($parametros);
die();*/
if($id_trabajo==""){
	$result = $trabajos->Insertar($parametros,"trabajos_libres");
	$ultimoID = $result["ultimoID"];
}else{
	$result = $trabajos->Modificar("ID=".$id_trabajo,$parametros,"trabajos_libres");
	$ultimoID = $id_trabajo;
}


/*obtego el ultimo ingreso*/



$i = 0;
//print_r($persona);
//die();
//Reseteo los autores
$delPers = $trabajos->eliminarByID("trabajos_libres_participantes","ID_trabajos_libres=".$ultimoID);
foreach ($persona as $u){

	if($u != ""){

		$sql = "SELECT * FROM personas_trabajos_libres WHERE ID_Personas = '$u';";
		$rs = mysql_query($sql, $con) or die(mysql_error());
		while($row = mysql_fetch_array($rs)){

			$persIns = array(
				"ID_trabajos_libres"=>$ultimoID,
				"ID_participante"=>$row["ID_Personas"],
				"lee"=>$lee[$i]
			);
			
			$trabajos->Insertar($persIns,"trabajos_libres_participantes");
		}
	}

	$i = $i + 1;
}


$sqlM = "INSERT INTO Modificaciones (Tiempo,Cambio, Usuario) VALUES ";
if($id_trabajo !=""){

	$sqlM .= "('" . date("d/m/Y  H:i")  . "','Se modifico el trabajo libre código $numero_TL' , '" .  $_SESSION["usuario"] . "');";

}else{

	$sqlM .= "('" . date("d/m/Y  H:i")  . "','Se creo el trabajo libre código $numero_TL ', '". $_SESSION["usuario"] . "');";

}
mysql_query($sqlM, $con);

/*echo "<script>\n";
if($idEliminar !=""){
echo "window.history.go(-2);\n";
}else{
echo "window.history.go(-1);\n";
}
echo "</script>\n";

header ("Location: estadoTL.php?estado=cualquier&ubicado=&area=&tipo=&clave=$numero_TL");*/
header ("Location: estadoTL.php?idioma=&estado=cualquier&vacio=true");


?>
