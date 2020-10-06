<?
class archivo{

	
	var $nCon;

	var $id;
	var $nombre;


	var $RAIZ_SERVER = "/programa.copinaval2009.com/programa/tl/";
				


	var $HOST = "copinaval2009.com";
	var $USU = "ftp_copinaval";
	var $PASS = 'VyLC$QPE';
	var $id_con ;
	
	
	var $archivoSuvidoOk;


	function archivo(){
		$this->nCon = conectarDB();

	}


	function conectarServidor(){

		// establecer una conexion basica
		$id_con = ftp_connect($this->HOST);

		// inicio de sesion con nombre de usuario y contrasenya
		$resultado_login = ftp_login($id_con, $this->USU, $this->PASS);

		$this->id_con = $id_con;

		// chequear la conexion
		if ((!$id_con) || (!$resultado_login)) {
			echo "La conexion FTP ha fallado'";
			exit;
		} else {
			//echo "<script>parent.llenarDivCargando('Conectado con el servidor');\n";
		}

		return "ok";

	}


	function subirArchivo($archivo_destino , $archivo_fuente){

		ini_set('max_execution_time','601');
		
		$subido = false;
		$this->conectarServidor();
		

		// cargar el archivo /*$carpeta*/
		$carga = @ftp_put($this->id_con, ($this->RAIZ_SERVER . $archivo_destino), $archivo_fuente, FTP_BINARY);

	
		// chequear el status de la carga
		if (!$carga) {

			/*echo "<br><font color='#ff0000'>Fallo la carga del archivo</font>";
			echo "<script>parent.document.getElementById('cargando').style.display='none'</script>\n";
			echo "<script>parent.document.getElementById('frameItem').style.display='inline'</script>\n";*/
			
			$subido = false;

		} else {

			
		
			//$this->insertarArchivo_en_base($archivo_destino);
			
			/*echo "<font size='2' face='Arial, Helvetica, sans-serif'>-El archivo se cargo correctamente</font></div><br>";
			echo "<script>parent.document.getElementById('cargando').style.display='none'</script>\n";
			echo "<script>parent.document.getElementById('frameItem').style.display='inline'</script>\n";*/
			$subido = true;
			
		}

		// cierra la secuencia FTP
		ftp_close($this->id_con);

	return $subido;

	}

	function insertarArchivo_en_base($nombre_archivo){


		$sql = "UPDATE trabajos_libres SET archivo_tl='$nombre_archivo' WHERE ID='".$_SESSION["ID_TL"]."';";
		$rs = $this->nCon->query($sql);

		return "OK";

	}


}
?>