<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");

if (!isset($_SESSION["registrado"])){
	$_SESSION["registrado"]=false;
}

include('conexion.php');
?>
<script language="JavaScript">
<!-- //
function BodyOnLoad()
{
	document.form1.usuario.focus();

}



// -->
</script>
<script src="js/menuEdicion.js" type="text/javascript"></script>
<script src="js/ajax.js" type="text/javascript"></script>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link href="estilos.css" rel="stylesheet" type="text/css">
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="BodyOnLoad()">

<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CCCCCC">
   <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php";?></td>
  </tr>
  <tr>
    <td valign="top"><p align="center">&nbsp;</p>

      <p align="center">&nbsp;</p>
      <form name="form1" method="post" action="login_enviar.php">
        <table width="100%"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#1E0143">
          <td height="5"></td>
          <td height="5"></td>
          <td height="5"></td>
        </tr>
        <tr>
          <td width="46%" rowspan="9" align="center" valign="middle" bgcolor="#FFFFFF"><img src="img/key.gif" width="175" height="176"></td>
          <td height="50" colspan="2" bgcolor="#FFFFFF"><strong>Acceso para Administradores</strong></td>
        </tr>
        <tr>
          <td colspan="2" bgcolor="#FFFFFF"><?
				$pass = $_GET["pass"];
				if($pass=="0"){
					echo "<font color='#ff0000'>El nombre de usuario o contrase&ntilde;a no son correctas</font>";
				}
			?></td>
        </tr>
        <tr>
          <td colspan="2" bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
        <tr>
          <td width="14%" bgcolor="#FFFFFF" class="linea_trabajos">Usuario</td>
          <td width="40%" bgcolor="#FFFFFF"><input name="usuario" type="text" class="trabajos" id="usuario" size="40"></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF" class="linea_trabajos">&nbsp;</td>
          <td bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF" class="linea_trabajos">Contrase&ntilde;a</td>
          <td bgcolor="#FFFFFF"><input name="clave" type="password" class="trabajos" id="clave" size="40"></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF" class="linea_trabajos">&nbsp;</td>
          <td bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
        <tr>
          <td height="10" bgcolor="#FFFFFF" class="linea_trabajos">&nbsp;</td>
          <td height="10" bgcolor="#FFFFFF"><input name="Submit" type="submit" class="tipo_de_actividad" value="Registrarse"></td>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF" class="linea_trabajos">&nbsp;</td>
          <td bgcolor="#FFFFFF" height="50">&nbsp;</td>
        </tr>
        <tr bgcolor="#1E0143">
          <td height="5"></td>
          <td height="5"></td>
          <td height="5"></td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
