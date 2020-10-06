<?PHP
require_once('../clases/grilla.php');
require_once('../clases/template.php');
require_once('../clases/seccion.php');

class presentacion {
	var $plantilla;
	var $bloquePrincipal;
	var $secciones;
	var $funcion_previa_mostrar;

	function presentacion($plantilla=null,$bloquePrincipal=null) {
		$this->plantilla=$plantilla;
		$this->bloquePrincipal=$bloquePrincipal;
		$this->secciones=array();		
	}
	
	function abrir($archivo,$directorio,$bloquePrincipal="") {
		if (file_exists($directorio . $archivo)) {
			// abrir plantilla
			$this->plantilla = new Template($directorio);
			$this->plantilla->load_file($archivo, "main");
			$this->bloquePrincipal=$bloquePrincipal;
			return true;
		} else {
			$this->plantilla = null;
			$this->$bloquePrincipal=null;

			echo "no se encontró la plantilla";
			exit();

			return false;
		}
	}

	function agregarSeccion($seccion,$idSeccion="") {
		if ($idSeccion!="") {
			$seccion->id=$idSeccion;
			$this->secciones[$idSeccion]=$seccion;
		} else {
			if ($seccion->labelTemplate!="") {
				$seccion->id=$seccion->labelTemplate;
				$this->secciones[$seccion->labelTemplate]=$seccion;
			}
		}
	}

	function quitarSeccion($idSeccion) {
		unset($this->secciones[$idSeccion]);
	}

	function darSecciones() {
		return $this->secciones;
	}

	function darSeccion($idSeccion) {
		$sec=&$this->secciones[$idSeccion];
		if ($sec) {
			return $sec;
		} else {
			return null;
		}
	}

	function asignarPropiedadSeccion($idSeccion,$propiedad,$valor) {
		$sec=&$this->secciones[$idSeccion];
		if ($sec) {
			$sec->$propiedad=$valor;
		} else {
			return null;
		}
	}

	function darValorSeccion($idSeccion) {
		if (array_key_exists ($idSeccion, $this->secciones)) {
			return $this->secciones[$idSeccion]->valor;
		} else {
			return null;
		}
	}

	function asignarValorSeccion($idSeccion,$valor) {
		if (array_key_exists ($idSeccion, $this->secciones)) {
			$this->secciones[$idSeccion]->valor=$valor;
			return true;
		} else {
			return false;
		}
	}

	function definirSecciones() {
		foreach ( $this->darSecciones() as $id => $sec ){
			if ($sec->habilitada) {
				$this->parse($sec->labelTemplate,$sec->repite);
			} else {
				$this->asignarValor($sec->labelTemplate,"");
			}
        }
	}
	
	function asignarValor($label,$valor) {
		$this->plantilla->set_var($label,$valor);
	}
	
	function asignarLang($label,$valor) {
		$this->plantilla->set_lang($label,$valor);
	}

	function mostrar(){
		ejecutar($this->funcion_previa_mostrar,$this);
		$this->plantilla->pparse($this->bloquePrincipal, false);
	}

	function rparse($bloque,$repite){
		return $this->plantilla->rparse($bloque,$repite);
	}

	function parse($bloque,$repite){
		$this->plantilla->parse($bloque,$repite);
	}

	function pparse($bloque,$repite){
		$this->plantilla->pparse($bloque,$repite);
	}
}
?>