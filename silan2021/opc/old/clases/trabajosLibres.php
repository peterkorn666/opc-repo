<?
class trabajosLibre{

	var $nCon;
	var $ordenTL;

	function trabajosLibre(){
		$this->nCon = conectarDB();
		$this->setOrdenTL();
	}


	function setOrdenTL(){


		$sql = "SELECT ordenTL FROM config limit 1;";
		$rs = $this->nCon->query($sql);
		while ($row = $rs->fetch_array()){

			if($row["ordenTL"]==0){

				$this->ordenTL = " numero_tl ";

			}


			if($row["ordenTL"]==1){

				$this->ordenTL = " Hora_inicio ";

			}


		}


	}

	function horas(){

		$sql = "SELECT * FROM horas ORDER by Hora ASC";
		$rs = $this->nCon->query($sql);
		return $rs;
	}

	function areas(){
		$sql = "SELECT * FROM areas_trabjos_libres ORDER by orden ASC";
		//$result = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error. ".mysql_error());
		$result = $this->nCon->query($sql);
		if (!$result){
			die("Ha ocurrido un error. ".$this->nCon->error);
		}
		return $result;
	}

	function tipoTL(){
		$sql = "SELECT * FROM tipo_de_trabajos_libres ORDER by id ASC";
		//$result = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error. ".mysql_error());
		$result = $this->nCon->query($sql);
		if (!$result){
			die("Ha ocurrido un error. ".$this->nCon->error);
		}
		return $result;
	}
	
	function tipoTLID($id){
		$sql = "SELECT * FROM tipo_de_trabajos_libres WHERE id='$id'";
		//$result = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error. ".mysql_error());
		//$row = mysql_fetch_array($result);
		$result = $this->nCon->query($sql);
		if (!$result){
			die("Ha ocurrido un error. ".$this->nCon->error);
		}
		$row = $result->fetch_array();
		return $row;
	}
	
	function areaID($id){
		$sql = "SELECT * FROM areas_trabjos_libres WHERE id='$id'";
		//$mysql = mysql_query($sql,$this->nCon) or die(mysql_error());
		$mysql = $this->nCon->query($sql);
		$result = $mysql->fetch_object();
		return $result;
	}
	
	function institucionID($id){
		$sql = "SELECT * FROM instituciones WHERE ID_Instituciones='$id'";
		$result = $this->nCon->query($sql);
		if (!$result){
			die("Ha ocurrido un error. ".$this->nCon->error);
		}
		$row = $result->fetch_array();
		return $row;
	}
	
	function getIdiomaID($id){
		$sql = "SELECT * FROM tl_idiomas WHERE id='$id'";
		$mysql = $this->nCon->query($sql);
		$result = $mysql->fetch_array();
		return $result;
	}
	
	function getTipoActividad($id)
	{
		$sql = "SELECT * FROM tipo_de_actividad WHERE id_tipo_actividad='$id'";
		//$mysql = mysql_query($sql,$this->nCon);
		$mysql = $this->nCon->query($sql);
		$result = $mysql->fetch_array();
		return $result;
	}
	
	function areaName($name){
		$sql = "SELECT * FROM areas_trabjos_libres WHERE Area='$name' ORDER BY orden ASC";
		//$mysql = mysql_query($sql,$this->nCon);
		$mysql = $this->nCon->query($sql);
		$result = $mysql->fetch_object();
		return $result;
	}



