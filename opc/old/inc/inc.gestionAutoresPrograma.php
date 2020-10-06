<?
$nombre = $nombreAutores[$row->ID];
$apellido = $apellidoAutores[$row->ID];
$institucion= $institucionAutores[$row->ID];
$lee = $leeAutores[$row->ID];
$inscripto = $inscriptoAutores[$row->ID];
$gestionAutores="";
$arrayPersonas = array();
$arrayInstituciones = array();

for($i=0; $i<count($nombre); $i++){
	array_push($arrayInstituciones , $institucion[$i]);
	if($lee == ($i+1)){
		$leeOno = 1;
	}else{
		$leeOno = 0;
	}
	array_push($arrayPersonas, array($institucion[$i], $apellido[$i], $nombre[$i], $leeOno , $inscripto[$i]));
}
$arrayInstitucionesUnicas = array_unique($arrayInstituciones);
$arrayInstitucionesUnicasNuevaClave = array();
if(count($arrayInstitucionesUnicas)>0){
	foreach ($arrayInstitucionesUnicas as $u){
		if($u!=""){
			array_push($arrayInstitucionesUnicasNuevaClave, $u);
		}
	}
}
$autoreInscriptos = "";
for ($i=0; $i < count($arrayPersonas); $i++){
	if($i>0){
		$gestionAutores .= "; ";
	}
	if($arrayPersonas[$i][0]!=""){
		$claveIns = (array_search($arrayPersonas[$i][0] ,$arrayInstitucionesUnicasNuevaClave))+1;
	}else{
		$claveIns = "";
	}
	if($arrayPersonas[$i][3]==1){
		$gestionAutores .= "<u>";
	}
	if($arrayPersonas[$i][4]==1){
		//$autoreInscriptos .= $arrayPersonas[$i][1] . ", " . $arrayPersonas[$i][2] . "<br>";
	}
	$gestionAutores .= "<b>";
	if(count($busqueda_string)>0){
		if(in_array(mb_strtolower(trim($arrayPersonas[$i][1]), 'UTF-8'), $busqueda_string)){
			$gestionAutores .= "<span class='found'>";
		}
	}
	$gestionAutores .= $arrayPersonas[$i][1];
	if(count($busqueda_string)>0){
		if(in_array(mb_strtolower(trim($arrayPersonas[$i][1]), 'UTF-8'), $busqueda_string)){
			$gestionAutores .= "</span>";
		}
	}
	
	$gestionAutores .= ", ";
	if(count($busqueda_string)>0){
		if(in_array(mb_strtolower(trim($arrayPersonas[$i][2]), 'UTF-8'), $busqueda_string)){
			$gestionAutores .= "<span class='found'>";
		}
	}
	$gestionAutores .= $arrayPersonas[$i][2];
	if(count($busqueda_string)>0){
		if(in_array(mb_strtolower(trim($arrayPersonas[$i][2]), 'UTF-8'), $busqueda_string)){
			$gestionAutores .= "</span>";
		}
	}
	$gestionAutores .= "</b>";
	
	if($arrayPersonas[$i][3]==1){
		$gestionAutores .= "</u>";
		//$autorPresentador = $arrayPersonas[$i][1] . ", " . $arrayPersonas[$i][2];
	}
	$gestionAutores .= "<sup>" . $claveIns . "</sup>";
}
$gestionAutores .="<br>";
for ($i=0; $i < count($arrayInstitucionesUnicasNuevaClave); $i++){
		
	$gestionAutores .= "<i>";
	$gestionAutores .=  ($i+1) . " - " . $arrayInstitucionesUnicasNuevaClave[$i] . ". ";
	$gestionAutores .= "</i>";
}

?>