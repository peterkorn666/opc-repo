<?
class datos_escanner{

	var $nCon;
	var $nCon_Andres;
	var $nCon_Heliux;

	var $id_escanner;
	var $referencia;
	var $formato_ancho;
	var $formato_alto;
	var $cantidad;
	var $forma_de_pago;
	var $grabar_cd;
	var $imagen;
	var $base;
	var $tipo_original;
	var $resolucion;
	var $retoque_especial;
	var $observaciones;
	var $estado;

	var $num_sess;
	var $num_ip;
	var $fecha;

	var $idCLiente;


	function datos_escanner(){
		$this->nCon = conectarDB_Nuestra();
	}

	function alta_escanner($referencia, $formato_ancho, $formato_alto, $cantidad, $forma_de_pago, $grabar_cd, $imagen, $base, $tipo_original, $resolucion, $retoque_especial, $observaciones, $estado, $num_sess, $num_ip, $fecha,  $idCLiente) {
		$sql ="INSERT INTO escanner (referencia, formato_ancho, formato_alto, cantidad, forma_de_pago, grabar_cd, imagen, base, tipo_original, resolucion, retoque_especial, observaciones, estado, num_sess, num_ip, fecha, idCLiente)
VALUES ('$referencia', '$formato_ancho', '$formato_alto', '$cantidad', '$forma_de_pago', '$grabar_cd', '$imagen', '$base', '$tipo_original', '$resolucion', '$retoque_especial', '$observaciones', '$estado', '$num_sess', '$num_ip',  NOW(), '$idCLiente');";
		echo $sql;
		mysqli_query($this->nCon,$sql);
		$_SESSION["ultimoID"]= mysqli_insert_id();
	}


	public function seleccionar_un_escanner($unId){		
		$sql ="SELECT * FROM escanner WHERE id_escanner='$unId' LIMIT 1;";
		$rs = mysqli_query($this->nCon,$sql) or die ("error al seleccionar un escanner");
		return $rs;
	}
	public function actualizar_un_escanner($unId){
		$leido = false;
		$sql = "SELECT * FROM escanner WHERE id_escanner='$unId' AND  leido = '0' LIMIT 1;";
		$rs = mysqli_query($this->nCon,$sql) or die ("error al seleccionar un escanner");
		while($row=mysqli_fetch_array($rs)){
			$sql0 ="UPDATE escanner SET leido = '1' WHERE id_escanner ='$unId' LIMIT 1;";
			mysqli_query($this->nCon,$sql0) or die ("error al actualizar escanner");
			$leido = true;
		}
		return $leido;
	}
	public function seleccionar_escanner_leido($unEstado){

		$sql ="SELECT * FROM escanner WHERE leido='$unEstado'   AND estado = 'Envio'  ORDER BY id_escanner DESC";
		$rs = mysqli_query($this->nCon,$sql) or die ("error al seleccionar escanner leido");

		return $rs;
	}
}
?>
