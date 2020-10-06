<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");

if (!isset($_SESSION["registrado"])){
	$_SESSION["registrado"]=false;
}
include('conexion.php');
include("inc/validarVistas.inc.php");

require ("clases/trabajosLibres.php");
$trabajos = new trabajosLibre;

$sePuedeImprimir=true;
$imprimir = "";

?>
<style>
.link {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	text-decoration: none;
	color:#6600CC;
}
.link:hover {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	text-decoration: none;
	color:#0000FF;
}
.pais{
font-family:Arial, Helvetica, sans-serif;
color:#000033;
font-size:11px;
text-decoration:none;
}
#busqueda{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	font-weight: bold;
	color: #990000;
	margin: 10px;
	background-color: #FFFFFF;
	padding: 5px;
	border: 1px solid #000000;
}
#resultado0{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	font-weight: bold;
	color: #FF0000;
	margin: 10px;
	text-align: center;
}
#todo{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	margin: 10px;
	background-color: #FFFFCC;
	text-align: center;
	padding: 5px;
	border: 1px solid #000000;
}
</style>
<link href="estilos.css" rel="stylesheet" type="text/css">
<script src="js/menuEdicion.js"></script>
<script src="js/trabajos_libres.js"></script>
<body leftmargin="0" topmargin="0" bgproperties="fixed" marginwidth="0" marginheight="0"">
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#FFFFFF">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php"; ?></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F0F0F0"><table width="770" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>
         
		 <?
		 /*fijo algunos coilores de fondo para la busqueda*/

		 $id = $_GET["id"];

	
		 if($que_busca == ""){

		 	echo "<p id='todo'>Su busqueda fue vacía por lo que se le devolvera todo el programa extendido del congreso</p>";

		 }else{

		 	echo "<div id='busqueda'>Su busqueda fue de: " .  remplazar($id) . "</div>";

		 }




		 /**FUNCION QWUE REMLAZA EL TEXTO*****************************************************************/

		 function remplazar($cual){


		 	$que_busca = $_POST["buscar_"];
		 	$arrayBusqueda = split(" ",  $que_busca);

		 	$enBucle = 0;


		 	$resultado= $cual;

		 	foreach ($arrayBusqueda as $busq){



		 		switch ($enBucle){

		 			case 0:
		 			$caracterEspecial = "Š";
		 			break;

		 			case 1:
		 			$caracterEspecial = "¥";
		 			break;

		 			case 2:
		 			$caracterEspecial = "Œ";
		 			break;

		 			case 3:
		 			$caracterEspecial = "ø";
		 			break;

		 			case 4:
		 			$caracterEspecial = "þ";
		 			break;
		 		}

		 		$resultado = str_replace  ($busq , $caracterEspecial . $busq . "œ", $resultado);

		 		if($enBucle<4){
		 			$enBucle = $enBucle + 1;
		 		}else{
		 			$enBucle = 0;
		 		}

		 	}


		 	$resultado = str_replace("œ",  "</span>" , $resultado);
		 	$resultado = str_replace("Š",  "<span class='b_0'>" , $resultado);
		 	$resultado = str_replace("¥",  "<span class='b_1'>" , $resultado);
		 	$resultado = str_replace("Œ",  "<span class='b_2'>" , $resultado);
		 	$resultado = str_replace("ø",  "<span class='b_3'>" , $resultado);
		 	$resultado = str_replace("þ",  "<span class='b_4'>" , $resultado);

		 	return  $resultado ;


		 }

		 /*******************************************************/
		/*esepcion si la busqueda es vacia le meto un elemento al arraay para que debuelva todo el congreos*/
		if(count($arrayBusqueda)==0){
			array_push($arrayBusqueda, "");
		}
		//**********************************

		 /*busqueda en la tabla congreso*/
		 $arrayIDCongreso = array();
		 $sql =  "SELECT ID FROM congreso WHERE ";
		 $bucle=0;
		 foreach ($arrayBusqueda as $i){

		 	if($bucle>0){
		 		$sql .= " or (";
		 	}else{
		 		$sql .= " (";
		 	}

		 	$sql .= "    Dia like '%$i%' ";
		 	$sql .= " or Sala like '%$i%' ";
		 	$sql .= " or Hora_inicio like '%$i%' ";
		 	$sql .= " or Hora_fin like '%$i%' ";
		 	$sql .= " or Area like '%$i%' ";
		 	$sql .= " or Tematicas like '%$i%' ";
		 	$sql .= " or Tipo_de_actividad like '%$i%' ";
		 	$sql .= " or Titulo_de_actividad like '%$i%' ";
		 	$sql .= " or Titulo_de_trabajo like '%$i%' ";
		 	$sql .= " or En_calidad like '%$i%' ";
		 	$sql .= " or Profesion like '%$i%' ";
		 	$sql .= " or Nombre like '%$i%' ";
		 	$sql .= " or Apellidos like '%$i%' ";
		 	$sql .= " or Cargos like '%$i%' ";
		 	$sql .= " or Institucion like '%$i%' ";
		 	$sql .= " or Pais like '%$i%' ";
		 	$sql .= " or Mail like '%$i%' )";

		 	$bucle= $bucle + 1;

		 }

		 $rs = mysql_query($sql,$con);
		 while ($row = mysql_fetch_array($rs)){
		 	array_push($arrayIDCongreso, $row["ID"]);

		 }



		 /*busqueda en TL*************************************************************/
		 /****************************************************************************/


		 /*primero busco las coincicdencias en la tabla personas TL*/
		 $sql2 =  "SELECT ID_Personas FROM personas_trabajos_libres WHERE ";
		 $bucle2 = 0;
		 $arrayPersonasTL = array();
		 foreach ($arrayBusqueda as $u){

		 	if($bucle2>0){
		 		$sql2 .= " or (";
		 	}else{
		 		$sql2 .= " (";
		 	}

		 	$sql2 .= "    Profesion like '%$u%' ";
		 	$sql2 .= " or Nombre like '%$u%' ";
		 	$sql2 .= " or Apellidos like '%$u%' ";
		 	$sql2 .= " or Pais like '%$u%' ";
		 	$sql2 .= " or Institucion like '%$u%' ";
		 	$sql2 .= " or Mail like '%$u%' ";
		 	$sql2 .= " or Cargos like '%$u%')";

		 	$bucle2 = $bucle2 + 1;
		 }

		 $rs2 = mysql_query($sql2,$con);
		 $canPersonasTL = mysql_num_rows($rs2);
		 while ($row2 = mysql_fetch_array($rs2)){
		 	array_push($arrayPersonasTL, $row2["ID_Personas"]);
		 }




		 /*Veo si ecxisten estas personas en la tabla tl participantes*/
		 if($canPersonasTL>0){
		 	$arrayParticipantesTL = array();
		 	$sql3 = "SELECT DISTINCT ID_trabajos_libres FROM trabajos_libres_participantes WHERE ";
		 	$bucle3 = 0;

		 	foreach ($arrayPersonasTL as $i){

		 		if($bucle3>0){
		 			$sql3 .= " OR ";
		 		}

		 		$sql3 .= " ID_participante=$i";
		 		$bucle3 = $bucle3 + 1;
		 	}

		 	$rs3 = mysql_query($sql3,$con);

		 	$canParticipantesTL = mysql_num_rows($rs3);
		 	while ($row3 = mysql_fetch_array($rs3)){
		 		array_push($arrayParticipantesTL, $row3["ID_trabajos_libres"]);

		 	}

		 }



		 /*Si existen los participante tomo el casillero y el ID de trabajo libre*/
		 if($canParticipantesTL>0){
		 	$arrayCasilleroParticipantesTL = array();
		 	$sql4 = "SELECT ID_casillero, ID FROM trabajos_libres WHERE ID_casillero<>0 and (";
		 	$bucle4 = 0;
		 	foreach ($arrayParticipantesTL as $i){

		 		if($bucle4>0){
		 			$sql4 .= " OR ";
		 		}

		 		$sql4 .= " ID=$i";
		 		$bucle4 = $bucle4 + 1;

		 	}
		 	$sql4 .= ");";

		 	$rs4 = mysql_query($sql4,$con);
		 	while ($row4 = mysql_fetch_array($rs4)){
		 		array_push($arrayCasilleroParticipantesTL, $row4["ID_casillero"]);

		 	}

		 }


		 $arrayCasillerosTL = array();
		 $arrayIDTL = array();
		 $sql5 =  "SELECT ID_casillero, ID FROM trabajos_libres WHERE ID_casillero<>0 and ";
		 $bucle5=0;
		 foreach ($arrayBusqueda as $i){

		 	if($bucle5>0){
		 		$sql5 .= " OR (";
		 	}else{
		 		$sql5 .= " (";
		 	}


		 	$sql5 .= "    Hora_inicio like '%$i%' ";
		 	$sql5 .= " or Hora_fin like '%$i%' ";
		 	$sql5 .= " or numero_tl like '%$i%' ";
		 	$sql5 .= " or titulo_tl like '%$i%' ";
		 	$sql5 .= " or area_tl like '%$i%' ";
		 	$sql5 .= " or tipo_tl like '%$i%' ";
		 	$sql5 .= " or mailContacto_tl like '%$i%' ";
		 	$sql5 .= " or resumen like '%$i%' ";
		 	$sql5 .= " or palabrasClave like '%$i%' )";

		 	$bucle5= $bucle5 + 1;

		 }

		 $rs5 = mysql_query($sql5,$con);
		 while ($row5 = mysql_fetch_array($rs5)){
		 	array_push($arrayCasillerosTL,  $row5["ID_casillero"]);
		 	array_push($arrayIDTL,  $row5["ID"]);
		 }

		 //$arrayParticipantesTL = id de trabajos libres donde hubo cinciudencias en las personas
		 //$arrayCasilleroParticipantesTL = ID_casillero donde el id de trabajo libre es $arrayParticipantesTL

		 //$arrayCasillerosTL = casilleros donde se encontro la busqueda en trabajos_libres
		 //$arrayIDTL = ID de trabajo libre donde se encontro la busqueda en trabajos_libres


		 /*uno los arrays DE ID de trabajos libres que deberian mostrarce*/
		 $unionArraysID_TL = array_merge($arrayParticipantesTL, $arrayIDTL);
		 $unicosArraysID_TL = array_unique($unionArraysID_TL);
		 sort($unicosArraysID_TL);

		 if($unicosArraysID_TL[0] == ""){
		 	array_shift($unicosArraysID_TL);
		 }


		 /*uno los arrays de casiillero de trabqjo libre que deberian mostrarce*/
		 $unionArraysCasillero_TL  = array_merge($arrayCasilleroParticipantesTL, $arrayCasillerosTL);
		 $unicosArraysCasillero_TL = array_unique($unionArraysCasillero_TL);
		 /*ahora me fijo el id de Casillero en la tabla congreso donde el campo trabajo libre es 1 y creo otro array para luego uniro con $arrayIDCongreso*/

		 if(count($unicosArraysCasillero_TL)>0){
		 	$arrayIDCongresoTL = Array();
		 	foreach($unicosArraysCasillero_TL as $u){

		 		$sql7 =  "SELECT ID FROM congreso WHERE Casillero='$u' and Trabajo_libre='1';";
		 		$rs7 = mysql_query($sql7,$con);
		 		while ($row7 = mysql_fetch_array($rs7)){
					
		 			array_push($arrayIDCongresoTL, $row7["ID"]);
		 			
		 		}
		 	}
		 }

		 
		 
		 $unionArraysDistintos = array_merge($arrayIDCongreso, $arrayIDCongresoTL);
		 $unicosArraysDistintos = array_unique($unionArraysDistintos);


		 if(count($unicosArraysDistintos)>0){

		 	$sql6 = "SELECT * FROM congreso WHERE ";
		 	$bucle6 = 0;

		 	foreach ($unionArraysDistintos as $i){

		 		if($bucle6>0){
		 			$sql6 .= " OR ";
		 		}

		 		$sql6 .= " ID = '$i'";
		 		$bucle6 = $bucle6 + 1;

		 	}
		 	$sql6 .= " ORDER by Casillero, Orden_aparicion ASC;";

		 	$rs = mysql_query($sql6,$con);




		 	while ($row = mysql_fetch_array($rs)){


		 		require("inc/programa.inc.php") ;


		 	}


		 }else{

		 	echo "<div id='resultado0'>No se encontraron resultados para su busqueda</div>";
		 }

	?>
	</td>
        </tr>
      </table>
    </tr>
</table>

<?
$_SESSION["paraImprimir"]=$imprimir;
/*
if(!isset($_SESSION["LocalizadoPrograma"])){

$sql = "SELECT Programa FROM estadisticas LIMIT 1;";
$rs = mysql_query($sql,$con);
while ($row = mysql_fetch_array($rs)){
$ultimoValor = $row["Programa"];

}

$nuevoValor	= $ultimoValor + 1;

$sql1 = "UPDATE estadisticas SET Programa= $nuevoValor, Tiempo = '" . date("d/m/Y  H:i") . "' LIMIT 1 ;";
mysql_query($sql1,$con);

$_SESSION["LocalizadoPrograma"]=true;
}*/
?>