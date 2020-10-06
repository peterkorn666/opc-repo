<?php
global $tpl;
$util = $tpl->getVar('util');
//$util->isLogged();
$core = $tpl->getVar('core');
$templates = $tpl->getVar('templates');
$debug = $tpl->getVar('debug');
$config = $tpl->getVar('config');
$core->Debug($debug);
//DEFINE HEADERS
$headers = array(
	"estilos/cronograma.css"=>"css",
	"js/cronograma.js"=>"js"
);
$tpl->SetVar('headers',$headers);

//def vars
$start_date = "";
$get = $_GET;
$toDay = "";
$primeraHoraHelper = 0;
//$typeWidth = "px";
$typeWidth = "%";
$leftPlus = 1;

//CONFIG
$desplasamientoDerecha = 1;
$alto_po_carga_horaria = 36;
$bannerheight = GetImageSize($config["banner_congreso"]);
$altoAbsoluto = $bannerheight[1]-650;

if($get["day"])
	$toDay = $get["day"];
else
	$toDay = $primerDia;

$visible_salas = '';
if(!$_SESSION["admin"]){
	$visible_salas = ' AND s.visible=1';
}
	
$getTotalSalas = $core->query("SELECT c.section_id,c.start_date FROM cronograma c JOIN salas s ON c.section_id=s.salaid WHERE 1=1 $visible_salas GROUP BY SUBSTRING(c.start_date,1,10), c.section_id ORDER BY SUBSTRING(c.start_date,1,10), c.section_id DESC");
//DEFINIR EL TAMAÑO DE LAS SALAS
if($typeWidth=="%")
	$tamano_columna = 99.5/count(($getTotalSalas?$getTotalSalas:1));
else
	$tamano_columna = 406;


