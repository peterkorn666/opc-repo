<?php


$casilleros = array(
				12=>6,
				13=>7,
				14=>8,
				15=>9,
				16=>10,
				17=>11,
				18=>12,
				19=>13,
				20=>14,
				21=>15,
				22=>16,
				23=>17,
				24=>18,
				25=>19,
				26=>20,
				27=>21,
				28=>22,
				29=>23,
				30=>24,
				31=>25,
				32=>26,
				33=>27,
				34=>28,
				35=>29,
				36=>30,
				37=>31);


$trabajos = $core->getTrabajosLibres();

foreach($trabajos as $tl){
	if($tl["area_tl"]){
		if($casilleros[$tl["area_tl"]]!="" && $tl["id_crono"]==0 && $tl["estado"]!=3){
			$core->bind("id_crono", $casilleros[$tl["area_tl"]]);
			$core->bind("id_trabajo", $tl["id_trabajo"]);
			$core->query("UPDATE trabajos_libres SET id_crono=:id_crono WHERE id_trabajo=:id_trabajo");
		}
	}else if($tl["area_tl"]==NULL){
		$core->bind("id_crono", 32);
		$core->bind("id_trabajo", $tl["id_trabajo"]);
		$core->query("UPDATE trabajos_libres SET id_crono=:id_crono WHERE id_trabajo=:id_trabajo");
	}
}

header("Location: ".$config["url_opc"]."?page=cronograma");
?>