	function cantidadInscriptoTL_estado($cual){
		$sql = "SELECT * FROM trabajos_libres where estado = $cual;";
		//$result = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error. ".mysql_error());
		$result = $this->nCon->query($sql);
		if (!$result){
			die("Ha ocurrido un error. ".$this->nCon->error);
		}
		$cantidad = $result->num_row;
		return $cantidad;
	}



function selectTL_estado($cual, $ubi, $congreso, $are, $tip, $cla, $ins,$premio,$quePremio,$idioma, $adjunto, $adjunto_poster, $adjunto_oral, $inicio, $TAMANO_PAGINA,$eliminado,$dropbox){
//	function selectTL_estado($cual, $ubi, $are, $tip, $cla, $ins){

		if($premio==""){
			$premio="";
		}
		if($cual == "cualquier"){

			$filtro = "where estado like '%%' ";

		}else{
			$filtro = "where estado = $cual";
		}
		
		if(($eliminado=="") || ($eliminado==0)){
			$filtro .= "";
		}else{
			$filtro .= " AND eliminado=1";
		}
		
		if($dropbox!=""){
			$filtro .= " AND dropbox=$dropbox";
		}
		
		
		
		//inscripto = '$ins'
			

		if($cla!=""){

			$arrayBusquedaClave= @split(" ",  $cla);


			/****************************/
			
			$sql2 =  "SELECT ID_Personas FROM personas_trabajos_libres WHERE ";
			
			$bucle2 = 0;
			$arrayPersonasTL = array();
			foreach ($arrayBusquedaClave as $u){

				if($bucle2>0){
					$sql2 .= " or (";
				}else{
					$sql2 .= " (";
				}

				$sql2 .= "    Profesion like '%$u%' ";
				$sql2 .= " or Nombre like '%$u%' ";
				$sql2 .= " or Apellidos like '%$u%' ";
				$sql2 .= " or Pais like '%$u%' ";
				$sql2 .= " or Institucion like '%$u%' ";
				$sql2 .= " or Mail like '%$u%' ";							
				$sql2 .= " or Cargos like '%$u%')";

				$bucle2 = $bucle2 + 1;
			}


			//$rs2 = mysql_query($sql2,$this->nCon);
			//$canPersonasTL = mysql_num_rows($rs2);
			$rs2 = $this->nCon->query($sql2);
			$cantPersonasTL = $rs2->num_row;
			/* $row2 = mysql_fetch_array($rs2) */
			while ($row2 = $rs2->fetch_array()){
				array_push($arrayPersonasTL, $row2["ID_Personas"]);
			}


			$arrayParticipantesTL = array();
			/*Veo si existen estas personas en la tabla tl participantes*/
			if($canPersonasTL>0){

				$sql3 = "SELECT DISTINCT ID_trabajos_libres FROM trabajos_libres_participantes WHERE ";
				$bucle3 = 0;

				foreach ($arrayPersonasTL as $i){

					if($bucle3>0){
						$sql3 .= " OR ";
					}
				
					$sql3 .= " ID_participante=$i";
					$bucle3 = $bucle3 + 1;
				}

				//$rs3 = mysql_query($sql3,$this->nCon);
				//$canParticipantesTL = mysql_num_rows($rs3);
				$rs3 = $this->nCon->query($sql3);
				$canParticipantesTL = $rs3->num_row;
				/* $row3 = mysql_fetch_array($rs3) */
				while ($row3 = $rs3->fetch_array()){
					array_push($arrayParticipantesTL, $row3["ID_trabajos_libres"]);

				}

			}



			if($cual == "cualquier"){
				$filtroEstado = "where estado like '%%' ";

			}else{
				$filtroEstado = "where estado = $cual";
			}

			$arrayIDParticipantesTL = array();
			/*Si existen los participante tomo el ID*/
			if($canParticipantesTL>0){

				$sql4 = "SELECT ID FROM trabajos_libres $filtroEstado and (";
				$bucle4 = 0;
				foreach ($arrayParticipantesTL as $i){

					if($bucle4>0){
						$sql4 .= " OR ";
					}

					$sql4 .= " ID=$i";
					$bucle4 = $bucle4 + 1;

				}
				$sql4 .= ");";

				//$rs4 = mysql_query($sql4,$this->nCon);
				$rs4 = $this->nCon->query($sql4);
				/* $row4 = mysql_fetch_array($rs4) */
				while ($row4 = $rs4->fetch_array()){
					array_push($arrayIDParticipantesTL, $row4["ID"]);

				}

			}


			$arrayIDTL = array();
			$sql5 =  "SELECT id_trabajo FROM trabajos_libres $filtroEstado and ";
			$bucle5=0;
			foreach ($arrayBusquedaClave as $i){

				if($bucle5>0){
					$sql5 .= " OR (";
				}else{
					$sql5 .= " (";
				}


				$sql5 .= "    Hora_inicio like '%$i%' ";
				$sql5 .= " or Hora_fin like '%$i%' ";
				$sql5 .= " or numero_tl like '%$i%' ";
				$sql5 .= " or titulo_tl like '%$i%' ";
				$sql5 .= " or area_tl like '%$i%' ";
				$sql5 .= " or tipo_tl like '%$i%' ";
				$sql5 .= " or contacto_mail like '%$i%' ";
				$sql5 .= " or resumen like '%$i%' ";
				$sql5 .= " or idioma like '%$i%' ";
				$sql5 .= " or palabrasClave like '%$i%' )";

				$bucle5= $bucle5 + 1;

			}

			//$rs5 = mysql_query($sql5,$this->nCon) or die(mysql_error());
			$rs5 = $this->nCon->query($sql5);
			if(!$rs5){
				die($this->nCon->error);
			}
			/* $row5 = mysql_fetch_array($rs5) */
			while ($row5 = $rs5->fetch_array()){
				array_push($arrayIDTL, $row5["id_trabajo"]);
			}

			$unionArrays = array_merge($arrayIDParticipantesTL, $arrayIDTL);

			$unionArraysDistintos = array_unique($unionArrays);
			/***************************/


			$bucle6=0;
			if(count($unionArraysDistintos)>0){
				$filtro .= " and (";
				foreach ($unionArraysDistintos as $i){

					if($bucle6>0){
						$filtro .= " or id_trabajo ='$i'";

					}else{
						$filtro .= " id_trabajo ='$i'";
					}

					$bucle6 = $bucle6 + 1;
				}

				$filtro .= ") ";
			}else{
				$filtro .= " and id_trabajo=0  ";
			}


		}


		if($ubi!=""){
			$filtro .= " and ID_casillero='$ubi'";
		}

		if($are!=""){


			$filtro .= " and area_tl='$are'";

		}
		
		if($premio!=""){


			$filtro .= " and premio='$premio'";

		}
		if($quePremio!=""){


			$filtro .= " and cual_premio='$quePremio'";

		}
		
		if($idioma!=""){


			$filtro .= " and idioma='$idioma'";

		}
		
		if($adjunto=="Si"){
			$filtro .=" and archivo_tl<>''";
		}else if($adjunto=="No"){
			$filtro .=" and archivo_tl=''";
		}
		
		if($adjunto_poster=="Si"){
			$filtro .=" and poster_tl<>''";
		}else if($adjunto_poster=="No"){
			$filtro .=" and poster_tl=''";
		}
		
		if($adjunto_oral=="Si"){
			$filtro .=" and oral_tl<>''";
		}else if($adjunto_oral=="No"){
			$filtro .=" and oral_tl=''";
		}
		
		if($congreso!=""){
			$filtro .= " AND congreso='$congreso'";
		}	
		
			
		if($tip!=""){



			$filtro .= " and tipo_tl='$tip'";
		}


		if($inicio!="" ){
			/////SI VIENE 0 LO TOMA COMO VACIO
			if($inicio==1){
				$inicio=0;
			}
			
			$inicio = " limit ". $inicio ." , " . $TAMANO_PAGINA;
		}else{
			$inicio="";
		}
		
		$arrayPerTLs = array();
		$bucle7 = 0;
		

		
		$sql = "SELECT * FROM trabajos_libres $filtro order by $this->ordenTL ASC ". $inicio;
		//echo $sql;
		//$result = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error.1 ".mysql_error());		
		$result = $this->nCon->query($sql);
		if (!$result){
			die("Ha ocurrido un error.1 ".$this->nCon->error);
		}
		if($ins=="todos"){
			return $result;
			exit;
		}else{
			/* $row123 = mysql_fetch_array($result) */
			while ($row123 = $result->fetch_array()){
			
				$sql12 = "SELECT * FROM trabajos_libres_participantes  WHERE lee = 1 AND ID_trabajos_libres  = '" . $row123["ID"]."'";
				//$result2 = mysql_query($sql12,$this->nCon) or die(mysql_error());	
				$result2 = $this->nCon->query($sql12);
				if (!$result2){
					die($this->nCon->error);
				}
				/* $row12 = mysql_fetch_array($result2) */
				while ($row12 = $result->fetch_array()){								
					
					$sql1 = "SELECT * FROM personas_trabajos_libres  WHERE ID_Personas = '" . $row12["ID_participante"]."'  AND inscripto='".$ins."'";
					//$result1 = mysql_query($sql1,$this->nCon) or die("Ha ocurrido un error.3 ");		
					$result1 = $this->nCon->query($sql1);
					if (!$result1){
						die("Ha ocurrido un error.".$this->nCon->error);
					}
					//echo mysql_num_rows($result1);
					/* $row1 = mysql_fetch_array($result1) */
					while ($row1 = $result1->fetch_array()){
								if($trabajo_anterior!=$row12["ID_trabajos_libres"]){							
									if($bucle7>0){
										$filtro2 .= " or ID = '".$row12["ID_trabajos_libres"]."' ";
									}else{
										$filtro2 .= " ID ='".$row12["ID_trabajos_libres"]."' ";
									}								
									$trabajo_anterior = $row12["ID_trabajos_libres"];
									$bucle7 = $bucle7 + 1;
								}
					}
					$cons .= $sql1;
				}
						
			}		
		$sql333 = "SELECT * FROM trabajos_libres WHERE $filtro2 ORDER BY numero_tl ";
		//mysql_set_charset('utf8',$this->nCon);
		//var_dump($sql333);
		//$result333 = mysql_query($sql333,$this->nCon) or die("No se han encontrado coincidencias");
		$result333 = $this->nCon->query($sql333);
		if (!$result333){
			die("No se han encontrado coincidencias");
		}
		return $result333;
		
		}	
	}



