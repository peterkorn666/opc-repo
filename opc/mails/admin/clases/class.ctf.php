<?
class datos_ctf{

	var $nCon;
	var $nCon_Andres;
	var $nCon_Nos;

	var $id_ctp;
	var $referencia;
	var $formato_ancho;
	var $formato_alto;
	var $cantidad;
	var $forma_de_pago;
	var $entrega_archivo;
	var $armado_pliego;
	var $observaciones;
	var $tintas;
	var $lineatura;
	var $sobreimpresion;
	var $trapping;
	var $promocion;
	var $estado;

	var $num_sess;
	var $num_ip;
	var $fecha;

	var $idCLiente;

	function datos_ctf(){
		$this->nCon = conectarDB_Nuestra();
	}
	function alta_ctf($referencia, $formato_ancho, $formato_alto, $cantidad, $forma_de_pago, $entrega_archivo, $armado_pliego, $observaciones, $tintas, $lineatura, $sobreimpresion, $trapping, $promocion, $estado, $num_sess, $num_ip, $fecha, $idCLiente){
		$sql ="INSERT INTO ctf (referencia, formato_ancho, formato_alto, cantidad, forma_de_pago,  entrega_archivo, armado_pliego, observaciones, tintas, lineatura, sobreimpresion, trapping, promocion, estado, num_sess, num_ip, fecha, idCLiente)
VALUES ('$referencia', '$formato_ancho', '$formato_alto', '$cantidad', '$forma_de_pago', '$entrega_archivo', '$armado_pliego', '$observaciones', '$tintas', '$lineatura', '$sobreimpresion', '$trapping', '$promocion', '$estado', '$num_sess', '$num_ip',  NOW(), '$idCLiente') ;";
		echo $sql;
		mysqli_query($this->nCon,$sql);
		$_SESSION["ultimoID"]= mysqli_insert_id();
	}


	public function seleccionar_un_ctf($unId){
				
		$sql = "SELECT * FROM ctf WHERE id_ctf='$unId' LIMIT 1;";
		$rs = mysqli_query($this->nCon,$sql) or die ("error al seleccionar un ctf");

		return $rs;
	}
	
	public function actualizar_un_ctf($unId){
		$leido = false;
		$sql = "SELECT * FROM ctf WHERE id_ctf='$unId' AND  leido = '0' LIMIT 1;";
		$rs = mysqli_query($this->nCon,$sql) or die ("error al seleccionar un ctf");
		while($row=mysqli_fetch_array($rs)){
			$sql0 ="UPDATE ctf SET leido = '1' WHERE id_ctf ='$unId' LIMIT 1;";
			mysqli_query($this->nCon,$sql0) or die ("error al actualizar ctf");
			$leido = true;
		}
		return $leido;
	}
	
	
	public function seleccionar_ctf_leido($unEstado){
		
		$sql ="SELECT * FROM ctf WHERE leido='$unEstado'   AND estado = 'Envio'  ORDER BY id_ctf DESC";
		$rs = mysqli_query($this->nCon,$sql) or die ("error al seleccionar ctf leido");
		
		return $rs;
	}

}
?>
