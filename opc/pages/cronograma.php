<?php
global $tpl;
$core = $tpl->getVar('core');
$templates = $tpl->getVar('templates');
$debug = $tpl->getVar('debug');
$config = $tpl->getVar('config');
$util = $tpl->getVar('util');
$core->Debug($debug);
//$util->isLogged();
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

//CONFIG
$desplasamientoDerecha = 1;
//alto de las cargas horarias
$alto_po_carga_horaria = 35;
$bannerheight = GetImageSize($config["banner_congreso"]);
//Posicion del crono con respecto al banner 
$altoAbsoluto = $bannerheight[1]-675;

//MOSTRAR TODOS LOS DAIS
$sqlDias = $core->query("SELECT start_date,end_date,section_id FROM cronograma GROUP BY SUBSTRING(start_date,1,10) ORDER BY SUBSTRING(start_date,1,10) ASC");
echo "<div id='container_dias'>";
$h = 0;
foreach($sqlDias as $key => $dias)
{
	if($key==0)
		$primerDia = $core->helperDate($dias["start_date"],0,10);
	$chk = "";
	if($_GET["day"]==$core->helperDate($dias["start_date"],0,10) || (empty($_GET["day"]) && $h==0))
		$chk = "day_selected";
	echo "<div class='dias_cronograma'><a href='?page=cronograma&day=".$core->helperDate($dias["start_date"],0,10)."' class='$chk'>".utf8_encode(strftime($config["time_format"],strtotime($core->helperDate($dias["start_date"],0,10))))."</a></div>";
	++$h;
}
echo "</div>";
if($get["day"])
	$toDay = $get["day"];
else
	$toDay = $primerDia;

$visible_salas = '';
if(!$_SESSION["admin"]){
    $visible_salas = 'AND s.visible=1';
}

$getTotalSalas = $core->query("SELECT c.section_id, c.start_date FROM cronograma c JOIN salas s ON c.section_id=s.salaid WHERE SUBSTRING(c.start_date,1,10)='$toDay' $visible_salas GROUP BY c.section_id ORDER BY c.section_id DESC");
//$getTotalSalas = $core->query("SELECT section_id,start_date FROM cronograma WHERE SUBSTRING(start_date,1,10)
//='$toDay' GROUP BY section_id ORDER BY section_id DESC");
//DEFINIR EL TAMAÑO DE LAS SALAS
//$escala = "%";
$escala = "px";
if($escala=="%")
	$tamano_columna = 180/count(($getTotalSalas?$getTotalSalas:1));
else
	$tamano_columna = 400;

//OBTENER SALAS DEL CRONO
$sqlCrono = $core->query("SELECT c.start_date,c.end_date,c.section_id, s.salaid, s.orden FROM cronograma as c JOIN salas as s ON c.section_id=s.salaid WHERE SUBSTRING(start_date,1,10)='$toDay' $visible_salas GROUP BY section_id ORDER BY s.orden, c.start_date ASC");
//$sqlCrono = $core->query("SELECT c.start_date,c.end_date,c.section_id, s.salaid, s.orden FROM cronograma as c JOIN
// salas as s ON c.section_id=s.salaid WHERE SUBSTRING(start_date,1,10)='$toDay' GROUP BY section_id ORDER BY s.orden, c.start_date ASC");
foreach($sqlCrono as $crono)
{
	if($core->helperDate($crono["start_date"],0,10)!=$start_date)
	{

//			echo $crono["start_date"]." - ".$crono["end_date"];

	}
			$posX = (($tamano_columna * $desplasamientoDerecha) - $tamano_columna);
			echo "<div class='sala' style='
					top: ".$altoAbsoluto."px;
					position: absolute;
					left:".$posX.$escala.";
					width:".$tamano_columna.$escala.";
					height:20px;
					background-color:#333333;
					border:1px solid #000000;
					color:white;
					text-align:center'>";//SALA
				$sala = $core->getSalaID($crono["section_id"]);
				echo $sala["name"];
			echo "</div>";	
			
			
		//CRONOGRAMA
			$sql = $core->query("SELECT * FROM cronograma WHERE section_id='" . $crono["section_id"] . "' and SUBSTRING(start_date,1,10) = '$toDay' ORDER BY start_date;");
			foreach($sql as $row){
				$alto_f = strtotime(substr($row["end_date"],11,18));
				$alto_i = strtotime(substr($row["start_date"],11,18));
				$alto = $alto_f - $alto_i;

		//separacion entre actividades, mientras mayor sea la division mayor sera la separacion
				$alto = $alto / 900;
				$alto = $alto * $alto_po_carga_horaria;
	
				$row2 = $core->row("SELECT start_date FROM cronograma where SUBSTRING(start_date,1,10) = '$toDay' ORDER  BY SUBSTRING(start_date,11,18) ASC LIMIT 0,1");
				$PrimeraHora = strtotime(substr($row2["start_date"],11,18));
				$pos = $alto_i - $PrimeraHora;

				$pos = $pos / 900;
				$pos = ($pos * $alto_po_carga_horaria);				
				$pos = $pos + ($altoAbsoluto+22);
				
				echo "<div id='". $row["id_crono"] ."' class='div_casillero' style=' position: absolute; ";
				echo "top:".$pos. "px; ";
				
				$posX = ((($tamano_columna) * $desplasamientoDerecha) - $tamano_columna);
				echo "width:".($tamano_columna * 1) . "$escala; ";
				echo "height:" . $alto . "px; ";
				echo "left:".($posX)."$escala; ";
				
			//tipo actividad
				$rowT = array();
				if($row["tipo_actividad"])
				{
					$core->bind("tipo",$row["tipo_actividad"]);
					$rowT = $core->row("SELECT * FROM tipo_de_actividad WHERE id_tipo_actividad=:tipo");
					echo "background-color:".$rowT["color_actividad"].";";
				}
				echo  "overflow:auto; ";
				echo "border:1px solid #ccc;";
				echo "'>";
					echo '<a href="index.php?page=buscarProgramaExtendido&key='.base64_encode($row["id_crono"]).'" target="_blank"></a>';
			//HORA
					echo '<div class="hora_actividad">'.$core->helperDate($row["start_date"],11,5);
					// - ".$core->helperDate($row["end_date"],11,5);
					//if($rowT)
						//echo " - ".$rowT["tipo_actividad"];
						/*if($row["tematica"])
							echo " - <b>".$core->getTematicaID($row["tematica"])["Tematica"]."</b>";*/
						if($row["titulo_actividad"])
							echo ' <b class="titulo" style="color:#294791;font-size:11px"> '.$row["titulo_actividad"]."</b>";
					echo '</div>';
			//TITULO
					//echo '<div class="titulo">'.$row["titulo_actividad"]."</div>";

			//TRABAJOS LIBRES
					$rowTL = $core->getCronoTL($row["id_crono"]);
					foreach($rowTL as $tl)
						echo $templates->templateTlCronoTXT($tl);
	
			//CONFERENCISTAS
					$sqlC = $core->query("SELECT * FROM crono_conferencistas as cc JOIN conferencistas as c ON c.id_conf=cc.id_conf WHERE id_crono=".$row["id_crono"]);
					foreach($sqlC as $rowC):
						echo '<div class="conferencistas">'.$templates->CronoConferencistas($rowC, ["profesion" => false, "calidad" => false]).'</div>';
					endforeach;
					
				echo "</div>\n";
			}
			
			//CRONOGRAMA
			
			
	$section_id = $crono["section_id"];
	$start_date = substr($crono["start_date"],0,10);
	
	$desplasamientoDerecha++;
	
}
?>