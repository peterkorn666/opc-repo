<?php
session_start();
require("../class/util.class.php");
$util = new Util();
$util->isLogged();
require("../class/core.php");
require("../class/templates.opc.php");
$core = new Core();
$config = $core->getConfig();
$templates = new templateOPC();
if($_GET['action']=='download' and $_GET['type']=='ms'){
	header("Content-type: application/vnd.ms-word");
	header("Content-Disposition: attachment;Filename=".str_replace(" ","_",$config['nombre_congreso'])."_Programa_Extendido.doc"); 
}else if($_GET['action']=='download' and $_GET['type']=='oa'){
	header("Content-type: application/vnd.oasis.opendocument.text");
	header("Content-Disposition: attachment;Filename=".str_replace(" ","_",$config['nombre_congreso'])."_Programa_Extendido.odt");
}

$sqlCronoDias = $core->query("SELECT DISTINCT(SUBSTRING(start_date,1,10)) as start_date FROM cronograma ORDER BY SUBSTRING(start_date,1,10),section_id,start_date ASC");
//GET
$get = $_GET;

//def variables
$dia_ = "";
$sala_ = "";

if($get["day"])
	$toDay = $get["day"];
else{
	/*$sqlPrimerDia = $core->row("SELECT * FROM cronograma ORDER BY start_date LIMIT 1");
	$toDay = substr($sqlPrimerDia["start_date"],0,10);*/
	$toDay = "";
}
$html = "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $config['nombre_congreso'] ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $config['url_opc'] ?>/estilos/programaExtendidoImp.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $config['url_opc'] ?>/bootstrap/css/bootstrap.min.css"/>
</head>
<body>
<?php
if($_GET['action']!='download'){
	echo '<p align="center"><a href="?action=download&type=ms&day='.$_GET['day'].'&section='.$_GET['section'].'">DESCARGAR EN FORMATO WORD</a></p>';
	echo '<p align="center"><a href="?action=download&type=oa&day='.$_GET['day'].'&section='.$_GET['section'].'">DESCARGAR EN FORMATO OPEN OFFICE</a></p>';
	//MOSTRAR TODOS LOS DAIS
	$sqlDias = $core->query("SELECT start_date,end_date,section_id FROM cronograma GROUP BY SUBSTRING(start_date,1,10) ORDER BY SUBSTRING(start_date,1,10) ASC");
	echo "<div id='container_dias'>";
	$h = 0;
	foreach($sqlDias as $key => $dias)
	{
		if(!$key)
			$primerDia = $core->helperDate($dias["start_date"],0,10);
		if($_GET["day"]==$core->helperDate($dias["start_date"],0,10) || (empty($_GET["day"]) && $h==0))
			$chk = "day_selected";
		echo "<div class='dias_cronograma'><a class='$chk' href='?day=".$core->helperDate($dias["start_date"],0,10)."'>".utf8_encode(strftime($config["time_format"],strtotime($core->helperDate($dias["start_date"],0,10))))."</a></div>";
		$chk = "";
		++$h;
	}

	echo "</div>";
	if($toDay)
		$where_sala = "WHERE SUBSTRING(start_date,1,10)='".$toDay."'";
	else
		$where_sala = "";
	$sqlSalas = $core->query("SELECT c.start_date,c.end_date,c.section_id,s.salaid,s.name,s.orden FROM cronograma as c JOIN salas as s ON c.section_id=s.salaid $where_sala GROUP BY c.section_id ORDER BY s.orden+0 ASC");
	echo "<div id='container_salas'>";
	$h = 0;
	foreach($sqlSalas as $key => $salas)
	{
		if(!$key)
			$primerSala = $salas["section_id"];
		if($_GET["section"]==$salas["section_id"] || (empty($_GET["section"]) && $h==0))
			$chk = "sala_selected";
		echo "<div class='salas_cronograma'><a class='$chk' href='?day=".$toDay."&section=".$salas["section_id"]."'>".$salas["name"]."</a></div>";
		$chk = "";
		++$h;
	}
	echo "</div>";

	$filtr_dia = ($toDay?$toDay:0);
	$filtr_sala = ($get["section"]?$get["section"]:0);
	$sqlActividades = $core->getTiposActividades();
	echo "<div class='row'>";
	echo "<div class='col-xs-6 col-xs-offset-3'>";
	echo "<select name='tipo_actividad' onChange=\"filterProgramaImp('$filtr_dia',$filtr_sala)\" class='form-control input-sm'>";
	echo "<option value=''></option>";
	foreach($sqlActividades as $actividad)
	{
		if($get["actividad"]==$actividad["id_tipo_actividad"])
			$slc = "selected";
		echo "<option value='".$actividad["id_tipo_actividad"]."' $slc style='background-color:".$actividad["color_actividad"]."'>".$actividad["tipo_actividad"]."</option>";
		$slc = "";
	}
	echo "</select>";
	echo "</div>";
	echo "</div>";

	if($filtr_dia || $filtr_sala || $get["actividad"])
		echo "<p align='center'><a href='?page=programaExtendidoImp'>Limpiar Filtros</a></p>";
}



$infoCrono = $core->getCronoByDaySala($toDay,$get["section"],$get["actividad"]);
$helper = 0;
foreach($infoCrono as $crono):
	
	$templates->programaExtendido($crono,$dia_,$sala_,$helper);
	
	$dia_ = $core->helperDate($crono["start_date"],0,10);
	$sala_ = $crono['section_id'];
	$helper++;
endforeach;
?>
</body>
</html>
<script type="text/javascript" src="../js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../js/programaTL.js"></script>