<?
include "class.Actividades.php";
class casillero{

	var $nCon;
	var $actividades;
	var $actividad;
	
	function casillero(){
		$this->nCon = conectarDB();
		$this->actividades = array(); //respaldo momentaneo
		$this->nroActividades = 0;
		$this->actividad = new actividades();
	}	
	
	function respaldarActividades($idCasillero){
		$sql = "SELECT * FROM congreso WHERE Casillero = '$idCasillero' AND ID_persona<>'0';";
		$rs = mysql_query($sql, $this->nCon);
		while ($row = mysql_fetch_array($rs)){
			if ($row["desdeSistema"]==0){
				//si no hay un respaldo en la tabla de actividades lo creo
				$parametros = array (					
					"Casillero"=>$row["Casillero"] ,
					"Titulo_de_trabajo"=>$row["Titulo_de_trabajo"] ,
					"Titulo_de_trabajo_ing"=>$row["Titulo_de_trabajo_ing"] ,
					"observaciones"=>$row["observaciones"] ,
					"idPersona"=>$row["ID_persona"] ,
					"archivoPonencia"=>$row["archivoPonencia"] ,
					"confirmado"=>$row["confirmado"] ,
					"mostrarOPC"=>$row["mostrarOPC"]
				);
				$idAct = $this->actividad->persistirActividad($parametros);				
				//guardo la referencia
				$sql2 = "UPDATE congreso SET desdeSistema='".$idAct."' WHERE ID = '".$row["ID"]."'";
				//echo $sql2 . "<br><br>";
				mysql_query($sql2, $this->nCon);
				
				array_push($this->actividades, $idAct);
				$this->nroActividades += 1;
			} else {
				array_push($this->actividades, $row["desdeSistema"]);				
				$this->nroActividades += 1;
			}
		}			
	}
			
	function persistirCasillero($parametros) {
	$resultado=false;
	if (is_array($parametros)) {
		$campos="";
		$valores="";
		foreach($parametros as $campo=>$valor) { // recorre el array de parametros y arma la consulta
			if ($campos!="") {
				$campos.=",";
			}
			$campos.=$campo;
			if ($valores!="") {
				$valores.=",";
			}
			$valores.="\"".addslashes($valor)."\"";
		}
		$sql="INSERT INTO congreso ($campos) VALUES ($valores)";		
		$resultado = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error al insertar un casillero: ".mysql_error());
		
	}	
		//echo $sql."<br>";
		//echo "FFFIIINNN";
		//echo "<br><br><br><br>";
		return $resultado;
	}
	
