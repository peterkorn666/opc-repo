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
require "clases/class.Cartas.php";
require "clases/listadoParticipantes.php";
$persona = new listadoPersonas;
$cartas = new cartas();
?>

<script src="js/envioMail.js"></script>

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
    <td valign="top"><div align="center"><strong><font color="#666666"><br>
      Envio de e-mails </font></strong></div>
      <form action="envioMail_listadoParticipantes_send.php" method="post" enctype="multipart/form-data" name="form1">
	<iframe id="guardarInscripcion" name="guardarInscripcion" style="display:none"></iframe>

        <table width="100%" border="0" cellspacing="5" cellpadding="2">
          <tr>
            <td height="0" align="center"><div style="border:1px solid #999999; width:70%"><table width="100%" border="0" cellspacing="0" cellpadding="8">
                <tr>
                  <td bgcolor="#EAEAEA"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><strong class="textos">Asunto:</strong></td>
                    </tr>
                    <tr>
                      <td><font color="#666666"><span class="textos">
                        <input name="asunto0" type="text" id="asunto0"  style="width:100
					px; font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;;">
                         Apellido, Nombre. </span></font>
                          <input name="asunto1" type="text" id="asunto1"  style="width:250px; font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;;"></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td><strong class="textos">Adjuntar un archivo:
                        <input name="archivo" type="file" class="campos" id="archivo" />
                        </strong>
                          <input name="archivoTMP" type="hidden" id="archivoTMP"></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="textos"><strong>Carta de presentaci&oacute;n:</strong></td>
                    </tr>
                    <tr>
                    <td bgcolor="#EAEAEA" class="textos">
                  <label  for="rbCartaManual" style="cursor:pointer">
                    <input name="rbCarta" id="rbCartaManual" checked="checked" type="radio" value="Manual" />
                    <strong>Manual</strong> </label>
                     <div id="CartaManual">
					<strong>Carta de presentaci&oacute;n:</strong><br><textarea id="carta" name="carta" rows="5" style="padding:2px; width:100%"></textarea>
                    </div>                    
                    <? 
				  $listaPredefinidas = $cartas->cargarPredefinidas("Conferencistas");
				  while ($predefinida = mysql_fetch_array($listaPredefinidas)){ ?>     
                         <label  for="rbCartaPredefinida<?=$predefinida["titulo"]?>" style="cursor:pointer">             		
				  		 <input name="rbCarta" id="rbCartaPredefinida<?=$predefinida["idCarta"]?>" type="radio" value="<?=$predefinida["idCarta"]?>" <? if($_SESSION["rbCarta"]==$predefinida["idCarta"]){echo 'checked="checked"';}?>>
                         <strong><?=$predefinida["titulo"]?></strong> - <?=$predefinida["subtitulo"]?></label>
                         <br>
				  <?  }	?>
                  <br>
                  <a href="altaCartaPersonalizada.php?nueva=<?=base64_encode("Conferencistas");?>">Nueva predefinida</a>
                  <br><br>
					<strong>Actividades del participantes:</strong><br>
					<input name="incPrograma" id="incPrograma0" type="radio" value="" /> Ninguna
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="incPrograma" id="incPrograma1" type="radio" value="es" /> Espa&ntilde;ol
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="incPrograma" id="incPrograma2" type="radio" value="ing" /> Ingl&eacute;s
                  </td></tr>

                  </table></td>
                </tr>
              </table></div></td>
          </tr>
          <tr>
            <td height="0" align="center"><div style="border:1px solid #999999; width:70%">
              <table width="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="#FFFFC6">
                <tr>
                  <td class="textos">Se generara un mail personalizado por cada participante seleccionado </td>
                </tr>
                <tr bgcolor="#FFFFCC">
                  <td bgcolor="#FFFFCC"><span class="textos"><strong>Opciones de env&iacute;o</strong></span></td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFCC"><label style="cursor:pointer">
                    <input name="A_otro" type="checkbox" id="A_otro" value="1">
                    <span class="textos">Enviar  mail de  cada trabajo seleccionado a un solo destinatario,<br>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;el cual es:</span></label>
                      <span class="textos">
                      <input name="mailAotro" type="text" id="mailAotro"  style="font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;;" size="30">
                    </span></td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFCC"><label style="cursor:pointer">
                    <input name="A_contacto" type="checkbox" id="A_participante" value="1">
                    <span class="textos">Enviar el mail correspondiente al contacto del trabajo  seleccionado</span></label></td>
                </tr>
               <!-- <tr bgcolor="#FFFFCC">
                  <td><span class="textos"><strong>Datos incluidos en el mail</strong></span></td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFE6"><label style="cursor:pointer"><span class="textos"> Enviar Participaci&oacute;n <strong>Individual</strong>
                    <input name="radiobutton" type="radio" value="individual">
                    &nbsp;</span></label>
                    <label></label>
                    <label style="cursor:pointer"><span class="textos"><strong>Actividad Completa
                    <input name="radiobutton" type="radio" value="completa">
                    </strong></span></label></td>
                  </tr>-->
                <tr>
                  <td><div align="right">
                      <input type="button" name="Submit" value="Enviar mails" onClick="enviarMailsCasilleros()">
                  </div></td>
                </tr>
              </table>
            </div></td>
          </tr>
          <tr>
            <td width="50%" height="121" valign="top">

    <?
	//$lista = $persona->personasCongresoConMail();
	$lista = $persona->personasPorCasilleroConMail($_POST["ID_Casilla"]);
	?>
   <table width="70%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><div id="DivBandejaAutores" style="border:1px solid #999999;width:100%;">
		 <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1">
	  <tr>
        <td height="25" colspan="5" valign="middle"><strong><span class="textos">Participantes en el congreso</span></strong><br>
            <span class="Estilo4">Hay [<font color="#990000" ><?=$persona->canPersonas?>
            </font>] participantes que tienen E-mail <font color="#990000"> </font></span></td>
	    </tr> 
	  <tr>
        <td height="25" colspan="5" valign="middle" bgcolor="#E2E7EB">&nbsp;<a href="#" style=" font-weight:normal; font-size:11px;" onClick="marcar(true)">Marcar todos</a> <font size="1">/</font> <a href="#" style=" font-weight:normal; font-size:11px;" onClick="marcar(false)">Desmarcar todos</a> <a href="#" style=" font-weight:normal; font-size:11px;" onClick="invertir()">Invertir</a> - <a href="#" style=" font-weight:normal; font-size:11px;" onClick="allSpanish()">Espa&ntilde;ol</a> - <a href="#" style=" font-weight:normal; font-size:11px;" onClick="allEnglish()">Ingl&eacute;s</a></td>
      </tr>
	<? 
	$cuantosPe = -1;
	while ($row = mysql_fetch_object($lista)){
		
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
		
		$idiom = "";
		switch ($row->idiomaHablado) {
			case "Spanish":
				$idiom = "<img border='0' src='img/es.png' />";
				break;
			case "English":
				$idiom = "<img border='0' src='img/gb.png' />";
				break;
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
		
		$sqlCalidad = "SELECT DISTINCT En_calidad FROM congreso WHERE ID_persona='".$row->ID_Personas."'";
		$rsCalidad = mysql_query($sqlCalidad, $con);
		$calidades = "";
		while($rowCalidad = mysql_fetch_array($rsCalidad)){
			$calidades .= $rowCalidad["En_calidad"] .", ";
		}
		if ($calidades){
			$calidades = substr($calidades, 0, -2);
		}
		

	?>
	<script>CuantosP = CuantosP + 1;</script>
    <? $cuantosPe = $cuantosPe + 1; ?>
				  <tr bgcolor="#FFFFFF">                  
                  <td width="50"><input name="participante[]" type="checkbox"<? if(($row->Pais=="Uruguay")&&($row->Mail!="")){echo "checked";}else{echo "";}?> id="participante[]" value="<?=$row->ID_Personas?>">	&nbsp; <?=$idiom?>                 <input name="participante_idioma_<?=$cuantosPe?>" type="hidden" id="participante_idioma_<?=$cuantosPe?>" value="<?=$row->idiomaHablado?>">	</td>  
                  <td width="150" style="font-size:12;"><strong><?=$row->Apellidos?> , <?=$row->Nombre?></strong></td>           
                  <td width="150" style="font-size:9;"> <? echo $profesion . $pais . $curriculum . $institucion; ?></td>
                  <td width="110" style="font-size:9;"> <?=$calidades?></td>
                  <td width="50"><?=$mail?> <a href="buscar.php?id=<?=$row->ID_Personas?>" style=" font-weight:normal; font-size:11px;" target="_blank">Ver</a></td>           
                  <!--<td width="460"> <? echo "<b><font size='2'>" . $row->Apellidos . ", " . $row->Nombre . "</font></b> <font size='1'>" . $profesion . $pais . $curriculum . $institucion . "&nbsp;". $mail . "</font>"; ?> <a href="buscar.php?id=<?=$row->ID_Personas?>" style=" font-weight:normal; font-size:11px;">[Ver su participaci&oacute;n]</a></td>-->
                </tr>
            <? 
			}
			?>
			<tr>
              <td height="25" colspan="5" valign="middle" bgcolor="#E2E7EB">&nbsp;<a href="#" style=" font-weight:normal; font-size:11px;" onClick="marcar(true)">Marcar todos</a> <font size="1">/</font> <a href="#" style=" font-weight:normal; font-size:11px;" onClick="marcar(false)">Desmarcar todos</a> <a href="#" style=" font-weight:normal; font-size:11px;" onClick="invertir()">Invertir</a> - <a href="#" style=" font-weight:normal; font-size:11px;" onClick="allSpanish()">Espa&ntilde;ol</a> - <a href="#" style=" font-weight:normal; font-size:11px;" onClick="allEnglish()">Ingl&eacute;s</a></td>
			  </tr>
		</table>	
		</div></td></tr></table>
			</td>
		  </tr>
          <tr>
            <td height="0" valign="top">&nbsp;</td>
          </tr>
        </table>
	  </form>
    </td>
  </tr>
</table>
