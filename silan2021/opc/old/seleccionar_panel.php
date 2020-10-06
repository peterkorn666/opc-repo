<?
include ('inc/sesion.inc.php');
include('conexion.php');
require "clases/trabajosLibres.php";

$imgMenuActivo=1;

$noDispone ='

<table width="500" border="1" cellpadding="5" cellspacing="0" bordercolor="#FF0000" bgcolor="#FFFFFF">
  <tr>
    <td><div align="center"><font color="#FF0000" size="2" face="Arial, Helvetica, sans-serif"><strong>Su tipo de usuario no le perimiete acceso a esta secci&oacute;n </strong></font></div></td>
  </tr>
</table>';

$cuantosInscriptosTL = new trabajosLibre;


?>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link href="estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {font-style: normal; font-weight: bold; text-decoration: none; color:#6600CC; font-family: Arial, Helvetica, sans-serif;}
.Estilo2 {font-size: 12px; font-style: normal; font-weight: bold; text-decoration: none; font-family: Arial, Helvetica, sans-serif;}
.Estilo3 {font-weight: bold; text-decoration: none; font-family: Arial, Helvetica, sans-serif; font-style: normal;}
-->
</style>
<script>

function config(){
	window.open("config.php","","scrollbars=yes,width=400,height=635")
}

function dire(cual){
	document.location.href = cual;
}


function desSeleccionarTodo(){
		
		tdCongreso.className="solapa_NO_selecionada";	
		tdTL.className="solapa_NO_selecionada";
		tdEstadisticas.className="solapa_NO_selecionada";	
		
		document.getElementById('divCongreso').style.display='none';
		document.getElementById('divTL').style.display='none';
		document.getElementById('divEstadisticas').style.display='none';
}


function seccion(cual){
	
	desSeleccionarTodo()

	if(cual == "Congreso"){
		tdCongreso.className="solapa_selecionada";	
		document.getElementById('divCongreso').style.display='inline';
	}
	
	if(cual == "TL"){
		tdTL.className="solapa_selecionada";
		document.getElementById('divTL').style.display='inline';
		
	}
	if(cual == "Estadisticas"){
		tdEstadisticas.className="solapa_selecionada";	
		document.getElementById('divEstadisticas').style.display='inline';
		
	}
	
	
}

function Abrir_ventana (pagina) {
var opciones="toolbar=no,location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=508, height=365, top=85, left=140";
window.open(pagina,"",opciones);
}

</script>
<script src="js/ajax.js"></script>
<script src="js/menuEdicion.js"></script>
<link href="estiloBordes.css" rel="stylesheet" type="text/css">
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "inc/vinculos.inc.php";?>
<span class="menu_sel"><b>

</b></span>
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CCCCCC">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php"; ?></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#CCCCCC"><div align="center">
	<?
		if($_SESSION["tipoUsu"]==1 || $_SESSION["tipoUsu"]==4){
		?>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="63" height="40"><div align="right"><img src="img/icon_herramientas.gif" width="40" height="40" onClick="config()"></div></td>
          <td width="317" height="40"><div align="left"><a href="javascript:config()" class="menu_sel">Configuraci&oacute;n del sistema.</a></div></td>
          <td width="47" height="40"><div align="left"><img src="img/database.png"></div></td>
          <td width="335" height="40"><div align="left">&nbsp;<a href="javascript:Abrir_ventana('respaldo/respaldo.php')" class="menu_sel" >Respaldar Base de datos.</a></div></td>
        </tr>
      </table>
	  <?
	  }
	  ?>
        <br>
        <table width="700" border="0" cellpadding="4" cellspacing="0" class="solapa_pie">
  <tr>
    <td width="145"></td>
    <td width="179"  id="tdCongreso"  class="solapa_selecionada"><div align="center"><a href="#" onClick="seccion('Congreso')">Secci&oacute;n Congreso </a></div></td>
    <td width="2"></td>
    <td width="179" id="tdTL" class="solapa_NO_selecionada"><div align="center"><a href="#"  onClick="seccion('TL')">Secci&oacute;n Trabajos Libres </a></div></td>
    <td width="2"></td>
    <td width="179" id="tdEstadisticas" class="solapa_NO_selecionada"><div align="center"><a href="#"  onClick="seccion('Estadisticas')">Estad&iacute;sticas e historial</a></div></td>
    <td width="147"></td>
  </tr>
