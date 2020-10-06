<?php
session_start();
if($_SESSION["Login"]==""){
	header("Location: login.php");
	die();
}

if($_SESSION["ID_TL"]==""){
	header("Location: personal.php");
	die();
}

header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");
require("../envioMail_Config.php");
if($leerRegl == true){
	if(($_SESSION["chkAcepto"]=="")||($_SESSION["chkAcepto"]=="1")){ 
		$btnHabilitado =  "disabled='disabled'"; 
	}
}					  
					  
if (!isset($_SESSION["registrado"])){
	$_SESSION["registrado"]=false;
}
include "../conexion.php";
require "clases/class.autores.php";
require ("../clases/trabajosLibres.php");
include dirname(__FILE__).'/replacePngTags.php';
echo '<?xml version="1.0" encoding="UTF-8"?>';
$trabajos = new trabajosLibre;
$autoresObj = new autores();

if ($_SESSION["Login"] != "Logueado") {
	header("Location:login.php");
	die();
}

$TL_rs = $trabajos->selectTL_ID($_SESSION["ID_TL"]);
while ($row = $TL_rs->fetch_object()){
	$imagen_ing = trim($row->tabla_trabajo_comleto_ing);
}
$sqlParaPalabrasClave = $trabajos->selectTL_ID($_SESSION["ID_TL"]);
while ($rowParaPalabrasClave = $sqlParaPalabrasClave->fetch_array()){
	$palabrasClave = $rowParaPalabrasClave["palabrasClave"];
}
	$dirArchivo = $_SESSION["archivo_tl"];
	$archivo_tl = $_SESSION["archivo_tl"];
	$resumen_amp = $_SESSION["archivo_tl_ampliado"];
	$dirArchivoConcurso = $_SESSION["dirArchivo"];
	$emailContacto = $_SESSION["emailContacto"];
	$emailContacto2 = $_SESSION["emailContacto2"];
	$ApellidoContacto = $_SESSION["ApellidoContacto"];
	$NombreContacto = $_SESSION["NombreContacto"];
	$InstContacto = $_SESSION["InstContacto"];
	$paisContacto = $_SESSION["paisContacto"];
	$ciudadContacto = $_SESSION["ciudadContacto"];
	$telContacto = $_SESSION["telContacto"];
	$agraContacto = $_SESSION["agraContacto"];	
	$numero = $_SESSION["numero"];
	$titulo = trim($_SESSION["titulo"]);
	$titulo_residente = trim($_SESSION["titulo_residente"]);
	$objetivos = $_SESSION["objetivos"];
	$desarrollo = $_SESSION["desarrollo"];
	$conclusiones = $_SESSION["conclusiones"];
	$bibliografia = $_SESSION["bibliografia"];
	$resumen = $_SESSION["resumen"];
	$resumen2 = $_SESSION["resumen2"];
	$resumen3 = $_SESSION["resumen3"];
	$resumen4 = $_SESSION["resumen4"];
	$resumen5 = $_SESSION["resumen5"];
	$resumen6 = $_SESSION["resumen6"];
	$resumen7 = $_SESSION["resumen7"];
	$resumen_en = $_SESSION["resumen_en"];
	$premio = $_SESSION["premio"];
	
	$resumen_residente = $_SESSION["resumen_residente"];
	$resumenIng = $_SESSION["resumenIng"];	
	$area = $_SESSION["area_tl"];
	$subarea = $_SESSION["subtema"];
	$tipo_tl = trim($_SESSION["tipoTL"]);
	$tipo_trabajo = trim($_SESSION["tipo_trabajo"]);
	$categoria = trim($_SESSION["categoria"]);
	$idioma = $_SESSION["idiomaTL"];
	
	
	
