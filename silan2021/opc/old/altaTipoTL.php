<?
include('inc/sesion.inc.php');
include('conexion.php');
?>
<link href="estilos.css" rel="stylesheet" type="text/css">

<script src="js/tipoTL.js"></script>
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? if ($_GET["sola"]!=1){?>
<? include "inc/vinculos.inc.php";?>
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CCCCCC">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php";?></td>
  </tr>
  <tr>
    <td valign="top"><div align="center"><br>
        <font color="#666666"><strong>Alta </strong></font><strong><font color="#666666" size="3">Tipo de <font color="#000000">Trabajos Libres </font></font></strong><br>
        <br>

  <table width="100%" border="1" cellpadding="5" cellspacing="2" bordercolor="#CCCCCC">
    <tr valign="top">
      <td width="50%" height="10" rowspan="2" valign="top" bordercolor="#000000" bgcolor="#000000">
	<?
	}
	?>
	<form name="form1" method="post" action="altaTipoTLEnviar.php">
	
	
	  <table width="100%"  border="0" cellspacing="0" cellpadding="4">
        <tr valign="top">
          <td height="10" bgcolor="#E6DEEB"><font color="#FF0000" size="2" class="crono_trab">Antes de agrgar un area compruebe que no exista en la lista </font></td>
        </tr>
        <tr valign="top">
          <td height="10" bgcolor="#E6DEEB"><font size="2">
            <input name="tipo_" type="text" id="tipo_" size="55"  style=" width:370;">
          </font></td>
        </tr>
        <tr valign="top">
          <td height="10" bgcolor="#E6DEEB"><div align="right"><font size="2">
              <input name="Submit" type="button" class="botones"  onClick="Validar()" value="Agregar tipo de trabajos libre">
          </font></div></td>
        </tr>
      </table>      
	  
	  <input name="sola" type="hidden" value="<?=$_GET["sola"]?>">
	  </form>
	    
<? if ($_GET["sola"]!=1){?>
		
        </td>
      <td width="50%" height="10" bordercolor="#999999" bgcolor="#666666"><font color="#FFFFFF" size="2"><strong>Tipos  Existentes:</strong></font></td>
    </tr>
    <tr valign="top">
      <td width="50%" bordercolor="#999999" bgcolor="#FFFFCC"><font size="2">
        <?
	$sql = "SELECT * FROM tipo_de_trabajos_libres ORDER by tipoTL ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
		
	echo  "<a href='modificarTipoTL.php?id=" . $row["id"]  . "'><img src='img/modificar.png' border='0' alt='Modificar este tipo'></a>";
	echo  "<a href='javascript:eliminar(" .  $row["id"] . ")'><img src='img/eliminar.png' border='0'  alt='Eliminar este tipo'></a> ";
	echo $row["tipoTL"] . "<br>";
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
$sql = "SELECT * FROM tipo_de_trabajos_libres ORDER by tipoTL ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
	
	/*LLENO ARRAY PARA VER QUE NO EXISTA*/
	echo "<script>arrayTipoTLNuevo.push('" . $row["tipoTL"] ."')</script>\n";
	}
?>
<script>form1.tipo_.focus();</script>