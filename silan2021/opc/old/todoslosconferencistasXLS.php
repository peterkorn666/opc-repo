<?
 header("Content-Disposition: attachment; filename=Todos_los_Conferencistas.xls");

require "conexion.php";
require("clases/class.baseController.php");
$base = new baseController();

function sacarBR($campo) {
	$aux = str_replace('<br/>', ' ',$campo);
	$aux = str_replace('<br />', ' ',$aux);
	$aux = str_replace('<br>', ' ',$aux);
	return $aux;
}

function sd($contenido,$prop)
{
	if($contenido==""){
		$contenido="&nbsp;";
	}
	echo "<td $prop>$contenido</td>";
}
?>
<meta charset="utf-8">
<table width="98%" height="39" border="1"  bordercolor="#000000" cellspacing="0">
<tr>
	<td style="background-color:#CCCCCC">ID_Personas</td>
	<td style="background-color:#CCCCCC">Confirmado que viene</td>
	<td style="background-color:#CCCCCC">Tipo de Conferencista</td>
	<td style="background-color:#CCCCCC">Categor&iacute;a Ana</td>
	<td style="background-color:#CCCCCC">Profesi&oacute;n</td>
	<td style="background-color:#CCCCCC">Nombre</td>
	<td style="background-color:#CCCCCC">Apellido</td>
	<td style="background-color:#CCCCCC">Internacional</td>
	<td style="background-color:#CCCCCC">Idioma</td>
	<td style="background-color:#CCCCCC">Mail</td>		
	<td style="background-color:#CCCCCC">Comentarios Administrador</td>	
	<td style="background-color:#CCCCCC">En Calidad de / Rol</td>
	<td style="background-color:#CCCCCC">Financiado por</td>
	<td style="background-color:#CCCCCC">Detalle financiamiento</td>
	<td style="background-color:#CCCCCC">Ciudad</td>
	<td style="background-color:#CCCCCC">Pa&iacute;s</td>
	<td style="background-color:#CCCCCC">Instituci&oacute;n y cargo o funci&oacute;n</td>
	<td style="background-color:#CCCCCC">Tel&eacute;fono</td>	
	<td style="background-color:#CCCCCC">Archivo Ponencia</td>
	<td style="background-color:#CCCCCC">Envi&oacute; Foto</td>
	<td style="background-color:#CCCCCC">Curriculum abreviado</td>
	<td style="background-color:#CCCCCC">Curriculum largo</td>	
	<td style="background-color:#CCCCCC">Confirmado - Hotel</td>
	<td style="background-color:#CCCCCC">IN</td>
	<td style="background-color:#CCCCCC">OUT</td>	
	<td style="background-color:#CCCCCC">Vuelo Llegada D&Iacute;A</td>
	<td style="background-color:#CCCCCC">Vuelo Llegada HORA</td>
	<td style="background-color:#CCCCCC">Vuelo Llegada COMPA&Ntilde;&Iacute;A</td>
	<td style="background-color:#CCCCCC">Vuelo Llegada #</td>	
	<td style="background-color:#CCCCCC">Necesita transporte (Llegada)</td>
	<td style="background-color:#CCCCCC">Qui&eacute;n se har&aacute; cargo (Llegada)</td>
	<td style="background-color:#CCCCCC">Vuelo Salida D&Iacute;A</td>
	<td style="background-color:#CCCCCC">Vuelo Salida HORA</td>
	<td style="background-color:#CCCCCC">Vuelo Salida COMPA&Ntilde;&Iacute;A</td>
	<td style="background-color:#CCCCCC">Vuelo Salida #</td>	
	<td style="background-color:#CCCCCC">Necesita transporte (Salida)</td>
	<td style="background-color:#CCCCCC">Qui&eacute;n se har&aacute; cargo (Salida)</td>	
	<td style="background-color:#CCCCCC">Comentarios del Conferencista</td>	
