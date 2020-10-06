 
<!--BeginPrincipal-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><!-- #BeginTemplate "/Templates/sistemaMailsAdmin.dwt" --><!-- DW6 -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- #BeginEditable "doctitle" --> 
<title>Sistema de Mails</title>
<!-- #EndEditable -->


<!-- #BeginEditable "head" --><!-- #EndEditable -->
<link href="../css/estilos.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="../js/funciones.js"></script>
<script type="text/javascript" src="../js/fechas.js"></script>
<script type="text/javascript" src="../js/variables.js"></script>
</head>

<body>
<table width="1010" border="1"  align="left" cellpadding="0" cellspacing="0" bordercolor="#939393">
  <tr>
    <td><table width="1010" border="0"  align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
      <tr>
        <td valign="top">SISTEMA DE ENVIOS
          <table  width="100%" border="0" cellpadding="4" cellspacing="0">
            <tr>
              <td valign="top" width="15%"><table width="95%"  border="0" align="right" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="95%" valign="top"><p><a href="../sistema/mails.php">Mails</a><br /><a href="../sistema/mail.php">&nbsp; &nbsp; ->nuevo</a></p>
                        
                        <p><a href="../sistema/subscriptos.php">Subscriptos</a><br />
                          &nbsp; &nbsp; -><a href="../sistema/subscripto.php">nuevo</a><br />
                          <a href="../sistema/subscripto.php">&nbsp; &nbsp; </a>-&gt;<a href="../sistema/subscriptosAgregarDeTexto.php">agregar de texto</a><br />
                        <a href="../sistema/subscripto.php">&nbsp; &nbsp; </a>-&gt;<a href="../sistema/subscriptosAgregarDeArchivo.php">agregar de archivo</a></p>
                        <p><a href="../sistema/grupos.php">Grupos</a><br />
                        <a href="../sistema/grupo.php">&nbsp; &nbsp; -&gt;nuevo</a></p>
<p>Agregar destinatarios<br />
&nbsp; &nbsp; -&gt;<a href="../sistema/destinatariosDesdeBase.php">de la base</a><br />
&nbsp; &nbsp; -&gt;<a href="../sistema/destinatariosDesdeTexto.php">de texto</a><br />
&nbsp; &nbsp; -&gt;<a href="../sistema/destinatariosDesdeArchivo.php">de archivo</a> </p>
<p><a href="../sistema/bandejaDeSalida.php">Bandeja de salida</a></p>
<p><a href="../sistema/elementosEnviados.php">Elementos enviados</a></p>
<p><a href="../sistema/elementosRebotados.php">Elementos rebotados</a></p>
<p><a href="../sistema/archivosAdjuntos.php">Archivos Adjuntos</a></p>
<p><a href="../sistema/modelo.php">Mensaje modelo</a><br />
  <br />
</p></td>
                      <td width="5%"></td>
                    </tr>
                  </table>
                    </td>
                  <td width="80%" valign="top"><table width="95%" height="102" border="0" align="center" cellpadding="4" cellspacing="0">

                    <tr>
                      <td><!-- #BeginEditable "titulo" -->Usuario<!-- #EndEditable --><br /><!-- #BeginEditable "contenido" -->
{Mensaje}{Form}{CamposOcultos}
                          <!--BeginFormBuscador-->
                          <!--EndFormBuscador-->
                          <!--BeginResultado-->
                          <!--EndResultado-->
                          <!--BeginFormEdicion-->
                          <div id="div_formulario">
                            <p class="TXTArial10878E96">{Mensaje}</p>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
        <tr bgcolor="#FFFFFF"> 
          <td colspan="2"> 
            <div align="left"> 
              <table width="100%"  border="0" align="center" cellpadding="3" cellspacing="2">
                <!--DWLayoutTable-->
                <tr valign="middle"> 
                  <td bgcolor="#FFFFFF" class="TXTArial10878E96"> 
                    <div align="right">Usuario</div>
                  </td>
                  <td class="TXTArial10878E96"> 
                    <input name="Usuario" type="text" class="BOX100x20" value="{Usuario}" />
                  </td>
                </tr>
                <tr valign="middle"> 
                  <td bgcolor="#FFFFFF" class="TXTArial10878E96"> 
                    <div align="right">Nombre</div>
                  </td>
                  <td class="TXTArial10878E96"> 
                    <input name="Nombre" type="text" class="BOX100x20" value="{Nombre}" />
                  </td>
                </tr>
                <tr valign="middle"> 
                  <td bgcolor="#FFFFFF" class="TXTArial10878E96"> 
                    <div align="right">Apellido</div>
                  </td>
                  <td class="TXTArial10878E96"> 
                    <input name="Apellido" type="text" class="BOX100x20" value="{Apellido}" />
                  </td>
                </tr>
                <tr valign="bottom"> 
                  <td height="28" valign="middle" bgcolor="#FFFFFF" class="TXTArial10878E96"> 
                    <p align="right">Nivel 
                  </p></td>
                  <td valign="middle" class="TXTArial10878E96"> 
                    <select name="IdNivel" class="BOX100x20">
                        {Niveles}                      
                    </select>
                  </td>
                </tr>
                <tr valign="bottom"> 
                  <td height="28" valign="middle" bgcolor="#FFFFFF" class="TXTArial10878E96"> 
                    <p align="right">Estado 
                  </p></td>
                  <td valign="middle" class="TXTArial10878E96"> 
                    <select name="IdEstadoUsuario" class="BOX100x20">
                        {Estados}                      
                    </select>
                  </td>
                </tr>
                <tr valign="middle"> 
                  <td bgcolor="#FFFFFF" class="TXTArial10878E96"> 
                    <div align="right">Contraseña</div>
                  </td>
                  <td class="TXTArial10878E96"> 
                    <input name="Clave1" type="password" class="BOX100x20" value="" />
                  </td>
                </tr>
                <tr valign="middle"> 
                  <td bgcolor="#FFFFFF" class="TXTArial10878E96"> 
                    <div align="right">Confirmar</div>
                  </td>
                  <td class="TXTArial10878E96"> 
                    <input name="Clave2" type="password" class="BOX100x20" value="" />
                  </td>
                </tr>
              </table>
            </div>
          </td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="20" colspan="2"> 
            <div align="right"> 
              <input type="button" name="btnAceptar" value="Aceptar" onclick="return aceptar();" />
              <input type="button" name="btnEnviar" value="Cancelar" onclick="return cancelar();" />
            </div>
          </td>
        </tr>
      </table></div>
                          <!--EndFormEdicion-->
{FormCierre}{Scripts}<!-- #EndEditable --></td>
                    </tr>
                  </table></td>
                  
                </tr>
              </table></td>
            </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<!-- #BeginEditable "final" --><!-- #EndEditable -->
</body>
<!-- #EndTemplate --></html>
<!--EndPrincipal-->
