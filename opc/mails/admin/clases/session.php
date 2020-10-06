<?PHP
class session
{

	function session() {

	}
	
	function darValor($id) {
		if (isset($_SESSION[$id])) {
			return $_SESSION[$id];
		} else {
			return null;
		}
	}

	function asignarValor($id,$valor) {
		$_SESSION[$id]=$valor;
		return false;
	}
	
	function eliminarValor($id) {
		unset($_SESSION[$id]);
	}

	function eliminarValores() {
		$_SESSION = array();
	}
	
	function asignarValoresVariables($variables,$prefijo="") {
		foreach($variables as $v) {
			session::asignarValor($prefijo . $v->id,$v->valor);
		}
	}
	
	function cargarValoresVariables(&$variables,$prefijo="") {
		foreach($variables as $v) {
			if (isset($_SESSION[$prefijo . $v->id])) {
				$v->valor=$_SESSION[$prefijo . $v->id];
			} else {
				$v->valor=$v->valorPorDefecto;
			}
		}
	}
	
	function eliminarValoresVariables($variables,$prefijo="") {
		foreach($variables as $v) {
			session::eliminarValor($prefijo . $v->id);
		}
	}
}

?>