</table>

        <br>
		
		<div id='divCongreso' style="display:nonse">
		 <?
		if($_SESSION["tipoUsu"]==1 || $_SESSION["tipoUsu"]==4){
		?>
	   	 <table width="500" border="0" cellspacing="5" cellpadding="0" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;">
          <? /*
          <tr>
            <td>
            <table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#000000">
              <tr>
                <td width="50%" bordercolor="#EAEAEA" bgcolor="#EAEAEA"><strong><font color="#666666" size="2">Inscripciones On-line al congreso </font></strong></td>
              </tr>
              
              <tr>
                <td bordercolor="#EAEAEA" bgcolor="#EAEAEA" class="menu_sel"><font color="#990000">
				
<font color="#990000">
<?
				require "clases/inscripciones.php";
				$cuantosInscriptos = new inscripciones;
				 
				?>
</font>				Total (<font color="#990000"><?=$cuantosInscriptos->cantidadInscripto();?></font>)<strong> Sin leer (<?=$cuantosInscriptos->cantidadInscriptoSinLeer();?>)
				
				
				
				</strong></font><strong> |</strong> <a href="bandejaEntradaInscripciones.php">Ir a bandeja de entrada </a></td>
              </tr>
			 
            </table>
              </td>
          </tr>
		*/?>
          <tr>
            <td width="50%"><table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;">
              <tr>
                <td bordercolor="#000000" bgcolor="#EAEAEA"><table width="100%" border="0" cellspacing="0" cellpadding="4">
                  <tr>
                    <td><span style="color:#000;"><strong>Secci&oacute;n programa</strong></span><hr></td>
                  </tr>
                </table>
                  <table width="100%"  border="1" cellpadding="2" cellspacing="5" bordercolor="#EAEAEA" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;">
                    <tr valign="top">
                      <td width="82%" bordercolor="#000000" bgcolor="#000000"><table width="100%"  border="0" cellspacing="2" cellpadding="0">
                        <tr>
                            <td bgcolor="#000000"><input name="Submit3" type="submit" class="botones" style="width:100%; height:60; font-size:16px; font-weight: bold; background-color:#CCEEFF; border:0px;" onClick="dire('altaCasillero.php');" value="Crear actividad (Casillero)"></td>
                        </tr>
                        <tr>
                            <td height="5" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="0">
                              <tr>
                                <td width="50%"><input name="Submit2" type="submit" class="botones" style="width:100%; height:30px;" onClick="dire('altaDia.php');" value="D&iacute;as"></td>
                                <td><input name="submit2" type="submit" class="botones" style="width:100%; height:30px;" onClick="dire('altaActividad.php');" value="Tipos de actividad"></td>
                              </tr>
                              <tr>
                                <td><input name="Submit222" type="submit" class="botones" style="width:100%; height:30px;" onClick="dire('altaSala.php');" value="Salas"></td>
                                <td><input name="submit52" type="submit" class="botones" style="width:100%; height:30px;" onClick="dire('altaArea.php');" value="&Aacute;reas"></td>
                              </tr>
                              <tr>
                                <td><input name="Submit22" type="submit" class="botones" style="width:100%; height:30px;" onClick="dire('altaHora.php');" value="Horarios"></td>
                                <td><input name="submit" type="submit" class="botones" style="width:100%; height:30px;" onClick="dire('altaTematica.php');" value="Tematicas"></td>
                              </tr>
                            </table></td>
                          </tr>
                        <tr>
                          <td height="5" bgcolor="#000000">&nbsp;</td>
                            </tr>
                        <tr>
                          <td height="5" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="0">
                            <tr>
                              <td width="50%"><input name="submit4" type="submit" class="botones" style="width:100%; height:30px;" onClick="dire('altaCalidad.php');" value="En Calidades"></td>
                              <td><input name="submit7" type="submit" class="botones" style="width:100%; height:30px;" onClick="dire('altaProfesion.php');" value="Profesiones"></td>
                            </tr>
                            <tr>
                              <td><input name="submit32" type="submit" class="botones" style="width:100%; height:30px;" onClick="dire('altaCargo.php');" value="Cargos"></td>
                              <td><input name="submit3" type="submit" class="botones" style="width:100%; height:30px;" onClick="dire('altaInstitucion.php');" value="Instituciones"></td>
                            </tr>
                            <tr>
                              <td><input name="submit6" type="submit" class="botones" style="width:100%; height:30px;" onClick="dire('altaPais.php');" value="Paises"></td>
                              <td>&nbsp;</td>
                            </tr>
                          </table></td>
                            </tr>
                        </table></td>
                      </tr>
                  </table>&nbsp;&nbsp;
                  
                  <center><div style="border:1px solid #666666; width:90%;"> <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                  <tr>
                    <td height="35" bgcolor="#F9F8FA">&nbsp;&nbsp;<a href="altaRecuadro.php" style="text-decoration:none;">Recuadros</a></td>
                  </tr>
                  
                </table>
				   </div></center><br>

				   <center><div style="border:1px solid #666666; width:90%; background-color:#F9F8FA"> <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" style=" background-image:url(img/envelop.gif); background-repeat:no-repeat; background-position:right">
                  <tr>
                    <td height="35">&nbsp;&nbsp;<a href="envioMail_listadoParticipantes.php" style="text-decoration:none;">Envio de mails masivos a participantes</a></td>
                  </tr>
                  
                </table>
				       <input name="submit22" type="submit" class="botones" style="width:100%;font-weight: bold;" onClick="dire('altaPersonas.php');" value="Personas">
				   </div></center><br></td>
              </tr>
            </table></td>
          </tr>
        </table>
		<?
		 }else{
		 echo $noDispone;
		 }
		?>
		</div>
		
		
		<div id='divTL' style="display:none1">
       	 <table width="500" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC">
          <tr>
            <td bordercolor="#000000" bgcolor="#E6DEEB"><table width="100%" border="0" cellspacing="0" cellpadding="4">
                <tr>
                  <td><strong><font size="2">&nbsp;<font color="#666666">Secci&oacute;n trabajos libres</font></font></strong></td>
                </tr>
              </table>
                <table width="100%"  border="2" cellpadding="4" cellspacing="4" bordercolor="#E6DEEB">
                  <tr bordercolor="#FF0000">
                    <td bordercolor="#FF0000" bgcolor="#FFCACA" class="menu_sel"><b>[<?=$cuantosInscriptosTL->cantidadInscriptoTL_estado("0");?>] </b><a href="estadoTL.php?estado=0">No revisados y registros On-line</a></td>
                  </tr>
                  <tr>
                    <td bordercolor="#0099CC" bgcolor="#79DEFF" class="menu_sel"><b>[<?=$cuantosInscriptosTL->cantidadInscriptoTL_estado("1");?>]</b> <a href="estadoTL.php?estado=1">En revisi&oacute;n</a></td>
                  </tr>
                  <tr>
                    <td bordercolor="#006600" bgcolor="#82E180" class="menu_sel"><b>[<b><?=$cuantosInscriptosTL->cantidadInscriptoTL_estado("2");?></b>]</b> <a href="estadoTL.php?estado=2">Aprobados</a></td>
                  </tr>
                  <tr>
                    <td bordercolor="#333333" bgcolor="#999999" class="menu_sel"><b>[<?=$cuantosInscriptosTL->cantidadInscriptoTL_estado("3");?>] </b><a href="estadoTL.php?estado=3">Rechazados</a></td>
                  </tr>
                </table>
				   <div align="center">
				     <input name="Submit232" type="submit" class="botones_tl" style="width:480; height:40;  font-weight: bold;" onClick="dire('estadisticasTL.php');" value="Estadisticas de trabajos">
				     <br>
				     <?
		if($_SESSION["tipoUsu"]==1){
		?>
                </div>
				
				   <br>
			   <center><div style="border:1px solid #666666; width:90%; background-color:#F9F8FA"> <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" style=" background-image:url(img/envelop.gif); background-repeat:no-repeat; background-position:right">
                  <tr>
                    <td>&nbsp;&nbsp;<a href="envioMail_trabajosLibres.php">Envio de mails masivos a los contactos de trabajos</a></td>
                  </tr>
                  <tr>
                    <td>&nbsp;&nbsp;<a href="envioMail_Autores_trabajosLibres.php">Envio de mails masivos a los autores/coautores de trabajos</a></td>
                  </tr>
                </table></div></center>
				<br>
				  <center><div style="border:1px solid #666666; width:90%; background-color:#EAEAEA"> <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" style=" background-image:url(img/excel_fnd.gif); background-repeat:no-repeat; background-position:right">
                  <tr>
                    <td>&nbsp;&nbsp;<a href="todoslostrabajos.php" target="_blank">Todos los Trabajos - Planilla Excel</a></td>
                  </tr>
                  <tr>
                    <td>&nbsp;&nbsp;<a href="todoslosautores.php" target="_blank">Todos los Autores  - Planilla Excel</a></td>
                  </tr>
                </table></div></center>
				  <br>
				<table width="100%"  border="1" align="center" cellpadding="2" cellspacing="5" bordercolor="#E6DEEB">
                  <tr valign="top" bgcolor="#000000">
                    <td bordercolor="#000000"><table width="100%"  border="0" cellpadding="0" cellspacing="2" bgcolor="#000000">
                        <tr>
                          <td bgcolor="#DDD0E1"><input name="Submit23" type="submit" class="botones_tl" style="width:100%; height:40;  font-weight: bold;" onClick="dire('altaTrabajosLibres.php');" value="Crear nuevo trabajo">                          </td>
                        </tr>
                        <tr>
                          <td bgcolor="#DDD0E1"><input name="Submit2322" type="submit" class="botones_tl" style="width:100%;" onClick="dire('altaPersonasTL.php');" value="Persona para trabajos">                          </td>
                        </tr>
                        <tr>
                          <td bgcolor="#DDD0E1"><input name="Submit2323" type="submit" class="botones_tl" style="width:100%;" onClick="dire('altaAreaTL.php');" value="Areas de trabajos"></td>
                        </tr>
                        <tr>
                          <td bgcolor="#DDD0E1"><input name="Submit23232" type="submit" class="botones_tl" style="width:100%;" onClick="dire('altaTipoTL.php');" value="Tipos  de trabajos"></td>
                        </tr>
                    </table></td>
                  </tr>
              </table>
			  
			  <div align="center">
			    <?
			  }
			  ?>
			  </div></td>
          </tr>
        </table>
		</div>
		
		
		<div id='divEstadisticas' style="display:none1">
        <?
		if($_SESSION["tipoUsu"]==1){
		?>
        <table width="100%"  border="1" cellpadding="3" cellspacing="0" bordercolor="#333333">
        <tr>
          <td bordercolor="#999999" bgcolor="#999999"><table width="100%"  border="1" cellpadding="3" cellspacing="2" bordercolor="#999999">
                            <tr>
                              <td bordercolor="#666666" bgcolor="#E7F1EA"><font color="#666666" size="2"><strong>Envíos Masivos Realizados:</strong></font><br>
                                <br>
								
                                  <table width="100%"  border="0" cellspacing="1" cellpadding="4">
                                    <tr>
                                      <td valign="middle" bgcolor="#DAE9DE"><div align="left"><font size="2"><b>&nbsp;&nbsp;&nbsp;Envío a contáctos de Trabajos&nbsp;&nbsp;</b> <a href="bajar.php?id=envioMasivoTrabajos.txt">Descargar</a> - <a href="envioMasivoTrabajos.txt" target="_blank">Ver online</a></font></div></td>
                                    </tr>
                                    <tr>
                                      <td valign="middle" bgcolor="#DAE9DE"><div align="left"><font size="2"><b>&nbsp;&nbsp;&nbsp;Env&iacute;o a Autores / Coautores de Trabajos&nbsp;&nbsp;</b> <a href="bajar.php?id=envioMasivoAutores.txt">Descargar</a> - <a href="envioMasivoAutores.txt" target="_blank">Ver online</a></font></div></td>
                                    </tr>
                                    <tr>
                                      <td valign="middle" bgcolor="#DAE9DE"><div align="left"><font size="2"><b>&nbsp;&nbsp;&nbsp;Env&iacute;o a Coordinadores/Conferencistas&nbsp;&nbsp;</b> <a href="bajar.php?id=envioMasivoParticipantes.txt">Descargar</a> - <a href="envioMasivoParticipantes.txt" target="_blank">Ver online</a></font></div></td>
                                    </tr>
                                </table>
							
							  </td>
                            </tr>
                          </table>
						  <table width="100%"  border="1" cellpadding="3" cellspacing="2" bordercolor="#999999">
                            <tr>
                              <td bordercolor="#666666" bgcolor="#CCCCCC"><font color="#666666" size="2"><strong>Visitas a distintas secciones:</strong></font><br>
                                <br>
								<?
								 $sql = "SELECT * FROM estadisticas LIMIT 1;";
									  $rs = mysql_query($sql,$con);
									  while ($row = mysql_fetch_array($rs)){
 
									  ?>
                                  <table width="100%"  border="0" cellspacing="1" cellpadding="4">
                                    <tr>
                                      <td width="23%" valign="middle" bgcolor="#DADADA"><div align="left"><font size="2"><b>Cronograma</b></font></div></td>
                                      <td width="77%" bgcolor="#E2E2DC"><font size="2">
                                      <?=$row["Crono"];?>
                                      </font></td>
                                    </tr>
                                    <tr>
                                      <td valign="middle" bgcolor="#DADADA"><div align="left"><font size="2"><b>Programa Extendido </b></font></div></td>
                                      <td bgcolor="#E2E2DC"><font size="2">
                                      <?=$row["Programa"];?>
                                      </font></td>
                                    </tr>
                                    <tr>
                                      <td valign="middle" bgcolor="#DADADA"><div align="left"><font size="2"><b>Listado de participantes </b></font></div></td>
                                      <td bgcolor="#E2E2DC"><font size="2">
                                      <?=$row["Listado"];?>
                                      </font></td>
                                    </tr>
                                    <tr>
                                      <td valign="middle" bgcolor="#DADADA"><div align="left"><font size="2"><b>Buscar</b></font></div></td>
                                      <td bgcolor="#E2E2DC"><font size="2">
                                      <?=$row["Buscador"];?>
                                      </font></td>
                                    </tr>
                                </table>
							  <?
								}
								?>							  </td>
                            </tr>
                          </table>
                          <table width="100%"  border="1" cellpadding="3" cellspacing="2" bordercolor="#999999">
                            <tr>
                              <td bordercolor="#666666" bgcolor="#CCCCCC"><font color="#666666" size="2"><strong>Ultimos 10 Modificaciones:</strong></font><br>
                                  <br>
                              
                                  <table width="100%"  border="0" cellspacing="1" cellpadding="2">
                                    <tr bgcolor="#333333">
                                      <td width="15%" valign="middle"><div align="center"><b><font color="#FFFFFF" size="2">Fecha</font></b></div></td>
                                      <td width="9%"><div align="center"><b><font color="#FFFFFF" size="2">Usuario</font></b></div></td>
                                      <td width="76%"><b><font color="#FFFFFF" size="2">Modificacion</font></b></td>
                                    </tr>
									    <?
									 $sql = "SELECT * FROM modificaciones ORDER BY ID DESC LIMIT 10;";
									  $rs = mysql_query($sql,$con);
									  while ($row = mysql_fetch_array($rs)){
									  ?>
                                    <tr valign="top">
                                      <td bgcolor="#DADADA"><div align="center"><font size="2">
                                      <?=$row["Tiempo"]?>
                                      </font></div></td>
                                      <td bgcolor="#E2E2DC"><div align="center"><font color="#990000"><b><font size="2">
                                      <?=$row["Usuario"]?>
                                      </font></b></font></div></td>
                                      <td bgcolor="#DADADA"><font size="1">
                                      <?=$row["Cambio"]?>
                                      </font></td>
                                    </tr>
									    <?
								}
								?>
                              </table>                              </td>
                            </tr>
              </table>            </td>
        </tr>
      </table>
		<?
		 }else{
		 echo $noDispone;
		 }
		 ?>
	    </div>
		 
		 
		 
		 
		 
      <font color="#666666"><br>
      </font>
      <p><font color="#666666" size="2">SistemaCongresos v.2.06</font></p>
      <p><font color="#000000" size="1">por <img src="img/gega.png" alt="GEGA" width="30" height="69" align="absmiddle" longdesc="GEGA | editorial | web | multimedia">GEGA s.r.l.</font><br>
          <br>
      </p>
    </div>    </td>
  </tr>
</table>

<?
if($_SESSION["tipoUsu"]==1 || $_SESSION["tipoUsu"]==4){
echo "<script>seccion('Congreso')</script>";
}
if($_SESSION["tipoUsu"]==2){
echo "<script>seccion('TL')</script>";
}
?>

