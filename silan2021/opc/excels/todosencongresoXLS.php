<?
session_start();
header("Content-Disposition: attachment; filename=Todos_en_Congreso_".date("Ymd").".xls");
require_once("../class/core.php");
require_once("../class/util.class.php");
$util = new util();
$core = new core();
$util->isLogged();
$config = $core->getConfig();

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
    <td bgcolor="#CCCCCC">Orden Día</td>
	<td bgcolor="#CCCCCC">Día</td>	
	<td bgcolor="#CCCCCC">Orden Sala</td>
	<td bgcolor="#CCCCCC">Sala</td>
	<td bgcolor="#CCCCCC">Hora</td>
	<td bgcolor="#CCCCCC">Titulo Session</td>
	<td bgcolor="#CCCCCC">Titulo Presentacion</td>
	<td bgcolor="#CCCCCC">Calidad</td>
	<td bgcolor="#CCCCCC">ID</td>
	<td bgcolor="#CCCCCC">Profesion</td>
	<td bgcolor="#CCCCCC">Nombre</td>
	<td bgcolor="#CCCCCC">Apellido</td>
	<td bgcolor="#CCCCCC">Pa&iacute;s</td>
	<td bgcolor="#CCCCCC">Mail</td>
	<td bgcolor="#CCCCCC">Instituci&oacute;n</td>
	<td bgcolor="#CCCCCC">Inscripto</td>

	</tr>
<?php
$k = 0;
$sqlCDSH = $core->query("SELECT * FROM cronograma as c JOIN salas as s ON s.salaid=c.section_id JOIN crono_conferencistas as cc ON cc.id_crono=c.id_crono JOIN conferencistas as t ON t.id_conf=cc.id_conf ORDER BY SUBSTRING(c.start_date,1,10), s.orden ASC"); 
foreach($sqlCDSH as $rowCDSH){
	
	if ($k == 0) {
		$ord_dia = 1;
		$ord_dia_condicion = substr($rowCDSH["start_date"], 8, 2);
		$k = $k + 1;
	}
	else {
		if ($ord_dia_condicion != substr($rowCDSH["start_date"], 8, 2)) {
			$ord_dia_condicion = substr($rowCDSH["start_date"], 8, 2);
			$ord_dia = $ord_dia + 1;
		}
	}
	
	$hora_ini = substr($rowCDSH["start_date"], 11, 5);
	$insc = "No";
	if ($rowCDSH["inscripto"]=='1'){
		$insc = "Si";
	}
?>	
	<tr>
    <td><?=$ord_dia?></td>
	<td><?=$rowCDSH["start_date"]?></td>
	<td><?=$rowCDSH["orden"]."&nbsp;"?></td>
	<td><?=sacarBR($rowCDSH["name"])?></td>
	<td><?=$hora_ini?></td>
	<td><?=sacarBR($rowCDSH["titulo_actividad"])?></td>
	<td><?=sacarBR($rowCDSH["titulo_conf"])?></td>
	<td><?php
		if($rowCDSH["en_calidad"])
	    	echo $core->getRolID($rowCDSH["en_calidad"])["calidad"];
		?>
    </td>	
    <td><?=$rowCDSH["id_conf"]?></td>
    <td><?=$rowCDSH["profesion"]?></td>
    <td><?=$rowCDSH["nombre"]?></td>
    <td><?=$rowCDSH["apellido"]?></td>
    <td>
	<?php
    	if($rowCDSH["pais"])
			echo $core->getPais($rowCDSH["pais"])["Pais"];
	?>
    </td>
    <td><?=$rowCDSH["email"]?></td>
    <td>
    	<?php
        	if($rowCDSH["institucion"])
				echo $core->getInstitution($rowCDSH["institucion"])["Institucion"];
		?>
    </td>
    <td><?=$insc?></td>	
	</tr>
<?php	
}

?>
</table>


