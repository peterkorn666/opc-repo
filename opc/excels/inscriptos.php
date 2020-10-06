<?php
session_start();
header("Content-Disposition: attachment; filename=inscriptos_".date("Y-m-d").".xls");
header('Content-Type: text/html; charset=utf-8');
require_once("../class/util.class.php");
require_once("../class/core.php");
require_once("../inscripcion/clases/lang.php");
$util = new util();
$core = new core();
$util->isLogged();
$config = $core->getConfig();
$lang = new Language("es");

$inscriptos = $core->query("SELECT * FROM inscriptos");
?>
<title>Excel Inscriptos</title>
<meta charset="utf-8">
<style>
.table td {
	align: center;
	valign: top;
}
</style>
<table>
	<thead>
    	<th>ID</th>
        <th>Nº Pasaporte</th>
        <!--<th>Comprobante</th>-->
        <th>Apellido</th>
        <th>Nombre</th>
        <th>Pago</th>
        <th>Filiación institucional</th>
        <th>Profesión / Titulación</th>
        <th>Ciudad</th>
        <th>País</th>
        <th>Teléfono</th>
        <th>Email</th>
        <th>Costo</th>
        <th>Categoría</th>
        <th>Forma Pago</th>
        <!--<th>Pagó institucion u otro</th>
        <th>Nº comprobante del que pagó</th>
        <th>Nº inscripto que pagó</th>-->
        <th>Comentarios</th>
        <th>Descuento</th>
        <th>Fecha de Pago</th>
        <!--<th>Link comprobante</th>-->
    </thead>
    <tbody>
<?php
foreach($inscriptos as $inscripto){
	if($inscripto["tipo_inscripcion"]===2)
		$costos_inscripcion = $lang->set["COSTOS_INSCRIPCION_JORNADA_PADRES"]["array"];
	else
		$costos_inscripcion = $lang->set["COSTOS_INSCRIPCION"]["array"];
	$link_comprobante = "";
	if($inscripto["comprobante_archivo"]){
		$link_comprobante = 'opc.tea2018.org/inscripcion/comprobantes/'.$inscripto["comprobante_archivo"];
	}
	//$costo_inscripcion = $inscripcion->getOpcionPrecioByID($inscripto["costos_inscripcion"]);
	$costo_inscripcion = $core->row("SELECT * FROM inscripcion_costos WHERE id=".$inscripto["costos_inscripcion"]);
?>
	<tr>
        <td><?=$inscripto["id"]?></td>
        <td><?=$inscripto["numero_pasaporte"]?></td>
        <!--<td><?php //echo $inscripto["numero_comprobante"]?></td>-->
        <td><?=$inscripto["apellido"]?></td>
        <td><?=$inscripto["nombre"]?></td>
        <td><?=$inscripto["estado"]?></td>
        <td><?=$inscripto["institucion"]?></td>
        <td><?=$inscripto["profesion"]?></td>
        <td><?=$inscripto["ciudad"]?></td>
        <td><?=$core->getPaisID($inscripto["pais"]);?></td>
        <td><?=$inscripto["telefono"]?></td>
        <td><?=$inscripto["email"]?></td>
        <td><?php
			if($inscripto["costos_inscripcion"]){
				echo $costo_inscripcion["precio"];
			}else
				echo "";
		?></td>
        <td><?php
			if($inscripto["costos_inscripcion"]){
				echo $costo_inscripcion["nombre"];
			}else
				echo "";
		?></td>
        <td><?php
			//$forma_pago = $inscripcion->getOpcionFormaPagoByID($inscripto["forma_pago"]);
			$forma_pago = $core->row("SELECT * FROM inscripcion_formas_pago WHERE id=".$inscripto["forma_pago"]);
			if($inscripto["forma_pago"]){
				echo $forma_pago["nombre"];
			}else
				echo "";
        ?></td>
        <!--<td><?php //echo $inscripto["grupo_check_comprobante"]?></td>
        <td><?php //echo $inscripto["grupo_numero_comprobante"]?></td>
        <td><?php //if($inscripto["key_inscripto"]!==0) echo $inscripto["key_inscripto"]; ?></td>-->
        <td><?=$inscripto["comentarios"]?></td>
        <td><?=$inscripto["descuento"]?></td>
        <td><?=substr($inscripto["fecha_pago"],0,10)?></td>
        <!--<td><?=$link_comprobante?></td>-->
    </tr>
<?php
}
?>
    </tbody>
</table>