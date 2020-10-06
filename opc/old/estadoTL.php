<?php
include('inc/sesion.inc.php');
include "conexion.php";
require "clases/trabajosLibres.php";
//header('Content-Type: text/html; charset=UTF-8');
$trabajos = new trabajosLibre;

$sePuedeImprimir=true;

if($_GET["neg"]==true){
?>
<script language="javascript" type="text/javascript">
alert("Los trabajos seleccionados para el envio no disponian de un mail de contacto o no estaban ubicados.");
</script>
<?
}

$estado = $_GET["estado"]; 
$ubicado = $_GET["ubicado"]; 
$area = $_GET["area"]; 
$tipo =  $_GET["tipo"]; 
$Pclave = $_GET["clave"];
$pagina = $_GET["pagina"];
$inscr = $_GET["inscr"];
$premio = $_GET["premio"];
$idioma = $_GET["idioma"];
$adjunto = $_GET["adjunto"];
$adjunto_oral = $_GET["adjunto_oral"];
$adjunto_poster = $_GET["adjunto_poster"];
$eliminado = $_GET["eliminado"];
$cualPremio = $_GET["quePremio"];
$dropbox = $_GET["dropbox"];
$filtroCongreso = $_GET["filtroCongreso"];
if($cualPremio==""){
	$quePremio = "";
}else{
	if($premio=="Si"){
		$quePremio = $cualPremio;
	}else{
		$quePremio = "";
	}
}



function remplazar($cual){

		 	$que_busca = $_GET["clave"];
		 	$arrayBusqueda = explode(" ",  $que_busca);

		 	$enBucle = 0;


		 	$resultado= $cual;

		 	foreach ($arrayBusqueda as $busq){

		 		
		 		
		 		switch ($enBucle){
		 			
		 			case 0:
		 				$caracterEspecial = "Š";
		 				break;
		 				
		 			case 1:
		 				$caracterEspecial = "¥";
		 				break;
		 			
		 			case 2:
		 				$caracterEspecial = "Œ";
		 				break;
		 			
		 			case 3:
		 				$caracterEspecial = "ø";
		 				break;
		 			
		 			case 4:
		 				$caracterEspecial = "þ";
		 				break;
		 		}
		 		
		 		$resultado = str_replace  ($busq , $caracterEspecial . $busq . "œ", $resultado);

		 		if($enBucle<4){
		 		$enBucle = $enBucle + 1;
		 		}else{
		 		$enBucle = 0;
		 		}

		 	}


		 	$resultado = str_replace("œ",  "</span>" , $resultado);
		 	$resultado = str_replace("Š",  "<span class='b_0'>" , $resultado);
		 	$resultado = str_replace("¥",  "<span class='b_1'>" , $resultado);
		 	$resultado = str_replace("Œ",  "<span class='b_2'>" , $resultado);
		 	$resultado = str_replace("ø",  "<span class='b_3'>" , $resultado);
		 	$resultado = str_replace("þ",  "<span class='b_4'>" , $resultado);

		 	return  $resultado ;

}

?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script>
function agregarItem(cual_, txt, valor){
	
	var oOption = document.createElement("OPTION");

	oOption.text = txt;

	oOption.value = valor;

	cual_.options.add(oOption);
}

