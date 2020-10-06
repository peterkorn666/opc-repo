<?php
global $tpl;
$util = $tpl->getVar('util');
//$util->isLogged();
$core = $tpl->getVar('core');
$templates = $tpl->getVar('templates');
$debug = $tpl->getVar('debug');
$core->Debug($debug);

$headers = array(
    "estilos/programaExtendido.css"=>"css",
	"js/programaTL.js"=>"js"
);
$tpl->SetVar('headers',$headers);

$CantActividad = 0;
$CantTL = 0;
$arrayCasilleroParticipantesTL = array();
$arrayCasillerosTL = array();
$unicosArraysCasillero_TL = array();
$arrayIDCongreso = array();
$arrayIDCongresoTL = array();
$unionArraysDistintos = array();
$unicosArraysDistintos = array();

		 /*Armo el array d ela busquda*/
		 $que_busca = $_POST["buscador"];
		 $que_busca = str_replace(":", " ", $que_busca);
		 $que_busca = str_replace(",", " ", $que_busca);
		 $que_busca = trim($que_busca);
		
		
		$arrayBusqueda_ = explode(" ",  $que_busca);
		
		 $arrayBusqueda = array_unique($arrayBusqueda_);
		 sort($arrayBusqueda);
		 if($arrayBusqueda[0] == ""){
		 	array_shift($arrayBusqueda);
		 }

		if(count($arrayBusqueda)>0){
			//Cronograma
			$sqlSearch = "SELECT * FROM cronograma WHERE ";
			foreach($arrayBusqueda as $key => $busqueda){
				if($key>0)
					$sqlSearch .= " OR ";
				$sqlSearch .= "titulo_actividad LIKE '%$busqueda%' ";
			}
			$querySearch = $core->query($sqlSearch);
			foreach($querySearch as $search){
				$unicosArraysDistintos[] = $search["id_crono"];
			}
			//Conferencistas
			$sqlSearch = "SELECT * FROM conferencistas as c JOIN crono_conferencistas as cc ON c.id_conf=cc.id_conf WHERE ";
			foreach($arrayBusqueda as $key => $busqueda){
				if($key>0)
					$sqlSearch .= " OR ";
				$sqlSearch .= "nombre LIKE '%$busqueda%' OR ";
				$sqlSearch .= "apellido LIKE '%$busqueda%' ";
			}
			//echo $sqlSearch.BR.BR;
			$querySearch = $core->query($sqlSearch);
			foreach($querySearch as $search){
				$unicosArraysDistintos[] = $search["id_crono"];
			}
			//echo $sqlSearch;
			//Trabajos Libres
			$sqlSearch = "SELECT * FROM personas_trabajos_libres as p JOIN trabajos_libres_participantes as tp ON p.ID_Personas=tp.ID_participante JOIN trabajos_libres as t ON tp.ID_trabajos_libres=t.id_trabajo WHERE t.id_crono<>0 AND ";
			$sqlSearch .= "(";
			foreach($arrayBusqueda as $key => $busqueda){
				if($key>0)
					$sqlSearch .= " OR ";
				$sqlSearch .= "Nombre LIKE '%$busqueda%' OR ";
				$sqlSearch .= "Apellidos LIKE '%$busqueda%' OR ";
				$sqlSearch .= "numero_tl LIKE '$busqueda' ";
			}
			$sqlSearch .= ")";
			//echo $sqlSearch.BR.BR;
			$querySearch = $core->query($sqlSearch);
			foreach($querySearch as $search){
				$unicosArraysDistintos[] = $search["id_crono"];
			}
			//$unicosArraysDistintos = array_unique($unicosArraysDistintos);
			$unicosArraysDistintos = array_keys(array_flip($unicosArraysDistintos));
		}
		
		if($_POST["recuadro"]==1){
			echo json_encode($unicosArraysDistintos);
			die();
		}
		
		if($_GET["key"]){
				$unicosArraysDistintos[] = base64_decode($_GET["key"]);
		}

		 if(count($unicosArraysDistintos)>0){//
		 	
		 	$sql6 = "SELECT * FROM cronograma as c JOIN salas as s ON s.salaid=c.section_id WHERE ";
		 	$bucle6 = 0;
			$sql6 .= "(";
		 	foreach ($unicosArraysDistintos as $i){

		 		if($bucle6>0){
		 			$sql6 .= " OR ";
		 		}

		 		$sql6 .= " c.id_crono = '$i'";
		 		$bucle6 = $bucle6 + 1;

		 	}
			$sql6 .= ")";
		 	$sql6 .= " ORDER BY SUBSTRING(c.start_date,1,10) ASC;";
            //echo $sql6;
		 	$rs = $core->query($sql6);
			$cantProgram = count($rs);
            $dia_ = "";
            $sala_ = "";
            $helper = 0;
		 	foreach($rs as $row){
		 		//require("inc/programa.inc.php");
				$_SESSION["buscar"] = true;
                $templates->programaExtendido($row,$dia_,$sala_,$helper);
                $dia_ = $core->helperDate($row["start_date"],0,10);
                $sala_ = $row['section_id'];
                $helper++;
		 	}
			///METO EN EL DIV LAS COINCIDENCIAS
			if($cantProgram>0){
				if ($CantActividad!=0){
						$Actividades = "Se han encontrado coincidencias en [ ". $CantActividad ." ] Actividades.<br>";
					}else{
						$Actividades="";
					}
				
				if ($CantTL!=0){
					/*$TLS = "Se han encontrado coincidencias en [ ". $CantTL ." ] Trabajos Libres.";
					echo "<script  language='javascript' type='text/javascript'>
	DIVCantActividad.innerHTML ='". $Actividades . $TLS ."'</script>";*/
				}else{
					$TLS="";
				}
			}else{
				echo "<div id='resultado0'>No se encontraron resultados para su busqueda</div>";
			}
			
			

		 }else{

		 	echo "<div id='resultado0'>No se encontraron resultados para su busqueda</div>";
		 }
		 

?>