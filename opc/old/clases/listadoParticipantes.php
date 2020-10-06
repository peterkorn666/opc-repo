<?
class listadoPersonas{

	var $canPersonas;
	var $canPersonasTL;
	var $nCon;

	/*Arrays*/
	function listadoPersonas(){
		$this->nCon = conectarDB();
	}


	function personasCongreso($fil){


		if($fil!="Todos"){
			$filto = " congreso.Apellidos LIKE '$fil%' and ";
		}else{
			$filto = "";
		}
////PARA EL FILTRO
		$sql = "SELECT Distinct congreso.ID_persona, personas.* FROM congreso,personas
				WHERE $filto congreso.ID_persona<>0 and  congreso.ID_persona = personas.ID_Personas ORDER by personas.apellido ASC";
		//$rs = mysql_query($sql,$this->nCon);
		//$this->canPersonas= mysql_num_rows($rs);
		$rs = $this->nCon->query($sql);
		$this->canPersonas = $rs->num_rows;

////PARA LA CANTIDAD TOTAL
		$sql1 = "SELECT Distinct congreso.ID_persona, personas.* FROM congreso,personas
				WHERE congreso.ID_persona<>0 and  congreso.ID_persona = personas.ID_Personas ORDER by personas.apellido ASC";
		//$rs1 = mysql_query($sql1,$this->nCon);
		//$this->canPersonasTOTAL= mysql_num_rows($rs1);
		$rs1 = $this->nCon->query($sql1);
		$this->canPersonasTOTAL = $rsq->num_rows;


		return $rs;
	}


	/*function personasCongresoConMail($inicio, $TAMANO_PAGINA){
		

		//$sql = "SELECT * FROM personas WHERE 1 ORDER by personas.Apellidos ASC LIMIT $inicio, $TAMANO_PAGINA";
		$sql = "SELECT Distinct congreso.ID_persona, personas.* FROM congreso,personas
				WHERE congreso.ID_persona<>0 and  congreso.ID_persona = personas.ID_Personas ORDER by personas.Apellidos ASC LIMIT $inicio, $TAMANO_PAGINA";
		$rs = mysql_query($sql,$this->nCon);
		$this->canPersonas= mysql_num_rows($rs);
		$sql2 = "SELECT Distinct congreso.ID_persona, personas.* FROM congreso,personas
				WHERE congreso.ID_persona<>0 and  congreso.ID_persona = personas.ID_Personas ORDER by personas.Apellidos ASC";
		$rs2 = mysql_query($sql2,$this->nCon);
		$this->canPersonasTOTAL= mysql_num_rows($rs2);
		return $rs;
	}*/

	function personasCongresoConMail($inicio, $tamano){
		$sql = "SELECT * FROM cronograma as c
				JOIN crono_conferencistas as cc ON c.id_crono=cc.id_crono
				JOIN conferencistas as f ON cc.id_conf=f.id_conf
			    WHERE f.email<>'' ORDER by f.apellido ASC";
		//$rs = mysql_query($sql,$this->nCon) or die(mysql_error());
		//$this->canPersonas= mysql_num_rows($rs);
		//$this->canPersonasTOTAL= mysql_num_rows($rs);
		$rs = $this->nCon->query($sql);
		if (!$rs){
			die($this->nCon->error);
		}
		$this->canPersonas = $rs->num_rows;
		$this->canPersonasTOTAL= $rs->num_rows;


		if($inicio!="" ){
			/////SI VIENE 0 LO TOMA COMO VACIO
			if($inicio==1){
				$inicio=0;
			}
			$inicio = " limit ". $inicio ." , " . $tamano;
		}else{
			$inicio="";
		}

		$sql .= " $inicio";

		//echo $sql;
		//exit();

		//$rs = mysql_query($sql,$this->nCon);
		$rs = $this->nCon->query($sql);
		return $rs;
	}

	function personasPorCasilleroConMail($casilleros){

		$rs=false;
		if (is_array($casilleros)) {
			$cas = "";
			foreach ($casilleros as $c){
				$cas .= "congreso.Casillero ='".$c."' OR ";
			}
			if ($cas != ""){
				$cas = substr($cas,0, -4);
			}

			$sql = "SELECT Distinct congreso.ID_persona, personas.* FROM congreso,personas
					  WHERE congreso.ID_persona<>0 and (congreso.ID_persona = personas.ID_Personas) and (personas.Mail<>'') and (".$cas.") ORDER by personas.Apellidos ASC";
			//echo $sql;
			//exit();		  
			//$rs = mysql_query($sql,$this->nCon);
			//$this->canPersonas= mysql_num_rows($rs);
			//$this->canPersonasTOTAL= mysql_num_rows($rs);
			$rs = $this->nCon->query($sql);
			$this->canPersonas = $rs->num_rows;
			$this->canPersonasTOTAL= $rs->num_rows;
		}
		return $rs;
	}

