<script language="JavaScript">
	function mOvr_m(src) {
	
		if (!src.contains(event.fromElement)) {
		 src.style.cursor = 'hand';
		 src.bgColor = 'ffffff';
		}
	 }

	 function mOut_m(src) {
	 
		if (!src.contains(event.toElement)) {
		 src.style.cursor = 'default';
		 src.bgColor = 'cccccc';
		}
	 }

	 function mClk_m(src) {
		 document.location.href = src;
	 }

</script>

<link href="estilos.css" rel="stylesheet" type="text/css">
<link href="menu.css" rel="stylesheet" type="text/css">

<form name="form2" method="post" action="buscar.php" style="display:inline;">
<?
if($imgCronoActivo==1){
	$imgCrono = "crono_activo";
}else{
	$imgCrono = "crono_normal";
}
if($imgPrgoActivo==1){
	$imgPrgo = "programa_activo";
}else{
	$imgPrgo = "programa_normal";
}
if($imgCoorActivo==1){
	$imgCoor = "conf_activo";
}else{
	$imgCoor = "conf_normal";
}
if($imgMenuActivo==1){
	$imgMenu = "menu_activo";
}else{
	$imgMenu = "menu_normal";
}




$sql = "SELECT nombre_congreso, mail_contacto FROM config LIMIT 1";
$rs = mysql_query($sql, $con);
while($row=mysql_fetch_array($rs)){$congreso = $row["nombre_congreso"]; $mail_contacto = $row["mail_contacto"];}
?>

<div id="menu_superior">

	<div id="titulosuperior"><h1><?=$congreso;?></h1></div>
    <div id="bt_imprimir">
     <?
	if($sePuedeImprimir==true){
	?>
    	<a href="HojaDeImpresion.php" target="_blank">
        <img src="img/ico_imprimir.gif" width="58" height="18" border="0" /></a>
    <?
	}
	?>
    
    </div>
    </div>
    
 <div id="menu_medio">
 	<div id="menu_login">
 	<a href="login.php" class="menu_ses">
    <img src="img/llave.gif" alt="Login" width="20" height="10" border="0" />
	<? if ($_SESSION["registrado"]==false){?>
    &lt;&lt;  Iniciar Sesión
	   <? 
	   } 
	   ?>
 </a>
<? 
if ($_SESSION["registrado"]==true){ 
	echo '<font color="#FFFFCC"  style="font-size: 9px">&nbsp;</font><font  style="font-size: 11px"><span class="Estilo5">Usuario: <b>'.$_SESSION["usuario"].'</b></span><b>    </b></font><font  style="font-size: 10px" color="#999999">&nbsp;|&nbsp;</font>&nbsp;<a href="cerrar_session.php" class="menu_ses" style="font-size: 10px">Cerrar sesi&oacute;n&nbsp;&nbsp;</a>';
} ?>

</div>

<div id="menu_visitas"><? include ('inc/contador.inc.php');?>     </div>
</div>

<div id="menu_inferior">
	<div id="botones">
    <ul>
		<li id="<?=$imgMenu?>"><a href='seleccionar_panel_simple.php'><span>Menú</span></a></li>
    	<li id="<?=$imgCrono?>"><a href='cronograma.php?dia_=<?=$dia_?>' ><span>Cronograma</span></a></li>
    	<li id="<?=$imgPrgo?>"><a href='programaExtendido.php?dia_=<?=$dia_?>' ><span>Programa extendido</span></a></li>
   		<li id="<?=$imgCoor?>"><a href='listadoParticipantes.php'><span>Conf./Coord.</span></a></li>
        </ul>
	</div>

	<div id="buscar_menu">
                <input name="buscar_" type="text" id="buscar_"  />
                &nbsp;
                <input name="Submit" type="submit" value="Buscar" id="bt_buscar">
   </div>
</div>
    
</form>
<script>document.form2.buscar_.focus();</script>