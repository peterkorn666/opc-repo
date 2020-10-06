<?
header("Content-Disposition: attachment; filename=Todos_en_Congreso.xls");
include('inc/sesion.inc.php');
require "conexion.php";
require "clases/class.Traductor.php";

$traductor = new traductor();
$traductor->setIdioma("ing");
//require "clases/trabajoslibres.php";

function sacarBR($txt){
	$aux = str_replace('<br>', ' - ',$txt);
	$aux = str_replace('<br >', ' - ',$aux);
	$aux = str_replace('<br />', ' - ',$aux);
	return $aux;	
}

function echotd($contenido,$prop)
{
	if($contenido==""){
		$contenido="&nbsp;";
	}
	echo "<td $prop>$contenido</td>";
}
?>
<meta charset="utf-8">
<table width="98%" height="39" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
	<tr>
	<td bgcolor="#CCCCCC">Orden Dia</td>	
	<td bgcolor="#CCCCCC">Dia</td>	
	<td bgcolor="#CCCCCC">Orden Sala</td>
	<td bgcolor="#CCCCCC">Sala</td>
	<td bgcolor="#CCCCCC">Hora</td>
	<td bgcolor="#CCCCCC">Actividad</td>
	<td bgcolor="#CCCCCC">Actividad Ingl&eacute;s</td>
	<td bgcolor="#CCCCCC">TituloSession</td>
	<td bgcolor="#CCCCCC">TituloSession Ingl&eacute;s</td>
	<td bgcolor="#CCCCCC">TituloPresentacion</td>
	<td bgcolor="#CCCCCC">TituloPresentacion Ingl&eacute;s</td>
	<td bgcolor="#CCCCCC">Calidad</td>
	<td bgcolor="#CCCCCC">Calidad Ingl&eacute;s</td>
	<td bgcolor="#CCCCCC">ID</td>
	<td bgcolor="#CCCCCC">Profesion</td>
	<td bgcolor="#CCCCCC">Nombre</td>
	<td bgcolor="#CCCCCC">Apellido</td>
	<td bgcolor="#CCCCCC">Cargos</td>
	<td bgcolor="#CCCCCC">Pa&iacute;s</td>
	<td bgcolor="#CCCCCC">Ciudad</td>	
	<td bgcolor="#CCCCCC">Mail</td>
	<td bgcolor="#CCCCCC">Tel&eacute;fono</td>
	<td bgcolor="#CCCCCC">Movil</td>
	<td bgcolor="#CCCCCC">Instituci&oacute;n</td>
	<td bgcolor="#CCCCCC">Inscripto</td>

	</tr>
<?php
$sqlCDSH = "SELECT * FROM congreso WHERE Apellidos !='' or Nombre !='' ORDER BY Casillero, Orden_aparicion ASC" ; 
$rsCDSH = mysql_query($sqlCDSH, $con) or die(mysql_error());
while($rowCDSH=mysql_fetch_array($rsCDSH)){
	$traductor->cargarTraductor($rowCDSH);

	if($rowCDSH["Dia_orden"]<=9){
		$diaOrden = "0" . $rowCDSH["Dia_orden"];
	}
	else{
		$diaOrden = $rowCDSH["Dia_orden"];
	}
	if($rowCDSH["Sala_orden"]<=9){
		$salaOrden = "0" . $rowCDSH["Sala_orden"];
	}
	else{
		$salaOrden = $rowCDSH["Sala_orden"];
	}
	
	$hora_ini = substr($rowCDSH["Hora_inicio"], 0, -3);
?>	
	<tr>
	<td><?=$diaOrden."&nbsp;"?></td>
	<td><?=$rowCDSH["Dia"]?></td>
	<td><?=$salaOrden."&nbsp;"?></td>
	<td><?=sacarBR($rowCDSH["Sala"])?></td>
	<td><?=$hora_ini?></td>
<?php
	$sql_act = "SELECT * FROM tipo_de_actividad WHERE Tipo_de_actividad ='" . $rowCDSH["Tipo_de_actividad"] . "';";
	$rs_act = mysql_query($sql_act,$con) or die(mysql_error());
	if ($row_act = mysql_fetch_array($rs_act)){
		$tipo_ing = $row_act["Tipo_de_actividad_ing"];
	} else {
		$tipo_ing = "";
	}
?>	
	<td><?=sacarBR($rowCDSH["Tipo_de_actividad"])?></td>
	<td><?=sacarBR($tipo_ing)?></td>
	<td><?=sacarBR($rowCDSH["Titulo_de_actividad"])?></td>
	<td><?=sacarBR($traductor->getTitulo_de_actividad())?></td>
	<td><?=sacarBR($rowCDSH["Titulo_de_trabajo"])?></td>
	<td><?=sacarBR($traductor->getTitulo_de_trabajo())?></td>
	<td><?=$rowCDSH["En_calidad"]?></td>	
	<td><?=sacarBR($traductor->enCalidad($rowCDSH["En_calidad"]))?></td>
    <?php
	$sqlPer = "SELECT * FROM personas WHERE ID_Personas='".$rowCDSH["ID_persona"]."'";
	$rsPer = mysql_query($sqlPer, $con) or die(mysql_error());
	while($rowPer = mysql_fetch_array($rsPer)){
		$insc = "No";
		if ($rowPer["inscripto"]=='1'){
			$insc = "Si";
		}
	?>
		<td><?=$rowPer["ID_Personas"]?></td>
		<td><?=$rowPer["profesion"]?></td>
		<td><?=$rowPer["nombre"]?></td>
		<td><?=$rowPer["apellido"]?></td>
		<td><?=$rowPer["cargos"]?></td>
		<td><?=$rowPer["pais"]?></td>
		<td><?=$rowPer["Ciudad"]?></td>
		<td><?=$rowPer["email"]?></td>
		<td><?=$rowPer["tel"]?></td>
		<td><?=$rowPer["Movil"]?></td>
		<td><?=$rowPer["institucion"]?></td>
		<td><?=$insc?></td>
    <?php
		}
	?>
	
	</tr>
<?php	
}

?>
</table>


