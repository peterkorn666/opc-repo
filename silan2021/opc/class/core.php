<?php
require_once("Db.class.php");
class Core{
	var $bd, $config;
	public function __construct()
	{
			$this->bd = new DB();
			$this->config = $this->getConfig();
	}
	
	public function prepare($sql){
		return $this->bd->prepare($sql);
	}
	
	public function query($sql){
		return $this->bd->query($sql);
	}
	
	public function row($sql){
		return $this->bd->row($sql);
	}
	
	public function bind($pos,$bind){
		$this->bd->bind($pos,$bind);
	}
	
	public function getLastID(){
		return $this->bd->lastInsertId();
	}
	
	public function Debug($bool){
		if($bool)
			error_reporting(E_ALL ^ E_NOTICE);
	}

	public function getClaves(){
		return $this->bd->query("SELECT * FROM claves WHERE ID_clave<>1");
	}

	public function getCuentas(){
		return $this->bd->query("SELECT * FROM cuentas ORDER BY id DESC");
	}

    public function getTrabajos($id_cuenta){
        return $this->bd->query("SELECT * FROM trabajos_libres WHERE id_cliente='{$id_cuenta}'");
    }
	
	public function getTrabajosLibres(){
        return $this->bd->query("SELECT * FROM trabajos_libres");
    }

	public function searchFirstDay()
	{
		$sql = $this->bd->query("SELECT SUBSTRING(start_date,1,10) as start_date FROM cronograma ORDER BY start_date ASC LIMIT 0,1");
		$row = $sql->fetch();
		return $row["start_date"];
	}
	
	public function getCronoByDaySala($day,$sala="",$tipo_actividad=""){
		$w = "WHERE 1=1";
		if($day)
		{
			$this->bd->bind("start",$day);
			$w .= " AND SUBSTRING(start_date,1,10)=:start";
		}
		if($sala)
		{
			$this->bd->bind("sala",$sala);
			$w .= " AND section_id=:sala";
		}
		if($tipo_actividad)
		{
			$this->bd->bind("tipo_actividad",$tipo_actividad);
			$w .= " AND tipo_actividad=:tipo_actividad";
		}
		if($w && !$_SESSION["admin"]){
			$w .= " AND s.visible=1";
		}
		
		$sql = $this->bd->query("SELECT * FROM cronograma as c JOIN salas as s ON c.section_id=s.salaid $w ORDER BY SUBSTRING(c.start_date,1,10),s.orden,c.start_date");
		return $sql;
	}
	
	public function getSalaID($id_sala)
	{
		$this->bd->bind("id",$id_sala);
		$sql = $this->bd->row("SELECT * FROM salas WHERE salaid = :id");
		return $sql;
	}

	public function getSalas(){
		$sql = $this->bd->query("SELECT * FROM salas ORDER BY orden");
		return $sql;
	}

    public function getTiposActividades()
    {
        $sql = $this->bd->query("SELECT * FROM tipo_de_actividad ORDER BY id_tipo_actividad");
        return $sql;
    }
	
	public function helperDate($date,$start=0,$end=1)
	{
		$s = substr($date,$start,$end);
		return $s;
	}
	
	public function getNameTipoActividadID($tipo_actividad)
	{
		$this->bd->bind("id",$tipo_actividad);
		$sql = $this->bd->row("SELECT * FROM tipo_de_actividad WHERE id_tipo_actividad = :id");
		return $sql;
	}
	
	public function getTematicaID($tematica){
		$this->bd->bind("id",$tematica);
		$sql = $this->bd->row("SELECT * FROM tematicas WHERE ID_Tematicas = :id");
		return $sql;
	}
	
	public function getCronoConferencistas($id_crono)
	{
		$this->bd->bind("id",$id_crono);
		$sql = $this->bd->query("SELECT * FROM crono_conferencistas WHERE id_crono = :id ORDER BY id");
		return $sql;
	}
	
	public function getConferencistaID($id_conf)
	{
		$this->bd->bind("id",$id_conf);
		$sql = $this->bd->row("SELECT * FROM conferencistas WHERE id_conf = :id");
		return $sql;
	}

