
<?
include('inc/sesion.inc.php');
include('conexion.php');

	$sql = "SELECT * FROM dias WHERE Dia='" . $_POST["dia_"] . "';";
	$rs = mysql_query($sql, $con);
	
	while ($row = mysql_fetch_array($rs)){
		$dia_orden_ = $row["Dia_orden"];
	}

	$sql = "SELECT * FROM salas WHERE Sala='" . $_POST["sala_"] . "';";
	$rs = mysql_query($sql, $con);
	while ($row = mysql_fetch_array($rs)){
		$sala_orden_ = $row["Sala_orden"];
	}
	
	$casillero_ = $dia_orden_ . $sala_orden_ . $_POST["hora_inicio_"];
	$casillero_ = str_replace(":","",$casillero_ );

?>

<form name="form1" method="post" action="altaCasilleroEnviar.php">
<input name="para_atras" type="hidden" value="<?=$_POST["para_atras"];?>">
<input name="seExpandira" type="hidden" value="<?=$_POST["seExpandira"];?>">
<input name="dia_" type="hidden" value="<?=$_POST["dia_"];?>">
<input name="sala_" type="hidden" value="<?=$_POST["sala_"];?>">

<input name="hora_inicio_" type="hidden" value="<?=$_POST["hora_inicio_"];?>">
<input name="hora_fin_" type="hidden" value="<?=$_POST["hora_fin_"];?>">
 

 
<input name="area_" type="hidden" value="<?=$_POST["area_"];?>">
<input name="tematica_" type="hidden" value="<?=$_POST["tematica_"];?>">
<input name="tipo_de_actividad_" type="hidden" value="<?=$_POST["tipo_de_actividad_"];?>">
<input name="titulo_de_actividad_" type="hidden" value="<?=$_POST["titulo_de_actividad_"];?>">

