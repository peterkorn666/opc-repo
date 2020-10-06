<?php
require("../class/core.php");
require("../class/util.class.php");
require("../class/templates.opc.php");
$util = new Util();
//$util->isLogged();
$core = new Core();
$config = $core->getConfig();
$templates = new templateOPC();
header("Content-Disposition: attachment; filename=Programa_Dia_Hora_Sala_".date("Y-m-d").".xml");

function html($txt){
	return "&lt;$txt&gt;";
}

function limpiar($html){
	//$rem = array("&lt;","&gt;","&","&amp;nbsp;");
	//$to = array("&amp;lt;","&amp;gt;", "&amp;amp;","");
	
	$rem2 = array(" & ");
	$to2 = array(" &amp; ");
	$html = str_replace($rem2, $to2, $html);
	
	$rem = array("&lt;", "&gt;", " &amp; ", "&amp;nbsp;");
	$to = array("&amp;lt;", "&amp;gt;", " &amp;amp; ", "");
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
//$infoCrono = $core->getCronoByDaySala($get["day"],$get["section"]);
$infoCrono = $core->getCronoByDayHoraSala($get["day"],$get["section"]);
$helper = 0;

echo html('?xml version="1.0" encoding="utf-8"?')."<br>";
echo html("root");

foreach($infoCrono as $crono):		

		$etiqueta_sala = "_02_sala";
		$sala_nombre = $crono["name"];
		$se_puede_mostrar = true;
		$titulos_a_mostrar_1_vez = array(3,4,5,6,10);
		if($crono["tipo_actividad"] == $tipo_actividad_anterior && in_array($crono["tipo_actividad"], $titulos_a_mostrar_1_vez)){
			$se_puede_mostrar = false;
		} else if (in_array($crono["tipo_actividad"], $titulos_a_mostrar_1_vez)) {
			$etiqueta_sala = "_02-1_sala";
			$sala_nombre = "Foyer";
		}
		
		if($se_puede_mostrar === true){
			//DIA
			if(substr($crono["start_date"],0,10)!=$dia_):
				//CONTAINER DATA
				echo  html("_01_dia").ucfirst(utf8_encode(strftime("%A %d de %B",strtotime(substr($crono["start_date"],0,10))))).html("/_01_dia").BR.PHP_EOL;
			endif;
			//SALA
			if($crono['section_id']!=$sala_):
				echo  html($etiqueta_sala).$sala_nombre.html("/".$etiqueta_sala).PHP_EOL;
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
			echo  html("_03_hora_actividad").substr($crono["start_date"],-8,-3)." - ".substr($crono["end_date"],-8,-3).html("/_03_hora_actividad")."@@@";
			if($tipo_actividad["tipo_actividad"])
				echo  html("_04_tipo_actividad").limpiar($tipo_actividad["tipo_actividad"]).html("/_04_tipo_actividad").BR;
			//TITULO ACTIVIDAD
			if($crono["titulo_actividad"])
				echo html("_05_titulo_actividad").limpiar($crono["titulo_actividad"]).html("/_05_titulo_actividad").BR;
			
			//TRABAJOS LIBRES
			$getCronoTL = $core->getCronoTL($crono["id_crono"]);
			if(count($getCronoTL)>0)
				echo html("_06_trabajos_libres");//BR.
			$rol_anterior = array("nombre" => "", "plural" => false);
			foreach($getCronoTL as $cronoTL):
				$Hora_inicio = substr($cronoTL["Hora_inicio"],0,2);
				$Minutos_inicio = substr($cronoTL["Hora_inicio"],3,2);
				
				$Hora_fin = substr($cronoTL["Hora_fin"],0,2);
				$Minutos_fin = substr($cronoTL["Hora_fin"],3,2);
				$txt = "";
					//if($data["Hora_inicio"]!="00:00:00" && $cronoTL["Hora_fin"]!="00:00:00")
						//$txt .= html("trabajo_hora").$Hora_inicio.":".$Minutos_inicio." - ".$Hora_fin.":".$Minutos_fin.html("/trabajo_hora")."@@@";
					//if($cronoTL["numero_tl"] == "100"){
					//	var_dump($cronoTL["titulo_tl"]);
					//	var_dump(limpiar($cronoTL["titulo_tl"]));
					//}
				
					//$txt .=  html("trabajo_titulo").limpiar($cronoTL["titulo_tl"]).html("trabajo_numero")." (#".$cronoTL["numero_tl"].")".html("/trabajo_numero"). html("/trabajo_titulo").BR;
					$txt .= html("_06-1_trabajo_titulo").limpiar($cronoTL["titulo_tl"]).html("/_06-1_trabajo_titulo").BR;
		
					$txt .= html("_06-2_trabajo_autores");
						//$txt .= str_replace(array("<sup>","</sup>", "<i>", "</i>"),array("&lt;sup&gt;","&lt;/sup&gt;","&lt;autor_institucion&gt;", "&lt;/autor_institucion&gt;"),limpiar($templates->templateAutoresTL($cronoTL)));
						//$autores = str_replace(array("<sup>","</sup>", "<i>", "</i>"),array("&lt;sup&gt;","&lt;/sup&gt;","&lt;autor_pais&gt;", "&lt;/autor_pais&gt;"),limpiar($templates->templateProgramaAutoresTL($cronoTL)));
						$autores = str_replace(array("<sup>","</sup>"),array("&lt;sup&gt;","&lt;/sup&gt;"),limpiar($templates->templateProgramaAutoresTL($cronoTL)));
						
						$etiqueta_inicio_rol = "&lt;_06-3_autor_calidad&gt;";
						$etiqueta_fin_rol = "&lt;/_06-3_autor_calidad&gt;";
						$etiqueta_inicio_autor = "&lt;_06-4_autor&gt;";
						$etiqueta_fin_autor = "&lt;/_06-4_autor&gt;";
						$etiqueta_inicio_institucion = "&lt;_06-5_autor_institucion&gt;";
						$etiqueta_fin_institucion = "&lt;/_06-5_autor_institucion&gt;";
						$etiqueta_inicio_pais = "&lt;_06-6_autor_pais&gt;";
						$etiqueta_fin_pais = "&lt;/_06-6_autor_pais&gt;";
						
						$matches_autor = array();
						//preg_match_all('|<[^>]+>(.*)</[^>]+>|U', $autores, $matches);
						preg_match_all('|<span[^>]+>(.*)</[^>]+>|U', $autores, $matches);
						//var_dump($matches);die();
						foreach($matches[0] as $key => $m){
							$match = preg_replace("/\&nbsp;/", '', $m);
							if(strpos($match, '<span class="txt_rol">')!== false){
								$string = str_replace('<span class="txt_rol">', '', $match);
								$string = str_replace('</span>', '', $string);
								//if($string != ""){
									$txt_rol = $string;
									if($txt_rol != "")
										$txt_rol .= ":";
									$tabuladores = "@@@"; //1tab
									$es_plural = false;
									$rol = $core->query("SELECT * FROM calidades_conferencistas WHERE calidad='".$string."'");
									if(count($rol) > 0){
										$es_plural = ($rol[0]["plural"] == 1);
										/*if($rol["plural"] == 1 && $rol_anterior == $rol["calidad"]){
											$txt_rol = "";
											$tabuladores .= "@@@"; //le agrego 1 tab
										}*/
									}else if($rol_anterior["plural"] == true){
										$txt_rol = "";
										$tabuladores .= "@@@"; //le agrego 1 tab
										$es_plural = true;
									}else if($txt_rol == ""){
										$tabuladores .= "@@@"; //le agrego 1 tab
									}
									
									$txt .= $etiqueta_inicio_rol.$txt_rol.$etiqueta_fin_rol.$tabuladores;
								//}
							}
							if(strpos($match, '<span class="txt_autor">')!== false){
								$txt .= $etiqueta_inicio_autor.$matches[1][$key].$etiqueta_fin_autor;
							}
							if(strpos($match, 'autor_institucion')!== false){
								$txt .= ' - '.$etiqueta_inicio_institucion.$matches[1][$key].$etiqueta_fin_institucion;
							}
							if(strpos($match, 'autor_pais')!== false){
								$txt .= ' '.$etiqueta_inicio_pais.$matches[1][$key].$etiqueta_fin_pais."<br>";//
							}
							$rol_anterior['nombre'] = $txt_rol;
							$rol_anterior['plural'] = $es_plural;
						}
						$txt = substr($txt, 0, -4);
						
						/*
						//Rol
						$pos_span_rol = strpos($autores, '<span class="txt_rol">');
						$pos_end_span_rol = strpos($autores, '</span>', $pos_span_rol);
						$largo_span_rol = strlen('<span class="txt_rol">');
						$largo_fin_span = strlen('</span>');
						for($i=0; $i < $largo_span_rol; $i++){
							$autores[$pos_span_rol+$i] = "";
						}
						//$autores[$pos_span_rol] = "&lt;calidad_autor&gt;";
						for($j=0; $j < $largo_fin_span; $j++){
							$autores[$pos_end_span_rol+$j] = "";
						}
						
						//Autor
						$pos_span_autor = strpos($autores, '<span class="txt_autor">');
						$pos_end_span_autor = strpos($autores, '</span>', $pos_span_autor);
						$largo_span_autor = strlen('<span class="txt_autor">');
						for($i=0; $i < $largo_span_autor; $i++){
							$autores[$pos_span_autor+$i] = "";
						}
						for($j=0; $j < $largo_fin_span; $j++){
							$autores[$pos_end_span_autor+$j] = "";
						}
						
						//Institucion
						$pos_span_institucion = strpos($autores, "<span class='autor_institucion'>");
						$pos_end_span_institucion = strpos($autores, '</span>', $pos_span_institucion);
						$largo_span_institucion = strlen("<span class='autor_institucion'>");
						for($i=0; $i < $largo_span_institucion; $i++){
							$autores[$pos_span_institucion+$i] = "";
						}
						for($j=0; $j < $largo_fin_span; $j++){
							$autores[$pos_end_span_institucion+$j] = "";
						}
						
						//TXT ROL
						$antes_de_span_rol = substr($autores, 0, $pos_span_rol);
						$pos_inicio_rol = $pos_span_rol + $largo_span_rol; //22 = strlen(<span class="txt_rol">)
						$rol = substr($autores, $pos_inicio_rol, $pos_end_span_rol - $pos_inicio_rol);
						$txt_rol = $etiqueta_inicio_rol.$rol.$etiqueta_fin_rol;
						$pos_siguiente_al_rol = $pos_end_span_rol + $largo_fin_span; //fin del rol + largo de </span>
						//$despues_span_rol = substr($autores, $pos_end_span_rol + $largo_fin_span);
						
						//TXT AUTOR
						$antes_de_span_autor = substr($autores, $pos_siguiente_al_rol, $pos_span_autor - $pos_siguiente_al_rol); //
						$pos_inicio_autor = $pos_span_autor + $largo_span_autor;
						$info_autor = substr($autores, $pos_inicio_autor, $pos_end_span_autor - $pos_inicio_autor);
						$txt_autor = $etiqueta_inicio_autor.$info_autor.$etiqueta_fin_autor;
						
						$pos_siguiente_al_autor = $pos_end_span_autor + $largo_fin_span;
						//$despues_span_autor = substr($autores, $pos_siguiente_al_autor);
						
						//TXT INSTITUCION
						$antes_de_span_institucion = substr($autores, $pos_siguiente_al_autor, $pos_span_institucion - $pos_siguiente_al_autor);
						$pos_inicio_institucion = $pos_span_institucion + $largo_span_institucion;
						$info_institucion = substr($autores, $pos_inicio_institucion, $pos_end_span_institucion - $pos_inicio_institucion);
						$txt_institucion = $etiqueta_inicio_institucion.$info_institucion.$etiqueta_fin_institucion;
						
						$pos_siguiente_a_institucion = $pos_end_span_institucion + $largo_fin_span;
						$despues_span_institucion = substr($autores, $pos_siguiente_a_institucion);
						
						$txt .= $antes_de_span_rol.$txt_rol.$antes_de_span_autor.$txt_autor.$antes_de_span_institucion.$txt_institucion.$despues_span_institucion;
						*/
						
					$txt .= html("/_06-2_trabajo_autores").BR;		
		
					/*$txt .= html("trabajo_resumen");
					
						if($cronoTL["resumen"]){
							$txt .= "<b>Resumen:</b>".BR;
							$txt .= limpiar($cronoTL["resumen"]).BR.BR;
						}
						
						if($cronoTL["resumen2"]){
							$txt .= "<b>Resumo:</b>".BR;
							$txt .= limpiar($cronoTL["resumen2"]).BR.BR;
						}
					$txt .= html("/trabajo_resumen");*/
				echo $txt;
			endforeach;
			if(count($getCronoTL)>0)
			echo html("/_06_trabajos_libres");
			
			
			//CONFERENCISTAS
			$getCronoConf = $core->getCronoConferencistas($crono["id_crono"]);
			if(count($getCronoConf)>0)
			echo html("_07_conferencistas");
			foreach($getCronoConf as $cronoConf):
				$getConf = $core->getConferencistaID($cronoConf["id_conf"]);
				$getRol = $core->getRolID($cronoConf["en_calidad"]);
				$txt = "";
				if($cronoConf["titulo_conf"])
					$txt .= html("_07-1_conferencista_titulo").limpiar($cronoConf["titulo_conf"]).html("/_07-1_conferencista_titulo").BR;
				if($templates->hiddenConf($getConf["nombre"],$getConf["apellido"]))
				{
					if($getRol["calidad"])
						$txt .= html("_07-2_conferencista_calidad").$getRol["calidad"].":".html("/_07-2_conferencista_calidad")."@@@";
					else
						$txt .= html("_07-2_conferencista_calidad").html("/_07-2_conferencista_calidad")."@@@@@@";
					$txt .= html("_07-3_conferencista").$getConf["profesion"]." ".$getConf["nombre"]." ".$getConf["apellido"].html("/_07-3_conferencista");
					if($getConf["institucion"])
						$txt .= html("_07-4_conferencista_institucion")." - ".limpiar($core->getInstitution($getConf["institucion"])["Institucion"]).html("/_07-4_conferencista_institucion");
					if($getConf["pais"] && $getConf["pais"]!=247)
						$txt .= html("_07-5_conferencista_pais")." (".$core->getPais($getConf["pais"])["Pais"].")".html("/_07-5_conferencista_pais");
					//Resumenes
					if($cronoConf["observaciones_conf"]){
						$txt .= BR.html("_07-6_conferencista_resumen");
							$txt .= $cronoConf["observaciones_conf"];
						$txt .= html("/_07-6_conferencista_resumen");
					}
				}
				
				echo $txt.BR;			
			endforeach;
			
			if(count($getCronoConf)>0)
			echo html("/_07_conferencistas");
		}
		
	
	$dia_ = $core->helperDate($crono["start_date"],0,10);
	$sala_ = $crono['section_id'];
	$tipo_actividad_anterior = $crono["tipo_actividad"];
	$helper++;
endforeach;
echo '<br>';
echo html("/root");
?>