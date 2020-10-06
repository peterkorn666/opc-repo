<?php
session_start();
header("Content-Disposition: attachment; filename=cuentas_".date("Ymd").".xls");
header('Content-Type: text/html; charset=utf-8');
require_once("../class/core.php");
require_once("../class/util.class.php");
$util = new util();
$core = new core();
$util->isLogged();
$config = $core->getConfig();

function echotd($contenido,$prop)
{
	if($contenido==""){
		$contenido="&nbsp;";
	}
	echo "<td $prop>$contenido</td>";
}


$sql = $core->query("SELECT * FROM cuentas ORDER BY id DESC");
?>
<meta charset="utf-8">
<table width="98%" height="39" border="1"  bordercolor="#000000" cellspacing="0">
	<tr>
		<td>ID</td>
        <td>Trabajos</td>
        <td>Nombre</td>
        <td>Apellido</td>
        <td>Email</td>
        <td>Trabajos</td>
        <td>Clave</td>
        <td>Fecha</td>
        <td>Activo</td>
    </tr>
<?php
foreach($sql as $row){
    $tls = '';
    $core->bind('id', $row['id']);
    $tl = $core->query('SELECT * FROM trabajos_libres WHERE id_cliente=:id');
    foreach($tl as $t)
        $tls .= $t['numero_tl'].', ';
?>
    <tr>
        <td><?=$row["id"]?></td>
        <td><?=trim($tls, ', ')?>&nbsp;</td>
        <td><?=$row["nombre"]?></td>
        <td><?=$row["apellido"]?></td>
        <td><?=$row["email"]?></td>
        <td><?=count($tl)?></td>
        <td><?=$row["clave"]?>&nbsp;</td>
        <td><?=$row["fecha"]?></td>
        <td>1</td>
    </tr>
<?php
}
?>
</table>

