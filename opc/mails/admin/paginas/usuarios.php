 
<!--BeginPrincipal-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><!-- #BeginTemplate "/Templates/sistemaMailsAdmin.dwt" --><!-- DW6 -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- #BeginEditable "doctitle" --> 
<title>Sistema de Mails</title>
<!-- #EndEditable -->


<!-- #BeginEditable "head" --><script type="text/javascript" src="../js/prototype.js"></script>
<script type="text/javascript" src="../js/funcionEnter.js"></script><!-- #EndEditable -->
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
                      <td><!-- #BeginEditable "titulo" -->Usuarios<!-- #EndEditable --><br /><!-- #BeginEditable "contenido" -->{Form} {CamposOcultos}<!--BeginFormBuscador-->  
<p class="textos" align="right" style="margin:0px;"> 
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
        <tr> 
          <td width="100%" height="107"> 
            <table width="100%" border="0" align="center" cellpadding="4" cellspacing="3">
              <tr valign="middle"> 
                <td valign="middle" class="TXTArial10878E96"> 
                  <div align="right">Nombre</div>                </td>
                <td> 
                  <input name="nombre" type="text" class="BOX100x20" value="{Nombre}" />                </td>
                <td class="TXTArial10878E96"> 
                  <div align="right">Nivel</div>                </td>
                <td class="TXTArial10878E96"> 
                  <select name="nivel" class="BOX100x20" >
			{Niveles}
                      
                  </select>                </td>
              </tr>
              <tr valign="middle"> 
                <td valign="middle" class="TXTArial10878E96"> 
                  <div align="right">Usuario</div>                </td>
                <td> 
                  <input name="usuario" type="text" class="BOX100x20" value="{Usuario}" />                </td>
                <td class="TXTArial10878E96"> 
                  <div align="right">Estado</div>                </td>
                <td class="TXTArial10878E96"> 
                  <select name="estado" class="BOX100x20" >
			{Estados}
                      
                  </select>                </td>
              </tr>
              <tr valign="middle"> 
                <td height="35" colspan="4" class="TXTArial10878E96"><div class="btn" align="center"><a href="#" onclick="buscar();">Buscar</a></div>
                 <div class="btn" align="center"><a href="#" onclick="document.frmBuscar.elements['accion'].value='limpiarBusquedaGuardada';document.frmBuscar.submit();">Ver Todos</a></div></td>
              </tr>
            </table>
			</td>
        </tr>
      </table>
			 <!--EndFormBuscador-->{FormCierre}{Scripts} 
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
			 <table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#E9E9E9" style="border:1px solid #FFFFFF">
               <tr class="cabezal_asc">
                 <td align="center">&nbsp;</td>
                 <td align="center">{Orden_Usuario_asc}</td>
                 <td align="center">{Orden_Nombre_asc}</td>
                 <td align="center">{Orden_Nivel_asc}</td>
                 <td align="center">{Orden_Estado_asc}</td>
                 <td align="center">&nbsp;</td>
                 <td align="center">&nbsp;</td>
               </tr>
               <tr class="cabezal">
                 <td  align="center">Sel</td>
                 <td align="center"><div align="center" class="Estilo1">Usuario</div></td>
                 <td align="center"><div align="center" class="Estilo1">Nombre</div></td>
                 <td align="center"><div align="center" class="Estilo1">Nivel</div></td>
                 <td align="center"><div align="center" class="Estilo1">Estado</div></td>
                 <td align="center">Ver/Editar</td>
                 <td align="center">Borrar</td>
               </tr>
               <tr class="cabezal_desc">
                 <td align="center">&nbsp;</td>
                 <td align="center">{Orden_Usuario_desc}</td>
                 <td align="center">{Orden_Nombre_desc}</td>
                 <td align="center">{Orden_Nivel_desc}</td>
                 <td align="center">{Orden_Estado_desc}</td>
                 <td align="center">&nbsp;</td>
                 <td align="center">&nbsp;</td>
               </tr>
               <!--BeginFilaResultado-->
               <tr  class="resultado_fila{resultado_tipoFila}" {resultado_scriptFila}>
                 <td><input type="checkbox" name="Id[]" value="{Id}" /></td>
                 <td >{resultado_Usuario}</td>
                 <td >{resultado_Nombre}</td>
                 <td >{resultado_Nivel}</td>
                 <td >{resultado_Estado}</td>
                 <td ><a href="#" onclick="return editar('{Id}')";><img src="../img/editar.gif" width="20" height="22" border="0" /></a></td>
                 <td ><a href="#" onclick="return borrar('{Id}','{Usuario}')";><img src="../img/borrar.gif" width="20" height="22" border="0" /></a></td>
               </tr>
               <!--EndFilaResultado-->
             </table>
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
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
        <tr> 
          <td > 
            <div align="left"> </div>          </td>
        </tr>
        <tr> 
          <td height="20"> 
            <div align="right"> 
              <input type="button" name="btnAgregar" value="Agregar" onclick="return agregar();" />
              <input type="submit" name="btnBorrar" value="Borrar" onclick="return confirmarBorrarSeleccionadas();" />
            </div>          </td>
        </tr>
      </table>
      <br/>
      <!--EndResultado-->

       
      <!--BeginFormEdicion-->
      <!--EndFormEdicion--><!-- #EndEditable --></td>
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