<input name="trabajo_libre_" type="hidden" value="<?=$_POST["trabajo_libre_"];?>"> 

 <input name="trabajo_1_" type="hidden" value="<?=$_POST["trabajo_1_"];?>">
 <input name="trabajo_2_" type="hidden" value="<?=$_POST["trabajo_2_"];?>">
 <input name="trabajo_3_" type="hidden" value="<?=$_POST["trabajo_3_"];?>">
 <input name="trabajo_4_" type="hidden" value="<?=$_POST["trabajo_4_"];?>">
 <input name="trabajo_5_" type="hidden" value="<?=$_POST["trabajo_5_"];?>">
 <input name="trabajo_6_" type="hidden" value="<?=$_POST["trabajo_6_"];?>">
 <input name="trabajo_7_" type="hidden" value="<?=$_POST["trabajo_7_"];?>">
 <input name="trabajo_8_" type="hidden" value="<?=$_POST["trabajo_8_"];?>">
 <input name="trabajo_9_" type="hidden" value="<?=$_POST["trabajo_9_"];?>">
 <input name="trabajo_10_" type="hidden" value="<?=$_POST["trabajo_10_"];?>">
 <input name="trabajo_11_" type="hidden" value="<?=$_POST["trabajo_11_"];?>">
 <input name="trabajo_12_" type="hidden" value="<?=$_POST["trabajo_12_"];?>">
 <input name="trabajo_13_" type="hidden" value="<?=$_POST["trabajo_13_"];?>">
 <input name="trabajo_14_" type="hidden" value="<?=$_POST["trabajo_14_"];?>">
 <input name="trabajo_15_" type="hidden" value="<?=$_POST["trabajo_15_"];?>">
 <input name="trabajo_16_" type="hidden" value="<?=$_POST["trabajo_16_"];?>">
 <input name="trabajo_17_" type="hidden" value="<?=$_POST["trabajo_17_"];?>">
 <input name="trabajo_18_" type="hidden" value="<?=$_POST["trabajo_18_"];?>">
 <input name="trabajo_19_" type="hidden" value="<?=$_POST["trabajo_19_"];?>">
 <input name="trabajo_20_" type="hidden" value="<?=$_POST["trabajo_20_"];?>">
 <input name="en_calidad_1_" type="hidden" value="<?=$_POST["en_calidad_1_"];?>">
 <input name="en_calidad_2_" type="hidden" value="<?=$_POST["en_calidad_2_"];?>">
 <input name="en_calidad_3_" type="hidden" value="<?=$_POST["en_calidad_3_"];?>">
 <input name="en_calidad_4_" type="hidden" value="<?=$_POST["en_calidad_4_"];?>">
 <input name="en_calidad_5_" type="hidden" value="<?=$_POST["en_calidad_5_"];?>">
 <input name="en_calidad_6_" type="hidden" value="<?=$_POST["en_calidad_6_"];?>">
 <input name="en_calidad_7_" type="hidden" value="<?=$_POST["en_calidad_7_"];?>">
 <input name="en_calidad_8_" type="hidden" value="<?=$_POST["en_calidad_8_"];?>">
 <input name="en_calidad_9_" type="hidden" value="<?=$_POST["en_calidad_9_"];?>">
 <input name="en_calidad_10_" type="hidden" value="<?=$_POST["en_calidad_10_"];?>">
 <input name="en_calidad_11_" type="hidden" value="<?=$_POST["en_calidad_11_"];?>">
 <input name="en_calidad_12_" type="hidden" value="<?=$_POST["en_calidad_12_"];?>">
 <input name="en_calidad_13_" type="hidden" value="<?=$_POST["en_calidad_13_"];?>">
 <input name="en_calidad_14_" type="hidden" value="<?=$_POST["en_calidad_14_"];?>">
 <input name="en_calidad_15_" type="hidden" value="<?=$_POST["en_calidad_15_"];?>">
 <input name="en_calidad_16_" type="hidden" value="<?=$_POST["en_calidad_16_"];?>">
 <input name="en_calidad_17_" type="hidden" value="<?=$_POST["en_calidad_17_"];?>">
 <input name="en_calidad_18_" type="hidden" value="<?=$_POST["en_calidad_18_"];?>">
 <input name="en_calidad_19_" type="hidden" value="<?=$_POST["en_calidad_19_"];?>">
 <input name="en_calidad_20_" type="hidden" value="<?=$_POST["en_calidad_20_"];?>">
 <input name="persona_1_" type="hidden" value="<?=$_POST["persona_1_"];?>">
 <input name="persona_2_" type="hidden" value="<?=$_POST["persona_2_"];?>">
 <input name="persona_3_" type="hidden" value="<?=$_POST["persona_3_"];?>">
 <input name="persona_4_" type="hidden" value="<?=$_POST["persona_4_"];?>">
 <input name="persona_5_" type="hidden" value="<?=$_POST["persona_5_"];?>">
 <input name="persona_6_" type="hidden" value="<?=$_POST["persona_6_"];?>">
 <input name="persona_7_" type="hidden" value="<?=$_POST["persona_7_"];?>">
 <input name="persona_8_" type="hidden" value="<?=$_POST["persona_8_"];?>">
 <input name="persona_9_" type="hidden" value="<?=$_POST["persona_9_"];?>">
 <input name="persona_10_" type="hidden" value="<?=$_POST["persona_10_"];?>">
 <input name="persona_11_" type="hidden" value="<?=$_POST["persona_11_"];?>">
 <input name="persona_12_" type="hidden" value="<?=$_POST["persona_12_"];?>">
 <input name="persona_13_" type="hidden" value="<?=$_POST["persona_13_"];?>">
 <input name="persona_14_" type="hidden" value="<?=$_POST["persona_14_"];?>">
 <input name="persona_15_" type="hidden" value="<?=$_POST["persona_15_"];?>">
 <input name="persona_16_" type="hidden" value="<?=$_POST["persona_16_"];?>">
 <input name="persona_17_" type="hidden" value="<?=$_POST["persona_17_"];?>">
 <input name="persona_18_" type="hidden" value="<?=$_POST["persona_18_"];?>">
 <input name="persona_19_" type="hidden" value="<?=$_POST["persona_19_"];?>">
 <input name="persona_20_" type="hidden" value="<?=$_POST["persona_20_"];?>">
 
