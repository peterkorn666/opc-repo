<?php
class templateOPC extends core
{
	public function CronoConferencsitas($data, $disabled = array())
	{
		$template = "";
		if($data)
		{
			if($data["titulo_conf"] && !isset($disabled["titulo_conf"]))
				$template .= $data["titulo_conf"]."<br>";
			if($this->hiddenConf($data["nombre"],$data["apellido"]))
			{
				if($data["calidad"] && !isset($disabled["calidad"]))
					$template .= $data["calidad"].": ";
				if($data["profesion"] && !isset($disabled["profesion"]))
					$template .= $data["profesion"]." ";
				if($data["apellido"] && !isset($disabled["apellido"]))
					$template .= $data["nombre"]." <b>".$data["apellido"]."</b>";
				if($data["pais"] && $data["pais"]!=231 && !isset($disabled["pais"]))
					$template .= " (".$this->getPais($data["pais"])["Pais"].")";
				if($template)
					$template .= "<br>";
			}			
		}
		return $template;
	}
	
	public function hiddenConf($nombre, $apellido){
		if(($nombre=="sin" && $apellido=="nombre") || ($nombre=="nombre" && $apellido=="sin"))
			return false;
		if($_SESSION["admin"] && $nombre=="a" && $apellido=="definir")
			return true;
		else if(!$_SESSION["admin"] && $nombre=="a" && $apellido=="definir")
			return false;
			
		return true;
	}

    public function templateConfTXT($data)
    {
        $getConf = $this->getConferencistaID($data["id_conf"]);
        $getRol = $this->getRolID($data["en_calidad"]);
        $txt = "";
        if($data["titulo_conf"])
            $txt .= "<div class='titulo_conf'>".$data["titulo_conf"]."</div>";
		if($this->hiddenConf($getConf["nombre"],$getConf["apellido"]))
		{
			$txt .= "<div class='calidad_conf'>&nbsp;".$getRol["calidad"]."</div>";
			if ($getConf["profesion"]) {
				$txt .= "<div class='conferencista'>" .$getConf["profesion"]." ".$getConf["nombre"]." ".$getConf["apellido"];
			}
			else {
				$txt .= "<div class='conferencista'>" .$getConf["nombre"]." ".$getConf["apellido"];
			}
			if($getConf["institucion"])
				$txt .= " <i> - ".$this->getInstitution($getConf["institucion"])["Institucion"]."</i>";
			if($getConf["pais"] && $getConf["pais"]!=231)
				$txt .= " <i>(".$this->getPais($getConf["pais"])["Pais"].")</i>";
			if($data["observaciones_conf"])
				$txt .= " <a href='#' data-id='{$data["id"]}' class='ver_mas_conf'>[ver]</a>";
			if($getConf["cv_extendido"])
				$txt .= " <a href='#' data-id='{$data["id"]}' class='ver_cv_conf'>[cv]</a>";
			if(!$data["mostrar_ponencia"] && $getConf["archivo_presentacion"])
				$txt .= " <a href='presentaciones/".$getConf["archivo_presentacion"]."' target='_blank'>[presentación]</a>";
			if($data["observaciones_conf"])
				$txt .= " <div class='div_obs_conf' id='rc{$data["id"]}'>".$data["observaciones_conf"]."</div>";
			if($getConf["cv_extendido"])
				$txt .= " <div class='div_cv_conf' id='cv{$data["id"]}'>".$getConf["cv_extendido"]."</div>";
			$txt .= "</div>";
		}
        return $txt;
    }
	
	public function templateConfTXTMail($data)
    {
        $getConf = $this->getConferencistaID($data["id_conf"]);
        $getRol = $this->getRolID($data["en_calidad"]);
        $txt = "";
        if($data["titulo_conf"])
            $txt .= "<div class='titulo_conf'><strong>".$data["titulo_conf"]."</strong></div>";
		if($this->hiddenConf($getConf["nombre"],$getConf["apellido"]))
		{
			$txt .= "<div style='margin-left:15px'>";
			if($getRol["calidad"])
				$txt .= $getRol["calidad"].": ";
			$txt .= "".$getConf["profesion"]." ".$getConf["nombre"]." ".$getConf["apellido"];
			if($getConf["institucion"])
				$txt .= " <i> - ".$this->getInstitution($getConf["institucion"])["Institucion"]."</i>";
			if($getConf["pais"] && $getConf["pais"]!=247)
				$txt .= " <i>(".$this->getPais($getConf["pais"])["Pais"].")</i>";
			$txt .= "</div>";
		}
        return $txt;
    }
	
