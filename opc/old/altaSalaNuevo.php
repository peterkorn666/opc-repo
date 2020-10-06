<?
include('inc/sesion.inc.php');
include('conexion.php');
?>
<link href="estilos.css" rel="stylesheet" type="text/css">
<?
$url = "altaSalaEnviarNuevo.php";
$titulo = "Alta";

if($_GET["id"] != "")
{
	$url = "gestionSala.php?modificar=true&id=" .$_GET["id"];
	$titulo = "Modificar";
  	$sql = "SELECT * FROM salas WHERE ID_Salas = " . $_GET["id"] . " limit 1;";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs))
		{
		$idViejo = $_GET["id"];
		$salaVieja = $row["Sala"];
		$salaIngVieja = $row["Sala_ing"];
		$salaOrdenVieja = $row["Sala_orden"];
		$salaObsVieja = $row["Sala_obs"];
		$visibleVieja = $row["visible"];
		
		}
}


?>


<script src="js/salas.js"></script>
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? if ($_GET["sola"]!=1){?>
<? include "inc/vinculos.inc.php";?>
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#FBEEF9">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php";?></td>
  </tr>
  <tr>
    <td valign="top"><div align="center" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif"><br>
        <strong><font color="#666666"><?=$titulo;?> Sala</font></strong><br>
        
          <table width="100%" border="1" cellpadding="5" cellspacing="2" bordercolor="#CCCCCC">
            <tr valign="top">
              <td bgcolor="#ECF4F9" width="50%" rowspan="2" valign="top" ><font size="2">
              </font>
			  
			  <? }?>
			  <form name="form1" method="post" action="<?=$url;?>">
			    <table width="398" height="100"  border="0" cellpadding="5" cellspacing="0">
			      <tr valign="top" bordercolor="#CCCCCC">
			        <td height="10" colspan="7" bgcolor="#ECF4F9" class="crono_trab">Antes de agregar una sala compruebe que no exista en la lista </td>
		          </tr>
			      <tr valign="top" bordercolor="#CCCCCC">
			        <td width="54" align="right" height="1" bgcolor="#ECF4F9"><font size="2"> Orden <br />
			          </font></td>
			        <td width="82" bgcolor="#ECF4F9"><font size="2">
			          <select name="orden_" id="orden_">
			            <? for($i=1;$i<=9;$i++){
			  $e = "0".$i;
			  ?>
			            <option value="<?=$i?>">
			              <?=$e?>
		                </option>
			            <? } ?>
			            <? for($i=10;$i<=85;$i++){?>
			            <option value="<?=$i?>">
			              <?=$i?>
		                </option>
			            <? }?>
		              </select>
			          </font></td>
			        <td width="74" bgcolor="#ECF4F9"><font size="2">Sala visible:</font></td>
			        <td width="20" bgcolor="#ECF4F9"> <input name="visible" type="radio" value="Si" <?	if($visibleVieja=='Si'){echo "checked";}?>/></td>
			        <td width="28" bgcolor="#ECF4F9"><font size="2">Si</font></td>
			        <td width="21" bgcolor="#ECF4F9"><input name="visible" type="radio" value="No" <?	if($visibleVieja=='No'){echo "checked";}?>/></td>
			        <td width="49" bgcolor="#ECF4F9"><font size="2">No</font></td>
		          </tr>
			      <tr valign="top" bordercolor="#CCCCCC">
			        <td height="1" align="right" colspan="2" bgcolor="#ECF4F9"><font size="2">Nombre de la sala </font></td>
			        <td colspan="5" bgcolor="#ECF4F9"><font size="2">
			          <input name="sala_" type="text" id="sala_" size="30" />
			          </font></td>
		          </tr>
			      <tr valign="top" bordercolor="#CCCCCC">
			        <td height="3" align="right" colspan="2" bgcolor="#ECF4F9"><font size="2">Nombre en Ingl&eacute;s
			          </font></td>
			        <td colspan="5" bgcolor="#ECF4F9"><font size="2">
			          <input name="sala_ing" type="text" id="sala_ing" size="30" />
			          </font></td>
		          </tr>
			      <tr valign="top" bordercolor="#CCCCCC">
			        <td height="5" align="right" colspan="2" bgcolor="#ECF4F9"><font size="2"> Observaciones de la sala </font></td>
			        <td colspan="5" bgcolor="#ECF4F9"><font size="2">
			          <input name="obssala_" type="text" id="obssala_" size="30" />
			          </font></td>
		          </tr>
			      <tr valign="top" bordercolor="#CCCCCC">
			        <td height="10" colspan="7" bgcolor="#ECF4F9"><div align="center"><font size="2">
			          <input name="Submit" type="button" class="botones" onClick="Validar()" value="<?=$titulo;?> sala" />
			          </font></div></td>
		          </tr>
		        </table>
         <input name="sola" type="hidden" value="<?=$_GET["sola"]?>">
				 <input name="sala_viejo" type="hidden" id="sala_viejo" value="<?=$salaVieja;?>" >
                 <input name="sala_ing_viejo" type="hidden" id="sala_ing_viejo" value="<?=$salaIngVieja;?>" >
				 <input name="orden_viejo" type="hidden" id="orden_viejo" value="<?=$salaOrdenVieja;?>" >
                 <input name="obssala_viejo" type="hidden" id="obssala_viejo" value="<?=$salaObsVieja;?>" >
			    </form>
				
				<? if ($_GET["sola"]!=1){?>
				</td>
              <td width="50%" height="10" bordercolor="#999999" bgcolor="#666666"><font color="#FFFFFF" size="2"><strong>Salas Existentes: </strong></font></td>
            </tr>
            <tr valign="top">
              <td width="50%" bordercolor="#999999" bgcolor="#FFFFCC"><font size="2">
                <?
	$sql = "SELECT * FROM salas ORDER by Sala_orden ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
	
		
	echo  "<a href='altaSala.php?id=" . $row["ID_Salas"]  . "'><img src='img/modificar.png' border='0' alt='Modificar este Sala'></a>";
	echo  "<a href='javascript:eliminar(" .  $row["ID_Salas"] . ")'><img src='img/eliminar.png' border='0'  alt='Eliminar esta Sala'></a> ";
	
	if($row["Sala_orden"]<=9){
		$salacon0= "0".$row["Sala_orden"];
	}
	else
	{
		$salacon0=$row["Sala_orden"];
	}
	
	echo $salacon0 . " - " . $row["Sala"] . "<br>";
	
	}
	  ?>
              </font></td>
            </tr>
          </table>
        <br>
       
        </div></td>
  </tr>
</table>
<br>
<? }

if($_GET["id"] != ""){
	
	echo "<script>document.form1.sala_.value='$salaVieja';
	document.form1.sala_ing.value='$salaIngVieja';
	document.form1.orden_.value='$salaOrdenVieja';
	document.form1.obssala_.value='$salaObsVieja';</script>\n";
	
}
///////LLENO LOS ARRAYS
	$sql = "SELECT * FROM salas ORDER by Sala_orden ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs))
{
	/*LLENO ARRAY PARA VER QUE NO EXISTA*/
	if($row["Sala"]!=$salaVieja)
	{
	echo "<script>arraySalaNuevo.push('" . $row["Sala"] ."')</script>\n";
	/*echo "<script>arraySalaIngNuevo.push('" . $row["Sala_ing"] ."')</script>\n";*/
	echo "<script>arraySalaOrdenNuevo.push('" . $row["Sala_orden"] ."')</script>\n";
	//echo "<script>arraySalaObsNuevo.push('" . $row["Sala_obs"] ."')</script>\n";
	}
}
?>
<script>form1.sala_.focus();</script>