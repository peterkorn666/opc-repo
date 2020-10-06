<?php
//session_start();
class core{
	public function __construct(){
		/*if(empty($_SESSION['cliente']['id_cliente']))
		{
			\Redirect::to("../../cuenta/login.php");
			die();
		}*/
		$this->db = DB::getInstance();//conectaDb();
	}
	
	public function getConfig(){
		return $this->db->get("config")->first();
	}
	
	public function getSalas(){
		if($_SESSION["abstract"]["registrado"]==true){
			$visibleD = "";
		}else{
			$visibleD = " WHERE visible=1";
		}
		$select = $this->db->prepare("SELECT * FROM salas $visibleD  ORDER BY Sala_orden ASC");
		$select->execute();
		return $select;
	}
	
	public function getHoras(){
		$select = $this->db->prepare("SELECT * FROM horas ORDER BY Hora ASC");
		$select->execute();
		return $select;
	}
	
	public function getEstadisticas(){
		return $this->db->get("estadisticas")->results();
	}
	
	public function insertarBd($tabla,$camposValores){
		//$camposValores es del tipo array("nombredelcampo1"=>"valor1","nombredelcampo2"=>"valor2")
		
		$resultado=false;
		if (is_array($camposValores)) {
			$campos="";
			$valores="";
			$i = 1;
			foreach($camposValores as $campo=>$valor) { // recorre el array de parametros y arma la consulta
				if ($campos!="") {
					$campos.=",";
				}
				$campos.=$campo;
				
				if ($valores!="") {
					$valores.=",";
					$signos.=",";
				}
				$valores.=$valor;
				$signos .= "?";
			}
			
			$sql=$this->db->prepare("INSERT INTO $tabla ($campos) VALUES ($signos)");
			
			foreach($camposValores as $campo=>$valor) { // recorre el array de parametros y arma la consulta
				if ($valores!="") {
					$valores.=",";
				}
				$valores.=$valor;
				
				$sql->bindValue($i,$valor);
				$i++;
			}
 
			if($sql->execute()){
				$result = true;
			}else{
				var_dump($sql->errorInfo());
				die();
			}
		
		}	
		
		//return $sql->errorInfo();
	//	return $sql->debugDumpParams();
		return array("result"=>$result,"lastID"=>$this->db->lastInsertId());
	}
	
	public function eliminarConferencistasCasillero($id_casillero){
		$select = $this->db->prepare("DELETE FROM congreso_conferencistas WHERE id_congreso=?");
		$select->bindValue(1,$id_casillero);
		$select->execute();
			//return $select->errorInfo();
		return $select;
	}
	
	public function validarUsuario($user,$clave){
		$select = $this->db->prepare("SELECT * FROM claves WHERE eliminado=0 AND usuario=? AND clave=?");
		$select->bindValue(1,$user);
		$select->bindValue(2,$clave);
		$select->execute();
			//return $select->errorInfo();
		return $select;
	}
	
	public function getPrimerDia(){
		$select = $this->db->prepare("SELECT * FROM congreso ORDER BY Dia_orden ASC LIMIT 0,1");
		$select->execute();
			//return $select->errorInfo();
		return $select;
	}
	
	public function getDiaByOrden($dia){
		$select = $this->db->prepare("SELECT * FROM dias WHERE Dia_orden=?");
		$select->bindValue(1,$dia);
		$select->execute();
			//return $select->errorInfo();
		return $select;
	}
	
	public function getDiaNameByOrden($dia){
		$select = $this->db->prepare("SELECT * FROM dias WHERE Dia=?");
		$select->bindValue(1,$dia);
		$select->execute();
			//return $select->errorInfo();
		return $select;
	}
	
	public function getDiasDistintosCongreso(){
		$select = $this->db->prepare("SELECT DISTINCT Dia, Dia_orden FROM congreso ORDER by Dia_orden ASC");
		$select->execute();
			//return $select->errorInfo();
		return $select;		
	}
	
	public function getSalasDistintosCongreso($dia){
		$select = $this->db->prepare("SELECT DISTINCT Sala_orden FROM congreso WHERE Dia_orden=?  ORDER BY Sala_orden");
		$select->bindValue(1,$dia);
		$select->execute();
			//return $select->errorInfo();
		return $select;		
	}
	
	public function getDiaSalasDistintosCongreso($dia,$sala){
		$select = $this->db->prepare("SELECT DISTINCT Sala_orden FROM congreso where Sala_orden=? and Dia_orden=?");
		$select->bindValue(1,$sala);
		$select->bindValue(2,$dia);
		$select->execute();
			//return $select->errorInfo();
		return $select;		
	}
	
