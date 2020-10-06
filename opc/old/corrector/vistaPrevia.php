<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");

/////////////CONFIGURACION//////////////////
$congreso = "HIDRAULICA 2010";
$subirArch = true;
////////*INICIO VERDECITO*//////////

/*$colorFondoClaro = "#DCE4E3";
$colorFondo = "#004800";
$colorFondoArriba = "#A2B9B6";*/

////////*FIN COLOR VERDECITO*///////
////////*INICIO AZUL*//////////
$colorFondoClaro = "#CFDEE7";
$colorFondo = "#006699";
$colorFondoArriba = "#A3C0D1";
////////*FIN COLOR AZUL*///////
////////*INICIO NARANJA*//////////
/*
$colorFondoClaro = "#F8EDDC";
//$colorFondo = "#FF9900";
$colorFondo = "#83572C";
$colorFondoArriba = "#E3C8AC";*/
////////*FIN COLOR NARANJA*///////
///////////////////////////////////////////

if (!isset($_SESSION["registrado"])){
	$_SESSION["registrado"]=false;

}
if ($_SESSION["registrado"]==false){
	//header ("Location: AUTOR_codigo.php");
}


$_SESSION["emailContacto"] = $_POST["emailContacto"];
$_SESSION["emailContacto2"] = $_POST["emailContacto2"];
$_SESSION["ApellidoContacto"] = $_POST["ApellidoContacto"];
$_SESSION["NombreContacto"] = $_POST["NombreContacto"];
$_SESSION["InstContacto"] = $_POST["InstContacto"];
$_SESSION["paisContacto"] = $_POST["paisContacto"];
$_SESSION["ciudadContacto"] = $_POST["ciudadContacto"];
$_SESSION["emailContacto"] = $_POST["emailContacto"];
$_SESSION["telContacto"] = $_POST["telContacto"];
$_SESSION["agraContacto"] = $_POST["agraContacto"];
$_SESSION["idiomaTL"] = $_POST["idiomaTL"];

$_SESSION["travel_award"] = $_POST["travel_award"];
$_SESSION["tema"] = $_POST["tema"];
$_SESSION["tipoTL"] = $_POST["tipoTL"];
$_SESSION["chkAcepto"] = $_POST["chkAcepto"];


$_SESSION["titulo"] = trim($_POST["titulo"]);
$_SESSION["resumen"] = $_POST["resumen"];
$_SESSION["tema"] = $_POST["tema"];

$_SESSION["key1"]  = $_POST["key1"];
$_SESSION["key2"]  = $_POST["key2"];
$_SESSION["key3"]  = $_POST["key3"];
$_SESSION["key4"]  = $_POST["key4"];
$_SESSION["key5"]  = $_POST["key5"];
if($_POST["key1"]){ $key1 = $_POST["key1"] . ", "; }
if($_POST["key2"]){ $key2 = $_POST["key2"] . ", "; }
if($_POST["key3"]){ $key3 = $_POST["key3"] . ", "; }
if($_POST["key4"]){ $key4 = $_POST["key4"] . ", "; }
if($_POST["key5"]){ $key5 = $_POST["key5"] ; }
$_SESSION["keywords"] = $key1 . $key2 . $key3 . $key4 . $key5;

	if($_POST["titulo"]=="" || $_POST["resumen"]==""){
		if($_GET["vista"]!=1){
			header("Location: index.php?error=1");
		}else{
			echo "<script>\n";
			echo "alert('Todos los campos son obligatorios')\n";
			echo "</script>\n";
		}
	}

	echo "<script>\n";
		if($_GET["vista"]!=1){
			echo "var vista = 0\n";
		}else{
			echo "var vista = 1\n";
		}


	echo "</script>\n";

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$congreso?> - Presentaci&oacute;n de Trabajo</title>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<link href="css/estilosDeTrabajoLibre.css" rel="stylesheet" type="text/css" />
<script src="js/funciones_VistaPrevia.js" language="javascript" type="text/javascript"></script>
<style type="text/css">
<!--
body {
	background-color: <?=$colorFondo?>;
}
-->
</style></head>

