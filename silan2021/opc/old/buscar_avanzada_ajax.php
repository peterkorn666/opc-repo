<?
include('inc/sesion.inc.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>
<body>
<?
include("conexion.php");
require("clases/trabajosLibres.php");
$trabajos = new trabajosLibre;
function remplazarPalabra($que_busca){	
	$que_busca = trim($que_busca);
	$que_busca = utf8_decode($que_busca);
	$que_busca = str_replace(":", "", $que_busca);
	$que_busca = str_replace("ñ", "n", $que_busca);
	$que_busca = str_replace("Ñ", "N", $que_busca);
	$que_busca = str_replace("á", "a" , $que_busca);
	$que_busca = str_replace("é", "e" , $que_busca);
	$que_busca = str_replace("í", "i" , $que_busca);
	$que_busca = str_replace("ó", "o" , $que_busca);
	$que_busca = str_replace("ú", "u" , $que_busca);
	$que_busca = str_replace("Á", "A" , $que_busca);
	$que_busca = str_replace("É", "E" , $que_busca);
	$que_busca = str_replace("Í", "I" , $que_busca);
	$que_busca = str_replace("Ó", "O" , $que_busca);
	$que_busca = str_replace("Ú", "U" , $que_busca);
	$que_busca = str_replace("à", "a" , $que_busca);
	$que_busca = str_replace("è", "e" , $que_busca);
	$que_busca = str_replace("ì", "i" , $que_busca);
	$que_busca = str_replace("ò", "o" , $que_busca);
	$que_busca = str_replace("ù", "u" , $que_busca);
	$que_busca = str_replace("ä", "a" , $que_busca);
	$que_busca = str_replace("ë", "e" , $que_busca);
	$que_busca = str_replace("ï", "i" , $que_busca);
	$que_busca = str_replace("ö", "o" , $que_busca);
	$que_busca = str_replace("ü", "u" , $que_busca);
	return  $que_busca;		
}
function remplazar($que_busca){	
	return  utf8_encode($que_busca);
}
$palabra_ = remplazarPalabra($_POST["palabra"]);
$dondeBusco_ = $_POST["dondeBusco"];
$comoMuestro_ = $_POST["comoMuestro"];
$arrayCalidades_ = split(",",$_POST["calidades"]);
$arrayActividades_ = split(",",remplazarPalabra($_POST["actividades"]));
$arrayPaises_ = split(",",remplazarPalabra($_POST["paises"]));
$arrayAreas_ = split(",",remplazarPalabra($_POST["areas"]));
$arraysCasillerosNuevo =  array();
$arrayIdeTodosNuevos = array();
$arrayPalabrasNuevo =  array();
$arrayCalidadesNuevo =  array();
$arrayActividadesNuevo =  array();
$arrayPaisesNuevo =  array();
$arrayAreasNuevo =  array();

if($palabra_ != ""){
	if("Ambos" == $dondeBusco_){
		$cons =  " Apellidos like '%$palabra_%' OR Nombre like '%$palabra_%' OR Titulo_de_actividad like '%$palabra_%' OR Titulo_de_trabajo like '%$palabra_%' ";		
	}else if("Participantes" == $dondeBusco_){
		$cons =  " Apellidos like '%$palabra_%' OR Nombre like '%$palabra_%' ";
	}else if("Titulos" == $dondeBusco_){
		$cons =  " Titulo_de_actividad like '%$palabra_%' OR Titulo_de_trabajo like '%$palabra_%' ";		
	}	 
	$sqlPal = "SELECT * FROM congreso WHERE " .$cons . " ORDER BY Dia_orden, Sala_orden, Hora_inicio, Orden_aparicion " ;
		$rsPal = mysql_query($sqlPal, $con);
		while($rowPal = mysql_fetch_array($rsPal)){
			array_push($arrayPalabrasNuevo, array($rowPal["Casillero"], $rowPal["ID"]));
			array_push($arrayIdeTodosNuevos, array($rowPal["Casillero"], $rowPal["ID"]));
		}
}
if(count($arrayCalidades_)>0){
	$definiORCal = 0;
	$sqlCal = " (";
	foreach($arrayCalidades_ as $calidad){
		if($calidad != ""){
			if($definiORCal == 1){
				$sqlCal .= " OR ";
			}
			$definiORCal = 1;
		
			$sqlCal .= "  En_calidad  = '$calidad' " ;
		}
	}
	$sqlCal .= ")";
	if($sqlCal==" ()"){
		$sqlCal = "";
	}else{
		$sqlCalidad = "SELECT * FROM congreso WHERE " .$sqlCal . " ORDER BY Dia_orden, Sala_orden, Hora_inicio, Orden_aparicion " ;
		$rsCalidad = mysql_query($sqlCalidad, $con);
		while($rowCalidad = mysql_fetch_array($rsCalidad)){
			array_push($arrayCalidadesNuevo, array($rowCalidad["Casillero"], $rowCalidad["ID"]));
			array_push($arrayIdeTodosNuevos, array($rowCalidad["Casillero"], $rowCalidad["ID"]));
		}
	}
}
if(count($arrayActividades_)>0){
	$definiORAct = 0;
	$sqlAct = " (";
	foreach($arrayActividades_ as $actividad){
		if($actividad != ""){
			if($definiORAct == 1){
				$sqlAct .= " OR ";
			}
			$definiORAct = 1;
		
			$sqlAct .= " Tipo_de_actividad  = '$actividad' " ;
		}
	}
	$sqlAct .= ")";
	if($sqlAct==" ()"){
		$sqlAct = "";
	}else{
		$sqlActividad = "SELECT * FROM congreso WHERE " .$sqlAct .  " ORDER BY Dia_orden, Sala_orden, Hora_inicio, Orden_aparicion " ;
		$rsActividad = mysql_query($sqlActividad, $con);
		while($rowActividad = mysql_fetch_array($rsActividad)){
			array_push($arrayActividadesNuevo, array($rowActividad["Casillero"], $rowActividad["ID"]));
			array_push($arrayIdeTodosNuevos, array($rowActividad["Casillero"], $rowActividad["ID"]));
		}
	}
}
if(count($arrayPaises_)>0){
	$sqlPais = " (";
	foreach($arrayPaises_ as $paises){
		if($paises != ""){
			$sqlPais .= " Pais  = '$paises' OR" ;
		}
	}
	$sqlPais .= ")";
	if($sqlPais==" ()"){
		$sqlPais = "";
	}else{
		$sqlPais = substr($sqlPais,0,-4);
		$sqlPais = $sqlPais.")";
		$sqlPa ="SELECT * FROM congreso  WHERE " .$sqlPais . " ORDER BY Dia_orden, Sala_orden, Hora_inicio, Orden_aparicion " ;
		$rsPa = mysql_query($sqlPa, $con);
		while($rowPa = mysql_fetch_array($rsPa)){
			array_push($arrayPaisesNuevo, array($rowPa["Casillero"], $rowPa["ID"]));
			array_push($arrayIdeTodosNuevos, array($rowPa["Casillero"], $rowPa["ID"]));
		}
	}
}
if(count($arrayAreas_)>0){
	$definiORArea = 0;
	$sqlArea = " (";
	foreach($arrayAreas_ as $area){
		if($area != ""){
			if($definiORArea == 1){
				$sqlArea .= " OR ";
			}
			$definiORArea = 1;
		
			$sqlArea .= " Area  = '$area' " ;
		}
	}
	$sqlArea .= ")";	
	if($sqlArea==" ()"){
		$sqlArea = "";
	}else{
		$sqlAre ="SELECT * FROM congreso WHERE " .$sqlArea . " ORDER BY Dia_orden, Sala_orden, Hora_inicio, Orden_aparicion " ;
		$rsAre = mysql_query($sqlAre, $con);
		while($rowAre = mysql_fetch_array($rsAre)){
			array_push($arrayAreasNuevo, array($rowAre["Casillero"], $rowAre["ID"]));
			array_push($arrayIdeTodosNuevos, array($rowAre["Casillero"], $rowAre["ID"]));
		}
	}
}
$CasilleroComun = Array();
 $Casilleros1=Array();
 for ($i=0;$i<count($arrayPalabrasNuevo);$i++) {
 	$Casilleros1[count($Casilleros1)]=$arrayPalabrasNuevo[$i][0];
 }
 $Casilleros2=Array();
 for ($i=0;$i<count($arrayCalidadesNuevo);$i++) {
 	$Casilleros2[count($Casilleros2)]=$arrayCalidadesNuevo[$i][0];
 }  
 $Casilleros3 = Array();
 for ($i=0;$i<count($arrayActividadesNuevo);$i++) {
 	$Casilleros3[count($Casilleros3)]=$arrayActividadesNuevo[$i][0];
 }
 $Casilleros4=Array();
 for ($i=0;$i<count($arrayPaisesNuevo);$i++) {
 	$Casilleros4[count($Casilleros4)]=$arrayPaisesNuevo[$i][0];
 }
 $Casilleros5=Array();
 for ($i=0;$i<count($arrayAreasNuevo);$i++) {
 	$Casilleros5[count($Casilleros5)]=$arrayAreasNuevo[$i][0];
 }
if(count($Casilleros1)!=0){
	$CasilleroComun = $Casilleros1;
}else if(count($Casilleros2)!=0){
	$CasilleroComun = $Casilleros2;
}else if(count($Casilleros3)!=0){
	$CasilleroComun = $Casilleros3;
}else if(count($Casilleros4)!=0){
	$CasilleroComun = $Casilleros4;
}else if(count($Casilleros5)!=0){
	$CasilleroComun = $Casilleros5;
}
if(count($Casilleros1)==0){
	$Casilleros1 = $CasilleroComun;
}
if(count($Casilleros2)==0){
	$Casilleros2 = $CasilleroComun;
}
if(count($Casilleros3)==0){
	$Casilleros3 = $CasilleroComun;
}
if(count($Casilleros4)==0){
	$Casilleros4 = $CasilleroComun;
}
if(count($Casilleros5)==0){
	$Casilleros5 = $CasilleroComun;
}
$arrayIdeUnicos = array();
$arrayIdeUnicos=array_intersect($Casilleros1,$Casilleros2,$Casilleros3,$Casilleros4,$Casilleros5);
$arrayIdeUnicos = array_unique($arrayIdeUnicos);
$arrayFinal = array();
foreach($arrayIdeUnicos as $i) {
		for ($e=0;$e<count($arrayIdeTodosNuevos);$e++) {
			if($i == $arrayIdeTodosNuevos[$e][0]){				
				array_push($arrayFinal, array($arrayIdeTodosNuevos[$e][0],$arrayIdeTodosNuevos[$e][1]));
			}
		}	
	}	
$IdesFinales1_=Array();
 for ($i=0;$i<count($arrayIdeTodosNuevos);$i++) {
 	$IdesFinales1_[count($IdesFinales1_)]=$arrayIdeTodosNuevos[$i][1];
 }
 $IdesFinales1_ = array_unique($IdesFinales1_);
sort($IdesFinales1_);

 $IdesFinales2_=Array();
 for ($i=0;$i<count($arrayFinal);$i++) {
 	$IdesFinales2_[count($IdesFinales2_)]=$arrayFinal[$i][1];
 }
  $IdesFinales2_ = array_unique($IdesFinales2_);
sort($IdesFinales2_);

$arrayIdeUnicosFinal = array();
$arrayIdeUnicosFinal=array_intersect($IdesFinales1_,$IdesFinales2_);
sort($arrayIdeUnicosFinal);


if(count($arrayIdeUnicosFinal)!=0){
	$definiORIdes0 = 0;
	foreach($arrayIdeUnicosFinal as $ides){
		if($ides != ""){
			if($definiORIdes0 == 1){
				$consulta .= " OR ";
			}
			$definiORIdes0 = 1;		
			$consulta .= " ID  = '$ides' " ;
			$i=$i+1;
		}
	}	
		$definiORIDES = 0;
		$sql = "SELECT * FROM congreso WHERE " .$consulta . " ORDER BY Dia_orden, Sala_orden, Hora_inicio, Orden_aparicion " ;
		$rs = mysql_query($sql,$con);
		while ($row = mysql_fetch_array($rs)){			
				if($definiORIDES == 1){
					$Ides .= " OR ";
					$casilla .= " OR ";
				}
				$definiORIDES = 1;
				$Ides .= " ID  = " . $row["ID"] ;
				$casilla .= " Casillero  = " . $row["Casillero"] ;
		}
	$ResultadoParcial = mysql_num_rows($rs); 

	if($ResultadoParcial!=0){
	
	echo '<table width="625px" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr>
            <td  class="textos"><a href="javascript:marcar(true)" class="linkAgregar">Marcar todos</a> / <a href="javascript:marcar(false)" class="linkAgregar">Desmarcar todos</a>              <div align="right"></div></td>
            <td  class="textos"><div align="right"><a href="HojaDeImpresion.php" target="_blank"><img src="./img/ico_imprimir.png"  border="0"></a></div></td>
  </tr>
</table>';
		if($comoMuestro_=="Individual"){
			$consulta2 = $Ides;
		}else{
			$consulta2 = $casilla;
		}
		
		$sql1 = "SELECT * FROM congreso WHERE " .$consulta2 . " ORDER BY Dia_orden, Sala_orden, Hora_inicio, Orden_aparicion " ;
		$_SESSION["sql1"] = $sql1;
		$rs = mysql_query($sql1,$con);
		while ($row = mysql_fetch_array($rs)){
				require("inc/programaBA.inc.php");				
		}
	}
}else{
	echo "No se han encontrado conicidencias.";
}
$_SESSION["paraImprimir"] = $imprimir;
?></body>
</html>