	function selectTL_Casillero($cual, $soloMostrarce,$orden){

		$filtro="";
		if(count($soloMostrarce)>0){
			$filtro .= " and (";
			for($i=0; $i<count($soloMostrarce); $i++){

				if($i>0){
					$filtro .= " OR ";
				}

				$filtro .= " ID=". $soloMostrarce[$i] . " ";

			}
			$filtro .= ")";
		}
		
		if($orden=="1"){
			$orden_tl = "orden";
		}else{
			$orden_tl = $this->ordenTL;
		}


		$sql = "SELECT * FROM trabajos_libres WHERE ID_casillero = '$cual' $filtro order by $orden_tl ASC;";
		//$result = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error. ".mysql_error());
		$result = $this->nCon->query($sql);
		if(!$result){
			die("Ha ocurrido un error. ".$this->nCon->error);
		}

		return $result;

	}
	
	////***********para envio de mail********************
	function seleccionar_trabajos_libres_del_filtrado($arrayIDS){

		foreach($arrayIDS as $i){
			$sql1 = "SELECT * FROM trabajos_libres WHERE id_trabajo = '$i' AND contacto_mail <> ''";
			//$rs1 = mysql_query($sql1,$this->nCon) or die("Ha ocurrido un error en mailContacto_tl");
			$rs1 = $this->nCon->query($sql1);
			if(!$rs1){
				die("Ha ocurrido un error en mailContacto_tl");
			}
			/* $row1 = mysql_fetch_array($rs1) */
			while($row1 = $rs1->fetch_array()){				
					$filtro .= " id_trabajo = $i OR ";				
			}
		}
		$largo = strlen($filtro) - 3;
		$filtro = substr($filtro, 0, $largo);
		






		$sql = "SELECT * FROM trabajos_libres WHERE $filtro ORDER BY numero_tl";

		//$rs = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error en seleccionar_trabajos_libres_del_filtrado");	
		//$rs = mysql_query($sql,$this->nCon) or false;	
		$rs = $this->nCon->query($sql);		
		return $rs;
	}
	
	
	function seleccionar_trabajos_libres_que_tienen_mail_de_contacto(){

		$sql = "SELECT * FROM trabajos_libres WHERE contacto_mail<>'' ORDER BY numero_tl ASC;";
		//$rs = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error en seleccionar_trabajos_libres_que_tienen_mail_de_contacto");
		$rs = $this->nCon->query($sql);
		if(!$rs){
			die("Ha ocurrido un error en seleccionar_trabajos_libres_que_tienen_mail_de_contacto");
		}
		return $rs;
	}

