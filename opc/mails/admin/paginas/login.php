<!--BeginPrincipal-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/sistemaMailsAdmin.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Sistema de Mails</title>
<!-- InstanceEndEditable -->


<!-- InstanceBeginEditable name="head" --><script type="text/javascript" src="../js/prototype.js"></script>
<script type="text/javascript" src="../js/panel.js"></script>
<script type="text/javascript" src="../js/funcionEnter.js"></script>
<!-- InstanceEndEditable -->
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
                      <td><!-- InstanceBeginEditable name="titulo" -->Login<!-- InstanceEndEditable --><br /><!-- InstanceBeginEditable name="contenido" -->
         <br /><div align="center" class="subtitulo">{Mensaje}</div>
         <br />
{Form} {CamposOcultos}      <!--BeginFormBuscador-->
      <!--EndFormBuscador-->
      <!--BeginResultado-->
      <!--EndResultado-->
      <!--BeginFormEdicion-->
         <table width="80%" border="0" align="center" cellpadding="4" cellspacing="1">
             <tr>
               <td width="148" rowspan="4"  class="textos"><div align="center"><img src="../img/login.gif" width="120" height="122"  /></div></td>
			   <td colspan="3"  class="textos">
</td>
	        </tr>
             <tr>
               <td width="73" bgcolor="#FFFFFF" class="textos"><div align="right">Usuario:</div></td>
               <td width="196" bgcolor="#FFFFFF" class="textos"><input name="nick" type="text" id="nick" /></td>
               <td width="82" bgcolor="#FFFFFF" class="textos">&nbsp;</td>
             </tr>
             <tr>
               <td width="73" bgcolor="#FFFFFF" class="textos"><div align="right">Contrase&ntilde;a:</div></td>
               <td width="196" bgcolor="#FFFFFF" class="textos"><input name="clave" type="password" id="clave" value=""  onkeydown="javascript:if(EnterPulsado(event)) return validar();"/></td>
               <td width="82" bgcolor="#FFFFFF" class="textos">&nbsp;</td>
             </tr>
             <tr>
               <td colspan="2" bgcolor="#FFFFFF" class="textos"><div align="center"><span style="width:400px;">
                 <input type="button" name="btnAceptar" value="Ingresar" onclick="return validar();"/>
               </span></div></td>
               <td bgcolor="#FFFFFF" class="textos">&nbsp;</td>
             </tr>
          </table>

        <br />
        <br />
        <!--EndFormEdicion-->
      {FormCierre}{Scripts}

		 <!-- InstanceEndEditable --></td>
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
<!-- InstanceBeginEditable name="final" --><!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>
<!--EndPrincipal-->