//OBTENER SALAS DEL CRONO
$sqlCrono = $core->query("SELECT c.start_date,c.end_date,c.section_id,c.section_id, s.salaid, s.orden, s.visible FROM cronograma as c JOIN salas as s ON c.section_id=s.salaid WHERE 1=1 $visible_salas ORDER BY SUBSTRING(c.start_date,1,10), s.orden ASC");
foreach($sqlCrono as $key => $crono)
{	
	
	
	//Ocultar los casillero de los trabajos al publico		
	$ocultarTrabajos = true;
	if(substr($crono["start_date"],0,10)=="2017-12-09" && $_SESSION["tipoUsu"]!="1")	
		$ocultarTrabajos = false;
	if($ocultarTrabajos){
		$posX = (($tamano_columna * $desplasamientoDerecha) - $tamano_columna);	
		//OBTENER LOS DIAS
		$sqlSalasCount = $core->query("SELECT c.section_id FROM cronograma c JOIN salas s ON c.section_id=s.salaid WHERE SUBSTRING(c.start_date,1,10)='".$core->helperDate($crono["start_date"],0,10)."' $visible_salas GROUP BY c.section_id");
		$cantidad_salas = count($sqlSalasCount);
		if($start_date != $core->helperDate($crono["start_date"],0,10))
		{
			$leftPlus++;//+(8*$leftPlus)
			echo "<div class='sala' style='
					top: ".($altoAbsoluto-20)."px;
					position: absolute;
					left:".($posX+(1*($leftPlus-1))) .$typeWidth.";				 
					width:".($tamano_columna*$cantidad_salas).$typeWidth.";
					height:20px;
					background-color:#333333;
					border:1px solid #000000;
					color:white;
					text-align:center; text-transform:uppercase'>";
				echo utf8_encode(strftime($config["time_format"],strtotime($core->helperDate($crono["start_date"],0,10))));
			echo "</div>";	
		}
		
		if($start_date != $core->helperDate($crono["start_date"],0,10) || $section_id!=$crono["section_id"])
		{
			//OBTENER CANTIDAD DE SALAS DEL DIA
			$dia_helper = $core->helperDate($crono["start_date"],0,10);//+(8*$leftPlus)
			echo "<div class='sala' style='
					top: ".$altoAbsoluto."px;
					position: absolute;
					left:".(($posX+(1*($leftPlus-1))).$typeWidth).";
					width:".$tamano_columna.$typeWidth.";
					height:20px;
					background-color:#333333;
					border:1px solid #000000;
					color:white;
					text-align:center'>";//SALA
				$sala = $core->getSalaID($crono["section_id"]);
				echo $sala["name"];
			echo "</div>";		
		
		//CRONOGRAMA		
			$sql = $core->query("SELECT * FROM cronograma WHERE section_id='" . $crono["section_id"] . "' AND SUBSTRING(start_date,1,10)='".$core->helperDate($crono["start_date"],0,10)."' ORDER BY start_date;");
			foreach($sql as $row){
					
				$alto_i = strtotime(substr($row["start_date"],11,18));
				$alto_f = strtotime(substr($row["end_date"],11,18));
				
				$alto = $alto_f - $alto_i;
				$alto = $alto / 900;
				$alto = $alto * $alto_po_carga_horaria;
	
				if($primeraHoraHelper==0){
					$row2 = $core->row("SELECT start_date FROM cronograma ORDER  BY SUBSTRING(start_date,1,16) ASC LIMIT 0,1");
					$PrimeraHora = strtotime(substr($row2["start_date"],11,18));
				}
				$pos = $alto_i - $PrimeraHora;
				$pos = $pos / 900;
				$pos = ($pos * $alto_po_carga_horaria);
				$pos = $pos + ($altoAbsoluto+20);
				
				echo "<div id='". $row["id_crono"] ."' class='div_casillero'  style='position: absolute; ";
				echo "top:".$pos. "px; ";
				
				$posX = ((($tamano_columna) * $desplasamientoDerecha) - $tamano_columna);
				echo "width:".($tamano_columna * 1).$typeWidth."; ";
				echo "height:" . $alto . "px; ";
				echo "left:".($posX+(1*($leftPlus-1))).$typeWidth."; ";//+(8*$leftPlus)
				//tipo actividad
				$tipo_actividad_en_crono = "";
				if($row["tipo_actividad"])
				{
					$core->bind("tipo",$row["tipo_actividad"]);
					$rowT = $core->row("SELECT * FROM tipo_de_actividad WHERE id_tipo_actividad=:tipo");
					echo "background-color:".$rowT["color_actividad"].";";
					
					if($_SESSION["admin"] || $core->helperDate($crono["start_date"],0,10) == '2018-10-17'){
						$tipo_actividad_en_crono = " ".$rowT["tipo_actividad"];
					}
				}
				////ACA TAMBIEN SE MODIFICAO PARA HACER TITULOS
				echo  "overflow:auto; ";
				echo "border:1px solid #ccc;";
				echo "'>";
					echo '<a href="index.php?page=buscarProgramaExtendido&key='.base64_encode($row["id_crono"]).'" target="_blank"></a>';
					//HORA
					$aux_bool = true;
					if($row["tipo_actividad"]) {
						if ($rowT["tipo_actividad"] == "sin horario") {
							$aux_bool = false;
						}
					}
					if ($aux_bool)
						echo '<div style="font-size:8px; text-align:center;" class="hora_actividad" align="left" >' . "<b>" .$core->helperDate($row["start_date"],11,5) . " - " . $core->helperDate($row["end_date"],11,5) .$tipo_actividad_en_crono."</b>";
					if($row["tematica"])
						echo " - <b>". $core->getTematicaID($row["tematica"])["Tematica"] . "</b>";
					if($row["titulo_actividad"])
						/*echo " <b>".substr($row["titulo_actividad"],0,20)."</b>";*/
						echo "<br>";
						echo " <b>". "<span style='font-size:11px;'>" . $row["titulo_actividad"] . "</span>" ."</b>";
					//if($rowT)
						//echo " - ".$rowT["tipo_actividad"];
					echo '</div>';
					//TITULO
					//echo '<div class="titulo">'.$row["titulo_actividad"]."</div>";
					//CONFERENCISTAS
					$sqlC = $core->query("SELECT * FROM crono_conferencistas as cc JOIN conferencistas as c ON c.id_conf=cc.id_conf LEFT JOIN calidades_conferencistas as cf ON cc.en_calidad=cf.ID_calidad WHERE id_crono=".$row["id_crono"]);
					foreach($sqlC as $rowC):
						echo '<div class="conferencistas" style="font-size:11px">'.$templates->CronoConferencsitas($rowC, array("pais"=>false)).'</div>';
					endforeach;
					
					$rowTL = $core->getCronoTL($row["id_crono"]);
					foreach($rowTL as $tl){
						echo $templates->templateTlCronoTXT($tl, "todos");
					}
	
				echo "</div>\n";
				$primeraHoraHelper++;
			}
			//CRONOGRAMA
			$desplasamientoDerecha++;
		}	
		$section_id = $crono["section_id"];
		$start_date = substr($crono["start_date"],0,10);		
	}
			
	
	
}
?>
<script type="text/javascript">
$(document).ready(function(e) {
    $("#buscador").submit(function(e){
		e.preventDefault();
		$.ajax({
			url: "index.php?page=buscarProgramaExtendido",
			cache:false,
			type: 'POST',
			dataType:"json",
			data: "buscador="+$("input[name='buscador']").val()+"&recuadro=1",
			beforeSend: function(){
				$("div").removeClass("found");
			},
			success: function(data) {
				//alert(data.toSource());
				if(data.length>0){
					$.each(data,function(index,key){
						
						$("#"+key).addClass("found");
					})
					$("#resultados").html("<b>Se encontraron "+data.length+" resultados</b>");
				}else{
					$("#resultados").html("<b>No se han encontrado resultados</b>");
				}
			},
			error: function(e,d){
				//alert(e.toSource());
			}
			 
		})	
	})
});
</script>