	function seleccionar_tl_que_tienen_mail_de_contacto_son_oral_sin_archivoCompleto(){
		$sql = "SELECT * FROM trabajos_libres WHERE contacto_mail<>'' and id_crono<>'' and archivo_tl='' and tipo_tl='Oral' ORDER BY numero_tl ASC;";
		//$rs = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error en seleccionar_trabajos_libres_que_tienen_mail_de_contacto");
		$rs = $this->nCon->query($sql);
		if(!$rs){
			die("Ha ocurrido un error en seleccionar_trabajos_libres_que_tienen_mail_de_contacto");
		}
		return $rs;
	}
		
	function seleccionar_tl_que_tienen_mail_de_contacto_son_posters_sin_archivoCompleto(){
		$sql = "SELECT * FROM trabajos_libres WHERE contacto_mail<>'' and id_crono<>'' and archivo_trabajo_comleto='' and tipo_tl='Poster' ORDER BY numero_tl ASC;";
		//$rs = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error en seleccionar_trabajos_libres_que_tienen_mail_de_contacto");
		$rs = $this->nCon->query($sql);
		if(!$rs){
			die("Ha ocurrido un error en seleccionar_trabajos_libres_que_tienen_mail_de_contacto");
		}
		return $rs;
	}
	
	function seleccionar_Autores_trabajos_libres_que_tienen_mail_de_contacto(){
		$sql = "SELECT * FROM trabajos_libres WHERE estado = 0 ORDER BY numero_tl ASC;";
		//$rs = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error en seleccionar_Autores_trabajos_libres_que_tienen_mail_de_contacto");
		$rs = $this->nCon->query($sql);
		if(!$rs){
			die("Ha ocurrido un error en seleccionar_Autores_trabajos_libres_que_tienen_mail_de_contacto");
		}
		return $rs;
	}
	