	function reasignarActividades($casillero){
		$acts = array();
		
		$sql = "SELECT * FROM congreso WHERE Casillero = '$casillero';";
		$rs = mysql_query($sql, $this->nCon);
		//echo $sql . "<br><br>";
		while ($row = mysql_fetch_array($rs)){		
			if ( ($row["ID_persona"]==0) && ($row["desdeSistema"]!=0) ){
				//desasigno el casillero en la actividad				
				$sql1 = "UPDATE actividades SET Casillero ='0' WHERE id  = '".$row["desdeSistema"]."'";
				//echo $sql1 . "<br><br>";
				//mysql_query($sql1, $this->nCon);
				//desasigno la actividad en el casillero				
				$sql2 = "UPDATE congreso SET desdeSistema='0' WHERE ID = '".$row["ID"]."'";
				mysql_query($sql2, $this->nCon);
				//echo $sql2 . "<br><br>";
			} else {
				if ( ($row["ID_persona"]!=0) && ($row["desdeSistema"]!=0) ){
					//chequeo que sea la actividad correspondiente
					$sql3 = "SELECT * FROM actividades WHERE id  = '".$row["desdeSistema"]."'";
					$rs3 = mysql_query($sql3, $this->nCon);
					//echo $sql3 . "<br><br>";
					if ($row3 = mysql_fetch_array($rs3)){
						if ($row["ID_persona"] == $row3["idPersona"]){
							//es la misma, entonces la actualizo
							$parametros4 = array (					
								"Casillero"=>$row["Casillero"] ,
								"Titulo_de_trabajo"=>$row["Titulo_de_trabajo"] ,
								"Titulo_de_trabajo_ing"=>$row["Titulo_de_trabajo_ing"] ,
								"observaciones"=>$row["observaciones"] ,
								"idPersona"=>$row["ID_persona"] ,
								"archivoPonencia"=>$row["archivoPonencia"] ,
								"confirmado"=>$row["confirmado"] ,
								"mostrarOPC"=>$row["mostrarOPC"]
							);
							//$endonde4 = $this->actividad->validarPedido("id", $row["desdeSistema"]);
							$this->actividad->editarActividad($parametros4, $row["desdeSistema"]);	
							/*$sql4 = "UPDATE actividades SET
							Titulo_de_trabajo = '".$row["Titulo_de_trabajo"]."', 
							Titulo_de_trabajo_ing = '".$row["Titulo_de_trabajo_ing"]."', 
							observaciones = '".$row["observaciones"]."',  
							archivoPonencia = '".$row["archivoPonencia"]."', 
							confirmado = '".$row["confirmado"]."', 
							mostrarOPC = '".$row["mostrarOPC"]."'							
							WHERE id  = '".$row["desdeSistema"]."'";
							mysql_query($sql4, $this->nCon);
							echo $sql4 . "<br><br>";*/
							$acts[$row["desdeSistema"]]="si";
							
						} else {
							//no es la misma, entonces desasigno de actividad
							//echo "--------------- no es la misma, entonces desasigno de actividad ---------------";
							$sql5 = "UPDATE actividades SET Casillero = '0'	WHERE id  = '".$row["desdeSistema"]."'";
							mysql_query($sql5, $this->nCon);
							//echo $sql5 . "<br><br>";
							//y hago una nueva
							$parametros6 = array (					
								"Casillero"=>$row["Casillero"] ,
								"Titulo_de_trabajo"=>$row["Titulo_de_trabajo"] ,
								"Titulo_de_trabajo_ing"=>$row["Titulo_de_trabajo_ing"] ,
								"observaciones"=>$row["observaciones"] ,
								"idPersona"=>$row["ID_persona"] ,
								"archivoPonencia"=>$row["archivoPonencia"] ,
								"confirmado"=>$row["confirmado"] ,
								"mostrarOPC"=>$row["mostrarOPC"]
							);
							$idAct = $this->actividad->persistirActividad($parametros6);	
							//guardo la referencia
							$sql7 = "UPDATE congreso SET desdeSistema='".$idAct."' WHERE ID = '".$row["ID"]."'";
							mysql_query($sql7, $this->nCon);
							//echo $sql7 . "<br><br>";
						}
					}
				
				} else {
					//si no hay un respaldo en la tabla de actividades lo creo
					//echo "--------------- si no hay un respaldo en la tabla de actividades lo creo ---------------";
					$parametros8 = array (					
								"Casillero"=>$row["Casillero"] ,
								"Titulo_de_trabajo"=>$row["Titulo_de_trabajo"] ,
								"Titulo_de_trabajo_ing"=>$row["Titulo_de_trabajo_ing"] ,
								"observaciones"=>$row["observaciones"] ,
								"idPersona"=>$row["ID_persona"] ,
								"archivoPonencia"=>$row["archivoPonencia"] ,
								"confirmado"=>$row["confirmado"] ,
								"mostrarOPC"=>$row["mostrarOPC"]
							);
					/*$sql8 = "INSERT INTO actividades (Casillero, Titulo_de_trabajo, Titulo_de_trabajo_ing, observaciones, idPersona, archivoPonencia, confirmado, mostrarOPC) VALUES ('".$row["Casillero"]."', '".$row["Titulo_de_trabajo"]."', '".$row["Titulo_de_trabajo_ing"]."', '".$row["observaciones"]."', '".$row["ID_persona"]."', '".$row["archivoPonencia"]."', '".$row["confirmado"]."', '".$row["mostrarOPC"]."')";
					mysql_query($sql8, $this->nCon);
					$idAct = mysql_insert_id($this->nCon);
					echo $sql8 . "<br>";*/
					$idAct = $this->actividad->persistirActividad($parametros8);	
					//guardo la referencia
					$sql9 = "UPDATE congreso SET desdeSistema='".$idAct."' WHERE ID = '".$row["ID"]."'";
					//echo $sql9 . "<br>";
					mysql_query($sql9, $this->nCon);
				}
				
			}			
		}
		//echo "Nro actividad es: ". $this->nroActividades . "<br><br>";
		//echo "Y son: <br>";
		//print_r($this->actividades);
		//echo "<br><br>";
		//echo "Y las actualizaciones son: <br>";
		//print_r($acts);
		//echo "<br><br>";
		
		for($i=0; $i<$this->nroActividades; $i++){
			//echo "Entre al for y voy a ver el valor de ".$i." , que vale: ". $acts[$this->actividades[$i]]."<br><br>";
			if ($acts[$this->actividades[$i]]!="si"){
				//si nunca la actualice la desasigno
				$sql8 = "UPDATE actividades SET Casillero = '0'	WHERE id  = '".$this->actividades[$i]."'";
				mysql_query($sql8, $this->nCon);
				//echo $sql8 . "<br><br>";
			}
		}
		
		$this->actividad->eliminarExtras();
		
		//exit();
	}
	
	
	
}	

?>