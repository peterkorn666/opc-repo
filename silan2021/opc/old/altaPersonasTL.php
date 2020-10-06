<?
if($_GET["sola"]!=1){
include('inc/sesion.inc.php');
}
include('conexion.php');
?>
<link href="estilos.css" rel="stylesheet" type="text/css">

<script src="js/personasTL.js"></script>
<script src="js/profesiones.js"></script>
<script src="js/cargos.js"></script>
<script src="js/instituciones.js"></script>
<script src="js/paises.js"></script>

<?
require("clases/personas.php");

$cargarArray = new personas();
$cargarArray->profesiones();
$cargarArray->cargos();
$cargarArray->instituciones();
$cargarArray->paises();

$url = "altaPersonasEnviarTL.php";
$titulo = "Alta";

$combo = $_GET["combo"];

if($_GET["id"] != ""){
	$url = "modificarPersonasEnviarTL.php";
	$titulo = "Modificar";
	$sql = "select  * from personas_trabajos_libres where ID_Personas = " . $_GET["id"] . " limit 1;";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
		$idViejo = $_GET["id"];
		$profecionViejo = $row["Profesion"];
		$nombreViejo = $row["Nombre"];
		$apellidoViejo = $row["Apellidos"];
		$cargoViejo = $row["Cargos"];
		$institucionViejo = $row["Institucion"];
		$paisViejo = $row["Pais"];
		$mailViejo = $row["Mail"];
		$currViejo = $row["Curriculum"];
	}
}

?>
<? if ($_GET["sola"]!=1){?>
<? include "inc/vinculos.inc.php";?>
  
<table width="1200" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CCCCCC">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php"; ?></td>
  </tr>
  <tr>
    <td valign="top"><p align="center"><strong><font color="#666666" size="3" face="Arial, Helvetica, sans-serif"><br>
     <?=$titulo?>
      Personas de trabajos libres </font></strong></p>
      <table width="100%" border="1" cellpadding="2" cellspacing="2" bordercolor="#CCCCCC">
      <tr>
        <td colspan="2" valign="top" bordercolor="#000000" bgcolor="#E6DEEB">
		<? }?>
            <form action="<?=$url?>" method="post" enctype="multipart/form-data" name="form1" >
              <table width="95%" height="95%" border="00" cellpadding="5" cellspacing="0" bgcolor="#E6DEEB" class="popop_box">
                <tr bgcolor="#FFFFFF">
                  <td width="74" height="10" bgcolor="#E6DEEB"><font size="2">Nombre:</font></td>
                  <td width="194" height="10" bgcolor="#E6DEEB"><font size="2">
                    <input name="nombre_" type="text" id="nombre_" style="width:170px">
                  </font></td>
                  <td width="74" bgcolor="#E6DEEB"><font size="2">Profesi&oacute;n:</font></td>
                  <td width="368" bgcolor="#E6DEEB"><font size="2">
                    <select name="profesion_" id="profesion_" style="width:170px">
                    </select>
                  <a href="javascript:agregar('altaProfesion.php', '80')">Agregar Profesi&oacute;n</a></font></td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td width="74" height="10" bgcolor="#E6DEEB"><font size="2">Apellidos:</font></td>
                  <td height="10" bgcolor="#E6DEEB"><font size="2">
                    <input name="apellidos_" type="text" id="apellidos_" style="width:170px">
                  </font></td>
                  <td bgcolor="#E6DEEB"><font size="2">Cargo:</font></td>
                  <td bgcolor="#E6DEEB"><font size="2">
                    <select name="cargo_" id="cargo_" style="width:170px;">
                    </select>
                  <a href="javascript:agregar('altaCargo.php', '50')">Agregar Cargo</a></font></td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td height="10" bgcolor="#E6DEEB"><font size="2">Instituci&oacute;n:</font></td>
                  <td height="10" bgcolor="#E6DEEB"><font size="2">
                    <select name="institucion_" id="institucion_" style="width:170px">
                    <?php
						$sqlI = mysql_query("SELECT * FROM instituciones ORDER BY Institucion",$con);
						while($rowI = mysql_fetch_array($sqlI)){
							if($institucionViejo==$rowI["ID_Instituciones"])
								$chki = "selected";
							echo '<option value="'.$rowI["ID_Instituciones"].'" '.$chki.'>'.$rowI["Institucion"].'</option>';
							$chki = "";
						}
					?>
                    </select>
                  <a href="javascript:agregar('altaInstitucion.php', '50')">Agregar Instituci&oacute;n</a></font></td>
                  <td bgcolor="#E6DEEB"><font size="2">Curriculum:</font></td>
                  <td bgcolor="#E6DEEB"><font size="2">
                    <?
					  if($currViejo!=""){
					  	echo "Existente: <b>'$currViejo'</b><br>";
						?>
                    <input name="eliminar_curr" type="checkbox" id="eliminar_curr" value="si">
Eliminar curriculum existente
<?
						echo "<br>Desea colocarle uno nuevo<br>";
					  }
					?>
