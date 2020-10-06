<?php
/**
 * User: Cristian
 * Date: 08/8/2016
 * Time: 20:43
 */
class Inscripcion extends Language
{
    private $_bd, $_render, $_vista;
    public function __construct($vista="")
    {
		self::isLogged();
        $this->_bd = \DB::getInstance();
		$this->_vista = $vista;
		parent::__construct("es");
    }

    public static function isLogged(){
		/*if($_SESSION['inscripcion']['admin'] || $_SESSION['inscripcion']['pago'])
			$_SESSION['cliente']['id_cliente'] = $_SESSION["inscripcion"]["id_cuenta"];
        if(!isset($_SESSION['cliente']['id_cliente']))
		{
			\Redirect::to('../cuenta/cuenta.php');
            return false;
		}else*/
        	return true;
    }

    public function getLogout(){
        session_destroy();
        \Redirect::to('/login/');
    }
	
	public function renderInput($name,$type="text", $options=array()){
		if($this->_vista=="previa"){
			switch($type){
				case "text":
					return "<br><b>".$_SESSION["inscripcion"][$name]."</b>";
				break;
				case "date":
					return "<br><b>".$_SESSION["inscripcion"]["day"].' / '.$_SESSION["inscripcion"]["month"].' / '.$_SESSION["inscripcion"]["year"]."</b>";
				case "select":
					if($name=="pais"){
						return "<br><b>".$this->getPaisesID($_SESSION["inscripcion"][$name])["Pais"]."</b>";
					}else
						return "<br><b>".$this->set[strtoupper($name)]["array"][$_SESSION["inscripcion"][$name]]."</b>";
				break;
				case "radio":
					$valor = $_SESSION["inscripcion"][$name];
					if(substr($name,0,6)=="costos")
						//return "<b>".$this->getValue($this->set[strtoupper($name)]["array"][$_SESSION["inscripcion"][$name]]).' U$S '.$this->getValue($this->set[strtoupper($name)]["array"][$_SESSION["inscripcion"][$name]],1)."</b>";
						return "<b>".$this->getValue($options[$valor]).' U$S '.$this->getValue($options[$valor],1)."</b>";
						//return $options;
					else
						return "<b>".$this->getValue($options[$valor])."</b>";
				break;
			}
		}else{
			switch($type){
				case "text":
					if ($name != "solapero") {
						return "<input type='text' style='font-size:16px; ' name='$name' class='form-control input-sm' value='".$_SESSION["inscripcion"][$name]."'>";
					}
					else {
						return "<input type='text' style='font-size:16px; text-align:center;' name='$name' class='form-control input-sm' value='".$_SESSION["inscripcion"][$name]."'>";
					}
				break;
				case "date":
					return '<div class="datefield">
								<input name="day" type="tel" maxlength="2" placeholder="DD" value="'.$_SESSION["inscripcion"]["day"].'"/> /              
								<input name="month" type="tel" maxlength="2" placeholder="MM" value="'.$_SESSION["inscripcion"]["month"].'"/>/
								<input name="year" type="tel" maxlength="4" placeholder="YYYY" value="'.$_SESSION["inscripcion"]["year"].'"/>
							</div>';
				break;
				case "select":
					$html = "<select name='$name' class='form-control input-sm'>";
						$html .= "<option value=''></option>";
						foreach($options as $key => $value)
						{
							if($_SESSION["inscripcion"][$name]==$key)
								$chk = "selected";
							$html .= "<option $chk value='$key'>$value</option>";
							$chk = "";
						}
					$html .= "</select>";
					return $html;
				break;
				case "radio":
					foreach($options as $key => $value)
					{
						$habilitado = $this->getValue($value,2);
						$values = $this->getValue($value);
						if($_SESSION["inscripcion"][$name]==$key)
							$chk = "checked";
						if($habilitado=="habilitado" || $_SESSION["admin"]){
							if(substr($name,0,6)=="costos")
								$html .= "<input type='radio' name='$name' $chk value='$key'> $values U\$S ".$this->getValue($value,1)."<br>";
							else
								$html .= "<input type='radio' name='$name' $chk value='$key'> $values<br>";
						}
						$chk = "";
					}
					return $html;
				break;
			}
		}
	}
	