$sql ="SELECT * FROM evaluaciones WHERE idEvaluador = '".$_SESSION["idEvaluador"]."' AND numero_tl ='".$numero."';";
$rs = $con->query($sql);
while($row = $rs->fetch_array()){
	$opcion = $row["opcion"];
	//$evaluar_trabajo = $row["evaluar_trabajo"];
	$acepto_trabajo = $row["evaluar_trabajo"];
	$nota1 = $row["nota1"];
	$nota2 = $row["nota2"];
	$nota3 = $row["nota3"];
	$nota4 = $row["nota4"];
	$nota5 = $row["nota5"];
	$nota6 = $row["nota6"];
	$nota7 = $row["nota7"];
	$nota8 = $row["nota8"];
	$nota9 = $row["nota9"];
	$ev_global = $row["ev_global"];
	$estado = $row["estadoEvaluacion"];
	$tipo = $row["tipo"];
	$comentarios = $row["comentarios"];
	$comentarios_nota1 = $row["comentarios_nota1"];
	$comentarios_nota2 = $row["comentarios_nota2"];
	$comentarios_nota3 = $row["comentarios_nota3"];
	$comentarios_nota4 = $row["comentarios_nota4"];
	$comentarios_nota5 = $row["comentarios_nota5"];
	$comentarios_nota6 = $row["comentarios_nota6"];
	$comentarios_nota7 = $row["comentarios_nota7"];
}

	
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
<title><?=utf8_encode($congreso)?> - Abstract Evaluate</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<script src="js/autores.js"></script>
<!--<script language="javascript" type="text/javascript" src="js/jquery.js"></script>-->
<script language="javascript" type="text/javascript" src="../../js/jquery-1.12.4.js"></script>
<script language="javascript" type="text/javascript" src="js/funciones.js"></script>
</head>

<body>
<center>
<form action="enviarEvaluacion.php" method="post" name="form0" id="form0" onSubmit="return validarEvaluacion()">
<!--$rutaBanner-->
  <table width="580px" cellspacing="5" cellpadding="1" border="0">
  	<tr>
  		<td><img src="../../imagenes/banner.jpg" style="width:580px"></td>
        <td>
        <div class="col-xs-12" style="margin-top:20px;padding: 0px">
        	<div class="col-xs-4" style="padding-right: 0px; width:274px" align="center">
            	<span style="font-size:14px"> Responsable de la Evaluaci&oacute;n: <br><strong><?=$_SESSION["nombreEvaluador"]?></strong></span><br>
            </div>
            <br>
        	<!--<div class="col-xs-4" style="padding-right: 0px; width:274px" align="center">
        		 <input name="aceptar" type="button" class="botones" value="Volver" style="width:80%; font-size:10px; font-weight:bold; " onClick="document.location.href='personal.php';"/>
        	</div>-->
            
        </div>
        </td>
    </tr>
  </table>
  <!--<a href="docs/Evaluadores.pdf" style="font-size:13px; color:blue;" target="blank">Descargar: Propuesta de mecanismo de evaluación de los trabajos científicos presentados.</a>-->
  <br>
  <table width="850" align="center" cellpadding="5px" cellspacing="0" style="border:2px; border-color:#333; border-style:solid; margin-top:2px;">
            <tr>
              <td width="33%" align="center" valign="top" bgcolor="#F4F4F4">
              
                <table width="95%" border="0" cellpadding="3" cellspacing="0" style="font-size:11px;">
                    <tr>
                        <td><? if($numero!=""){echo "<strong><span class='textos' style='font-size:11px'>N&deg; de trabajo:</strong> " . $numero . "</span>";}?>&nbsp;</td>
                    </tr>
                </table>
                
                <table width="95%" border="0" cellpadding="3" cellspacing="0" style="font-size:11px;">
                      <tr>
                        <td><strong>Área:</strong> <?=$trabajos->areaID($area)->Area_es?></td>
                      </tr>
                </table>
                
                <table width="95%" border="0" cellpadding="3" cellspacing="0" style="font-size:11px;">
                      <tr>
                        <td><strong>Modalidad:</strong> <?=$trabajos->getModalidadID($tipo_tl)["tipoTL_es"]?></td>
                      </tr>
                </table>
                
                <table width="95%" border="0" cellpadding="3" cellspacing="0" style="font-size:11px;">
                      <tr>
                        <td><strong>¿Postula a premio?</strong> <?=$premio?></td>
                      </tr>
                </table>
                
                <table width="95%" border="0" cellpadding="3" cellspacing="0" style="font-size:11px; display:none;">
                    <tr>
                        <td><strong>Idioma:</strong> <?=$trabajos->getIdiomaID($idioma)["idioma"]?></td>
                    </tr>
                </table>
                
                <table width="95%" border="0" cellpadding="3" cellspacing="0" style="font-size:11px;">
                    <tr>
                        <!--<td><strong>Confirmo que no soy autor de este trabajo</strong> <input type="checkbox" id="acepto_trabajo" name="acepto_trabajo" style="width:90%" value="Si" <?php if($acepto_trabajo=="Si") {echo "checked";} ?>></td>-->
                        <td><strong>¿Soy autor de este trabajo?</strong></td>
                    </tr>
                    <tr>
                    	<td> <input type="radio" name="acepto_trabajo" value="Si" <?php if($acepto_trabajo=="Si") {echo "checked";} ?>> Si &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="acepto_trabajo" value="No" <?php if($acepto_trabajo!="Si") {echo "checked";} ?>> No</td>
                    </tr>
                </table><br>
                
                <table width="95%" border="0" cellpadding="3" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; border:1px #333 solid;" bgcolor="#FFFFFF" id="tabla_estado">
                      <tr>
                        <td colspan="2" align="center" bgcolor="#028DC8" style="color:#FFFFFF"><strong>Recomendación</strong></td>
                      </tr>
                      <tr>
                        <td align="center" bgcolor="#FFFFFF" class="texto" width="50%"><input type="radio" name="estado" value="Aceptado" <? if($estado=="Aceptado"){echo "checked";} ?>>
                          Aceptado</td>
                      </tr>
                      <tr>
                        <td align="center" bgcolor="#FFFFFF" class="texto" width="50%"><input type="radio" name="estado" value="Aceptado con modificaciones" <? if($estado=="Aceptado con modificaciones"){echo "checked";} ?>>
                          Aceptado con modificaciones</td>
                      </tr>
                      <tr>
                        <td align="center" bgcolor="#FFFFFF" class="texto">&nbsp;&nbsp;
                          <input type="radio" name="estado" value="No aceptado" <? if($estado=="No aceptado"){echo "checked";} ?>>
                          No aceptado</td>
                      </tr>
                      <!--<tr>
                        <td colspan="2" align="center" bgcolor="#FFFFFF" class="texto"><input name="aceptar4" type="submit" class="botones" value="Guardar" style="width:95%; font-size:13px; font-weight:bold;" /></td>
                      </tr>-->
                </table>
                
                
                <!--<span style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:16px"><strong><br></strong></span>-->
                
                    <table width="95%" border="0" cellpadding="3" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; border:1px #333 solid; display:none" bgcolor="#FFFFFF">
                      <tr>
                        <td align="center" bgcolor="#028DC8" style="color:#FFFFFF"><strong>¿Usted acepta evaluar este trabajo?</strong></td>
                      </tr>
                      <tr>
                        <td align="center" bgcolor="#FFFFFF" class="texto"><select name="evaluar_trabajo" style="width:90%">
                          <option value=""></option>
                          <option value="Si" <? if($evaluar_trabajo=="Si"){echo "selected";} ?>>Si</option>
                          <option value="No" <? if($evaluar_trabajo=="No"){echo "selected";} ?>>No</option>
                        </select></td>
                      </tr>
                    </table>
                    <br>
                    <table width="95%" border="0" cellpadding="3" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; border:1px #333 solid;" bgcolor="#FFFFFF" id="tabla_correcciones">
                      <tr>
                        <td align="center" bgcolor="#028DC8" style="color:#FFFFFF"><strong><span id="texto_recomendacion">Indicaciones / Modificaciones</span></strong></td>
                      </tr>
                      <tr>
                        <td align="center" bgcolor="#FFFFFF" class="texto"><textarea name="comentarios" style="width:100%" rows="8"><?=$comentarios?></textarea></td>
                      </tr>
                    </table>