	public function getSalasNameDistintosCongreso($sala){
		$select = $this->db->prepare("SELECT DISTINCT Sala FROM salas where ID_Salas=?");
		$select->bindValue(1,$sala);
		$select->execute();
			//return $select->errorInfo();
		return $select;		
	}
	
	public function getByDiaSalaOrden($dia,$sala,$orden){
		$select = $this->db->prepare("SELECT * FROM congreso where Sala_orden=? and Dia_orden =? $orden");
		$select->bindValue(1,$sala);
		$select->bindValue(2,$dia);
		
		$select->execute();
			//return $select->errorInfo();
		return $select;		
	}
	
	public function getCongresoByDia($orden){
		$select = $this->db->prepare("SELECT Hora_inicio FROM congreso $orden");
		$select->execute();
			//return $select->errorInfo();
		return $select;	
	}
	
	public function getRecuadrosByDiaSala($dia,$sala,$orden){
		$select = $this->db->prepare("SELECT * FROM recuadros where Sala_orden=? and Dia_orden=? $orden");
		$select->bindValue(1,$sala);
		$select->bindValue(2,$dia);
		$select->execute();
			//return $select->errorInfo();
		return $select;	
	}
	
	public function getTipoActividad(){
		$select = $this->db->prepare("SELECT * FROM tipo_de_actividad ORDER BY Tipo_de_actividad");
		$select->execute();
			//return $select->errorInfo();
		return $select;	
	}
	
	public function getTipoActividadBy($tipo_actividad){
		$select = $this->db->prepare("SELECT * FROM tipo_de_actividad WHERE ID_Tipo_de_actividad =?");
		$select->bindValue(1,$tipo_actividad);
		$select->execute();
		$return = $select->fetch();
			//return $select->errorInfo();
		return $return;	
	}
	
	public function tipo_actividadRandom($id){
		$rand = rand(1,33);
		$select = $this->db->prepare("UPDATE congreso SET Tipo_de_actividad=$rand WHERE ID=?");
		$select->bindValue(1,$id);

		$select->execute();

			//return $select->errorInfo();


	}
	
	public function getCongreso($casillero,$where){
		$select = $this->db->prepare("SELECT * FROM congreso WHERE Casillero=? $where");
		$select->bindValue(1,$casillero);
		$select->execute();
			//return $select->errorInfo();
		return $select;
	}
	
	public function getCongresoByID($id){
		$select = $this->db->prepare("SELECT * FROM congreso WHERE ID=?");
		$select->bindValue(1,$id);
		$select->execute();
			//return $select->errorInfo();
		return $select;
	}
	
	public function getConferencistasByIDCasillero($id_congreso){
		$select = $this->db->prepare("SELECT * FROM congreso_conferencistas as c JOIN personas as p ON c.id_persona=p.ID_Personas WHERE id_congreso=? ORDER BY c.orden_conferencista");
		$select->bindValue(1,$id_congreso);
		$select->execute();
			//return $select->errorInfo();
		return $select;
	}
	
	public function getTrabajosLibresByCasilleroAndTL($casillero){
		$select = $this->db->prepare("SELECT Trabajo_libre FROM congreso WHERE Casillero ='$casillero' and Trabajo_libre=1");
		$select->bindValue(1,$casillero);
		$select->execute();
			//return $select->errorInfo();
		return $select;
	}
	
	public function getTrabajosLibresByCasillero($casillero){
		$select = $this->db->prepare("SELECT * FROM trabajos_libres WHERE ID_casillero ='$casillero' ORDER BY numero_tl;");
		$select->bindValue(1,$casillero);
		$select->execute();
			//return $select->errorInfo();
		return $select;
	}
	
	public function getAutoresTL($id){
		$select = $this->db->prepare("SELECT * FROM trabajos_libres_participantes as t JOIN personas_trabajos_libres as p ON t.ID_participante=p.ID_Personas WHERE t.ID_trabajos_libres=? AND t.lee=1");
		$select->bindValue(1,$id);
		$select->execute();
			//return $select->errorInfo();
		return $select;
	}
	
	
	public function getConferencistasByApellido($apellido){
		$select = $this->db->prepare("SELECT * FROM personas where apellido like ? ORDER by  apellido,nombre ASC");
		$select->bindValue(1,$apellido."%");
		$select->execute();
			//return $select->errorInfo();
		return $select;
	}
	
	
	public function getDistinctSalaOrdenByDia($dia){
		$select = $this->db->prepare("SELECT DISTINCT Sala, Sala_orden FROM congreso where Dia_orden =? ORDER by Sala_orden ASC");
		$select->bindValue(1,$dia);
		$select->execute();
			//return $select->errorInfo();
		return $select;
	}
	public function getDistinctSalaOrdenDByDia($dia){
		$select = $this->db->prepare("SELECT DISTINCT Sala, Sala_orden FROM congreso where Dia_orden =? ORDER by Sala_orden DESC");
		$select->bindValue(1,$dia);
		$select->execute();
			//return $select->errorInfo();
		return $select;
	}
		