	public function getPaises(){
		$paises = $this->_bd->query("SELECT * FROM paises ORDER BY Pais")->results();
		$render = array();
		foreach($paises as $pais)
			$render[$pais["ID_Paises"]] = $pais["Pais"];
		return $render;				
	}
	
	public function getPaisesID($id){
		$pais = $this->_bd->get("paises",["ID_Paises","=",$id])->first();
		return $pais;
	}	
	
	public function getInstitucionID($id){
		if(empty($id))
			return array("Institucion"=>"");
		$result = $this->_bd->get("instituciones",["ID_Instituciones","=",$id])->first();
		return $result;
	}
	
	public function getPresentadorInfo(){
		$trabajo = $this->_bd->get("trabajos_libres", ["id_cliente", "=", $_SESSION["cliente"]["id_cliente"]])->first();
		if(!is_array($trabajo))
			return "";
		$presentador = $this->_bd->query("SELECT * FROM trabajos_libres_participantes WHERE lee=1 AND ID_trabajos_libres=?", [$trabajo["id_trabajo"]])->first();
		if(!is_array($presentador))
			return "";
		$autor = $this->_bd->get("personas_trabajos_libres", ["ID_Personas", "=", $presentador["ID_participante"]])->first();
		return $autor;
	}
	
	public function finish(){
		$sql = $this->_bd->insert('cuentas', ["nombre"=>$_POST['nombre'],"apellido"=>$_POST['apellido'],"email"=>$_POST['email'],"clave"=>$_POST['clave1'],"fecha"=>date("d-m-Y")]);
        if($sql)
        {
            \Redirect::to('../login.php?success=1');
            return false;
        }else {
			\Redirect::to('../login.php?error=1');
            return false;
        }
	}
	
	public function existeInscripcion(){
		$sql = $this->_bd->query("SELECT COUNT(id) as count_inscripciones FROM inscriptos WHERE numero_pasaporte=?", [$_SESSION["inscripcion"]["numero_pasaporte"]])->first();
		if($sql["count_inscripciones"]>=1)
		{
			unset($_SESSION["inscripcion"]["numero_pasaporte"]);
			//unset($_SESSION["inscripcion"]["tipo_inscripcion"]);
			//\Redirect::to('check.php?ae=1');
            return true;
		}else{
			return false;
		}
	}
	
	public function getInscriptos(){
		$result = $this->_bd->query("SELECT * FROM inscriptos")->results();
		return $result;
	}
	
	public function getInscripto($id_inscripto) {
		$result = $this->_bd->get("inscriptos",["id","=",$id_inscripto])->first();
		return $result;
	}
	
	public function getTrabajos($id_cliente){
		$result = $this->_bd->query("SELECT id_trabajo, numero_tl, titulo_tl FROM trabajos_libres WHERE id_cliente=?", [$id_cliente])->results();
		return $result;
	}
	
	public function getTrabajosByPasaporte(){
		$autores = $this->_bd->query("SELECT ID_Personas FROM personas_trabajos_libres WHERE pasaporte=?", [$_SESSION["inscripcion"]["numero_pasaporte"]])->results();
		
		foreach($autores as $autor){
			$ids_tls = $this->_bd->query("SELECT ID_trabajos_libres FROM trabajos_libres_participantes WHERE ID_Participante=?", [$autor])->results();
			foreach($ids_tls as $id_tl){
				$result[$id_tl] = $this->_bd->query("SELECT id_trabajo, numero_tl, titulo_tl FROM trabajos_libres WHERE id_trabajo=?", [$id_tl])->results();
			}
		}
		/*foreach($tlps as $tlp){
			$result[] = $this->_bd->query("SELECT id_trabajo, numero_tl, titulo_tl FROM trabajos_libres WHERE numero_pasaporte=?", [$pasaporte])->results();
		}*/
		return $result;
	}
	
