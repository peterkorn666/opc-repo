<?
include ('inc/sesion.inc.php');
include ('inc/config_idioma.inc.php');
include('conexion.php');
include('envioMail_Config.php');


$sql = "SELECT nombre_congreso, email_congreso FROM config LIMIT 1";
$rs = mysql_query($sql, $con);
while($row=mysql_fetch_array($rs)){
	$congreso = $row["nombre_congreso"];

}

$qsEs = "?idioma=es";
$txtEs = "<img border='0' src='img/es.png' />";
$qsIng = "?idioma=ing";
$txtIng = "<img border='0' src='img/gb.png' />";


?>
<?
if ($_GET["idioma"]=="ing"){
	$imgCrono = "opc_cronograma_ing.gif";
	$bordeAbajoCrono = 'style="border-bottom:#FFFFFF 2px solid"';
}else{
	$imgCrono = "opc_cronograma.gif";
	$bordeAbajoCrono = 'style="border-bottom:#FFFFFF 2px solid"';
}
if ($_GET["idioma"]=="ing"){
	$imgPrgo = "opc_programa_ing.gif";
	$bordeAbajoProg = 'style="border-bottom:#FFFFFF 2px solid"';
}else{
	$imgPrgo = "opc_programa.gif";
	$bordeAbajoProg = 'style="border-bottom:#FFFFFF 2px solid"';
}
if ($_GET["idioma"]=="ing"){
	$imgCoor = "opc_conf_ing.gif";
	$bordeAbajoList= 'style="border-bottom:#FFFFFF 2px solid"';
}else{
	$imgCoor = "opc_conf.gif";
	$bordeAbajoList= 'style="border-bottom:#FFFFFF 2px solid"';
}
if ($_GET["idioma"]=="ing"){
	$imgMenu = "opc_menu_ing.gif";
	$bordeAbajoMenu= 'style="border-bottom:#FFFFFF 2px solid"';
}else{
	$imgMenu = "opc_menu.gif";
	$bordeAbajoMenu= 'style="border-bottom:#FFFFFF 2px solid"';
}

$bordeAbajoCrono = '';
$bordeAbajoMenu= '';
$bordeAbajoList= '';
$bordeAbajoProg = '';

?>
<link href="estilos.css" rel="stylesheet" type="text/css">
<script>


	function dire(cual){
		document.location.href = cual;
	}
	function buscaTL(que){
		document.location.href = "estadoTL.php?estado=cualquier&ubicado=&area=&tipo=&clave=" + que;
	}

</script>
<style type="text/css">
	#DivDiasCrono {
		position:absolute;
		left:100px;
		top:48px;
		/*width:214px;
        height:147px;*/
		z-index:500;
		display:none;
	}
</style>
<script src="js/jquery-1.2.2.js" language="javascript" type="text/javascript"></script>
<script src="js/menuEdicion.js" language="javascript" type="text/javascript"></script>
<script src="js/ajax.js" language="javascript" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function (){
		achicarBarras()
		$("#DivMenu").mouseover(function (){
			$("#DivMenu").animate({top:5}, "normal");
			setTimeout("OcultarMenu()",3000);
		});
		/*$("#DivMenu").mouseout(function (){
		 $("#DivMenu").animate({top:22}, "fast");
		 });*/
		/*$("body").onload(function a(){achicarBarras()}); 
		 */
	});
	function OcultarMenu(){
		$("#DivMenu").animate({top:22}, "normal");
	}
	function achicarBarras(){

		$("#DivMail").fadeOut("fast");
		$("#DivBuscar").fadeOut("fast");
		$("#DivOtro").fadeOut("fast");
		$("#DiVExcel").fadeOut("fast");


		$("#DivMail").fadeIn("slow");
		$("#DivBuscar").fadeIn("slow");
		$("#DivOtro").fadeIn("slow");
		$("#DiVExcel").fadeIn("slow");

	}
</script>
<link href="estiloBordes.css" rel="stylesheet" type="text/css">
<style type="text/css">
	<!--
	#Layer1 {
		position:absolute;
		left:733px;
		top:15px;
		width:67px;
		height:35px;
		z-index:3;
	}
	#Layer2 {
		position:absolute;
		left:111px;
		top:54px;
		width:57px;
		height:37px;
		z-index:4;
	}
	-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?
