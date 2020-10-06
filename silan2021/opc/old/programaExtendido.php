<?
session_start();
//include('inc/sesion.inc.php');
include('conexion.php');
require ("clases/class.Traductor.php");
include("inc/validarVistas.inc.php");
require ("clases/trabajosLibres.php");
$trabajos = new trabajosLibre;

$traductor = new traductor();
$traductor->setIdioma($_GET["idioma"]);

$sePuedeImprimir=true;
$imprimir = "";

$tit_act_sin_hora = "Actividad sin horarios";
 
function remplazar($cual){
	return $cual;		  		
}
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
</style>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function mOvr(src,clrOver) {
	if (!src.contains(event.fromElement)) {
		src.style.cursor = 'hand';
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
	document.location.href = src;
}


</script>
<script src="js/menuEdicion.js"></script>
<script src="js/trabajos_libres.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script src="js/slide.js" type="text/javascript"></script>
<? 
if($_SESSION["tipoUsu"]==1){
	include "inc/vinculos.inc.php";
}
?>
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" bgproperties="fixed" marginwidth="0" marginheight="0">

<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#FFFFFF">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php";	 ?></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F0F0F0">      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="100%" border="1" align="left" cellpadding="2" cellspacing="2" bordercolor="#ffffff">
            <tr>
              <?
			 
			function is_chrome(){
   return(@eregi("chrome", $_SERVER['HTTP_USER_AGENT']));
}

if(is_chrome()){
 $dia_ = utf8_decode($_GET["dia_"]);
$sala_ = utf8_decode($_GET["sala_"]);
}else{
			  $dia_ = $_GET["dia_"];
			  $sala_ = $_GET["sala_"];}

              if($dia_==""){
              	$sql = "SELECT Dia FROM congreso ORDER BY Dia_orden ASC LIMIT 1;";
              	$rs = mysql_query($sql, $con);
              	while ($row = mysql_fetch_array($rs)){
              		$dia_=$row["Dia"];
              	}
              }
              if($sala_==""){
              	$sql = "SELECT Sala FROM congreso where Dia_orden='" . $dia_ . "' order by Sala_orden Desc;";/**/
              	$rs = mysql_query($sql, $con);
              	while ($row = mysql_fetch_array($rs)){
              		$sala_=$row["Sala"];
              	}
              }


              $sql = "SELECT DISTINCT Dia FROM congreso ORDER by Dia_orden ASC";
              $rs = mysql_query($sql,$con);


              while ($row = mysql_fetch_array($rs)){
				  
				$sql3 = "SELECT * FROM dias WHERE Dia='".$row["Dia"]."'";	
				$rs3 = mysql_query($sql3,$con);
				$row3 = mysql_fetch_array($rs3);

              	if($row3["Dia_orden"]==$dia_){
              		$colorFondoDia = "#93DDFD";
              	}else{
              		$colorFondoDia= "#ffffff";
              	}
				
				$nomDia = $traductor->nombreDia($row3["Dia_orden"]);
			
				
	?>
	<? if($_SESSION["tipoUsu"]==4 and $row3["Dia_orden"]==10){ ?>
              <td valign="top" bordercolor="#999999" bgcolor="<?=$colorFondoDia?>" 
					onClick="mClk('?dia_=<?=$row3["Dia_orden"];?>');"
					onMouseOver="mOvr(this,'C6FFFF');" 
					onMouseOut="mOut(this,'<?=$colorFondoDia?>');"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><b>
                    
                 	 <a href="?dia_=<?=$row3["Dia_orden"];?>&idioma=<?=$_GET["idioma"];?>" class='lista_persona'><?=$nomDia;?></a>

              </b></font></div></td>
<? }else if($_SESSION["tipoUsu"]==1){ ?>
<td valign="top" bordercolor="#999999" bgcolor="<?=$colorFondoDia?>" 
					onClick="mClk('?dia_=<?=$row3["Dia_orden"];?>');"
					onMouseOver="mOvr(this,'C6FFFF');" 
					onMouseOut="mOut(this,'<?=$colorFondoDia?>');"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><b>
                    
                 	 <a href="?dia_=<?=$row3["Dia_orden"];?>&idioma=<?=$_GET["idioma"];?>" class='lista_persona'><?=$nomDia;?></a>

              </b></font></div></td>              
              <?
}
              }
	?>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="100%" border="1" align="left" cellpadding="2" cellspacing="2" bordercolor="#ffffff">
            <tr>
              <?
              $sql = "SELECT DISTINCT Sala, Sala_orden FROM congreso where Dia_orden ='" . $dia_ . "' ORDER by Sala_orden ASC";/**/
              $rs = mysql_query($sql,$con);

              while ($row = mysql_fetch_array($rs)){

				$sql2 = "SELECT * FROM salas WHERE Sala='".$row["Sala"]."'";	
				$rs2 = mysql_query($sql2,$con);
				$row2 = mysql_fetch_array($rs2);

              	if($row2["Sala_orden"]==$sala_){

              		$colorFondoSala = "#93DDFD";
              	}else{
              		$colorFondoSala= "#ffffff";
              	}
				
				
			
			$nomSala = $traductor->nombreSala($row["Sala_orden"]);

	?>
    
    
    
              <td valign="top" bordercolor="#999999" bgcolor="<?=$colorFondoSala?>" 
		  onClick="mClk('?sala_=<?=$row2["Sala_orden"];?>&dia_=<?=$dia_;?>&idioma=<?=$_GET["idioma"];?>');"
		  onMouseOver="mOvr(this,'C6FFFF');" 
		  onMouseOut="mOut(this,'<?=$colorFondoSala ?>');"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><b>
                    <a href="?sala_=<?=$row2["Sala_orden"];?>&dia_=<?=$dia_;?>&idioma=<?=$_GET["idioma"];?>" class='lista_persona'> <?=$nomSala;?></a>
              </b></font></div></td>
    <?
              }
	?>
            </tr>
          </table></td>
        </tr>
      </table>
           
      <table width="770" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td><?
        if($_GET["casillero"]!=""){
        	$sql = "SELECT * FROM congreso where Casillero='" . $_GET["casillero"] . "' and Dia_orden='" . $dia_ . "' and Sala_orden='" . $sala_ . "' ORDER by Casillero, Orden_aparicion ASC";/**/
        }else{
        	$sql = "SELECT * FROM congreso where Dia_orden='" . $dia_ . "' and Sala_orden='" . $sala_ . "' ORDER by Casillero, Orden_aparicion ASC";/**/
        }
        $rs = mysql_query($sql,$con);
        
		
		while ($row = mysql_fetch_array($rs)){
			$traductor->cargarTraductor($row);
	
        	$_SESSION["buscar"] = false;
        	require("inc/programaNuevo.inc.php");
        }
		
		
	?></td>
        </tr>
      </table>
  </tr>
</table>

<script language="javascript">
 	 function eliminar_tl(cual){
 		var return_value = confirm("¿Esta seguro que desea eliminar este trabajo libre?");
		 if ( return_value == true ) {
			 document.location.href = "eliminarTrabajoLibre.php?id=" + cual;
		 }
	 }
	  function fliar(cual){
			 document.location.href = "?filtro=" + cual;

	 }
</script>

<?
$_SESSION["paraImprimir"]=$imprimir;
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
}
?>