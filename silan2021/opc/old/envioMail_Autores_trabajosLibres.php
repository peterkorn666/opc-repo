<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");
/*
if (!isset($_SESSION["registrado"])){
	$_SESSION["registrado"]=false;
}*/
$_SESSION["finalizo"]=0;
include('conexion.php');
include("inc/validarVistas.inc.php");
require "clases/trabajosLibres.php";
$trabajo = new trabajosLibre();
require "clases/listadoParticipantes.php";
require "clases/class.Cartas.php";
$persona = new listadoPersonas;
$cartas = new cartas();
?>

<script src="js/envioMail.js"></script>
<script src="js/ajax.js"></script>
<script language="javascript" type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
	// Notice: The simple theme does not use all options some of them are limited to the advanced theme
	tinyMCE.init({
		mode : "textareas",
		theme: "advanced",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_buttons1 : "bold,italic,underline,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,numlist,bullist,outdent,indent, separator, link, unlink, code",
		theme_advanced_buttons2 : "",				
		theme_advanced_buttons3 : ""


	});
</script>
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

<body background="fondo_2.jpg" leftmargin="0" topmargin="0" bgproperties="fixed" marginwidth="0" marginheight="0" >
<? include "inc/vinculos.inc.php";?>
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CCCCCC">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php"; ?></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F0E6F0" align="center"><div align="center" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:16px"><br>
     <strong> Envio de e-mails</strong><br>
     Autores y/o Co-Autores de Trabajos</div>
      <form action="envioMail_Autores_trabajosLibres_send.php" method="post" enctype="multipart/form-data" name="form1">
	<iframe id="guardarInscripcion" name="guardarInscripcion" style="display:none"></iframe>

        <table width="90%" border="0" cellspacing="5" cellpadding="2">
          <tr>
            <td height="0" align="center"><div style="width:85%; background-color:#FEFFEA; border:1px solid #333;"><table width="100%" border="0" align="center" cellpadding="10" cellspacing="0" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:13px">
                    <tr>
                      <td width="33%"><strong>Asunto:</strong> [Apellido Nombre]</td>
                      <td width="67%"><input name="asunto1" type="text" id="asunto1"  style="width:80%; font-size:11px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif"></td>
                    </tr>
                    <tr>
                      <td><strong>Adjuntar un archivo:                        </strong></td>
                      <td><strong>
                        <input name="archivo" type="file" style="width:80%; font-size:13x; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif" id="archivo" />
                      </strong>
                      <input name="archivoTMP" type="hidden" id="archivoTMP"></td>
                    </tr>
                    <tr>
                      <td colspan="2">
                      <label  for="rbCartaManual" style="cursor:pointer">
                    <input name="rbCarta" id="rbCartaManual" checked="checked" type="radio" value="Manual" />
                    <strong>Manual</strong> </label><br>
                    <strong>Carta de presentaci&oacute;n:</strong><br>
                    <div id="CartaManual">
                      <textarea id="carta" name="carta" rows="5" style="padding:2px; width:100%; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:11px"></textarea>
                     </div>
                      <? 
				  $listaPredefinidas = $cartas->cargarPredefinidas("Autores");
				  while ($predefinida = $listaPredefinidas->fetch_array()){ ?>     
                         <label  for="rbCartaPredefinida<?=$predefinida["titulo"]?>" style="cursor:pointer">             		
				  		 <input name="rbCarta" id="rbCartaPredefinida<?=$predefinida["idCarta"]?>" type="radio" value="<?=$predefinida["idCarta"]?>" <? if($_SESSION["rbCarta"]==$predefinida["idCarta"]){echo 'checked="checked"';}?>>
                         <strong><?=$predefinida["titulo"]?></strong> - <?=$predefinida["subtitulo"]?></label>
                         <br>
				  <?  }	?> 
                  <br>
                  <a href="altaCartaPersonalizada.php?nueva=<?=base64_encode("Autores");?>">Nueva predefinida</a>
                  <br><br>    
                     
                     </td>                                     
                    </tr>
              </table></div></td>
          </tr>
          <tr>
            <td height="0" align="center"><div style="border:1px solid #333; width:85%"><table width="100%" border="0" align="center" cellpadding="10" cellspacing="0" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:13px" bgcolor="#ECF4F9">
                   <tr>
                <td colspan="2"><label style="cursor:pointer"><input name="A_otro" type="checkbox" id="A_otro" value="1">
                  <span>Enviar  mail de  cada trabajo seleccionado otros destinatarios (utilize ; para separarlos):</span></label></td>
              </tr>
                  <tr>
                     <td width="6%">&nbsp;</td>
                     <td width="94%" style="padding:0px"><input name="mailAotro" type="text" id="mailAotro"  style="font-size:11px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; width:300px;"></td>
                  </tr>
                  <tr>
                <td colspan="2"><label style="cursor:pointer"><input name="A_contacto" type="checkbox" id="A_participante" value="1">
                  <span>Enviar el mail correspondiente a los autores/coautores seleccionados en el listado</span></label></td>
              </tr>
              <tr>
                <td colspan="2"><div align="right">
                  <input type="button" name="Submit" value="Enviar mails" onClick="enviarMailsAutores()" style="width:150px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:13px">
                </div></td>
              </tr>


            </table></div></td>
          </tr>
          <tr>
            <td width="50%" height="121" valign="top" align="center">
    <?
    ///$lista = $trabajo->seleccionar_tl_que_tienen_mail_de_contacto_son_oral_sin_archivoCompleto()
 	//$lista = $trabajo->seleccionar_tl_que_tienen_mail_de_contacto_son_posters_sin_archivoCompleto()
	//$lista = $trabajo->seleccionar_trabajos_libres_que_tienen_mail_de_contacto();
	$lista = $trabajo->seleccionar_Autores_trabajos_libres_que_tienen_mail_de_contacto();
	//$lista = $trabajo->seleccionar_trabajos_libres_sin_inscriptos();
	
	/*while ($row = mysql_fetch_object($lista)){
		$mail = "";
			 $sql2 ="SELECT ID_participante, lee FROM trabajos_libres_participantes WHERE ID_trabajos_libres = " . $row->ID ." ORDER BY ID ASC;";
		  	 $rs2 = mysql_query($sql2, $con);
		 	 while ($row2 = mysql_fetch_array($rs2)){
	
			$sql3 ="SELECT * FROM personas_trabajos_libres WHERE ID_Personas =" . $row2["ID_participante"] . ";";
			$rs3 = mysql_query($sql3, $con);			
			while ($row3 = mysql_fetch_array($rs3)){
			
			
				if ($row3["Mail"]!=""){
					$mail = "&nbsp;<a href='mailto:" . $row3["Mail"]  . "'><img src='img/logo_mail.gif' border='0' alt='Enivar mail a esta persona'></a>";
				
					if($_SESSION["registrado"] == true || $verMails== true){
						$mail = "&nbsp;<a href='mailto:" . $row3["Mail"]  . "'><img src='img/logo_mail.gif' border='0' alt='Enivar mail a esta persona'></a>";
					}else{
						$mail = "";
					}
				}else{
					$mail = "";
				}
				
			if($row3["Mail"] != ""){
			
			array_push($arrayPersonas, array($row3["Apellidos"], $row3["Nombre"], $mail, $row3["ID_Personas"], $row->numero_tl ));
			
			sort($arrayPersonas);
			
			}
		}
	}
}
*/
$arrayPersonasParaTotal = array();
$sql = "SELECT * FROM personas_trabajos_libres WHERE Mail <> '' ORDER BY Apellidos, Mail ASC";
$rs = $con->query($sql);
while($row = $rs->fetch_array()){
	$sql2 = "SELECT * FROM trabajos_libres_participantes WHERE ID_participante = " . $row["ID_Personas"] . ";";
	$rs2 = $con->query($sql2);
	while($row2 = $rs2->fetch_array()){
		if(($apellidoAnt != $row["Apellidos"])&&($mailAnt != $row["Mail"])){
			array_push($arrayPersonasParaTotal, array($row["Apellidos"], $row["Nombre"]));		
			$apellidoAnt = $row["Apellidos"];
			$mailAnt = $row["Mail"];
		}
	}
}
$cantidadTotal = count($arrayPersonasParaTotal);
$pagina = $_GET["inicio"];
$TAMANO_PAGINA = 400; 