	public function getSalaBySala($sala){
		$select = $this->db->prepare("SELECT * FROM salas WHERE Sala=?");
		$select->bindValue(1,$sala);
		$select->execute();
			//return $select->errorInfo();
		return $select;
	}
	
	public function getCasilleroProgramaExtendido($sql){
		$select = $this->db->prepare($sql);
		$select->execute();
			//return $select->errorInfo();
		return $select;
	}
	
	public function getConferencistasCongresoByCasillero($id_casillero){
		$select = $this->db->prepare("SELECT * FROM congreso_conferencistas WHERE id_congreso=? ORDER BY orden_conferencista");
		$select->bindValue(1,$id_casillero);
		$select->execute();
			//return $select->errorInfo();
		return $select;
	}
	
	public function getPersonaByID($id){
		$select = $this->db->prepare("SELECT * FROM personas WHERE ID_Personas =?");
		$select->bindValue(1,$id);
		$select->execute();
			//return $select->errorInfo();
		return $select;
	}
	
	public function getPersonaInscriptoByID($id){
		$select = $this->db->prepare("SELECT inscripto FROM personas Where ID_Personas =? Limit 1");
		$select->bindValue(1,$id);
		$select->execute();
			//return $select->errorInfo();
		return $select;
	}
	
	public function getActividadesByPersonaIdByCasillero($id,$casillero){
		$select = $this->db->prepare("SELECT * FROM actividades WHERE idPersonaNueva=? AND Casillero=?");
		$select->bindValue(1,$id);
		$select->bindValue(2,$casillero);
		$select->execute();
			//return $select->errorInfo();
		return $select;
	}
	
	public function getDistinctDiaCongreso(){
		$select = $this->db->prepare("SELECT DISTINCT Dia FROM congreso ORDER by Dia_orden ASC");
		$select->execute();
			//return $select->errorInfo();
		return $select;
	}
	
	public function getLeeTL($id){
		$select = $this->db->prepare("SELECT ID_participante, lee FROM trabajos_libres_participantes WHERE ID_trabajos_libres =? ORDER BY ID ASC");
		$select->bindValue(1,$id);
		$select->execute();
			//return $select->errorInfo();
		return $select;
		
	}
	
	public function getPersonasTLByID($id){
		$select = $this->db->prepare("SELECT * FROM personas_trabajos_libres WHERE ID_Personas=?");
		$select->bindValue(1,$id);
		$select->execute();
			//return $select->errorInfo();
		return $select;
		
	}
	
	public function getSalaByOrden($dia){
		$select = $this->db->prepare("SELECT Sala FROM congreso where Dia_orden=? order by Sala_orden Desc;");
		$select->bindValue(1,$dia);
		$select->execute();
			//return $select->errorInfo();
		return $select;
		
	}
	
	public function getCasilleroVoid(){
		$select = $this->db->prepare("SELECT * FROM congreso where Hora_inicio='00:00:00'");
		$select->execute();
			//return $select->errorInfo();
		return $select;
	}
	
	public function getConferencistasByApellidos($apellido){
		$select = $this->db->prepare("SELECT * FROM personas WHERE apellido LIKE ?");
		$select->bindValue(1,"%".$apellido."%");
		$select->execute();
			///return $select->errorInfo();
		return $select;
	}
	
	public function getConferencistasByID($id){
		$select = $this->db->prepare("SELECT * FROM personas WHERE ID_Personas=?");
		$select->bindValue(1,$id);
		$select->execute();
			///return $select->errorInfo();
		return $select;
	}
	
	public function getRoles(){
		$select = $this->db->prepare("SELECT * FROM en_calidades");
		$select->execute();
			///return $select->errorInfo();
		return $select;
	}
	public function getRolesConferencistas(){
		return $this->db->query("SELECT * FROM calidades_conferencistas ORDER BY calidad")->results();
	}
	public function getRolConferencistaByID($id_rol){
		$row = $this->db->get("calidades_conferencistas", ['ID_calidad','=',$id_rol])->first();
		return $row;
	}
	
	
	public function getRolesByID($id){
		$select = $this->db->prepare("SELECT * FROM en_calidades WHERE ID_En_calidad=?");
		$select->bindValue(1,$id);
		$select->execute();
		//$select->fetch();
			//return $select->errorInfo();
		return $select;
	}
	
	public function getAreas(){
		$select = $this->db->prepare("SELECT * FROM areas");
		$select->execute() or die($select->errorInfo());
			///return ;
		return $select;
	}
	
	public function getAreasTL(){
		return $this->db->query("SELECT * FROM areas_trabjos_libres ORDER BY orden, id")->results();
	}
	
