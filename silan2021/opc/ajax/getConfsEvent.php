<?
header('Content-Type: text/html; charset=UTF-8');

if($_POST["id"]!=""){
	require("../codebase/config.php");
	$db = conectaDb();
		
	$sql = $db->prepare("SELECT * FROM crono_conferencistas WHERE id_crono=? ORDER BY id ASC");
	$sql->bindValue(1,$_POST["id"]);
	$sql->execute() or die(json_encode(print_r($db->errorInfo())));
	if($sql->rowCount()>0)
	{
		$personas = array();
		$helper = 0;
		while($row = $sql->fetch())
		{
			//GET INFO CONF
			$sqlC = $db->prepare("SELECT * FROM conferencistas WHERE id_conf=?");
			$sqlC->bindValue(1,$row["id_conf"]);
			$sqlC->execute();
			$rowC = $sqlC->fetch();
			$personas[$helper]["id_crono"] = $row["id_crono"];
			$personas[$helper]["id_conf"] = $row["id_conf"];
			$personas[$helper]["nombre"] = $rowC["nombre"];
			$personas[$helper]["apellido"] = $rowC["apellido"];
			$personas[$helper]["institucion"] = $rowC["institucion"];
			$personas[$helper]["pais"] = $rowC["pais"];
			$personas[$helper]["en_calidad"] = $row["en_calidad"];
			$personas[$helper]["titulo_conf"] = $row["titulo_conf"];
			$personas[$helper]["observaciones_conf"] = $row["observaciones_conf"];
			$personas[$helper]["mostrar_ponencia"] = $row["mostrar_ponencia"];
			$personas[$helper]["en_crono"] = $row["en_crono"];
			$helper++;
		}
		echo json_encode($personas);
	}else
		echo json_encode("not found");
}
?>