	public function getCronoTL($id_crono)
	{
		$this->bd->bind("id",$id_crono);
		$sql = $this->bd->query("SELECT * FROM trabajos_libres WHERE id_crono = :id ORDER BY orden, numero_tl");
		//$sql = $this->bd->query("SELECT * FROM trabajos_libres WHERE id_crono = :id ORDER BY numero_tl DESC");
		return $sql;
	}

	
	public function returnAllTables($table){
		$sql = $this->bd->query("SHOW COLUMNS FROM $table");
		return $sql;
		
	}
	
	public function getConfig(){
		$sql = $this->bd->row("SELECT * FROM config WHERE id=1");
		return $sql;
	}
	
	public function getAreas()
	{
		$sql = $this->bd->query("SELECT * FROM areas ORDER BY Area");
		return $sql;
	}
	
	public function getAreasTL()
	{
		$sql = $this->bd->query("SELECT * FROM areas_trabjos_libres ORDER BY orden");
		return $sql;
	}
	
	public function getTipoTL()
	{
		$sql = $this->bd->query("SELECT * FROM tipo_de_trabajos_libres ORDER BY id");
		return $sql;
	}
	public function getTipoTLID($id)
	{
		$this->bd->bind("id",$id);
		return $this->bd->row("SELECT * FROM tipo_de_trabajos_libres WHERE id=:id");
	}
	
	public function getAreaID($id)
	{
		$this->bd->bind("id",$id);
		$sql = $this->bd->row("SELECT * FROM areas WHERE ID_Areas=:id");
		return $sql;
	}
	
	
	public function getAreasTLID($id)
	{
		$this->bd->bind("id", $id);
		$sql = $this->bd->query("SELECT * FROM areas_trabjos_libres WHERE id=:id");
		return $sql[0]["Area_es"];
	}
	
	public function getIdiomas()
	{
		$sql = $this->bd->query("SELECT * FROM tl_idiomas ORDER BY idioma");
		return $sql;
	}
	
	public function getIdiomaID($id)
	{
		$this->bd->bind("id", $id);
		$sql = $this->bd->row("SELECT * FROM tl_idiomas WHERE id=:id");
		return $sql;
	}
	
	public function getPaisID($pais){
		$this->bd->bind('pais',$pais);
		$select = $this->bd->query("SELECT * FROM paises WHERE ID_Paises=:pais ORDER BY Pais");
		return $select[0]["Pais"];
	}
	
	
	public function getRoles()
	{
		$sql = $this->bd->query("SELECT * FROM calidades_conferencistas ORDER BY calidad");
		return $sql;
	}

    public function getRolID($id)
    {
        $this->bind("id",$id);
        $sql = $this->bd->row("SELECT * FROM calidades_conferencistas WHERE ID_calidad=:id");
        return $sql;
    }
	
	public function getInstitutiones()
	{
		$sql = $this->bd->query("SELECT * FROM instituciones ORDER BY Institucion");
		return $sql;
	}

	public function getInstitution($id)
	{
		$this->bd->bind("id",$id);
		$sql = $this->bd->row("SELECT * FROM instituciones WHERE ID_Instituciones=:id");
		return $sql;
	}
	
	public function insertInstitution($name)
	{
		$name = trim($name);
		$this->bd->bind("name",$name);
		$sql = $this->bd->row("SELECT * FROM instituciones WHERE Institucion=:name");
		if(!$sql){
			$this->bd->bind("ins",$name);
			$sqlInsert = $this->bd->query("INSERT INTO instituciones (Institucion) VALUES (:ins)");
			$id = $this->getLastID();
			return $id;
		}
		return $sql["ID_Instituciones"];
	}
	
	public function getPais($id)
	{
		$this->bd->bind("id",$id);
		return $this->bd->row("SELECT * FROM paises WHERE ID_Paises=:id");
	}

	public function getPaises()
	{
		return $this->query("SELECT * FROM paises ORDER BY Pais");
	}
	
	public function getProfesiones()
	{
		return $this->query("SELECT * FROM profesiones ORDER BY Profesion");
	}
	
	public function getCargos()
	{
		return $this->query("SELECT * FROM cargos ORDER BY Cargos");
	}
	
