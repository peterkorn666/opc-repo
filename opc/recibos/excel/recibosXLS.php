<?php
session_start();
header("Content-Disposition: attachment; filename=recibos_".date("Ymd").".xls");
header('Content-Type: text/html; charset=utf-8');
require("../init.php");
//require("../clases/DB.class.php");
require("../clases/lang.php");
require("../clases/inscripcion.class.php");
$inscripcion = new Inscripcion();
$lang = new Language("es");
$db = \DB::getInstance();

function echotd($contenido,$prop)
{
	if($contenido==""){
		$contenido="&nbsp;";
	}
	echo "<td $prop>$contenido</td>";
}


$sql = $db->query("SELECT * FROM inscriptos_recibo ORDER BY id ASC")->results();
?>
<meta charset="utf-8">
<table width="98%" height="39" border="1"  bordercolor="#000000" cellspacing="0">
	<tr>
		<td align="center" valign="center">ID</td>
        <td align="center" valign="center">ID inscripto</td>
        <td align="center" valign="center">Recibo a nombre de</td>
        <td align="center" valign="center">Documento</td>
        <td align="center" valign="center">Email</td>
        <td align="center" valign="center">N&uacute;mero de recibo</td>
        <td align="center" valign="center">N&uacute;mero de autorizaci&oacute;n</td>
        <td align="center" valign="center">Importe</td>
        <td align="center" valign="center">Descuento</td>
        <td align="center" valign="center">Direcci&oacute;n</td>
        <td align="center" valign="center">Comentarios</td>
        <td align="center" valign="center">Forma de pago</td>
        <td align="center" valign="center">Tipo de pago</td>
        <td align="center" valign="center">Estado</td>
        <td align="center" valign="center">Fecha</td>
        <td align="center" valign="center">Fecha de creado</td>
    </tr>
<?php
foreach($sql as $row){
    
?>
    <tr>
        <td align="center" valign="center"><?=$row["id"]?></td>
        <td align="center" valign="center"><?=$row["id_inscripto"]?></td>
        <td align="center" valign="center"><?=$row["recibo_a"]?></td>
        <td align="center" valign="center"><?=$row["documento"]?></td>
        <td align="center" valign="center"><?=$row["email"]?></td>
        <td align="center" valign="center"><?=$row["numero_recibo"]?></td>
        <td align="center" valign="center"><?=$row["numero_autorizacion"]?></td>
        <td align="center" valign="center"><?=$row["importe"]?></td>
        <td align="center" valign="center"><?=$row["descuento"]?></td>
        <td align="center" valign="center"><?=$row["direccion"]?></td>
        <td align="center" valign="center"><?=$row["comentarios"]?></td>
        <td align="center" valign="center"><?php 
		if ($row["forma_pago"] == '1' || $row["forma_pago"] == '2')
			echo str_replace("Tarjeta de Crédito: ", "", $lang->getValue($lang->set["FORMA_PAGO_RECIBO"]["array"][$row["forma_pago"]]));
		else {
			echo str_replace("Giro: ", "", $lang->getValue($lang->set["FORMA_PAGO_RECIBO"]["array"][$row["forma_pago"]]));
		}
		?></td>
        <td align="center" valign="center"><?php //Tipo de pago
			if ($row["forma_pago"] == '1' || $row["forma_pago"] == '2') {
				$dato = $row["id_inscripto"].$row["email"];
				$sqlTipoPago = $db->query("SELECT credit_card_type FROM inscriptos_tarjeta WHERE id_inscripto = ? ORDER BY id DESC", array(md5($dato)))->first();
				//$sqlTipoPago = $db->get("inscriptos_tarjeta", ["id_inscripto", "=", md5($dato)])->first();
				if (count($sqlTipoPago) > 0) {
					echo $sqlTipoPago["credit_card_type"];
				}
			}
        ?></td>
        <td align="center" valign="center"><?php
			$sqlEstadoPago = $db->get("pago_aprobado", ["id_inscripto", "=", $row["id_inscripto"]])->first();
			if (count($sqlEstadoPago) > 0)
				echo '1';
			else
				echo '0';
		?></td>
        <td align="center" valign="center"><?=$row["fecha"]?></td>
        <td align="center" valign="center"><?=$row["fecha_creado"]?></td>
    </tr>
<?php
}
?>
</table>

