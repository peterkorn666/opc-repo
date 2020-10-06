<?php
/**
 * User: Cristian
 * Date: 08/8/2016
 * Time: 20:43
 */
class Cuenta
{
    private $_bd, $_render, $_id_cliente;
    public function __construct($reset_password = false)
    {
		if(!$reset_password){
			if(empty($_SESSION['cliente']['id_cliente'])){
				\Redirect::to("login.php");
				die();
			}
		}
        $this->_bd = \DB::getInstance();
		$this->_id_cliente = $_SESSION['cliente']['id_cliente'];
		
		
    }
	
	public function getCuentaByEmail($email){
		return $this->_bd->query("SELECT * FROM cuentas WHERE email=?", [$email])->first();
	}
	
	public function getCuenta(){
		return $this->_bd->query("SELECT * FROM cuentas WHERE id=?", [$_SESSION['cliente']['id_cliente']])->first();
	}

    public static function isLogged(){
        if(!isset($_SESSION['cliente']['id_cliente']))
            return false;
        else
            return true;
    }

    public function getLogout(){
        session_destroy();
        \Redirect::to('/login/');
    }
	
	public function getConfig(){
		return $this->_bd->query("SELECT * FROM config")->first();
	}
	
	public function getTrabajosByType($type="1"){
		return $this->_bd->query("SELECT * FROM trabajos_libres WHERE id_cliente=? AND tipo_tl=? AND estado<>3", [$this->_id_cliente, $type])->results();
	}
	
	public function getTrabajosByCuenta($id_cuenta){
		return $this->_bd->query("SELECT * FROM trabajos_libres WHERE id_cliente=? AND estado<>3", [$id_cuenta])->results();
	}
	
	public function getTrabajoByID($id){
		if(empty($id))
			return false;
		return $this->_bd->get("trabajos_libres",["id_trabajo","=",$id])->first();
	}
	
	public function getTituloPanelista($data){
		return $this->_bd->query("SELECT * FROM trabajos_libres_panel_titulos WHERE id_trabajo=? AND id_coordinador=? AND id_panelista=?",[$data["id_trabajo"], $data["id_coordinador"], $this->_id_cliente])->first();
	}
	
	public function setAutorTitulo(){
		$getTitulo = $this->_bd->query("SELECT * FROM trabajos_libres_panel_titulos WHERE id_trabajo=? AND id_coordinador=? AND id_panelista=?",[$_POST["id_trabajo"], $_POST["id_coordinador"], $this->_id_cliente])->first();
		$data = array(
			"id_trabajo" => $_POST["id_trabajo"],
			"id_coordinador" => $_POST["id_coordinador"],
			"id_panelista" => $this->_id_cliente,
			"titulo" => $_POST["author_title"]
		);
		if(count($getTitulo)==0){
			$data["fecha"] = date("Y-m-d H:i:s");
			return $this->_bd->insert("trabajos_libres_panel_titulos", $data);
		}else{
			$data["fecha_modificacion"] = date("Y-m-d H:i:s");
			return $this->_bd->update("trabajos_libres_panel_titulos", "id=".$getTitulo["id"], $data);
		}
	}
	
	public function generarString($cantidad){
		$pattern = "123456789123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $pass = '';
		for($i=0;$i<$cantidad;$i++){
			$pass .= $pattern{rand(0,35)};
		}
		return $pass;
	}
	
	public function resetPassword(){
		$cuenta = $this->getCuentaByEmail(trim($_POST["pswd-email"]));
		if(count($cuenta)==0){
			header("Location: ../login.php?psw=2");
			die();
		}
		$clave = $this->generarString(8);
		return array($clave, $cuenta, $this->_bd->update("cuentas","id=".$cuenta["id"], array("clave"=>$clave)));
	}
	
	public function getTrabajoInteresa($id_cuenta)
	{
		return $this->_bd->query("SELECT * FROM cuentas_trabajos as ct JOIN trabajos_libres as t USING(id_trabajo) JOIN cronograma as c USING(id_crono) WHERE ct.id_cuenta=? AND t.estado<>3", [$id_cuenta])->results();	
	}
	
	public function getTrabajoCrono($id_crono){
		return $this->_bd->query("SELECT * FROM cronograma WHERE id_crono=?", [$id_crono])->first();
	}
	
	public function getEdificioID($id_edificio){
		return $this->_bd->query("SELECT * FROM edificios WHERE id=?", [$id_edificio])->first();
	}
	
	public function getSalaID($id_sala){
		return $this->_bd->query("SELECT * FROM salas WHERE salaid=?", [$id_sala])->first();
	}
	
