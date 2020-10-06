<?php
session_start();
if($_SESSION["Login"]==""){
	header("Location: login.php");
	die();
}
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");

include("../envioMail_Config.php");
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

$array_ID_persona = array();
$array_nombre = array();
$array_apellido = array();
$array_institucion = array();
$array_mail = array();
$array_pais = array();
$array_ciudad= array();
$array_agradecimientos = array();
$array_lee = array();
$array_inscripto= array();

$_SESSION["txtCod"]=$_GET["txtCod"];

 
	$sql3 = "SELECT * FROM trabajos_libres WHERE numero_tl='" . $_GET["txtCod"] ."';";
	$rs3 = $con->query($sql3);
	$row = $rs3->fetch_array();
	$pass=1;
	//$_SESSION["idEvaluador"] = $idEvaluador;
	$_SESSION["opcion"] = $opcion;
	$_SESSION["nota"] = $nota;
	$_SESSION["correccion"] = str_replace("<br />", "", $correccion);	
	$_SESSION["opcion2"] = $opcion2;
	$_SESSION["nota2"] = $nota2;
	$_SESSION["correccion2"] = str_replace("<br />", "", $correccion2);	
	//$_SESSION["nombreEvaluador"] = $nombreEvaluador;
	$_SESSION["registrado"] = true;
	$_SESSION["habilitado"] = true;
	$_SESSION["ID_TL"] = $row["ID"];	
	$_SESSION["emailContacto"] = $row["contacto_mail"];
	$_SESSION["ApellidoContacto"] = $row["contacto_apellido"];
	$_SESSION["NombreContacto"] = $row["contacto_nombre"];
	$_SESSION["InstContacto"] = $row["contacto_institucion"];
	$_SESSION["paisContacto"] = $row["contacto_pais"];
	$_SESSION["ciudadContacto"] = $row["contacto_ciudad"];
	$_SESSION["agraContacto"] = $row["agraContacto"];
	$_SESSION["telContacto"] = $row["telefono"];
	$_SESSION["numero"] = $row["numero_tl"];
	$_SESSION["titulo"] = $row["titulo_tl"];
	$_SESSION["resumen"] = $row["resumen"];
	$_SESSION["resumen2"] = $row["resumen2"];
	$_SESSION["resumen3"] = $row["resumen3"];
	$_SESSION["resumen4"] = $row["resumen4"];
	$_SESSION["resumen5"] = $row["resumen5"];
	$_SESSION["resumen6"] = $row["resumen6"];
	$_SESSION["resumen_en"] = $row["resumen_en"];
	$_SESSION["titulo_residente"] = $row["titulo_tl_residente"];
	$_SESSION["resumen_residente"] = $row["resumen_residente"];
	$_SESSION["resumenIng"] = $row["resumenIng"];
	$_SESSION["tema"] = $row["area_tl"];
	$_SESSION["idiomaTL"] = $row["idioma"];
	$_SESSION["tipoTL"] = $row["tipo_tl"];
	$_SESSION["archivo_tl"] = $row["archivo_tl"];
	$_SESSION["dirArchivo"] = $row["dirArchivo"];
	$_SESSION["clave"] = $row["clave"];
	$keys = $row["palabrasClave"]; 
	
	$_SESSION["objetivos"] = $row["antecedentes"];
	$_SESSION["desarrollo"] = $row["material"];
	$_SESSION["conclusiones"] = $row["conclusiones"];
	$_SESSION["referencias"] = $row["referencias"];
	
	list($_SESSION["key1"], $_SESSION["key2"], $_SESSION["key3"], $_SESSION["key4"], $_SESSION["key5"] ) = explode(',', $keys );
	$enAutor=1;
	$sql0 ="SELECT * FROM trabajos_libres_participantes WHERE ID_trabajos_libres=" . $row["id_trabajo"] . "  ORDER BY ID ASC;";
	$rs0 = $con->query($sql0);
	while ($row0 = $rs0->fetch_array()){
		$sql1 ="SELECT * FROM personas_trabajos_libres WHERE ID_Personas = " . $row0["ID_participante"] . ";";
		$rs1 = $con->query($sql1);
		while ($row1 = $rs1->fetch_array()){
			array_push($array_ID_persona, $row1["ID_Personas"]);
			array_push($array_nombre, $row1["Nombre"]);
			array_push($array_apellido, $row1["Apellidos"]);
			array_push($array_institucion,  $row1["Institucion"]);
			array_push($array_mail,  $row1["Mail"]);
			array_push($array_pais, $row1["Pais"]);
			array_push($array_ciudad,  $row1["ciudad"]);
			array_push($array_agradecimientos,  $row1["agradecimientos"]);			
			if($row0["lee"]==1){
				$array_lee = $enAutor;
			}			
			array_push($array_inscripto, $row0["inscripto"]);
		}
		$enAutor=$enAutor+1;
	}
	$autores = new autores();
	$autores->setSessionAutores($array_ID_persona, $array_nombre,$array_apellido,$array_institucion,$array_mail,$array_pais,$array_ciudad,$array_agradecimientos,$array_lee,$array_inscripto);//


