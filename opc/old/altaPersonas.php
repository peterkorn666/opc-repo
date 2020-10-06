<?
include('inc/sesion.inc.php');
include('conexion.php');
?>
<link href="estilos.css" rel="stylesheet" type="text/css">

<script src="js/personas.js"></script>
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


$url = "altaPersonasEnviar.php";
$titulo = "Alta";

if($_GET["id"] != ""){
	$url = "modificarPersonasEnviar.php";
	$titulo = "Modificar";
	$sql = "select  * from personas where ID_Personas = " . $_GET["id"] . " limit 1;";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
		$idViejo = $_GET["id"];
		$profecionViejo = $row["profesion"];
		$nombreViejo = $row["nombre"];
		$apellidoViejo = $row["apellido"];
		$cargoViejo = $row["cargo"];
		$institucionViejo = $row["institucion"];
		$paisViejo = $row["pais"];
		$mailViejo = $row["email"];
		$idiomaViejo = $row["idioma_hablado"];
		$currViejo = $row["cv"];
	}
}

?>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
  <? if ($_GET["sola"]!=1){?>  
<? include "inc/vinculos.inc.php";?>
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#F0E6F0">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php"; ?></td>
  </tr>
  <tr>
    <td valign="top"><p align="center"><strong><font color="#666666" size="3" face="Trebuchet MS, Arial, Helvetica, sans-serif"><br>
     <?=$titulo?> Personas</font></strong></p>
    <table width="100%" border="1" cellpadding="2" cellspacing="2" bordercolor="#CCCCCC">
      <tr>
        <td colspan="2" valign="top" bordercolor="#000000" bgcolor="#000000"><? }?>
            <form action="<?=$url?>" method="post" enctype="multipart/form-data" name="form1">
              <table width="100%" height="100%" border="00" cellpadding="5" cellspacing="0" bgcolor="#CCCCCC" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif">
               
                <tr bgcolor="#FFFFFF">
                  <td width="64" height="10" bgcolor="#ECF4F9"><font size="2">Profesi&oacute;n:</font></td>
                  <td width="345" height="10" bgcolor="#ECF4F9"><font size="2">
                  <select name="profesion_" id="profesion_" style="width:170px"></select>
                  <a href="javascript:agregar('altaProfesion.php', '80')">Agregar Profesi&oacute;n</a></font></td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td width="64" height="10" bgcolor="#ECF4F9"><font size="2">Nombre:</font></td>
                  <td height="10" bgcolor="#ECF4F9"><font size="2">
                    <input name="nombre_" type="text" id="nombre_" style="width:170px">
                  </font></td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td width="64" height="10" bgcolor="#ECF4F9"><font size="2">Apellidos:</font></td>
                  <td height="10" bgcolor="#ECF4F9"><font size="2">
                    <input name="apellidos_" type="text" id="apellidos_" style="width:170px">
                  </font></td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td width="64" height="10" bgcolor="#ECF4F9"><font size="2">Cargo:</font></td>
                  <td height="10" bgcolor="#ECF4F9"><font size="2">
				  
  		         <select name="cargo_" id="cargo_" style="width:170px;"></select>
                  <a href="javascript:agregar('altaCargo.php', '50')">Agregar Cargo</a></font></td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td width="64" height="10" bgcolor="#ECF4F9"><font size="2">Instituci&oacute;n:</font></td>
                  <td height="10" bgcolor="#ECF4F9"><font size="2">
             
				<select name="institucion_" id="institucion_" style="width:170px"></select>
				<a href="javascript:agregar('altaInstitucion.php', '50')">Agregar Instituci&oacute;n</a></font> </td>
				</tr>
                <tr bgcolor="#FFFFFF">
                  <td height="10" bgcolor="#ECF4F9"><font size="2">Pa&iacute;s:</font></td>
                  <td height="10" bgcolor="#ECF4F9"><font size="2">

				<select name="pais_" id="pais_" style="width:170px" ></select>
				<a href="javascript:agregar('altaPais.php', '50')">Agregar Pa&iacute;s</a></font></td>
			    </tr>
                <tr bgcolor="#FFFFFF">
                  <td height="10" bgcolor="#ECF4F9"><font size="2">E-mail:</font></td>
                  <td height="10" bgcolor="#ECF4F9"><font size="2">
                    <input name="mail_" type="text" id="mail_" style="width:170px">
                  </font></td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td height="10" bgcolor="#ECF4F9"><font size="2">Idioma Hablado:</font></td>
                  <td height="10" bgcolor="#ECF4F9"><font size="2">
                    <select name="idioma_" id="idioma_" style="width:170px" >
                    <option value="">&nbsp;</option>
                    <option value="English" <? if ($idiomaViejo=="English"){ echo "selected"; }?> >Ingl&eacute;s</option>
                    <option value="Spanish" <? if ($idiomaViejo=="Spanish"){ echo "selected"; }?> >Espa&ntilde;ol</option>
                    </select>
                  </font></td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td width="64" height="10" bgcolor="#ECF4F9"><font size="2">Curriculum:</font></td>
                  <td height="10" bgcolor="#ECF4F9"><font size="2">
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
                <tr valign="top" bgcolor="#FFFFFF">
                  <td bgcolor="#ECF4F9"><font size="2">&nbsp;</font></td>
                  <td bgcolor="#ECF4F9"><font size="2">
                    <input name="Submit" type="button" class="botones" onClick="ValidarPersona()" value="<?=$titulo?> persona"   style=" width:170;">
                  </font></td>
                </tr>
              </table>
			  <input name="combo" type="hidden" value="<?=$_GET["combo"]?>"> 
              <input name="sola" type="hidden" value="<?=$_GET["sola"]?>">
			  <input name="idViejo" type="hidden" value="<?=$idViejo?>">
            </form>
          <? if ($_GET["sola"]!=1){?>		  </td>
<td width="50%" valign="top"  bordercolor="#999999" bgcolor="#666666"><iframe frameborder="0"   src="listadoPersonas.php?indice=A" style="width:100%; height:408;" scrolling="no"></iframe></td>
       </tr>
      </table>
	 <p align="center"><strong><font color="#666666" size="3" face="Arial, Helvetica, sans-serif"><br></font></strong></p>
	</td>
  </tr>
</table>

<? 
}
?>

<script>

	llenarProfesiones();
	llenarCargos();
    llenarInstituciones();
	llenarPaises();
 
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
	$sql = "SELECT * FROM personas ORDER by Apellidos ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
	
	if($row["Apellidos"]!=$apellidoViejo){
	echo "<script>arrayApellidoExisten.push('" . $row["Apellidos"] ."');</script>\n";
	echo "<script>arrayNombreExisten.push('" . $row["Nombre"] ."');</script>\n";
	
	}
}
?>