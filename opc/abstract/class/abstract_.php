<?php
class abstracts{
	public function __construct(){
		$this->db = \DB::getInstance();
	}

    public function getTitulosAcademicosHabilitados(){
        return $this->db->query("SELECT * FROM trabajos_libres_titulos_academicos WHERE enabled=1 ORDER BY orden_titulo_academico")->results();
    }
    public function getInstitucionesHabilitadas(){
        return $this->db->query("SELECT * FROM trabajos_libres_instituciones WHERE enabled=1 ORDER BY orden_institucion")->results();
    }
	
	public function getAreas(){
		return $this->db->query("SELECT * FROM areas_trabjos_libres ORDER BY Area")->results();
	}
	public function getAreaID($id){
		return $this->db->get("areas_trabjos_libres", ["id","=",$id])->first();
	}
	public function getIdiomas(){
		return $this->db->query("SELECT * FROM tl_idiomas ORDER BY idioma")->results();
	}
	
	public function getTrabajoID($id){
		return $this->db->get("trabajos_libres", ["id_trabajo","=",$id])->first();
	}
	
	public function generarClave($cantidad){
		$pattern = "123456789123456789abcdefghijklmnopqrstuvwxyz";
        $pass = '';
		for($i=0;$i<$cantidad;$i++){
			$pass .= $pattern{rand(0,35)};
		}
		return $pass;
	}
	
	public function getLastNumTL(){
		$sql = $this->db->query("SELECT id_trabajo, numero_tl FROM trabajos_libres ORDER BY numero_tl DESC LIMIT 0,1")->first();
		$return = ($sql["numero_tl"]==""?"1":intval($sql["numero_tl"])+1);
		$return = str_pad($return, 4, "0", STR_PAD_LEFT);
		return $return;
	}
	
	public function getAutoresIDtl($id){
		return $this->db->query("SELECT * FROM trabajos_libres_participantes as tp JOIN personas_trabajos_libres as pl ON tp.ID_participante=pl.ID_Personas WHERE tp.ID_trabajos_libres=? ORDER BY tp.ID ASC", [$id])->results();
	}
	
	public function getAutorIDcount($id_autor){
		return $this->db->get("trabajos_libres_participantes", ["ID_participante", "=", $id_autor])->count();
	}
	
	public function eliminarAutorDeltrabajoID($autores_nuevos, $id_participante){
		if(!in_array($id_participante, $autores_nuevos))
			return $this->db->query("DELETE FROM trabajos_libres_participantes WHERE ID_participante=?", [$id_participante]);
	}
	
	public function validarInstitucionAutores($institucion){
		$sql = $this->db->get("instituciones", ["institucion","=",$institucion])->first();		
		if(count($sql)==0){
			$sqlI = $this->db->insert("instituciones", ["institucion"=>trim($institucion)]);
			return $this->db->lastID();
		}
		return ($sql["ID_Instituciones"]==""?0:$sql["ID_Instituciones"]);
	}
	
	function getInstitucionID($id){
		$sql = $this->db->get("instituciones", ["ID_Instituciones","=",$id])->first();
		return $sql["Institucion"];
	}
	
	function getInstituciones($ins){
		$where = "";
		if($ins!=""){
			$where = "WHERE ID_Instituciones='$ins'";
		}
		return $this->db->query("SELECT * FROM instituciones $where ORDER BY Institucion")->results();
	}
	
	private function getLastID(){
		//return $this->db->lastInsertId();
		return $this->db->lastID();
	}
	
	function insertInstitution($name)
	{
		$name = trim($name);
		$sql = $this->db->query("SELECT * FROM instituciones WHERE Institucion=? LIMIT 0,1", [$name])->first();

		if(count($sql)==0){
			$sqlInsert = $this->db->query("INSERT INTO instituciones (Institucion) VALUES (?)", [$name]);
			$id = $this->getLastID();
			return $id;
		}else
			return $sql["ID_Instituciones"];
	}
	
