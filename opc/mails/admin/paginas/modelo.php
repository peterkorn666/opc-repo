<!--BeginPrincipal-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/sistemaMailsAdmin.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Sistema de Mails</title>
<!-- InstanceEndEditable -->


<!-- InstanceBeginEditable name="head" -->
<!-- TinyMCE -->
<script type="text/javascript" src="../js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "PlantillaHTML",
		convert_urls : false,
		document_base_url : "http://difusion.cce.org.uy/envios/adjuntos/",
		relative_urls : true,
		width : "800",
		height : "350",
		theme : "advanced",
		theme_advanced_buttons1 : "formatselect,fontselect,fontsizeselect,separator,bold,italic,underline,strikethrough,separator,forecolor,backcolor,separator,justifyleft,justifycenter,justifyright, justifyfull,separator,outdent,indent,bullist,numlist,separator,hr",
		theme_advanced_buttons2 : "visualaid,separator,sub,sup,separator,charmap,separator,link,unlink,anchor,image,separator,undo,redo,separator,removeformat,separator,cleanup,separator,code,separator,fullscreen",
		theme_advanced_buttons3 : "tablecontrols,table,row_props,cell_props,delete_col,delete_row,col_after,col_before,row_after,row_before,row_after,row_before,split_cells,merge_cells",
		plugins : "fullscreen,advimage,table",
		external_image_list_url : "../admin/js/listadoimagenes.php",
		external_link_list_url : "../admin/js/listadoadjuntos.php",
		theme_advanced_buttons3_add : "fullscreen",
		theme_advanced_blockformats : "p,div,h1,h2,h3,h4,h5,h6",		
		fullscreen_new_window : true,
		fullscreen_settings : {
			theme_advanced_path_location : "top"
		}
	});
</script>
<!-- /TinyMCE -->
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
                      <td><!-- InstanceBeginEditable name="titulo" -->Edición del modelo de mensaje<!-- InstanceEndEditable --><br /><!-- InstanceBeginEditable name="contenido" -->
                        <p>{Mensaje}{Form}{CamposOcultos}
                          <!--BeginFormBuscador-->
                          <!--EndFormBuscador-->
                          <!--BeginResultado-->
                          <!--EndResultado-->
                          <!--BeginFormEdicion-->
                        <div id="div_formulario">
							{Mensaje}
							<table width="100%" border="0" cellspacing="0" cellpadding="2">
										<tr>
											<td>Plantilla:</td>
										</tr>
										<tr>
											<td valign="top"><textarea cols="40" name="PlantillaHTML" id="PlantillaHTML" ></textarea></td>
										</tr>
							</table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td>
										<input type="button" name="btnEnviar" value="Cancelar" onclick="return cancelar();"/>
										<input type="button" name="btnAceptar" value="Guardar cambios" onclick="return aceptar();"/>
									</td>
								</tr>
                            </table>
                        </div>
                          <!--EndFormEdicion-->
                          {FormCierre}{Scripts}</p>
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