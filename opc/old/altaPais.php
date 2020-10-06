<?
include('inc/sesion.inc.php');
include('conexion.php');

?>
<link href="estilos.css" rel="stylesheet" type="text/css">
<?
$url = "altaPaisEnviar.php";
$titulo = "Alta";

if($_GET["id"] != "")
{
	$url = "gestionPais.php?modificar=true&id=" .$_GET["id"];
	$titulo = "Modificar";
    $sql = "SELECT * FROM paises WHERE ID_Paises=" . $_GET["id"];
	   $rs = mysql_query($sql,$con);
	   while ($row = mysql_fetch_array($rs)){
	   $pais_viejo = $row["Pais"];
	   $pais_ing_viejo = $row["Pais_ing"];
		}
}
?>
<script src="js/paises.js"></script>
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? if ($_GET["sola"]!=1){?>
<? include "inc/vinculos.inc.php";?> 
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CCCCCC">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php"; ?></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F0E6F0" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:16px"><div align="center"><font color="#666666" size="3"><br>
<strong>
<?=$titulo;?>
</strong> <br>
Pa&iacute;s </font><br>
    <br>
    </div>
      
        <table width="100%" border="1" cellpadding="5" cellspacing="2" bordercolor="#CCCCCC" bgcolor="#ECF4F9">
          <tr valign="top">
            <td width="50%" rowspan="2" >
			<? }?>
			<form name="form1" method="post" action="<?=$url;?>">
						
					<table width="380" height="100"  border="0" cellpadding="5" cellspacing="0">
                <tr valign="top" bordercolor="#FFFFFF">
                  <td bgcolor="#ECF4F9" class="crono_trab">Antes de agregar un pa&iacute;s compruebe que no exista en la lista </td>
                </tr>
                <tr valign="top" bordercolor="#FFFFFF">
                  <td bgcolor="#ECF4F9"><input name="pais_" type="text" id="pais_" size="30"  style=" width:370;"></td>
                </tr>
                <tr valign="top" bordercolor="#FFFFFF">
                  <td bgcolor="#ECF4F9" class="crono_trab">En ingl&eacute;s</td>
                </tr>
                <tr valign="top" bordercolor="#FFFFFF">
                  <td bgcolor="#ECF4F9"><input name="pais_ing" type="text" id="pais_ing" size="30"  style=" width:370;"></td>
                </tr>
                <tr valign="top" bordercolor="#FFFFFF">
                  <td bgcolor="#ECF4F9"><div align="right"><font size="2">
                    <input type="button" name="Submit" value="<?=$titulo;?> pa&iacute;s" onClick="Validar()">
                  </font></div></td>
                </tr>
            </table>
			
			 <input name="sola" type="hidden" value="<?=$_GET["sola"]?>">  
			 <input name="pais_viejo" type="hidden" id="pais_viejo" value="<?=$pais_viejo?>" >
             <input name="pais_ing_viejo" type="hidden" id="pais_ing_viejo" value="<?=$pais_ing_viejo?>" >
		 </form>
		 <? if ($_GET["sola"]!=1){?> 
			</td>
            <td width="50%" bordercolor="#999999" bgcolor="#FEFFEA"><font size="2"><strong>Paises Existentes: </strong></font></td>
          </tr>
          <tr valign="top">
            <td width="50%" bordercolor="#999999" bgcolor="#FEFFEA"><font size="2">
			<?
	$sql = "SELECT * FROM paises ORDER by Pais ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
	
	echo  "<a href='altaPais.php?id=" . $row["ID_Paises"]  .  "'><img src='img/modificar.png' border='0' alt='Modificar este País'></a>";
	
	echo  "<a href='javascript:eliminar(" .  $row["ID_Paises"] . ")'><img src='img/eliminar.png' border='0'  alt='Eliminar este Paíss'></a> ";
	
	echo $row["Pais"] . " / " . $row["Pais_ing"] . "<br>";

	}
	  ?>
</font></td>
          </tr>
        </table>

    </td>
  </tr>
</table>
<? }

if($_GET["id"] != ""){
	
	echo "<script>document.form1.pais_.value='$pais_viejo';</script>\n";
	echo "<script>document.form1.pais_ing.value='$pais_ing_viejo';</script>\n";
	
}
/*LLENO ARRAY PARA VER QUE NO EXISTA*/
	$sql = "SELECT * FROM paises ORDER by Pais ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
	
	if($row["Pais"]!=$pais_viejo){
	echo "<script>arrayPaisNuevo.push('" . $row["Pais"] ."')</script>\n";
	}
}
?>
<script>form1.pais_.focus();</script>