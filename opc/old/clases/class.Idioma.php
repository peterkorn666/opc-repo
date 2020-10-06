<?
class idioma{
	var $idiomas;
	var $cantIdiomas;
	var $activo;
	var $nroActivo;	
	//CONSTRUCTOR idioma($nro)	
	/**
		Esta función habilita los idiomas con los que trabajara la página.
		El parametro recibido indicara cual es el idioma activo y en caso de no recibir uno asumira que este es el idioma 0 (Español)
	**/
	function idioma($nro = 0){		
		$this->nroActivo = $nro;		
		$this->idiomas = array(
		0 => "esp",
		1 => "ing"
		);
		$this->activo = $this->idiomas[$nro];		
		$this->cantIdiomas = count ($this->idiomas);
		
	}	
	//CAMBIAR IDIOMA	
	/**
		Esta función indica el valor del idioma activo
		De no recibir parametro asumira que este es el idioma 0 (Español)
	**/
	function setActivo($nro = 0){	
		$this->nroActivo = $nro;
		$this->activo = $this->idiomas[$nro];		
	}	
	function getActivo(){
		return $this->nroActivo;
	}	
	//GENERAR DIVS
	/**
		Esta función genera los divs de los idiomas
		Recibira el prefijo de los id con los que serán generado y generará tantos como idiomas haya habilitados
		En caso alternativo de divs generara etiquetas span
	**/	
	function divIdiomas($nameDiv, $nro ,$arrTxt){		
		for ($i=0; $i< $this->cantIdiomas; $i++){
			if ($i == $this->nroActivo) {
				echo "<span id='".$nameDiv.$this->idiomas[$i].$nro."'>".$arrTxt[$nro][$i]."</span>";
			} else {
				echo "<span id='".$nameDiv.$this->idiomas[$i].$nro."' style='display:none;'>".$arrTxt[$nro][$i]."</span>";
			}
		}
    }	
	//GENERAR JAVASCRIPT
	/**
		Esta funcion genera los bucles javascript que habilitan/deshabilitan los divs en cada idioma		
	**/
	function generarJavascript($nameDiv, $num, $arrTxt){
		echo "for (k=0; k<".count($arrTxt)."; k++){";
		for ($i=0; $i< $this->cantIdiomas; $i++){
			if ($i == $num) {
				echo 'document.getElementById("'.$nameDiv.$this->idiomas[$i].'"+k).style.display = "block";';
			} else {
				echo 'document.getElementById("'.$nameDiv.$this->idiomas[$i].'"+k).style.display = "none";';
			}	
		}	
		echo "}";
	}
}	
?>