</script>
<script src="js/tipoTL.js"></script>
<script src="js/areasTL.js"></script>
<script src="js/trabajos_libres.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script src="js/slide.js" type="text/javascript"></script>
<script>
function entsub(myform) {

  if (window.event && window.event.keyCode == 13){
       filtrar(document.form1.filtroEstado.value, document.form1.filtroUbicado.value, document.form1.filtroArea.value, document.form1.tipo.value, document.form1.filtroPalabraClave.value, getRadioButtonSelectedValue(document.form1.filtroPresentador), document.form1.filtroPremio.value, document.form1.filtroCualPremio.value,document.form1["filtroIdioma"].value,getRadioButtonSelectedValue(document.form1.filtroAdjunto),getRadioButtonSelectedValue(document.form1.filtroDropbox))
 }
}
function mostrarContenido(cual){
	document.getElementById('menu_mover').style.background = '#E4E4CD';
	document.getElementById('menu_tipo').style.background = '#E4E4CD';
	document.getElementById('menu_area').style.background = '#E4E4CD';
	document.getElementById('menu_ubicar').style.background = '#E4E4CD';
	document.getElementById('menu_'+cual).style.background = '#F7F7F0';
	
	document.getElementById('contenidos_mover').style.display = 'none';
	document.getElementById('contenidos_tipo').style.display = 'none';
	document.getElementById('contenidos_area').style.display = 'none';
	document.getElementById('contenidos_ubicar').style.display = 'none';
	document.getElementById('contenidos_'+cual).style.display = 'block';	
}
</script>
<link href="estilos.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
.borddeAbajo {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #77969F;
}

