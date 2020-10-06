<!--BeginPrincipal-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/sistemaMailsAdmin.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Sistema de Mails</title>
<!-- InstanceEndEditable -->


<!-- InstanceBeginEditable name="head" -->
<script type="text/javascript" src="../js/prototype.js"></script>
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
                      <td><!-- InstanceBeginEditable name="titulo" -->Elementos enviados  (Seleccionar el envío para ver subscriptos)<!-- InstanceEndEditable --><br /><!-- InstanceBeginEditable name="contenido" --> {Form} {CamposOcultos}<!--BeginFormBuscador-->       
		              <table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#FFFFFF" class="textos">
             <tr>
               <td bgcolor="#E9E9E9" class="textos"><div align="right">Envio:</div></td>
               <td bgcolor="#E9E9E9" class="textos"><select name="IdEnvio" id="IdEnvio">
                 {envios}
                                
               </select><input name="incluidoEnvio" type="hidden" value="enviado" />
</td>
             </tr>
             <tr>
               <td align="right" bgcolor="#F0F0F0">Limitar la b&uacute;squeda a:</td>
               <td bgcolor="#F0F0F0"><input type="text" name="Limite" id="Limite" value="{Limite}" style="width:50px" class="campos" onkeydown="javascript:if(EnterPulsado(event)) buscar();"/> subscriptos. (dejar vac&iacute;o para no limitar)
                 </td>
               </tr>
             <tr>
             <tr>
               <td align="right" bgcolor="#F0F0F0">Email:</td>
               <td bgcolor="#F0F0F0"><input type="text" name="Email" id="Email" value="{Email}" style="width:200px" class="campos" onkeydown="javascript:if(EnterPulsado(event)) buscar();"/>
                 </td>
               </tr>
             <tr>
               <td align="right" bgcolor="#E9E9E9">Grupo:</td>
               <td bgcolor="#E9E9E9">{listadoGrupos}
                 </td>
               </tr>  
<!--			   
             <tr>
               <td align="right" bgcolor="#E9E9E9">Nombre o Apellido:</td>
               <td bgcolor="#E9E9E9"><input type="text" name="NombreApellido" id="NombreApellido" value="{NombreApellido}" style="width:200px" class="campos" onkeydown="javascript:if(EnterPulsado(event)) buscar();"/>
                 </td>
               </tr>    
             <tr>
               <td align="right" bgcolor="#E9E9E9">Profesi&oacute;n:</td>
               <td bgcolor="#E9E9E9"><input type="text" name="Profesion" id="Profesion" value="{Profesion}" style="width:200px" class="campos" onkeydown="javascript:if(EnterPulsado(event)) buscar();"/>
                 </td>
               </tr>  
             <tr>
               <td align="right" bgcolor="#E9E9E9">Especialidad:</td>
               <td bgcolor="#E9E9E9"><input type="text" name="Especialidad" id="Especialidad" value="{Especialidad}" style="width:200px" class="campos" onkeydown="javascript:if(EnterPulsado(event)) buscar();"/>
                 </td>
               </tr>  
             <tr>
               <td align="right" bgcolor="#E9E9E9">Pa&iacute;s:</td>
               <td bgcolor="#E9E9E9"><input type="text" name="Pais" id="Pais" value="{Pais}" style="width:200px" class="campos" onkeydown="javascript:if(EnterPulsado(event)) buscar();"/>
                 </td>
               </tr>  
             <tr>
               <td align="right" bgcolor="#E9E9E9">Idioma:</td>
               <td bgcolor="#E9E9E9"><input type="text" name="Idioma" id="Idioma" value="{Idioma}" style="width:200px" class="campos" onkeydown="javascript:if(EnterPulsado(event)) buscar();"/>
                 </td>
               </tr>  
             <tr>
               <td align="right" bgcolor="#E9E9E9">Libre 1:</td>
               <td bgcolor="#E9E9E9"><input type="text" name="Libre1" id="Libre1" value="{Libre1}" style="width:200px" class="campos" onkeydown="javascript:if(EnterPulsado(event)) buscar();"/>
                 </td>
               </tr>  
			 <tr>
               <td align="right" bgcolor="#E9E9E9">Libre 2:</td>
               <td bgcolor="#E9E9E9"><input type="text" name="Libre2" id="Libre2" value="{Libre2}" style="width:200px" class="campos" onkeydown="javascript:if(EnterPulsado(event)) buscar();"/>
                 </td>
               </tr>  
-->			   
             <tr>
               <td align="right" bgcolor="#F0F0F0">&nbsp;</td>
               <td bgcolor="#F0F0F0"><div class="btn" align="center"><a href="#" onclick="buscar();">Buscar</a></div>
                 <div class="btn" align="center"><a href="#" onclick="document.frmBuscar.elements['accion'].value='limpiarBusquedaGuardada';document.frmBuscar.submit();">Ver Todos</a></div></td>
               </tr>             			 
		    </table>
			 <!--EndFormBuscador--> 
			 <!--BeginResultado-->
