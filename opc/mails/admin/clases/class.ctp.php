<?
class datos_ctp{

var $nCon;	
var $nCon_Andres;	
var $nCon_Nos;	

var $id_ctf;
var $referencia;
var $formato_ancho;
var $formato_alto ;
var $cantidad;
var $forma_de_pago;
var $calibre;
var $entrega_archivo;
var $armado_pliego;
var $observaciones;
var $tintas;
var $pinza;
var $lineatura;
var $sobreimpresion;
var $trapping;
var $horneado;
var $promocion;
var $estado;

var $num_sess;
var $num_ip;
var $fecha;

var $idCLiente;

function datos_ctp(){
		$this->nCon = conectarDB_Nuestra();	
	}

function alta_ctp($referencia, $formato_ancho, $formato_alto, $cantidad, $forma_de_pago, $calibre, $entrega_archivo, $armado_pliego, $observaciones, $tintas, $pinza, $lineatura, $sobreimpresion, $trapping, $horneado, $promocion, $estado, $num_sess, $num_ip, $fecha, $idCLiente){
	if ($horneado=="No") {
		$horneado_01=0;
		$tiraje="";
	} else if ($horneado!="") {
		$horneado_01=1;
		$tiraje=$horneado;
	}
	$sql ="INSERT INTO ctp (referencia, formato_ancho, formato_alto, cantidad, forma_de_pago, calibre, entrega_archivo, armado_pliego, observaciones, tintas, pinza, lineatura, sobreimpresion, trapping, horneado,tiraje, promocion, estado, num_sess,  num_ip, fecha, idCLiente) 
VALUES ('$referencia', '$formato_ancho', '$formato_alto', '$cantidad', '$forma_de_pago', '$calibre', '$entrega_archivo', '$armado_pliego', '$observaciones', '$tintas', '$pinza', '$lineatura', '$sobreimpresion', '$trapping', '$horneado_01', '$tiraje','$promocion', '$estado', '$num_sess', '$num_ip', NOW(), '$idCLiente');";
echo $sql;

	mysqli_query($this->nCon,$sql);
	$_SESSION["ultimoID"]= mysqli_insert_id();
}


	public function seleccionar_un_ctp($unId){
		
		$sql ="SELECT * FROM ctp WHERE id_ctp='$unId' LIMIT 1;";
		$rs = mysqli_query($this->nCon,$sql) or die ("error al seleccionar un ctp");	
		
		return $rs;
	}
	public function actualizar_un_ctp($unId){
		$leido = false;
		$sql = "SELECT * FROM ctp WHERE id_ctp='$unId' AND  leido = '0' LIMIT 1;";
		$rs = mysqli_query($this->nCon,$sql) or die ("error al seleccionar un ctp");
		while($row=mysqli_fetch_array($rs)){
			$sql0 ="UPDATE ctp SET leido = '1' WHERE id_ctp ='$unId' LIMIT 1;";
			mysqli_query($this->nCon,$sql0) or die ("error al actualizar ctp");
			$leido = true;
		}
		return $leido;
	}
	public function seleccionar_ctp_leido($unEstado){
		
		$sql ="SELECT * FROM ctp WHERE leido='$unEstado'   AND estado = 'Envio'  ORDER BY id_ctp DESC";
		$rs = mysqli_query($this->nCon,$sql) or die ("error al seleccionar ctp leido");
		
		return $rs;
	}

}
?>