	public function templateTlTXT($data, $color="", $from_mail = false)
	{
		//$getConf = $this->getConferencistaID($data["id_conf"]);
		$Hora_inicio = substr($data["Hora_inicio"],0,2);
		$Minutos_inicio = substr($data["Hora_inicio"],3,2);
		
		$Hora_fin = substr($data["Hora_fin"],0,2);
		$Minutos_fin = substr($data["Hora_fin"],3,2);
		$txt = "<div class='trabajo'>";
			$txt .= "<div class='hora_tl' style='margin-top:2px'>";
				/*if($this->canEdit())
					$txt .= " <input type='text' name='hora_inicio' class='editar_hora_tl' style='width:25px' value='$Hora_inicio'>:<input  type='text' name='minutos_inicio' class='editar_hora_tl' style='width:25px' value='$Minutos_inicio'> - <input type='text' name='hora_fin' style='width:25px' value='$Hora_fin' class='editar_hora_tl'>:<input type='text' name='minutos_fin' style='width:25px' value='$Minutos_fin' class='editar_hora_tl'><input type='hidden' name='id_tl' style='width:25px' value='".$data["id_trabajo"]."' class='editar_hora_tl'>";
				else if($data["Hora_inicio"]!="00:00:00" && $data["Hora_fin"]!="00:00:00")
					$txt .= "<span style='font-size:11px'>".$Hora_inicio.":".$Minutos_inicio." - ".$Hora_fin.":".$Minutos_fin."</span>";
				else
					$txt .= "&nbsp;";*/
			$txt .= "</div>";
			if ($this->canEdit()) {
				$txt .= "<div class='datos'>";
	
					if($data["area_tl"])
						$txt .= " <i>".$this->getAreasTLID($data["area_tl"])."</i> | ";
	
					if($data["id_crono"])
						$txt .= $this->getTLubicacion($data["id_crono"]);
						
	
					if($data["areas"])
						$txt .= " | <i>".$data["areas"]."</i>";
					if($data["eje_tematico"])
						$txt .= " | <i>".$data["eje_tematico"]."</i>";
					if($data["idioma"])
						$txt .= " | <i>".$data["idioma"]."</i>";
					if($data["modalidad_presentacion"])
						$txt .= " | <i>".$data["modalidad_presentacion"]."</i>";
					if($data["premio"]) {
						if($data["premio"]=="Si")
							$txt .= " | <i>Postula a premio</i>";
					}
						
					/*if($data["area_tl"]){
						$elp = "";
						if(strlen($this->getAreasTLID($data["area_tl"]))>75)
							$elp = "...";
						$txt .= substr($this->getAreasTLID($data["area_tl"]),0,75).$elp;
					}*/
				$txt .= "</div>";
			}
			
            $txt .= "<div class='titulo'>";	
				if($_SESSION["usuario"] && isset($_GET["filtro_palabra_clave"]) && !$from_mail)
	                $txt .= " <input type='checkbox' name='id_trabajos[]' value='".$data["id_trabajo"]."' style='outline:solid 3px ".$this->getColorEstados($data["estado"])."'> ";
				/*if ($this->canEdit())
					$txt .= " <strong>".$data["titulo_tl"]." (#".$data["numero_tl"].")</strong>";
				else
					$txt .= "<strong>(#".$data["numero_tl"].")</strong>";*/
				$txt .= " <strong>(#".$data["numero_tl"].") ".$data["titulo_tl"]."</strong>";	
				//<span style='background-color:$color'>".$data["numero_tl"]."</span>
            $txt .= "</div>";
			
			$txt .= "<div class='clear'></div>";
			//var_dump($this->templateAutoresTL($data));
			
			//if ($this->canEdit()) {
				$txt .= "<div class='autores'>";
					$txt .= $this->templateAutoresTL($data);
				$txt .= "</div>";
				
				$txt .= "<div class='clear'></div>";
				
				if(!$from_mail){
					$txt .= "<div class='resumen-link'>";
						if($data["resumen"] || $data["resumen2"] || $data["resumen3"] || $data["resumen4"] || $data["resumen5"])
							$txt .= "<a href='#' data-id='{$data['id_trabajo']}' class='display-resumen-link'>[ver]</a>";
						if($this->canEdit()){
							if($data['archivo_tl'])
								$txt .= " <a href='tl/".$data['archivo_tl']."' target='_blank'>[descargar]</a>";
							$txt .= " <a href='abstract/login.php?id=".base64_encode($data['id_trabajo'])."' target='_blank'>[editar]</a>";
						}
					$txt .= "</div>";
				}
	
				
	
				$txt .= "<div id='resumen{$data["id_trabajo"]}' class='resumen' style='text-align: justify'>";
				
					if($data["resumen"]){
						$txt .= "<b>Introducción:</b>".BR;
						$txt .= $data["resumen"].BR.BR;
					}
					
					if($data["resumen2"]){
						$txt .= "<b>Objetivo:</b>".BR;
						$txt .= $data["resumen2"].BR.BR;
					}
					
					if($data["resumen3"]){
						if($data["tipo_tl"] == 2){
							$txt .= "<b>Caso(s) clínico(s):</b>".BR;
						}else
							$txt .= "<b>Material y Métodos:</b>".BR;
						$txt .= $data["resumen3"].BR.BR;
					}
					
					if($data["resumen4"]){
						$txt .= "<b>Resultados:</b>".BR;
						$txt .= $data["resumen4"].BR.BR;
					}
					
					if($data["resumen5"]){
						$txt .= "<b>Conclusiones:</b>".BR;
						$txt .= $data["resumen5"].BR.BR;
					}
					
					if($data["palabrasClave"]) {
						$txt .= "<b>Palabras Claves:</b>".BR;
						$txt .= $data["palabrasClave"];
					}
				
            		$txt .= "</div>";
			//} // end admin
			$txt .= "<div class='clear'></div>";
			$txt .= "<div class='divider'></div>";
        $txt .= "</div>";
		return $txt;
	}
	
