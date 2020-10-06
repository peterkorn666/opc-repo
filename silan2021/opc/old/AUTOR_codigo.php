<style type="text/css">
<!--
body {
	background-color: #000000;
}
.Estilo1 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #FFFFFF;
	font-weight: bold;
	font-style: italic;
	font-size:14px;
	
}
-->
</style>
<link href="estilos.css" rel="stylesheet" type="text/css"><br>
<form name="form1" method="post" action="AUTOR_codigo_enviar.php">
<table width="451" height="13%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CFC2D6">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><center class="Estilo1">AIDIS 2006</center></td>
  </tr>
  <tr>
    <td height="76" valign="top"><p align="center" class="botones_tl"><strong>Trabajo Técnico - Versión Definitiva</strong></p>
             <?
				$pass = $_GET["pass"];
				if($pass=="0"){
					echo "<center><font color='#ff0000'>El código del Trabajo o contrase&ntilde;a no son correctas</font></center><br>";
				}
			?>
        <table width="315" border="0" align="center" cellpadding="2" cellspacing="0" bgcolor="#CFC2D6">
      <tr>
        <td width="144" bgcolor="#BCAAC6" class="textos">C&oacute;digo de Trabajo : </td>
        <td width="175" bgcolor="#BCAAC6" class="textos"><input name="txtCodigo" type="text" id="txtCodigo"></td>
      </tr>
      <tr>
        <td bgcolor="#BCAAC6" class="textos">Contrase&ntilde;a:</td>
        <td bgcolor="#BCAAC6" class="textos"><input name="txtClave" type="password" id="txtClave"></td>
      </tr>
    </table>
        <div align="center"><br>
          
          <input type="Submit" name="Submit" value="Ver Trabajo" >
          
          <br>
      </div></td>
  </tr>
</table>
</form>