	public function getAreasIdTL($id){
		$lang = $this->getCurrentLang();
		$row = $this->db->get("areas_trabjos_libres", ["id","=",$id])->first();
		return $row["Area_".$lang];
	}
	
	public function getTematicasTL($area_id = 1){
		//$row = $this->db->get("trabajos_libres_tematicas", ["area_id","=",$area_id])->results();
		$row = $this->db->query("SELECT * FROM trabajos_libres_tematicas WHERE area_id = ? ORDER BY id", array($area_id))->results();
		return $row;
		//return $this->db->query("SELECT * FROM trabajos_libres_tematicas ORDER BY id")->results();
	}
	
	public function getTematicaTLByID($id_tematica){
		$row = $this->db->get("trabajos_libres_tematicas", ["id","=",$id_tematica])->first();
		return $row["nombre"];
	}
	
	public function randomString($length = 5){
		$pattern = "123456789123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$pass = '';
		for($i=0;$i<$length;$i++){
			$pass .= $pattern{rand(0,35)};
		}
		return $pass;	
	}
	
	public function getPais(){
		return $this->db->query("SELECT * FROM paises ORDER BY orden_pais")->results();
	}
	
	public function getPaisID($pais){
		$row = $this->db->get("paises", ['ID_Paises','=',$pais])->first();
		return $row["Pais"];
	}
	
	public function getTipoTL($filter=array())
	{
		$filtro = "";
		if ($filter != array()){
			$filtro.= "(";
			foreach($filter as $f){
				$filtro.= $f.",";
			}
			$filtro = substr($filtro,0,-1);
			$filtro.= ")";
			$filtro = "WHERE id IN ".$filtro;
		}
		return $this->db->query("SELECT * FROM tipo_de_trabajos_libres $filtro ORDER BY id")->results();
	}
	
	/*public function getTipoTL()
	{
		return $this->db->query("SELECT * FROM tipo_de_trabajos_libres ORDER BY id")->results();
	}*/
	
	public function getTipoTLID($id)
	{
		$row = $this->db->get("tipo_de_trabajos_libres", ['id','=',$id])->first();
		return $row["tipoTL_".$this->getCurrentLang()];
	}
	
	public function getModalidades()
	{
		return $this->db->query("SELECT * FROM trabajos_libres_modalidades ORDER BY orden, id")->results();
	}
	
	public function getModalidadID($id)
	{
		$row = $this->db->get("trabajos_libres_modalidades", ['id','=',$id])->first();
		return $row["modalidad_".$this->getCurrentLang()];
	}

    public function getTipoConversatorioByID($id_tipo_conversatorio){
        $row = $this->db->get("trabajos_libres_conversatorios_tipos", ['id_tipo_conversatorio','=',$id_tipo_conversatorio])->first();
        return $row["descripcion_tipo_conversatorio_".$this->getCurrentLang()];
        return $this->db->get("trabajos_libres_conversatorios_tipos", ["id_tipo_conversatorio","=",$id_tipo_conversatorio])->first();
    }
	
	public function getCurrentLang()
	{
		return $_SESSION["abstract"]["lang"];
	}
	
	public function asignarTrabajos($numero_tl)
	{
		$select = $this->db->prepare("SELECT * FROM evaluadores WHERE id<>1 ORDER BY id");
		$select->execute() or die($select->errorInfo());
		while($row = $select->fetch())
		{
			$insert = $this->db->prepare("INSERT INTO evaluaciones (idEvaluador,numero_tl,fecha,fecha_asignado) VALUES (?,?,?,?)");
			$insert->bindValue(1,$row["id"]);
			$insert->bindValue(2,$numero_tl);
			$insert->bindValue(3,date("Y-m-d"));
			$insert->bindValue(4,date("Y-m-d"));
			$insert->execute();
		}
	}
	
	public function getCuantosEjemplares($id){
		switch($id){
			case 1:
				return "entre 1 y 20";
				
			case 2:
				return "entre 21 y 50";
				
			case 3:
				return "entre 51 y 80";
				
			case 4:
				return "más de 80";
				
			default:
				return "";
		}
	}

    public function getPalabrasClave()
    {
        return $this->db->query("SELECT * FROM trabajos_libres_palabras_clave ORDER BY orden")->results();
    }
    public function getPalabraClaveByID($id){
        return $this->db->get("trabajos_libres_palabras_clave", ['id_palabra_clave','=',$id])->first();
	}
	
	public function getLineasTransversales()
	{
		return $this->db->query("SELECT * FROM trabajos_libres_lineas_transversales ORDER BY orden, id")->results();
	}
	public function getLineaTransversalByID($id_linea_transversal){
		return $this->db->get("trabajos_libres_lineas_transversales", ['id', '=', $id_linea_transversal])->first();
	}
}
?>