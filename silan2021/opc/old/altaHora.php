<?
include('inc/sesion.inc.php');
include('conexion.php');
?>
<link href="estilos.css" rel="stylesheet" type="text/css">

<script  src="js/horas.js"></script>
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<? if ($_GET["sola"]!=1){?>
<? include "inc/vinculos.inc.php";?>
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#ECF4F9">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php";?></td>
  </tr>
  <tr>
    <td valign="top" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif"><div align="center"><font color="#666666" size="3"><strong><br>
      Alta horario </strong></font><br>
       
          <table width="100%" height="100" border="1" cellpadding="5" cellspacing="2" bordercolor="#CCCCCC">
            <tr valign="top">
              <td width="52%" rowspan="2" bordercolor="#000000" >
			  
			<? }else{
				$css = "popop_box";
			}?>  
			  
			  
			  
			   <form name="form1" method="post" action="altaHoraEnviar.php">
			  
			  
			  
			  <table width="380" height="100" border="0" cellpadding="5" cellspacing="0" bgcolor="#ECF4F9" class="<?=$css?>">
                  <tr valign="top" bordercolor="#FFFFFF">
                    <td  class="crono_trab">Antes de agregar una horario compruebe que no exista en la lista </td>
                  </tr>
                  <tr valign="top" bordercolor="#FFFFFF">
                    <td bgcolor=><font size="2">
                      <input name="hora_" type="text" id="hora_" size="2" maxlength="2">
              :
              <input name="min_" type="text" id="min_" size="2" maxlength="2">
              <input name="Submit" type="submit" class="botones" value="Agregar horario">
                    </font></td>
                  </tr>
              </table>
			  <input name="sola" type="hidden" value="<?=$_GET["sola"]?>">
			  
		        </form>
			  
			  
			  
			  <? if ($_GET["sola"]!=1){?>
			  
			  
			  </td>
              <td width="48%" height="10" bordercolor="#999999" bgcolor="#666666"><font color="#FFFFFF" size="2"><strong>Horarios Existentes:</strong></font></td>
            </tr>
            <tr valign="top">
              <td width="48%" bordercolor="#999999" bgcolor="#FFFFCC"><font size="2">
                <?
	$sql = "SELECT * FROM horas ORDER by Hora ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
	
	
	
		echo  "<a href='javascript:eliminar(" .  $row["ID_Horas"] . ")'><img src='img/eliminar.png' border='0'  alt='Eliminar esta hora'></a> ";
	
	echo substr($row["Hora"], 0, -3) . "<br>";
	}
	  ?>
              </font></td>
            </tr>
          </table>
     
        <br>
    </div></td>
  </tr>
</table>
<? }?>
<script>form1.hora_.focus();</script>