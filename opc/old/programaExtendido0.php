<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");

if (!isset($_SESSION["registrado"])){
	$_SESSION["registrado"]=false;
}
include('inc/sesion.inc.php');
include('conexion.php');
include("inc/validarVistas.inc.php");

require ("clases/trabajosLibres.php");
$trabajos = new trabajosLibre;

$sePuedeImprimir=true;
$imprimir = "";

$tit_act_sin_hora = "Actividad sin horarios";
 
function remplazar($cual){
		  	
	return  $cual;
	
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
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" bgproperties="fixed" marginwidth="0" marginheight="0">
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#FFFFFF">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php"; ?></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F0F0F0">      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="100%" border="1" align="left" cellpadding="2" cellspacing="2" bordercolor="#ffffff">
            <tr>
              <?

              $dia_ = $_GET["dia_"];
              $sala_ = $_GET["sala_"];

              if($dia_==""){
              	$sql = "SELECT Dia FROM congreso ORDER BY Dia_orden ASC LIMIT 1;";
              	$rs = mysql_query($sql, $con);
              	while ($row = mysql_fetch_array($rs)){
              		$dia_=$row["Dia"];
              	}
              }
              if($sala_==""){
              	$sql = "SELECT Sala FROM congreso where Dia='" . $dia_ . "' order by Sala_orden Desc;";
              	$rs = mysql_query($sql, $con);
              	while ($row = mysql_fetch_array($rs)){
              		$sala_=$row["Sala"];
              	}
              }


              $sql = "SELECT DISTINCT Dia FROM congreso ORDER by Dia_orden ASC";
              $rs = mysql_query($sql,$con);


              while ($row = mysql_fetch_array($rs)){

              	if($row["Dia"]==$dia_){
              		$colorFondoDia = "#93DDFD";
              	}else{
              		$colorFondoDia= "#ffffff";
              	}
	?>
              <td valign="top" bordercolor="#999999" bgcolor="<?=$colorFondoDia?>" 
					onClick="mClk('?dia_=<?=$row["Dia"];?>');"
					onMouseOver="mOvr(this,'C6FFFF');" 
					onMouseOut="mOut(this,'<?=$colorFondoDia?>');"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><b>
                  <a href="?dia_=<?=$row["Dia"];?>" class='lista_persona'><?=$row["Dia"];?></a>
              </b></font></div></td>
              <?
              }
	?>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="100%" border="1" align="left" cellpadding="2" cellspacing="2" bordercolor="#ffffff">
            <tr>
              <?
              $sql = "SELECT DISTINCT Sala FROM congreso where Dia='" . $dia_ . "' ORDER by Sala_orden ASC";
              $rs = mysql_query($sql,$con);

              while ($row = mysql_fetch_array($rs)){

              	if($row["Sala"]==$sala_){
              		$colorFondoSala = "#93DDFD";
              	}else{
              		$colorFondoSala= "#ffffff";
              	}


	?>
              <td valign="top" bordercolor="#999999" bgcolor="<?=$colorFondoSala?>" 
		  onClick="mClk('?sala_=<?=$row["Sala"];?>&dia_=<?=$dia_;?>');"
		  onMouseOver="mOvr(this,'C6FFFF');" 
		  onMouseOut="mOut(this,'<?=$colorFondoSala ?>');"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><b>
                    <a href="?sala_=<?=$row["Sala"];?>&dia_=<?=$dia_;?>" class='lista_persona'> <?=$row["Sala"];?></a>
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
        	$sql = "SELECT * FROM congreso where Casillero='" . $_GET["casillero"] . "'and Dia='" . $dia_ . "' and Sala='" . $sala_ . "' ORDER by Casillero, Orden_aparicion ASC";
        }else{
        	$sql = "SELECT * FROM congreso where Dia='" . $dia_ . "' and Sala='" . $sala_ . "' ORDER by Casillero, Orden_aparicion ASC";
        }
        $rs = mysql_query($sql,$con);
        
		
		while ($row = mysql_fetch_array($rs)){

        	
        	require("inc/programa.inc.php");
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