<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");

if (!isset($_SESSION["registrado"])){
	$_SESSION["registrado"]=false;
}
$_SESSION["finalizo"]=0;
include('conexion.php');
include("inc/validarVistas.inc.php");
include("inc/sesion.inc.php");
require "clases/class.Cartas.php";
require "clases/trabajosLibres.php";
$trabajo = new trabajosLibre;
$cartas = new cartas();
$_POST["tl"] = ($_POST["id_trabajos"]?$_POST["id_trabajos"]:$_POST["tl"]);
?>

<script src="js/envioMail.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">

<!--
.personas {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	background-color: #F0F0F0;
	width: 70%;
	margin: 1px;
	padding: 4px;
	border: 1px solid #999999;
	position:relative;
	left: 100;
}
.personasTL {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	background-color:#E8DBE8;
	width: 100%;
	margin: 1px;
	padding: 4px;
	border: 1px solid #999999;
	position:relative;
}
#Guardando{
	background-color: #FFBFBF;
	margin: 5px;
	padding: 5px;
	height: 20px;
	width: 150px;
	border: 1px solid #FF0000;
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 16px;
	font-weight: bold;
	font-style: italic;
	text-align: center;
	position:absolute;
	left:0px;
	
	visibility:hidden;
top: expression( ( 0 + ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ) ) + 'px' );


}
body > #Guardando { position: fixed; left: 0px; top: 0px; }

#msn1{
	background-color: #FFFFCC;
	margin: 2px;
	padding: 2px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	text-align: center;
	font-weight: bold;
}
#abc {
	background-color: #FFFFFF;
	padding: 2px;
	border: 1px solid #333333;
	margin: 2px;
}
#abcTL {
	background-color: #F7F4F7;
	padding: 2px;
	border: 1px solid #333333;
	margin: 2px;
}
.Estilo4 {
	color: #333333;
	font-size: 11px;
}
.campos {	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	width: 200px;
}
-->
</style>

<body background="fondo_2.jpg" leftmargin="0" topmargin="0" bgproperties="fixed" marginwidth="0" marginheight="0">
<? include "inc/vinculos.inc.php";?>
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CCCCCC">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php"; ?></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F0E6F0" align="center"><div align="center" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:16px"><strong><br>
      Envio de e-mails</strong><br>
      Trabajos</div>
      <form action="envioMail_trabajosLibres_send.php" method="post" enctype="multipart/form-data" name="form1">
	<iframe id="guardarInscripcion" name="guardarInscripcion" style="display:none"></iframe>
        <table width="90%" border="0" cellspacing="5" cellpadding="2">
          <tr>
            <td align="center"><div style="width:85%; background-color:#FEFFEA; border:1px solid #333;"><table width="100%" border="0" align="center" cellpadding="10" cellspacing="0" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:13px">             <tr>
                      <td width="14%"><strong>Asunto:</strong></td>
                      <td width="86%"><span>
                        <input name="asunto0" type="text" id="asunto0"  style="width:30%; font-size:11px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif">
                      </span><span><strong><font color="#666666"> [Cod.Trab] [Apellido Nombre] </font></strong></span><span>
                      <input name="asunto1" type="text" id="asunto1"  style="width:25%; font-size:11px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif">
                      </span></td>
                    </tr>
                    <tr>
                      <td colspan="2"><strong>Adjuntar un archivo:
                        <input name="archivo" type="file" class="campos" id="archivo"  style="width:50%; font-size:13x; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif"/>
                        </strong>
                          <input name="archivoTMP" type="hidden" id="archivoTMP"></td>
                    </tr>
                         <tr>
                    <td colspan="2">
                  <label  for="rbCartaManual" style="cursor:pointer">
                    <input name="rbCarta" id="rbCartaManual" checked="checked" type="radio" value="Manual" />
                    <strong>Carta 
                    Manual </strong></label><br>