	public function templateTlCronoTXT($data,$vista="crono")
	{
		//$getConf = $this->getConferencistaID($data["id_conf"]);
		$txt = "<div align='left' style='font-size:11px;padding-left:3px; margin-bottom: 10px;'>";
			if($vista=="todos"){
				//$txt .= $this->templateAutoresTL($data, true, "todos");
				$txt .= "<span>(#<b>".$data["numero_tl"]."</b>)</span> ".$data["titulo_tl"];
			}else{
				/*$txt .= "- ";
				if($data["Hora_inicio"]!="00:00:00")
					$txt .= substr($data["Hora_inicio"],0,5)." - ".substr($data["Hora_fin"],0,5)." ";*/
				$txt .= " (#<b>".$data["numero_tl"]."</b>) ".$data["titulo_tl"];
				//$txt .= $this->templateAutoresTL($data, true, "crono");
			}

        $txt .= "</div>";
		return $txt;
	}
	
	public function templateAutoresTL($data, $presentador=false, $crono="")
	{
		$this->bind("id_tl", $data["id_trabajo"]);
		$sql = $this->query("SELECT * FROM trabajos_libres_participantes as tp JOIN personas_trabajos_libres as p ON tp.ID_participante=p.ID_Personas WHERE tp.ID_trabajos_libres=:id_tl ORDER BY tp.ID ASC");
		
		$arrayPersonas = array();
		$arrayInstituciones = array();
		$gestionAutores = "";
		$helper = 1;
		foreach($sql as $key => $row){	
			$nombre[$key] = $row["Nombre"];
			$apellido[$key] = $row["Apellidos"];
			$apellido2[$key] = $row["Apellidos2"];
			$institucion[$key] = $row["Institucion"];
			$email[$key] = $row["Mail"];
			$pais[$key] = $row["Pais"];
			$lee[$key] = $row["lee"];
			$inscripto[$key] = $row["inscripto"];
			array_push($arrayPersonas, array($institucion[$key], $apellido[$key], $nombre[$key], $lee[$key], $inscripto[$key], $apellido2[$key]));
			array_push($arrayInstituciones , $institucion[$key]);
		}
		
		//Unifcacion Instituciones
		$arrayInstitucionesUnicas =  array_values(array_unique($arrayInstituciones));
	
		$arrayInstitucionesUnicasNuevaClave = array();
		if(count($arrayInstitucionesUnicas)>0){
			foreach ($arrayInstitucionesUnicas as $u){
				if($u!=""){
					array_push($arrayInstitucionesUnicasNuevaClave, $u);
				}
			}
		}
		
		$autoreInscriptos = "";
		$gestionAutores = "";
		//var_dump($arrayPersonas);
		for ($i=0; $i < count($arrayPersonas); $i++){
			if($i>0){
				if(!$presentador)
					$gestionAutores .= "; ";
			}else
				$primerAutor .= $arrayPersonas[$i][2]. " <b>".$arrayPersonas[$i][1]. " ".$arrayPersonas[$i][5] . "</b> ";
			if($arrayPersonas[$i][0]!=""){
				$claveIns = (array_search($arrayPersonas[$i][0] ,$arrayInstitucionesUnicas))+1;
			}else{
				$claveIns = "";
			}

			if($arrayPersonas[$i][4] && $_SESSION["admin"] && $crono!="todos" && !$presentador)
					$gestionAutores .= '<div class="no-hover circle-green" style="display:inline-block"></div> ';
			
			if($arrayPersonas[$i][3]==1){
				$gestionAutores .= "<u>";
			}
			if(!$presentador){
				$gestionAutores .=  $arrayPersonas[$i][2] . " " . $arrayPersonas[$i][1]. " ".$arrayPersonas[$i][5];
			}
			if($arrayPersonas[$i][3]==1){
				$gestionAutores .= "</u>";
				if($presentador)
					$gestionAutores .= $arrayPersonas[$i][2]. " <b>".$arrayPersonas[$i][1]. " ".$arrayPersonas[$i][5] . "</b>; ";
				$helper++;
				//$gestionAutores .= $primerAutor;
			}
			if($helper==1 && $i==(count($sql)-1) && $presentador)
				$gestionAutores .= $primerAutor;
			if(!$presentador)
				$gestionAutores .= "<sup>" . $claveIns . "</sup>";
				
		}
		$gestionAutores = trim($gestionAutores,"; ");
		if(!$presentador){
			$gestionAutores .="<div class='autor_institucion'>";
			for ($i=0; $i < count($arrayInstitucionesUnicasNuevaClave); $i++){
				$gestionAutores .= "<i>";
				$gestionAutores .=  ($i+1) . " - " . $this->getInstitution($arrayInstitucionesUnicas[$i])["Institucion"] . ". ";
				$gestionAutores .= "</i>";
			}
			$gestionAutores .="</div>";
		}
			
				
			
		
		return $gestionAutores;
		
	}

