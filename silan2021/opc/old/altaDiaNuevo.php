<?
include('inc/sesion.inc.php');
include('conexion.php');
?>
<link href="estilos.css" rel="stylesheet" type="text/css">
<?


$url = "altaDiaEnviarNuevo.php";
$titulo = "Alta";

if($_GET["id"] != "")
{
	$url = "gestionDia.php?modificar=true&id=" .$_GET["id"];
	$titulo = "Modificar";
  	$sql = "SELECT * FROM dias WHERE ID_Dias=" . $_GET["id"];
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs))
		{
		$idViejo = $_GET["id"];
		  $dia_viejo = $row["Dia"];
		  $dia_ing_viejo = $row["Dia_ing"];
	      $orden_viejo = $row["Dia_orden"];
		  $visible = $row["visible"];
		
		}
}
	  
?>
<script src="js/dias.js"></script>
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? if ($_GET["sola"]!=1){?>
<? include "inc/vinculos.inc.php";?>
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CCCCCC">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php"; ?></td>
  </tr>
  <tr>
    <td valign="top"><div align="center"><strong><font color="#666666" size="3">&nbsp;<br>
&nbsp;<?=$titulo;?> D&iacute;a</font></strong><br>
    </div>
    
	  
        <table width="100%" border="1" cellpadding="5" cellspacing="2" bordercolor="#CCCCCC">
          <tr valign="top">
            <td width="50%" rowspan="2" bgcolor="#000000">
		 	<? } ?>
			<form name="form1" method="post" action="<?=$url;?>">
			<table width="380" height="100"  border="0" cellpadding="5" cellspacing="0">
                <tr valign="top" bordercolor="#FFFFFF">
                  <td height="10" bgcolor="#CCCCCC" class="crono_trab">Antes de agregar un d&iacute;a compruebe que no exista en la lista </td>
                </tr>
                <tr valign="top" bordercolor="#FFFFFF">
                  <td height="10" bgcolor="#CCCCCC"><font size="2">Orden
                      <select name="orden_" id="orden_">
                        <? for($i=1;$i<=9;$i++){
			  $e = "0".$i;
			  ?>
                        <option value="<?=$i?>">
                          <?=$e?>
                        </option>
                        <? } ?>
                        <? for($i=10;$i<=35;$i++){?>
                        <option value="<?=$i?>">
                          <?=$i?>
                        </option>
                        <? }?>
                      </select>
                    Nombre de d&iacute;a
                        <input name="dia_" type="text" id="dia_" size="25">
                  </font></td>
                </tr>
                 <tr valign="top" bordercolor="#FFFFFF">
                  <td height="10" bgcolor="#CCCCCC"><font size="2">En ingl&eacute;s</font> <input name="dia_ing" type="text" id="dia_ing" size="25"></td>
                </tr>
                <tr valign="top" bordercolor="#FFFFFF">
                   <td height="10" bgcolor="#CCCCCC"><font size="2">Visible: &nbsp;&nbsp;Si
<input type="radio" name="visible" value="1" <?=($visible==1?"checked":"")?>>&nbsp;&nbsp;&nbsp; No <input type="radio" name="visible" value="0" <?=($visible==0?"checked":"")?>></font></td>
                </tr>
                <tr valign="top" bordercolor="#FFFFFF">
                  <td height="10" bgcolor="#CCCCCC"><div align="right"><font size="2">
                      <input name="Submit" type="button" class="botones" onClick="Validar()" value="<?=$titulo;?> d&iacute;a">
                  </font></div></td>
                </tr>
            </table>
			<input name="sola" type="hidden" value="<?=$_GET["sola"]?>">
			 <input name="dia_viejo" type="hidden" id="dia_viejo" value="<?=$dia_viejo;?>" >
             <input name="dia_ing_viejo" type="hidden" id="dia_ing_viejo" value="<?=$dia_ing_viejo;?>" >
		 <input name="orden_viejo" type="hidden" id="orden_viejo" value="<?=$orden_viejo;?>" >
		      </form>
		<? if ($_GET["sola"]!=1){?>
			</td>
            <td width="50%" bordercolor="#999999" bgcolor="#666666"><font color="#FFFFFF" size="2"><strong>D&iacute;as Existentes: </strong></font></td>
          </tr>
          <tr valign="top">
            <td width="50%" bordercolor="#999999" bgcolor="#FFFFCC"><font size="2">
              <?
	$sql = "SELECT * FROM dias ORDER by Dia_orden ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
	
	echo  "<a href='altaDia.php?id=" . $row["ID_Dias"]  . "'><img src='img/modificar.png' border='0' alt='Modificar este día'></a>";
	
	echo  "<a href='javascript:eliminar(" .  $row["ID_Dias"] . ")'><img src='img/eliminar.png' border='0'  alt='Eliminar este día'></a> ";
	
	if($row["Dia_orden"]<=9){
		$salacon0= "0".$row["Dia_orden"];
	}
	else
	{
		$salacon0=$row["Dia_orden"];
	}
	
	echo $salacon0 . " - " . $row["Dia"] . " / " . $row["Dia_ing"]. "<br>";
	
	}
	  ?>
            </font></td>
          </tr>
        </table>
   
	  	
    <strong><font color="#666666" size="3"></font></strong></td>
  </tr>
</table>
	<? }
	
	
if($_GET["id"] != ""){
	
	echo "<script>document.form1.dia_.value='$dia_viejo';
	document.form1.dia_ing.value='$dia_ing_viejo';
	document.form1.orden_.value='$orden_viejo';</script>\n";
	
}
/*LLENO ARRAY PARA VER QUE NO EXISTA*/
	$sql = "SELECT * FROM dias ORDER by Dia_orden ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
	
	if($row["Dia"]!=$dia_viejo){
	echo "<script>arrayDiasNuevo.push('" . $row["Dia"] ."')</script>\n";
	echo "<script>arrayDiasOrdenNuevo.push('" . $row["Dia_orden"] ."')</script>\n";
	}
}
?>
	<script>form1.dia_.focus();</script>