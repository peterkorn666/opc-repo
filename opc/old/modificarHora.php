<?
include('inc/sesion.inc.php');
?>
<link href="estilos.css" rel="stylesheet" type="text/css">
<?
include('conexion.php');
?>
<script language="javascript">
	function Validar(){
	
	  if(form1.hora_.value==""){alert("Por Favor, Ingrese un numero para la hora.");form1.hora_.focus();return;}
	  if(form1.min_.value==""){alert("Por Favor, Ingrese un numero para los minutos");form1.min_.focus();return;}
	
	form1.submit();
	}
	function eliminar(cual){
 		
		var return_value = confirm("¿Esta seguro que desea eliminar esta hora?");
		 if ( return_value == true ) {
			 document.location.href = "eliminarHora.php?id=" + cual;
		 }
		 
	 }
</script>
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CCCCCC">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php"; ?></td>
  </tr>
  <tr>
    <td valign="top"><div align="center"><strong><font color="#666666" size="3">&nbsp;<br>
&nbsp;Modificar Hora</font></strong></div>
      <form name="form1" method="post" action="modificarHoraEnviar.php">
        <table width="100%" border="1" cellpadding="5" cellspacing="2" bordercolor="#CCCCCC">
          <tr valign="top">
		 		  <?
				  $sql = "SELECT * FROM horas WHERE ID_Horas = " . $_GET["id"];
				  $rs = mysql_query($sql,$con);
				  while ($row = mysql_fetch_array($rs)){
				  $hora_viejo = $row["Hora"];
				  ?>
		  
            <td width="50%" rowspan="2" bgcolor="#000000"><table width="100%"  border="0" cellpadding="5" cellspacing="0">
                <tr valign="top" bordercolor="#FFFFFF">
                  <td bgcolor="#FFFFFF"><font color="#FF0000" size="2">Modificara:</font><font color="#FF0000" size="2">&nbsp;
				  <?
				  echo $row["Hora"];
				  ?>
				  </font></td>
                </tr>
                <tr valign="top" bordercolor="#FFFFFF">
                  <td bgcolor="#FFFFFF"><font size="2">
                    <input name="pais_" type="text" id="pais_" value="<?=$row["Hora"];?>" size="25">
                    <?
				  }
				  ?>
</font></td>
                </tr>
                <tr valign="top" bordercolor="#FFFFFF">
                  <td bgcolor="#FFFFFF"><div align="right"><font size="2">
                      <input type="submit" name="Submit" value="Modificar Hora">
                  </font></div></td>
                </tr>
            </table></td>
            <td width="50%" bordercolor="#999999" bgcolor="#666666"><font color="#FFFFFF" size="2"><strong>Horas Existentes: </strong></font></td>
          </tr>
          <tr valign="top">
            <td width="50%" bordercolor="#999999" bgcolor="#FFFFCC"><font size="2">
    <?
	$sql = "SELECT * FROM horas ORDER by Hora ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
	
	echo  "<a href='modificarHora.php?id=" . $row["ID_Horas"]  .  "'><img src='img/modificar.png' border='0' alt='Modificar esta hora'></a>";
	
	echo  "<a href='javascript:eliminar(" .  $row["ID_Horas"] . ")'><img src='img/eliminar.png' border='0'  alt='Eliminar esta hora'></a> ";
	
	echo substr($row["Hora"], 0, -3) . "<br>";

	}
	?>
            </font></td>
          </tr>
        </table>
		 <input name="hora_viejo" type="hidden" id="hora_viejo" value="<?=$hora_viejo?>" >
	  </form>
    <strong><font color="#666666" size="3"></font></strong></td>
  </tr>
</table>