.vinculo{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #0033FF;
	text-decoration: none;
}
.vinculo:hover{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color:#000033;
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
<link href="estiloBordes.css" rel="stylesheet" type="text/css">

<?
$trabajos->arrayAreas();
$trabajos->arrayTipoTL();
?><body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "inc/vinculos.inc.php";?>
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#F0E6F0" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php"; ?></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="2">
      <tr>
        <td width="23%" height="30" align="center" valign="middle" bordercolor="#FF0000" bgcolor="#FFCACA" class="menu_sel"><b>[<?=$trabajos->cantidadInscriptoTL_estado("0");?>] </b><a href="?estado=0">Recibidos</a></td>
        <td width="17%" height="30" align="center" valign="middle" bordercolor="#0099CC" bgcolor="#79DEFF" class="menu_sel"><b>[<?=$trabajos->cantidadInscriptoTL_estado("1");?>]</b> <a href="?estado=1">En revisi&oacute;n</a></td>
        <td width="22%" height="30" align="center" valign="middle" bordercolor="#006600" bgcolor="#82E180" class="menu_sel"><b>[<b><?=$trabajos->cantidadInscriptoTL_estado("2");?></b>]</b> <a href="?estado=2">Aprobados</a></td>
        <td width="20%" align="center" valign="middle" bordercolor="#333333" bgcolor="#E074DD" class="menu_sel"><b>[<b>
          <?=$trabajos->cantidadInscriptoTL_estado("4");?>
        </b>]</b> <a href="?estado=4">Notificados</a></td>
        <td width="18%" height="30" align="center" valign="middle" bordercolor="#333333" bgcolor="#999999" class="menu_sel"><b>[<?=$trabajos->cantidadInscriptoTL_estado("3");?>] </b><a href="?estado=3">Rechazados</a></td>
        </tr>
    </table>
      <p align="center"><strong><font color="#666666" size="3" face="Trebuchet MS, Arial, Helvetica, sans-serif">Estado de trabajos </font></strong></p>
      <form method="post" name="form1" >
        <table width="650" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F0E6F0">
          <tr>
            <td width="113"><div align="left" id="divTitFiltro" class="borde_1_Iz_Der_arriba"><span class="textos"><strong>Filtrar y/o Buscar</strong></span></div></td>
            <td>
              <div align="right">
            <a href="estadisticasTL.php">Ver estadisticas de trabajos</a>            </div></td>
          </tr>
        </table>
        <div id="divFiltro" >
	    <table width="650" border="0" align="center" cellpadding="4" cellspacing="0">
	      <tr>
            <td width="94" class="borde_1_Iz"><div align="left" class="textos">Palabra/s</div></td>
	        <td colspan="3" class="borde_1_Der_arriba"><input name="filtroPalabraClave" type="text" class="botones" id="filtroPalabraClave" style="width:530;" value="<?=$Pclave?>"  onKeyPress="entsub('form1')"></td>
	        </tr>
	      <tr>
            <td class="borde_1_Iz"><div align="left" class="textos">Estado: </div></td>
	        <td colspan="3" class="borde_1_Der">
			
			
			<select name="filtroEstado" class="botones" id="filtroEstado"  style="width:530;">
                    <?
			switch ($_GET["estado"]) {
			
				case "cualquier":
					$sel_C = "selected";
					break;
				case 0:
					$sel_0 = "selected";
					break;
				case 1:
					$sel_1 = "selected";
					break;
					
				case 2:
					$sel_2 = "selected";
					break;
				case 3:
					$sel_3 = "selected";
					break;
				case 4:
					$sel_4 = "selected";
					break;
			}
			?>
		 	  <option value="cualquier" <?=$sel_C?>>Cualquier estado</option>
			  <option value="0" style="background-color:#FFCACA;" <?=$sel_0?>>No revisados y registros On-line</option>
		      <option value="1" style="background-color:#79DEFF;" <?=$sel_1?>>En revisi&oacute;n</option>
		      <option value="2" style="background-color:#82E180;" <?=$sel_2?>>Aprobados</option>
              <option value="4" style="background-color:#E074DD;" <?=$sel_4?>>Notificados</option>
		      <option value="3" style="background-color:#999999;" <?=$sel_3?>>Rechazados</option>
            </select>			</td>
	        </tr>

          <tr>
            <td class="borde_1_Iz"><div align="left" class="textos">Ubicados en: </div></td>
            <td colspan="3" class="borde_1_Der"><select name="filtroUbicado" class="botones" id="filtroUbicado" style="width:530;">
                <option value=""  style="background-color:#999999;" selected>Cualquiera</option>
                <?
			   	if($ubicado == "0"){
						$selUbi = "selected";
					}else{
						$selUbi = "";
					}
			   ?>
                <option value="0" style="background-color:#6666666;" <?=$selUbi?>>Ningun lado</option>
                <?
		
			    $sql ="SELECT * FROM congreso WHERE Trabajo_libre = '1' ORDER BY Casillero ASC;";
				$rs2 = mysql_query($sql,$con);
				while ($row2 = mysql_fetch_array($rs2)){
				
				
					if($row2["Casillero"] == $ubicado){
						$selUbi = "selected";
					}else{
						$selUbi = "";
					}
				
				
				
					echo "<option style='background-color:#6666666;' value='".$row2["Casillero"]."' $selUbi>" . $row2["Dia"] . " / " . $row2["Sala"] . " / "  . $row2["Hora_inicio"]  . " a " . $row2["Hora_fin"] . " / "  . $row2["Titulo_de_actividad"] . "</option>";
			    }
		
			?>
            </select></td>
            </tr>
          <tr>
            <td class="borde_1_Iz"><div align="left" class="textos">
              <div align="left" class="textos">Tipo de trabajo </div>
            </div></td>
            <td colspan="3" class="borde_1_Der"><select name="tipo" class="botones" id="tipo"  style="width:530;">
              <option value="" style="background-color:#999999;">Cualquiera</option>
			  <option value="Sin_tipo" style="background-color:#CCCCCC;" <? if($tipo=="Sin_tipo"){echo "selected";}?>>Sin tipo</option>
              <?
				
				$lista2 = $trabajos->tipoTL();
				while ($row2 = mysql_fetch_object($lista2)){
				
				if($row2->tipoTL == $tipo){
					$selTipo = "selected";
				}else{
					$selTipo = "";
				}
				?>
              <option value="<?=$row2->tipoTL ?>" <?=$selTipo?>>
              <?=$row2->tipoTL ?>
              </option>
              <?
				}
				?>
            </select></td>
            </tr>
          <tr>
            <td class="borde_1_Iz"><span class="textos">Congreso</span></td>
            <td colspan="3" class="borde_1_Der">
            	<select name="filtroCongreso" class="botones" style="width:530;">
                	<option value=""></option>
                	<option value="XXX Congreso Uruguayo de Pediatría" <?php if($filtroCongreso=="XXX Congreso Uruguayo de Pediatría"){echo "selected";} ?>>XXX Congreso Uruguayo de Pediatría</option>
              		<option value="I Congreso Integrado de Adolescencia" <?php if($filtroCongreso=="I Congreso Integrado de Adolescencia"){echo "selected";} ?>>I Congreso Integrado de Adolescencia</option>
              		<option value="VIII Jornadas del Pediatra Joven del Cono Sur" <?php if($filtroCongreso=="VIII Jornadas del Pediatra Joven del Cono Sur"){echo "selected";} ?>>VIII Jornadas del Pediatra Joven del Cono Sur</option>
                </select>
            </td>
          </tr>
          <tr>
            <td class="borde_1_Iz"><span class="textos">Por &aacute;rea</span></td>
            <td colspan="3" class="borde_1_Der"><select name="filtroArea" class="botones" id="filtroArea"  style="width:530;">
              <option value="" style="background-color:#999999;">Cualquiera</option>
			  <option value="Sin_area" style="background-color:#CCCCCC;" <? if($area=="Sin_area"){echo "selected";}?>>Sin &aacute;rea</option>
              <?
				$lista = $trabajos->areas();
	
				while($listas = mysql_fetch_object($lista)){
				
				if($listas->Area == $area){
					$selArea = "selected";
				}else{
					$selArea = "";
				}
				
				?>
              <option value="<?=$listas->id?>" <?=$selArea?>>
              <?=$listas->id." - ".$listas->Area?>
              </option>
              <?
				}
				?>
            </select></td>
          </tr>
          <tr>
            <td bgcolor="#EFEFE2" class="borde_1_Iz"><span class="textos">Idioma</span></td>
            <td colspan="3" bgcolor="#F7F7F0" class="borde_1_Der">
            <select name="filtroIdioma" class="botones" id="filtroIdioma"  style="width:530;">
              <option value="" style="background-color:#999999;">Cualquiera</option>
              <option value="Español" <? if($idioma=="Español"){echo "selected";} ?>>Español</option>
              <option value="Inglés" <? if($idioma=="Inglés"){echo "selected";} ?>>Inglés</option>
              <option value="Portugués" <? if($idioma=="Portugués"){echo "selected";} ?>>Portugués</option>
            </select>
            </td>
          </tr>
          <tr>
            <td bgcolor="#EFEFE2" class="borde_1_Iz"><div align="left" class="textos">
              <div align="left" class="textos">Trabajos con:</div>
              </div></td>
            <td colspan="3" bgcolor="#F7F7F0" class="borde_1_Der">
              <label style="cursor:pointer"><input name="filtroPresentador" type="radio" value="1" <? if($inscr=="1"){echo "checked";} ?>>
                <spam align="left" class="textos">Presentador Inscripto</spam></label>
              <label style="cursor:pointer"><input name="filtroPresentador" type="radio" value="0" <? if($inscr=="0"){echo "checked";} ?>>   		    <spam align="left" class="textos">Presentador <strong>No</strong> Inscripto</spam> </label>
              <label style="cursor:pointer"><input name="filtroPresentador" type="radio" value="todos"  <? if(($inscr=="todos")||($inscr=="")){echo "checked"; $inscr="todos";} ?>>
                <spam align="left" class="textos">Todos</spam> 
              </label><?=$ins?></td>
          </tr>
          <tr>
            <td class="borde_1_Iz"><div align="left" class="textos">
              <div align="left" class="textos">Premio:</div>
              </div></td>
            <td width="233" bgcolor="#F7F7F0" style="font-size:12px">Si <input type="radio" name="filtroPremio" value="Si" <? if($premio=="Si"){echo "checked";} ?>> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No
<input type="radio" name="filtroPremio" value="No" <? if($premio=="No"){echo "checked";} ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Todos <input type="radio" name="filtroPremio" value="" <? if($premio==""){echo "checked";} ?>></td>
            <td width="94" align="center" bgcolor="#F7F7F0" style="font-size:12px"><div align="left" class="textos">
              <div align="left" class="textos">Con adjunto:</div>
            </div></td>
            <td width="197" align="center" bgcolor="#F7F7F0" class="borde_1_Der" style="font-size:12px"><span style="font-size:12px"><span style="font-size:12px">Si
                  <input type="radio" name="filtroAdjunto" value="Si" <? if($adjunto=="Si"){echo "checked";} ?>>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No
<input type="radio" name="filtroAdjunto" value="No" <? if($adjunto=="No"){echo "checked";} ?>>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Todos
<input type="radio" name="filtroAdjunto" value="" <? if($adjunto==""){echo "checked";} ?>>
            </span></span></td>
          </tr>
          <tr>
            <td colspan="2" bgcolor="#F7F7F0" class="borde_1_Iz"  style="font-size:12px">
            	<select name="filtroCualPremio" style="width:320px">
                	<option value=""></option>
                    <option value="Premio Profesor Dr. Antonio Puigvert para el mejor trabajo de investigacion urologica (basica o clinica)" <? if($quePremio=="Premio Profesor Dr. Antonio Puigvert para el mejor trabajo de investigacion urologica (basica o clinica)"){echo "selected";} ?>>Premio Profesor Dr. Antonio Puigvert para el mejor trabajo de investigacion urologica (basica o clinica)</option>
                    <option value="Premio Frank A. Hughes para los mejores casos clinicos" <? if($quePremio=="Premio Frank A. Hughes para los mejores casos clinicos"){echo "selected";} ?>>Premio Frank A. Hughes para los mejores casos clinicos</option>
                    <option value="Premio Victor Politano imagenologia (poster)" <? if($quePremio=="Premio Victor Politano imagenologia (poster)"){echo "selected";} ?>>Premio Victor Politano imagenologia (poster)</option>
                    <option value="Premio Roberto Rocha Brito para el mejor video/DVD" <? if($quePremio=="Premio Roberto Rocha Brito para el mejor video/DVD"){echo "selected";} ?>>Premio Roberto Rocha Brito para el mejor video/DVD</option>
                </select>
            </td>
            <td bgcolor="#F7F7F0" style="font-size:12px"><div align="left" class="textos">
              <div align="left" class="textos">Dropbox:</div>
            </div></td>
            <td bgcolor="#F7F7F0"  class="borde_1_Der" style="font-size:12px">Si
                <input type="radio" name="filtroDropbox" value="1" <? if($dropbox=="1"){echo "checked";} ?>>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No
<input type="radio" name="filtroDropbox" value="0" <? if($dropbox=="0"){echo "checked";} ?>>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Todos
<input type="radio" name="filtroDropbox" value="" <? if($dropbox==""){echo "checked";} ?>>
            </td>
          </tr>
          <tr>
            <td bgcolor="#F7F7F0" class="borde_1_Iz"  style="font-size:12px">Adjunto PPT</td>
            <td bgcolor="#F7F7F0" style="font-size:12px">Si
              <input type="radio" name="filtroAdjuntoOral" value="Si" <? if($adjunto_oral=="Si"){echo "checked";} ?>>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No
<input type="radio" name="filtroAdjuntoOral" value="No" <? if($adjunto_oral=="No"){echo "checked";} ?>>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Todos
<input type="radio" name="filtroAdjuntoOral" value="" <? if($adjunto_oral==""){echo "checked";} ?>></td>
            <td bgcolor="#F7F7F0" style="font-size:12px"><span class="textos">Adjunto Poster:</span></td>
            <td bgcolor="#F7F7F0"  class="borde_1_Der" style="font-size:12px"><span style="font-size:12px">Si
                <input type="radio" name="filtroAdjuntoPoster" value="Si" <? if($adjunto_poster=="Si"){echo "checked";} ?>>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No
<input type="radio" name="filtroAdjuntoPoster" value="No" <? if($adjunto_poster=="No"){echo "checked";} ?>>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Todos
<input type="radio" name="filtroAdjuntoPoster" value="" <? if($adjunto_poster==""){echo "checked";} ?>>
            </span></td>
          </tr>
          <tr style="display:none">
            <td class="borde_1_Iz_abajo"><div align="left" class="textos">
              <div align="left" class="textos">Eliminados</div>
              </div></td>
            <td colspan="3" class="borde_1_Der_abajo" style="font-size:12px">Si <input type="radio" name="eliminado" value="1" <? if($eliminado==1){echo "checked";} ?>>  
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No
              <input type="radio" name="eliminado" value="0"  <? if(($eliminado==0) || ($eliminado=="")){echo "checked";} ?>></td>
          </tr>
          <tr>
            <td class="borde_1_Iz_abajo"><input name="filtroQuePremio" type="hidden"  value="">&nbsp;</td>
            <td colspan="3" class="borde_1_Der_abajo"><input name="filtrarBusqueda" type="button" class="botones" id="filtrarBusqueda"   onClick="filtrar(filtroEstado.value, filtroUbicado.value, filtroArea.value, tipo.value, filtroPalabraClave.value, getRadioButtonSelectedValue(filtroPresentador),getRadioButtonSelectedValue(filtroPremio),filtroCualPremio.value,filtroIdioma.value,getRadioButtonSelectedValue(filtroAdjunto),getRadioButtonSelectedValue(filtroAdjuntoPoster),getRadioButtonSelectedValue(filtroAdjuntoOral),getRadioButtonSelectedValue(eliminado),getRadioButtonSelectedValue(filtroDropbox),filtroCongreso.value)" value="Aceptar y filtrar y/o Buscar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="limpiar" type="button" class="botones"   onClick="resetear()" value="Limpiar campos"></td>
            </tr>
        </table>
</div>
	
		  <?
		  

//$lista = $trabajos->selectTL_estado($estado, $ubicado, $area, $tipo, $Pclave, $inscr, '', '');
//echo $lista;


          if($_GET["vacio"]!="true"){
 

$lista = $trabajos->selectTL_estado($estado, $ubicado, $filtroCongreso, $area, $tipo, $Pclave, $inscr,$premio,$quePremio, $idioma,$adjunto,$adjunto_poster, $adjunto_oral, $inicio, $TAMANO_PAGINA,$eliminado,$dropbox);
$num_total_registros = mysql_num_rows($lista);
if($inscr!="Todos"){
$TAMANO_PAGINA = 100;

	if ($pagina=="") { 
	////LE PUSE UNO SINO NO JUEGA
	////CAMBIAR EN EL TRABAJOSLIBRES.PHP
		$inicio = 0; 
		$pagina=1; 
	} 
	else { 
		$inicio = ($pagina - 1) * $TAMANO_PAGINA; 
		if($inicio==0){$inicio=0;}
	}


$total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);  
}	
	echo "<p class='textos' align='center'>";
	echo "N&uacute;mero de registros encontrados: <strong>" . $num_total_registros . ".</strong><br> "; 
	echo "Se muestran p&aacute;ginas de <strong>" . $TAMANO_PAGINA . " registros cada una. </strong><br> "; 
	echo "Mostrando la p&aacute;gina <strong>" . $pagina . " de " . $total_paginas . "</strong><br><br><font size='3'>"; 
	include("inc/paginador.inc.php");
}
?>
		  <center>
  <?
