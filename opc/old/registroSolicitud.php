<?php
	 header("Content-Disposition: attachment; filename=Todas_las_Solicitudes.xls");

require "conexion.php";
require("clases/class.baseController.php");
$base = new baseController();
$query = $base->getInscriptos();
?>
<table width="100%" border="1" cellspacing="2" cellpadding="1">
  <tr>
    <td>ID</td>
    <td>Nombre</td>
    <td>Apellido</td>
    <td>Entidad</td>
    <td>Cargo</td>
    <td>Direcci&oacute;n</td>
    <td>Ciudad</td>
    <td>Provincia</td>
    <td>Pa&iacute;s</td>
    <td>Tel&eacute;fono</td>
    <td>Cel</td>
    <td>E-mail</td>
    <td>Clave</td>
    <td>Fecha</td>
  </tr>
<?
while($row = mysql_fetch_object($query)){
?>
  <tr>
    <td><?=$row->ID_Personas?></td>
    <td><?=$row->personal_nombre?></td>
    <td><?=$row->personal_apellido?></td>
    <td><?=$row->entidad_razon_social?></td>
    <td><?=$row->personal_cargo?></td>
    <td><?=$row->entidad_direccion?></td>
    <td><?=$row->entidad_ciudad?></td>
    <td><?=$row->entidad_provincia?></td>
    <td><?=$row->entidad_pais?></td>
    <td>&nbsp;<?=$row->entidad_tel_codigo." ".$row->entidad_tel?></td>
    <td>&nbsp;<?=$row->personal_celular_codigo." ".$row->personal_celular?></td>
    <td><?=$row->entidad_mail?></td>
    <td><?=$row->clave?></td>
    <td>&nbsp;<?=$row->fecha?></td>
  </tr>
<?
}
?>
</table>