//include "inc/vinculos.inc.php";?>
<center>
	<div style="margin:auto"><br><br>

		<?
		$sql = "SELECT * FROM dias ORDER BY Dia_orden ASC";
		$rs = mysql_query($sql, $con);
		while($row=mysql_fetch_array($rs)){
			if($_GET["idioma"]=="ing"){?>
			<a href="cronograma.php?idioma=ing&dia_=<?=$row["Dia_orden"]?>" style="color:#000; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:12px; text-decoration:none; background:url(img/dias.png); background-repeat:repeat-x; text-align:center; padding-top:3px; padding-bottom:3px" onMouseOver="this.style.color='#666'" onMouseOut="this.style.color='#000'">&nbsp;&nbsp;<?=$row["Dia_ing"]?>&nbsp;&nbsp;</a><? }else{?>
				<a href="cronograma.php?dia_=<?=$row["Dia_orden"]?>" style="color:#000; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:12px; text-decoration:none; background:url(img/dias.png); background-repeat:repeat-x; text-align:center; padding-top:3px; padding-bottom:3px" onMouseOver="this.style.color='#666'" onMouseOut="this.style.color='#000'">&nbsp;&nbsp;<?=$row["Dia"]?>&nbsp;&nbsp;</a>
			<? }
		}?>
	</div>
	<br>
	<br>
	<a href="<?=$qsEs?>" style="text-decoration:none;font-size: 10px; color:#FFFFFF; font-family:Arial, Helvetica, sans-serif"><?=$txtEs?></a>&nbsp;&nbsp;
	<a href="<?=$qsIng?>" style="text-decoration:none;font-size: 10px; color:#FFFFFF; font-family:Arial, Helvetica, sans-serif"><?=$txtIng?></a>