if ($_SESSION["Login"] != "Logueado") {
	header("Location:login.php");
}

$TL_rs = $trabajos->selectTL_ID($_SESSION["ID_TL"]);
$row = $TL_rs->fetch_object();
$imagen_ing = trim($row->tabla_trabajo_comleto_ing);

	$dirArchivo = $_SESSION["archivo_tl"];
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
	$numero = $_GET["txtCod"];
	$titulo = trim($_SESSION["titulo"]);
	
	$titulo_residente = trim($_SESSION["titulo_residente"]);
	
	$objetivos = $_SESSION["objetivos"];
	$desarrollo = $_SESSION["desarrollo"];
	$conclusiones = $_SESSION["conclusiones"];
	$referencias = $_SESSION["referencias"];
	
	$resumen = $_SESSION["resumen"];
	$resumen2 = $_SESSION["resumen2"];
	$resumen3 = $_SESSION["resumen3"];
	$resumen4 = $_SESSION["resumen4"];
	$resumen5 = $_SESSION["resumen5"];
	$resumen6 = $_SESSION["resumen6"];
	$resumen_en = $_SESSION["resumen_en"];
	$resumen_residente = $_SESSION["resumen_residente"];
	$resumenIng = $_SESSION["resumenIng"];	
	$area = $_SESSION["tema"];
	$subarea = $_SESSION["subtema"];
	$tipo_tl = trim($_SESSION["tipoTL"]);
	
	$sqlPremio = "SELECT premio FROM trabajos_libres WHERE numero_tl='".$_SESSION["numero"]."'";
	$resultPremio = $con->query($sqlPremio);
	if(!$resultPremio){
		die($con->error);
	}
	$rowPremio = $resultPremio->fetch_array();
	$premio = $rowPremio["premio"];
	
	
	
$sql ="SELECT * FROM evaluaciones WHERE idEvaluador = '".$_GET["evaluador"]."' AND numero_tl ='".$numero."';";
$rs = $con->query($sql);
if(!$rs){
	die($con->error);
}
while($row = $rs->fetch_array()){
	$opcion = $row["opcion"];
	$evaluar_trabajo = $row["evaluar_trabajo"];
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
	/*$premio = $row["premio"];*/
	$estado = $row["estadoEvaluacion"];
	$tipo = $row["tipoEvaluacion"];
	$comentarios = $row["comentarios"];
}


$sqlEvaluador = "SELECT * FROM evaluadores WHERE id='".$_GET["evaluador"]."'";
$queryEvaluador = $con->query($sqlEvaluador);
if(!$queryEvaluador){
	die($con->error);
}
$rowEvaluador = $queryEvaluador->fetch_array();
	
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
<script language="javascript" type="text/javascript" src="js/funciones.js"></script>
</head>