	public function getInscripto(){
		return $this->_bd->get("inscriptos",["id_cuenta","=",$this->_id_cliente])->first();
	}
	
	public function getTrabajosInscripto($id_inscripto){
		$ids_autores = $this->_bd->get("cuenta_autores", ["id_inscripto", "=", $id_inscripto])->results();
		/*$numeros_trabajos = "";*/
		$cant = 0;
		$trabajos = array();
		if ($ids_autores) {
			foreach($ids_autores as $id_autor) {
				$id_trabajo = $this->_bd->get("trabajos_libres_participantes", ["ID_participante", "=", $id_autor["id_autor"]])->first();
				$trabajo = $this->_bd->get("trabajos_libres", ["id_trabajo", "=", $id_trabajo["ID_trabajos_libres"]])->first();
				/*$numeros_trabajos .= $trabajo["numero_tl"] . ", ";*/
				$cant = $cant + 1;
				$trabajos[] = $trabajo;
			}
			/*$numeros_trabajos = substr($numeros_trabajos,0,-2);*/
		}
		/*return array("numeros_trabajos" => $numeros_trabajos, "cant" => $cant);*/
		return array("trabajos" => $trabajos, "cant" => $cant);
	}
	
	public function getVisitas(){
		return $this->_bd->get("cuentas_visitas")->count();
	}
	
	public function getInstitution($id)
	{
		return $this->_bd->get("instituciones", ["ID_Instituciones","=", $id])->first();
	}
	
	public function setComprobante($numero, $nombre){
		$inscripto = $this->getInscripto();
		if($inscripto["grupo_check_comprobante"]){
			$cuenta_pago = $this->getCuentaByComprobante($numero);
			return $this->_bd->update("inscriptos", "id"."=".$inscripto["id"], ['grupo_numero_comprobante'=>$numero,'comprobante_archivo'=>$nombre, "key_cuenta" => $cuenta_pago["id"]]);
		}else
			return $this->_bd->update("cuentas", "id"."=".$_SESSION['cliente']['id_cliente'], ['numero_comprobante'=>$numero,'comprobante'=>$nombre]);
	}
	
	public function validarComprobanteInsPersona($numero){
		return $this->_bd->get("cuentas", ["numero_comprobante", "=", $numero])->first();
	}
	
