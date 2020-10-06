<?
header("Content-Disposition: attachment; filename=Todos_las_personas_".date("Ymd").".xls");
include('inc/sesion.inc.php');
require "conexion.php";
function echotd($contenido,$prop)
{
	if($contenido==""){
		$contenido="&nbsp;";
	}
	echo "<td $prop>$contenido</td>";
}


$sqlTOTAL = "SELECT * FROM conferencistas as c JOIN crono_conferencistas as cc USING(id_conf) JOIN cronograma as g USING(id_crono) ORDER BY c.apellido ASC;";
$rsTOTAL = mysql_query($sqlTOTAL, $con) or die(mysql_error());
?>
<meta charset="utf-8">
<table width="98%" height="39" border="1"  bordercolor="#000000" cellspacing="0">
<tr>
		<td>ID</td>
		<td>Profesion</td>
		<td>Nombre</td>
		<td>Apellido</td>
        <td>Día</td>
        <td>Sala</td>
        <td>Título actividad</td>
        <td>Título</td>
		<td>Género</td>
		<td>Institución</td>
		<td>Cargo / Ocupación</td>
		<td>Documento / Pasaporte</td>
		<td>Teléfono</td>
		<td>Email</td>
		<td>Ciudad</td>
		<td>País</td>
		<td>Comentarios</td>
		<td>Redes sociales</td>
		<td>Cv Abreviado</td>
		<td>Hotel</td>
		<td>IN</td>
		<td>OUT</td>
		<td>Compañia Arribo</td>
		<td>Vuelo Arribo</td>
		<td>Fecha Arribo</td>
		<td>Hora Arribo</td>
		<td>Compañia Partida</td>
		<td>Vuelo Partida</td>
		<td>Fecha Partida</td>
		<td>Hora Partida</td>
		<td>Inscripto</td>
		<td>Cartas Enviadas</td>	
		<td>Roles</td>		
		<td>Cantidad de Actividades</td>	
</tr>
	<?
