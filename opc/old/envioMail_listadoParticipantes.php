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
require "clases/class.Cartas.php";
$persona = new listadoPersonas;
$cartas = new cartas();
?>
<script src="js/jquery-1.11.1.min.js"></script>
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
.paginas {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: bold;
	color: #000000;
	border: 1px solid #000000;
	background-color:#F3F5F8;
	text-align: center;
	text-decoration: none;
}
.paginasSel {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: bold;
	color: #000000;
	border: 2px solid #003300;
	background-color:#00CCFF;
	text-align: center;
	text-decoration: none;
}
.paginas:hover {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: bold;
	color: #ffffff;
	border: 1px solid #000000;
	background-color:#003366;
	text-align: center;
	text-decoration: none;
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
    <td valign="top" align="center" bgcolor="#F0E6F0"><div align="center" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:16px"><strong><br>
      Envio de e-mails</strong><br>
      Participantes
    </div>
      <form action="envioMail_listadoParticipantes_send.php" method="post" enctype="multipart/form-data" name="form1">
	<iframe id="guardarInscripcion" name="guardarInscripcion" style="display:none"></iframe>
 <table width="90%" border="0" cellspacing="5" cellpadding="2">
          <tr>
            <td align="center"><div align="center" style="width:85%; background-color:#FEFFEA; border:1px solid #333;"><table width="100%" border="0" align="center" cellpadding="10" cellspacing="0" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:13px">
                <tr>
                  <td width="12%"><strong>Asunto:</strong></td>
                  <td width="88%"><input name="asunto0" type="text" id="asunto0"  style="width:25%; font-size:11px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif">
Dr. Apellido, Nombre.
  <input name="asunto1" type="text" id="asunto1"  style="width:25%; font-size:11px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif"></td>
                </tr>
			    <tr>
			      <td colspan="2"><strong>Adjuntar un archivo:
			        
			        </strong>
			        <input name="archivoTMP" type="hidden" id="archivoTMP"></td>
			      </tr>
	            <tr>
	              <td colspan="2">
	                <label  for="rbCartaManual" style="cursor:pointer">
	                  <input name="rbCarta" id="rbCartaManual" checked="checked" type="radio" value="Manual" onClick="document.getElementById('incPrograma0').disabled=false; document.getElementById('incPrograma1').disabled=false;"/>
	                  <strong>Carta Manual</strong> </label><br>
	                  <textarea id="carta" name="carta" rows="5" style="padding:2px; width:100%; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:11px"></textarea>
	                  <strong>
	                  <input name="archivo" type="file" class="campos" id="archivo"  style="width:50%; font-size:13x; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif"/>
	                  </strong><br>
 <? $listaPredefinidas = $cartas->cargarPredefinidas("Conferencistas");
 					/* $predefinida = mysql_fetch_array($listaPredefinidas) */
				  while ($predefinida = $listaPredefinidas->fetch_array()){ ?>     
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
	                </td>
	              </tr>
            </table></div></td>
          </tr>
          <tr>
           <td align="center"><div style="border:1px solid #333; width:85%"><table width="100%" border="0" align="center" cellpadding="10" cellspacing="0" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:13px" bgcolor="#ECF4F9">
           <tr>
                <td><label style="cursor:pointer"><input name="A_otro" type="checkbox" id="A_otro" value="1">Enviar todos los mail de  cada participante seleccionado a un solo destinatario, el cual es:</label></td>
              </tr>
              <tr>
                <td style="padding-left:100px"><input name="mailAotro" type="text" id="mailAotro" style="font-size:11px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; width:300px;"></td>
              </tr>
              <tr>
                <td><label style="cursor:pointer"><input name="A_participante" type="checkbox" id="A_participante" value="1">
                  <span>Enviar un mail correspondiente a cada participante seleccionado </span></label></td>
              </tr>
              <tr>
                <td><div align="right">
                  <input type="button" name="Submit" value="Enviar mails" onClick="enviarMails()" style="width:150px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:13px">
                </div></td>
              </tr>


            </table></div></td>
          </tr>
          <tr>
            <td width="50%" height="121" valign="top" align="center">

    <?
	//agregado
	$cuantosPe = -1;
	$pagina = $_GET["inicio"];
	$TAMANO_PAGINA = 300; 
	
	if (!$pagina) { 
		$inicio = 1; 
		$pagina=1; 
	} 
	else { 
		$inicio = ($pagina - 1) * $TAMANO_PAGINA; 
		if($inicio==0){$inicio=1;}
	} 
		//echo $inicio . " - ". $TAMANO_PAGINA . "<br>";

	//agregado
	$lista = $persona->personasCongresoConMail($inicio, $TAMANO_PAGINA);
	$cantidadTotal = $persona->canPersonasTOTAL;
	$cuantasPag = $cantidadTotal / $TAMANO_PAGINA;
	?>
<div id="DivBandejaAutores" style="border:1px solid #333; width:85%">
    <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#E4EDE4" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:13px">
	  <tr>
        <td height="25" colspan="6" valign="middle"><strong><span>Participantes en el congreso </span></strong><br>
            <span class="Estilo4">Hay [<font color="#990000" ><?=$persona->canPersonasTOTAL?>
            </font>] participantes que tienen E-mail <font color="#990000"> </font></span></td>
	    </tr> 
        <tr>
                      <td height="25" colspan="6" valign="middle" bgcolor="#D0E1D1"><div align="center" style="margin-top:2px">
                        <?
              for($i=1;$i<=($cuantasPag+1);$i++){
              if($i!=$pagina){
				  ?>
                        &nbsp;<a href="envioMail_listadoParticipantes.php?inicio=<?=$i?>" target="_self" class="paginas">&nbsp;
                          <?=$i?>
                          &nbsp;</a>
                        <?
               }else{
                 echo "&nbsp;<span class='paginasSel'>&nbsp;". $i . "&nbsp;</span>";			  
                }
              }
              ?>
                      </div></td>
                    </tr>
	  <tr>
        <td height="25" colspan="6" valign="middle" bgcolor="#D0E1D1" style=" font-weight:normal; font-size:11px;">&nbsp;<a href="#" style=" font-weight:normal; font-size:11px;" onClick="marcar(true)">Marcar todos</a> <font size="1">/</font> <a href="#" style=" font-weight:normal; font-size:11px;" onClick="marcar(false)">Desmarcar todos</a> <font size="1">/</font> <a href="#" style=" font-weight:normal; font-size:11px;" onClick="invertir()">Invertir</a> - <a href="#" style=" font-weight:normal; font-size:11px;" onClick="allSpanish()">Espa&ntilde;ol</a> - <a href="#" style=" font-weight:normal; font-size:11px;" onClick="allEnglish()">Ingl&eacute;s</a> - Rol: 
<?
//$sql = "SELECT DISTINCT En_calidad FROM congreso ORDER BY En_calidad ASC;";
//$rs = mysql_query($sql, $con);
$sql = "SELECT calidad FROM calidades_conferencistas ORDER BY calidad ASC";
$rs = $con->query($sql);
?>
<select name="EnCalidad" style="width:100px; font-family:Arial, Helvetica, sans-serif; font-size:9px" onChange="segunRol()">
<option value="">Seleccione</option>
<!-- $row = mysql_fetch_array($rs) -->
<? 
if ($rs){
while($row = $rs->fetch_array()){
	?>
<option value="<?=$row[0]?>"><?=$row[0]?></option>
<? }
}?>
</select></td>
      </tr>
      <tr>
      	<td colspan="6">
        	<input type="checkbox" name="filtro_coordinador" value="1"> Solo coordinadores
        </td>
      </tr>
	<? 
	/* $row = mysql_fetch_object($lista) */
	/*var_dump('Lista: ' . $lista->fetch_object());
	die();*/
	while ($row = $lista->fetch_object()){
		if ($row->institucion!=""){
			$institucion = " - "  . $row->institucion;
		}else{
			$institucion = "";
		}
	
		if ($row->pais!=""){
			$sqlPais = $con->query("SELECT Pais FROM paises WHERE ID_Paises=".$row->pais);
			if(count($sqlPais) > 0){
				$rsPais = $sqlPais->fetch_array();
				$pais = " ("  . $rsPais[0] . ")";
			}
		}else{
			$pais = "";
		}
		
		$es_coordinador = 0;
		if ($row->en_calidad!=""){
			$sqlRol = $con->query("SELECT calidad, coordinador FROM calidades_conferencistas WHERE ID_calidad=".$row->en_calidad);
			if(count($sqlRol) > 0){
				$rsRol = $sqlRol->fetch_array();
				$enCalidad = $rsRol["calidad"];
				if($rsRol["coordinador"] == 1){
					$es_coordinador = 1;
				}
			}
			//$enCalidad = $row->En_calidad . ": ";
		}else{
			$enCalidad  = "";
		}
		
		if ($row->profesion!=""){
			$profesion = "(".$row->profesion.")";
			}else{
			$profesion = "";
		}
		
		if ($row->cv_!=""){
			if($_SESSION["registrado"] == true || $verCurriculums == true){
				$curriculum = "&nbsp;<a href='bajando_cv.php?id=" .  $row->cv_ . "' target='_self'><img src='img/logo_curriculum.gif' width='15' height='17' border='0' alt='Descargar curriculum de " . $row->nombre . " " . $row->apellido . "'></a>";
			}else{
				$curriculum = "";
			}
		}else{
			$curriculum = "";
		}
		
		$idiom = "";
		switch ($row->actividad_idioma_hablado) {
			case "Espanol":
				$idiom = "<img border='0' src='img/es.png' />";
				break;
			case "Ingles":
				$idiom = "<img border='0' src='img/gb.png' />";
				break;
		}
		
		
		if ($row->email!=""){
			$mail = "&nbsp;<a href='mailto:" . $row->email  . "'><img src='img/logo_mail.gif' border='0' alt='Enivar mail a esta persona'></a>";
		
			if($_SESSION["registrado"] == true || $verMails== true){
				$mail = "&nbsp;<a href='mailto:" . $row->email  . "'><img src='img/logo_mail.gif' border='0' alt='Enivar mail a esta persona'></a>";
			}else{
				$mail = "";
			}
		}else{
			$mail = "";
		}

	?>
	<script>CuantosP = CuantosP + 1;</script>
    <? $cuantosPe = $cuantosPe + 1; ?>
				  <!--<tr>
                  <td width="50" bgcolor="#FFFFFF" >
				  <input name="participante[]" type="checkbox"<? if(($row->Pais=="Uruguay")&&($row->Mail!="")){echo "checked";}else{echo "";}?> id="participante[]" value="<?=$row->ID_Personas?>">	&nbsp; <?=$idiom?>
                  </td>
                  <td width="460" bgcolor="#FFFFFF"> <? echo "<b><font size='2'>" . $row->Apellidos . ", " . $row->Nombre . "</font></b> <font size='1'>" . $profesion .  $pais . $institucion . "&nbsp;". $curriculum  .$mail . "</font>"; ?> <a href="buscar.php?id=<?=$row->ID_Personas?>" style=" font-weight:normal; font-size:11px;">[Ver su participaci&oacute;n]</a></td>
                </tr>-->
                <tr bgcolor="#FFFFFF">                  
                  <td width="50"><input name="participante[]" type="checkbox" id="participante[]" value="<?=$row->id_conf?>" class="<?=$row->actividad_idioma_hablado?>" data-coordinador="<?=$es_coordinador?>">	&nbsp; <?=$idiom?>                 <input name="participante_idioma_<?=$cuantosPe?>" type="hidden" id="participante_idioma_<?=$cuantosPe?>" value="<?=$row->actividad_idioma_hablado?>">
<input name="participante_rol_<?=$cuantosPe?>" type="hidden" id="participante_rol_<?=$cuantosPe?>" value="<?=$enCalidad?>">
                  
                  	</td>  
                  <td width="150" style="font-size:12;"><strong><?=$row->apellido?> , <?=$row->nombre?></strong></td>
                  <td width="150" style="font-size:9;"><?=$row->email?></td>           
                  <td width="150" style="font-size:9;"> <? echo $profesion." ".$pais; ?></td><!-- $curriculum . $institucion -->
                  <td width="110" style="font-size:9;"> <?=$enCalidad?></td>
                  <td width="50"><?=$mail?> <!--<a href="buscar.php?id=<?=$row->id_conf?>" style=" font-weight:normal; font-size:11px;" target="_blank">Ver</a>--></td>
                  <!--<td width="460"> <? echo "<b><font size='2'>" . $row->apellido . ", " . $row->nombre . "</font></b> <font size='1'>" . $profesion . $pais . $curriculum . $institucion . "&nbsp;". $mail . "</font>"; ?> <a href="buscar.php?id=<?=$row->ID_Personas?>" style=" font-weight:normal; font-size:11px;">[Ver su participaci&oacute;n]</a></td>-->
                </tr>
            <? 
			}
			?>
			<tr>
              <td height="25" colspan="6" valign="middle" bgcolor="#D0E1D1">&nbsp;<a href="#" style=" font-weight:normal; font-size:11px;" onClick="marcar(true)">Marcar todos</a> <font size="1">/</font> <a href="#" style=" font-weight:normal; font-size:11px;" onClick="marcar(false)">Desmarcar todos</a> <font size="1">/</font> <a href="#" style=" font-weight:normal; font-size:11px;" onClick="invertir(true)">Invertir</a>- <a href="#" style=" font-weight:normal; font-size:11px;" onClick="allSpanish()">Espa&ntilde;ol</a> - <a href="#" style=" font-weight:normal; font-size:11px;" onClick="allEnglish()">Ingl&eacute;s</a></td>
			  </tr>
		</table>	
		</div></td></tr></table>
	  </form>
    </td>
  </tr>
</table>
