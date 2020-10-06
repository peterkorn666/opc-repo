<?
require("inc/sesion.inc.php");
//session_start();
if (!isset($_SESSION["registrado"])){
	$_SESSION["registrado"]=false;
}
$dir = dirname(__FILE__);
include $dir.'/replacePngTags.php';


$tit_act_sin_hora = "Actividad sin horarios";
$estoyEnCrono = "siLoEstoy";

$sePuedeImprimir=true;

include('conexion.php');
include('envioMail_Config.php');
require ("clases/class.Traductor.php");

$size = GetImageSize($dirBanner);
$altura=$size[1]; 
if(@ereg("MSIE", $_SERVER["HTTP_USER_AGENT"])){
	$suma = 120;
}else{
	if($_SESSION["tipoUsu"]!=4){
		$suma =40;
	}else{
		$suma = 10;
	}
}

function wordlimit($string, $length = 50, $ellipsis = "...")
{
    $words = explode(' ', $string);
    if (count($words) > $length)
    {
            return implode(' ', array_slice($words, 0, $length)) ." ". $ellipsis;
    }
    else
    {
            return $string;
    }
}

$altoAbsoluto = $altura+$suma;

$traductor = new traductor();
$traductor->setIdioma($_GET["idioma"]);

$sqla = "SELECT AltoDeCrono, AltoDeCronoImp FROM config;";
$rsa = mysql_query($sqla, $con);
while ($rowa = mysql_fetch_array($rsa)){
	$alto_po_carga_horaria = 17;
	$alto_carga_horaria_Imprimir=$rowa["AltoDeCronoImp"];
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link href="estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
#Detalles{
	background-color:#CCCCFF;
	color:#000000;
	width: 630px;    	
	margin:0 auto 0 auto;
	border: 2px solid #CCC;    	
	padding: 0 20px 0 20px;  
	margin: 1px;
	padding: 1px;
	height: 15px;
	width: 630px;
	border: 1px solid #6633FF
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 11 px;
	font-weight: bold;
	font-style: italic;
	text-align: center;
	position: absolute; 
	/*bottom: 0; */
	margin: 0 auto;

	 top: expression( ( -0 - Detalles.offsetHeight + ( document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight ) + ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ) ) + 'px' );


left: expression( (  ( ignoreMe2 = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft ) ) +( ( document.body.offsetWidth - 630)/2 ) + 'px' );
}


body > #Detalles { text-align: center; position:fixed; top:100; left:100;  }


#x{	
	
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 10 px;
	font-weight: bold;
	text-align: center;
	text-decoration:none;
	color:#000066;
}
#x:hover{
font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 10 px;
	font-weight: bold;
	text-align: center;
	text-decoration:none;
	color:#FF0000;
}


.Estilo1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: italic;
	font-weight: bold;
	color:#990000;
}
#ventanaCrono1 {
	position:absolute;	left:320px;	margin-left:-100px;	top:102px;	width:400px;	height:400px;	
	/*border:solid 2px #000000;*/
	/*background:#FFFFFF;*/
}
#DivContenidoCasilleroGlobo{
width:500px;
height:241px;
overflow:auto;
}
#DivEdicionCasilleroglobo{
height:16px;
width:500px;
font-family:Arial, Helvetica, sans-serif;
font-size:12px;

}
-->
</style>

<script language="JavaScript">

function cerrarDetalles(){
document.getElementById('Detalles').style.visibility='hidden';
}

var activarCasillero = 1;

function mOvr(src,clrOver) {
	if (!src.contains(event.fromElement)) {
		src.style.cursor = 'pointer';
		src.bgColor = clrOver;
	}
}

function mOut(src,clrIn) {
	if (!src.contains(event.toElement)) {
		src.style.cursor = 'default';
		src.bgColor = clrIn;
	}
}

function mClk(src) {
	if(activarCasillero==1){
	//	document.location.href = src;
	}
}


