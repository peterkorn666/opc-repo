<?
session_start();
header("Content-Disposition: attachment; filename=Congreso_completo_".date("Y-m-d").".xls");
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
	<td bgcolor="#CCCCCC">D&iacute;a</td>	
	<td bgcolor="#CCCCCC">Orden Sala</td>
	<td bgcolor="#CCCCCC">Sala</td>
	<td bgcolor="#CCCCCC">Hora</td>
    <td bgcolor="#CCCCCC">Tipo de actividad</td>
	<td bgcolor="#CCCCCC">T&iacute;tulo Actividad o Sesi&oacute;n</td>
    <td bgcolor="#CCCCCC">Rol - En calidad de</td>
	<td bgcolor="#CCCCCC">T&iacute;tulo de su Presentaci&oacute;n</td>
	<td bgcolor="#CCCCCC">ID Conf</td>
	<td bgcolor="#CCCCCC">T&iacute;tulo acad&eacute;mico</td>
	<td bgcolor="#CCCCCC">Nombre</td>
	<td bgcolor="#CCCCCC">Apellido</td>
    <td bgcolor="#CCCCCC">Instituci&oacute;n</td>
    <td bgcolor="#CCCCCC">Cargo/Ocupaci&oacute;n</td>
    <td bgcolor="#CCCCCC">G&eacute;nero</td>
    <td bgcolor="#CCCCCC">Documento/Pasaporte</td>
    <td bgcolor="#CCCCCC">Tel&eacute;fono</td>
    <td bgcolor="#CCCCCC">Mail</td>
	<td bgcolor="#CCCCCC">Pa&iacute;s</td>
    <td bgcolor="#CCCCCC">Comentarios de la persona</td>
    <td bgcolor="#CCCCCC">CV abreviado</td>
    <td bgcolor="#CCCCCC">Comentarios del Administrador</td>
    <td bgcolor="#CCCCCC">Otros Roles</td>
    <td bgcolor="#CCCCCC">Cantidad de Actividades</td>
	</tr>
<?php
$sqlCDSH = $core->query("SELECT c.start_date, c.tipo_actividad, c.titulo_actividad, 
								s.orden, s.name, 
								cc.en_calidad, cc.titulo_conf, 
								conf.id_conf, conf.profesion, conf.nombre, conf.apellido, conf.institucion, conf.cargo, conf.genero, conf.documento, conf.telefono, conf.email, conf.pais, conf.comentarios, conf.cv_abreviado, conf.admin_comentarios 
								FROM cronograma as c 
									JOIN salas as s ON s.salaid=c.section_id 
									JOIN crono_conferencistas as cc ON cc.id_crono=c.id_crono 
									JOIN conferencistas as conf ON conf.id_conf=cc.id_conf 
								ORDER BY SUBSTRING(c.start_date,1,10), s.orden");
								
foreach($sqlCDSH as $rowCDSH){
	$hora_ini = substr($rowCDSH["start_date"], 11, 5);
?>	
	<tr>
        <td><?=$rowCDSH["start_date"]?></td>
        <td><?=$rowCDSH["orden"]."&nbsp;"?></td>
        <td><?=sacarBR($rowCDSH["name"])?></td>
        <td><?=$hora_ini?></td>
        <td>
        <?php
            if($rowCDSH["tipo_actividad"])
                echo $core->getNameTipoActividadID($rowCDSH["tipo_actividad"])["tipo_actividad"];
        ?>
        </td>
        <td><?=sacarBR($rowCDSH["titulo_actividad"])?></td>
        <td><?php
            if($rowCDSH["en_calidad"])
                echo $core->getRolID($rowCDSH["en_calidad"])["calidad"];
            ?>
        </td>	
        <td><?=sacarBR($rowCDSH["titulo_conf"])?></td>
        <td><?=$rowCDSH["id_conf"]?></td>
        <td><?=$rowCDSH["profesion"]?></td>
        <td><?=$rowCDSH["nombre"]?></td>
        <td><?=$rowCDSH["apellido"]?></td>
        <td><?php
                if($rowCDSH["institucion"])
                    echo $core->getInstitution($rowCDSH["institucion"])["Institucion"];
            ?>
        </td>
        <td><?=$rowCDSH["cargo"]?></td>
        <td><?=$rowCDSH["genero"]?></td>
        <td><?=$rowCDSH["documento"]?></td>
        <td><?=$rowCDSH["telefono"]?></td>
        <td><?=$rowCDSH["email"]?></td>
        <td><?php
            	if($rowCDSH["pais"])
                	echo $core->getPais($rowCDSH["pais"])["Pais"];
            ?>
        </td>
        <td><?=$rowCDSH["comentarios"]?></td>
        <td><?=$rowCDSH["cv_abreviado"]?></td>
        <td><?=$rowCDSH["admin_comentarios"]?></td>
        <?php
            $contador_actividades = 0;
            $roles = "";
            $conferencistas = $core->getCronoConferencistasByConf($rowCDSH["id_conf"]);
            foreach($conferencistas as $conferencista) {
                $arr = $core->getRolID($conferencista["en_calidad"]);
                $roles = $roles . $arr["calidad"] . ", ";
                $contador_actividades = $contador_actividades + 1;
            }
            $roles = trim($roles, ", ");
        ?>
        <td><?php echo $roles; ?></td>
        <td><?=$contador_actividades?></td>
	</tr>
<?php	
}

?>
</table>