<body>
<center>
<form action="enviarEvaluacion.php" method="post" name="form0" id="form0">
  <table width="580px" cellspacing="5" cellpadding="1" border="0">
  	<tr>
  		<td><img src="../../imagenes/banner.jpg" style="width:580px"></td>
        <td>
        <div class="col-xs-12" style="margin-top:20px;padding: 0px">
        	<div class="col-xs-4" style="padding-right: 0px; width:274px" align="center">
            	<span style="font-size:10px"> Responsable de la Evaluaci&oacute;n: <br><strong><?=$rowEvaluador["nombre"]?></strong></span><br>
            </div>
            <br>
        	<div class="col-xs-4" style="padding-right: 0px; width:274px" align="center">
        		 <input name="aceptar" type="button" class="botones" value="Volver" style="width:80%; font-size:10px; font-weight:bold; " onClick="document.location.href='personal.php';"/>
        	</div>
            
        </div>
        </td>
    </tr>
  </table>
  <!--<a href="docs/Evaluadores.pdf" style="font-size:13px; color:blue;">Descargar: Propuesta de mecanismo de evaluación de los trabajos científicos presentados.</a>-->
  <br>
  <table width="850" align="center" cellpadding="5px" cellspacing="0" style="border:2px; border-color:#333; border-style:solid">
    <tr>
      <td width="33%" align="center" valign="top" bgcolor="#F4F4F4">
        <!--<table width="95%" border="0" cellpadding="3" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; border:1px #333 solid;" bgcolor="#FFFFFF">
          <tr>
            <td align="center" bgcolor="#028DC8" style="color:#FFFFFF"><strong>Responsable de la Evaluaci&oacute;n:</strong></td>
          </tr>
          <tr>
            <td align="center">&nbsp;
              <?php /*echo $_SESSION["nombreEvaluador"];*/ ?></td>
          </tr>
        </table>
        <span style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:16px"><strong><br>
          </strong></span><span style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:16px"><strong><br>
            Evaluaci&oacute;n</strong></span><br>
        <br>-->
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
        <?php
	if($_SESSION["nivel"]==1){
?>
        <table width="95%" border="0" cellpadding="3" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; border:1px #333 solid;" bgcolor="#FFFFFF">
          <tr>
            <td align="center" bgcolor="#028DC8" style="color:#FFFFFF"><strong>Evaluación global</strong></td>
          </tr>
          <tr>
            <td align="center" bgcolor="#FFFFFF" class="texto"><?=$estado?></td>
          </tr>
        </table>
        <br>
        <?php if($estado === 'Aceptado con correcciones') { ?>
        <table width="95%" border="0" cellpadding="3" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; border:1px #333 solid;" bgcolor="#FFFFFF">
          <tr>
            <td align="center" bgcolor="#028DC8" style="color:#FFFFFF"><strong>Indicaciones / Correcciones</strong></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF" class="texto"><?=$comentarios?></td>
          </tr>
        </table>
        <br>
        <?php } ?>
        <table width="95%" border="0" cellpadding="3" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; border:1px #333 solid; display:none" bgcolor="#FFFFFF">
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
		?>
        
        <table width="95%" border="0" cellpadding="3" cellspacing="0" style="font-size:12px;">
            <tr>
                <td><? if($numero!=""){echo "<strong><span class='textos' style='font-size:12px'>N&deg; de trabajo:</strong> " . $numero . "</span>";}?>&nbsp;</td>
            </tr>
        </table>
        <table width="95%" border="0" cellpadding="3" cellspacing="0" style="font-size:12px;">
              <tr>
                <td><strong>Área:</strong> <?=$trabajos->areaID($area)->Area_es?></td>
              </tr>
        </table>
      </td>
      <td width="67%" rowspan="2" align="center" valign="top" bgcolor="#FFFFFF"><table width="100%" cellpadding="5" cellspacing="0">
        <tr>
          <td align="center" bordercolor="#F0F0F0"><br>
            <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
              <tr>
                <td><table width="100%" border="1" cellpadding="2" cellspacing="0" style="border:solid 1px #999999; font-size:12px; display:none">
                  <tr>
                    <td bgcolor="#DBF4FF"><span class="textos" style="width:550px;"><strong>Autores:</strong></span></td>
                  </tr>
                  <tr>
                    <td><div id="divAutores" align="center" style="padding:1px; font-family:Arial, Helvetica, sans-serif; font-size:10px;"></div></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td height="10">
                  <table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px;">
                    <tr>
                      <td align="center"><strong>
                        <?=$titulo?>
                      </strong></td>
                    </tr>
                  </table><br>
                  <table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px;">
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
                      <td><strong>Introducción:</strong></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" style="text-align:justify"><?=$resumen?>
                        <div style="border-bottom:1px dashed #CCC;margin:5px 0"></div></td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px;">
                    <tr>
                      <td><strong>Objetivo:</strong></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" style="text-align:justify"><?=$resumen2?>
                        <div style="border-bottom:1px dashed #CCC;margin:5px 0"></div></td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px;">
                    <tr>
                      <td><strong>
                      <?php
					  if ($tipo_tl=="1") {
					  ?>
						Material y Métodos:
					  <?php
					  } else {
					  ?>
						Caso(s) clínico(s)
					  <?php
					  }
					  ?>
                      </strong></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" style="text-align:justify"><?=$resumen3?>
                        <div style="border-bottom:1px dashed #CCC;margin:5px 0"></div></td>
                    </tr>
                  </table>
                  <?php
				  if ($tipo_tl=="1") {
				  ?>
                  <table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px;">
                    <tr>
                      <td><strong>Resultados:</strong></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" style="text-align:justify"><?=$resumen4?>
                        <div style="border-bottom:1px dashed #CCC;margin:5px 0"></div></td>
                    </tr>
                  </table>
                  <?php
				  }
				  ?>
                  
                  <table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px;">
                    <tr>
                      <td><strong>Discusión/Conclusiones:</strong></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" style="text-align:justify"><?=$resumen5?>
                        <div style="border-bottom:1px dashed #CCC;margin:5px 0"></div></td>
                    </tr>
                  </table>
                  
                  <table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size:12px;">
                    <tr>
                      <td><strong>Palabras clave:</strong></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" style="text-align:justify"><?=$keys?>
                        <div style="border-bottom:1px dashed #CCC;margin:5px 0"></div></td>
                    </tr>
                  </table>
                  
                  
                  
                  <br></td>
              </tr>
              <tr>
                <td><table width="100%" border="1" cellpadding="2" cellspacing="0" style="font-size:12px; display:none">
                  <tr>
                    <td height="10" bgcolor="#DBF4FF"><strong>Tiene Trabajo Completo:
                      <? if($archivo_tl!=""){echo "Si";}else{echo "No";}?>
                    </strong></td>
                  </tr>
                  <? if($archivo_tl!=""){?>
                  <tr>
                    <td align="center"><a href="javascript:bajarTL('tl/<?=$archivo_tl?>')" style="font-size:13px; text-decoration:none; color:#028DC8"><strong>Descargue el trabajo completo para su evaluaci&oacute;n</strong></a></td>
                  </tr>
                  <? }?>
                </table>
                  <table width="100%" border="1" cellpadding="2" cellspacing="0" style="border:solid 1px #999999;  font-size:12px; display:none">
                    <tr>
                      <td height="10" bgcolor="#DBF4FF"><strong>Tiene Trabajo Completo:
                        <? if($dirArchivo!=""){echo "Si";}else{echo "No";}?>
                      </strong></td>
                    </tr>
                    <? if($dirArchivo!=""){?>
                    <tr>
                      <td align="center"><a href="javascript:bajarTL('../tl/<?=$dirArchivo?>')" style="font-size:13px; text-decoration:none; color:#028DC8"><strong>Descargue el trabajo completo para su evaluaci&oacute;n</strong></a></td>
                    </tr>
                    <? }?>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
    </table>
</form>
<br>&nbsp;
</center>
</body>
</html>
<script language="javascript" type="text/javascript" src="js/funciones_ArmadoTrabajoLibre.js"></script>
<?
include "inc.gestionAutores.php";
?>
<script>cargarDivAutores('<?=$gestionAutores?>');</script>