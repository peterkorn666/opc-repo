<?
include('inc/sesion.inc.php');
include('conexion.php');
?>
<link href="estilos.css" rel="stylesheet" type="text/css">
<?
$url = "altaRubroEnviar.php";
$titulo = "Alta";

if($_GET["id"] != "")
{
	$url = "gestionRubro.php?modificar=true&id=" .$_GET["id"];
	$titulo = "Modificar";
  	$sql = "SELECT * FROM rubros WHERE ID_rubro = " . $_GET["id"] . " limit 1;";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs))
		{
		$idViejo = $_GET["id"];
		$rubroVieja = $row["rubro"];
		$rubroDesc = $row["descripcion"];
		}
}


?>


<script src="js/rubros.js"></script>
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "inc/vinculos.inc.php";?>
<? if ($_GET["sola"]!=1){?>
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#ECF4F9">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php";?></td>
  </tr>
  <tr>
    <td valign="top"><div align="center"><br>
        <strong><font color="#666666"><?=$titulo;?>
        Rubro</font></strong><br>
      <br>
        
          <table width="100%" border="1" cellpadding="5" cellspacing="2" bordercolor="#CCCCCC">
            <tr valign="top">
              <td width="50%" rowspan="2" valign="top"><font size="2">
              </font>
			  
			  <? }?>
			  <form name="form1" method="post" action="<?=$url;?>">
			    <table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif">
                        <tr>
                            <td  colspan="2" height="10"  class="crono_trab">
                                    Antes de agregar un rubro compruebe que no exista en la lista 	
                            </td>
                         </tr>
                         <tr>
                            <td  > 
                                Rubro
                            </td>
                            <td> 
                                <input name="rubro_"  type="text" id="rubro_" size="23">
                            </td>
                         </tr>
                         <tr>
                            <td  > 
                                Descripcion
                            </td>
                            <td > 
                                <input name="descripcion_" type="text" id="descripcion_" size="23">
                            </td>
                         </tr>
                         <tr>
                            <td  colspan="2" class="crono_trab">
                               <input name="Submit" type="button" class="botones" onClick="Validar()" value="<?=$titulo;?> Rubro">
                            </td>
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
              <td width="50%" height="10" bordercolor="#999999" bgcolor="#666666"><font color="#FFFFFF" size="2"><strong>Rubros Existentes: </strong></font></td>
            </tr>
            <tr valign="top">
              <td width="50%" bordercolor="#999999" bgcolor="#FFFFCC"><font size="2">
                <?
	$sql = "SELECT * FROM rubros ORDER by rubro ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
	
		
	echo  "<a href='altaRubro.php?id=" . $row["id_rubro"]  . "'><img src='img/modificar.png' border='0' alt='Modificar este Rubro'></a>";
	echo  "<a href='javascript:eliminar(" .  $row["id_rubro"] . ")'><img src='img/eliminar.png' border='0'  alt='Eliminar este Rubro'></a> ";
	
	
	echo $row["rubro"] . "<br>";
	
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

//echo "Rubro: " . $rubroVieja;
//echo "Desc: " . $rubroDesc;
//echo "Id: " . $_GET["id"];
//exit();
	
if($_GET["id"] != ""){
	
	echo "<script>document.form1.rubro_.value='$rubroVieja';
	document.form1.descripcion_.value='$rubroDesc';</script>\n";
	
}
///////LLENO LOS ARRAYS
	$sql = "SELECT * FROM rubros ORDER by rubro ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs))
{
	/*LLENO ARRAY PARA VER QUE NO EXISTA*/
	if($row["rubro"]!=$rubroVieja)
	{
	echo "<script>arrayRubroNuevo.push('" . $row["Sala"] ."')</script>\n";
	//echo "<script>arraySalaObsNuevo.push('" . $row["Sala_obs"] ."')</script>\n";
	}
}
?>
<script>form1.rubro_.focus();</script>