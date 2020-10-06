<?
class traductor{
	var $nCon;
	var $idioma;	
	function traductor(){
		$this->nCon = conectarDB();
	}	
	function setIdioma($idioma){
		if ($idioma == "ing"){
			$this->idioma = "_ing";
		} else {
			$this->idioma = "";
		}		
	}	
	function nombreDia($dia_orden){
		$campo = "Dia".$this->idioma;
		$sql = "SELECT ".$campo." FROM dias WHERE Dia_orden='".$dia_orden."';";
		$rs = mysql_query($sql, $this->nCon);
		if ($row = mysql_fetch_array($rs)) {
			return $row[$campo];
		} else {
			return "";
		}
	}
	function nombreSala($sala_orden){
		$campo = "Sala".$this->idioma;
		$sql = "SELECT ".$campo." FROM salas WHERE Sala_orden='".$sala_orden."';";
		$rs = mysql_query($sql, $this->nCon);
		if ($row = mysql_fetch_array($rs)) {
			return $row[$campo];			
		}else{
			return "";
		}
	}	
	function enCalidad($enC){
		$campo = "En_calidad".$this->idioma;
		$sql = "SELECT ".$campo." FROM en_calidades WHERE En_calidad='".$enC."';";
		$rs = mysql_query($sql, $this->nCon);
		if ($row = mysql_fetch_array($rs)) {
			return $row[$campo] . ": ";
		} else {
			return "";
		}
	}	
	function getPais($pais){
		$p = "";
		if ($pais!="") {
			$campo = "Pais".$this->idioma;
			$sql = "SELECT ".$campo." FROM paises WHERE Pais='".$pais."';";
			$rs = mysql_query($sql, $this->nCon);
			if ($row = mysql_fetch_array($rs)) {
				$p = "(". trim($row[$campo]) . ")";
			} 
		} 
		if($p=="()"){
			$p="";
		}
		return $p;		
	}	
	function cargarTraductor($row){	
		//$this->Titulo_de_actividad = $row["Titulo_de_actividad".$this->idioma];						
		//$this->Titulo_de_trabajo = $row["Titulo_de_trabajo".$this->idioma];				
		if ($row["Titulo_de_actividad_ing"]!=""){	
			$this->Titulo_de_actividad = $row["Titulo_de_actividad".$this->idioma];						
		} else	{
			$this->Titulo_de_actividad = $row["Titulo_de_actividad"];							
		}
		if ($row["Titulo_de_trabajo_ing"]!=""){
			$this->Titulo_de_trabajo = $row["Titulo_de_trabajo".$this->idioma];				
		} else {
			$this->Titulo_de_trabajo = $row["Titulo_de_trabajo"];				
		}		
	}	
	function setTipo_de_actividad($row){		
		//$this->Tipo_de_actividad = $row["Tipo_de_actividad".$this->idioma];
		if ($row["Tipo_de_actividad_ing"]!=""){
			$this->Tipo_de_actividad = $row["Tipo_de_actividad".$this->idioma];
		}else if(!(empty($row["Tipo_de_actividad"]))){
			$this->Tipo_de_actividad = $row["Tipo_de_actividad"];
		}else{
			$this->Tipo_de_actividad = "";
		}
	}	
	function getTipo_de_actividad(){		
		return $this->Tipo_de_actividad;
	}	
	function getTitulo_de_actividad(){		
		return $this->Titulo_de_actividad;
	}		
	function getTitulo_de_trabajo(){		
		return $this->Titulo_de_trabajo;
	}
}	
?>