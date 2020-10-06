<?
header('Content-Type: text/html; charset=UTF-8');
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
<link href="estilos.css" rel="stylesheet" type="text/css">
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
			
				}
	?>
          </td>
        </tr>
      </table>
           
      <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td><?
        if($_GET["casillero"]!=""){
        	$sql = "SELECT * FROM congreso where Casillero='" . $_GET["casillero"] . "'and Dia_orden='" . $dia_ . "' and Sala_orden='" . $sala_ . "' ORDER by Casillero, Orden_aparicion ASC";/**/
        }else{
        	$sql = "SELECT * FROM congreso where Dia_orden='" . $dia_ . "' and Sala_orden='" . $sala_ . "' ORDER by Casillero, Orden_aparicion ASC";/**/
        }
        $rs = mysql_query($sql,$con);
        
		$pers = 1;
		$cantidadPersonasCongreso = mysql_num_rows($rs);
		while ($row = mysql_fetch_array($rs)){
			$traductor->cargarTraductor($row);
	
        	$_SESSION["buscar"] = false;
        	require("inc/programaCronoCompleto.php");
			$pers++;
        }
		
		
	?>

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