<input name="en_crono_1_" type="hidden" value="<?=$_POST["en_crono_1_"];?>">
<input name="en_crono_2_" type="hidden" value="<?=$_POST["en_crono_2_"];?>">
<input name="en_crono_3_" type="hidden" value="<?=$_POST["en_crono_3_"];?>">
<input name="en_crono_4_" type="hidden" value="<?=$_POST["en_crono_4_"];?>">
<input name="en_crono_5_" type="hidden" value="<?=$_POST["en_crono_5_"];?>">
<input name="en_crono_6_" type="hidden" value="<?=$_POST["en_crono_6_"];?>">
<input name="en_crono_7_" type="hidden" value="<?=$_POST["en_crono_7_"];?>">
<input name="en_crono_8_" type="hidden" value="<?=$_POST["en_crono_8_"];?>">
<input name="en_crono_9_" type="hidden" value="<?=$_POST["en_crono_9_"];?>">
<input name="en_crono_10_" type="hidden" value="<?=$_POST["en_crono_10_"];?>">
<input name="en_crono_11_" type="hidden" value="<?=$_POST["en_crono_11_"];?>">
<input name="en_crono_12_" type="hidden" value="<?=$_POST["en_crono_12_"];?>">
<input name="en_crono_13_" type="hidden" value="<?=$_POST["en_crono_13_"];?>">
<input name="en_crono_14_" type="hidden" value="<?=$_POST["en_crono_14_"];?>">
<input name="en_crono_15_" type="hidden" value="<?=$_POST["en_crono_15_"];?>">
<input name="en_crono_16_" type="hidden" value="<?=$_POST["en_crono_16_"];?>">
<input name="en_crono_17_" type="hidden" value="<?=$_POST["en_crono_17_"];?>">
<input name="en_crono_18_" type="hidden" value="<?=$_POST["en_crono_18_"];?>">
<input name="en_crono_19_" type="hidden" value="<?=$_POST["en_crono_19_"];?>">
<input name="en_crono_20_" type="hidden" value="<?=$_POST["en_crono_20_"];?>">
 
<input name="seLlamara_tex" type="hidden" value="<?=$_POST["seLlamara_tex"];?>">
<input name="seLlamara_com" type="hidden" value="<?=$_POST["seLlamara_com"];?>">
 
<input name="dia_viejo" type="hidden" value="<?=$_POST["dia_"];?>">
<input name="sala_viejo" type="hidden" value="<?=$_POST["sala_"];?>">

</form>


<?
$modificar = 0;
$sql = "SELECT Casillero FROM congreso WHERE Casillero ='" . $casillero_ . "';";
$rs = mysql_query($sql, $con);
	while ($row = mysql_fetch_array($rs)){
		$modificar = 1;
		if($row["Casillero"]==$_POST["casillero"]){
			$sql = "DELETE FROM congreso WHERE Casillero = '" . $_POST["casillero"] . "';";
			mysql_query($sql, $con);
	}
}

if($modificar == 0){
		$sql_tl = "UPDATE trabajos_libres SET ID_casillero = '". $casillero_ ."'  WHERE ID_casillero = '" .$_POST["casillero"] ."';" ;
		mysql_query($sql_tl, $con);

	$sql = "DELETE FROM congreso WHERE Casillero = '" . $_POST["casillero"] . "';";
	mysql_query($sql, $con);
}

?>

<body onLoad="enviar()"></body>

<script language="javascript">
	function enviar(){
		form1.submit();
	}
</script>