function sobreCasillero(cual){
	if(activarCasillero==1){
		document.getElementById(cual).style.background= "#ffffff";
		document.getElementById(cual).style.cursor = 'pointer';
	}
	
 activarCasillero = 1;
}

function fueraCasillero(cual, col){
	
	if(col.substring(0,1) == "#"){
			document.getElementById(cual).style.background= col;
			
	}else{
			document.getElementById(cual).style.background = "url('img/patrones/"+col+"')";
	}
	
}
function activ(){
	activarCasillero = 0;
}
function desactiv(){
	activarCasillero = 1;
}

</script>
<script language="javascript" type="text/javascript" src="js/ajax.js"></script>
<script src="js/ajax.js"></script>
<script src="js/menuEdicion.js"></script>
<script src="js/drag_drop.js"></script>
<?

$sql_chico = "SELECT Dia_orden FROM congreso ORDER BY Dia_orden DESC";
$rs_chico = mysql_query($sql_chico, $con);
while($row_chico = mysql_fetch_array($rs_chico)){
	$primero = $row_chico["Dia_orden"];
}


$dia_ = $_GET["dia_"];
$sala_ = $_GET["sala_"];






?>
<body   leftmargin="0" topmargin="0" bgproperties="fixed" marginwidth="0" marginheight="0" style="background-color:#F2F2F2;">
<div align="left"><img src="imagenes/banner_opc.jpg" width="900" height="111"></div>
<? 


$sqlD = "SELECT * FROM dias ORDER BY Dia_orden";
$rsD = mysql_query($sqlD, $con);
$po = 0;


$solo_primera = 1;


		//$tamano_columna_imp= 200;
		$tamano_columna = 80;

		$desplasamientoDerecha = 1;