	function seleccionar_mail_de_contacto_de_un_TL($unId){
		$sql = "SELECT contacto_mail FROM trabajos_libres WHERE id_trabajo='$unId' Limit 1";
		//$rs = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error en seleccionar_trabajos_libres_que_tienen_mail_de_contacto");
		$rs = $this->nCon->query($sql);
		if(!$rs){
			die("Ha ocurrido un error en seleccionar_trabajos_libres_que_tienen_mail_de_contacto");
		}
		/* $row = mysql_fetch_array($rs) */
		while ($row = $rs->fetch_array()) {
			$mail_contacto = $row["contacto_mail"];
		}
		return $mail_contacto ;
	}
	

	function selectTL_ID($cual,$filtroMail=""){
		if($filtroMail=="mail"){
			$sqlW = " AND contacto_mail<>''";
		}
		$sql = "SELECT * FROM trabajos_libres WHERE id_trabajo = '$cual' $sqlW;";
		//$result = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error. ".mysql_error());
		$result = $this->nCon->query($sql);
		if(!$result){
			die("Ha ocurrido un error en seleccionar_trabajos_libres_que_tienen_mail_de_contacto");
		}
		return $result;
	}

	function moverTL($cual, $aDonde){
		$sql = "UPDATE trabajos_libres SET estado = '$aDonde' WHERE id_trabajo = '$cual' LIMIT 1";
		$result = $this->nCon->query($sql);
		/*if(!$result){
			die("Ha ocurrido un error. ".$this->nCon->error);
		}*/
		return "ok";
	}

	function ubicarTL($cual, $valor){
		$sql = "UPDATE trabajos_libres SET id_crono = '$valor' WHERE id_trabajo = '$cual' LIMIT 1";
		/* mysql_query($sql,$this->nCon) */
		$result = $this->nCon->query($sql);
		if(!$result){
			return "error";
		}else{
			return "ok";
		}
	}

	function asignarAreaTL($cual, $valor){
		$sql = "UPDATE trabajos_libres SET area_tl = '$valor' WHERE id_trabajo = '$cual' LIMIT 1";
		//mysql_query($sql,$this->nCon) or die("Ha ocurrido un error. ".mysql_error());
		$result = $this->nCon->query($sql);
		if(!$result){
			die("Ha ocurrido un error. ".$this->nCon->error);
		}
		return "ok";
	}

	function asignarTipoTL($cual, $valor){

		$sql = "UPDATE trabajos_libres SET tipo_tl = '$valor' WHERE id_trabajo = '$cual' LIMIT 1";
		//mysql_query($sql,$this->nCon) or die("Ha ocurrido un error. ".mysql_error());
		$result = $this->nCon->query($sql);
		if(!$result){
			die("Ha ocurrido un error. ".$this->nCon->error);
		}
		return "ok";

	}


	function eliminarTL($cual){
		$sql = "DELETE FROM trabajos_libres WHERE id_trabajo  = $cual;";
		//mysql_query($sql,$this->nCon) or die(mysql_error());
		$result = $this->nCon->query($sql);
		if(!$result){
			die("Ha ocurrido un error. ".$this->nCon->error);
		}

		$sql2 = "DELETE FROM trabajos_libres_participantes WHERE ID_trabajos_libres  = $cual;";
		//mysql_query($sql2,$this->nCon) or die(mysql_error());
		$result2 = $this->nCon->query($sql2);
		if(!$result2){
			die("Ha ocurrido un error. ".$this->nCon->error);
		}
	}
	function eliminarTLupdate($cual){
		$sql = "DELETE FROM trabajos_libres WHERE id_trabajo  = $cual;";
		//mysql_query($sql,$this->nCon) or die(mysql_error());
		$result = $this->nCon->query($sql);
		if(!$result){
			die("Ha ocurrido un error. ".$this->nCon->error);
		}

		$sql2 = "DELETE FROM trabajos_libres_participantes WHERE ID_trabajos_libres  = $cual;";
		//mysql_query($sql2,$this->nCon) or die(mysql_error());
		$result2 = $this->nCon->query($sql2);
		if(!$result2){
			die("Ha ocurrido un error. ".$this->nCon->error);
		}
	}




