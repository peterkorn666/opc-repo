<?php
class login{
	public function __construct(){
		$this->db = \DB::getInstance();
	}
	
	public function validar($numero_tl,$clave){
		return $this->db->query("SELECT * FROM trabajos_libres WHERE numero_tl=? AND clave=?", [$numero_tl, $clave])->first();
	}

    private function getClientIDfromTL($id_tl){
        $tl = $this->db->get("trabajos_libres",["id_trabajo","=",$id_tl])->first();
        if(count($tl)==0){
            \Redirect::to('/cuenta');
            die();
        }
        return $this->db->get("cuentas", ["id","=",$tl['id_cliente']])->first();
    }
	
	public function validarID($id){
        if($_SESSION["admin"]) {
            unset($_SESSION['cliente']);
            /*$cliente = $this->getClientIDfromTL(base64_decode($id));
            if (count($cliente) == 0) {
                \Redirect::to('/cuenta');
                die();
            }
            $_SESSION['cliente']['id_cliente'] = $cliente['id'];
            $_SESSION['cliente']['nombre'] = $cliente['nombre'];
            $_SESSION['cliente']['apellido'] = $cliente['apellido'];*/
        }
		return $this->db->get("trabajos_libres", ["id_trabajo","=",base64_decode($id)])->first();
	}
}
?>