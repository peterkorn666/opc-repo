<?php
require("../class/core.php");
require("../class/util.class.php");
require("../class/templates.opc.php");
$util = new Util();
//$util->isLogged();
$core = new Core();
$config = $core->getConfig();
$templates = new templateOPC();
header("Content-Disposition: attachment; filename=Cronograma_".date("Y-m-d").".xml");

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

$core->bd->bind("start",$get["day"]);
$core->bd->bind("sala",$get["section"]);
//s.orden,
$infoCrono = $core->bd->query("SELECT * FROM cronograma as c JOIN salas as s ON c.section_id=s.salaid ORDER BY SUBSTRING(c.start_date,1,10), SUBSTRING(c.start_date,11,6), s.orden");
$helper = 0;

echo html('?xml version="1.0" encoding="utf-8"?')."<br>";
echo html("root");

foreach($infoCrono as $crono):		
		//DIA
		//if(substr($crono["start_date"],0,10)!=$dia_):
			//CONTAINER DATA
			//echo  html("_01_dia").utf8_encode(strftime("%A",strtotime(substr($crono["start_date"],0,10)))).html("/_01_dia").BR.PHP_EOL;
		//endif;
		//SALA
		//if($crono['section_id']!=$sala_):
		//	echo  html("_02_sala").$crono["name"].html("/_02_sala").BR;
		//endif;
		$se_puede_mostrar = true;
		$titulos_a_no_mostrar = array(3,4,5,6,10);
		if(in_array($crono["tipo_actividad"], $titulos_a_no_mostrar)){
			$se_puede_mostrar = false;
		}

		if($se_puede_mostrar === true){
			
			//HORA / TIPO ACTIVIDAD
			//$tipo_actividad = $core->getNameTipoActividadID($crono["tipo_actividad"]);
			//echo  html("_03_hora_actividad"). substr($crono["start_date"],-8,-3)." - ".substr($crono["end_date"],-8,-3).html("/_03_hora_actividad").BR;
			
			//if($tipo_actividad["tipo_actividad"])
			//	echo  html("tipo_actividad").limpiar($tipo_actividad["tipo_actividad"]).html("/tipo_actividad");
			//TITULO ACTIVIDAD
			//echo html("actividad").substr(limpiar($crono["titulo_actividad"]),9,6).html("/actividad").BR;
			//echo html("titulo_actividad").substr(limpiar($crono["titulo_actividad"]),16).html("/titulo_actividad").BR;
			echo "###".html("_05_titulo_actividad"). limpiar($crono["titulo_actividad"]) . html("/_05_titulo_actividad").BR;
			
			//TRABAJOS LIBRES
			$getCronoTL = $core->getCronoTL($crono["id_crono"]);
			if(count($getCronoTL)>0)
			echo BR.html("_06_trabajos_libres");
			foreach($getCronoTL as $cronoTL):
				$Hora_inicio = substr($cronoTL["Hora_inicio"],0,2);
				$Minutos_inicio = substr($cronoTL["Hora_inicio"],3,2);
				
				$Hora_fin = substr($cronoTL["Hora_fin"],0,2);
				$Minutos_fin = substr($cronoTL["Hora_fin"],3,2);
				$txt = "";
					//if($data["Hora_inicio"]!="00:00:00" && $cronoTL["Hora_fin"]!="00:00:00")
						//$txt .= html("trabajo_hora").$Hora_inicio.":".$Minutos_inicio." - ".$Hora_fin.":".$Minutos_fin.html("/trabajo_hora")."@@@";
				
					//$txt .=  html("_06-1_trabajo_titulo").limpiar($cronoTL["titulo_tl"]).html("/_06-1_trabajo_titulo").BR;//html("trabajo_numero")." (#".$cronoTL["numero_tl"].")".html("/trabajo_numero")
		
					$txt .= html("_06-2_trabajo_autores");
						//$txt .= str_replace(array("<sup>","</sup>", "<i>", "</i>"),array("&lt;sup&gt;","&lt;/sup&gt;","&lt;autor_institucion&gt;", "&lt;/autor_institucion&gt;"),limpiar($templates->templateAutoresTL($cronoTL)));
						
						$autores = str_replace(array("<sup>","</sup>"),array("&lt;sup&gt;","&lt;/sup&gt;"),limpiar($templates->templateProgramaAutoresTL($cronoTL, false, "", true)));
						
						//$etiqueta_inicio_rol = "&lt;_06-3_autor_calidad&gt;";
						//$etiqueta_fin_rol = "&lt;/_06-3_autor_calidad&gt;";
						$etiqueta_inicio_autor = "&lt;_06-4_autor&gt;";
						$etiqueta_fin_autor = "&lt;/_06-4_autor&gt;";
						$etiqueta_inicio_institucion = "&lt;_06-5_autor_institucion&gt;";
						$etiqueta_fin_institucion = "&lt;/_06-5_autor_institucion&gt;";
						//$etiqueta_inicio_pais = "&lt;_06-6_autor_pais&gt;";
						//$etiqueta_fin_pais = "&lt;/_06-6_autor_pais&gt;";
						
						$matches_autor = array();
						preg_match_all('|<span[^>]+>(.*)</[^>]+>|U', $autores, $matches);
						//var_dump($matches);die();
						$primera_vez = true;
						foreach($matches[0] as $key => $m){
							$match = preg_replace("/\&nbsp;/", '', $m);
							/*if(strpos($match, '<span class="txt_rol">')!== false){
								$string = str_replace('<span class="txt_rol">', '', $match);
								$string = str_replace('</span>', '', $string);
								//if($string != ""){
									$txt_rol = $string;
									//$tabuladores = "@@@"; //1tab
									$es_plural = false;
									$rol = $core->query("SELECT * FROM calidades_conferencistas WHERE calidad='".$string."'");
									if(count($rol) > 0){
										$es_plural = ($rol[0]["plural"] == 1);
									}else if($rol_anterior["plural"] == true){
										$txt_rol = "";
										//$tabuladores .= "@@@"; //le agrego 1 tab
										$es_plural = true;
									}else if($txt_rol == ""){
										//$tabuladores .= "@@@"; //le agrego 1 tab
									}
									
									$txt .= $etiqueta_inicio_rol.$txt_rol.$etiqueta_fin_rol;//$tabuladores
								//}
							}*/
							if(strpos($match, '<span class="txt_autor">') !== false){
								if($primera_vez === false){
									$txt .= BR;
								}else
									$primera_vez = false;
									
								$txt .= $etiqueta_inicio_autor.$matches[1][$key].$etiqueta_fin_autor;
							}
							if(strpos($match, 'autor_institucion')!== false){
								$txt .= ' - '.$etiqueta_inicio_institucion.$matches[1][$key].$etiqueta_fin_institucion;
							}
							/*if(strpos($match, 'autor_pais')!== false){
								$txt .= ' '.$etiqueta_inicio_pais.$matches[1][$key].$etiqueta_fin_pais."<br>";
							}*/
							//$rol_anterior['nombre'] = $txt_rol;
							//$rol_anterior['plural'] = $es_plural;
						}
						
						
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
			$rol = false;
			$txt = "";
			$primer_conf = true;
			foreach($getCronoConf as $cronoConf):
				$getConf = $core->getConferencistaID($cronoConf["id_conf"]);
				$getRol = $core->getRolID($cronoConf["en_calidad"]);
				
				//if($getRol["calidad"]!="Coordinador" && $getRol["calidad"]!="Coordinadora"){
				//	$txt = trim($txt, ", ");
				//}
							
				/*if($cronoConf["titulo_conf"]){
					$elipsis = "";
					if(strlen(limpiar($cronoConf["titulo_conf"]))>=52)
						$elipsis = "...";
					$txt .= BR.html("_07-1_conferencista_titulo").substr(limpiar($cronoConf["titulo_conf"]),0,52).$elipsis.html("/_07-1_conferencista_titulo").BR;
				}*/
				if($templates->hiddenConf($getConf["nombre"],$getConf["apellido"]))
				{
					//$txt .= html("_07-2_conferencista_calidad").html("/_07-2_conferencista_calidad");
					/*if($getRol["calidad"]){
						if(($getRol["calidad"]=="Coordinador" || $getRol["calidad"]=="Coordinadora") && $rol==false){
							$txt .= html("_07-2_conferencista_calidad")."Coordinan:@@@".html("/_07-2_conferencista_calidad");
							$rol = true;
						}//else if($getRol["calidad"]!="Coordinador" && $getRol["calidad"]!="Coordinadora"){
						//	$txt .= html("conferencista_calidad").$getRol["calidad"].":@@@".html("/conferencista_calidad");
						//	$rol = false;
						//}
							
					}*/
					
					if($primer_conf === false){
						$txt .= BR;
					}else
						$primer_conf = false;
					
					$txt .= html("_07-3_conferencista").$getConf["nombre"]." ".$getConf["apellido"].html("/_07-3_conferencista");
					/*if(($getRol["calidad"]=="Coordinador" || $getRol["calidad"]=="Coordinadora") && $rol==true)
						$txt .= ", ";*/
					if($getConf["institucion"])
						$txt .= html("_07-4_conferencista_institucion")." - ".limpiar($core->getInstitution($getConf["institucion"])["Institucion"]).html("/_07-4_conferencista_institucion");
					/*if($getConf["pais"] && $getConf["pais"]!=231)
						$txt .= html("_07-5_conferencista_pais")." (".$core->getPais($getConf["pais"])["Pais"].")".html("/_07-5_conferencista_pais");*/
					/*//Resumenes
					if($cronoConf["observaciones_conf"]){
						$txt .= BR.html("_07-6_conferencista_resumen");
							$txt .= $cronoConf["observaciones_conf"];
						$txt .= html("/_07-6_conferencista_resumen");
					}*/
				}
				
						
			endforeach;
			
			
			
			echo $txt;
			
			if(count($getCronoConf)>0){
				echo html("/_07_conferencistas");
				echo BR;
			}
		}//end if se puede mostrar
	
	
	$dia_ = $core->helperDate($crono["start_date"],0,10);
	$sala_ = $crono['section_id'];
	$helper++;
endforeach;
echo '<br>';
echo html("/root");
?>