	public function programaExtendido($crono,$dia_,$sala_,$helper)
	{
		global $showUbicacion;
		if($this->helperDate($crono["start_date"],0,10)!=$dia_ || $crono['section_id']!=$sala_):
			//CONTAINER DATA END
			if($helper!=0){
				echo "</div>";
			}
		endif;

		//CONTAINER DIA SALA
		echo "<div class='extendido_container_dia_sala'>";
		//DIA
		if($this->helperDate($crono["start_date"],0,10)!=$dia_):
			//CONTAINER DATA
			echo  "<span class='extendido_dia_sala extendido_dia' style='text-transform: uppercase;'>".utf8_encode(strftime($this->config["time_format"],strtotime($this->helperDate($crono["start_date"],0,10))))."</span> ".PHP_EOL;
		endif;
		//SALA

		if($crono['section_id']!=$sala_):
			echo  "<span class='extendido_dia_sala extendido_sala'>".$crono["name"]."</span>".PHP_EOL;
		endif;
		//CONTAINER DIA SALA END
		echo "</div>";

		if($this->helperDate($crono["start_date"],0,10)!=$dia_ || $crono['section_id']!=$sala_):
			echo "<div class='clear'></div>";
			//CONTAINER DATA
			echo "<div class='container_data'>";
		endif;

		//HORA / TIPO ACTIVIDAD
		$tipo_actividad = $this->getNameTipoActividadID($crono["tipo_actividad"]);
		echo  "<div class='extendido_hora_actividad' style='border-top:4px solid ".$tipo_actividad["color_actividad"]."'><span>";
			if($this->_imp)
				echo $this->showUbicacion($crono["start_date"],$crono["end_date"], $crono["section_id"]);
			else{
				if($crono["tipo_actividad"]!=11)
				echo $this->helperDate($crono["start_date"],-8,-3)." - ".$this->helperDate($crono["end_date"],-8,-3);
			}
		echo "</span>";
		if($tipo_actividad["tipo_actividad"] && ($this->helperDate($crono["start_date"],0,10) == '2018-10-17' || $_SESSION["admin"]))
			echo  " <i>".$tipo_actividad["tipo_actividad"]."</i>";
		echo  "</div>".PHP_EOL;
		//TITULO ACTIVIDAD
		echo "<div class='extendido_titulo_actividad'>";
			echo $crono["titulo_actividad"];
		echo "</div>";
		//CONFERENCISTAS
		$getCronoConf = $this->getCronoConferencistas($crono["id_crono"]);
		foreach($getCronoConf as $cronoConf):
			echo  $this->templateConfTXT($cronoConf).BR;
		endforeach;
		//TRABAJOS LIBRES
		$getCronoTL = $this->getCronoTL($crono["id_crono"]);
		foreach($getCronoTL as $cronoTL):
			echo  $this->templateTlTXT($cronoTL,$tipo_actividad["color_actividad"]);
		endforeach;
		echo "<div class='clear'></div>";
		echo "<div class='casillero_pie titulo_conf'>".$crono["casillero_pie"]."</div>";
	}
	
