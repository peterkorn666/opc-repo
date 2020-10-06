<?
include "inc/sesion.inc.php";
include('conexion.php');
require "clases/class.Cartas.php";
$cartas = new cartas();

$titulo = "";
$subtitulo = "";
$asunto = "";
$destinatarios = "";
$cuerpo = "";
$txt = "Alta";


if ( ($_GET["action"]!="")&&($_GET["id"]!="") ){	
	if (base64_decode($_GET["action"])=="b"){	
		$cartas->eliminarUna(base64_decode($_GET["id"]));
	} 
	if (base64_decode($_GET["action"])=="m"){	
		$modify = $cartas->cargarUna(base64_decode($_GET["id"]));
		if ($letter = $modify->fetch_array()){
			$titulo = utf8_decode($letter["titulo"]);
			$subtitulo = $letter["subtitulo"];
			$asunto = utf8_decode($letter["asunto"]);
			$destinatarios = $letter["destinatarios"];
			$cuerpo = utf8_decode($letter["cuerpo"]);
			$txt = "Modificar";
		}
	} 	
}

if ($_GET["nueva"]!=""){
	$destinatarios = base64_decode($_GET["nueva"]);
}

?>
<link href="estilos.css" rel="stylesheet" type="text/css">
<script src="js/cartasPersonalizadas.js"></script>
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "inc/vinculos.inc.php";?>
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CCCCCC">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php";?></td>
  </tr>
  <tr>
    <td valign="top" align="center"><br>
			<strong><font color="#666666" size="3"><?=$txt?> carta Predefinida</font></strong> <? if ($txt=="Modificar"){ echo " - ". $titulo; } ?>&nbsp;<br>
<a href="envioMail_Autores_trabajosLibres.php">Autores</a> | <a href="envioMail_listadoInscriptos.php">Inscriptos</a> | <a href="envioMail_listadoParticipantes.php">Conferencistas</a> | <a href="envioMail_trabajosLibres.php">Autores de trabajos</a><br>
<a href="buscar_avanzada.php">Busqueda Avanzada en Congreso</a> | <a href="estadoTL.php?estado=cualquier&vacio=true">Busqueda Avanzada en Trabajos</a>
 <form name="form1" method="post" action="altaCartaPersonalizadaEnviar.php">
  <table width="100%" border="1" cellpadding="5" cellspacing="2" bordercolor="#CCCCCC">
    <tr valign="top">
      <td valign="top" bordercolor="#000000" bgcolor="#000000">
       <table width="100%"  border="0" cellpadding="4" cellspacing="0">
        <tr valign="top">
          <td height="10" colspan="3" bgcolor="#CCCCCC" class="crono_trab">T&iacute;tulo de la Carta</td>
          <td colspan="2" bgcolor="#CCCCCC" class="crono_trab">Subtitulo de la Carta</td>
        </tr>
        <tr valign="top">
          <td height="10" colspan="3" bgcolor="#CCCCCC"><input name="titulo" type="text" id="titulo" size="55"  style="width:98%" value="<?=$titulo?>">          </td>
          <td height="10" colspan="2" bgcolor="#CCCCCC"><input name="subtitulo" type="text" id="subtitulo" size="55"  style="width:98%" value="<?=$subtitulo?>"></td>
        </tr>
        <tr valign="top">
          <td height="10" colspan="3" bgcolor="#CCCCCC" class="crono_trab">A qui&eacute;n esta dirigida</td>
          <td height="10" colspan="2" bgcolor="#CCCCCC" class="crono_trab">Asunto</td>
        </tr>
        <tr valign="top">
          <td height="10" colspan="3" bgcolor="#CCCCCC"><select name="destinatarios" style="width:98%"   >
            <option value="">Seleccione</option>
            <option value="Contactos" <? if ($destinatarios=="Contactos"){ echo "selected"; } ?> >Contactos de Trabajos Libre</option>
            <option value="Autores" <? if ($destinatarios=="Autores"){ echo "selected"; } ?> >Autores de Trabajos Libres</option>
            <option value="Conferencistas" <? if ($destinatarios=="Conferencistas"){ echo "selected"; } ?> >Conferencistas</option>
            <!--<option value="Inscriptos" <? if ($destinatarios=="Inscriptos"){ echo "selected"; } ?> >Inscriptos</option>-->
            <!--<option value="Casillero" <? if ($destinatarios=="Casillero"){ echo "selected"; } ?> >Env&iacute;os por busqueda avanzada</option>-->
          </select></td>
          <td height="10" colspan="2" bgcolor="#CCCCCC"><input name="asunto" type="text" id="asunto" size="55" style="width:98%" value="<?=$asunto?>"></td>
        </tr>
        <tr valign="top">
          <td width="16%" height="10" rowspan="2" valign="bottom" bgcolor="#CCCCCC" class="crono_trab">
	<span class="crono_trab">Cuerpo de la Carta:</span></td>
          <td width="5%" valign="bottom" bgcolor="#9E9E9E" class="linea_persona" ><img src="img/html.png" alt="" width="28" height="20" border="0"></td>
          <td colspan="2" valign="middle" bgcolor="#9E9E9E" class="linea_persona" ><a href="http://word2cleanhtml.com/" style="text-decoration:none; color:#FFFFFF" target="_blank">&nbsp; <strong>Editor de cartas online presione <span style="color:#FF6">aqu&iacute;</span></strong></a></td>
          <td width="19%" height="10" rowspan="2" align="right" valign="bottom" bgcolor="#CCCCCC" class="trabCronoExt"><div id="vista" onClick='abrir("vistaPreviaCartaPersonalizada.php?id=<?=$_GET["id"];?>")' style="cursor:pointer">Vista previa</div></td>
          </tr>
        <tr valign="top">
          <td colspan="3" bgcolor="#F3F3F3" class="linea_persona" >Dise&ntilde;e su carta en un procesador de texto con el formato deseado.
