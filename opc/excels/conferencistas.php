<?php
session_start();
header("Content-Disposition: attachment; filename=conferencistas_".date("Y-m-d").".xls");
header('Content-Type: text/html; charset=utf-8');
require_once("../class/util.class.php");
require_once("../class/core.php");
$util = new util();
$core = new core();
$util->isLogged();
$config = $core->getConfig();

$conferencistas = $core->getConferencistas();
?>
<title>Excel Conferencistas</title>
<meta charset="utf-8">
<table>
	<thead>
    	<th>Nombre</th>
        <th>Apellido</th>
        <th>Organización</th>
        <th>Puesto</th>
        <th>Web</th>
        <th>Email</th>
        <th>Biografía</th>
        <th>Categorias</th>
        <th>Foto</th>
        <th>Orden</th>
        <th>Puntuable</th>
    </thead>
    <tbody>
<?php

//$dirFija = 'http://opc.tea2018.org/conf_fotos/';
foreach($conferencistas as $conferencista){
	$rowInstitucion = $core->getInstitution($conferencista['institucion']);
?>
	<tr>
        <td><?=$conferencista['nombre']?></td>
        <td><?=$conferencista['apellido']?></td>
        <td><?=$rowInstitucion['Institucion']?></td>
        <td></td>
        <td><?=$conferencista['redes_sociales']?></td>
        <td><?=$conferencista['email']?></td>
        <td><?=$conferencista['cv_abreviado']?></td>
        <td></td>
        <td><?=$dirFija.$conferencista['archivo_foto']?></td>
        <td></td>
        <td>No</td>
     </tr>
<?php 
} 
?>
    </tbody>
</table>