	public function getAutor($id)
	{
		$this->bind("id", $id);
		return $this->row("SELECT * FROM personas_trabajos_libres WHERE ID_Personas=:id");
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

			/*if(strtolower($extension)!="pdf"){
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

                ){
				header("Location: index.php?error=file");
				die();
			}*/
			if(filesize($file["tmp_name"])>20971520)
				return "file_type";
			if($nombre=="")
				$nombre = $archivo;
			else
				$nombre = $nombre.".".$extension;
			$archivo_name = $this->reemplazarNombreArchivo($nombre);
			if(!copy($file["tmp_name"], $ruta.$archivo_name))
				return "error";

			return $archivo_name;
		}
	}

	public function messages($type){
		$html = '';
		switch($type){
			case 'ok':
				$html = '<div class="alert alert-dismissible alert-success fade in">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Estado:</strong> Todos los datos se han guardado correctamente.
</div>';
			break;
			case 'error':
				$html = '<div class="alert alert-dismissible alert-danger fade in">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Estado:</strong> Hubo un error al guardar los datos.
</div>';
			break;
			case 'dok':
				$html = '<div class="alert alert-dismissible alert-success fade in">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Estado:</strong> Todos los datos se han eliminado correctamente.
</div>';
			break;
		}
		return $html;
	}
	
	public function busquedaTL($param){
		if($param["filtro_estado"] == "cualquier" || $param["filtro_estado"] == ""){
			$filtro = "where estado like '%%' ";
		}else if($param["filtro_estado"]!=""){
			$filtro = "where estado = ".$param["filtro_estado"];
		}			
		if(trim($param["filtro_palabra_clave"]) || trim($param["filtro_email_autor"])){
			if($param["filtro_palabra_clave"])
				$arrayBusquedaClave = @explode(" ",  $param["filtro_palabra_clave"]);
			else
				$arrayBusquedaClave = @explode(" ",  $param["filtro_email_autor"]);


			/****************************/
			
			$sql2 =  "SELECT ID_Personas, Profesion, Nombre, Apellidos, Pais, Mail, Cargos FROM personas_trabajos_libres WHERE ";
			
			$bucle2 = 0;
			$arrayPersonasTL = array();
			foreach ($arrayBusquedaClave as $u){

				if($bucle2>0){
					$sql2 .= " or (";
				}else{
					$sql2 .= " (";
				}
				if($param["filtro_palabra_clave"]){
					$sql2 .= "    Profesion like '%$u%' ";
					$sql2 .= " or Nombre like '%$u%' ";
					$sql2 .= " or Apellidos like '%$u%' ";
					$sql2 .= " or Pais like '%$u%' ";
					$sql2 .= " or Mail like '%$u%' ";					
					$sql2 .= " or Cargos like '%$u%'";
				}
				if($param["filtro_email_autor"]){
					if($param["filtro_palabra_clave"])
						$sql2 .= " AND ";
					$sql2 .= "Mail like '%".$param["filtro_email_autor"]."%' ";	
				}
				
				$sql2 .= ")";

				$bucle2 = $bucle2 + 1;
			}
			//echo $sql2;
			$rs2 = $this->query($sql2);
			foreach($rs2 as $row2)
				array_push($arrayPersonasTL, $row2["ID_Personas"]);

			$sqlI = "SELECT * FROM instituciones WHERE ";
			$bucle2 = 0;
			$arrayIns = array();
			foreach ($arrayBusquedaClave as $u){

				if($bucle2>0){
					$sqlI .= " or ";
				}

				$sqlI .= " Institucion like '%$u%' ";
	

				$bucle2 = $bucle2 + 1;
			}
			$rs2 = $this->query($sqlI);
			foreach($rs2 as $row2)
				array_push($arrayIns, $row2["ID_Instituciones"]);
			
			$bucle2 = 0;
			if(count($arrayIns)>0){
				$sql2 =  "SELECT ID_Personas, Institucion FROM personas_trabajos_libres WHERE ";
				foreach ($arrayIns as $u){
	
					if($bucle2>0){
						$sql2 .= " or ";
					}else{
						$sql2 .= " ";
					}
	
					$sql2 .= " Institucion = '$u' ";
	
					$bucle2 = $bucle2 + 1;
				}
				$rs2 = $this->query($sql2);
				foreach($rs2 as $row2)
					array_push($arrayPersonasTL, $row2["ID_Personas"]);
			}
			

			$arrayParticipantesTL = array();
			/*Veo si ecxisten estas personas en la tabla tl participantes*/
			if(count($arrayPersonasTL)>0){

				$sql3 = "SELECT DISTINCT ID_trabajos_libres FROM trabajos_libres_participantes WHERE ";
				$bucle3 = 0;

				foreach ($arrayPersonasTL as $i){
					if($bucle3>0)
						$sql3 .= " OR ";
				
					$sql3 .= " ID_participante=$i";
					$bucle3 = $bucle3 + 1;
				}

				$rs3 = $this->query($sql3);
				foreach($rs3 as $row3)
					array_push($arrayParticipantesTL, $row3["ID_trabajos_libres"]);
			}


			$arrayIDParticipantesTL = array();
			/*Si existen los participante tomo el ID*/
			if(count($arrayParticipantesTL)>0){
				
				if($filtroEstado)
					$withEstado = $filtroEstado." and";
				else
					$withEstado = 'WHERE ';
				$sql4 = "SELECT id_trabajo FROM trabajos_libres $withEstado (";
				$bucle4 = 0;
				foreach ($arrayParticipantesTL as $i){

					if($bucle4>0){
						$sql4 .= " OR ";
					}

					$sql4 .= " id_trabajo=$i";
					$bucle4 = $bucle4 + 1;

				}
				$sql4 .= ");";

				$rs4 = $this->query($sql4);
				foreach($rs4 as $row4)
					array_push($arrayIDParticipantesTL, $row4["id_trabajo"]);
			}


			$arrayIDTL = array();
			$sql5 =  "SELECT id_trabajo FROM trabajos_libres ";
			if($filtroEstado)
				$sql5 .= "$filtroEstado and";
			else
				$sql5 .= "WHERE ";
			$bucle5=0;
			foreach ($arrayBusquedaClave as $i){

				if($bucle5>0)
					$sql5 .= " OR (";
				else
					$sql5 .= " (";

				$sql5 .= "    Hora_inicio like '%$i%' ";
				$sql5 .= " or Hora_fin like '%$i%' ";
				$sql5 .= " or numero_tl like '%$i%' ";
				$sql5 .= " or titulo_tl like '%$i%' ";
				$sql5 .= " or tipo_tl like '%$i%' ";
				$sql5 .= " or contacto_mail like '%$i%' ";
				$sql5 .= " or resumen like '%$i%' ";
				$sql5 .= " or palabrasClave like '%$i%' )";

				$bucle5= $bucle5 + 1;

			}
			#echo $sql5;
			$rs5 = $this->query($sql5);
			foreach($rs5 as $row5)
				array_push($arrayIDTL, $row5["id_trabajo"]);

			$unionArrays = array_merge($arrayIDParticipantesTL, $arrayIDTL);
			$unionArraysDistintos = array_unique($unionArrays);

			$bucle6=0;
			if(count($unionArraysDistintos)>0){
				if($filtro)
					$filtro .= " and (";
				else
					$filtro .= " WHERE (";
				foreach ($unionArraysDistintos as $i){

					if($bucle6>0){
						$filtro .= " or id_trabajo ='$i'";

					}else{
						$filtro .= " id_trabajo ='$i'";
					}

					$bucle6 = $bucle6 + 1;
				}

				$filtro .= ") ";
			}else{
				$filtro .= " and id_trabajo=0  ";
			}


		}
		
		/*if($param["filtro_modalidad"]!="")
			$filtro .= " and JSON_CONTAINS(area_tl, '".$param["filtro_modalidad"]."')";*/
			
		if($param["filtro_area_tl"]!="") {
			$filtro .= " and area_tl='".$param["filtro_area_tl"]."'";
		}
		
		if($param["filtro_modalidad"]!="") {
			$filtro .= " and tipo_tl='".$param["filtro_modalidad"]."'";
		}

		if($param["filtro_ubicado"]!="")
			$filtro .= " and id_crono='".$param["filtro_ubicado"]."'";		
		
		if($param["filtro_idioma"]!="")
			$filtro .= " and idioma='".$param["filtro_idioma"]."'";
			
		if($param["filtro_premio"]!="")
			$filtro .= " and premio='".$param["filtro_premio"]."'";
		
		if($param["filtro_adjunto"]=="Si")
			$filtro .=" and archivo_tl<>''";
		else if($param["filtro_adjunto"]=="No")
			$filtro .=" and archivo_tl=''";

		if($inicio!=""){
			/////SI VIENE 0 LO TOMA COMO VACIO
			if($inicio==1)
				$inicio=0;			
			$inicio = " limit ". $inicio ." , " . $TAMANO_PAGINA;
		}else
			$inicio="";
		
		$arrayPerTLs = array();
		$bucle7 = 0;
		
		$sql = "SELECT * FROM trabajos_libres $filtro order by numero_tl ASC ". $inicio;
		//echo $sql;
		$result = $this->query($sql);		
		if($param["filtro_presentador"]=="todos" || $param["filtro_presentador"]==""){
			return $result;
			exit;
		}else{
			foreach($result as $row123){			
				$sql12 = "SELECT * FROM trabajos_libres_participantes  WHERE lee = 1 AND ID_trabajos_libres  = '" . $row123["id_trabajo"]."'";
				$result2 = $this->query($sql12);		
				foreach($result2 as $row12){						
					
					$sql1 = "SELECT * FROM personas_trabajos_libres  WHERE ID_Personas = '" . $row12["ID_participante"]."'  AND inscripto='".$param["filtro_presentador"]."'";
					$result1 = $this->query($sql1);		
					//echo mysql_num_rows($result1);
					foreach($result1 as $row1){
						if($trabajo_anterior!=$row12["ID_trabajos_libres"]){							
							if($bucle7>0)
								$filtro2 .= " or id_trabajo = '".$row12["ID_trabajos_libres"]."' ";
							else
								$filtro2 .= " id_trabajo ='".$row12["ID_trabajos_libres"]."' ";
															
							$trabajo_anterior = $row12["ID_trabajos_libres"];
							$bucle7 = $bucle7 + 1;
						}
					}
					$cons .= $sql1;
				}
						
			}
		if($filtro2){		
			$sql333 = "SELECT * FROM trabajos_libres WHERE $filtro2 ORDER BY numero_tl ";
		//var_dump($sql333);
			$result333 = $this->query($sql333);	
		}else
			$result333 = array();
		return $result333;
		}
	}
	
	public function isAdmin(){
		if(!$_SESSION["admin"]){
			return false;
		}
		return true;
	}
	
	public function canEdit(){
		if($_SESSION["canEdit"])
			return true;
		return false;
	}
	
	public function canDel(){
		if($_SESSION["canDel"])
			return true;
		return false;
	}
	
	public function getEstadosTLCount(){
		$recibidos = $this->bd->query("SELECT count(estado) as total FROM trabajos_libres WHERE estado='0'");
		$revision = $this->bd->query("SELECT count(estado) as total FROM trabajos_libres WHERE estado='1'");
		$aprobados = $this->bd->query("SELECT count(estado) as total FROM trabajos_libres WHERE estado='2'");
		$notificados = $this->bd->query("SELECT count(estado) as total FROM trabajos_libres WHERE estado='4'");
		$rechazados = $this->bd->query("SELECT count(estado) as total FROM trabajos_libres WHERE estado='3'");
		
		return array("recibidos"=>$recibidos[0]["total"], "revision"=>$revision[0]["total"], "aprobados"=>$aprobados[0]["total"], "notificados"=>$notificados[0]["total"], "rechazados"=>$rechazados[0]["total"]);
		
	}
	
	public function showUbicacion($start_date, $end_date, $section){
		$config = $this->getConfig();
		return utf8_encode(strftime($config["time_format"],strtotime($this->helperDate($start_date,0,10)))).' | '.$this->getSalaID($section)['name'].' | '.$this->helperDate($start_date,10,6).' - '.$this->helperDate($end_date,10,6);
	}
	
	public function getTLubicacion($id_crono){
			$this->bind("id_crono",$id_crono);
			$row = $this->row("SELECT * FROM cronograma WHERE id_crono=:id_crono");
			return $this->showUbicacion($row["start_date"], $row["end_date"], $row["section_id"]);
	}
	
}
?>