	function searchAutorByApellido($apellido){
		return $this->db->query("SELECT * FROM personas_trabajos_libres WHERE Apellidos LIKE ?", ["%".$apellido."%"])->results();
	}
	
	function getAutores(){
		return $this->db->query("SELECT * FROM personas_trabajos_libres ORDER BY Apellidos")->results();
	}
	
	function getHoras(){
		return $this->db->query("SELECT * FROM horas ORDER BY Hora")->results();
	}
	
	function guardarArchivoTL($archivo,$trabajo,$nombre_carpeta = "tl"){
		$archivo_tl = $archivo["name"];
				
		if($archivo["tmp_name"]!=""){
			$extension = explode(".",$archivo_tl);
			$extension = end($extension);
			
			if(
				strtolower($extension)!="doc" &&
				strtolower($extension)!="docx" &&
				strtolower($extension)!="pdf"
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
				strtolower($extension)=="wsh" ||
				strtolower($extension)=="txt" ||
				strtolower($extension)=="pdf" ||
				strtolower($extension)=="jpg" ||
				strtolower($extension)=="bmp" ||
				strtolower($extension)=="jpeg"||
				strtolower($extension)=="gif"
			*/
			){
				header("Location: index.php?error=file");
				die();
			}
			if(filesize($archivo["tmp_name"])>20971520)
			{
				header("Location: index.php?error=size");
				die();
			}
			
			$archivo_tl = $trabajo["numero_tl"]."_".$trabajo["nombre"]."_".$trabajo["apellido"];
			$archivo_tl = $this->reemplazarNombreArchivo($archivo_tl.".".$extension);
			@unlink("../".$nombre_carpeta."/$archivo_tl");
			if(!copy($archivo["tmp_name"], "../".$nombre_carpeta."/$archivo_tl")){
				$puede_ingresar=false;
			}
			
			return $archivo_tl;
		}
	}

	function reArrayFiles(&$file_post) {

		$file_ary = array();
		$file_count = count($file_post['name']);
		$file_keys = array_keys($file_post);

		for ($i=0; $i<$file_count; $i++) {
			foreach ($file_keys as $key) {
				$file_ary[$i][$key] = $file_post[$key][$i];
			}
		}

		return $file_ary;
	}

	function guardarArchivoCV($archivo,$trabajo){
        $file_ary = $this->reArrayFiles($archivo);
        if(count($file_ary)>0) {
            $_files = $this->db->get('trabajos_libres', ['numero_tl', '=', $trabajo['numero_tl']])->first();
            $json = array();
            if ($_files['archivo_cv'])
                $json = json_decode($_files['archivo_cv'], true);
            $_SESSION["abstract"]["archivo_cv"] = array();
            foreach ($file_ary as $file) {
                if ($file["tmp_name"] != '') {
                    $extension = explode(".", $file['name']);
                    $extension = end($extension);

                    if (strtolower($extension) != "pdf") {
                        header("Location: index.php?error=file");
                        die();
                    }
                    if (filesize($file["tmp_name"]) > 2097152) {
                        header("Location: index.php?error=size");
                        die();
                    }
                    if (count($json) == 0)
                        $index = 0;
                    else
                        $index = (int)end(explode('_', end($json)));

                    $new_name = $trabajo["numero_tl"] . '_cv_' . ($index + 1);
                    if (copy($file["tmp_name"], "../uploads/cv/{$new_name}.pdf")) {
                        $json[] = $new_name;
                        $this->db->update('trabajos_libres', "numero_tl='{$trabajo['numero_tl']}'", ['archivo_cv' => json_encode($json)]);
                        $_SESSION["abstract"]["archivo_cv"][] = $new_name;
                    }
                }
            }
        }
    }
	