if (!$pagina) { 
////LE PUSE UNO SINO NO JUEGA
////CAMBIAR EN EL TRABAJOSLIBRES.PHP
    $inicio = 1; 
    $pagina=1; 
} 
else { 
    $inicio = ($pagina - 1) * $TAMANO_PAGINA; 
	if($inicio==0){$inicio=1;}
} 

$cuantasPag = $cantidadTotal / 200;



$arrayPersonas = array();
$sql = "SELECT * FROM personas_trabajos_libres WHERE Mail <> '' ORDER BY Apellidos, Mail ASC LIMIT ". $inicio ." , " . $TAMANO_PAGINA;
$rs = $con->query($sql);
while($row = $rs->fetch_array()){
	$sql2 = "SELECT * FROM trabajos_libres_participantes WHERE ID_participante = " . $row["ID_Personas"] . ";";
	$rs2 = $con->query($sql2);
	while($row2 = $rs2->fetch_array()){
		//if(($apellidoAnt != $row["Apellidos"])&&($mailAnt != $row["Mail"])){
			array_push($arrayPersonas, array($row["Apellidos"], $row["Nombre"], $row["Mail"], $row["Pais"], $row["ID_Personas"], $row2["ID"]));		
			$apellidoAnt = $row["Apellidos"];
			$mailAnt = $row["Mail"];
		//}
	}
}

