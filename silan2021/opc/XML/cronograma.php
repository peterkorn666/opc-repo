<?php
require("../class/core.php");
require("../class/util.class.php");
require("../class/templates.opc.php");
$util = new Util();
//$util->isLogged();
$core = new Core();
$config = $core->getConfig();
$templates = new templateOPC();

function html($txt){
	return "&lt;$txt&gt;";
}

function limpiar($html){
	$rem = array("&lt;","&gt;","&","&amp;nbsp;");
	$to = array("&amp;lt;","&amp;gt;", "&amp;amp;","");
	$html = str_replace($rem, $to, $html);
	return $html;
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

$core->bd->bind("start",$get["day"]);
$core->bd->bind("sala",$get["section"]);
//s.orden,
$infoCrono = $core->bd->query("SELECT * FROM cronograma as c JOIN salas as s ON c.section_id=s.salaid WHERE c.section_id<>2 ORDER BY SUBSTRING(c.start_date,1,10),s.orden,c.section_id,SUBSTRING(c.start_date,11,6)");
$helper = 0;

echo html('?xml version="1.0" encoding="utf-8"?')."<br>";
echo html("root");

foreach($infoCrono as $crono):		
		//DIA
		if(substr($crono["start_date"],0,10)!=$dia_):
			//CONTAINER DATA
			echo  html("dia").utf8_encode(strftime("%A",strtotime(substr($crono["start_date"],0,10)))).html("/dia").BR.PHP_EOL;
		endif;
		//SALA
		if($crono['section_id']!=$sala_):
			echo  html("sala").$crono["name"].html("/sala").BR;
		endif;

		//HORA / TIPO ACTIVIDAD
		$tipo_actividad = $core->getNameTipoActividadID($crono["tipo_actividad"]);
		echo  html("hora_actividad"). substr($crono["start_date"],-8,-3)." - ".substr($crono["end_date"],-8,-3).html("/hora_actividad").BR;
		//if($tipo_actividad["tipo_actividad"])
			//echo  html("tipo_actividad").limpiar($tipo_actividad["tipo_actividad"]).html("/tipo_actividad");
		//TITULO ACTIVIDAD
		//echo html("actividad").substr(limpiar($crono["titulo_actividad"]),9,6).html("/actividad").BR;
		//echo html("titulo_actividad").substr(limpiar($crono["titulo_actividad"]),16).html("/titulo_actividad").BR;
		echo html("titulo_actividad"). limpiar($crono["titulo_actividad"]) . html("/titulo_actividad").BR;
		//CONFERENCISTAS
		$getCronoConf = $core->getCronoConferencistas($crono["id_crono"]);
		if(count($getCronoConf)>0)
		echo html("conferencistas");
		$rol = false;
		$txt = "";
		foreach($getCronoConf as $cronoConf):
			$getConf = $core->getConferencistaID($cronoConf["id_conf"]);
			$getRol = $core->getRolID($cronoConf["en_calidad"]);
			
			/*if($getRol["calidad"]!="Coordinador" && $getRol["calidad"]!="Coordinadora"){
				$txt = trim($txt, ", ");
			}*/
			$espacio = true;
			
			if($cronoConf["titulo_conf"]){
				/*$elipsis = "";
				if(strlen(limpiar($cronoConf["titulo_conf"]))>=52)
					$elipsis = "...";*/
				//substr(limpiar($cronoConf["titulo_conf"]),0,52).$elipsis
				$txt .= BR.html("conferencista_titulo").limpiar($cronoConf["titulo_conf"]).html("/conferencista_titulo").BR;
				$espacio = false;
			}
			if($templates->hiddenConf($getConf["nombre"],$getConf["apellido"]))
			{
				
				if($getRol["calidad"]){
					$txt .= html("conferencista_calidad").$getRol["calidad"].":".html("/conferencista_calidad")." ";
					/*if(($getRol["calidad"]=="Coordinador" || $getRol["calidad"]=="Coordinadora") && $rol==false){
						$txt .= html("conferencista_calidad")."Coordinan:".html("/conferencista_calidad");//@@@
						$rol = true;
					}else if($getRol["calidad"]!="Coordinador" && $getRol["calidad"]!="Coordinadora"){
						$txt .= html("conferencista_calidad").$getRol["calidad"].":@@@".html("/conferencista_calidad");
						$rol = false;
					}*/
						
				}
				
				$txt .= html("conferencista").$getConf["nombre"]." ".$getConf["apellido"].html("/conferencista");
				/*if(($getRol["calidad"]=="Coordinador" || $getRol["calidad"]=="Coordinadora") && $rol==true)
					$txt .= ", ";*/
				if($getConf["institucion"])
					$txt .= html("conferencista_institucion")." - ".limpiar($core->getInstitution($getConf["institucion"])["Institucion"]).html("/conferencista_institucion");
				if($getConf["pais"] && $getConf["pais"]!=231)
					$txt .= html("conferencista_pais")." (".$core->getPais($getConf["pais"])["Pais"].")".html("/conferencista_pais");
				if($espacio)
					$txt .= BR;
				/*//Resumenes
				if($cronoConf["observaciones_conf"]){
					$txt .= BR.html("conferencista_resumen");
						$txt .= $cronoConf["observaciones_conf"];
					$txt .= html("/conferencista_resumen");
				}*/
			}
			
					
		endforeach;
		
		
		
		echo $txt;
		
		if(count($getCronoConf)>0){
			echo html("/conferencistas");
			echo BR;
		}
		
		//TRABAJOS LIBRES
		/*$getCronoTL = $core->getCronoTL($crono["id_crono"]);
		if(count($getCronoTL)>0)
		echo BR.html("trabajos_libres");
		foreach($getCronoTL as $cronoTL):
			$Hora_inicio = substr($cronoTL["Hora_inicio"],0,2);
			$Minutos_inicio = substr($cronoTL["Hora_inicio"],3,2);
			
			$Hora_fin = substr($cronoTL["Hora_fin"],0,2);
			$Minutos_fin = substr($cronoTL["Hora_fin"],3,2);
			$txt = "";
				//if($data["Hora_inicio"]!="00:00:00" && $cronoTL["Hora_fin"]!="00:00:00")
					//$txt .= html("trabajo_hora").$Hora_inicio.":".$Minutos_inicio." - ".$Hora_fin.":".$Minutos_fin.html("/trabajo_hora")."@@@";
			
				$txt .=  html("trabajo_titulo").limpiar($cronoTL["titulo_tl"]).html("trabajo_numero")." (#".$cronoTL["numero_tl"].")".html("/trabajo_numero"). html("/trabajo_titulo").BR;
	
				$txt .= html("trabajo_autores");
					$txt .= str_replace(array("<sup>","</sup>", "<i>", "</i>"),array("&lt;sup&gt;","&lt;/sup&gt;","&lt;autor_institucion&gt;", "&lt;/autor_institucion&gt;"),limpiar($templates->templateAutoresTL($cronoTL)));
				$txt .= html("/trabajo_autores").BR;		
	
				$txt .= html("trabajo_resumen");
				
					if($cronoTL["resumen"]){
						$txt .= "<b>Introduction:</b>".BR;
						$txt .= limpiar($cronoTL["resumen"]).BR.BR;
					}
					
					if($cronoTL["resumen2"]){
						$txt .= "<b>Material and Methods:</b>".BR;
						$txt .= limpiar($cronoTL["resumen2"]).BR.BR;
					}
					
					if($cronoTL["resumen3"]){
						$txt .= "<b>Results:</b>".BR;
						$txt .= limpiar($cronoTL["resumen3"]).BR.BR;
					}
					
					if($cronoTL["resumen4"]){
						$txt .= "<b>Conclusions:</b>".BR;
						$txt .= limpiar($cronoTL["resumen4"]).BR.BR;
					}
					
					if($cronoTL["resumen5"]){
						$txt .= "<b>Objectives of the session:</b>".BR;
						$txt .= limpiar($cronoTL["resumen5"]).BR.BR;
					}
					
					if($cronoTL["resumen6"]){
						$txt .= "<b>Content of the session:</b>".BR;
						$txt .= limpiar($cronoTL["resumen6"]).BR.BR;
					}
					
					if($cronoTL["resumen7"]){
						$txt .= "<b>Method and extent of audience participation:</b>".BR;
						$txt .= limpiar($cronoTL["resumen7"]).BR.BR;
					}
					
					if($cronoTL["resumen8"]){
						$txt .= "<b>Proposed content area and why it is important to participants:</b>".BR;
						$txt .= limpiar($cronoTL["resumen8"]);
					}
				$txt .= html("/trabajo_resumen");
			echo $txt;
		endforeach;
		if(count($getCronoTL)>0)
		echo html("/trabajos_libres");*/
	
	
	$dia_ = $core->helperDate($crono["start_date"],0,10);
	$sala_ = $crono['section_id'];
	$helper++;
endforeach;
echo '<br>';
echo html("/root");
?>