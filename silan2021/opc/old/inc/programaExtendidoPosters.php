<?

//$tit_act_sin_hora = "Actividad sin horarios";
//if($row["seExpande"] > 2){

if(($row["Casillero"] == $row["sala_agrupada"]) ||($row["sala_agrupada"] == '0')){

	echo "<div class='row'>";//Row
		if($row["Dia_orden"]!=$Dia_orden_){
			echo "<div class='col-xs-12'><h3>".$row["Dia"]."</h3></div>";//Dia
		}
		$Dia_orden_ = $row["Dia_orden"];
		
		if($row["Sala_orden"]!=$Sala_orden_){
			echo "<div class='col-xs-12'><h4>".$row["Sala"]."</h4></div>";//Sala
		}
		$Sala_orden_ = $row["Sala_orden"];
				if($row["Casillero"]!=$Casillero_)
					echo "<div class='col-xs-12 line'></div>";
			echo "<div class='col-xs-2 hora_conf' style='width:120px'>";
					if($row["Casillero"]!=$Casillero_)
						echo substr($row["Hora_inicio"],0,-3)." a ".substr($row["Hora_fin"],0,-3);
			echo "</div>";
			
			echo "<div class='col-xs-10'>";
					if($row["Casillero"]!=$Casillero_)
						echo "<div class='titulo_actividad'>".$row["Titulo_de_actividad"]."</div>";
						
					if($row["Titulo_de_trabajo"]!=""){
						echo "<div class='row'>
								<div class='col-xs-2'></div>
								<div class='col-xs-10'>".$row["Titulo_de_trabajo"]."</div>
						</div>";
					}
					
					if(($row["Nombre"]!="") && ($row["Apellidos"]!="")){
						echo "<div class='row'>";
								echo "<div class='col-xs-2'>". $row["En_calidad"]."</div>";
								echo "<div class='col-xs-10 conferencista'><strong>".$row["Nombre"] . " " . $row["Apellidos"]."</strong></div>";
						echo "</div>";
					}
					
			echo "</div>";
		if($row["Trabajo_libre"]==1){
					$IDS = $trabajos->selectTL_Casillero($row["Casillero"], $unicosArraysID_TL);			
					 while ($row = mysql_fetch_object($IDS)){
						 if(!$sin_resultados){
							 if(in_array($row->ID,$trabajos_busqueda)){
								 require("inc/inc.gestionAutoresPrograma.php");
									echo "<div id='divTL'>";
										require "inc/trabajoLibreExtendidoPosters.php";
									echo "</div>";
							 }
						 }else{
							 require("inc/inc.gestionAutoresPrograma.php");
									echo "<div id='divTL'>";
										require "inc/trabajoLibreExtendidoPosters.php";
									echo "</div>";
						 }
					 }
		}
		
		$Casillero_ = $row["Casillero"];
		
	echo "</div>";//Row

}
//}
?>