	public function templateAutoresTL($data, $presentador=false, $ins=true)
	{
		$sql = $this->_bd->query("SELECT * FROM trabajos_libres_participantes as tp JOIN personas_trabajos_libres as p ON tp.ID_participante=p.ID_Personas WHERE tp.ID_trabajos_libres=? ORDER BY tp.ID ASC", [$data["id_trabajo"]])->results();
		
		$arrayPersonas = array();
		$arrayInstituciones = array();
		$gestionAutores = "";
		$helper = 1;
		foreach($sql as $key => $row){	
			$nombre[$key] = $row["Nombre"];
			$apellido[$key] = $row["Apellidos"];
			$apellido2[$key] = $row["Apellidos2"];
			$institucion[$key] = $row["Institucion"];
			$email[$key] = $row["Mail"];
			$pais[$key] = $row["Pais"];
			$lee[$key] = $row["lee"];
			$inscripto[$key] = $row["inscripto"];
			$id[$key] = $row["ID_Personas"];
			array_push($arrayPersonas, array($institucion[$key], $apellido[$key], $nombre[$key], $lee[$key], $inscripto[$key], $apellido2[$key], $pais[$key], $id[$key]));
			array_push($arrayInstituciones , $institucion[$key]);
		}
		
		//Unifcacion Instituciones
		$arrayInstitucionesUnicas =  array_values(array_unique($arrayInstituciones));
	
		$arrayInstitucionesUnicasNuevaClave = array();
		if(count($arrayInstitucionesUnicas)>0){
			foreach ($arrayInstitucionesUnicas as $u){
				if($u!=""){
					array_push($arrayInstitucionesUnicasNuevaClave, $u);
				}
			}
		}
		
		$autoreInscriptos = "";
		$gestionAutores = "";
		//var_dump($arrayPersonas);
		for ($i=0; $i < count($arrayPersonas); $i++){
			if($i>0){
				if(!$presentador){
					$gestionAutores .= "; ";
					$gestionAutores .= '<br>';
				}
			}else{
				$primerAutor .= $arrayPersonas[$i][2]. " <b>".$arrayPersonas[$i][1]. " ".$arrayPersonas[$i][5] . "</b> ";
				
			}
			if($arrayPersonas[$i][0]!=""){
				$claveIns = (array_search($arrayPersonas[$i][0] ,$arrayInstitucionesUnicas))+1;
			}else{
				$claveIns = "";
			}

			if($arrayPersonas[$i][4])
					$gestionAutores .= '<div class="no-hover circle-green" style="display:inline-block"></div> ';
			
			if($arrayPersonas[$i][3]==1 && $crono!="nolee"){
				//$gestionAutores .= "<u>";
			}
			if(!$presentador){
				if($data["tipo_tl"]=="1")
					$gestionAutores .=  "<a href='acp/descargar.php?t=".base64_encode($data["id_trabajo"])."&k=".base64_encode($arrayPersonas[$i][7])."' target='_blank'>";
				else
					$gestionAutores .=  "<a href='acp/panel.php?t=".base64_encode($data["id_trabajo"])."&k=".base64_encode($arrayPersonas[$i][7])."' target='_blank'>";
				$gestionAutores .= $arrayPersonas[$i][2] . " " . $arrayPersonas[$i][1]. " ".$arrayPersonas[$i][5]."</a>";
			}
			if($arrayPersonas[$i][3]==1 && $crono!="nolee"){
				//$gestionAutores .= "</u>";
			}
			if($arrayPersonas[$i][3]==1){
				if($presentador)
					$gestionAutores .= "<a href='#'>".trim($arrayPersonas[$i][2]). " <b>".trim($arrayPersonas[$i][1]). " ".trim($arrayPersonas[$i][5]) . "</b></a>;";
				$helper++;
				//$gestionAutores .= $primerAutor;
			}
			
			if($helper==1 && $i==(count($sql)-1) && $presentador)
				$gestionAutores .= $primerAutor;
			if(!$presentador && $ins)
				$gestionAutores .= "<sup>" . $claveIns . "</sup>";
			if($data["asistencia"] && $arrayPersonas[$i][4]){
				if($data["tipo_tl"] == 1){
					$gestionAutores .= ' <a href="acp/certificado_autor.php?t='.base64_encode($data["id_trabajo"]).'&k='.base64_encode($arrayPersonas[$i][7]).'" target="_blank" style="color:red">constancia de ponencia</a>';
				}else{
					$gestionAutores .= ' <a href="acp/certificado_autor.php?t='.base64_encode($data["id_trabajo"]).'&k='.base64_encode($arrayPersonas[$i][7]).'" target="_blank" style="color:red">constancia de panel</a>';
				}
			}
				
		}
		$gestionAutores = trim($gestionAutores,"; ");
		if(!$presentador && $ins){
			
			$gestionAutores .="<div class='autor_institucion'>";
			for ($i=0; $i < count($arrayInstitucionesUnicasNuevaClave); $i++){
				$gestionAutores .= "<i>";
				$gestionAutores .=  ($i+1) . " - " . $this->getInstitution($arrayInstitucionesUnicas[$i])["Institucion"] . ". ";
				$gestionAutores .= "</i>";
			}
			$gestionAutores .="</div>";
		}
			
		
		return $gestionAutores;
		
	}
	
	private function limpiar($String){
		$String = utf8_encode($String);
		$String = str_replace(array('á','à','â','ã','ª','ä'),"a",$String);
		$String = str_replace(array('Á','À','Â','Ã','Ä'),"A",$String);
		$String = str_replace(array('Í','Ì','Î','Ï'),"I",$String);
		$String = str_replace(array('í','ì','î','ï'),"i",$String);
		$String = str_replace(array('é','è','ê','ë'),"e",$String);
		$String = str_replace(array('É','È','Ê','Ë'),"E",$String);
		$String = str_replace(array('ó','ò','ô','õ','ö','º'),"o",$String);
		$String = str_replace(array('Ó','Ò','Ô','Õ','Ö'),"O",$String);
		$String = str_replace(array('ú','ù','û','ü'),"u",$String);
		$String = str_replace(array('Ú','Ù','Û','Ü'),"U",$String);
		$String = str_replace(array('[','^','´','`','¨','~',']'),"",$String);
		$String = str_replace("ç","c",$String);
		$String = str_replace(" ","_",$String);
		$String = str_replace("Ç","C",$String);
		$String = str_replace("ñ","n",$String);
		$String = str_replace("Ñ","N",$String);
		$String = str_replace("Ý","Y",$String);
		$String = str_replace("ý","y",$String);

		$String = str_replace("&aacute;","a",$String);
		$String = str_replace("&Aacute;","A",$String);
		$String = str_replace("&eacute;","e",$String);
		$String = str_replace("&Eacute;","E",$String);
		$String = str_replace("&iacute;","i",$String);
		$String = str_replace("&Iacute;","I",$String);
		$String = str_replace("&oacute;","o",$String);
		$String = str_replace("&Oacute;","O",$String);
		$String = str_replace("&uacute;","u",$String);
		$String = str_replace("&Uacute;","U",$String);
		return $String;
	}
	