	/*arrays*/

	function arrayAreas(){


		$sql = "SELECT * FROM areas_trabjos_libres ORDER by orden ASC";
		//$rs = mysql_query($sql,$this->nCon);
		$rs = $this->nCon->query($sql);
		/* $row = mysql_fetch_array($rs) */
		while ($row = $rs->fetch_array()){
			
			echo "<script>llenarArrayAreas('" . $row["Area"] . "');</script>";
			echo "<script>llenarArrayAreasID('" . $row["id"] . "');</script>";

		}
		/*$areasArray = array("Adrenal y Pubertad / Adrenal and Puberty","Hueso / Bone","Diabetes ,  Obesidad y Metabolismo / Diabetes, Obesity and Metabolism","Desórdenes del desarrollo sexual (DSD) y gónadas / Disorders of Sex Development (DSD) and Gonads","Crecimiento y Neuro Endocrinología / Growth and Neuroendocrinology","Tiroides / Thyroid"); 
		
		foreach($areasArray as $areasArray){
			$areasArray = utf8_decode($areasArray);
			echo "<script>llenarArrayAreas('$areasArray')</script>";
			
		}*/

	}


	function arrayTipoTL(){

		$sql = "SELECT * FROM tipo_de_trabajos_libres  ORDER by tipoTL ASC";
		//$rs = mysql_query($sql,$this->nCon);
		$rs = $this->nCon->query($sql);
		return $rs;

	}
	function personasCongresoConMail(){
		
		$sql = "SELECT Distinct congreso.ID_persona, personas.* FROM congreso,personas
			      WHERE congreso.ID_persona<>0 and  congreso.ID_persona = personas.ID_Personas and personas.Mail<>'' ORDER by personas.Apellidos ASC";
		//$rs = mysql_query($sql,$this->nCon);
		//$this->canPersonas= mysql_num_rows($rs);
		//$this->canPersonasTOTAL= mysql_num_rows($rs);
		$rs = $this->nCon->query($sql);
		$this->canPersonas = $rs->num_row;
		$this->canPersonasTOTAL = $rs->num_row;
		return $rs;

	}




	/*esto es para los arrays tambien*/
	function personas(){

		$sql = "SELECT * FROM personas_trabajos_libres ORDER by Apellidos, Nombre  ASC";
		//$rs = mysql_query($sql,$this->nCon);
		$rs = $this->nCon->query($sql);
		/* $row = mysql_fetch_array($rs) */
		while ($row = $rs->fetch_array()){

			if ($row["Institucion"]!=""){
				$institucion = " - "  . $row["Institucion"];
			}else{
				$institucion = "";
			}

			if ($row["Pais"]!=""){
				$pais = " ("  . $row["Pais"] . ")";
			}else{
				$pais = "";
			}

			if ($row["Profesion"]!=""){
				$profesion = " (".$row["Profesion"].")";
			}else{
				$profesion = "";
			}

			echo "<script>llenarArrayPersonas('" . $row["Apellidos"] . "," . $row["Nombre"] . $profesion . $pais . $institucion  . "', '" . $row["ID_Personas"] ."')</script>";

		}
	}
	
	function primer_autor($id_tl){
		$sql2 ="SELECT ID_participante, lee FROM trabajos_libres_participantes WHERE ID_trabajos_libres = " . $id_tl ." ORDER BY ID ASC LIMIT 1;";
		//$rs2 = mysql_query($sql2,$this->nCon);
		$rs2 = $this->nCon->query($sql2);
		/* $row2 = mysql_fetch_array($rs2) */
		while ($row2 = $rs2->fetch_array()){
			$sql3 ="SELECT * FROM personas_trabajos_libres WHERE ID_Personas =" . $row2["ID_participante"] . " LIMIT 1 ;";
			//$rs3 = mysql_query($sql3,$this->nCon);
			$rs3 = $this->nCon->query($sql3);
			/* $row3 = mysql_fetch_array($rs3) */
			while ($row3 = $rs3->fetch_array()){
				$nombre = $row3["Apellidos"];
			}
		}
		return $nombre;
	}
	