<?php
	if($_SESSION["nivel"]==2 or $_SESSION["nivel"]==1){
?>
                    <table width="95%" border="0" cellpadding="3" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; border:1px #333 solid; display:none;" bgcolor="#FFFFFF">
                      <tr>
                        <td width="30%" align="center" bgcolor="#028DC8" style="color:#FFFFFF"><strong>Premio</strong></td>
                        <td width="19%" align="right"><input type="radio" value="Si" name="premio" <? if($_SESSION["premio"]=="Si"){echo "checked";} ?>></td>
                        <td width="13%" align="left">Si</td>
                        <td width="11%" align="right"><input type="radio" value="No" name="premio" <? if($_SESSION["premio"]=="No"){echo "checked";} ?>></td>
                        <td width="27%" align="left">No</td>
                      </tr>
                    </table>
                    <br>
                    <?
					 }
					 if($_SESSION["nivel"]==2 or $_SESSION["nivel"]==1){
					?>
					<input name="aceptar2" type="submit" class="botones" value="Guardar evaluaci&oacute;n" style="width:95%; font-size:13px; font-weight:bold; color:#FFFFFF; background-color:red;" />
					<?php
					 }
					?>
                    <br>
                    <br>
                    <input name="aceptar" type="button" class="botones" value="Salir sin guardar evaluación" style="width:95%; font-size:10px; font-weight:bold; " onClick="document.location.href='personal.php';"/>
                    <br>
                    <br>
                    <table width="95%" border="0" cellpadding="3" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:9px; border:1px #333 solid; display:none;">
                      <tr>
                        <td align="left">
                        Escala de Puntuación:<br>
                                0 al 2 no cumple con los criterios mínimos aceptables.<br>
                                3 al 5 mínimos aceptables.<br>
                                6 y 12 entre aceptables y excelentes.<br><br>
                                
                        Se evaluarán a Premio de 9 o más puntos.<br>
                        Si el trabajo se considerara “APTO” pero tienen evaluaciones en uno o más ítems entre 3 y 5 puntos, se les trasmitirán a los autores las recomendaciones sin identificar al evaluador que las formuló.<br>
                        Igualmente se podrán plantear recomendaciones a los de promedio 6 o más.<br><br>
                                
                        En caso de considerarlo “NO APTO”, exprese brevemente los motivos.<br></td>
                      </tr>
                    </table>
                
              </td>                    
                    <td width="67%" rowspan="2" align="center" valign="top" bgcolor="#FFFFFF">
                    <table width="100%" cellpadding="5" cellspacing="0">
                      <tr>
                        <td align="center" bordercolor="#F0F0F0">
                        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
                        <tr>
                        <td>
                                <table width="100%" border="1" cellpadding="2" cellspacing="0" style="border:solid 1px #999999; font-size:12px; display:none;">
                          <tr>
                              <td bgcolor="#028DC8" style="color:white;"><span class="textos" style="width:550px;"><strong>Autores:</strong></span></td>
                              </tr>
                              <tr>
                                <td><div id="divAutores" align="center" style="padding:1px; font-family:Arial, Helvetica, sans-serif; font-size:10px;"></div></td>
                              </tr>
                                </table>
                          </td>
                          </tr>                  
                              <tr>
                                <td height="10">

                                <table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px;">
                              <tr>
                                <td align="center"><strong><?=$titulo?></strong></td>
                              </tr>
                              </table><br>
                              <table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px; display:none;">
                              <tr>
                                <td><strong>Tiene Trabajo Completo: <? if($dirArchivo!=""){echo "Si";}else{echo "No";}?></strong></td>
                              </tr>
                              <? if($dirArchivo!=""){?>
                              <tr>
                                <td align="center">
                                
                                <a href="javascript:bajarTL('../tl/<?=$dirArchivo?>')" style="font-size:13px; text-decoration:none; color:#028DC8"><strong>Descargue el trabajo completo para su evaluaci&oacute;n</strong></a>
                                
                                </td>
                              </tr>
                              <? }?>
                              </table>
                              <table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px;">
                              <tr>
                                <td><strong>Resumen:</strong></td>
                              </tr>                
                              <tr>
                                <td align="left" valign="top" style="text-align:justify">
									<?=$resumen?>
                                    <div style="border-bottom:1px dashed #CCC;margin:5px 0"></div>
                                </td>
                              </tr>                  
                              </table>
                            
                              
                              <table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px;">
                              <tr>
                                <td><strong>Justificación:</strong></td>
                              </tr>                
                              <tr>
                                <td align="left" valign="top" style="text-align:justify">
									<?=$resumen2?>
                                    <div style="border-bottom:1px dashed #CCC;margin:5px 0"></div>
                                </td>
                              </tr>                  
                              </table>
                              
                              
                              <table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px;">
                              <tr>
                                <td><strong>Objetivos</strong></td>
                              </tr>                
                              <tr>
                                <td align="left" valign="top" style="text-align:justify">
									<?=$resumen3?>
                                    <div style="border-bottom:1px dashed #CCC;margin:5px 0"></div>
                                </td>
                              </tr>                  
                              </table>
                              
                              <table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px;">
                              <tr>
                                <td><strong>Materiales y Métodos:</strong></td>
                              </tr>                
                              <tr>
                                <td align="left" valign="top" style="text-align:justify">
									<?=$resumen4?>
                                    <div style="border-bottom:1px dashed #CCC;margin:5px 0"></div>
                                </td>
                              </tr>                  
                              </table>
                              
                              <table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px;">
                              <tr>
                                <td><strong>Resultados:</strong></td>
                              </tr>                
                              <tr>
                                <td align="left" valign="top" style="text-align:justify">
									<?=$resumen5?>
                                    <div style="border-bottom:1px dashed #CCC;margin:5px 0"></div>
                                </td>
                              </tr>                  
                              </table>
                              
                              <!--<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px;">
                              <tr>
                                <td><strong>Discusión:</strong></td>
                              </tr>                
                              <tr>
                                <td align="left" valign="top" style="text-align:justify">
									<?=$resumen6?>
                                    <div style="border-bottom:1px dashed #CCC;margin:5px 0"></div>
                                </td>
                              </tr>                  
                              </table>
                              
                              <table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px;">
                              <tr>
                                <td><strong>Conclusiones:</strong></td>
                              </tr>                
                              <tr>
                                <td align="left" valign="top" style="text-align:justify">
									<?=$resumen7?>
                                    <div style="border-bottom:1px dashed #CCC;margin:5px 0"></div>
                                </td>
                              </tr>                  
                              </table>-->
                          
                              
                              <!--<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px;">
                              <tr>
                                <td><strong>Palabras Clave:</strong></td>
                              </tr>                
                              <tr>
                                <td align="left" valign="top" style="text-align:justify">
									<?php echo $palabrasClave ?>
                                    <div style="border-bottom:1px dashed #CCC;margin:5px 0"></div>
                                </td>
                              </tr>                  
                              </table>
                              <br>-->
                              
                              
                              </td>
                              </tr>                            
                              <tr><td>
                              
                              <table width="100%" border="1" cellpadding="2" cellspacing="0" style="font-size:12px; display:none"><tr>
                                <td height="10" bgcolor="#DBF4FF"><strong>Tiene Trabajo Completo: <? if($archivo_tl!=""){echo "Si";}else{echo "No";}?></strong></td>
                              </tr>
                              <? if($archivo_tl!=""){?>
                              <tr>
                                <td align="center">
                                
                                <a href="javascript:bajarTL('tl/<?=$archivo_tl?>')" style="font-size:13px; text-decoration:none; color:#028DC8"><strong>Descargue el trabajo completo para su evaluaci&oacute;n</strong></a>                    </td>
                              </tr>
                              <? }?>
                              </table>
                      
                              <table width="100%" border="1" cellpadding="2" cellspacing="0" style="border:solid 1px #999999;  font-size:12px; display:none;"><tr>
                                <td height="10" bgcolor="#DBF4FF"><strong>Tiene Trabajo Completo: <? if($dirArchivo!=""){echo "Si";}else{echo "No";}?></strong></td>
                              </tr>
                              <? if($dirArchivo!=""){?>
                              <tr>
                                <td align="center">
                                
                                <a href="javascript:bajarTL('../tl/<?=$dirArchivo?>')" style="font-size:13px; text-decoration:none; color:#028DC8"><strong>Descargue el trabajo completo para su evaluaci&oacute;n</strong></a>                    </td>
                              </tr>
                              <? }?>
                              </table>
                              
                              </td></tr>
                        </table></td>
                      </tr>
                    </table>
        </td>
    </table>