	public function actividadConferencista($id_conf){
		$this->bind("id_conf", $id_conf);
		$actividad = $this->query("SELECT * FROM crono_conferencistas as cc JOIN cronograma as c USING(id_crono) WHERE cc.id_conf=:id_conf");
		$i = 1;
		$html = "";
		foreach($actividad as $act){
		
			$html .= '<table style="width:100%;padding:10px" class="table nborder table-condensed">';
				$html .= '<tr>';
					$html .= '<td bgcolor="#97C6F9">';
						$html .= 'Actividad '.$i;
					$html .= '</td>';
					$html .= '<td bgcolor="#97C6F9">';
						$html .= $this->showUbicacion($act["start_date"], $act["end_date"], $act["section_id"]);
					$html .= '</td>';
					$html .= '<td bgcolor="#97C6F9">';
						$html .= '&nbsp;';
					$html .= '</td>';
				$html .= '</tr>';
				$html .= '<tr>';
					$html .= '<td colspan="3" bgcolor="#D7E9FD">Título: ';
						$html .= $act["titulo_actividad"];
					$html .= '</td>';
				$html .= '</tr>';
				if($this->isAdmin())
				{
					$html .= '<tr>';
						$html .= '<td colspan="3" bgcolor="#D7E9FD">Rol: ';
							$html .= $this->getRolID($act["en_calidad"])["calidad"];
						$html .= '</td>';
					$html .= '</tr>';
					$html .= '<tr>';
						$html .= '<td colspan="3" bgcolor="#D7E9FD">Ponencia: ';
							$html .= $act["titulo_conf"];
						$html .= '</td>';
					$html .= '</tr>';
					$html .= '<tr>';
						$html .= '<td colspan="3" bgcolor="#D7E9FD">Resumen: ';
							$html .= $act["observaciones_conf"];
						$html .= '</td>';
					$html .= '</tr>';
				}
			$html .= '</table>';
			++$i;
		}
		
		return $html;
	}
	
