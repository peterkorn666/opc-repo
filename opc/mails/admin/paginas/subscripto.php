<!--BeginPrincipal-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/sistemaMailsAdmin.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Sistema de Mails</title>
<!-- InstanceEndEditable -->


<!-- InstanceBeginEditable name="head" --><script type="text/javascript" src="../js/prototype.js"></script>
<script type="text/javascript" src="../js/panel.js"></script>
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
                      <td><!-- InstanceBeginEditable name="titulo" -->Detalles de un subscripto<!-- InstanceEndEditable --><br /><!-- InstanceBeginEditable name="contenido" -->{Mensaje}{Form}{CamposOcultos}
                          <!--BeginFormBuscador-->
                          <!--EndFormBuscador-->
                          <!--BeginResultado-->
                          <!--EndResultado-->
                          <!--BeginFormEdicion-->
                          <div id="div_formulario">
                            <p class="TXTArial10878E96">{Mensaje}</p>
                            <table width="100%" border="0" cellspacing="1" cellpadding="4">
                              <tr>
                                <td width="68" bgcolor="#E9E9E9" class="textos"><div align="right">IdSubscripto:</div></td>
                                <td width="250" bgcolor="#F4F4F4" class="textos">{IdSubscripto}<input type="hidden" id="IdSubscripto" name="IdSubscripto" value="{IdSubscripto}" /></td>
                                <td width="8" bgcolor="#FFFFFF" class="textos"></td>
                                <td width="114" bgcolor="#E9E9E9" class="textos">Email:</td>
                                <td width="222" bgcolor="#F4F4F4" class="textos"><input name="Email" type="text" class="campos" id="Email" style="width:200px" value="{Email}"/></td>
                              </tr>
                              <tr>
                                <td width="68" bgcolor="#E9E9E9" class="textos"><div align="right">Activo:</div></td>
                                <td width="250" bgcolor="#F4F4F4" class="textos"><input type="checkbox" name="Activo" id="Activo" value="1" /></td>
                                <td width="8" bgcolor="#FFFFFF" class="textos">&nbsp;</td>
                                <td width="114" bgcolor="#E9E9E9" class="textos"></td>
                                <td width="222" bgcolor="#F4F4F4" class="textos"></td>
                              </tr>
                            </table>
						<table>
								<tr>
									<td>Nombre</td><td><input type="hidden" name="sdp_IdSubscripto" id="sdp_IdSubscripto" value="{sdp_IdSubscripto}"  size="11"  /><input type="text" name="sdp_Nombre" id="sdp_Nombre" size="100" value="{sdp_Nombre}"  /></td>
								</tr>
							
								<tr>
									<td>Apellido</td><td><input type="text" name="sdp_Apellido" id="sdp_Apellido" size="100" value="{sdp_Apellido}"  /></td>
								</tr>
							
								<tr>
									<td>Pais</td><td><input type="text" name="sdp_Pais" id="sdp_Pais" size="100" value="{sdp_Pais}"  /></td>
								</tr>
							
								<tr>
									<td>Ciudad</td><td><input type="text" name="sdp_Ciudad" id="sdp_Ciudad" size="100" value="{sdp_Ciudad}"  /></td>									
								</tr>
							
								<tr>
									<td>Direccion</td><td><textarea cols="40" name="sdp_Direccion" id="sdp_Direccion"   >{sdp_Direccion}</textarea></td>
								</tr>
							
								<tr>
									<td>CP</td><td><input type="text" name="sdp_CP" id="sdp_CP" size="10" value="{sdp_CP}"  /></td>
								</tr>
							
								<tr>
									<td>Telefono</td><td><input type="text" name="sdp_Telefono" id="sdp_Telefono" size="20" value="{sdp_Telefono}"  /></td>
								</tr>
							
								<tr>
									<td>Celular</td><td><input type="text" name="sdp_Celular" id="sdp_Celular" size="20" value="{sdp_Celular}"  /></td>
								</tr>
							
								<tr>
									<td>Fax</td><td><input type="text" name="sdp_Fax" id=sdp_"Fax" size="20" value="{sdp_Fax}"  /></td>
								</tr>
							
								<tr>
									<td>Web</td><td><textarea cols="40" name="sdp_Web" id="sdp_Web" >{sdp_Web}</textarea></td>
								</tr>
							
								<tr>
									<td>Idioma</td><td><input type="text" name="sdp_Idioma" id="sdp_Idioma" size="2" value="{sdp_Idioma}"  /></td>
								</tr>
							
								<tr>
									<td>Sexo</td><td><input type="text" name="sdp_Sexo" id="sdp_Sexo" size="1" value="{sdp_Sexo}"  /></td>
								</tr>
							
								<tr>
									<td>Edad</td><td><input type="text" name="sdp_Edad" id="sdp_Edad" size="11" value="{sdp_Edad}"  /></td>
								</tr>
							
								<tr>
									<td>Rango Edad</td><td><input type="text" name="sdp_RangoEdad" id="sdp_RangoEdad" size="20" value="{sdp_RangoEdad}"  /></td>
								</tr>
							
								<tr>
									<td>Profesi&oacute;n</td><td><input type="text" name="sdp_Profesion" id="sdp_Profesion" size="50" value="{sdp_Profesion}"  /></td>
								</tr>
							
								<tr>
									<td>Especialidad</td><td><input type="text" name="sdp_Especialidad" id="sdp_Especialidad" size="50" value="{sdp_Especialidad}"  /></td>
								</tr>
							
								<tr>
									<td>Instituci&oacute;n</td><td><input type="text" name="sdp_Institucion" id="sdp_Institucion" size="100" value="{sdp_Institucion}"  /></td>
								</tr>
							
								<tr>
									<td>Tipo Instituci&oacute;n</td><td><input type="text" name="sdp_TipoInstitucion" id="sdp_TipoInstitucion" size="50" value="{sdp_TipoInstitucion}"  /></td>
								</tr>
							
								<tr>
									<td>Libre1</td><td><input type="text" name="sdp_Libre1" id="sdp_Libre1" size="100" value="{sdp_Libre1}"  /></td>
								</tr>
							
								<tr>
									<td>Libre2</td><td><input type="text" name="sdp_Libre2" id="sdp_Libre2" size="100" value="{sdp_Libre2}"  /></td>
								</tr>
							
								<tr>
									<td>Libre3</td><td><input type="text" name="sdp_Libre3" id="sdp_Libre3" size="100" value="{sdp_Libre3}"  /></td>
								</tr>
							
								<tr>
									<td>Libre4</td><td><input type="text" name="sdp_Libre4" id="sdp_Libre4" size="100" value="{sdp_Libre4}"  /></td>
								</tr>
							
								<tr>
									<td>Libre5</td><td><input type="text" name="sdp_Libre5" id="sdp_Libre5" size="100" value="{sdp_Libre5}"  /></td>
								</tr>							
						</table>
                            <table width="650"  border="0" align="center" cellpadding="0" cellspacing="2">
                              <tr bgcolor="#FFFFFF">
                                <td height="20" colspan="2"><div align="right">
                                    <input type="button" name="btnEnviar" value="Cancelar" onclick="return cancelar();"/>
                                    <input type="button" name="btnAceptar" value="Guardar cambios" onclick="return aceptar();"/>
                                </div></td>
                              </tr>
                            </table>
                          </div>
                          <!--EndFormEdicion-->
{FormCierre}{Scripts}<!-- InstanceEndEditable --></td>
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
<!-- InstanceBeginEditable name="final" --><script  type="text/javascript"></script><!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>
<!--EndPrincipal-->