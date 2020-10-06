<?
include "inc/sesion.inc.php";
include('conexion.php');
?>
<link href="estilos.css" rel="stylesheet" type="text/css">
<?


$url = "altaAreaEnviar.php";
$titulo = "Alta";

if($_GET["id"] != "")
{
	$url = "gestionArea.php?modificar=true&id=" .$_GET["id"];
	$titulo = "Modificar";
  	$sql = "SELECT * FROM areas WHERE ID_Areas = " . $_GET["id"] . " limit 1;";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs))
		{
		$idViejo = $_GET["id"];
		$areaVieja = addslashes($row["Area"]);
		$area_ingVieja = addslashes($row["Area_ing"]);
		}
}

?>
<script src="js/areas.js"></script>
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? if ($_GET["sola"]!=1){?>
<? include "inc/vinculos.inc.php";?>
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#F0E6F0">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php";?></td>
  </tr>
  <tr>
    <td valign="top"><div align="center" style="font:'Trebuchet MS', Arial, Helvetica, sans-serif" ><br>
        <font color="#666666"><strong><?=$titulo;?> </strong></font><strong><font color="#666666" size="3"><br>
      Areas</font></strong><br>
        <br>

  <table width="100%" border="1" cellpadding="5" cellspacing="2" bordercolor="#CCCCCC">
    <tr valign="top">
      <td width="50%" height="10" rowspan="2" valign="top" bordercolor="#000000" bgcolor="#ECF4F9">
	 
	 
	 <? }?>
	 
	 
	 
	 <form name="form1" method="post" action="<?=$url;?>">
	  <table  width="380" height="150"  border="0" cellpadding="4" cellspacing="0" style="background-color:#ECF4F9">
        <tr valign="top">
          <td height="10" bgcolor="#ECF4F9" class="crono_trab">Antes de agregar un &aacute;rea compruebe que no exista en la lista </td>
        </tr>
        <tr valign="top">
          <td height="10" bgcolor="#ECF4F9"><input name="area_" type="text" id="area_" size="55"  style=" width:370;">          </td>
        </tr>
        <tr valign="top">
          <td height="10" bgcolor="#ECF4F9" class="crono_trab">En ingl&eacute;s</td>
        </tr>
        <tr valign="top">
          <td height="10" bgcolor="#ECF4F9"><input name="area_ing" type="text" id="area_ing" size="55"  style=" width:370;">          </td>
        </tr>
        <tr valign="top">
          <td height="10" bgcolor="#ECF4F9"><div align="right">
              <input name="Submit" type="button" class="botones"  onClick="Validar()" value="<?=$titulo;?> Area">
          </div></td>
        </tr>
      </table>  
	  <input name="sola" type="hidden" value="<?=$_GET["sola"]?>">
	  </form>
	    <? if ($_GET["sola"]!=1){?>
	  
	        
        </td>
      <td width="50%" height="10" bordercolor="#999999" bgcolor="#666666"><font color="#FFFFFF" size="2"><strong>Areas Existentes:</strong></font></td>
    </tr>
    <tr valign="top">
      <td width="50%" bordercolor="#999999" bgcolor="#FFFFCC"><font size="2">
      
		<?
	
	$sql = "SELECT * FROM areas ORDER by Area ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
		
	echo  "<a href='altaArea.php?id=" . $row["ID_Areas"]  . "'><img src='img/modificar.png' border='0' alt='Modificar esta area'></a>";
	echo  "<a href='javascript:eliminar(" .  $row["ID_Areas"] . ")'><img src='img/eliminar.png' border='0'  alt='Eliminar esta area'></a> ";
	echo $row["Area"] . " / " . $row["Area_ing"] . "<br>";
	}
	  ?>
      </font></td>
    </tr>
  </table>

<br>
    </div></td>
  </tr>
</table>
<? }?>
<?
if($_GET["id"] != ""){
	
	echo "<script>document.form1.area_.value='$areaVieja';</script>\n";
	echo "<script>document.form1.area_ing.value='$area_ingVieja';</script>\n";
	
}
	$sql = "SELECT * FROM areas ORDER by Area ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
	
	if($row["Area"]!=$areaVieja){
	echo "<script>arrayAreasNuevo.push('" . $row["Area"] ."')</script>\n";
	}
}
	
?>
<script>form1.area_.focus();</script>