	public function tablaEstadosTL(){
		$config = $this->getConfig();
		$estados = $this->getEstadosTLCount();
		return '
		<table width="580" class="tabla-estados-tl table table-bordered text-center">
		  <tr>
			<td bgcolor="#FFCACA"><strong>['.$estados["recibidos"].'] <a href="'.$config["url_opc"].'?filtro_palabra_clave=&filtro_estado=0">Recibidos</a></strong></td>
			<td bgcolor="#79DEFF"><strong>['.$estados["revision"].'] <a href="'.$config["url_opc"].'?filtro_palabra_clave=&filtro_estado=1">En revisión</a></strong></td>
			<td bgcolor="#82E180"><strong>['.$estados["aprobados"].'] <a href="'.$config["url_opc"].'?filtro_palabra_clave=&filtro_estado=2">Aprobados</a></strong></td>
			<td bgcolor="#E074DD"><strong>['.$estados["notificados"].'] <a href="'.$config["url_opc"].'?filtro_palabra_clave=&filtro_estado=4">Notificados</a></strong></td>
			<td bgcolor="#999999"><strong>['.$estados["rechazados"].'] <a href="'.$config["url_opc"].'?filtro_palabra_clave=&filtro_estado=3">Rechazados</a></strong></td>
		  </tr>
		</table>';

	}
	
	
	public function programaExtendidoMail($crono, $dia_ ,$sala_, $helper, $trabajos = false)
	{
		global $showUbicacion;
		$html = "";
		if($this->helperDate($crono["start_date"],0,10)!=$dia_ || $crono['section_id']!=$sala_):
			//CONTAINER DATA END
			if($helper!=0){
				$html .= "</div>";
			}
		endif;

		//CONTAINER DIA SALA
		$html .= "<div class='extendido_container_dia_sala'>";
		//DIA
		if($this->helperDate($crono["start_date"],0,10)!=$dia_):
			//CONTAINER DATA
			$html .=  "<br><span class='extendido_dia_sala'><strong>".ucfirst(utf8_encode(strftime("%A %d de %B",strtotime($this->helperDate($crono["start_date"],0,10)))))."</strong></span>".PHP_EOL;
		endif;
		//SALA
		if($this->helperDate($crono["start_date"],0,10)!=$dia_ || $crono['section_id']!=$sala_):
			if($this->helperDate($crono["start_date"],0,10)==$dia_ && $crono['section_id']!=$sala_)
				$html .= '<br>';
			$html .=  "<span class='extendido_dia_sala'><strong>".$crono["name"]."</strong></span>";
		endif;
		//CONTAINER DIA SALA END
		$html .= "</div>";

		if($this->helperDate($crono["start_date"],0,10)==$dia_ && $helper!=0 && ($this->helperDate($crono["start_date"],0,10)==$dia_ && $crono['section_id']==$sala_))
			$html .= '<br>';

		if($this->helperDate($crono["start_date"],0,10)!=$dia_ || $crono['section_id']!=$sala_):
			$html .= "<div class='clear'></div>";
			//CONTAINER DATA
			$html .= "<div class='container_data'>";
		endif;

		//HORA / TIPO ACTIVIDAD
		//
		$tipo_actividad = $this->getNameTipoActividadID($crono["tipo_actividad"]);

		$html .=  "<div class='extendido_hora_actividad' style='border-top:4px solid ".$tipo_actividad["color_actividad"]."; padding:2px'><span>";
			if($this->_imp)
				$html .= $this->showUbicacion($crono["start_date"],$crono["end_date"], $crono["section_id"]);
			else
				$html .= $this->helperDate($crono["start_date"],-8,-3)." - ".$this->helperDate($crono["end_date"],-8,-3);
		$html .= "</span>";
		if($tipo_actividad["tipo_actividad"])
			$html .=  " <i>".$tipo_actividad["tipo_actividad"]."</i>";
		if($crono["titulo_actividad"])
			$html .= " - <b>".$crono["titulo_actividad"]."</b>";
		$html .=  "</div>";
		//CONFERENCISTAS
		$getCronoConf = $this->getCronoConferencistas($crono["id_crono"]);
		foreach($getCronoConf as $cronoConf):
			$html .= $this->templateConfTXTMail($cronoConf);
		endforeach;
		//TRABAJOS LIBRES
		if($trabajos){
			$getCronoTL = $this->getCronoTL($crono["id_crono"]);
			foreach($getCronoTL as $cronoTL):
				$html .=  $this->templateTlTXT($cronoTL,$tipo_actividad["color_actividad"], true);
			endforeach;
		}
		$html .= "<div class='clear'></div>";
//		$html .= "<div class='casillero_pie titulo_conf'>".$crono["casillero_pie"]."</div>";
		return $html;
	}
	