/////////-------------------------
if($_GET["vacio"]!="true"){
	if($num_total_registros>0){
?>
<div style="width:638px; height:16px; border:2px solid  #000000; padding:4px; margin:5px auto 0px auto;  background-color:#F7F7F0" class="textos"  align="left">
<div style="width:230px; float:left" align="left"><a href="javascript:marcar(true)">Marcar todos</a> / <a href="javascript:marcar(false)">Desmarcar todos</a></div><div style="width:180px; float:right" align="right">Con marca: <a href="#" onClick="eliminarVarios(<?=$estado?>)">Eliminar</a></div></div>
<?
echo $inicio." / ".$TAMANO_PAGINA;
		$lista = $trabajos->selectTL_estado($estado, $ubicado, $filtroCongreso, $area, $tipo, $Pclave, $inscr,$premio,$quePremio, $idioma,$adjunto,$adjunto_poster, $adjunto_oral, $inicio, $TAMANO_PAGINA,$eliminado,$dropbox);
		
	     //$lista = $trabajos->selectTL_estado($estado, $ubicado, $area, $tipo, $Pclave, $inscr);
		 $econtrados = 0;
		//echo mysql_num_rows($lista)."---";
		 while ($row = mysql_fetch_object($lista)){
			$econtrados = 1;
			 require "inc/trabajoLibre.inc.php";
			 
			 echo "<script>CuantosTL = CuantosTL + 1;</script>";
			 ob_flush();
			 flush();
		 }
	}
	if($num_total_registros>0){
		 ?>

<table width="650" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#000000" bgcolor="#F7F7F0" style="border:2px #000000 solid;">
  <tr>
    <td bordercolor="#F7F7F0" bgcolor="#F7F7F0" class="textos"><div align="left"><strong>Con marca : </strong></div></td>
    <td bordercolor="#F7F7F0" bgcolor="#F7F7F0" class="textos"><input name="Submit4" type="button" class="botones" value="Preparar env&iacute;o masivo de mails a los trabajos seleccionados" onClick="envioMailsFiltrados()" style="width:420px; background-color:#99CCCC"></td>
  </tr>
  <tr>
    <td width="95" bordercolor="#F7F7F0" bgcolor="#F7F7F0" class="textos"><div align="right">Mover a:&nbsp;&nbsp; </div></td>
    <td width="535" bordercolor="#F7F7F0" class="textos"><div align="left">
      <select name="moverA" class="botones" id="moverA"  style="width:420;">
        <?
			switch ($_GET["estado"]) {
			
				case 0:
					$sel_0 = "selected";
					break;
				case 1:
					$sel_1 = "selected";
					break;
					
				case 2:
					$sel_2 = "selected";
					break;
				case 3:
					$sel_3 = "selected";
					break;
				case 4:
					$sel_4 = "selected";
					break;
			}

			
			?>
        <option value="0" style="background-color:#FFCACA;" <?=$sel_0?>>No revisados y registros On-line</option>
        <option value="1" style="background-color:#79DEFF;" <?=$sel_1?>>En revisi&oacute;n</option>
        <option value="2" style="background-color:#82E180;" <?=$sel_2?>>Aprobados</option>
        <option value="4" style="background-color:#E074DD;" <?=$sel_4?>>Notificados</option>
        <option value="3" style="background-color:#999999;" <?=$sel_3?>>Rechazados</option>
      </select>
      <input name="Submit32" type="button" class="botones" value="Aceptar y mover" onClick="mover()"  style="width:100">
    </div></td>
  </tr>
  <tr>
    <td bordercolor="#F7F7F0" bgcolor="#F7F7F0" class="textos"><div align="right">Asignar tipo:&nbsp;&nbsp; </div></td>
    <?
			if( $_SESSION["tipoUsu"]==1){
			?>
    <td bordercolor="#F7F7F0" class="textos"><div align="left"><font color="#333333" size="2">
      <select name="tipo_de_TL" class="botones" id="tipo_de_TL"  style="width:420;">
      </select>
      </font>
            <input name="Submit3" type="button" class="botones" value="Aceptar y Asignar" onClick="asignarTipo(<?=$_GET["pagina"]?>)" style="width:100">
    </div></td>
    <?
			  }
			  ?>
  </tr>
  <tr>
    <td bordercolor="#F7F7F0" bgcolor="#F7F7F0" class="textos"><div align="right">Asignar area:&nbsp;&nbsp; </div></td>
    <?
			if( $_SESSION["tipoUsu"]==1){
			?>
    <td bordercolor="#F7F7F0" class="textos"><div align="left"><font color="#333333" size="2">
      <select name="area_" class="botones" id="area_"  style="width:420;">
			   <?
					$lista = $trabajos->areas();
		
					while($listas = mysql_fetch_object($lista)){
					
					if($listas->Area == $area){
						$selArea = "selected";
					}else{
						$selArea = "";
					}
				
				?>
              <option value="<?=$listas->id?>" <?=$selArea?>><?=$listas->id?> - <?=$listas->Area?></option>
              <?
					}
			  ?>
      </select>
      </font>
            <input name="Submit3" type="button" class="botones" value="Aceptar y Asignar" onClick="asignarArea(<?=$_GET["pagina"]?>)" style="width:100">
    </div></td>
    <?
			  }
			  ?>
  </tr>
  <tr>
    <td bordercolor="#F7F7F0" bgcolor="#F7F7F0" class="textos"><div align="right">Ubicar:&nbsp;&nbsp; </div></td>
    <?
			if( $_SESSION["tipoUsu"]==1){
			?>
    <td bordercolor="#F7F7F0" class="textos"><div align="left"><font color="#333333" size="2">
    <? if($_GET["a"]!="" && $_GET["e"]!=""){echo "Se ubicaron ".$_GET["a"]." de ".($_GET["a"]+$_GET["e"])." casilleros correctamente";} ?>
      <select name="ID_casillero" class="botones" id="select2"  style="width:420;">
        <option value=""  style="background-color:#999999; color:#FF0000;" selected>Sin Ubicaci&oacute;n</option>
        <?
				    $sql ="SELECT * FROM congreso WHERE Trabajo_libre = 1 ORDER BY Casillero ASC;";
					$rs = mysql_query($sql,$con);
					while ($row = mysql_fetch_array($rs)){

				  ?>
        <option value="<?=$row["Casillero"]?>">
          <?=$row["Dia"]?>
          /
          <?=$row["Sala"]?>
          /
          <?=substr($row["Hora_inicio"], 0, -3)?>
          a
          <?=substr($row["Hora_fin"], 0, -3)?>
          /
          <?=$row["Titulo_de_actividad"]?>
          </option>
        <?
					 }
					 ?>
      </select>
      </font>
            <input name="Submit3" type="button" class="botones" value="Aceptar y Ubicar" onClick="ubicar()" style="width:100">
    </div></td>
    <?
			  }
			  ?>
  </tr>
  <tr>
    <td colspan="2" bordercolor="#F7F7F0" bgcolor="#E4E4CD" class="textos"><a href="javascript:marcar(true)">Marcar todos</a> / <a href="javascript:marcar(false)">Desmarcar todos</a></td>
  </tr>
</table>
		 </center><? } ?>
          <br>
		
	<div align="center"><?  include("inc/paginador.inc.php"); ?></div>
      </form>
       </td>
  </tr>
</table>
<? }

	   
	   $_SESSION["paraImprimir"]=$imprimir;
	   
	   
	   ?>
	 
