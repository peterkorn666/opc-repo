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
                      <td><!-- InstanceBeginEditable name="titulo" -->Mails<!-- InstanceEndEditable --><br /><!-- InstanceBeginEditable name="contenido" -->{Form} {CamposOcultos}<!--BeginFormBuscador-->       
		   <table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#FFFFFF" class="textos">
             <tr>
               <td align="right" bgcolor="#F0F0F0">Asunto:</td>
               <td bgcolor="#F0F0F0"><input type="text" name="Asunto" id="Asunto" value="{Asunto}" style="width:200px" class="campos" onkeydown="javascript:if(EnterPulsado(event)) buscar();"/></td>
               </tr>
             
             <tr>
               <td align="right" bgcolor="#F0F0F0">&nbsp;</td>
               <td bgcolor="#F0F0F0"><div class="btn" align="center"><a href="#" onclick="buscar();">Buscar</a></div>
                 <div class="btn" align="center"><a href="#" onclick="document.frmBuscar.elements['accion'].value='limpiarBusquedaGuardada';document.frmBuscar.submit();">Ver Todos</a></div></td>
               </tr>
             
			 <!--EndFormBuscador-->
		    </table>
			 {FormCierre}{Scripts} 
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
                   <td width="5%" align="center">{Orden_IdMail_asc}</td>
                   <td width="60%" align="center">{Orden_Asunto_asc}</td>
                   <td width="5%" align="center">&nbsp;</td>
				   <td width="5%" align="center">{Orden_Enviados_asc}</td>
				   <td width="5%" align="center">{Orden_Pendientes_asc}</td>
				   <td width="20%" align="center">&nbsp;</td>
                 </tr>
                 <tr class="cabezal">
                   <td width="5%"  align="center"><div align="center" class="Estilo1">Id</div></td>
                   <td width="60%"  align="center"><div align="center" class="Estilo1">Asunto</div></td>
                   <td width="5%" align="center">Ver</td>
				   <td width="5%" align="center">Enviados</td>
				   <td width="5%" align="center">Pendientes</td>
				   <td width="20%" align="center">Enviar</td>
                 </tr>
                 <tr class="cabezal_desc">
                   <td width="5%" align="center">{Orden_IdMail_desc}</td>
                   <td width="60%" align="center">{Orden_Asunto_desc}</td>
                   <td width="5%" align="center">&nbsp;</td>
				   <td width="5%" align="center">{Orden_Enviados_desc}</td>
				   <td width="5%" align="center">{Orden_Pendientes_desc}</td>
				   <td width="20%" align="center">&nbsp;</td>
                 </tr>
			<!--BeginFilaResultado-->
                 <tr  class="resultado_fila{resultado_tipoFila}" {resultado_scriptFila}>
                   <td width="5%">{resultado_IdMail}</td>
                   <td width="60%">{resultado_Asunto}</td>
				   <td width="5%">{resultado_VerMail}</td>
				   <td width="5%" align="center">{resultado_Enviados}</td>
				   <td width="5%" align="center">{resultado_Pendientes}</td>
				   <td width="20%" align="center" nowrap>{resultado_Enviar}</td>
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
          <!--EndPaginarResultado-->
        
          <!--EndHayResultado-->

        
          <!--BeginNoHayResultado-->
          <p>No hay registros</p> 
          <!--EndNoHayResultado-->
        
			   </td>
             </tr>
           </table>
      <!--EndResultado-->

       
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