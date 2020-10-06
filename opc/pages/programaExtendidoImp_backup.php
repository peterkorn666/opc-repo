<?php
session_start();
require("../class/util.class.php");
$util = new Util();
//$util->isLogged();
$imp = true;
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
else
	$toDay = "";
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
<div align="center">
<img src="<?php echo $config['banner_congreso'] ?>" width="500" />
</div>
<?php
if($_GET['action']!='download'){
	echo '<p align="center"><a href="?action=download&type=ms&day='.$_GET['day'].'&section='.$_GET['section'].'">DESCARGAR EN FORMATO WORD</a></p>';
	echo '<p align="center"><a href="?action=download&type=oa&day='.$_GET['day'].'&section='.$_GET['section'].'">DESCARGAR EN FORMATO OPEN OFFICE</a></p>';
	//MOSTRAR TODOS LOS DAIS
	$sqlDias = $core->query("SELECT start_date,end_date,section_id FROM cronograma GROUP BY SUBSTRING(start_date,1,10) ORDER BY SUBSTRING(start_date,1,10) ASC");
	echo "<div id='container_dias'>";
	foreach($sqlDias as $key => $dias)
	{
		if(!$key)
			$primerDia = $core->helperDate($dias["start_date"],0,10);
		echo "<div class='dias_cronograma'><a href='?day=".$core->helperDate($dias["start_date"],0,10)."'>".utf8_encode(strftime($config["time_format"],strtotime($core->helperDate($dias["start_date"],0,10))))."</a></div>";
	}
	echo "</div>";
	//MOSTRAR SALAS HABILITADAS
	if($toDay)
		$where_sala = "WHERE SUBSTRING(start_date,1,10)='".$toDay."'";
	else
		$where_sala = "";
	$sqlSalas = $core->query("SELECT c.start_date,c.end_date,c.section_id,s.salaid,s.name,s.orden FROM cronograma as c JOIN salas as s ON c.section_id=s.salaid $where_sala GROUP BY c.section_id ORDER BY s.orden+0 ASC");
	echo "<div id='container_salas'>";
	foreach($sqlSalas as $key => $salas)
	{
		if(!$key)
			$primerSala = $salas["section_id"];
		echo "<div class='salas_cronograma'><a href='?day=".$get["day"]."&section=".$salas["section_id"]."'>".$salas["name"]."</a></div>";
	}
	echo "</div>";
	
	if($_GET['day'] || $_GET['section'])
		echo '<p align="center"><a href="programaExtendidoImp.php">LIMPIAR FILTRO</a></p>';
}
$infoCrono = $core->getCronoByDaySala($get["day"],$get["section"]);
$helper = 0;
foreach($infoCrono as $crono):
	$showUbicacion = true;
	if(substr($crono["start_date"],0,10)==$day_crono_viejo)
		$showUbicacion = false;
	$templates->programaExtendido($crono,$dia_,$sala_,$helper);
	$day_crono_viejo = substr($crono["start_date"],0,10);
	
	$dia_ = $core->helperDate($crono["start_date"],0,10);
	$sala_ = $crono['section_id'];
	$helper++;
endforeach;
?>
</body>
</html>