?>
<div id="DivBandejaAutores" style="border:1px solid #333; width:85%">
          <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#E4EDE4" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:13px">
            <tr>
              <td height="25" colspan="2" valign="middle"><strong><span>Autores y/o Co-Autores de Trabajos</span></strong><br />
                  <span class="Estilo4">Mostrando [ <strong><? echo count($arrayPersonas)?></strong> ] de [
                    <?=$cantidadTotal?>
                    ] Autores y/o Co-Autores de trabajos  que tienen E-mail de contacto.</span></td>
            </tr>
            <tr>
              <td height="25" colspan="2" valign="middle" bgcolor="#D0E1D1"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>&nbsp;<a href="javascript:void(0)" style=" font-weight:normal; font-size:11px;" onClick="marcarAutor(true)">Marcar todos</a> <font size="1">/</font> <a href="javascript:void(0)" style=" font-weight:normal; font-size:11px;" onClick="marcarAutor(false)">Desmarcar todos</a></td>
                    </tr>
              </table></td>
            </tr>
            <? 

foreach ($arrayPersonas as $i){
	?>
            <script>CuantosA = CuantosA + 1;</script>
            <tr style="font-size:11px" >
              <td width="21" bgcolor="#FFFFFF" ><input name="autor[]" type="checkbox" id="autor[]" value="<?=$i[4]?>" /></td>
              <td width="492" bgcolor="#FFFFFF"  ><span> <? echo "<strong>".$i[0] ." ". $i[1] . "</strong> <em>(" .$trabajo->getPaisID($i[3]). ")</em> ". "&nbsp;<a style=' font-weight:normal; font-size:11px;' href='mailto:" . $i[2]  . "'>[".$i[2]."]</a>"?> </span></td>
            </tr>
            <? 
			}
			?>
            <tr>
              <td height="25" colspan="2" valign="middle" bgcolor="#D0E1D1">&nbsp;<a href="javascript:void(0)" style=" font-weight:normal; font-size:11px;" onClick="marcarAutor(true)">Marcar todos</a> <font size="1">/</font> <a href="javascript:void(0)" style=" font-weight:normal; font-size:11px;" onClick="marcarAutor(false)">Desmarcar todos</a></td>
            </tr>
          </table>
        </div></td>
      </tr>
    </table></div>
	  </form>
    </td>
  </tr>
</table>
