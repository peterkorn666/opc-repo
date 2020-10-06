<?
include('inc/sesion.inc.php');
include('conexion.php');
?>
<link href="estilos.css" rel="stylesheet" type="text/css">
<?

$url = "altaProfesionEnviar.php";
$titulo = "Alta";

if($_GET["id"] != "")
{
	$url = "gestionProfesion.php?modificar=true&id=" .$_GET["id"];
	$titulo = "Modificar";
    	$sql = "SELECT * FROM profesiones WHERE ID_Profesiones = " . $_GET["id"];
		$rs = mysql_query($sql,$con);
		while ($row = mysql_fetch_array($rs)){
		$profesion_viejo = $row["Profesion"];
		}
}
?>
<script src="js/profesiones.js"></script>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? if ($_GET["sola"]!=1){?>
<? include "inc/vinculos.inc.php";?> 
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CCCCCC">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php";?></td>
  </tr>
  <tr>
    <td valign="top"><div align="center"><br>
        <font color="#666666"><strong><?=$titulo;?> </strong></font><strong><font color="#666666" size="3">Profesion</font></strong><br>
        <br>

  <table width="100%" border="1" cellpadding="5" cellspacing="2" bordercolor="#CCCCCC">
    <tr valign="top">
      <td width="50%" height="10" rowspan="2" valign="top" bordercolor="#000000" bgcolor="#000000">
	 <? }?>
	 
	 <form name="form1" method="post" action="<?=$url;?>">
	
	  <table width="380" height="100"  border="0" cellpadding="4" cellspacing="0">
        <tr valign="top">
          <td height="10" bgcolor="#CCCCCC"><font color="#FF0000" size="1" class="crono_trab">Antes de agregar una profesi&oacute;n compruebe que no exista en la lista </font></td>
        </tr>
        <tr valign="top">
          <td height="10" bgcolor="#CCCCCC">
            <input name="profesion_" type="text" id="profesion_"  style=" width:370;">
      </td>
        </tr>
        <tr valign="top">
          <td height="10" bgcolor="#CCCCCC"><div align="right"><font size="2">
              <input name="Submit" type="button" class="botones"  onClick="Validar()" value="<?=$titulo;?> profesion">
          </font></div></td>
        </tr>
      </table> 
	  
	 <input name="sola" type="hidden" value="<?=$_GET["sola"]?>">  
	  <input name="profesion_viejo" type="hidden" id="profesion_viejo" value="<?=$profesion_viejo?>">
	
	 </form> 
	 
		 <? if ($_GET["sola"]!=1){?>     
        </td>
      <td width="50%" height="10" bordercolor="#999999" bgcolor="#666666"><font color="#FFFFFF" size="2"><strong>Tipos de profesiones Existentes:</strong></font></td>
    </tr>
    <tr valign="top">
      <td width="50%" bordercolor="#999999" bgcolor="#FFFFCC"><font size="2">
        <?
	$sql = "SELECT * FROM profesiones ORDER by Profesion ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
	
	echo  "<a href='altaProfesion.php?id=" . $row["ID_Profesiones"]  . "'><img src='img/modificar.png' border='0' alt='Modificar esta profesión'></a>";
	echo  "<a href='javascript:eliminar(" .  $row["ID_Profesiones"] . ")'><img src='img/eliminar.png' border='0'  alt='Eliminar esta profesión'></a> ";
	echo $row["Profesion"] . "<br>";
	}
	  ?>
      </font></td>
    </tr>
  </table>

<br>
    </div></td>
  </tr>
</table>
<? }
if($_GET["id"] != ""){
	
	echo "<script>document.form1.profesion_.value='$profesion_viejo';</script>\n";
	
}
	/*LLENO ARRAY PARA VER QUE NO EXISTA*/

	$sql = "SELECT * FROM profesiones ORDER by Profesion ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
	
	if($row["Profesion"]!=$profesion_viejo){
	echo "<script>arrayProfesionNuevo.push('" . $row["Profesion"] ."')</script>\n";
	}
	}
?>
<script>form1.profesion_.focus();</script>