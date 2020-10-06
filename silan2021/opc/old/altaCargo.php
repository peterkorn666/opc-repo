<?
include('inc/sesion.inc.php');
include('conexion.php');
?>
<link href="estilos.css" rel="stylesheet" type="text/css">
<?
$url = "altaCargoEnviar.php";
$titulo = "Alta";

if($_GET["id"] != "")
{
	$url = "gestionCargo.php?modificar=true&id=" .$_GET["id"];
	$titulo = "Modificar";
  		  $sql = "SELECT * FROM cargos WHERE ID_Cargo = " . $_GET["id"];
			$rs = mysql_query($sql,$con);
			while ($row = mysql_fetch_array($rs)){
			$cargo_viejo = $row["Cargos"];
		
		}
}
	  

?>
<script src="js/cargos.js"></script>
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
 <? if ($_GET["sola"]!=1){?>  
<? include "inc/vinculos.inc.php";?>
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CCCCCC">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php";?></td>
  </tr>
  <tr>
    <td valign="top"><div align="center"><br>
        <font color="#666666"><strong><?=$titulo;?> </strong></font><strong><font color="#666666" size="3">Cargo</font></strong><br>
  <table width="100%" border="1" cellpadding="5" cellspacing="2" bordercolor="#CCCCCC">
    <tr valign="top">
      <td width="50%" height="10" rowspan="2" valign="top" bordercolor="#000000" bgcolor="#000000">
	 <? } ?>
	 
	 <form name="form1" method="post" action="<?=$url;?>">
	 
	 
	  <table width="380" height="100"  border="0" cellpadding="4" cellspacing="0">
        <tr valign="top">
          <td height="10" bgcolor="#CCCCCC"><font class="crono_trab">Antes de agregar un cargo compruebe que no exista en la lista.</font> </td>
        </tr>
        <tr valign="top">
          <td height="10" bgcolor="#CCCCCC">
            <input name="cargo_" type="text" id="cargo_" size="55"   style=" width:370;">
        </td>
        </tr>
        <tr valign="top">
          <td height="10" bgcolor="#CCCCCC"><div align="right"><font size="2">
              <input name="Submit" type="button" class="botones"  onClick="Validar()" value="<?=$titulo;?> Cargo">
          </font></div></td>
        </tr>
      </table>    
	  
	  
	   <input name="sola" type="hidden" value="<?=$_GET["sola"]?>">  
	   <input name="cargo_viejo" type="hidden" id="cargo_viejo" value="<?=$cargo_viejo?>">
	  </form>
	       <? if ($_GET["sola"]!=1){?>  
        </td>
      <td width="50%" height="10" bordercolor="#999999" bgcolor="#666666"><font color="#FFFFFF" size="2"><strong>Tipos de Cargos Existentes:</strong></font></td>
    </tr>
    <tr valign="top">
      <td width="50%" bordercolor="#999999" bgcolor="#FFFFCC"><font size="2">
        <?
	$sql = "SELECT * FROM cargos ORDER by Cargos ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
	
	echo  "<a href='altaCargo.php?id=" . $row["ID_Cargo"]  . "'><img src='img/modificar.png' border='0' alt='Modificar este Cargo'></a>";
	echo  "<a href='javascript:eliminar(" .  $row["ID_Cargo"] . ")'><img src='img/eliminar.png' border='0'  alt='Eliminar este Cargo'></a> ";
	echo $row["Cargos"] . "<br>";
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
	
	echo "<script>document.form1.cargo_.value='$cargo_viejo';</script>\n";
	
}
/*LLENO ARRAY PARA VER QUE NO EXISTA*/
	$sql = "SELECT * FROM cargos ORDER by Cargos ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
	
	if($row["Cargos"]!=$cargo_viejo){
	
	echo "<script>arrayCargoNuevo.push('" . $row["Cargos"] ."')</script>\n";
	}
}
?>
<script>form1.cargo_.focus();</script>