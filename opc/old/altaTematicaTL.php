<?
include('inc/sesion.inc.php');
include('conexion.php');
?>
<link href="estilos.css" rel="stylesheet" type="text/css">
<?
$url = "altaTematicaTLEnviar.php";
$titulo = "Alta";

if($_GET["id"] != "")
{
	$url = "gestionTematicaTL.php?modificar=true&id=" .$_GET["id"];
	$titulo = "Modificar";
  	  $sql = "SELECT * FROM tematicas_trabajos_libres WHERE ID_Tematicas = " . $_GET["id"];
	  $rs = mysql_query($sql,$con);
		while ($row = mysql_fetch_array($rs)){
		$tematica_viejo = $row["Tematica"];
		}
}


?>
<script src="js/tematicas.js"></script>
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? if ($_GET["sola"]!=1){?>
<? include "inc/vinculos.inc.php";?>  
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CCCCCC">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php";?></td>
  </tr>
  <tr>
    <td valign="top"><div align="center"><br>
        <font color="#666666"><strong><?=$titulo;?> </strong></font><strong><font color="#666666" size="3">Tem&aacute;ticas en Trabajos </font></strong><br>
        <br>
        <table width="100%" border="1" cellpadding="5" cellspacing="2" bordercolor="#CCCCCC">
    <tr valign="top">
      <td width="50%" height="10" rowspan="2" valign="top" bordercolor="#000000" bgcolor="#000000">
	  
	  <? }?>
	  <form name="form1" method="post" action="<?=$url;?>">
	  
	  	  
	  <table width="380" height="100"  border="0" cellpadding="4" cellspacing="0">
        <tr valign="top">
          <td height="10" bgcolor="#CCCCCC" class="crono_trab">Antes de agregar una tem&aacute;tica compruebe que no exista en la lista </td>
        </tr>
        <tr valign="top">
          <td height="10" bgcolor="#CCCCCC">
            <input name="tematica_" type="text" id="tematica_" size="55"  style=" width:370;">
       </td>
        </tr>
        <tr valign="top">
          <td height="10" bgcolor="#CCCCCC"><div align="right"><font size="2">
              <input name="Submit" type="button" class="botones"  onClick="Validar()" value="<?=$titulo;?> tem&aacute;tica">
          </font></div></td>
        </tr>
      </table>   
	  
	  
	 <input name="sola" type="hidden" value="<?=$_GET["sola"]?>">
	  <input name="tematica_viejo" type="hidden" id="tematica_viejo" value="<?=$tematica_viejo?>">
	  
	  </form>
	       <? if ($_GET["sola"]!=1){?>  
        </td>
      <td width="50%" height="10" bordercolor="#999999" bgcolor="#666666"><font color="#FFFFFF" size="2"><strong>Tem&aacute;ticas Existentes:</strong></font></td>
    </tr>
    <tr valign="top">
      <td width="50%" bordercolor="#999999" bgcolor="#FFFFCC"><font size="2">
        <?
	$sql = "SELECT * FROM tematicas_trabajos_libres ORDER by Tematica ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
	echo  "<a href='altaTematicaTL.php?id=" . $row["ID_Tematicas"]  . "'><img src='img/modificar.png' border='0' alt='Modificar esta temática'></a>";
	echo  "<a href='gestionTematicaTL.php?id=" . $row["ID_Tematicas"]  . "'><img src='img/eliminar.png' border='0'  alt='Eliminar esta temática'></a> ";
	echo $row["Tematica"] . "<br>";
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
	
	echo "<script>document.form1.tematica_.value='$tematica_viejo';</script>\n";
	
}
$sql = "SELECT * FROM tematicas_trabajos_libres ORDER by Tematica ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
	
	if($row["Tematica"]!=$tematica_viejo){
	/*LLENO ARRAY PARA VER QUE NO EXISTA*/
	echo "<script>arrayTematicaTLNuevo.push('" . $row["Tematica"] ."')</script>\n";
	}
}
?>
<script>form1.tematica_.focus();</script>