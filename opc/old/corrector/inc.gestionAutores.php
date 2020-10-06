<?
$nombre = $_SESSION["nombre"];
$apellido = $_SESSION["apellido"];
$institucion= $_SESSION["institucion"];
$pais = $_SESSION["pais"];
$lee = $_SESSION["lee"];
$inscripto = $_SESSION["inscripto"];


$gestionAutores="";

$arrayPersonas = array();
$arrayInstituciones = array();

for($i=0; $i<count($nombre); $i++){
	
	if($lee == ($i+1)){
		$leeOno = 1;
	}else{
		$leeOno = 0;
	}
	$getIns = $con->query("SELECT * FROM instituciones WHERE ID_Instituciones='".safes($institucion[$i])."'");
	$rowIns = $getIns->fetch_array();
	$getPais = $con->query("SELECT * FROM paises WHERE ID_Paises='".safes($pais[$i])."'");
	$rowPais = $getPais->fetch_array();	
	array_push($arrayInstituciones , $rowIns["Institucion"]);
	array_push($arrayPersonas, array($rowIns["Institucion"], $apellido[$i], $nombre[$i], $leeOno , $inscripto[$i],$rowPais["Pais"]));
	
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
		$autoreInscriptos .= $arrayPersonas[$i][1] . ", " . $arrayPersonas[$i][2] . "<br>";
	}


	$gestionAutores .= "<b>" . $arrayPersonas[$i][1] . ", " . $arrayPersonas[$i][2] . "</b>";
	
	if($arrayPersonas[$i][3]==1){
		$gestionAutores .= "</u>";
		$autorPresentador = $arrayPersonas[$i][1] . ", " . $arrayPersonas[$i][2];
	}
	$gestionAutores .= "<sup>" . $claveIns . "</sup>";


}

$gestionAutores .= "<br><i>";

for ($i=0; $i < count($arrayInstitucionesUnicasNuevaClave); $i++){


	$gestionAutores .=  ($i+1) . " - " . $arrayInstitucionesUnicasNuevaClave[$i] . ", (".$arrayPersonas[$i][5].")<br>";

}

$gestionAutores .= "</i>";

?>