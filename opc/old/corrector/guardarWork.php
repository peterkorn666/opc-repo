<?
if($_GET["id"]==""){
	echo "Error #5344";
	die();
}
$id = $_GET["id"];
require("../conexion.php");

$status = "";
$exist = false;
if(!empty($_POST["por_area".$id]))
{
	$sqlT = $con->query("SELECT * FROM trabajos_libres WHERE area_tl='".$_POST["por_area".$id]."' AND estado<>3");
	if(!$sqlT){
		die($con->error);
	}
	if($sqlT->num_row==0)
		echo "No hay trabajos en esta &aacute;rea.";
	while($rowT = $sqlT->fetch_array()){
		//verifico que el trabajo ya no este adjudicado
		$sqlV = $con->query("SELECT * FROM evaluaciones WHERE idEvaluador='$id' AND numero_tl='".$rowT["numero_tl"]."'");
		if($sqlV->num_row==0)
		{
			if($con->query("INSERT INTO evaluaciones (idEvaluador,numero_tl,fecha_asignado) VALUES ('$id','".$rowT["numero_tl"]."','".date("Y-m-d")."')"))
			{
				$status .= "El trabajo ".$rowT["numero_tl"]." fue agregado.<br>";
			}else{
				$status .= "No se puede guardar el trabajo ".$rowT["numero_tl"];
			}
		}
			
	}
}else if(count($_POST["trabajos".$id])>0)
{
	for($i=0;$i<count($_POST["trabajos".$id]);$i++){
		if($_POST["trabajos".$id][$i]!=""){
	
	$sqlExist = "SELECT * FROM evaluaciones WHERE idEvaluador='$id' AND numero_tl='".$_POST["trabajos".$id][$i]."' ORDER BY numero_tl";
	$queryExist = $con->query($sqlExist);
			if($queryExist->num_row>=1){
				$exist = true;
			}
	
			if(!$exist){
				$sql = "INSERT INTO evaluaciones (idEvaluador,numero_tl,fecha_asignado) VALUES ('$id','".$_POST["trabajos".$id][$i]."','".date("Y-m-d")."')";
				if($con->query($sql)){
					$status .= "El trabajo ".$_POST["trabajos".$id][$i]." fue agregado.<br>";
				}else{
					$status .= "No se puede guardar el trabajo ".$_POST["trabajos"][$i];
				}
				$numero_tl = "";
			}else{
				$status .= "El trabajo ".$_POST["trabajos".$id][$i]." ya est&aacute; asignado a este evaluador.<br>";
			}
		}
		$exist = false;
	}
}

echo $status;

?>