	function Insertar($camposValores,$tabla){
	//$camposValores es del tipo array("nombredelcampo1"=>"valor1","nombredelcampo2"=>"valor2")
		$resultado=false;
		if (is_array($camposValores)) {
			$campos="";
			$valores="";
			foreach($camposValores as $campo=>$valor) { // recorre el array de parametros y arma la consulta
				if ($campos!="") {
					$campos.=",";
				}
				$campos.=$campo;
				if ($valores!="") {
					$valores.=",";
				}
				//$valor = str_replace('"',"´´",$valor);
				$valor = str_replace('"<p>',"",$valor);
				$valor = str_replace('"</p>',"",$valor);
				$valores.="\"".addslashes($valor)."\"";
			}
			$sql="INSERT INTO $tabla ($campos) VALUES ($valores)";
			//mysql_set_charset('utf8',$this->nCon);
			//$resultado = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error al insertar: ".mysql_error());
			$resultado = $this->nCon->query($sql);
			if(!$resultado){
				die("Ha ocurrido un error al insertar: ".$this->nCon->error);
			}
			$ultimoID = $this->nCon->insert_id;
		}	
		return array("result"=>$resultado,"ultimoID"=>$ultimoID);
	}
	
	function Modificar( $idInscripcion, $camposValores,$tabla){
		//$camposValores es del tipo array("nombredelcampo1"=>"valor1","nombredelcampo2"=>"valor2"))
		$resultado=false;
		if (is_array($camposValores)) {
			$update="";
			foreach($camposValores as $campo=>$valor) { // recorre el array de parametros y arma la consulta
				if ($update!="") {
					$update.=",";
				}
				//$valor = str_replace('"',"´´",$valor);
				$valor = str_replace('"<p>'," ",$valor);
				$valor = str_replace('"</p>'," ",$valor);
				$update.="$campo =\"".addslashes($valor)."\"";
			}
			$sql="UPDATE $tabla SET $update WHERE $idInscripcion";
			//$resultado = mysql_query($sql,$this->nCon) or die("Ha ocurrido un error al modificar: $sql");
			$resultado = $this->nCon->query($sql);
			if(!$resultado){
				die("Ha ocurrido un error al modificar. ".$this->nCon->error);
			}
			$ultimoID = $this->nCon->insert_id;
		}
		return array("result"=>$resultado,"ultimoID"=>$ultimoID);		
	}	
	
	function eliminarByID($tabla,$id){
		$sql = "DELETE FROM $tabla WHERE $id";
		//$query = mysql_query($sql,$this->nCon);	
		$query = $this->nCon->query($sql);
		return $query;	
	}
	function getTLid($id){
		$sql = "SELECT * FROM trabajos_libres WHERE ID='$id'";
		//$query = mysql_query($sql,$this->nCon);
		$query = $this->nCon->query($sql);
		return $query;
	}
	
	function getPaisID($id_pais){
		$sql = "SELECT * FROM paises WHERE ID_Paises='$id_pais'";
		//$query = mysql_query($sql,$this->nCon);
		//$row = mysql_fetch_array($query);
		$query = $this->nCon->query($sql);
		$row = $query->fetch_array();
		return $row["Pais"];
	}
	
	function getPaises(){
		$sql = "SELECT * FROM paises ORDER BY Pais";
		//$query = mysql_query($sql,$this->nCon);
		$query = $this->nCon->query($sql);
		return $query;
	}
	
	function getModalidadID($id){
		$sql = "SELECT * FROM tipo_de_trabajos_libres WHERE id='$id'";
		//$query = mysql_query($sql,$this->nCon);
		//$row = mysql_fetch_array($query);
		$query = $this->nCon->query($sql);
		$row = $query->fetch_array();
		return $row;
	}
	
