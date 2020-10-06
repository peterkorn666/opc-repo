<?
function limpiar($valor) {
		// Retirar las barras 
		if (get_magic_quotes_gpc()) {
			$valor = stripslashes($valor);
		}	
		// Colocar comillas si no es un número o una cadena numérica
		if (!is_numeric($valor)) {
			$valor = "'" . mysql_real_escape_string($valor) . "'";
		}
		return $valor;
}

class actividades{

	var $nCon;
	
	function actividades(){
		$this->nCon = conectarDB();
	}
			
	function persistirActividad($parametros) {	
		$idAct= -1;
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
				//$valores.="\"".$valor."\"";
				$valores.=limpiar($valor);
			}
			$sql="INSERT INTO actividades ($campos) VALUES ($valores)";
				
			$resultado = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error al insertar ".mysql_error());		
			//echo $sql . "<br>";
			$idAct = mysql_insert_id($this->nCon);
		}	
		return $idAct;
	}
	
	function validarPedido($campo, $valor) {
		return $campo . "=" . limpiar($valor);
	}
	
	function editarActividad($parametros, $idAct){
		$resultado=false;
		if (is_array($parametros)) {
			$campos="";
			foreach($parametros as $campo=>$valor) {
				if ($campo!="") {					
					$campos.= $campo. "=" . limpiar($valor) .", ";				
				}
			}			
		}
		if ($campos!=""){
			$campos = substr($campos,0, -2); 
		}		
		if ($campos!=""){
			$sql="UPDATE actividades SET $campos WHERE id='$idAct'";
			$resultado = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error al actualizar");
		}
		
		//echo $sql . "<br><br>";
		return $resultado;
	}
	
	
	function eliminarExtras(){		
		$campos = "";
		$parametros = array("Titulo_de_trabajo", "Titulo_de_trabajo_ing", "observaciones", "idPersona", "archivoPonencia", "confirmado", "mostrarOPC");
		foreach($parametros as $p) {
			$campos .= " AND a1.$p = a2.$p";
		}
		$sql="SELECT * FROM actividades a1 WHERE EXISTS (SELECT * FROM actividades a2 WHERE a2.id<>a1.id AND a1.Casillero=0 AND a2.Casillero<>0 $campos)";
		//echo "<br><br>". $sql . "<br><br>";
		$rs = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error al eliminarExtras" . $sql);	
		while ($row = mysql_fetch_array($rs)){
			$sql2 = "DELETE FROM actividades WHERE id=".$row["id"].";";
			 //echo "<br><br>". $sql2 . "<br><br>";
			 mysql_query($sql2,$this->nCon) or die("Ha ocurrido un error al eliminarExtras" . $sql2);	
		}
		
	}
	
	
}	

?>