	function personasInscriptasConMail(){
		$sql = "SELECT * FROM inscripciones_congreso WHERE mail <> '' ORDER BY apellido";
		//$rs = mysql_query($sql,$this->nCon) or die(mysql_error());
		//$this->canPersonas= mysql_num_rows($rs);
		//$this->canPersonasTOTAL= mysql_num_rows($rs);
		$rs = $this->nCon->query($sql);
		if (!$rs){
			die($this->nCon->error);
		}
		$this->canPersonas = $rs->num_rows;
		$this->canPersonasTOTAL= $rs->num_rows;
		return $rs;
	}
	function personasTL($fil){

		$arrayIDtl = array();

		$arrayIDPersonas = array();

		$sql = "SELECT Distinct ID_casillero,ID from trabajos_libres WHERE ID_casillero<>'0'";
		//$rs = mysql_query($sql,$this->nCon) or die(mysql_error());
		//$cantidadCasilleros = mysql_num_rows($rs);
		$rs = $this->nCon->query($sql);
		$cantidadCasilleros = $rs->num_row;
		/* $row = mysql_fetch_array($rs) */
		while ($row = $rs->fetch_array()){

			array_push($arrayIDtl, $row["ID"]);

		}



		if($cantidadCasilleros>0){

			$pos=0;
			$clausula = "WHERE ";

			foreach ($arrayIDtl as $i){
				if($pos>0){
					$clausula .= " OR ";
				}

				$clausula .= "ID_trabajos_libres=$i";
				$pos=$pos+1;

			}

			$sql2 = "SELECT ID_participante from trabajos_libres_participantes $clausula";
			//$rs2 = mysql_query($sql2,$this->nCon) or die(mysql_error());
			//$cantidadPersonas = mysql_num_rows($rs2);
			$rs2 = $this->nCon->query($sql2);
			$cantidadPersonas = $rs2->num_row;
			/* $row2 = mysql_fetch_array($rs2) */
			while ($row2 = $rs2->fetch_array()){
				array_push($arrayIDPersonas, $row2["ID_participante"]);
			}


			$arrayIDPersonas = array_unique($arrayIDPersonas);
		}




		$this->canPersonasTL=0;
		if($cantidadPersonas>0){
			$pos=0;

			if($fil!="Todos"){
				$filto = "  Apellidos LIKE '$fil%' and ";
			}else{
				$filto = "";
			}

			$clausula = "WHERE $filto (";



			foreach ($arrayIDPersonas as $u){

				if($pos>0){
					$clausula .= " OR ";
				}

				$clausula .= "ID_Personas=$u";
				$pos=$pos+1;
			}

			$clausula .= ")";





			$sql3 = "SELECT * from personas_trabajos_libres $clausula ORDER by Apellidos ASC";
			//$rs3 = mysql_query($sql3,$this->nCon) or die(mysql_error());
			//$this->canPersonasTL = mysql_num_rows($rs3);
			$rs3 = $this->nCon->query($sql3);
			if(!$rs3){
				die($this->nCon->error);
			}
			$this->canPersonasTL = $rs3->num_row;
///TOTAL EN TRABAJOS LIBRES
			$sql4 = "SELECT DISTINCT (ID_Personas) FROM personas_trabajos_libres as ptl, trabajos_libres_participantes as tlp, trabajos_libres as tl WHERE ptl.ID_Personas  = tlp.ID_participante";
			//$rs4 = mysql_query($sql4,$this->nCon);
			//$this->canPersonasTLTOTAL = mysql_num_rows($rs4);
			$rs4 = $this->nCon->query($sql4);
			if(!$rs4){
				die($this->nCon->error);
			}
			$this->canPersonasTLTOTAL = $rs4->num_row;

		}

		return $rs3;

	}





	function trabajosQueTieneLaPersona($cual){

		$arrayNumerosTL = array();
		$sql = "SELECT ID_trabajos_libres FROM trabajos_libres_participantes WHERE ID_participante = $cual";
		//$rs = mysql_query($sql,$this->nCon);
		$rs = $this->nCon->query($sql);
		/* $row = mysql_fetch_array($rs) */
		while ($row = $rs->fetch_array()){

			$sql2 = "SELECT numero_tl FROM trabajos_libres WHERE ID = " . $row["ID_trabajos_libres"];
			//$rs2 = mysql_query($sql2,$this->nCon);
			$rs2 = $this->nCon->query($sql2);
			/* $row2 = mysql_fetch_array($rs2) */
			while ($row2 = $rs2->fetch_array()){

				array_push($arrayNumerosTL , $row2["numero_tl"]);

			}

		}

		return  $arrayNumerosTL;

	}

	function buscarSiLee($idPersona, $numTrabajo){
		$sql1 = "SELECT * FROM trabajos_libres WHERE numero_tl = '$numTrabajo'";
		//$rs1 =  mysql_query($sql1,$this->nCon);
		$rs1 = $this->nCon->query($sql1);
		/* $row2 = mysql_fetch_array($rs1) */
		while ($rs1->fetch_array()){
			$idTrabajo = $row2["ID"];

			$sql = "SELECT * FROM trabajos_libres_participantes WHERE ID_participante = $idPersona AND ID_trabajos_libres = $idTrabajo";
			//$rs = mysql_query($sql,$this->nCon);
			$rs = $this->nCon->query($sql);
			if (!$rs){
				die($this->nCon->error);
			}
			/* $row = mysql_fetch_array($rs) */
			while ($row = $rs->fetch_array()){
				if ($row["lee"] == '0'){
					$lee = 0;
				}else{
					$lee = 1;
				}
			}
		}
		return $lee;
	}





}
?>