</form>
<br>&nbsp;
</center>
</body>
</html>
<script language="javascript" type="text/javascript" src="js/funciones_ArmadoTrabajoLibre.js"></script>
<?
include "inc.gestionAutores.php";
//var_dump($gestionAutores);
?>
<script>
$(document).ready(function(e) {
	
	esAutor();
	$("input[name='acepto_trabajo']").click(function(){
		esAutor();
		conCorrecciones();
	});
	
	conCorrecciones();
	$("input[name='estado']").click(function(){
		conCorrecciones();
	});
	
	//console.log(cargarDivAutores('<?=$gestionAutores?>'))
	//cargarDivAutores('<?=$gestionAutores?>');
	//$("#divAutores").html('<?=$gestionAutores?>');
});

function esAutor(){
	if ($("input[name='acepto_trabajo']:checked").val() === 'Si'){
		$("#tabla_estado").hide();
		console.log($("input[name='estado']:checked"));
		$("input[name='estado']:checked").prop('checked', false);
	} else {
		$("#tabla_estado").show();
	}
}

function conCorrecciones(){
	if($("input[name='estado']:checked").val()==="Aceptado con modificaciones"){
		$("#tabla_correcciones").show();
	}else{
		$("#tabla_correcciones").hide();
		$("textarea[name='comentarios']").val('');
	}
}

//txtCor('<?=$estado?>');
//cargarDivAutores('<?=$gestionAutores?>');
//setInterval("total()",2000);
</script>