<body <? // onLoad="comprebarHabilitado()" ?> >
<?
if($_GET["vista"]!=1){
?>
	<center>
	<table width="650" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
    <td align="center" bgcolor="#FFFFFF"><img src="../imagenes/banner.jpg" width="598" height="137" /></td>
    </tr>
    </table>
    <table width="650" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFF">
	  <tr><td bgcolor="#FFFFFF">
    <table width="600" border="2" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
	  <tr bgcolor="#F0F0F0">
		<td width="" bordercolor="#000000"><table width="100%" border="0" cellpadding="5" cellspacing="0">
          <tr>
            <td height="49" bordercolor="#F0F0F0"><div align="center"><strong><font size="4" face="Verdana, Arial, Helvetica, sans-serif">Vista Previa </font></strong><br />
                    <br />
              </div>
            </td>
          </tr>
          <tr>
            <td bordercolor="#F0F0F0"><form action="enviar.php" method="post" enctype="multipart/form-data"  name="form1"  id="form1">
                <table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
                  <tr>
                    <td height="116">
                      <div align="left">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input name="Submit32" type="button" class="botones" onClick="volverIndex()" value="&lt; Atr&aacute;s" style="width:100px;" />
                        &nbsp;&nbsp;</div></td></tr>
                    <tr>
                    <td>
					<?
					}
					?>
					<div align="center">
					<div id="alertaMalTrabajo" style="display:none;"><strong>Su resumen es demasiado extenso. Intente acortarlo. De lo contrario no podra ser enviado.  </strong></div>
					 </div>
					<?
					include "inc.disenoPrevia.php";
				
					?>              		</td>
					</tr>
                    <tr>
                    <? if($subirArch==true){ ?>
					  <td>
                      <table width="100%" border="2" align="center" cellpadding="2" cellspacing="2" bordercolor="#000000" bgcolor="#CFDEE7">
  <tr>
    <td style="font-size:14px"><strong>Ingrese su Presentaci&oacute;n</strong>
</td>
  </tr>
  <tr>
    <td> <span  class="textos">
	<? if($_SESSION["archivo_trabajo_comleto"]!=""){ 
	$nombreArchivo = $_SESSION["archivo_trabajo_comleto"];
	?>
		Archivo actual  (<em>solo lectura</em>): <a href='../bajando_tl.php?id=<?=$nombreArchivo?>'> <img src='../img/filesave.png' border='0' align='absmiddle' > <?=$nombreArchivo?></a><br>
		<?	}
	?>
	<strong>Resumen Extendido:</strong> (Debe ser menor a 2048 KB)&nbsp;&nbsp;&nbsp;&nbsp;
                      <input name="archivo_TL" type="file" class="textos" id="archivo_TL"  style="width:200px;" size="40" onChange="HabilitarBtnAceptar(this.value)" onKeyPress="HabilitarBtnAceptar(this.value)"></span>             </td>
  </tr>
</table>         </td>
					<? } ?>
                    </tr>
                    <tr>
                      <td><div align="center"><br>
                          <input name="BTNaceptarEnviar" type="submit" class="botones"  style="width:328px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold;" onClick="VerCargando()"  value="Aceptar y Enviar" 
						  <? if($cantidadPalabras > 350){ echo 'disabled="disabled"';}	?>  />
                      </div></td>
                    </tr>
				</table>
					</form>
			</td>
		  </tr>
			</table></td>
	  </tr>
	  </table><br>
</td></tr></table>

	</center>




	<div id="bgEnabled" style="background-image:url(bg_enabled.gif);display:none;;">

	<div id="ventanaDivs"  style="display:none; color:#999999; vertical-align:middle">
	 
	<div id="cargando">
	  <font color="#FF0000" size="2" face="Arial, Helvetica, sans-serif"><strong>Aguarde... </strong><br>
	  Esta operación puede tardar un momento.<br>
	  <font color="#000000">Se esta subiendo su trabajo a nuestro servidor.<br>
	  <em>Gracias</em></font><br>	  
	  <br>
	  </font>
	  <center>
	  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="250" height="6" title="Cargando...">
        <param name="movie" value="carga.swf">
        <param name="quality" value="high">
        <embed src="carga.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="250" height="6"></embed>
      </object>
	  </center>

	</div>
      </div>
	</div>

</body>
</html>


