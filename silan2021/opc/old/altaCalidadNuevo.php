<?
include('inc/sesion.inc.php');
include('conexion.php');

?>
<link href="estilos.css" rel="stylesheet" type="text/css">
<?

$url = "altaCalidadEnviarNuevo.php";
$titulo = "Alta";

if($_GET["id"] != "")
{
	$url = "gestionCalidad.php?modificar=true&id=" .$_GET["id"];
	$titulo = "Modificar";
  	  $sql = "SELECT * FROM en_calidades WHERE ID_En_calidad = " . $_GET["id"];
	  $rs = mysql_query($sql,$con);
	  while ($row = mysql_fetch_array($rs)){
	  $calidad_viejo = $row["En_calidad"];
	  $calidad_ing_viejo = $row["En_calidad_ing"];
		}
}

?>
<script src="js/en_calidades.js"></script>
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
 <? if ($_GET["sola"]!=1){?>  
<? include "inc/vinculos.inc.php";?>
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#F0E6F0">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php";?></td>
  </tr>
  <tr>
    <td valign="top" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:16px"><div align="center"><br>
        <font ><strong><?=$titulo;?> </strong></font><font size="3"><br>
        Calidad / Roles</font><br>
        <br>

  <table width="100%" border="1" cellpadding="5" cellspacing="2" bordercolor="#CCCCCC"  >
    <tr valign="top">
      <td width="50%" height="10" rowspan="2" valign="top" bordercolor="#000000"   >
	 <? }?>
	 <form name="form1" method="post" action="<?=$url;?>">
	   <table width="380" height="100"  border="0" cellpadding="4" cellspacing="0" bgcolor="#ECF4F9">
	   <tr valign="top">
	     <td height="10" bgcolor="#ECF4F9" class="crono_trab"><table width="380" height="100"  border="0" cellpadding="4" cellspacing="0">
	       <tr valign="top">
	         <td height="10" bgcolor="#ECF4F9" class="crono_trab">Antes de agregar una calidad compruebe que no exista en la lista </td>
	         </tr>
	       <tr valign="top">
	         <td height="10" bgcolor="#ECF4F9"><input name="calidad_" type="text" id="calidad_" size="55"  style=" width:370;"></td>
	         </tr>
	       <tr valign="top">
	         <td height="10" bgcolor="#ECF4F9" class="crono_trab">En ingl&eacute;s</td>
	         </tr>
	       <tr valign="top">
	         <td height="10" bgcolor="#ECF4F9"><input name="calidad_ing" type="text" id="calidad_ing" size="55"  style=" width:370;"></td>
	         </tr>
	       <tr valign="top">
	         <td height="10" bgcolor="#ECF4F9"><div align="right"><font size="2">
	           <input name="Submit" type="button" class="botones"  onClick="Validar()" value="<?=$titulo;?> calidad">
	           </font></div></td>
	         </tr>
	       </table></td>
	   </tr>
	   </table>
	   <input name="sola" type="hidden" value="<?=$_GET["sola"]?>"> 
		<input name="combo" type="hidden" value="<?=$_GET["combo"]?>"> 
		 <input name="calidad_viejo" type="hidden" id="calidad_viejo" value="<?=$calidad_viejo?>">
         <input name="calidad_ing_viejo" type="hidden" id="calidad_ing_viejo" value="<?=$calidad_ing_viejo?>">
	  </form>    
	   <? if ($_GET["sola"]!=1){?>    
        </td>
      <td width="50%" height="10" bordercolor="#999999" bgcolor="#FEFFEA"><font  size="2"><strong>Tipos de calidades Existentes:</strong></font></td>
    </tr>
    <tr valign="top">
      <td width="50%" bordercolor="#999999" bgcolor="#FEFFEA"><font size="2">
        <?
	$sql = "SELECT * FROM en_calidades ORDER by En_calidad ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
	
	echo  "<a href='altaCalidad.php?id=" . $row["ID_En_calidad"]  . "'><img src='img/modificar.png' border='0' alt='Modificar esta calidad'></a>";
	echo  "<a href='javascript:eliminar(" .  $row["ID_En_calidad"] . ")'><img src='img/eliminar.png' border='0'  alt='Eliminar esta calidad'></a> ";
	echo $row["En_calidad"] . " / " . $row["En_calidad_ing"] . "<br>";
	}
	  ?>
      </font></td>
    </tr>
  </table>

<br>
    </div></td>
  </tr>
</table>
<?
}

if($_GET["id"] != ""){
	
	echo "<script>document.form1.calidad_.value='$calidad_viejo';</script>\n";
	echo "<script>document.form1.calidad_ing.value='$calidad_ing_viejo';</script>\n";
	
}
/*LLENO ARRAY PARA VER QUE NO EXISTA*/
$sql = "SELECT * FROM en_calidades ORDER by En_calidad ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
	
	if($row["En_calidad"]!=$calidad_viejo){
	
	echo "<script>arrayCalidadNuevo.push('" . $row["En_calidad"] ."')</script>\n";
	}
}
?>

<script>form1.calidad_.focus();</script>