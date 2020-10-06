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
require "clases/listadoParticipantes.php";
$persona = new listadoPersonas;
?>

<script src="js/envioMail.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
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
.Estilo5 {color: #990000}
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
      <form action="envioMail_listadoInscriptos_send.php" method="post" enctype="multipart/form-data" name="form1">
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
                        Dr. Apellido, Nombre. </span></font>
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
                      <td><textarea id="carta" name="carta" rows="5" style="padding:2px; width:100%"></textarea></td>
                    </tr>
                  </table></td>
                </tr>
              </table></div></td>
          </tr>
          <tr>
            <td height="0" align="center"><div style="border:1px solid #999999; width:70%"><table width="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="#FFFF99">
              <tr>
                <td class="textos">Se generaran diferentes mails, por cada marca de  participante.</td>
              </tr>
              <tr>
                <td><label style="cursor:pointer"><input name="A_otro" type="checkbox" id="A_otro" value="1">
                  <span class="textos">Enviar todos los mail de  cada participante seleccionado a un solo destinatario,<br>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;el cual es:</span></label> <span class="textos">
                  <input name="mailAotro" type="text" id="mailAotro"  style="font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif;;" size="30">
                  </span></td>
              </tr>
              <tr>
                <td><label style="cursor:pointer"><input name="A_participante" type="checkbox" id="A_participante" value="1">
                  <span class="textos">Enviar un mail correspondiente a cada participante seleccionado </span></label></td>
              </tr>
              <tr>
                <td><div align="right">
                  <input type="button" name="Submit" value="Enviar mails" onClick="enviarMails()">
                </div></td>
              </tr>


            </table></div></td>
          </tr>
          <tr>
            <td width="50%" height="121" valign="top">

    <?
	$lista = $persona->personasInscriptasConMail();
	?>
   <table width="70%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><div id="DivBandejaAutores" style="border:1px solid #999999;width:100%;">
		 <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1">
	  <tr>
        <td height="25" colspan="2" valign="middle"><strong><span class="textos">Inscriptos en el congreso</span></strong><br>
            <span class="Estilo4">Hay [<font color="#990000" ><?=$persona->canPersonas?></font>] participantes que tienen E-mail <font color="#990000"> </font></span></td>
	    </tr> 
	  <tr>
        <td height="25" colspan="2" valign="middle" bgcolor="#E2E7EB">&nbsp;<a href="#" style=" font-weight:normal; font-size:11px;" onClick="marcar(true)">Marcar todos</a> <font size="1">/</font> <a href="#" style=" font-weight:normal; font-size:11px;" onClick="marcar(false)">Desmarcar todos</a></td>
      </tr>
	<? 
	while ($row = mysql_fetch_object($lista)){
		
		if ($row->institucion!=""){
			$institucion = " - "  . $row->institucion;
		}else{
			$institucion = "";
		}
		
		if ($row->pais!=""){
			$pais = " ("  . $row->pais . ")";
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
				$curriculum = "&nbsp;<a href='bajando_cv.php?id=" .  $row->Curriculum . "' target='_self'><img src='img/logo_curriculum.gif' width='15' height='17' border='0' alt='Descargar curriculum de " . $row->nombre . " " . $row->apellido . "'></a>";
			}else{
				$curriculum = "";
			}
		}else{
			$curriculum = "";
		}
		
		if ($row->mail!=""){
			$mail = "&nbsp;<a href='mailto:" . $row->mail  . "'><img src='img/logo_mail.gif' border='0' alt='Enivar mail a esta persona'></a>";
		
			if($_SESSION["registrado"] == true || $verMails== true){
				$mail = "&nbsp;<a href='mailto:" . $row->mail  . "'><img src='img/logo_mail.gif' border='0' alt='Enivar mail a esta persona'></a>";
			}else{
				$mail = "";
			}
		}else{
			$mail = "";
		}

	?>
	<script>CuantosP = CuantosP + 1;</script>
				  <tr>
                  <td width="21" bgcolor="#FFFFFF" >
				  <input name="participante[]" type="checkbox" id="participante[]" value="<?=$row->id?>">				  </td>
                  <td width="492" bgcolor="#FFFFFF"> <? echo "<b><font size='2'>" . $row->apellido . ", " . $row->nombre . "</font></b> <font size='1'>" . $profesion . $institucion . $pais . $curriculum . $mail . "</font>"; ?> </td>
                </tr>
            <? 
			}
			?>
			<tr>
              <td height="25" colspan="2" valign="middle" bgcolor="#E2E7EB">&nbsp;<a href="#" style=" font-weight:normal; font-size:11px;" onClick="marcar(true)">Marcar todos</a> <font size="1">/</font> <a href="#" style=" font-weight:normal; font-size:11px;" onClick="marcar(false)">Desmarcar todos</a></td>
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
