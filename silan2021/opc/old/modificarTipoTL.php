<?
include ('inc/sesion.inc.php');
include('conexion.php');
?>
<link href="estilos.css" rel="stylesheet" type="text/css">

<script language="javascript">
   function Validar(){
	  if(form1.tipo_.value==""){alert("Por Favor, Ingrese una tipo de trabajo libre.");form1.tipo_.focus();return;}
	  form1.submit();
	}
	
	function eliminar(cual){
 		
		var return_value = confirm("¿Esta seguro que desea eliminar esta tipo de trabajo libre?");
		
		 if ( return_value == true ) {
			 document.location.href = "eliminarTipoTL.php?id=" + cual;
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
&nbsp;Modificar Tipo de </font></strong> <strong>Trabajo Libre </strong></div>
      <form name="form1" method="post" action="modificarTipoTLEnviar.php">
        <table width="100%" border="1" cellpadding="5" cellspacing="2" bordercolor="#CCCCCC">
          <tr valign="top">
		 		  <?
				  $sql = "SELECT * FROM tipo_de_trabajos_libres WHERE id = " . $_GET["id"];
				  $rs = mysql_query($sql,$con);
				  while ($row = mysql_fetch_array($rs)){
				  $tipo_viejo = $row["tipoTL"];
				  ?>
		  
            <td width="50%" rowspan="2" bgcolor="#000000"><table width="100%"  border="0" cellpadding="5" cellspacing="0">
                <tr valign="top" bordercolor="#FFFFFF">
                  <td bgcolor="#E6DEEB" class="crono_trab">Modificara:&nbsp;			        <?
				  echo $row["tipoTL"];
				  ?>				  </td>
                </tr>
                <tr valign="top" bordercolor="#FFFFFF">
                  <td bgcolor="#E6DEEB"><font size="2">
                    <input name="tipo_" type="text" id="tipo_" value="<?=$row["tipoTL"]?>" size="55">
					<?
				  }
				  ?>
                  </font></td>
                </tr>
                <tr valign="top" bordercolor="#FFFFFF">
                  <td bgcolor="#E6DEEB"><div align="right"><font size="2">
                      <input name="Submit" type="button" class="botones" onClick="Validar()" value="Modificar area">
                  </font></div></td>
                </tr>
            </table></td>
            <td width="50%" bordercolor="#999999" bgcolor="#666666"><font color="#FFFFFF" size="2"><strong>Tipos  Existentes:</strong></font></td>
          </tr>
          <tr valign="top">
            <td width="50%" bordercolor="#999999" bgcolor="#FFFFCC"><font size="2">
              <?
	$sql = "SELECT * FROM tipo_de_trabajos_libres ORDER by tipoTL  ASC";
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
		 <input name="tipo_viejo" type="hidden" id="tipo_viejo" value="<?=$tipo_viejo?>">
		
      </form>
    <strong><font color="#666666" size="3"></font></strong></td>
  </tr>
</table>
