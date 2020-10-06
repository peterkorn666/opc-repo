<?php
global $tpl;
$util = $tpl->getVar('util');
//$util->isLogged();
$core = $tpl->getVar('core');
$templates = $tpl->getVar('templates');
$config = $tpl->getVar('config');
$debug = $tpl->getVar('debug');
$core->Debug($debug);
$sqlCronoDias = $core->query("SELECT DISTINCT(SUBSTRING(start_date,1,10)) as start_date FROM cronograma ORDER BY SUBSTRING(start_date,1,10),section_id,start_date ASC");
//GET
$get = $_GET;

//def variables
$dia_ = "";
$sala_ = "";

if($get["day"])
	$toDay = $get["day"];
else{
	$sqlPrimerDia = $core->row("SELECT * FROM cronograma ORDER BY start_date LIMIT 1");
	$toDay = substr($sqlPrimerDia["start_date"],0,10);
}

//DEFINE HEADERS
$headers = array(
	"estilos/programaExtendido.css"=>"css",
	"js/programaTL.js"=>"js"
);
$tpl->SetVar('headers',$headers);
$html = "";
$h = 0;
//MOSTRAR TODOS LOS DAIS
$sqlDias = $core->query("SELECT start_date,end_date,section_id FROM cronograma GROUP BY SUBSTRING(start_date,1,10) ORDER BY SUBSTRING(start_date,1,10) ASC");
echo "<div id='container_dias'>";
foreach($sqlDias as $key => $dias)
{
	if(!$key)
		$primerDia = $core->helperDate($dias["start_date"],0,10);
	if($_GET["day"]==$core->helperDate($dias["start_date"],0,10) || (empty($_GET["day"]) && $h==0))
		$chk = "day_selected";			
	echo "<div class='dias_cronograma'><a href='?page=programaExtendido&day=".$core->helperDate($dias["start_date"],0,10)."' class='$chk'>".utf8_encode(strftime($config["time_format"],strtotime($core->helperDate($dias["start_date"],0,10))))."</a></div>";
	$chk = "";
	++$h;
}
echo "</div>";
//MOSTRAR SALAS HABILITADAS
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
	echo "<div class='salas_cronograma'><a href='?page=programaExtendido&day=".$toDay."&section=".$salas["section_id"]."' class='$chk'>".$salas["name"]."</a></div>";
	$chk = "";
	++$h;
	
}
echo "</div>";


$filtr_dia = ($toDay?$toDay:0);
$filtr_sala = ($get["section"]?$get["section"]:0);
$sqlActividades = $core->getTiposActividades();
/*echo "<div class='row'>";
echo "<div class='col-xs-6 col-xs-offset-3'>";
echo "<select name='tipo_actividad' onChange=\"filterPrograma('$filtr_dia',$filtr_sala)\" class='form-control input-sm'>";
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
echo "</div>";*/

/*if($filtr_dia || $filtr_sala || $get["actividad"])
	echo "<p align='center'><a href='?page=programaExtendido'>Limpiar Filtros</a></p>";*/

$infoCrono = $core->getCronoByDaySala($toDay,$get["section"],$get["actividad"]);
$helper = 0;
foreach($infoCrono as $crono):
	
	$templates->programaExtendido($crono, $dia_, $sala_, $helper, true);
	
	$dia_ = $core->helperDate($crono["start_date"],0,10);
	$sala_ = $crono['section_id'];
	$helper++;
endforeach;
?>