<? 
				  $listaPredefinidas = $cartas->cargarPredefinidas("Contactos");
				  while ($predefinida = $listaPredefinidas->fetch_array()){ ?>     
                         <label  for="rbCartaPredefinida<?=$predefinida["titulo"]?>" style="cursor:pointer">             		
				  		 <input name="rbCarta" id="rbCartaPredefinida<?=$predefinida["idCarta"]?>" type="radio" value="<?=$predefinida["idCarta"]?>" <? if($_SESSION["rbCarta"]==$predefinida["idCarta"]){echo 'checked="checked"';}?>>
                         <strong><?=$predefinida["titulo"]?></strong> - <?=$predefinida["subtitulo"]?></label>
                         
                         <br>
				  <?   }	?>
                  <br><br>
   
                  <textarea id="carta" name="carta" rows="5" style="padding:2px; width:100%; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:11px"></textarea>
                  <br>
                  <a href="altaCartaPersonalizada.php?nueva=<?=base64_encode("Contactos");?>">Nueva predefinida</a> </td></tr>
              </table></div></td>
          </tr>
          <tr>
            <td align="center"><div style="border:1px solid #333; width:85%"><table width="100%" border="0" align="center" cellpadding="10" cellspacing="0" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:13px" bgcolor="#ECF4F9">
              <tr>
                <td colspan="3"><label style="cursor:pointer"><input name="A_otro" type="checkbox" id="A_otro" value="1">
                  <span>Enviar  mail de  cada trabajo seleccionado a un solo destinatario, el cual es:</span></label></td>
              </tr>
              <tr>
                <td colspan="3" style="padding-left:100px"><input name="mailAotro" type="text" id="mailAotro" style="font-size:11px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; width:300px;"></td>
                </tr>
              <tr>
                <td colspan="3"><label style="cursor:pointer"><input name="A_contacto" type="checkbox" id="A_participante" value="1">
                  <span>Enviar el mail correspondiente al contacto del trabajo  seleccionado</span></label></td>
              </tr>
              <tr>
                <td width="35%"><strong>Datos del trabajo en el mail:</strong></td>
                <td width="31%">
                  <input name="chkMostrarUbicacion" type="checkbox" id="chkMostrarUbicacion" value="1">
                  <span> Mostrar Ubicación</span></td>
                <td width="34%">                  <label style="cursor:pointer"> 
                    <input name="chkMostrarTrabajo" type="checkbox" id="chkMostrarTrabajo" value="1">
                    <span>Mostrar Trabajo </span></label></td>
              </tr>
              <tr>
                <td colspan="3"><div align="right">
                  <input type="button" name="Submit" value="Enviar mails" onClick="enviarMailsTrabajos()" style="width:150px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:13px">
                </div></td>
              </tr>


            </table>
            </div></td>
          </tr>
          <tr>
            <td width="50%" height="121" valign="top" align="center">
    <?
    if($_POST["tl"]!=""){
	
		$lista = $trabajo->seleccionar_trabajos_libres_del_filtrado($_POST["tl"], $inicio, $TAMANO_PAGINA);
		if(!$lista){
		?>
		<script language="javascript" type="text/javascript">
			document.location.href="estadoTL.php?neg=true&estado=cualquier&vacio=true";
		</script>
		<?	
		}
		$totalEncontrados = $trabajo->seleccionar_trabajos_libres_del_filtrado($_POST["tl"], $inicio, $TAMANO_PAGINA)->num_row;
		
	}else{
		$lista = $trabajo->seleccionar_trabajos_libres_que_tienen_mail_de_contacto();
		$totalEncontrados = $trabajo->seleccionar_trabajos_libres_que_tienen_mail_de_contacto()->num_row;
	}	
	?>
    
<div style="border:1px solid #333; width:85%">
    <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#E4EDE4" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:13px">
      <tr>
        <td height="25" colspan="2" valign="middle"><strong><span>Trabajos <? if($_POST["tl"]!=""){echo "<strong>(vienen del filtrado)</strong>";}?></span></strong><br>
            <span class="Estilo4">Hay [
            <?=$totalEncontrados?>
          ] trabajos  que tienen E-mail de contacto (puede que no esten ubicados todavia) </span></td>
	    </tr> 
	  <tr>
        <td height="25" colspan="2" valign="middle" bgcolor="#D0E1D1">&nbsp;<a href="#" style=" font-weight:normal; font-size:11px;" onClick="marcarTrabajos(true)">Marcar todos</a> <font size="1">/</font> <a href="#" style=" font-weight:normal; font-size:11px;" onClick="marcarTrabajos(false)">Desmarcar todos</a></td>
      </tr>
	<? 
	while ($row = $lista->fetch_object()){
		
		if ($row->Institucion!=""){
			$institucion = " - "  . $row->Institucion;
		}else{
			$institucion = "";
		}
		
		if ($row->Pais!=""){
			$pais = " ("  . $row->Pais . ")";
		}else{
			$pais = "";
		}
		
		if ($row->En_calidad!=""){
			$enCalidad = $row->En_calidad . ": ";
		}else{
			$enCalidad  = "";
		}
		if ($row->Profesion!=""){
			$profesion = "(".$row->Profesion.")";
			}else{
			$profesion = "";
		}
		
		if ($row->Curriculum!=""){
			if($_SESSION["registrado"] == true || $verCurriculums == true){
				$curriculum = "&nbsp;<a href='bajando_cv.php?id=" .  $row->Curriculum . "' target='_self'><img src='img/logo_curriculum.gif' width='15' height='17' border='0' alt='Descargar curriculum de " . $row->Nombre . " " . $row->Apellidos . "'></a>";
			}else{
				$curriculum = "";
			}
		}else{
			$curriculum = "";
		}
		
		if ($row->Mail!=""){
			$mail = "&nbsp;<a href='mailto:" . $row->Mail  . "'><img src='img/logo_mail.gif' border='0' alt='Enivar mail a esta persona'></a>";
		
			if($_SESSION["registrado"] == true || $verMails== true){
				$mail = "&nbsp;<a href='mailto:" . $row->Mail  . "'><img src='img/logo_mail.gif' border='0' alt='Enivar mail a esta persona'></a>";
			}else{
				$mail = "";
			}
		}else{
			$mail = "";
		}

	?>
	<script>CuantosT = CuantosT + 1;</script>
				  <tr>
                    <td width="21" bgcolor="#FFFFFF" ><input name="trabajo[]" type="checkbox" id="trabajo[]" value="<?=$row->id_trabajo?>"></td>
                    <td width="492" bgcolor="#FFFFFF" style="font-size:11px"><strong>
                      <?=$row->numero_tl?>
                    </strong> - <?=$row->titulo_tl?> [Contacto: <?=$row->contacto_mail?>]</td>
                </tr>
            <? 
			}
			?>
			<tr>
              <td height="25" colspan="2" valign="middle" bgcolor="#D0E1D1">&nbsp;<a href="javascript:void(0)" style=" font-weight:normal; font-size:11px;" onClick="marcarTrabajos(true)">Marcar todos</a> <font size="1">/</font> <a href="javascript:void(0)" style=" font-weight:normal; font-size:11px;" onClick="marcarTrabajos(false)">Desmarcar todos</a></td>
			  </tr>
		</table>	
		</div></td>
		  </tr>
        </table>
	  </form>
    </td>
  </tr>
</table>