</tr>
<?
//$sql = "SELECT Distinct congreso.ID_persona, personas.* FROM congreso,personas WHERE congreso.ID_persona<>0 and  congreso.ID_persona = personas.ID_Personas ORDER by personas.Apellidos ASC;";
//$sql = "SELECT congreso.ID_persona, congreso.Dia, congreso.Sala, congreso.Hora_inicio, congreso.observaciones , congreso.Titulo_de_actividad , personas.* FROM congreso,personas WHERE congreso.ID_persona<>0 and  congreso.ID_persona = personas.ID_Personas ORDER by personas.Apellidos ASC;";
$sql = "SELECT * FROM personas ORDER by apellido ASC;";
$rs = mysql_query($sql, $con) or die(mysql_error());
$p = 0;
while($row=mysql_fetch_array($rs)){
	$sqlCongreso = "SELECT En_calidad,ID_persona FROM congreso WHERE ID_persona='".$row["ID_Personas"]."' AND En_calidad<>'' AND seExpande<=1";
;
	$queryCongreso = mysql_query($sqlCongreso,$con) or die(mysql_error());
	
	while($rowC = mysql_fetch_object($queryCongreso)){
		$en_calidad[] = $rowC->En_calidad;
	}
	
	$conf = "No";
	if ($row["actividad_confirma_viene"]==1) {
		$conf = "Si";
	}
	$inter = "No";
	if ($row["actividad_internacional"]==1) {
		$inter = "Si";
	}
	
	$idioma = "";
	if ($row["actividad_idioma_hablado"]=='Espanol') {
		$idioma = "Espa&ntilde;ol";
	}
	if ($row["actividad_idioma_hablado"]=='Ingles') {
		$idioma = "Ingl&eacute;s";
	}
	
	$tieneP = "No";
	if ($row["tienePonenecia"]==1) {
		$tieneP = "Si";
	}
?>
<tr>
	<td><?=$row["ID_Personas"]?></td>
	
	
	<td><?=$conf?></td>
	<td><?=$base->getAreasActividad($row["actividad_areas"])?></td>
	<td><?=$row["actividad_categoriaAna"]?></td>	
	<td><?=$row["profesion"]?></td>	
	<td><?=$row["nombre"]?></td>
	<td><?=$row["apellido"]?></td>	
	
	<td><?=$inter?></td>	
	
	<td><?=$idioma?></td>	
	<td><?=$row["email"]?></td>	
	<td><?=$row["actividad_comentarios"]?></td>	
	<td><? if($en_calidad!=""){echo implode(",",$en_calidad);}?></td>
    <? unset($en_calidad) ; ?>
	<td><?=$row["financiado"]?></td>
	<td><?=$row["confirmacionEncargado"]?></td>
	<td><?=$row["Ciudad"]?></td>
	<td><?=$row["Pais"]?></td>
	<td><?=$row["Institucion"]?></td>
	<td><?=$row["Tel"]?></td>
	
	<td><?=$row["archCurriculum"]?></td>
	<td><?=$row["foto"]?></td>
	<td><?=sacarBR($row["cvAbreviado"])?></td>
	<td><?=sacarBR($row["Curriculum"])?></td>
	<td><?=$row["confirmado"]?></td>
	<td><?=$row["hotel_in"]?></td>
	<td><?=$row["hotel_out"]?></td>	
	<td><?=$row["fecha_ll"]?></td>
	<td><?=$row["hora_ll"]?></td>
	<td><?=$row["comp_ll"]?></td>
	<td><?=$row["vuelo_ll"]?></td>
	<td><?=$row["transporte"]?></td>
	<td><?=$row["traslado_comentario"]?></td>	
	<td><?=$row["fecha_sal"]?></td>	
	<td><?=$row["hora_sal"]?></td>
	<td><?=$row["comp_sal"]?></td>
	<td><?=$row["vuelo_sal"]?></td>
	<td><?=$row["transporte2"]?></td>
	<td><?=$row["traslado_comentario2"]?></td>
	<td><?=$row["agradecimientos"]?></td>
</tr>
<?
}
 ?>
</table>
 
 