$diaViejo ="";
while ($row323232323232 = mysql_fetch_array($rsD)){
	$dia_=$row323232323232["Dia_orden"];
	$leftXwindows = 0;
	if($solo_primera==1){
		$diaViejo = $dia_;
		$leftXwindows = 5; 
	}

		$sql = "SELECT DISTINCT Sala_orden FROM congreso WHERE Dia_orden='$dia_'  ORDER BY Sala_orden;";

		$rs = mysql_query($sql, $con);
		unset($cualesSalas);
		$cantidad_salas = 0;
		while ($row = mysql_fetch_array($rs)){

			$cantidad_salas = $cantidad_salas + 1;
			$cualesSalas[] = $row["Sala_orden"];
		}

		

		foreach($cualesSalas as $i){

			$sql = "SELECT DISTINCT Sala_orden FROM congreso where Sala_orden='" .  $i. "' and Dia_orden='" . $dia_ .  "';";
			$rs = mysql_query($sql, $con);
			while ($row = mysql_fetch_array($rs)){
				$salaFuente = $row["Sala_orden"];
			}
			
			


			$sql = "SELECT DISTINCT Sala FROM salas where Sala_orden='" .  $salaFuente . "';";
			$rs = mysql_query($sql, $con);
			while ($row = mysql_fetch_array($rs)){
			
				
				$nomSala = $traductor->nombreSala($salaFuente);
				
				if($diaViejo!=$dia_){
					$desplasamientoDerecha = $desplasamientoDerecha + 0.3;
				
				}
				
				if($diaViejoDia!=$dia_){
				
					//-------------Dias--------------------------------------
					$posX = (($tamano_columna * $desplasamientoDerecha) - $tamano_columna);
					
					echo "<div style='position: absolute; ";
					$paraImprimi .= "<div style='position: absolute; ";
					echo "top:".($altoAbsoluto-27) ."px; ";
					$paraImprimi .= "top:10; ";
					echo "left:".($posX+$leftXwindows)."px; ";
					
					$posX = (($tamano_columna) * $desplasamientoDerecha - $tamano_columna);
					$paraImprimi .= "left:".($posX)."px; ";
					
					$posX = (($tamano_columna * $desplasamientoDerecha) - $tamano_columna);
					echo "width:".($tamano_columna*$cantidad_salas)."px; ";
					$paraImprimi .= "width:".($tamano_columna)."px; padding:5px;";
					echo "background-color:gray;padding:5px 0 4px 0; ";
					$paraImprimi .= "background-color:#333333; ";
					echo  "border:1px solid #000000;'>";
					$paraImprimi .= "overflow:hidden;";
					$paraImprimi .= "border:1px solid #000000;'>";
					echo "<div align='center'><font size='2' color='#ffffff'><b>" . $row323232323232["Dia"] . "</b></font></div>";
					echo "</div>";
					$paraImprimi .=  "</div>";
				}
				$diaViejoDia = $dia_;
				$diaViejo=$dia_;
				
				//-------------Salas--------------------------------------

				$posX = (($tamano_columna * $desplasamientoDerecha) - $tamano_columna);
				//$posX_imp = (($tamano_columna_imp * $desplasamientoDerecha) - $tamano_columna_imp);
				
				
				
				echo "<div style='position: absolute; ";
				$paraImprimi .= "<div style='position: absolute; ";
				echo "top:$altoAbsoluto; ";
				$paraImprimi .= "top:33; ";
				echo "left:".($posX+$leftXwindows)."px; ";
				
				$posX = (($tamano_columna) * $desplasamientoDerecha - $tamano_columna);
				$paraImprimi .= "left:".($posX)."px; ";
				
				$posX = (($tamano_columna * $desplasamientoDerecha) - $tamano_columna);
				echo "width:".$tamano_columna."px; ";
				$paraImprimi .= "width:".($tamano_columna)."px; padding:5px;";
				echo "height:20px; ";
				$paraImprimi .= "height:15px; ";
				echo "background-color:#333333; ";
				$paraImprimi .= "background-color:#333333; ";
				echo  "border:1px solid #000000;'>";
				$paraImprimi .= "overflow:hidden;";
				$paraImprimi .= "border:1px solid #000000;'>";
				echo "<div align='center'><font size='2' color='#ffffff'><b>" . $nomSala . "</b></font></div>";
				$paraImprimi .=  "<div align='center' valign='middle'><span class='CronoSala'>" . $nomSala . "</span></div>";
				echo "</div>";
				$paraImprimi .=  "</div>";
				

				//--------------------------------------------------------------
				

				$sql = "SELECT * FROM congreso where Sala_orden='" . $i . "' and Dia_orden = '" . $dia_ . "' ORDER BY Casillero, Orden_aparicion;";
				$rs = mysql_query($sql, $con);

				while ($row = mysql_fetch_array($rs)){
					$traductor->cargarTraductor($row);
					$alto_f=strtotime($row["Hora_fin"]);
					$alto_i = strtotime($row["Hora_inicio"]);
					$alto = $alto_f - $alto_i;
					$alto = $alto / 900;
					$altoImprimir = $alto * $alto_carga_horaria_Imprimir;
					$alto = $alto * $alto_po_carga_horaria;


					$sql2 = "SELECT Hora_inicio FROM congreso where Dia_orden = '" . $dia_ . "' ORDER  BY Hora_inicio ASC ";
					$rs2 = mysql_query($sql2, $con);

					while ($row2 = mysql_fetch_array($rs2)){
						if($solo_primera == 1){
							$PrimeraHora = strtotime($row2["Hora_inicio"]);
							$solo_primera =0;
						}
					}

					$pos =$alto_i- $PrimeraHora;
					$pos = $pos / 900;
					$posImprimir = ($pos * $alto_carga_horaria_Imprimir) + (60);
					$pos = ($pos * $alto_po_carga_horaria) + ($altoAbsoluto+20);


					//recuadros****************************************************
					$sql3 = "SELECT * FROM recuadros where Sala_orden='" . $i . "' and Dia_orden = '" . $row["Dia_orden"] . "' ORDER  BY Hora_inicio ASC ";
					$rs3 = mysql_query($sql3, $con);

					$row3 = mysql_fetch_array($rs3);

						$RRalto_f=strtotime($row3["Hora_fin"]);
						$RRalto_i = strtotime($row3["Hora_inicio"]);
						$RRalto = $RRalto_f - $RRalto_i;
						$RRalto = $RRalto / 900;
						$RRaltoImprimir =  $RRalto * $alto_carga_horaria_Imprimir;
						$RRalto = $RRalto * $alto_po_carga_horaria;
						$RRpos = $RRalto_i- $PrimeraHora;
						$RRpos = $RRpos / 900;
						$RRposImprimir = ($RRpos * $alto_carga_horaria_Imprimir) + (35);
						$RRpos = ($RRpos * $alto_po_carga_horaria) + ($altoAbsoluto+20);

						echo "<div id='div_".$row3["ID"]."' onmouseover='enabledMarco(this.id)' align='center' style='position: absolute; ";
						$paraImprimi .=  "<div align='center' style='position: absolute; ";
						echo "top:".$RRpos. "px; ";
						$paraImprimi .=  "top:" . $RRposImprimir . "px; ";
						echo "left:".($posX+$leftXwindows). "px; ";
						$paraImprimi .=  "left:".$posX. "px; ";
						echo "z-index: 1;";
						$paraImprimi .=  "z-index: 1; ";
						echo "width:".$tamano_columna * $row3["seExpande"] . "px; ";
						$paraImprimi .=  "width:".$tamano_columna * $row3["seExpande"] . "px; ";
						echo "height:" . $RRalto . "px; ";
						$paraImprimi .=   "height:" . $RRaltoImprimir . "px; ";
						echo  "border:3px solid #ff0000;filter:swap(enabled=false)'></div>  ";
						$paraImprimi .=  "border:3px solid #ff0000;'> </div>";
					

					//*****************************************************************

					if($casillero_anterior != $row["Casillero"]){


						$posX = (($tamano_columna * $desplasamientoDerecha) - $tamano_columna);
						//$posX = (($tamano_columna_imp * $desplasamientoDerecha) - $tamano_columna_imp);

						echo "<div id='". $row["Casillero"] ."'  align='center' style=' position: absolute; ";
						$paraImprimi .=  	"<div  style='position: absolute; ";
						echo "top:".$pos. "px; ";
						$paraImprimi .= "top:" . $posImprimir . "px; ";
						echo "left:".($posX+$leftXwindows) . "px; ";
						
						$posX = ((($tamano_columna+50) * $desplasamientoDerecha) - $tamano_columna);
						$paraImprimi .="left:".($posX-50)."px; ";
						
						$posX = (($tamano_columna * $desplasamientoDerecha) - $tamano_columna);
						echo "width:".$tamano_columna * $row["seExpande"] . "px; ";
						$paraImprimi .="width:".($tamano_columna+50) * $row["seExpande"] . "px; ";
						echo "height:" . $alto . "px; ";
						$paraImprimi .="height:" . $altoImprimir . "px; ";

						////ACA TAMBIEN SE MODIFICAO PARA HACER TITULOS
						if($row['Tipo_de_actividad']!=$tit_act_sin_hora){

							if($row["seExpande"]!=0){

								echo  "border:1px solid #000000; ";
								$paraImprimi .= "border:1px solid #000000; ";

							}

						}else{

							echo  "border:0px solid #000000; ";
							$paraImprimi .= "border:0px solid #000000; ";
						}


						echo  "overflow:hidden; ";
						$paraImprimi .= "overflow:hidden;";

						$sql_act = "SELECT * FROM tipo_de_actividad WHERE Tipo_de_actividad ='" . $row["Tipo_de_actividad"] . "';";
						$rs_act = mysql_query($sql_act,$con);												
						if($row["Tipo_de_actividad"]==""){
								$color_fondo = "";
								$color_java = "";
								$traductor->setTipo_de_actividad("");	
						}
						while ($row_act = mysql_fetch_array($rs_act)){
							$traductor->setTipo_de_actividad($row_act);	
							if(substr($row_act["Color_de_actividad"], 0 , 1)=="#"){
								$color_fondo = "background-color:". $row_act["Color_de_actividad"] . ";";
								$color_java = $row_act["Color_de_actividad"];
							}else{
								$color_fondo = "background:url(img/patrones/". $row_act["Color_de_actividad"] . ");";
								$color_java = $row_act["Color_de_actividad"];
							}
							
							
							
						}

				if($_SESSION["registrado"] == true && $_SESSION["tipoUsu"]==1){
						if($row["sala_agrupada"]!=0){		
							$queElimino = $row["sala_agrupada"];	
							$salaAgrupada = 1;	
						}else{
							$queElimino = $row["Casillero"];	
							$salaAgrupada = 0;		
						}
				}
				
						echo "$color_fondo ' onMouseOver=\"sobreCasillero('". $row["Casillero"] ."'); \" onMouseOut=\"fueraCasillero('". $row["Casillero"] ."','".$color_java ."')\" onClick=\"mClk('programaExtendido.php?casillero=" . $row["Casillero"] . "&idioma=" . $_GET["idioma"] . "&sala_=" . $row["Sala_orden"] . "&dia_=" . $row["Dia_orden"] . "')\">";
												
						$paraImprimi .= "$color_fondo;'>";


?>
<table border="0" width="100%" height="100%"  align="center">
<?

$paraImprimi .= "<table width='100%' height='100%'  border='0' cellpadding='0' cellspacing='0'><tr height='1'><td  height='1'>";

if(($row['Tipo_de_actividad']!="Registro sin hora")&&($row['Tipo_de_actividad']!="Posters")){
	echo "<tr><td class='crono_hora' height='1' valign='top'>" . substr($row["Hora_inicio"], 0, -3) ;
}else{
	echo "<tr><td  height='1' valign='top'>";
}
if(strtolower($row["Tipo_de_actividad"])=="cafe" or strtolower($row["Tipo_de_actividad"])=="café" or strtolower($row["Tipo_de_actividad"])=="apertura académica" or strtolower($row["Tipo_de_actividad"])=="ingreso" or strtolower($row["Tipo_de_actividad"])=="recorrida expo"){$margin = "-4px";}else{$margin="10px";}
		echo  "<p class='crono_tipo_act' align='center' style='margin-top:$margin'>"  . $row["Tipo_de_actividad"] . "</p>";



echo "</tr>";
$paraImprimi .="</td></tr><tr><td align='left' valign='top' style='padding:10px'>";




//////////////PARA VER CUANTOS TRABAJOS LIBRES HAY EN EL CASILLERO
$cons = "SELECT Trabajo_libre FROM congreso WHERE Casillero ='".$row["Casillero"]."' and Trabajo_libre=1";
$exec = mysql_query($cons, $con);



if(mysql_num_rows($exec)>0){
$lineaNumTls = "<b class='crono_trab' >";
$lineaNumTls2 = "<b class='crono_trab' >";
	//$cons = "SELECT * FROM trabajos_libres WHERE ID_casillero ='".$row["Casillero"]."' ORDER BY numero_tl;";
	$cons = "SELECT * FROM trabajos_libres WHERE ID_casillero ='".$row["Casillero"]."' ORDER BY numero_tl;";
	$exec = mysql_query($cons, $con);
	while($rowTrabajos = mysql_fetch_array($exec)){
	if($rowTrabajos["Hora_inicio"]!="00:00:00"){
		$lineaNumTls .= "<br><font color='#000000'>".substr($rowTrabajos["Hora_inicio"],0,-3)." - ".$rowTrabajos["numero_tl"]."</font> ".substr($rowTrabajos["titulo_tl"],0,26)."...";
		$lineaNumTls2 .= "<br><font color='#000000'>".substr($rowTrabajos["Hora_inicio"],0,-3)." - ".$rowTrabajos["numero_tl"]."</font> ".substr($rowTrabajos["titulo_tl"],0,26)."...";
		}else{
			$lineaNumTls .= "<div align='left'>";
			$lineaNumTls2 .= "<div align='left'>";
			$lineaNumTls .= '
			<table width="'.($tamano_columna-25) * $row["seExpande"] .'" border="0" cellspacing="0" cellpadding="0" style="font-size:11px;margin-top:5px">
 			 <tr>';
			 $lineaNumTls2 .= '
			<table width="'.($tamano_columna-25) * $row["seExpande"] .'" border="0" cellspacing="0" cellpadding="0" style="font-size:11px;margin-top:5px">
 			 <tr>';
			$lineaNumTls .= "<td valign='top' width='20'><span style='color:gray'>".$rowTrabajos["numero_tl"]."</span></td> <td style='padding-left:5px;'>";
			$lineaNumTls2 .= "<td valign='top' width='20'><span style='color:gray'>".$rowTrabajos["numero_tl"]."</span></td> <td style='padding-left:5px;'>";
			$lineaNumTls .= "<span style='color:black;	font-family:Arial, Helvetica, sans-serif;text-transform:uppercase'>".substr($rowTrabajos["titulo_tl"],0,24)."..."."</span>";
			$tl_autores = "SELECT * FROM trabajos_libres_participantes as t JOIN personas_trabajos_libres as p ON t.ID_participante=p.ID_Personas WHERE t.ID_trabajos_libres='".$rowTrabajos["ID"]."' AND t.lee=1";
			$query_autores = mysql_query($tl_autores,$con); //or die(mysql_error());
			while($rowAutores = mysql_fetch_object($query_autores)){
				$lineaNumTls .= "<br><span style='color:black;font-weight:bold'>".$rowAutores->Nombre." ".$rowAutores->Apellidos."</span>";
				$lineaNumTls2 .= "<br><span style='color:black;font-weight:bold'>".$rowAutores->Nombre." ".$rowAutores->Apellidos."</span>";
			}
		$lineaNumTls .= "</td></tr></table></div>";
		$lineaNumTls2 .= "</td></tr></table></div>";
			
		}
	}
	$lineaNumTls .= "</b>";
	$cant_trab = mysql_num_rows($exec);
	$numero_trabajos = " <b class='crono_trab' >(". $cant_trab .")</b>";
	$numero_trabajos .= $lineaNumTls;
	$numero_trabajos2 = " <b class='crono_trab' >(". $cant_trab .")</b>";
	$numero_trabajos2 .= $lineaNumTls2;
	/*$numero_trabajos2 = " - (". $cant_trab .")</span><br>";*/
}else{
	$numero_trabajos = "";
	$numero_trabajos2 = "";
	$lineaNumTls2 = "";
}

echo "<tr><td class='crono_trab' style='color:#000000' align='center'><b>". $act."<br>";
$paraImprimi .= "<span class='CronoTituloAct'><span style='font-size:11px;'><strong>" . $act ."</strong></span>". $numero_trabajos2;


echo "<span class='crono_trab'>".$numero_trabajos."</span>";

echo "</td></tr></table>";
$paraImprimi .= "</td></tr></table>";
//-------------------------------

echo "</div>\n";
$paraImprimi .= "</div>\n";
$casillero_anterior = $row["Casillero"];
					}
				}
			}
			$desplasamientoDerecha = $desplasamientoDerecha + 1;
		}
		$po = $po+1;
		
}
?>
<script>
window.onload=carga;
</script>
<?
$_SESSION["paraImprimir"]=$paraImprimi;
?>