	function Autores($id_trabajo){
		$sql = "SELECT * FROM trabajos_libres WHERE id_trabajo='$id_trabajo'";
		//$rs = mysql_query($sql, $this->nCon);
		$rs = $this->nCon->query($sql);
		/* $row=mysql_fetch_array($rs) */
		while($row = $rs->fetch_array()){
			$arrayPersonas = array();
			$arrayInstituciones = array();
			$primero = true;
			$sql2 ="SELECT ID_participante, lee FROM trabajos_libres_participantes WHERE ID_trabajos_libres = " . $row["id_trabajo"] ." ORDER BY ID ASC;";
			//$rs2 = mysql_query($sql2,$this->nCon);
			$rs2 = $this->nCon->query($sql2);
			/*$row2 = mysql_fetch_array($rs2) */
			while ($row2 = $rs2->fetch_array()){
				$sql3 ="SELECT * FROM personas_trabajos_libres WHERE ID_Personas =" . $row2["ID_participante"] . ";";
				//$rs3 = mysql_query($sql3,$this->nCon);
				$rs3 = $this->nCon->query($sql3);
				/* $row3 = mysql_fetch_array($rs3) */
				while ($row3 = $rs3->fetch_array()){
			
					if(!empty($row3["Institucion"]))
					{
						//$getInstitucion = mysql_query("SELECT * FROM instituciones WHERE ID_Instituciones='".$row3["Institucion"]."'",$this->nCon) or die(mysql_error());
						//$rowInstitucion = mysql_fetch_array($getInstitucion);
						$getInstitucion = $this->nCon->query("SELECT * FROM instituciones WHERE ID_Instituciones='".$row3["Institucion"]."'");
						if (!$getInstitucion){
							die($this->nCon->error);
						}
						$rowInstitucion = $getInstitucion->fetch_array();
					}
					array_push($arrayInstituciones , $rowInstitucion["Institucion"]);
			
					if(!empty($row3["Pais"]))
					{
						//$getPais = mysql_query("SELECT * FROM paises WHERE ID_Paises='".$row3["Pais"]."'",$this->nCon);
						//$rowPais = mysql_fetch_array($getPais);
						$getPais = $this->nCon->query("SELECT * FROM paises WHERE ID_Paises='".$row3["Pais"]."'");
						if (!$getPais){
							die($this->nCon->error);
						}
						$rowPais = $getPais->fetch_array();
					}
					array_push($arrayPersonas, array($rowInstitucion["Institucion"], $row3["Apellidos"], $row3["Nombre"], $rowPais["Pais"], $row3["Curriculum"], $row3["Mail"], $row2["lee"], $row3["inscripto"]));
				
				}
			
			}
			$imprimir .= "<span style='font-family:Times New Roman, Times, serif; font-size: 12px;color: #000000;margin:0px'>";
			$arrayInstitucionesUnicas = array_unique($arrayInstituciones);
			$arrayInstitucionesUnicasNuevaClave = array();
			if(count($arrayInstitucionesUnicas)>0){
				foreach ($arrayInstitucionesUnicas as $u){
					if($u!=""){
						array_push($arrayInstitucionesUnicasNuevaClave, $u);
					}
				}
			}
			$autoreInscriptos = "";
			for ($i=0; $i < count($arrayPersonas); $i++){
				if($i>0){
					$imprimir .= "; ";
				}
				if($i==0){
					if($arrayPersonas[$i][3] != ""){
						$aster = "(*)";
					}
				}else{
					$aster = "";
				}
				if($arrayPersonas[$i][0]!=""){
					$claveIns = (array_search($arrayPersonas[$i][0] ,$arrayInstitucionesUnicasNuevaClave))+1;
				}else{
					$claveIns = "";
				}
			
				if($arrayPersonas[$i][7]==1){
					$autoreInscriptos .= $arrayPersonas[$i][1] . ", " . $arrayPersonas[$i][2] . "<br>";
				}
			
				if ($arrayPersonas[$i][6]=="1"){
					$imprimir .= "<u>";
					$presentador = $arrayPersonas[$i][1] . ", " . $arrayPersonas[$i][2];
				}		
				$imprimir .= $arrayPersonas[$i][1] . ", " . $arrayPersonas[$i][2];
				if($primero){
					$PrimerAutor = $arrayPersonas[$i][1] . ", " . $arrayPersonas[$i][2];
					$PrimerPais = $arrayPersonas[$i][3];
					$primero = false;
				}
			
				if ($arrayPersonas[$i][6]=="1"){
					$imprimir .= "</u>";
				}
				$imprimir .= "<sup> " . $claveIns . $aster  . "</sup>";
			}
		}	 
		$imprimir .= "</span><br>";
			
		$divRegistrad=false;
		$primero = false;
		/*imprimo institucion y claves*/
		$imprimir .= "<span style='font-family:Times New Roman, Times, serif;font-size: 10px;color: #000000;margin:0px'>";
		if(count($arrayInstitucionesUnicasNuevaClave)>0){
			$clave = 1;
			foreach ($arrayInstitucionesUnicasNuevaClave as $ins){
				$imprimir .= "<i> $clave - $ins</i>";
			
				if ($primero == false ){
					if($arrayPersonas[0][3] != ""){
						$primero = true;
						$imprimir .= " | (*) " . $arrayPersonas[0][3];
					}
				}				
				//$imprimir .= "</span>";
				$clave = $clave++;
			}
		}
			
		if(count($arrayInstitucionesUnicasNuevaClave)==0){
			
			if($arrayPersonas[0][3] != ""){
				$imprimir .= "(*) " . $arrayPersonas[0][3];
			}		
		}
		$imprimir .= "</span>";
		return $imprimir;
	}
	

}
?>