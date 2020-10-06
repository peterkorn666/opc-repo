<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");
include "envioMail_Config.php";

$cong = "[$congreso]";

$pass=0;
include "conexion.php";

function limpiar($campo){
	$campo = str_replace("= ", "", $campo);
	$campo = str_replace("' ", "", $campo);
	$campo = str_replace(", ", "", $campo);
	$campo = str_replace(". ", "", $campo);
	$campo = str_replace('" ', '', $campo);
	$campo = str_replace("AND ", "", $campo);
	$campo = str_replace("and ", "", $campo);
	$campo = str_replace("OR ", "", $campo);
	$campo = str_replace("or ", "", $campo);
	$campo = str_replace("DROP ", "", $campo);
	$campo = str_replace("drop ", "", $campo);
	$campo = str_replace("TRUNCATE ", "", $campo);
	$campo = str_replace("truncate ", "", $campo);
	$campo = str_replace("TRUNCATE ", "", $campo);
	$campo = str_replace("truncate ", "", $campo);
	$campo = str_replace("DELETE ", "", $campo);
	$campo = str_replace("delete ", "", $campo);
	$campo = str_replace("INSERT ", "", $campo);
	$campo = str_replace("insert ", "", $campo);
	$campo = str_replace("UPDATE ", "", $campo);
	$campo = str_replace("update ", "", $campo);
	$campo = str_replace(" " , "", $campo);
	return $campo;
}

$sql = "SELECT * FROM claves WHERE usuario='" . limpiar($_POST["usuario"]) ."' and clave='" . limpiar($_POST["clave"]) . "';";

//echo $sql;
//exit();
$rs = mysql_query($sql,$con);

	while ($row = mysql_fetch_array($rs)){
			$pass=1;

			$_SESSION["registrado"] = true;
			$_SESSION["usuario"] = $_POST["usuario"];
			$_SESSION["tipoUsu"] = $row["tipoUsuario"];

	     	$headers = "From:gegamultimedios@gmail.com\nReply-To:gegamultimedios@gmail.com\n";
			$headers .= "X-Mailer:PHP/".phpversion()."\n";
			$headers .= "Mime-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$headers .= "Return-Path:gegamultimedios@gmail.com\r\n";


			mail("gegamultimedios@gmail.com", "$cong [".$_SESSION["usuario"]."] [".date("G:i - d/m/y")."]",  "", $headers);
			if($_SESSION["tipoUsu"]==2){
				header ("Location:cronograma.php?dia_=1");
			}else if($_SESSION["tipoUsu"]==4){
				header ("Location: programaExtendido.php");
			}else{
				header ("Location: seleccionar_panel_simple.php");
			}

}

if ($pass==0){


	if(!isset($_SESSION["intentos"])|| $_SESSION["intentos"] == 0){
		$_SESSION["intentos"] = 0;
		$_SESSION["intentosArray"] = array();
	}

	$_SESSION["intentos"] = $_SESSION["intentos"] + 1;

	array_push($_SESSION["intentosArray"] , array($_POST["usuario"], $_POST["clave"]));

	if($_SESSION["intentos"]>=3){

			$_SESSION["intentos"] = 0;

	}

	header ("Location:login.php?pass=0");
}
?>