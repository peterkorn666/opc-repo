<?
session_start();
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

include('conexion.php');

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

$area_ = $_POST["area_"];
$ID_casillero = $_POST["ID_casillero"];

$mailContacto_TL = $_POST["mailContacto_TL"];
$telContacto_TL = $_POST["telContacto_TL"];

$titulo_TL = $_POST["titulo_TL"];
$palabrasClave_TL = $_POST["palabrasClave_TL"];
$persona = $_POST["persona"];
$lee = $_POST["lee"];
$viejoArchivo = "";
$resumenTL= $_POST["resumenTL"];
$clave = $_POST["clave"];


$NombreContacto = $_POST["nombreContacto_tl"];
$ApellidoContacto = $_POST["apellidoContacto_tl"];
$InstContacto = $_POST["institucionContacto_tl"];
$paisContacto = $_POST["paisContacto"];
$ciudadContacto = $_POST["ciudadContacto"];
$will_sendContacto = $_POST["will_sendContacto"];

$premio = $_POST["premio"];
if ($_POST["quePremio"]!="" && $_POST["quePremio"]!="(Seleccione)" ){
	$quePremio = $_POST["quePremio"];
}else{
	$quePremio = "";
}



$viejoActualizacion = $_POST["viejoActualizacion"];

$nombreArchivo = $_FILES['archivo_TL']['name'];

$idEliminar = $_POST["idEliminar"];

if($idEliminar !=""){

	require("clases/trabajosLibres.php");
	$trabajos = new trabajosLibre;
	$trabajos ->eliminarTL($idEliminar);
	
	if($_POST["eliminarTrabajo"]==1){
		unlink("tl/" . $_POST["viejoArchivo"]);
	}else{
		$viejoArchivo = $_POST["viejoArchivo"];
	}
	
}

/*ingreso datos principales*/
$sql = "INSERT INTO trabajos_libres (ID_casillero ,Hora_inicio ,Hora_fin ,numero_tl , titulo_tl , area_tl ,
		tipo_tl ,  estado , palabrasClave, archivo_tl, archivo_trabajo_comleto, resumen, clave, idioma, 
		
		
		 mailContacto_tl, 
		 nombreContacto, 
		 apellidoContacto, 
		 telefono, 
		 institucionContacto, 
		 paisContacto, 
		 ciudadContacto,  
		 will_sendContacto,
		
		ultima_actualizacion,premio,quePremio ) VALUES (
		
		'$ID_casillero',
		'$hora_inicio',
		'$hora_fin',
		'$numero_TL',
		'$titulo_TL ',
		'$area_',
		'$tipo_de_TL',
		'$estado_de_TL',
		'$palabrasClave_TL',
		'$viejoArchivo',
		'$viejoArchivo',
		'$resumenTL',
		'$clave',
		'$idioma', 

		
			'$mailContacto_TL',
			'$NombreContacto',
			'$ApellidoContacto',
			'$telContacto_TL',
			'$InstContacto',
			'$paisContacto',
			'$ciudadContacto',
			'$will_sendContacto',
		
		
		
		'$viejoActualizacion','$premio','$quePremio'
		);";

mysql_query($sql, $con);

/*obtego el ultimo ingreso*/
$ultimoID = mysql_insert_id();


$i = 0;
//print_r($persona);
foreach ($persona as $u){

	if($u != ""){

		$sql = "SELECT * FROM personas_trabajos_libres WHERE ID_Personas = '$u';";
		$rs = mysql_query($sql, $con);
		while($row = mysql_fetch_array($rs)){

			/*tomo estos datos solo para el nombre del archivo*/
			if($i==0){
				$nombreAutor = $row["Nombre"];
				$apellidoAutor = $row["Apellidos"];
			}

			/*inserto los  id de los participantes*/
			
			$sql2= "INSERT INTO trabajos_libres_participantes (ID_trabajos_libres, ID_participante, lee) VALUES
					('$ultimoID','" . $row["ID_Personas"] . "','" . $lee[$i] . "');";
			mysql_query($sql2, $con);

		}
	}

	$i = $i + 1;
}


/*cambio nombre al archivo*/
$extensionArchivoArray = explode ("." , $nombreArchivo);
$extensionArchivo = array_pop($extensionArchivoArray);
$nombreArchivo1 = $numero_TL . "_" . $apellidoAutor . "_" . $nombreAutor ;
$nombreArchivo = normalizarString($nombreArchivo1). ".$extensionArchivo";


/* copio el archivo*/
if($_FILES["archivo_TL"]["tmp_name"]!=""){
	if(!copy($_FILES["archivo_TL"]["tmp_name"], "tl/$nombreArchivo")){
		echo "Ocurrio un error cuando se subia el archivo";
	}
}

if($_FILES["archivo_TL"]["tmp_name"]!=""){
/*alctualizo  el campo nombre de archivo*/
$sql = "UPDATE trabajos_libres SET archivo_tl = '$nombreArchivo' , archivo_trabajo_comleto = '$nombreArchivo'  WHERE ID = '$ultimoID' LIMIT 1;";
mysql_query($sql, $con);
}
/**/



$sqlM = "INSERT INTO Modificaciones (Tiempo,Cambio, Usuario) VALUES ";
if($idEliminar !=""){

	$sqlM .= "('" . date("d/m/Y  H:i")  . "','Se modifico el trabajo libre código $numero_TL' , '" .  $_SESSION["usuario"] . "');";

}else{

	$sqlM .= "('" . date("d/m/Y  H:i")  . "','Se creo el trabajo libre código $numero_TL ', '". $_SESSION["usuario"] . "');";

}
mysql_query($sqlM, $con);

echo "<script>\n";
if($idEliminar !=""){
echo "window.history.go(-2);\n";
}else{
echo "window.history.go(-1);\n";
}
echo "</script>\n";
header ("Location: altaTrabajosLibres.php");


?>
