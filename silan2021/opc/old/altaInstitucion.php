<?
include('inc/sesion.inc.php');
include('conexion.php');
?>
<link href="estilos.css" rel="stylesheet" type="text/css">
<?
$url = "altaInstitucionEnviar.php";
$titulo = "Alta";

if($_GET["id"] != "")
	{
	$url = "gestionInstitucion.php?modificar=true&id=" .$_GET["id"];
	$titulo = "Modificar";
  	 $sql = "SELECT * FROM instituciones WHERE ID_Instituciones = " . $_GET["id"];
		$rs = mysql_query($sql,$con);
		while ($row = mysql_fetch_array($rs)){
		$institucion_viejo = $row["Institucion"];
		}
	}

?>
<script  src="js/instituciones.js"></script>
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
  <? if ($_GET["sola"]!=1){?>  
<? include "inc/vinculos.inc.php";?>
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CCCCCC">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php";?></td>
  </tr>
  <tr>
    <td valign="top"><div align="center"><br>
        <font color="#666666"><strong><?=$titulo;?> </strong></font><strong><font color="#666666" size="3">Instituci&oacute;n</font></strong><br>

  <table width="100%" border="1" cellpadding="5" cellspacing="2" bordercolor="#CCCCCC">
    <tr valign="top">
      <td width="50%" height="10" rowspan="3" valign="top" bordercolor="#000000" bgcolor="#000000">
	 <? }?>
	 <form name="form1" method="post" action="<?=$url;?>">
	 
	  <table width="380" height="100"  border="0" cellpadding="4" cellspacing="0">
        <tr valign="top">
          <td height="10" bgcolor="#CCCCCC" class="crono_trab">Antes de agregar una instituci&oacute;n compruebe que no exista en la lista </td>
        </tr>
        <tr valign="top">
          <td height="10" bgcolor="#CCCCCC">
            <input name="institucion_" type="text" id="institucion_" size="55"  style=" width:370;">          </td>
        </tr>
        <tr valign="top">
          <td height="10" bgcolor="#CCCCCC"><div align="right"><font size="2">
              <input name="Submit" type="button" class="botones"  onClick="Validar()" value="<?=$titulo;?> institución">
          </font></div></td>
        </tr>
      </table>
	  
	     <input name="sola" type="hidden" value="<?=$_GET["sola"]?>">  
		  <input name="institucion_viejo" type="hidden" id="institucion_viejo" value="<?=$institucion_viejo?>">
	 </form> 
	    
		<? if ($_GET["sola"]!=1){?> 
		</td><td width="50%" valign="top"  bordercolor="#999999" bgcolor="#666666"><iframe frameborder="0"  id="listado" name="listado"  src="listadoInstituciones.php" style="width:100%; height:408;" scrolling="auto"></iframe></td>
    </tr>
  </table>

<br>
    </div></td>
  </tr>
</table>
<? }

if($_GET["id"] != ""){
	
	echo "<script>document.form1.institucion_.value='$institucion_viejo';</script>\n";
	
}
/*LLENO ARRAY PARA VER QUE NO EXISTA*/
	$sql = "SELECT * FROM instituciones ORDER by Institucion ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
	
	if($row["Institucion"]!=$institucion_viejo){
	
	echo "<script>arrayInstitucionNuevo.push('" . $row["Institucion"] ."')</script>\n";
	}
}
?>
<script>
form1.institucion_.focus();
</script>