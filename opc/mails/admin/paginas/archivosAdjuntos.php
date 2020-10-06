<!--BeginPrincipal-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/sistemaMailsAdmin.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Sistema de Mails</title>
<!-- InstanceEndEditable -->


<!-- InstanceBeginEditable name="head" -->
<script type="text/javascript" src="../js/prototype.js"></script>
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
                      <td><!-- InstanceBeginEditable name="titulo" -->Administraci&oacute;n de archivos adjuntos<!-- InstanceEndEditable --><br /><!-- InstanceBeginEditable name="contenido" -->
                        <p>{Mensaje}{Form}{CamposOcultos}
                          <!--BeginFormBuscador-->
                          <!--EndFormBuscador-->
                          <!--BeginResultado-->
                          <!--EndResultado-->
                          <!--BeginFormEdicion-->
                        <!--EndFormEdicion-->
                        <div id="admArchivos">
{FormCierre}Ruta: <span id="spanRuta"></span>

<br />Contenido:
<div id="divDirectorio"></div>
<div id="divCrearDirectorio"  style="display:none;position:relative;">Crear directorio: <input type="text" name="txtNuevoDirectorio" id="txtNuevoDirectorio" /><input type="button" id="okNuevoDirectorio" name="okNuevoDirectorio" onclick="javascript:crearDirectorio($('txtNuevoDirectorio').value);" value="Crear directorio" /></div>
<div id="divCrearDirectorioSinPermiso" style="display:none;position:relative;">
<p>No hay permisos suficientes para crear un subdirectorio en esta carpeta.</p>
</div>
<!-- formulario para el upload, no puede ir dentro del form principal -->
<div id="divUploadArchivos" style="display:none;position:relative;">
<br />Subir archivo:<br />
<form id="formUpload1" method="post" enctype="multipart/form-data" action="../ajax/archivos_adjuntos.php" target="iframeUpload1">
<input type="hidden" name="id" value="1" />
<input type="hidden" name="accion" value="upload" />
<input type="hidden" name="directorio" value="" />
<span id="uploader1" style="font-family:verdana;font-size:10;">
Archivo: <input name="uploaderControl1" id="uploaderControl1" type="file"  />
<br>
<input type="button" value="enviar" onclick="return uploadFile(1)">
</span>
<span id="result1" style="font-family:verdana;font-size:10;">
</span>	
<span id="other1" style="font-family:verdana;font-size:10;display:none;">
<a href="javascript:subirOtro(1);"> - subir otro archivo</a>
</span>	
<iframe name="iframeUpload1" style="display:none"></iframe>
</form>
</div>
<div id="divUploadArchivosSinPermiso" style="display:none;position:relative;">
<p>No hay permisos suficientes para agregar archivos en esta carpeta.</p>
</div>
<!-- formulario para el upload, no puede ir dentro del form principal -->
</div>
		{Scripts}                      <!-- InstanceEndEditable --></td>
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