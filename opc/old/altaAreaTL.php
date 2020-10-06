<?
include "inc/sesion.inc.php";
include('conexion.php');
?>
<link href="estilos.css" rel="stylesheet" type="text/css">
<?


$url = "altaAreaTLEnviar.php";
$titulo = "Alta";

if($_GET["id"] != "")
{
	$url = "gestionAreaTL.php?modificar=true&id=" .$_GET["id"];
	$titulo = "Modificar";
  	$sql = "SELECT * FROM areas_trabjos_libres WHERE id = " . $_GET["id"] . " limit 1;";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs))
		{
		$idViejo = $_GET["id"];
		$ordenViejo = $row["orden"];
		$areaVieja = $row["Area"];
		}
}

?>
<script src="js/areasTL.js"></script>
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? if ($_GET["sola"]!=1){?>
<? include "inc/vinculos.inc.php";?>
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CCCCCC">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php";?></td>
  </tr>
  <tr>
    <td valign="top"><div align="center"><br>
        <font color="#666666"><strong><?=$titulo;?> </strong></font><strong><font color="#666666" size="3">Areas de <font color="#000000">Trabajos Libres </font></font></strong><br>
        <br>

  <table width="100%" border="1" cellpadding="5" cellspacing="2" bordercolor="#CCCCCC">
    <tr valign="top">
      <td width="50%" height="10" rowspan="2" valign="top" bordercolor="#000000" bgcolor="#000000">
	<?
	}
	?>
	<form name="form1" method="post" action="<?=$url;?>">
	
	
	  <table width="100%"  border="0" cellspacing="0" cellpadding="4">
        <tr valign="top">
        <?
			if($_GET["orden"]){
				echo "<script>alert('El orden ya existe.');</script>";
			}
		?>
          <td height="10" bgcolor="#E6DEEB"><font color="#FF0000" size="2" class="crono_trab">Orden<br>
          <select name="orden_area">
          	<?
				for($i=1;$i<=16;$i++){
					if($i==$ordenViejo){
						$sel = "selected";
					}
					echo "<option value='$i' $sel>$i</option>";
					$sel = "";
				}
			?>
            </select>
          </font></td>
        </tr>
        <tr valign="top">
          <td height="10" bgcolor="#E6DEEB"><font color="#FF0000" size="2" class="crono_trab">Antes de agregar un area compruebe que no exista en la lista </font></td>
        </tr>
        <tr valign="top">
          <td height="10" bgcolor="#E6DEEB"><font size="2">
            <input name="area_" type="text" id="area_" size="55"  style=" width:370;">
          </font></td>
        </tr>
        <tr valign="top">
          <td height="10" bgcolor="#E6DEEB"><div align="right"><font size="2">
              <input name="Submit" type="button" class="botones"  onClick="Validar()" value="<?=$titulo;?> Area">
          </font></div></td>
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
	$sql = "SELECT * FROM areas_trabjos_libres ORDER by Area ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
	
	echo  "<a href='altaAreaTL.php?id=" . $row["id"]  . "'><img src='img/modificar.png' border='0' alt='Modificar esta area'></a>";
	echo  "<a href='javascript:eliminar(" .  $row["id"] . ")'><img src='img/eliminar.png' border='0'  alt='Eliminar esta area'></a> ";
	echo $row["orden"]." - ".$row["Area"] . "<br>";
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
	
	echo "<script>document.form1.area_.value='$areaVieja';</script>\n";
	
}
/*LLENO ARRAY PARA VER QUE NO EXISTA*/
	$sql = "SELECT * FROM areas_trabjos_libres ORDER by orden ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){	
	if($row["Area"]!=$areaVieja){
	echo "<script>arrayAreasTL.push('" . $row["Area"] ."')</script>\n";
	}
}
?>

<script>form1.area_.focus();</script>