</center>
<center>
	<?
	if($_SESSION["tipoUsu"]==1 || $_SESSION["tipoUsu"]==4){
		?>
		<?
	}


	?>

	<div style="width:745px; z-index:0; position:relative; top:22px; height:28px; display:block;" align="left" id="DivMenu">
		<!--<a href='cronograma.php?dia_=<?=$dia_?>&idioma=<?=$_GET["idioma"]?>'><img id="IMGcrono" src="img/<?=$imgCrono?>" width="86" height="28" border="0" <? // onMouseOver="MostrarDivCrono()"?>/></a>-->
		<a href='programaExtendido.php?dia_=<?=$dia_?>&idioma=<?=$_GET["idioma"]?>'><img id="IMGProg" src="img/<?=$imgPrgo?>" width="131" height="28" border="0" style="z-index:0" /></a>
		<a href='listadoParticipantes.php?idioma=<?=$_GET["idioma"]?>'><img id="IMGConf" src="img/<?=$imgCoor?>" width="91" height="28" border="0" /></a>
	</div>
	<table id="fondo"  border="0" cellspacing="0" cellpadding="0" align="center" style=" z-index:100;position:relative; " >
		<tr>
			<td align="center"><div id="BordeMenu">
					<div id="DivOtro">
						<div id="divContenidoPanel">
							<? if  ($_SESSION["tipoUsu"]==1) {?>
							<strong><?=$ingresar_modificar__?></strong>
							<ul>
								<li><a href="seleccionar_panel.php?idioma=<?=$_GET["idioma"]?>"><?=$esquema__?></a></li>
								<li><a href="../admin"><?=$actividad_casillero__?></a></li>
								<li><a href="../?page=conferencistasManager"><?=$actividades__?>
										<img src="img/conferencistas.png" width="23" height="20" border="0"></a></li>
								<li>&nbsp;</li>
								<li><a href="altaTrabajosLibres.php?idioma=<?=$_GET["idioma"]?>"><?=$trabajos__?></a> </li>
								<li><a href="altaPersonasTL.php?idioma=<?=$_GET["idioma"]?>"><?=$autores__?></a> </li>
								<? } ?>
							</ul>
						</div>
					</div>
					<div id="DivBuscar">
						<div id="divContenidoPanel">
							<form name="form2" method="post" action="buscar.php">
								<table width="305" border="0" align="center" cellpadding="1" cellspacing="1">
									<tr>
										<td width="146"><label>
												<input type="text" name="buscar_">
											</label></td>
										<td width="145" > <input name="Submit" type="submit" class="botones" value="<?=$txt_buscar_con__?>" style="width:100%"></td>
									</tr>
									<tr>
										<td><input type="text" name="txtBuscaCongreso"></td>
										<td> <input name="Submit" type="button" class="botones" value="<?=$txt_buscar_tra__?>" onClick="buscaTL(txtBuscaCongreso.value)" style="width:100%"></td>
									</tr>
								</table>
							</form>
							<br>
							<ul>
								<? if  ($_SESSION["tipoUsu"]==1) {?>
									<li><a href="buscar_avanzada.php?idioma=<?=$_GET["idioma"]?>"><?=$busqueda_avanzada_congreso__?></a></li>
								<? } ?>
								<li><a href="estadoTL.php?idioma=<?=$_GET["idioma"]?>&estado=cualquier&vacio=true"><?=$busqueda_avanzada_trabajos__?></a></li>
								<li><a href="estadisticasTL.php?idioma=<?=$_GET["idioma"]?>"><?=$estadisticas__?>
										<img src="img/estadistica.png" width="23" height="26" border="0"></a></li>
							</ul>
						</div>
					</div>


					<div id="DivMail">
						<?
						if($_SESSION["tipoUsu"]==1){
							?>
							<div id="divContenidoPanel" >
								</strong>
								<div style="float:right;text-align:right">
									<? if ($_SESSION["tipoUsu"]==1) {?>
										<a href="altaCartaPersonalizada.php"><?=$cartas_predefinidas_?><br>
											<img src="img/carta_nueva.png" width="32" height="32" border="0"></a>
									<?  } ?></div>
								<br>
								<strong><?=$mail_masivo__?>
									<ul>
										<li><a href="envioMail_trabajosLibres.php"><?=$contacto_tls__?></a></li>
										<li><a href="envioMail_Autores_trabajosLibres.php"><?=$autores_tls__?></a></li>
										<li><a href="envioMail_listadoParticipantes.php"><?=$conf_coord__?></a></li>
										<li><a href="verMailsEnviadosTL.php" target="_blank">Ver mail enviados de trabajos</a></li>
										<!--<li><a href="envioMail_listadoInscriptos.php"><?=$inscriptos__?></a></li>-->
									</ul>
							</div>
							<?
						}
						?>
					</div>


					<div id="DiVExcel">
						<div id="divContenidoPanel">

							<strong><?=$excel__?></strong>
							<ul>
								<li><a href="todoslostrabajosXLS.php"><?=$listado_trabajos__?></a></li>
								<li><a href="todoslosautoresXLS.php"><?=$listado_autores__?></a></li>
								<li><a href="todosencongresoXLS.php"><?=$listado_congreso__?></a></li>
								<li><a href="todaslaspersonasXLS.php"><?=$listado_inscriptos__?></a></li>
							</ul>
						</div>
					</div>



				</div></td>
		</tr>
	</table>
	<div id="DivDiasCrono"></div>
	<div align="right" style="width:750px">
		<div style="float:left; width:250px" align="left" ><a href="seleccionar_panel_simple.php?idioma=es" class="linkIndice"><em>Español</em></a> <font color="#990000"><em><strong>|</strong></em></font> <a  href="seleccionar_panel_simple.php?idioma=ing" class="linkIndice"><em>English</em></a></div>
		<div style="float:right; width:350px" align="right" >
			<? if ($_SESSION["tipoUsu"]==1) { ?>
				<a href="seleccionar_panel.php" class="linkIndice"><em><?=$menu_tradicional__?></em></a>
			<? } ?>
		</div>
	</div>

	<div align="center" style="clear:both"><img src="img/logo.png" alt="OPC+ // OPC para OPC"  align="absmiddle" longdesc="GEGA | editorial | web | multimedia"><br>
		<font color="#FFFFFF" >
			V.5 &Beta;</font>  </div>

	</div>
</center>



