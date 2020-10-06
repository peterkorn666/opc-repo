<?PHP
class Seccion {
	var $id;
	var $labelTemplate;
	var $div;
	var $habilitada;
	var $visible;
	var $repite;
	var $valor;

	function Seccion($labelTemplate=null,$div=null,$habilitada=true,$visible=true,$repite=false,$valor=null) {
		$this->id=$labelTemplate;
		$this->labelTemplate=$labelTemplate;
		if ($div==null) {
			$this->div=$labelTemplate;
		} else {
			$this->div=$div;
		}
		$this->habilitada=$habilitada;
		$this->visible=$visible;
		$this->repite=$repite;
		$this->valor=$valor;
	}

}
?>