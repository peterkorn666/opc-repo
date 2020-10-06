<?
include('inc/sesion.inc.php');
include('conexion.php');

$porCual = $_POST["uniSel"]; 
	
foreach ($_POST["uni"] as $i){		
	if($i != $_POST["uniSel"]){	
		////ACTUALIZAR INSTITUCIONES EN LAS PERSONAS DE TRABAJOS LIBRES
			$sqlPTL = "SELECT * FROM personas_trabajos_libres WHERE Institucion='$i';";

			$rsPTL = mysql_query($sqlPTL, $con) or die(mysql_error());
			while($rowPTL = mysql_fetch_array($rsPTL)){
				$sql = "UPDATE personas_trabajos_libres SET Institucion='$porCual' WHERE Institucion='$i';";
				
				mysql_query($sql,$con) or die(mysql_error());
			}
		////////BUSCAR NOMBRE DE LA INSTITUCIION
		$sqlI_old = mysql_query("SELECT * FROM instituciones WHERE ID_Instituciones='$i'",$con) or die(mysql_error());
		$rowI_old = mysql_fetch_array($sqlI_old);
		
		$sqlI_new = mysql_query("SELECT * FROM instituciones WHERE ID_Instituciones='$porCual'",$con) or die(mysql_error());
		$rowI_new = mysql_fetch_array($sqlI_new);
		
		//////ACTUALIZAR INSTITUCION EN LAS PERSONAS
			$sqlP = "SELECT * FROM conferencistas WHERE institucion='".$rowI_old["Institucion"]."';";
			$rsP = mysql_query($sqlP, $con) or die(mysql_error());
			while($rowP = mysql_fetch_array($rsP)){
				$sql = "UPDATE conferencistas SET institucion='".$rowI_new["Institucion"]."' WHERE institucion='".$rowI_old["Institucion"]."';";
				mysql_query($sql,$con) or die(mysql_error());
			}
		//////****
		/////BORRAR LOS QUE NO VAN MAS
			$sql2 = "DELETE FROM instituciones WHERE ID_Instituciones='$i';";
			mysql_query($sql2,$con) or die(mysql_error());
	}else{
		header("Location: altaInstitucion.php?error=1");
	}		
		///------
}


header("Location: altaInstitucion.php");
?>