	public function tablaActionsTL(){
		$config = $this->getConfig();
		$html = '
		<table id="actions_tl" class="table" bgcolor="#F9F9F9">
		  <tbody><tr>
			<td><strong>Con marca:</strong></td>
			<td><input type="submit" class="btn btn-default input-sm form-control" style="background-color:#99CCCC" value="Preparar envío masivo de mails a los trabajos seleccionados"></td>
		  </tr>
		  <tr>
			<td width="95">Mover a:</td>
			<td width="535">
				<div class="input-group">
					<select class="form-control input-sm" name="asignar_estado">
						<option style="background-color:#FFCACA;" value="0">Recibidos</option>
						<option style="background-color:#79DEFF;" value="1">En revisión</option>
						<option style="background-color:#82E180;" value="2">Aprobados</option>
						<option style="background-color:#E074DD;" value="4">Notificados</option>
						<option style="background-color:#999999;" value="3">Rechazados</option>
					</select>
					<span class="input-group-btn">
						<input type="button" class="btn btn-default input-sm" data-target="estado" value=" &nbsp;&nbsp;&nbsp;Mover">
					</span>
				</div>
			</td>
		  </tr>
		  <tr>
			<td>Asignar tipo:</td>
			<td>
				<div class="input-group">
					<select id="tipo_de_TL" class="form-control input-sm" name="asignar_modalidad">
					<option value=""></option>
					<option value="Oral">Oral</option>
                    <option value="Poster">Poster</option>
					</select>
					<span class="input-group-btn">
						<input type="button" class="btn btn-default input-sm" data-target="modalidad" value="Asignar">
					</span>
				</div>
			</td>
		  </tr>
		  <tr>
			<td>Asignar area:</td>
			<td>
				<div class="input-group">
					<select class="form-control input-sm" name="asignar_area">
						<option value="">Seleccione un área</option>';
						foreach($this->getAreasTL() as $areas){
							$html .= '<option value="'.$areas["id"].'">'.$areas["Area"].'</option>';
						}
$html .= '						
					</select>
					<span class="input-group-btn">
						<input type="button" class="btn btn-default input-sm" data-target="area" value="Asignar">
					</span>
				</div>
			</td>
		  </tr>
		  <tr>
			<td>Ubicar:&nbsp;&nbsp;</td>
			<td>
				<div class="input-group">
					<select class="form-control input-sm" name="asignar_casillero">
						<option selected="" style="background-color:#999999; color:#FF0000;" value="">Sin Ubicación</option>';     
						$ubicados_tl = $this->query('SELECT * FROM cronograma as c JOIN salas as s ON c.section_id=s.salaid ORDER BY SUBSTRING(c.start_date,1,10), s.orden, SUBSTRING(c.start_date,12,16) ASC');
						foreach($ubicados_tl as $ubicado){
							if($ubicado['id_crono']==$_GET['filtro_ubicado'])
								$chktl = 'selected';
							$html .= '<option value="'.$ubicado['id_crono'].'" '.$chktl.'>'.$this->showUbicacion($ubicado["start_date"],$ubicado["end_date"],$ubicado["section_id"]).' - '.$this->getTematicaID($ubicado["tematica"])["Tematica"].'</option>';
							$chktl = '';
						}    
					$html .= '	    
					</select>
					<span class="input-group-btn">
						<input type="button" class="btn btn-default input-sm" data-target="casillero" value="&nbsp;&nbsp;Ubicar">
					</span>
				</div>
			</td>
		  </tr>
		  <tr>
			<td colspan="2"><a href="#" class="checkuntls">Marcar todos / Desmarcar todos</a></td>
		  </tr>
		</tbody>
		</table>';
		return $html;
	}
	
	public function getColorEstados($cual){
		switch($cual)
		{
			case "0":
				return "#FFCACA";
			break;
			case "1":
				return "#79DEFF";
			break;
			case "2":
				return "#82E180";
			break;
			case "3":
				return "#999999";
			break;
			case "4":
				return "#E074DD";
			break;
		}
	}


}
?>