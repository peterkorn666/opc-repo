<?
class datos_prueba_color{

	var $nCon;
	var $nCon_Andres;
	var $nCon_Heliux;

	var $id_prueba_color;
	var $referencia;
	var $formato_ancho;
	var $formato_alto;
	var $cantidad;
	var $forma_de_pago;
	var $entrega_archivo;
	var $observaciones;
	var $tipo_papel;
	var $calidad;
	var $estado;

	var $num_sess;
	var $num_ip;
	var $fecha;

	var $idCLiente;


	function datos_prueba_color(){
		$this->nCon = conectarDB_Nuestra();
	}
	function alta_prueba_color($referencia, $formato_ancho, $formato_alto, $cantidad, $forma_de_pago, $entrega_archivo, $observaciones, $tipo_papel, $calidad, $estado, $num_sess, $num_ip, $fecha, $idCLiente)  {
		$sql ="INSERT INTO prueba_color (referencia, formato_ancho, formato_alto, cantidad, forma_de_pago, entrega_archivo, observaciones, tipo_papel, calidad, estado, num_sess, num_ip, fecha, idCLiente)
VALUES ('$referencia', '$formato_ancho', '$formato_alto', '$cantidad', '$forma_de_pago', '$entrega_archivo', '$observaciones', '$tipo_papel', '$calidad', '$estado', '$num_sess', '$num_ip',  NOW(), '$idCLiente') ;";
		echo $sql;
		mysqli_query($this->nCon,$sql);
		$_SESSION["ultimoID"]= mysqli_insert_id();
	}

	public function seleccionar_un_prueba_color($unId){
		$sql ="SELECT * FROM prueba_color WHERE id_prueba_color='$unId' LIMIT 1;";
		$rs = mysqli_query($this->nCon,$sql) or die ("error al seleccionar un prueba_color");
		return $rs;
	}
	public function actualizar_un_prueba_color($unId){
		$leido = false;
		$sql = "SELECT * FROM prueba_color WHERE id_prueba_color='$unId' AND  leido = '0' LIMIT 1;";
		$rs = mysqli_query($this->nCon,$sql) or die ("error al seleccionar un prueba_color");
		while($row=mysqli_fetch_array($rs)){
			$sql0 ="UPDATE prueba_color SET leido = '1' WHERE id_prueba_color ='$unId' LIMIT 1;";
			mysqli_query($this->nCon,$sql0) or die ("error al actualizar prueba_color");
		$leido = true;
		}
		return $leido;
	}
	
	public function seleccionar_prueba_color_leido($unEstado){

		$sql ="SELECT * FROM prueba_color WHERE leido='$unEstado'   AND estado = 'Envio'  ORDER BY id_prueba_color DESC";
		$rs = mysqli_query($this->nCon,$sql) or die ("error al seleccionar prueba_color leido");

		return $rs;
	}

}
?>