while($totalTLS = mysql_fetch_array($rsTOTAL)){
	if($totalTLS["inscripto"]=="1"){
		$inscripto = "Si";	
	}else{
		$inscripto = "No";	
	}
?>
<tr>
		<td><?=$totalTLS["id_conf"]?></td>
		<td><?=$totalTLS["profesion"]?></td>
		<td><?=$totalTLS["nombre"]?></td>
		<td><?=$totalTLS["apellido"]?></td>
        <td><?=$totalTLS["start_date"]?></td>
        <td><?php
			if($totalTLS["section_id"])
			{
        		$gSala = mysql_query("SELECT * FROM salas WHERE salaid='{$totalTLS["section_id"]}'", $con);
				$sala = mysql_fetch_array($gSala);
				echo $sala["name"];
			}
			?>
        </td>
        <td><?=$totalTLS["titulo_actividad"]?></td>
        <td><?=$totalTLS["titulo_conf"]?></td>
		<td><?=$totalTLS["genero"]?></td>
		<td><?php
				if($totalTLS["institucion"])
				{
					$gIns = mysql_query("SELECT * FROM instituciones WHERE ID_Instituciones='{$totalTLS["institucion"]}'", $con);
					$ins = mysql_fetch_array($gIns);
					echo $ins["Institucion"];
				}
			?></td>
		<td><?=$totalTLS["cargo"]?></td>
		<td><?=$totalTLS["documento"]?></td>
		<td><?=$totalTLS["telefono"]?></td>
		<td><?=$totalTLS["email"]?></td>
		<td><?=$totalTLS["ciudad"]?></td>
		<td><?php
			if($totalTLS["pais"])
			{
				$gPais = mysql_query("SELECT * FROM paises WHERE ID_Paises='{$totalTLS["pais"]}'", $con);
				$pais = mysql_fetch_array($gPais);
				echo $pais["Pais"];
			}
			?></td>
		<td><?=$totalTLS["comentarios"]?></td>
		<td><?=$totalTLS["redes_sociales"]?></td>
		<td><?=$totalTLS["cv_abreviado"]?></td>
		<td><?=$totalTLS["hotel"]?></td>
		<td><?=$totalTLS["hotel_in"]?></td>
		<td><?=$totalTLS["hotel_out"]?></td>
		<td><?=$totalTLS["hotel_compania_in"]?></td>
		<td><?=$totalTLS["hotel_vuelo_in"]?></td>
		<td><?=$totalTLS["hotel_fecha_in"]?></td>
		<td><?=$totalTLS["hotel_fecha_out"]?></td>
		<td><?=$totalTLS["hotel_compania_out"]?></td>
		<td><?=$totalTLS["hotel_vuelo_out"]?></td>
		<td><?=$totalTLS["hotel_fecha_out"]?></td>
		<td><?=$totalTLS["hotel_hora_out"]?></td>
		<td><?=$inscripto?></td>
		<td><?=str_replace("<br />", "", $totalTLS["cartasEnviadas"])?></td>
<?        
		$sql = "SELECT * FROM crono_conferencistas WHERE id_conf = '".$totalTLS["id_conf"]."'";
		$rs = mysql_query($sql, $con);
		$roles = "";
		$casillero = "";
		$cant = mysql_num_rows($rs);
		while($row = mysql_fetch_array($rs)){
				if($row["en_calidad"]!=""){
					$gRoles = mysql_query("SELECT * FROM calidades_conferencistas WHERE ID_calidad='{$row["en_calidad"]}'", $con);
					$rol = mysql_fetch_array($gRoles);
					$roles .= $rol["calidad"].", ";
				}
		}	
		$roles = substr($roles,0,-2);
?>		
		<td><?=$roles?></td>
		<td><?=$cant?></td>
</tr>
<?
}
$sqlSA = "SELECT * FROM conferencistas as c JOIN crono_conferencistas as cc ON cc.id_conf";
?>
<tr>
	<!-- SIN ACTIVIDADES -->
    <td><?=$totalTLS["id_conf"]?></td>
    <td><?=$totalTLS["profesion"]?></td>
    <td><?=$totalTLS["nombre"]?></td>
    <td><?=$totalTLS["apellido"]?></td>
    <td><?=$totalTLS["start_date"]?></td>
    <td><?php
        if($totalTLS["section_id"])
        {
            $gSala = mysql_query("SELECT * FROM salas WHERE salaid='{$totalTLS["section_id"]}'", $con);
            $sala = mysql_fetch_array($gSala);
            echo $sala["name"];
        }
        ?></td>
    <td><?=$totalTLS["genero"]?></td>
    <td><?php
            if($totalTLS["institucion"])
            {
                $gIns = mysql_query("SELECT * FROM instituciones WHERE ID_Instituciones='{$totalTLS["institucion"]}'", $con);
                $ins = mysql_fetch_array($gIns);
                echo $ins["Institucion"];
            }
        ?></td>
    <td><?=$totalTLS["cargo"]?></td>
    <td><?=$totalTLS["documento"]?></td>
    <td><?=$totalTLS["telefono"]?></td>
    <td><?=$totalTLS["email"]?></td>
    <td><?=$totalTLS["ciudad"]?></td>
    <td><?php
        if($totalTLS["pais"])
        {
            $gPais = mysql_query("SELECT * FROM paises WHERE ID_Paises='{$totalTLS["pais"]}'");
            $pais = mysql_fetch_array($gPais);
            echo $pais["Pais"];
        }
        ?></td>
    <td><?=$totalTLS["comentarios"]?></td>
    <td><?=$totalTLS["redes_sociales"]?></td>
    <td><?=$totalTLS["cv_abreviado"]?></td>
    <td><?=$totalTLS["hotel"]?></td>
    <td><?=$totalTLS["hotel_in"]?></td>
    <td><?=$totalTLS["hotel_out"]?></td>
    <td><?=$totalTLS["hotel_compania_in"]?></td>
    <td><?=$totalTLS["hotel_vuelo_in"]?></td>
    <td><?=$totalTLS["hotel_fecha_in"]?></td>
    <td><?=$totalTLS["hotel_fecha_out"]?></td>
    <td><?=$totalTLS["hotel_compania_out"]?></td>
    <td><?=$totalTLS["hotel_vuelo_out"]?></td>
    <td><?=$totalTLS["hotel_fecha_out"]?></td>
    <td><?=$totalTLS["hotel_hora_out"]?></td>
    <td><?=$inscripto?></td>
    <td><?=str_replace("<br />", "", $totalTLS["cartasEnviadas"])?></td>		
    <td></td>
    <td>0</td>
</tr>
</table>

