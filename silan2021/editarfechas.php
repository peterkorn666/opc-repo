<?php
	require("init.php");

	$db = \DB::getInstance();
	
	$crono = $db->query("SELECT id_crono, start_date, end_date FROM cronograma")->results();
	foreach($crono as $row){
		$cambios_inicio = true;
		$dia_inicio = substr($row["start_date"], 0, 10);
		$hora_inicio = substr($row["start_date"], 10);
		if($dia_inicio == "2017-10-24"){
			
			$nuevo_dia_inicio = "2019-10-22".$hora_inicio;
		}else if($dia_inicio == "2017-10-25"){
			
			$nuevo_dia_inicio = "2019-10-23".$hora_inicio;
		}else if($dia_inicio == "2017-10-26"){
			
			$nuevo_dia_inicio = "2019-10-24".$hora_inicio;
		}else if($dia_inicio == "2017-10-27"){
			
			$nuevo_dia_inicio = "2019-10-25".$hora_inicio;
		}else{
			$cambios_inicio = false;
			$nuevo_dia_inicio = $row["start_date"];
		}
		
		$cambios_fin = true;
		$dia_fin = substr($row["end_date"], 0, 10);
		$hora_fin = substr($row["end_date"], 10);
		if($dia_fin == "2017-10-24"){
			
			$nuevo_dia_fin = "2019-10-22".$hora_fin;
		}else if($dia_fin == "2017-10-25"){
			
			$nuevo_dia_fin = "2019-10-23".$hora_fin;
		}else if($dia_fin == "2017-10-26"){
			
			$nuevo_dia_fin = "2019-10-24".$hora_fin;
		}else if($dia_fin == "2017-10-27"){
			
			$nuevo_dia_fin = "2019-10-25".$hora_fin;
		}else{
			$cambios_fin = false;
			$nuevo_dia_fin = $row["start_date"];
		}
		
		if($cambios_inicio || $cambios_fin){
			$db->query("UPDATE cronograma SET start_date=?, end_date=? WHERE id_crono=?", 
							[
								$nuevo_dia_inicio, 
								$nuevo_dia_fin, 
								$row["id_crono"]
							]
						);
		}
	}

	echo "Termino";
?>