	private function reemplazarNombreArchivo($str, $replace=array(), $delimiter='_') {
		setlocale(LC_ALL, 'en_US.UTF8');
		if( !empty($replace) ) {
			$str = str_replace((array)$replace, ' ', $str);
		}

		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\.\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

		return $this->limpiar($clean);
	}

	function guardarArchivo($file,$ruta,$nombre=""){
		$archivo = $file["name"];
		if($file["tmp_name"]!=""){
			$extension = explode(".",$archivo);
			$extension = end($extension);

			if(strtolower($extension)!="pdf" && strtolower($extension)!="png" && strtolower($extension)!="jpg" && strtolower($extension)!="jpeg" && strtolower($extension)!="bmp" && strtolower($extension)!="gif"){
				/*if(
                    strtolower($extension)=="bat" ||
                    strtolower($extension)=="exe" ||
                    strtolower($extension)=="cmd" ||
                    strtolower($extension)=="sh" ||
                    strtolower($extension)=="php" ||
                    strtolower($extension)=="pl" ||
                    strtolower($extension)=="cgi" ||
                    strtolower($extension)=="386" ||
                    strtolower($extension)=="dll" ||
                    strtolower($extension)=="com" ||
                    strtolower($extension)=="torrent" ||
                    strtolower($extension)=="js" ||
                    strtolower($extension)=="app" ||
                    strtolower($extension)=="jar" ||
                    strtolower($extension)=="pif" ||
                    strtolower($extension)=="vb" ||
                    strtolower($extension)=="vbscript" ||
                    strtolower($extension)=="wsf" ||
                    strtolower($extension)=="asp" ||
                    strtolower($extension)=="cer" ||
                    strtolower($extension)=="csr" ||
                    strtolower($extension)=="jsp" ||
                    strtolower($extension)=="drv" ||
                    strtolower($extension)=="sys" ||
                    strtolower($extension)=="ade" ||
                    strtolower($extension)=="adp" ||
                    strtolower($extension)=="bas" ||
                    strtolower($extension)=="chm" ||
                    strtolower($extension)=="cpl" ||
                    strtolower($extension)=="crt" ||
                    strtolower($extension)=="csh" ||
                    strtolower($extension)=="fxp" ||
                    strtolower($extension)=="hlp" ||
                    strtolower($extension)=="hta" ||
                    strtolower($extension)=="inf" ||
                    strtolower($extension)=="ins" ||
                    strtolower($extension)=="isp" ||
                    strtolower($extension)=="jse" ||
                    strtolower($extension)=="htaccess" ||
                    strtolower($extension)=="htpasswd" ||
                    strtolower($extension)=="ksh" ||
                    strtolower($extension)=="lnk" ||
                    strtolower($extension)=="mdb" ||
                    strtolower($extension)=="mde" ||
                    strtolower($extension)=="mdt" ||
                    strtolower($extension)=="mdw" ||
                    strtolower($extension)=="msc" ||
                    strtolower($extension)=="msi" ||
                    strtolower($extension)=="msp" ||
                    strtolower($extension)=="mst" ||
                    strtolower($extension)=="ops" ||
                    strtolower($extension)=="pcd" ||
                    strtolower($extension)=="prg" ||
                    strtolower($extension)=="reg" ||
                    strtolower($extension)=="scr" ||
                    strtolower($extension)=="sct" ||
                    strtolower($extension)=="shb" ||
                    strtolower($extension)=="shs" ||
                    strtolower($extension)=="url" ||
                    strtolower($extension)=="vbe" ||
                    strtolower($extension)=="vbs" ||
                    strtolower($extension)=="wsc" ||
                    strtolower($extension)=="wsf" ||
                    strtolower($extension)=="wsh"

                ){*/
				header("Location: ../cuenta.php?ce=file_ext");
				die();
			}
			if(filesize($file["tmp_name"])>20971520)
			{
				header("Location: ../cuenta.php?ce=file_size");
				die();
			}
			if($nombre=="")
				$nombre = $archivo;
			else
				$nombre = $nombre.".".$extension;
			$archivo_name = $this->reemplazarNombreArchivo($nombre);
			$copy = copy($file["tmp_name"], $ruta.$archivo_name);
			if(!$copy)
			{
				header("Location: ../cuenta.php?ce=file");
				die();
			}
		
			return $archivo_name;
		}
	}
	
	public function getCuentaByComprobante($numero){
		return $this->_bd->get("cuentas", ["numero_comprobante", "=", $numero])->first();
	}

	public function getCuentaById($id){
		return $this->_bd->get("cuentas", ["id", "=", $id])->first();
	}

}