Copie el documento y p&eacute;guelo en cuadro de texto de la WEB.<br>
Para generar el c&oacute;digo fuente de la carta, presione &quot;Convert to clean HTML&quot;. <br>
Copie el c&oacute;digo generado y p&eacute;guelo en el recuadro que aparece aqu&iacute; debajo (<span style="font-size:18px">&darr;</span>)</td>
        </tr>
        <tr valign="top">
          <td align="center"colspan="5" bgcolor="#CCCCCC"><span class="crono_trab">
            <textarea name="cuerpoCarta" id="cuerpoCarta" style="width:98%;" rows="13" ><?=$cuerpo?></textarea>
          </span></td>
        </tr>
        <tr valign="top">
          <td colspan="5" align="center" bgcolor="#CCCCCC" class="crono_trab">
    <table width="250" border="0" cellspacing="1" cellpadding="2" bgcolor="#333333" class="textos" style="width:98%">
  <tr>
    <td colspan="4" bgcolor="#CCCCCC" class="trabCronoExt"><strong>Trabajos Libres: (copiar y pegar)</strong></td>
    </tr>
  <tr>
    <td width="109" bgcolor="#F4F4F4"><strong>Profesi&oacute;n</strong></td>
    <td width="258" bgcolor="#F4F4F4">&lt;:profesion&gt;</td>
    <td width="101" bgcolor="#F4F4F4"><strong>Mail</strong></td>
    <td width="271" bgcolor="#F4F4F4">&lt;:mail&gt;</td>
  </tr>
  <tr>
    <td bgcolor="#F4F4F4"><strong>Nombre</strong></td>
    <td bgcolor="#F4F4F4">&lt;:nombreContacto&gt;</td>
    <td bgcolor="#F4F4F4"><strong>Ciudad</strong></td>
    <td bgcolor="#F4F4F4">&lt;:ciudad&gt;</td>
  </tr>
  <tr>
    <td bgcolor="#F4F4F4"><strong>Apellido</strong></td>
    <td bgcolor="#F4F4F4">&lt;:apellidoContacto&gt;</td>
    <td bgcolor="#F4F4F4"><strong>Cargos</strong></td>
    <td bgcolor="#F4F4F4">&lt;:cargos&gt;</td>
  </tr>
  <tr>
    <td bgcolor="#F4F4F4"><strong>Pa&iacute;s</strong></td>
    <td bgcolor="#F4F4F4">&lt;:pais&gt;</td>
    <td bgcolor="#F4F4F4"><strong>Fecha (ingl&eacute;s)</strong></td>
    <td bgcolor="#F4F4F4">&lt;:fecha&gt;</td>
  </tr>
  <tr>
    <td bgcolor="#F4F4F4"><strong>Instituci&oacute;n</strong></td>
    <td bgcolor="#F4F4F4">&lt;:institucion&gt;</td>
    <td bgcolor="#F4F4F4"><strong>Fecha (espa&ntilde;ol)</strong></td>
    <td bgcolor="#F4F4F4">&lt;:fecha2&gt;</td>
  </tr>
  <tr>
    <td bgcolor="#F4F4F4"><strong>Fecha Nacimiento</strong></td>
    <td bgcolor="#F4F4F4">&lt;:fecha_Nacimiento&gt;</td>
    <td bgcolor="#F4F4F4"><strong>Clave</strong></td>
    <td bgcolor="#F4F4F4">&lt;:clave&gt;</td>
  </tr>
    </table>
    <table width="250" border="0" cellspacing="1" cellpadding="2" bgcolor="#333333" class="textos" style="width:98%">
      <tr>
        <td colspan="4" bgcolor="#CCCCCC" class="trabCronoExt"><strong>Conferencistas:</strong></td>
        </tr>
      <tr>
        <td bgcolor="#F4F4F4"><strong>Nombre</strong></td>
        <td bgcolor="#F4F4F4">&lt;:nombre&gt;</td>
        <td bgcolor="#F4F4F4"><strong>Apellido</strong></td>
        <td bgcolor="#F4F4F4">&lt;:apellido&gt;</td>
      </tr>
      <tr>
        <td bgcolor="#F4F4F4"><strong>Profesi&oacute;n</strong></td>
        <td bgcolor="#F4F4F4">&lt;:profesion&gt;</td>
        <td bgcolor="#F4F4F4"><strong>Instituci&oacute;n</strong></td>
        <td bgcolor="#F4F4F4">&lt;:institucion&gt;</td>
      </tr>
      <tr>
        <td bgcolor="#F4F4F4"><strong>Mail</strong></td>
        <td bgcolor="#F4F4F4">&lt;:mail&gt;</td>
        <td bgcolor="#F4F4F4"><strong>Vinculo a la ficha</strong></td>
        <td bgcolor="#F4F4F4">&lt;:link_conferencista&gt;</td>
      </tr>
      <tr>
        <td width="162" bgcolor="#F4F4F4"><strong>Hotel</strong></td>
        <td width="207" bgcolor="#F4F4F4">&lt;:hotel&gt;</td>
        <td width="169" bgcolor="#F4F4F4"><strong>Habitaci&oacute;n</strong></td>
        <td width="200" bgcolor="#F4F4F4">&lt;:habitacion&gt;</td>
        </tr>
      <tr>
        <td bgcolor="#F4F4F4"><strong>Fecha In</strong></td>
        <td bgcolor="#F4F4F4">&lt;:hotel_in&gt;</td>
        <td bgcolor="#F4F4F4"><strong>Fecha Out</strong></td>
        <td bgcolor="#F4F4F4">&lt;:hotel_out&gt;</td>
        </tr>
      <tr>
        <td bgcolor="#F4F4F4"><strong>Cantidad de noches</strong></td>
        <td bgcolor="#F4F4F4">&lt;:cantidad_noches&gt;</td>
        <td bgcolor="#F4F4F4"><strong>Costo del hotel</strong></td>
        <td bgcolor="#F4F4F4">&lt;:costo_hotel&gt;</td>
        </tr>
      <tr>
        <td bgcolor="#F4F4F4"><strong>C&oacute;digo de reserva </strong></td>
        <td bgcolor="#F4F4F4">&lt;:codigo_reserva&gt;</td>
        <td bgcolor="#F4F4F4"><strong>Forma de pago</strong></td>
        <td bgcolor="#F4F4F4">&lt;:forma_pago&gt;</td>
        </tr>
      <tr>
        <td bgcolor="#F4F4F4"><strong>Aeropuerto de partida</strong></td>
        <td bgcolor="#F4F4F4">&lt;:aeropuero&gt;</td>
        <td bgcolor="#F4F4F4"><strong>Compania de arribo</strong></td>
        <td bgcolor="#F4F4F4">&lt;:compania_arribo&gt;</td>
        </tr>
      <tr>
        <td bgcolor="#F4F4F4"><strong>Vuelo de arribo</strong></td>
        <td bgcolor="#F4F4F4">&lt;:vuelo_arribo&gt;</td>
        <td bgcolor="#F4F4F4"><strong>Fecha de arribo</strong></td>
        <td bgcolor="#F4F4F4">&lt;:fecha_arribo&gt;</td>
      </tr>
      <tr>
        <td bgcolor="#F4F4F4"><strong>Hora de arribo</strong></td>
        <td bgcolor="#F4F4F4">&lt;:hora_arribo&gt;</td>
        <td bgcolor="#F4F4F4"><strong>Quien se hace cargo Arribo</strong></td>
        <td bgcolor="#F4F4F4">&lt;:quien_se_hace_cargo_arribo&gt;</td>
      </tr>
      <tr>
        <td bgcolor="#F4F4F4"><strong>Hora Traslado Arribo</strong></td>
        <td bgcolor="#F4F4F4">&lt;:hora_traslado_1&gt;</td>
        <td bgcolor="#F4F4F4"><strong>Compania Partida</strong></td>
        <td bgcolor="#F4F4F4">&lt;:compania_partida&gt;</td>
      </tr>
      <tr>
        <td bgcolor="#F4F4F4"><strong>Vuelo de Partida</strong></td>
        <td bgcolor="#F4F4F4">&lt;:vuelo_partida&gt;</td>
        <td bgcolor="#F4F4F4"><strong>Fecha Partida</strong></td>
        <td bgcolor="#F4F4F4">&lt;:fecha_partida&gt;</td>
      </tr>
      <tr>
        <td bgcolor="#F4F4F4"><strong>Hora  Partida</strong></td>
        <td bgcolor="#F4F4F4">&lt;:hora_partida&gt;</td>
        <td bgcolor="#F4F4F4"><strong>Quien se hace cargo Partida</strong></td>
        <td bgcolor="#F4F4F4">&lt;:quien_se_hace_cargo_partida&gt;</td>
      </tr>
      <tr>
        <td bgcolor="#F4F4F4"><strong>Hora Traslado Partida</strong></td>
        <td bgcolor="#F4F4F4">&lt;:hora_traslado_2&gt;</td>
        <td bgcolor="#F4F4F4"><strong>Nombre de acompa&ntilde;ante</strong></td>
        <td bgcolor="#F4F4F4">&lt;:nombre_acompa&ntilde;ante&gt;</td>
      </tr>
      <tr>
        <td bgcolor="#F4F4F4"><strong>N&uacute;mero de recibo</strong></td>
        <td bgcolor="#F4F4F4">&lt;:numero_Recibo&gt;</td>
        <td bgcolor="#F4F4F4"><strong>Carta para Mail</strong></td>
        <td bgcolor="#F4F4F4">&lt;:carta_Mail&gt;</td>
      </tr>
      <tr>
        <td bgcolor="#F4F4F4"><strong>Estado de Pago</strong></td>
        <td bgcolor="#F4F4F4">&lt;:estado_Pago&gt;</td>
        <td bgcolor="#F4F4F4"><strong>Monto Pago</strong></td>
        <td bgcolor="#F4F4F4">&lt;:monto_Pago&gt;</td>
      </tr>
    </table></td>
        </tr>
        <tr valign="top">
          <td colspan="5" align="center" height="10" bgcolor="#CCCCCC" class="crono_trab">
          <table width="380" style="width:98%" cellpadding="2" cellspacing="1" bgcolor="#333333">
        <tr valign="top">
          <td width="19" bgcolor="#CCCCCC" class="crono_trab">&nbsp;</td>
          <td width="272" bgcolor="#CCCCCC" class="trabCronoExt"><strong>T&iacute;tulo</strong></td>
          <td width="217" bgcolor="#CCCCCC" class="trabCronoExt"><strong>Subtitulo</strong></td>
          <td width="167" bgcolor="#CCCCCC" class="trabCronoExt"><strong>Destinatarios</strong></td>
          <td width="18" bgcolor="#CCCCCC" class="trabCronoExt">&nbsp;</td>
        </tr>
      <?
	  $lista = $cartas->listarTodas();
	  while ($row = $lista->fetch_array()){
	  ?> 
      <tr valign="top" class="textos" bgcolor="#F4F4F4" onMouseOver="this.style.backgroundColor='#FFFFCC'" onMouseOut="this.style.backgroundColor='#F4F4F4'">
          <td align="center" valign="middle"><a href='altaCartaPersonalizada.php?action=<?=base64_encode("m")?>&id=<?=base64_encode($row["idCarta"])?>'  target='_parent'> <img src='img/modificar.png' border='0' title='Modificar esta carta'></a> </td>
          <td valign="middle" ><?=$row["titulo"]?></td>
          <td valign="middle" ><?=$row["subtitulo"]?></td>
          <td valign="middle"  ><?=$row["destinatarios"]?></td>
          <td align="center" valign="middle"><a href='altaCartaPersonalizada.php?action=<?=base64_encode("b")?>&id=<?=base64_encode($row["idCarta"])?>'  target='_parent'><img src='img/eliminar.png' border='0' title='Eliminar esta carta'></a></td>
        </tr>
      
      <? } ?>
        </table></td>
        </tr>
        <tr valign="top">
          <td height="10" colspan="5" bgcolor="#CCCCCC"><div align="right">
	          <input name="action" type="hidden" value="<?=$_GET["action"]?>">
              <input name="id" type="hidden" value="<?=$_GET["id"]?>">
              <input name="Submit" type="button" class="botones"  onClick="validar()" value="Guardar">
          </div></td>
        </tr>
      </table>        	 
        </td>
    </tr>
   
  </table>
</form></td>
  </tr>
</table>
<script>
function abrir(url) {
open(url,'','top=100,left=100,width=800, height=600,scrollbars=yes') ;
}
</script>