	function limpiar($String){
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
		
	function reemplazarNombreArchivo($str, $replace=array(), $delimiter='_') {
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
	
	function getIdiomaTL()
	{
		return $this->db->query("SELECT * FROM tl_idiomas ORDER BY id")->results();
	}
	
	function getIdiomaTLID($id)
	{
		$sql = $this->db->get("tl_idiomas", ["id","=",$id])->first();
		return $sql["idioma"];
	}
	
	private function saveTL(){	
	
		$palabras_claves = "";
		if($_SESSION["abstract"]["palabra_clave1"]!="")
			$palabras_claves .= $_SESSION["abstract"]["palabra_clave1"];
			
		if($_SESSION["abstract"]["palabra_clave2"]!="")
			$palabras_claves .= ", ".$_SESSION["abstract"]["palabra_clave2"];
		
		if($_SESSION["abstract"]["palabra_clave3"]!="")
			$palabras_claves .= ", ".$_SESSION["abstract"]["palabra_clave3"];
		
		if($_SESSION["abstract"]["palabra_clave4"]!="")
			$palabras_claves .= ", ".$_SESSION["abstract"]["palabra_clave4"];
			
		if($_SESSION["abstract"]["palabra_clave5"]!="")
			$palabras_claves .= ", ".$_SESSION["abstract"]["palabra_clave5"];
		/*$pal1 = NULL;
        if($_SESSION["abstract"]["palabra_clave1"]!="")
            $pal1 = $_SESSION["abstract"]["palabra_clave1"];
        $pal2 = NULL;
        if($_SESSION["abstract"]["palabra_clave2"]!="")
            $pal2 = $_SESSION["abstract"]["palabra_clave2"];
        $pal3 = NULL;
        if($_SESSION["abstract"]["palabra_clave3"]!="")
            $pal3 = $_SESSION["abstract"]["palabra_clave3"];
        $pal4 = NULL;
        if($_SESSION["abstract"]["palabra_clave4"]!="")
            $pal4 = $_SESSION["abstract"]["palabra_clave4"];
        $pal5 = NULL;
        if($_SESSION["abstract"]["palabra_clave5"]!="")
            $pal5 = $_SESSION["abstract"]["palabra_clave5"];*/

		if($_SESSION["abstract"]["area_tl"] != ""){
			$area_tl = (int)$_SESSION["abstract"]["area_tl"];
		}else
			$area_tl = 0;
        if($_SESSION["abstract"]["linea_transversal"] != ""){
            $linea_transversal = (int)$_SESSION["abstract"]["linea_transversal"];
        }else
            $linea_transversal = NULL;

        if(empty($_SESSION["abstract"]["apoyo_audiovisual"])){
            $apoyo_audiovisual = 0;
        }else
            $apoyo_audiovisual = (int)$_SESSION["abstract"]["apoyo_audiovisual"];
			
		if($_SESSION["abstract"]["resumen_tl"] == ""){
			$resumen_tl = NULL;
		}else{
			$resumen_tl = $_SESSION["abstract"]["resumen_tl"];
		}
		if($_SESSION["abstract"]["resumen_tl2"] == ""){
			$resumen_tl2 = NULL;
		}else{
			$resumen_tl2 = $_SESSION["abstract"]["resumen_tl2"];
		}
        if($_SESSION["abstract"]["resumen_tl3"] == ""){
            $resumen_tl3 = NULL;
        }else{
            $resumen_tl3 = $_SESSION["abstract"]["resumen_tl3"];
        }
        $modalidad = (int)$_SESSION["abstract"]["modalidad"];
		
		$data = array(
		    //"reglamento"=>(int)$_SESSION["abstract"]["reglamento"],
            //"conflicto_descripcion"=>$_SESSION["abstract"]["conflicto_descripcion"],
			"modalidad" => $modalidad,
			"linea_transversal" => $linea_transversal,
			"apoyo_audiovisual" => $apoyo_audiovisual,
			"area_tl" => $area_tl,
			//"tematica_tl"=>(int)$_SESSION["abstract"]["tematica_tl"],
			"tipo_tl" => (int)$_SESSION["abstract"]["tipo_tl"],
			"titulo_tl" => $_SESSION["abstract"]["titulo_tl"],
			
			//"modalidad"=>$_SESSION["abstract"]["modalidad"],
			"idioma_tl" => $_SESSION["abstract"]["idioma_tl"],
			"resumen" => $resumen_tl,
			"resumen2" => $resumen_tl2,
			"resumen3" => $resumen_tl3,
			"palabrasClave"=>$_SESSION["abstract"]["palabras_claves"],
            //"palabra_clave1"=>$pal1,
            //"palabra_clave2"=>$pal2,
            //"palabra_clave3"=>$pal3,
            //"palabra_clave4"=>$pal4,
            //"palabra_clave5"=>$pal5,
			"contacto_mail" => $_SESSION["abstract"]["contacto_mail"],
			"contacto_mail2" => $_SESSION["abstract"]["contacto_mail2"],
			"contacto_nombre" => $_SESSION["abstract"]["contacto_nombre"],
			"contacto_apellido" => $_SESSION["abstract"]["contacto_apellido"],
			"contacto_pais" => $_SESSION["abstract"]["contacto_pais"],
			"contacto_institucion" => $this->insertInstitution($_SESSION["abstract"]["contacto_institucion"]),
			"contacto_ciudad" => $_SESSION["abstract"]["contacto_ciudad"],
			"contacto_telefono" => $_SESSION["abstract"]["contacto_telefono"],
			"browser" => $_SESSION["abstract"]["browser"]
		);

		if($_SESSION["abstract"]["id_tl"]==""){
			$numero_de_trabajo = $this->getLastNumTL();
            $data["numero_tl"] = $numero_de_trabajo;
			
			$password = $this->generarClave(5);
			$_SESSION["abstract"]["password"] = $password;
            $data["clave"] = $password;
            $data["fecha_creado"] = date("Y-m-d");//var_dump($data);
			$data["ultima_modificacion"] = date("Y-m-d");
			$data["lang"] = $_SESSION["abstract"]["lang"];
			$result_tl = $this->db->insert("trabajos_libres", $data);
		}else{
            $data["ultima_modificacion"] = date("Y-m-d");
            if(!$_SESSION["admin"]){
                $data["lang"] = $_SESSION["abstract"]["lang"];
            }
			$result_tl = $this->db->update("trabajos_libres","id_trabajo='{$_SESSION["abstract"]["id_tl"]}'",$data);
			$numero_de_trabajo = $_SESSION["abstract"]["numero_tl"];
		}
        $id_tl = ($_SESSION["abstract"]["id_tl"]?$_SESSION["abstract"]["id_tl"]:$this->db->lastID());

		$array_a_retornar = array("id_tl"=>$id_tl,"numero_tl"=>$numero_de_trabajo);
        //Guardar archivo
		
		if($_FILES["archivo_tl"]["name"] !== "" && $_FILES["archivo_tl"]["tmp_name"] !== ""){
			$archivo_tl = $_FILES["archivo_tl"];
			$nombre_archivo = $this->guardarArchivoTL($archivo_tl,array("nombre" => $data["contacto_nombre"], "apellido" => $data["contacto_apellido"], "numero_tl" => $numero_de_trabajo));
			$result_subir_archivo = $this->db->update("trabajos_libres","id_trabajo=".$id_tl,array("archivo_tl" => $nombre_archivo));
			$array_a_retornar["archivo_name"] = $nombre_archivo;
		}
		
		
        $archivo_cv = $_FILES["archivo_cv"];
		if($archivo_cv){
			$autores = array("numero_tl"=>$numero_de_trabajo);
			$this->guardarArchivoCV($archivo_cv,$autores);
		}
		//return array("id_tl"=>$id_tl,"numero_tl"=>$numero_de_trabajo);
		return $array_a_retornar;
	}
	
	 private function saveAutores($id_tl){
        if($id_tl==0 || $id_tl=='0' || empty($id_tl))
            $id_tl = NULL;
		
		$ids_autores = array();
		for($i=0;$i<$_SESSION["abstract"]["total_autores"];$i++){
			$ids_autores[] = $_SESSION["abstract"]["id_autor_".$i];
			$verf_autor = $this->getAutorIDcount($_SESSION["abstract"]["id_autor_".$i]);
			if($_SESSION["abstract"]["institucion_".$i] == 'Otra'){
                $institucion_autor = $this->validarInstitucionAutores($_SESSION["abstract"]["institucion-txt_".$i]);
                $institucion = $_SESSION["abstract"]["institucion_".$i];
                $institucion_otro = $institucion_autor;
            } else {
                $institucion_autor = $this->validarInstitucionAutores($_SESSION["abstract"]["institucion_".$i]);
                $institucion = $institucion_autor;
                $institucion_otro = NULL;
            }
			
			if($_SESSION["abstract"]["rol_".$i]){
				$rol_crono = $_SESSION["abstract"]["rol_".$i];
			}else{
				$rol_crono = NULL;
			}
            if($_SESSION["abstract"]["profesion-txt_".$i]){
                $profesion_otro = $_SESSION["abstract"]["profesion-txt_".$i];
            }else{
                $profesion_otro = NULL;
            }
			
			$datos_autores = array(
				"Profesion" => $_SESSION["abstract"]["profesion_".$i],
                "Profesion_otro" => $profesion_otro,
				"Nombre"=>$_SESSION["abstract"]["nombre_".$i],
				"Apellidos"=>$_SESSION["abstract"]["apellido_".$i],
				"pasaporte"=>$_SESSION["abstract"]["pasaporte_".$i],
				"rol_crono"=>$rol_crono,
				//"Apellidos2"=>$_SESSION["abstract"]["apellido2_".$i],
				"Pais"=>$_SESSION["abstract"]["pais_".$i],
				"pertenencia" => $_SESSION["abstract"]["pertenencia_".$i],
				"Institucion" => $institucion,
                "Institucion_otro" => $institucion_otro,
				"Mail"=>$_SESSION["abstract"]["email_".$i],
				"ciudad"=>$_SESSION["abstract"]["ciudad_".$i]
			);
			
			if($verf_autor){
				$result_autores = $this->db->update("personas_trabajos_libres","ID_Personas=".$_SESSION["abstract"]["id_autor_".$i],$datos_autores);
				$autores_last = $_SESSION["abstract"]["id_autor_".$i];
			}else{
				$result_autores = $this->db->insert("personas_trabajos_libres",$datos_autores);
				$autores_last = $this->db->lastID();
			}	
			
					
			
			if($result_autores){
				$insert_autores_con = array(
					"ID_trabajos_libres"=>$id_tl,
					"ID_participante" => $autores_last,
					"lee"=>$_SESSION["abstract"]["lee_".$i]
				);
				if($verf_autor) {
					unset($insert_autores_con["ID_participante"]);
					$result = $this->db->update("trabajos_libres_participantes","ID_participante=".$_SESSION["abstract"]["id_autor_".$i],$insert_autores_con);
				}else {
					$result = $this->db->insert("trabajos_libres_participantes",$insert_autores_con);
				}
			}	
		}
		
		
		if($verf_autor){
			$revisarAutores = $this->getAutoresIDtl($id_tl);
			foreach($revisarAutores as $rowAut){
				$this->eliminarAutorDeltrabajoID($ids_autores,$rowAut["ID_participante"]);
			}
		}
		
	} 

	
	public function todoTL(){
        try{
            //Simulate Queries
            $this->db->beginTransaction();
            $tl = $this->saveTL();//var_dump('aca');die();
			$this->saveAutores($tl["id_tl"]);
			//Commit all changes to db
			$this->db->commit();
			$array_return = array("success"=>1,"numero_tl"=>$tl["numero_tl"]);
			if(array_key_exists("archivo_name", $tl)){
				$array_return["archivo_name"] = $tl["archivo_name"];
			}
			return $array_return;
		}catch(Exception $e){
			//Rolback all changes.
            if(\Config::get('debug'))
			    var_dump("Error at line " . __LINE__ . " in " . __FILE__ . ": " . $e->getMessage());
			$this->db->rollback();
            if(\Config::get('debug'))
                die();
			return array("success"=>0);
		}
	}
		
}