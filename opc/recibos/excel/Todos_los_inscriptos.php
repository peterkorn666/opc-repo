<?
session_start();
header("Content-Disposition: attachment; filename=Todos_los_Inscriptos_".date("Ymd").".xls");
header('Content-Type: text/html; charset=utf-8');
require "../init.php";
require "../clases/inscripcion.class.php";
require "../clases/lang.php";
$inscripcion = new Inscripcion();
$lang = new Language("es");

function sacarBR($txt){
	$aux = str_replace('<br>', ' - ',$txt);
	$aux = str_replace('<br >', ' - ',$aux);
	$aux = str_replace('<br />', ' - ',$aux);
	return $aux;	
}

?>
<meta charset="utf-8">
<table width="98%" height="39" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
	<tr>
    <td bgcolor="#CCCCCC">ID</td>
    <td bgcolor="#CCCCCC">Estado</td>
    <td bgcolor="#CCCCCC">Solapero</td>
    <td bgcolor="#CCCCCC">Tipo de documento</td>
    <td bgcolor="#CCCCCC">Documento</td>
    <td bgcolor="#CCCCCC">Nombre</td>
    <td bgcolor="#CCCCCC">Apellido</td>
    <td bgcolor="#CCCCCC">Género</td>
    <td bgcolor="#CCCCCC">Teléfono</td>
    <td bgcolor="#CCCCCC">Fecha de nacimiento</td>
    <td bgcolor="#CCCCCC">Email</td>
    <td bgcolor="#CCCCCC">Ciudad</td>
    <td bgcolor="#CCCCCC">Pa&iacute;s</td>
    <td bgcolor="#CCCCCC">Instituci&oacute;n</td>
    <td bgcolor="#CCCCCC">M&aacute;ximo t&iacute;tulo</td>
    <td bgcolor="#CCCCCC">Forma pago</td>
    <td bgcolor="#CCCCCC">Tipo de tarjeta</td>
    <td bgcolor="#CCCCCC">N&uacute;mero de tarjeta</td>
    <td bgcolor="#CCCCCC">Comentarios</td>

	</tr>
<?php
	$inscriptos = $inscripcion->listadoInscriptos();
	foreach ($inscriptos as $inscripto) {
?>	
	<tr>
    <td valign="center" align="center"><?=$inscripto["id"]?></td>
    <td valign="center" align="center"><?php 
	if ($inscripto["estado"] == 0)
		echo "No inscripto";
	else if ($inscripto["estado"] == 1)
		echo "Si inscripto";
	?></td>
    <td valign="center" align="center"><?=$inscripto["solapero"]?></td>
    <td valign="center" align="center"><?=$lang->getValue($lang->set["TIPO_DOCUMENTO"]["array"][$inscripto["tipo_documento"]],0)?></td>
    <td valign="center" align="center"><?=$inscripto["numero_pasaporte"]?></td>
    <td valign="top" align="center"><?=$inscripto["nombre"]?></td>
    <td valign="top" align="center"><?=$inscripto["apellido"]?></td>
    <td valign="center" align="center"><?=$lang->getValue($lang->set["GENERO"]["array"][$inscripto["genero"]],0)?></td>
    <td valign="center" align="center"><?=$inscripto["telefono"]?></td>
    <td valign="center" align="center"><?=date("Y-m-d", strtotime($inscripto["fecha_nacimiento"]))?></td>
    <td valign="center" align="center"><?=$inscripto["email"]?></td>
    <td valign="center" align="center"><?=$inscripto["ciudad"]?></td>
    <td valign="center" align="center"><?php 
	$paisArray = $inscripcion->getPais($inscripto["pais"]);
	echo $paisArray["Pais"];
	?></td>
    <td valign="top" align="center"><?=$inscripto["institucion"]?></td>
    <td valign="top" align="center"><?=$lang->getValue($lang->set["MAXIMO_TITULO"]["array"][$inscripto["maximo_titulo"]],0)?></td>
    <td valign="center" align="center"><?=str_replace("Tarjeta de Crédito: ", "", $lang->getValue($lang->set["FORMA_PAGO"]["array"][$inscripto["forma_pago"]],0))?></td>
    <td valign="center" align="center"><?=$inscripto["credit_card_type"]?></td>
    <td valign="center" align="center"><?=str_pad(substr($inscripto["credit_card_number"], -4), 14, '*', STR_PAD_LEFT)?></td>
    <td valign="top" align="center"><?=$inscripto["comentarios"]?></td>
    
	
	</tr>
<?php	
	}
?>
</table>


