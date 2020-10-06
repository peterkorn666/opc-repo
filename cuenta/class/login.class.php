<?php
/**
 * User: Cristian
 * Date: 08/8/2016
 * Time: 20:43
 */
class Login
{
    private $_bd, $_render;
    public function __construct()
    {
        $this->_bd = \DB::getInstance();
    }

    public static function isLogged(){
        if(!isset($_SESSION['cliente']['id_cliente']))
            return false;
        else
            return true;
    }

    public function validate($id)
    {
        if($id=='' || !$_SESSION["admin"])
            $sql = $this->_bd->query('SELECT * FROM cuentas WHERE email=? AND clave=?', [$_POST['email'], $_POST['clave']]);
        else
            $sql = $this->_bd->get('cuentas', ['id','=',$id]);
        if($sql->count()>0)
        {
            $results = $sql->first();
			if(!$_SESSION["admin"]){
				$this->_bd->insert('cuentas_visitas', ["id_cuenta"=>$results['id']]);
				$this->_bd->update('cuentas', "id=".$results['id'], ["ultimo_acceso"=>date("Y-m-d H:i:s")]);
			}
            $_SESSION['cliente']['id_cliente'] = $results['id'];
            $_SESSION['cliente']['nombre'] = $results['nombre'];
			$_SESSION['cliente']['apellido'] = $results['apellido'];
			$_SESSION['cliente']['email'] = $results['email'];
			$_SESSION['cliente']['ultimo_acceso'] = $results['ultimo_acceso'];
            \Redirect::to('../cuenta.php');
            return false;
        }else {
			\Redirect::to('../login.php?error=1');
            return false;
        }
    }

    public function getLogout(){
        session_destroy();
        \Redirect::to('/login/');
    }
	
	private function validarCuenta(){
		return $this->_bd->get("cuentas",["email","=",$_POST["email"]])->count();
	}
	
	public function crearCuenta(){
		if($this->validarCuenta()>0){
			\Redirect::to('../login.php?crear=3');
            return false;
		}
		$sql = $this->_bd->insert('cuentas', ["nombre"=>$_POST['nombre'],"apellido"=>$_POST['apellido'],"email"=>$_POST['email'],"clave"=>$_POST['clave1'],"fecha"=>date("d-m-Y")]);
        if($sql)
        {
            return $this->_bd->lastID();
        }else {

            return false;
        }
	}
	
	public function guardarContacto(){
		return $this->_bd->insert("contacto", ["nombre"=>$_POST['nombre'],"apellido"=>$_POST['apellido'],"email"=>$_POST['email'],"asunto"=>$_POST['asunto'],"mensaje"=>$_POST["mensaje"],"imagen"=>$_FILES['archivo']['name'],"fecha"=>date("Y-m-d H:i:s")]);
	}
}