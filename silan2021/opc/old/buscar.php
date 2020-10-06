<?
//require("inc/sesion.inc.php");
session_start();
if (!isset($_SESSION["registrado"])){
	$_SESSION["registrado"]=false;
}
//include('inc/sesion.inc.php');
include('conexion.php');
require ("clases/class.Traductor.php");
include('cronoTraductor.php');
include("inc/validarVistas.inc.php");

require ("clases/trabajosLibres.php");
$trabajos = new trabajosLibre;

$traductor = new traductor();
$traductor->setIdioma($_GET["idioma"]);

$sePuedeImprimir=true;
$imprimir = "";

$CantActividad = 0;
$CantTL = 0;
$arrayCasilleroParticipantesTL = array();
$arrayCasillerosTL = array();
$unicosArraysCasillero_TL = array();
$arrayIDCongreso = array();
$arrayIDCongresoTL = array();
$unionArraysDistintos = array();
$unicosArraysDistintos = array();

?>
<meta charset="UTF-8">
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
	background-color: #FFFFCC;
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
#DIVCantActividad{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color:#333333;
	background-color: #FFFFCC;
	margin-left:10px;
	
}
</style>
<link href="estilos.css" rel="stylesheet" type="text/css">
<script src="js/menuEdicion.js"></script>
<script src="js/trabajos_libres.js"></script>
<body leftmargin="0" topmargin="0" bgproperties="fixed" marginwidth="0" marginheight="0">
<? include "inc/vinculos.inc.php";?>
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#FFFFFF">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php"; ?></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F0F0F0"><table width="770" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td >
         
		 <?
		 /*Armo el array d ela busquda*/
		 $que_busca = $_POST["buscar_"];
		 $que_busca = str_replace(":", " ", $que_busca);
		 $que_busca = str_replace(",", " ", $que_busca);
		 $que_busca = trim($que_busca);
		
		
		if($_SESSION["tipoUsu"]!=4){
			 $arrayBusqueda_ = explode(" ",  $que_busca);
		}else{
		 	$arrayBusqueda_[] = $que_busca;
		}
		
		 $arrayBusqueda = array_unique($arrayBusqueda_);
		 sort($arrayBusqueda);
		 if($arrayBusqueda[0] == ""){
		 	array_shift($arrayBusqueda);
		 }
		 /***************************/


		 if($que_busca == ""){
		 	
		 		 	
		 	
		 	if($_GET["id"]!=""){
		 		$sql = "SELECT * FROM personas Where ID_Personas=" . $_GET["id"] . " Limit 1;";
		 		$rs = mysql_query($sql,$con);
		 		while ($row = mysql_fetch_array($rs)){
		 			$quien = $row["Nombre"] . " " . $row["Apellidos"] ;	
		 			
		 			$_SESSION["que_busca"] = $quien; 
		 			
		 			echo "<div id='busqueda' >Su busqueda fue del autor o co-autor de trabajo libre: " .  remplazar($quien) . "<br><div id='DIVCantActividad'></div></div>";		
		 		}
		 		
		 	}
		 	
		 	
		 	if($_GET["id_tl"]!=""){
		 		$sql = "SELECT * FROM personas_trabajos_libres Where ID_Personas=" . $_GET["id_tl"] . " Limit 1;";
		 		$rs = mysql_query($sql,$con);
		 		while ($row = mysql_fetch_array($rs)){
		 			$quien = $row["Apellidos"] . ", " . $row["Nombre"] ;	
		 			
		 			$_SESSION["que_busca"] = $quien;
		 			
		 			echo "<div id='busqueda'>Su busqueda fue del autor o co-autor de trabajo libre: " .  remplazar($quien) . "<br><div id='DIVCantActividad'></div></div>";		
		 		}
		 		
		 	}
		 		
		 	
		 	/*Si la busqueda es vacia, y si el get no tiene nada*/
			if($_GET["idioma"]=="ing"){
				if($_GET["id"]=="" && $_GET["id_tl"]==""){
					echo "<p id='todo'>Your search was empty, so we will return the entire conference program extended</p>";
				}	
			}else{
				if($_GET["id"]=="" && $_GET["id_tl"]==""){
					echo "<p id='todo'>Su busqueda fue vacía por lo que se le devolvera todo el programa extendido del congreso</p>";
				}
			}

		 }else{

		 	echo "<div id='busqueda' >Su busqueda fue de: " .  remplazar($que_busca) . "<br> <div id='DIVCantActividad'></div></div>";

		 }




		 /**FUNCION QWUE REMLAZA EL TEXTO*****************************************************************/

		 function remplazar($cual){

		 	if($_GET["id_tl"]=="" && $_GET["id"]==""){
		 		$que_busca = $_POST["buscar_"];
		 		$que_busca = str_replace(":", " ", $que_busca);
				$que_busca = str_replace(",", " ", $que_busca);
		 	}else{
		 		$que_busca = $_SESSION["que_busca"];
		 		$que_busca = str_replace(":", " ", $que_busca);
				$que_busca = str_replace(",", " ", $que_busca);
		 	}
		 	
			
		 	$arrayBusqueda = explode(" ",  $que_busca);

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

			return $resultado;
		 	//return  utf8_encode($resultado) ;


		 }

		 /*******************************************************/
		 /*esepcion si la busqueda es vacia le meto un elemento al arraay para que debuelva todo el congreos*/
		 if(count($arrayBusqueda)==0){
		 	array_push($arrayBusqueda, "");
		 }
		 //**********************************

		 /*busqueda en la tabla congreso*/
		 $arrayIDCongreso = array();

		 if($_GET["id_tl"]==""){
			 
			 if($_SESSION["tipoUsu"]==4){
				 $sql2 = "Dia_orden=10 and";
			 }
			if(!$_SESSION["registrado"]){
				$sql2 = "Dia_orden<>'5' and Dia_orden<>'1' and";
			}
			
		 	$sql =  "SELECT * FROM congreso WHERE $sql2";
		 	$bucle=0;
		 	foreach ($arrayBusqueda as $i){
				$i = trim($i);
		 		if($bucle>0){
		 			$sql .= " or (";
		 		}else{
		 			$sql .= " (";
		 		}
				if($_SESSION["tipoUsu"]!=4){
		 			$sql .= "    Dia like '%$i%' ";
		 			$sql .= " or Sala like '%$i%' ";
				}else{
					$sql .= " Sala like '%$i%' ";
				}
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

		 	if($_GET["id"]!=""){

		 		$sql .= "and ID_persona=".$_GET["id"];

		 	}
			$sql .= " ORDER BY Dia_orden ASC, Hora_inicio ASC,  seExpande  DESC;";
			//echo $sql;
		 	$rs = mysql_query($sql,$con) or die(mysql_error()."#317");
			$casillero = "";
		 	while ($row = mysql_fetch_array($rs)){
		 		array_push($arrayIDCongreso, $row["ID"]);
				if(($row["seExpande"]=="0")&&($dia == $row["Dia_orden"])&&($Hora == $row["Hora_inicio"])){
				}else{
					if($casillero == $row["Casillero"]){
						$CantActividad = $CantActividad+1;
					}
				}
				$dia = $row["Dia_orden"];
				$Hora = $row["Hora_inicio"];
				$casillero = $row["Casillero"];
		 	}
		 }

//echo $sql;
		 if($_GET["id"]==""){
		 	/*busqueda en TL*************************************************************/
		 	/****************************************************************************/


		 	/*primero busco las coincicdencias en la tabla personas TL*/
		 	$sql2 =  "SELECT ID_Personas FROM personas_trabajos_libres WHERE ";
		 	$bucle2 = 0;
		 	$arrayPersonasTL = array();
			$qitl = array();
		 	foreach ($arrayBusqueda as $u){
				
				//Check if its a instutiton
		 		$sqlITL = mysql_query("SELECT * FROM instituciones WHERE Institucion LIKE '%".safes($u)."%'",$con) or die(mysql_error()."#347");
				if(mysql_num_rows($sqlITL)==1)
				{
					$rowITL = mysql_fetch_array($sqlITL);
					$qitl[] = $rowITL["ID_Instituciones"];
				}else if(mysql_num_rows($sqlITL)>1)
				{
					
					while($rowITL = mysql_fetch_array($sqlITL))
						$qitl[] = $rowITL["ID_Instituciones"];
				}
		 		//Check if its a country
		 		$sqlPTL = mysql_query("SELECT * FROM paises WHERE Pais LIKE '%".safes($u)."%'",$con) or die(mysql_error()."#359");
				if(mysql_num_rows($sqlPTL)==1)
				{
					$rowPTL = mysql_fetch_array($sqlPTL);
					$qitl[] = $rowPTL["ID_Paises"];
				}else if(mysql_num_rows($sqlPTL)>1)
				{
					
					while($rowPTL = mysql_fetch_array($sqlPTL))
						$qitl[] = $rowPTL["ID_Paises"];
				}
				
				if($bucle2>0){
					$sql2 .= " or (";
				}else{
					$sql2 .= " (";
				}
				
				$sql2 .= " Profesion like '%$u%' ";
				$sql2 .= " or Nombre like '%$u%' ";
				$sql2 .= " or Apellidos like '%$u%' ";
				$sql2 .= " or Mail like '%$u%' ";
				$sql2 .= " or Cargos like '%$u%'";
				
				if(count($qitl)>0)
				{
					
					//var_dump($qitl);
					foreach($qitl as $key => $ui)
					{
						$sql2 .= " or Pais like '%$ui%' ";
						$sql2 .= " or Institucion like '%$ui%' ";
					}
				}
				
				

				
				
				
				$sql2 .= ")";
		 		$bucle2 = $bucle2 + 1;
		 	}


			//var_dump($sql2);
			$rs2 = mysql_query($sql2,$con) or die(mysql_error()."#395");
			$canPersonasTL = mysql_num_rows($rs2);

			while ($row2 = mysql_fetch_array($rs2)){
				if($_GET["id_tl"]==""){
					array_push($arrayPersonasTL, $row2["ID_Personas"]);
				}
			}


		 	/*si la busqueda viene por el listado de */
		 	// $arrayPersonasTL = array();
		 	if($_GET["id_tl"]!=""){
		 		array_push($arrayPersonasTL, $_GET["id_tl"]);
				
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

			/*lo inicializo afuera por las dudas*/
			$arrayCasilleroParticipantesTL = array();

		 	/*Si existen los participante tomo el casillero y el ID de trabajo libre*/
		 	if($canParticipantesTL>0){
		 		
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
					$CantTL = $CantTL + 1;

		 		}

		 	}


		 	$arrayCasillerosTL = array();
		 	$arrayIDTL = array();
		 	$sql5 =  "SELECT * FROM trabajos_libres WHERE ID_casillero<>0  ";
		 	$bucle5=0;
		 	foreach ($arrayBusqueda as $i){
				if($bucle5==0){
					$sql5 .= " and ";
				}
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
		 		$sql5 .= " or contacto_mail like '%$i%' ";
		 		$sql5 .= " or resumen like '%$i%' ";
				$sql5 .= " or resumen_en like '%$i%' ";
		 		$sql5 .= " or idioma like '%$i%' ";
				
		 		$sql5 .= " or palabrasClave like '%$i%' )";
		 		
				//echo $sql5;
		 		$bucle5= $bucle5 + 1;

		 	}
		 	$rs5 = mysql_query($sql5,$con) or die(mysql_error()."#513");
		 	while ($row5 = @mysql_fetch_array($rs5)){
		 		if($_GET["id_tl"]==""){
		 			array_push($arrayCasillerosTL,  $row5["ID_casillero"]);
		 			array_push($arrayIDTL,  $row5["ID"]);
						///PARA QUE SUME SI ES UN DATO DEL TRABAJO		
						if($TlAnterior != $row5["ID"]){									
						$CantTL = $CantTL + 1;										
						$TlAnterior = $row5["ID"];
						}							
												
								
		 		}
		 	}

		 }
		 //$arrayParticipantesTL = id de trabajos libres donde hubo cinciudencias en las personas
		 //$arrayCasilleroParticipantesTL = ID_casillero donde el id de trabajo libre es $arrayParticipantesTL

		 //$arrayCasillerosTL = casilleros donde se encontro la busqueda en trabajos_libres
		 //$arrayIDTL = ID de trabajo libre donde se encontro la busqueda en trabajos_libres


 //Se puso condiciones de if porque puede que alguno de los arrays a unir estén vacíos y en el dreamhost muestra los warnings
		 if(($arrayParticipantesTL)&&($arrayIDTL)){	 
			 $unionArraysID_TL = array_merge($arrayParticipantesTL, $arrayIDTL);
		 }elseif($arrayIDTL){
			 $unionArraysID_TL = $arrayIDTL;
		 }elseif($arrayParticipantesTL){
			 $unionArraysID_TL = $arrayParticipantesTL;
		 }
		 if(count($unionArraysID_TL)>0){
			 $unicosArraysID_TL = array_unique($unionArraysID_TL);
		 	sort($unicosArraysID_TL);
		 }

		 if($unicosArraysID_TL[0] == ""){
			 if(count($unicosArraysID_TL)>0){
		 		array_shift($unicosArraysID_TL);
			 }
		 }

		 /*uno los arrays de casiillero de trabqjo libre que deberian mostrarce*/
		 $unionArraysCasillero_TL  = array_merge($arrayCasilleroParticipantesTL, $arrayCasillerosTL);
		 $unicosArraysCasillero_TL = array_unique($unionArraysCasillero_TL);
		 /*ahora me fijo el id de Casillero en la tabla congreso donde el campo trabajo libre es 1 y creo otro array para luego uniro con $arrayIDCongreso*/

		 if(count($unicosArraysCasillero_TL)>0){
		 	$arrayIDCongresoTL = Array();
		 	foreach($unicosArraysCasillero_TL as $u){
				if($_SESSION["tipoUsu"]==4){
					$sql3421321 = "Dia_orden=10 and ";
				}
		 		$sql7 =  "SELECT ID,Casillero FROM congreso WHERE $sql3421321 Casillero='$u' and Trabajo_libre='1';";
		 		$rs7 = mysql_query($sql7,$con);
		 		while ($row7 = mysql_fetch_array($rs7)){

		 			array_push($arrayIDCongresoTL, $row7["ID"]);
						////AGREGO LOS CASILLERO QUE TIENEN TRABAJOS LIBRES									
						if($casilleroAnterior7 != $row7["Casillero"]){									
						$CantActividad = $CantActividad +1 ;									
						$casilleroAnterior7 = $row7["Casillero"];
						}				
			
		 		}
		 	}
		 }



		 $unionArraysDistintos = array_merge($arrayIDCongreso, $arrayIDCongresoTL);
		 $unicosArraysDistintos = array_unique($unionArraysDistintos);


		 if(count($unicosArraysDistintos)>0){
			 if(!$_SESSION["registrado"]){
				 $dvisible = "Dia_orden<>10 AND";
			 }
//
		 	$sql6 = "SELECT * FROM congreso WHERE $dvisible ";
		 	$bucle6 = 0;
			$sql6 .= "(";
		 	foreach ($unionArraysDistintos as $i){

		 		if($bucle6>0){
		 			$sql6 .= " OR ";
		 		}

		 		$sql6 .= " ID = '$i'";
		 		$bucle6 = $bucle6 + 1;

		 	}
			$sql6 .= ")";
		 	$sql6 .= " ORDER by Casillero, Orden_aparicion ASC;";

		 	$rs = mysql_query($sql6,$con);
			$cantProgram = mysql_num_rows($rs);
		 	while ($row = mysql_fetch_array($rs)){
			
		 		//require("inc/programa.inc.php") ;
				$_SESSION["buscar"] = true;
				require("inc/programaNuevo.inc.php") ;
			
			  
		 	}
			///METO EN EL DIV LAS COINCIDENCIAS
			if($cantProgram>0){
				if ($CantActividad!=0){
						$Actividades = "Se han encontrado coincidencias en [ ". $CantActividad ." ] Actividades.<br>";
					}else{
						$Actividades="";
					}
				
				if ($CantTL!=0){
					/*$TLS = "Se han encontrado coincidencias en [ ". $CantTL ." ] Trabajos Libres.";
					echo "<script  language='javascript' type='text/javascript'>
	DIVCantActividad.innerHTML ='". $Actividades . $TLS ."'</script>";*/
				}else{
					$TLS="";
				}
			}else{
				echo "<div id='resultado0'>No se encontraron resultados para su busqueda</div>";
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

if(!isset($_SESSION["LocalizadoBuscador"])){
	
  $sql = "SELECT Buscador FROM estadisticas LIMIT 1;";
  $rs = mysql_query($sql,$con);
  while ($row = mysql_fetch_array($rs)){
  	$ultimoValor = $row["Buscador"];
  	
  }
  
  $nuevoValor	= $ultimoValor + 1;
  
  $sql1 = "UPDATE estadisticas SET Buscador= $nuevoValor, Tiempo = '" . date("d/m/Y  H:i") . "' LIMIT 1 ;";
  mysql_query($sql1,$con);
  
  $_SESSION["LocalizadoBuscador"]=true;
}
?>
