<?
class datos_Cliente{

var $nCon_Andres;	
var $nCon_Heliux;	

var $idCliente;

var $codigo;
var $clave;

var $rsocial;
var $nombre;
var $telefono;
var $email;
var $ruc;

	function datos_Cliente(){
					
	}
		
	/*
	public function nombreCliente($cual){
			$this->nCon_Andres = conectarDB_Andres();			
			$sql2 = "SELECT * FROM cliente WHERE idCliente = '$cual'";
			$rs2 = mysqli_query($sql2,$this->nCon_Andres) or die("Base_A_Ha ocurrido un error en Cliente->nombreCliente()");		
			while($row2 = mysqli_fetch_array($rs2)){	
				$this->idCliente=$row2["idCliente"];			
				$this->rsocial=$row2["rsocial"];			
				$this->nombre=$row2["nombre"];
				$this->telefono=$row2["telefono"];
				$this->email=$row2["correo"];
				$this->ruc=$row2["ruc"];
				$nom = $row2["rsocial"];
				}				
		return $rs2;
		desconectarDB_andres($this->nCon_Andres);
	}*/
	
		public function nombreCliente($cual){
			$this->nCon_Andres = conectarDB_Andres();			
			$sql2 = "SELECT * FROM cliente WHERE idCliente = '$cual'";
			$rs2 = mysqli_query($this->nCon_Andres,$sql2) or die("Base_A_Ha ocurrido un error en Cliente->nombreCliente()");		
			while($row2 = mysqli_fetch_array($rs2)){						
					$nom = $row2["rsocial"];
				}				
			return $nom;		
		desconectarDB_andres($this->nCon_Andres);
	}
	
					
}				
?>