<?
class conferencistas_congreso{
var $nCon;
	function conferencistas_congreso(){
		$this->nCon = conectarDB();
	}	
	function seleccionar_conferencistas_del_filtrado($arrayIDS){
			foreach($arrayIDS as $i){
				$sql1 = "SELECT * FROM personas WHERE ID_Personas = '$i' AND Mail <> ''";
				$rs1 = mysql_query($sql1,$this->nCon) or die("Ha ocurrido un error en Mail");
				while($row1 = mysql_fetch_array($rs1)){				
						$filtro .= " ID_Personas = $i OR ";				
				}
			}
			$largo = strlen($filtro) - 3;
			$filtro = substr($filtro, 0, $largo);
			
			$sql = "SELECT * FROM personas WHERE $filtro ORDER BY ID_Personas ASC";
			$rs = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error en seleccionar_conferencistas_del_filtrado");
			return $rs;
	}
	
	function seleccionar_evaluadores_del_filtrado($arrayIDS){
			foreach($arrayIDS as $i){
				$sql1 = "SELECT * FROM evaluadores WHERE id = '$i' AND mail <> ''";
				$rs1 = mysql_query($sql1,$this->nCon) or die("Ha ocurrido un error en Mail");
				while($row1 = mysql_fetch_array($rs1)){				
						$filtro .= " id = $i OR ";				
				}
			}
			$largo = strlen($filtro) - 3;
			$filtro = substr($filtro, 0, $largo);
			
			$sql = "SELECT * FROM evaluadores WHERE $filtro ORDER BY id ASC";
			$rs = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error en seleccionar_conferencistas_del_filtrado ".mysql_error());
			return $rs;
	}
}
?>