<script>

function resetear(){
	document.form1.filtroPalabraClave.value="";	
	document.form1.filtroEstado.value="cualquier";
	document.form1.filtroUbicado.value="";
	document.form1.tipo.value="";
	document.form1.filtroArea.value="";
	document.form1.filtroPresentador[2].checked=true;
	document.form1.filtroPremio[0].checked=false;
	document.form1.filtroPremio[1].checked=false;
	document.form1.filtroPremio[2].checked=true;
	document.form1.filtroAdjunto[0].checked=false;
	document.form1.filtroAdjunto[1].checked=false;
	document.form1.filtroAdjunto[2].checked=true;
	document.form1.filtroAdjuntoPoster[0].checked=false;
	document.form1.filtroAdjuntoPoster[1].checked=false;
	document.form1.filtroAdjuntoPoster[2].checked=true;
	document.form1.filtroAdjuntoOral[0].checked=false;
	document.form1.filtroAdjuntoOral[1].checked=false;
	document.form1.filtroAdjuntoOral[2].checked=true;
	
	document.form1.filtroDropbox[0].checked=false;
	document.form1.filtroDropbox[1].checked=false;
	document.form1.filtroDropbox[2].checked=true;
}

//llenarAreas();
llenarTipoTL();
abrirFiltro();

//mostrarContenido('mover')
</script>