<input name="archivo" type="file" id="archivo" style="width:270px">
                  </font></td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td width="74" height="10" bgcolor="#E6DEEB"><font size="2">Pa&iacute;s:</font></td>
                  <td height="10" bgcolor="#E6DEEB"><font size="2">
                    <select name="pais_" id="pais_" style="width:170px" >
                    <?php
						$sqlP = mysql_query("SELECT * FROM paises ORDER BY Pais",$con);
						while($rowP = mysql_fetch_array($sqlP)){
							if($paisViejo==$rowP["ID_Paises"])
								$chkp = "selected";
							echo '<option value="'.$rowP["ID_Paises"].'" '.$chkp.'>'.$rowP["Pais"].'</option>';
							$chkp = "";
						}
					?>
                    </select>
                  <a href="javascript:agregar('altaPais.php', '50')">Agregar Pa&iacute;s</a></font></td>
                  <td bgcolor="#E6DEEB">&nbsp;</td>
                  <td bgcolor="#E6DEEB">&nbsp;</td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td width="74" height="10" bgcolor="#E6DEEB"><font size="2">E-mail:</font></td>
                  <td height="10" bgcolor="#E6DEEB"><font size="2">
                    <input name="mail_" type="text" id="mail_" style="width:170px">
                  </font></td>
                  <td bgcolor="#E6DEEB">&nbsp;</td>
                  <td bgcolor="#E6DEEB"><font size="2">
                    <input name="Submit" type="button" class="botones" onClick="ValidarPersonaTL()" value="<?=$titulo?> persona"   style=" width:170;">
                  </font></td>
                </tr>
              </table>
			  <input name="combo" type="hidden" value="<?=$combo?>">
              <input name="sola" type="hidden" value="<?=$_GET["sola"]?>">
			  <input name="idViejo" type="hidden" value="<?=$idViejo?>">
            </form>
          <? if ($_GET["sola"]!=1){?>		  </td>
       </tr>
      <!--<tr>
        <td colspan="2" valign="top">&nbsp;</td>
        <td valign="top" class="textos">Con marca: <a href="#" onClick="unificarPersonas()">Unificar Personas</a></td>
      </tr>-->
      </table>
	  <iframe frameborder="0"  id="listado" name="listado"  src="listadoPersonasTL.php" style="width:100%; height:1200px" scrolling="no"></iframe><br>
<br>
<br>

	</td>
  </tr>
</table>

<?
}
?>

<script>

	llenarProfesiones();
	llenarCargos();
   // llenarInstituciones();
	 // llenarPaises();


</script>
<?
if($_GET["id"] != ""){

	echo "<script>seleccionarProfesiones('$profecionViejo');</script>\n";
	echo "<script>document.form1.nombre_.value='$nombreViejo';</script>\n";
	echo "<script>document.form1.apellidos_.value='$apellidoViejo';</script>\n";
	echo "<script>seleccionarCargos('$cargoViejo');</script>\n";
	echo "<script>seleccionarInstituciones('$institucionViejo');</script>\n";
	echo "<script>seleccionarPaises('$paisViejo');</script>\n";
	echo "<script>document.form1.mail_.value='$mailViejo';</script>\n";

}
$sql = "SELECT * FROM personas_trabajos_libres ORDER by Apellidos ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
	
	if($row["Apellidos"]!=$apellidoViejo){
	echo "<script>arrayApellidoExisten.push('" . $row["Apellidos"] ."');</script>\n";
	echo "<script>arrayNombreExisten.push('" . $row["Nombre"] ."');</script>\n";
	
	}
}
?>