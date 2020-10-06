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
	
class baseController{
	
	var $nCon;
	var $idioma;
	
	function baseController(){
		$this->nCon = conectarDB();
	}
		
	/*
	inserta en tabla $tabla los valores $camposValores que vienen en formato "campo"=>valor
	*/
	function insertarEnBase($tabla, $camposValores){
		$resultado=false;
		if (is_array($camposValores)) {
			$campos="";
			$valores="";
			foreach($camposValores as $campo=>$valor) {
				if ($campos!="") {
					$campos.=",";
				}
				$campos.=$campo;
				if ($valores!="") {
					$valores.=",";
				}
				$valores.=limpiar($valor);
			}
			$sql="INSERT INTO $tabla ($campos) VALUES ($valores)";
			$resultado = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error al insertar");
		}	
		
		return $resultado;
	}
	
	/*
	valida la variable campo para un where 
	*/
	function validarPedido($campo, $valor) {
		return $campo . "=" . limpiar($valor);
	}
	
	/*
	corrige el nombre de un archivo $donde 
	*/
	function validarArchivo($donde){
		$valor = str_replace(" ", "_" , $donde);
		$valor = str_replace(",", "_" , $valor);
		$valor = str_replace("á", "a" , $valor);
		$valor = str_replace("é", "e" , $valor);
		$valor = str_replace("í", "i" , $valor);
		$valor = str_replace("ó", "o" , $valor);
		$valor = str_replace("ú", "u" , $valor);
		$valor = str_replace("´", "" , $valor);
		$valor = str_replace(" ", "_" , $valor);
		return $valor;
	}
	
	/*
	realiza un update en $tabla con la informacion de $camposValores (en formato $campo=>valor) donde $camposWhere indica el where
	*/
	function updateEnBase($tabla, $camposValores, $camposWhere){
		$resultado=false;
		if (is_array($camposValores)) {
			$campos="";
			foreach($camposValores as $campo=>$valor) {
				if ($campo!="") {					
					$campos.= $campo. "=" . limpiar($valor) .", ";				
				}
			}			
		}
		if ($camposWhere==""){
			$camposWhere = "1";
		}
		if ($campos!=""){
			$campos = substr($campos,0, -2); 
		}		
		if ( ($tabla!="") && ($campos!="") ){
			$sql="UPDATE $tabla SET $campos WHERE $camposWhere";
			$resultado = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error al actualizar ".mysql_error());
		}
		return $resultado;
	}
	
	/*
	borra en $table donde $camposWhere indica el where
	*/
	function borrarEnBase($tabla, $camposWhere){
		if ( ($tabla!="") && ($camposWhere!="") ){
			$sql="DELETE FROM $tabla WHERE $camposWhere";
			$resultado = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error al eliminar filas");
		}
	}
	
	
	
	/*function cargarDeBase($tabla, $camposValores, $camposWhere){
		$resultado=false;
		if (is_array($camposValores)) {
			$campos="";
			foreach($camposValores as $campo) {
				if ($campo!="") {					
					$campos.= $campo. ", ";				
				}
			}			
		}
		if ($camposWhere==""){
			$camposWhere = "1";
		}
		if ($campos!=""){
			$campos = substr($campos,0, -2); 
		} else {	
			$campos = "*";
		}	
		if ( ($tabla!="") && ($campos!="") ){
			$sql="SELECT $campos FROM $tabla WHERE $camposWhere";
			$resultado = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error al actualizar");
		}
		return $resultado;
	}*/
	
	function areasActividad(){
		$sql = "SELECT * FROM areas_trabjos_libres";
		$query = mysql_query($sql,$this->nCon);
		return $query;
	}
	
	function getAreasActividad($id){
		$sql = "SELECT * FROM areas_trabjos_libres WHERE id='$id'";
		$query = mysql_query($sql,$this->nCon);
		$row = mysql_fetch_object($query);
		if($id==7){
			$row->area_abr = "Protocolar";
		}else if($id==8){
			$row->area_abr = "Varias &aacute;reas";
		}else if($id==9){
			$row->area_abr = "Congreso";
		}
		return $row->area_abr;
	}
	
	function getInscriptos(){
		$sql = "SELECT * FROM inscriptos ORDER BY fecha DESC";
		$query = mysql_query($sql,$this->nCon);
		
		return $query;
	}
	
	function getRoles(){
		$sql = "SELECT * FROM en_calidades ORDER BY ID_En_calidad";
		$query = mysql_query($sql,$this->nCon);
		return $query;
	}
	
	

}
?>