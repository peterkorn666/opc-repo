<?
class datos_otro{

	var $nCon;
	var $nCon_Andres;
	var $nCon_Heliux;

	var $id_otro;
	var $observaciones;

	var $num_sess;
	var $num_ip;
	var $fecha;

	var $idCLiente;


	function datos_otro(){
		$this->nCon = conectarDB_Nuestra();
	}
	function alta_otro($observaciones, $estado, $num_sess, $num_ip, $fecha, $idCLiente, $referencia)  {

		$sql ="INSERT INTO otros (observaciones, estado, num_sess, num_ip, fecha, idCLiente, referencia)
		
 			   VALUES ('$observaciones', '$estado', '$num_sess', '$num_ip',  NOW(), '$idCLiente', '$referencia') ;";

		mysqli_query($this->nCon,$sql);

		$_SESSION["ultimoID"] = mysqli_insert_id();
	}


	public function seleccionar_un_otro($unId){
		$sql ="SELECT * FROM otros WHERE id_otro ='$unId' LIMIT 1;";
		$rs = mysqli_query($this->nCon,$sql) or die ("error al seleccionar un otros");
		return $rs;
	}
	public function actualizar_un_otro($unId){
		$leido = false;
		$sql = "SELECT * FROM otros WHERE id_otro='$unId' AND  leido = '0' LIMIT 1;";
		$rs = mysqli_query($this->nCon,$sql) or die ("error al seleccionar un otros");
		while($row=mysqli_fetch_array($rs)){
			$sql0 ="UPDATE otros SET leido = '1' WHERE id_otro ='$unId' LIMIT 1;";
			mysqli_query($this->nCon,$sql0) or die ("error al actualizar otros");			
			$leido = true;
			}
		return $leido;
	}
	public function seleccionar_otros_leido($unEstado){

		$sql ="SELECT * FROM otros WHERE leido='$unEstado'  AND estado = 'Envio'  ORDER BY id_otro DESC";
		$rs = mysqli_query($this->nCon,$sql) or die ("error al seleccionar otros leido");

		return $rs;
	}

}
?>