<p class="textos" align="right" style="margin:0px;"> <!--BeginPaginarResultado-->
          {TotalRegistros} 
          {Anterior} 
          <!--BeginPaginarResultadoPaginas-->
          {Pagina} 
          <!--EndPaginarResultadoPaginas-->
          {Siguiente} 
          <!--EndPaginarResultado-->
		  </p>
			 <!--BeginHayResultado-->
		   <table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#FFFFFF" class="textos">
             <tr>
               <td colspan="8" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#E9E9E9" style="border:1px solid #FFFFFF">
                 <tr class="cabezal_asc">
                   <td align="center"><a href="#" onclick="javascript:return seleccionarTodos();">todos</a></td>
                   <td align="center">{Orden_Email_asc}</td>
				   <!--
                   <td align="center">{Orden_NombreApellido_asc}</td>
                   <td align="center">{Orden_Profesion_asc}</td>
				   <td align="center">{Orden_Especialidad_asc}</td>
				   <td align="center">{Orden_Pais_asc}</td>
				   <td align="center">{Orden_Idioma_asc}</td>
				   <td align="center">{Orden_Libre1_asc}</td>
				   <td align="center">{Orden_Libre2_asc}</td>
				   -->
                   <td align="center">{Orden_EnviosPendientes_asc}</td>
                   <td align="center">{Orden_EnviosHechos_asc}</td>
                   <td align="center">{Orden_EnviosRebotados_asc}</td>
                   </tr>
                 <tr class="cabezal">
                   <td width="5%"  align="center">Seleccionar</td>
                   <td width="20%"  align="center"><div align="center" class="Estilo1">Email</div></td>
				   <!--
                   <td width="20%"  align="center"><div align="center" class="Estilo1">Nombre y Apellido</div></td>
                   <td width="20%"  align="center"><div align="center" class="Estilo1">Profesi&oacute;n</div></td>
				   <td width="20%"  align="center"><div align="center" class="Estilo1">Especialidad</div></td>
				   <td width="20%"  align="center"><div align="center" class="Estilo1">Pa&iacute;s</div></td>
				   <td width="20%"  align="center"><div align="center" class="Estilo1">Idioma</div></td>
				   <td width="20%"  align="center"><div align="center" class="Estilo1">Libre 1</div></td>
				   <td width="20%"  align="center"><div align="center" class="Estilo1">Libre 2</div></td>
				   -->
                   <td width="10%"  align="center"><div align="center" class="Estilo1">EnviosPendientes</div></td>
                   <td width="10%"  align="center"><div align="center" class="Estilo1">EnviosHechos</div></td>
                   <td width="10%"  align="center"><div align="center" class="Estilo1">EnviosRebotados</div></td>
				   </tr>
                 <tr class="cabezal_desc">
                   <td align="center"><a href="#" onclick="javascript:return desSeleccionarTodos();">ninguno</a></td>
                   <td align="center">{Orden_Email_desc}</td>
				   <!--
				   <td align="center">{Orden_NombreApellido_desc}</td>
				   <td align="center">{Orden_Profesion_desc}</td>
				   <td align="center">{Orden_Especialidad_desc}</td>
				   <td align="center">{Orden_Pais_desc}</td>
				   <td align="center">{Orden_Idioma_desc}</td>
				   <td align="center">{Orden_Libre1_desc}</td>
				   <td align="center">{Orden_Libre2_desc}</td>
				   -->
                   <td align="center">{Orden_EnviosPendientes_desc}</td>
                   <td align="center">{Orden_EnviosHechos_desc}</td>
                   <td align="center">{Orden_EnviosRebotados_desc}</td>
                   </tr>
			<!--BeginFilaResultado-->
                 <tr  class="resultado_fila{resultado_tipoFila}" {resultado_scriptFila}>
                   <td>{resultado_CheckSeleccion}</td>
                   <td>{resultado_Email}</td>
				   <!--
				   <td>{resultado_NombreApellido}</td>
				   <td>{resultado_Profesion}</td>
				   <td>{resultado_Especialidad}</td>
				   <td>{resultado_Pais}</td>
				   <td>{resultado_Idioma}</td>
				   <td>{resultado_Libre1}</td>
				   <td>{resultado_Libre2}</td>
				   -->
                   <td>{resultado_EnviosPendientes}</td>
                   <td>{resultado_EnviosHechos}</td>
				   <td>{resultado_EnviosRebotados}</td>
                   </tr>
			<!--EndFilaResultado-->
               </table>
       <br/>
          <!--BeginPaginarResultado--><p>
          {TotalRegistros} <br/>
          {Anterior} 
          <!--BeginPaginarResultadoPaginas-->
          {Pagina} 
          <!--EndPaginarResultadoPaginas-->
          {Siguiente}</p> 
          <p>
            <!--EndPaginarResultado-->
            </p>

            
            <script type="text/javascript">

function cambiarCheck() {
}
              </script>
              <!--EndHayResultado-->
            
            
              <!--BeginNoHayResultado-->
          <p>No hay registros</p> 
          <!--EndNoHayResultado-->
        
			   </td>
             </tr>
           </table>
      <!--EndResultado-->

       {FormCierre}{Scripts}
      <!--BeginFormEdicion-->
      <!--EndFormEdicion-->
          
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
<!-- InstanceBeginEditable name="final" --><script  type="text/javascript">

</script><!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>
<!--EndPrincipal-->