	public function getTLID($id_inscripto) {
		$rel_autor = $this->_bd->query("SELECT id_autor, id_inscripto, ID_trabajos_libres FROM cuenta_autores ca JOIN trabajos_libres_participantes tlp ON ca.id_autor = tlp.ID_participante WHERE id_inscripto = ?", [$id_inscripto])->first();
		$result = $this->_bd->query("SELECT id_trabajo FROM trabajos_libres WHERE id_trabajo = ?", [$rel_autor["ID_trabajos_libres"]])->first();
		return $result;
	}
	
	public function getTrabajosByPassaport($documento){
		$listado_trabajos = "";
		$trabajos_inscripto = $this->_bd->query("SELECT ID_Personas, pasaporte FROM personas_trabajos_libres WHERE pasaporte = ?", [$documento])->results();
		if(count($trabajos_inscripto) > 0){
			//$trabajos_inscripto = $trabajos_inscripto[0];
			foreach($trabajos_inscripto as $ti){
				$trabajos = $this->_bd->query("SELECT t.id_trabajo, t.numero_tl FROM trabajos_libres t JOIN trabajos_libres_participantes tp ON t.id_trabajo=tp.ID_trabajos_libres WHERE tp.ID_participante = ?", [$ti["ID_Personas"]])->results();
				if(count($trabajos) > 0){
					foreach($trabajos as $t){
						$listado_trabajos .= $t["numero_tl"].", ";
					}
				}
			}
			$listado_trabajos = substr($listado_trabajos, 0, -2);
		}
		return $listado_trabajos;
	}
	
	public function getInscriptosByIDS($ids_inscriptos = array()){
		if(count($ids_inscriptos) > 0){
			$txt_ids = "";
			foreach($ids_inscriptos as $id_inscripto){
				$txt_ids .= $id_inscripto.", ";
			}
			$txt_ids = substr($txt_ids, 0, -2);
			return $this->_bd->query("SELECT * FROM inscriptos WHERE id IN (".$txt_ids.")")->results();
		}
	}

	//Inscripción general
	public function getPrecios() {
		return $this->_bd->query("SELECT * FROM inscripcion_costos")->results();
	}
	
	public function getPreciosHabilitados() {
		return $this->_bd->query("SELECT * FROM inscripcion_costos WHERE habilitado=1")->results();
	}
	
	public function getOpcionPrecioByID($id_precio) {
		return $this->_bd->get("inscripcion_costos", ["id", "=", $id_precio])->first();
	}
	
	//Formas de pago
	public function getFormasPago() {
		return $this->_bd->query("SELECT * FROM inscripcion_formas_pago")->results();
	}
	
	public function getFormasPagoHabilitadas() {
		return $this->_bd->query("SELECT * FROM inscripcion_formas_pago WHERE habilitado=1")->results();
	}
	
	public function getOpcionFormaPagoByID($id_forma_pago) {
		return $this->_bd->get("inscripcion_formas_pago", ["id", "=", $id_forma_pago])->first();
	}
	
	public function esBeca($id_costo) {
		$es_beca = false;
		$result = $this->_bd->query("SELECT id, nombre FROM inscripcion_costos WHERE id=?", [$id_costo])->first();
		if(count($result) > 0){
			if($result["nombre"] === 'Beca'){
				$es_beca = true;
			}
		}
		return $es_beca;
	}
	
	public function esFormaPagoConComprobante($id_forma_pago) {
		$tiene_comprobante = false;
		$result = $this->_bd->query("SELECT id, lleva_comprobante FROM inscripcion_formas_pago WHERE id=?", [$id_forma_pago])->first();
		if(count($result) > 0) {
			if($result["lleva_comprobante"] == 1){
				$tiene_comprobante = true;
			}
		}
		return $tiene_comprobante;
	}
	
	public function calcularPrecio($id_inscripto) {
		
		$precio_costo_congreso = 0;
		$inscripto = $this->getInscripto($id_inscripto);
		if(count($inscripto) > 0){
			if($inscripto["costos_inscripcion"] != NULL){
				$rowCostoInscripcion = $this->getOpcionPrecioByID($inscripto["costos_inscripcion"]);
				$precio_costo_congreso = (int)$rowCostoInscripcion["precio"];
			}
		}
		return $precio_costo_congreso;
	}
	
}