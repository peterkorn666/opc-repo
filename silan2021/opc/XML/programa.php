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

function limpiar($cual){
	$amperson = "&amp;";

	//borro todo lo feo
	$cual = str_replace("<p>", "" , $cual);
	$cual = str_replace("</p>", "<br>" , $cual);
	$cual = str_replace('<p class="MsoBodyText3">', "" , $cual);
	$cual = str_replace('<p class="MsoBodyText2">', "" , $cual);
	
	$cual = str_replace('<p class="MsoNormal">', "" , $cual);
	$cual = str_replace('<p class="MsoNormal">', "" , $cual);

	$cual = str_replace('<h2>', "" , $cual);
	$cual = str_replace('</h2>', "" , $cual);

	$cual = str_replace('<span>', "" , $cual);
	$cual = str_replace('</span>', "" , $cual);

	$cual = str_replace('<a name="OLE_LINK2">', "" , $cual);
	$cual = str_replace('<a>', "" , $cual);
	$cual = str_replace('</a>', "" , $cual);
	
	$cual = str_replace(' < ', " ".$amperson . "&lt;"." " , $cual);

	//
	//
	//modifico etiquetas buenas////////////////////////

/*	$cual = str_replace('<br />', "[[|br /|]]" , $cual);

	$cual = str_replace('<br>', "[[|br /|]]" , $cual);

	$cual = str_replace('<sup>', "[[|sup|]]" , $cual);
	$cual = str_replace('</sup>', "[[|/sup|]]" , $cual);

	$cual = str_replace('<sub>', "[[|sub|]]" , $cual);
	$cual = str_replace('</sub>', "[[|/sub|]]" , $cual);

	$cual = str_replace('<em>', "[[|em|]]" , $cual);
	$cual = str_replace('</em>', "[[|/em|]]" , $cual);

	$cual = str_replace('<strong>', "[[|strong|]]" , $cual);
	$cual = str_replace('</strong>', "[[|/strong|]]" , $cual);

	$cual = str_replace('<b>', "[[|b|]]" , $cual);
	$cual = str_replace('</b>', "[[|/b|]]" , $cual);

	$cual = str_replace('<table ', "[[|table|]]" , $cual);
	$cual = str_replace('<table', "[[|table|]]" , $cual);
	$cual = str_replace('</table>', "[[|/table|]]" , $cual);

	$cual = str_replace('<tr>', "[[|tr|]]" , $cual);
	$cual = str_replace('</tr>', "[[|/tr|]]" , $cual);

	$cual = str_replace('<td>', "[[|td|]]" , $cual);
	$cual = str_replace('</td>', "[[|/td|]]" , $cual);
	*/
	//
	
	

	//$cual = str_replace(" & ", (" " . $amperson . "amp; ") , $cual);
	//$cual = str_replace("&", ($amperson . "amp;") , $cual);
	
	//relpazo solo los cos coyetes: < y >
	$cual = str_replace('<', "&lt;" , $cual);
	$cual = str_replace('>',  "&gt;" , $cual);
	//
	//$cual = str_replace('&lt;', $amperson . "lt;" , $cual);
	//$cual = str_replace('&gt;', $amperson . "gt;" , $cual);
	// "
	$cual = str_replace("&ldquo;", ($amperson . "quot;"), $cual);
	$cual = str_replace("&rdquo;", ($amperson . "quot;"), $cual);
	//'
	$cual = str_replace("&lsquo;", ($amperson . "apos;"), $cual);
	$cual = str_replace("&rsquo;", ($amperson . "apos;"), $cual);
	// -
	$cual = str_replace("&ndash;", "-", $cual);
	//
	$cual = str_replace($amperson . "mu;", "&mu;", $cual);


	$cual = str_replace("'", ($amperson . "apos;") , $cual);
	$cual = str_replace('"', ($amperson . "quot;") , $cual);

	//$cual = str_replace('<', ($amperson . "lt;") , $cual);
	//$cual = str_replace('>', ($amperson . "gt;") , $cual);


	//desemplazo etiqueas html

	//modifico etiquetas buenas////////////////////////

/*	$cual = str_replace("[[|br /|]]" , '<br />', $cual);

	$cual = str_replace("[[|sup|]]" , '&lt;sup&gt;', $cual);
	$cual = str_replace("[[|/sup|]]" , '&lt;/sup&gt;', $cual);

	$cual = str_replace("[[|sub|]]" , '&lt;sub&gt;', $cual);
	$cual = str_replace("[[|/sub|]]" , '&lt;/sub&gt;', $cual);

	$cual = str_replace("[[|em|]]" , '&lt;em&gt;', $cual);
	$cual = str_replace("[[|/em|]]" , '&lt;/em&gt;', $cual);

	$cual = str_replace("[[|strong|]]" , '&lt;strong&gt;', $cual);
	$cual = str_replace("[[|/strong|]]" , '&lt;/strong&gt;', $cual);

	$cual = str_replace("[[|b|]]" , '&lt;strong&gt;', $cual);
	$cual = str_replace("[[|/b|]]" , '&lt;/strong&gt;', $cual);

	$cual = str_replace( "[[|table|]]" , "<br>" . nodo("TABLA"), $cual);
	$cual = str_replace( "[[|/table|]]" , nodo("/TABLA"), $cual);

	$cual = str_replace("[[|tr|]]" , '######', $cual);
	$cual = str_replace("[[|/tr|]]" , '#####', $cual);

	$cual = str_replace("[[|td|]]" ,  '#####', $cual);
	$cual = str_replace("[[|/td|]]" ,  '#####', $cual);*/


		//
	
	
	return $cual;
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
$infoCrono = $core->getCronoByDaySala($get["day"],$get["section"]);
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
			echo  html("sala").$crono["name"].html("/sala").PHP_EOL;
		endif;
		//CONTAINER DIA SALA END
		echo "</div>";

		if(substr($crono["start_date"],0,10)!=$dia_ || $crono['section_id']!=$sala_):
			echo "<div class='clear'></div>";
			//CONTAINER DATA
			echo "<div class='container_data'>";
		endif;

		//HORA / TIPO ACTIVIDAD
		$tipo_actividad = $core->getNameTipoActividadID($crono["tipo_actividad"]);
		echo  html("hora_actividad").substr($crono["start_date"],-8,-3)." - ".substr($crono["end_date"],-8,-3).html("/hora_actividad")."@@@";
		//if($tipo_actividad["tipo_actividad"])
			//echo  html("tipo_actividad").limpiar($tipo_actividad["tipo_actividad"]).html("/tipo_actividad");
		//TITULO ACTIVIDAD
		echo html("titulo_actividad").limpiar($crono["titulo_actividad"]).html("/titulo_actividad").BR;
		//CONFERENCISTAS
		$getCronoConf = $core->getCronoConferencistas($crono["id_crono"]);
		if(count($getCronoConf)>0)
		echo html("conferencistas");
		foreach($getCronoConf as $cronoConf):
			$getConf = $core->getConferencistaID($cronoConf["id_conf"]);
			$getRol = $core->getRolID($cronoConf["en_calidad"]);
			$txt = "";
			if($cronoConf["titulo_conf"])
				$txt .= html("conferencista_titulo").limpiar($cronoConf["titulo_conf"]).html("/conferencista_titulo").BR;
			if($templates->hiddenConf($getConf["nombre"],$getConf["apellido"]))
			{
				if($getRol["calidad"])
					$txt .= html("conferencista_calidad").$getRol["calidad"].":@@@".html("/conferencista_calidad");
				$txt .= html("conferencista").$getConf["nombre"]." ".$getConf["apellido"].html("/conferencista");
				if($getConf["institucion"])
					$txt .= html("conferencista_institucion")." - ".limpiar($core->getInstitution($getConf["institucion"])["Institucion"]).html("/conferencista_institucion");
				if($getConf["pais"] && $getConf["pais"]!=247)
					$txt .= html("conferencista_pais")." (".$core->getPais($getConf["pais"])["Pais"].")".html("/conferencista_pais");
				//Resumenes
				if($cronoConf["observaciones_conf"]){
					$txt .= BR.html("conferencista_resumen");
						$txt .= $cronoConf["observaciones_conf"];
					$txt .= html("/conferencista_resumen");
				}
			}
			
			echo $txt.BR;			
		endforeach;
		
		if(count($getCronoConf)>0)
		echo html("/conferencistas");
		
		//TRABAJOS LIBRES
		$getCronoTL = $core->getCronoTL($crono["id_crono"]);
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
						$txt .= "<b>Objetivo:</b>".BR;
						$txt .= limpiar($cronoTL["resumen2"]).BR.BR;
					}
					
					if($cronoTL["resumen3"]){
						$txt .= "<b>Material y método:</b>".BR;
						$txt .= limpiar($cronoTL["resumen3"]).BR.BR;
					}
					
					if($cronoTL["resumen4"]){
						$txt .= "<b>Resultados:</b>".BR;
						$txt .= limpiar($cronoTL["resumen4"]).BR.BR;
					}
					
					if($cronoTL["resumen5"]){
						$txt .= "<b>Conclusiones:</b>".BR;
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
		echo html("/trabajos_libres");
	
	
	$dia_ = $core->helperDate($crono["start_date"],0,10);
	$sala_ = $crono['section_id'];
	$helper++;
endforeach;
echo '<br>';
echo html("/root");
?>