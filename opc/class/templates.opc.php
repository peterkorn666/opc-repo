<?php
class templateOPC extends core
{
	public function CronoConferencistas($data, $disabled = array())
	{
		$template = "";
		if($data && $data['en_crono'])
		{
			if($data["titulo_conf"] && !isset($disabled["titulo_conf"]))	
				$template .= $data["titulo_conf"]."<br>";
			if($this->hiddenConf($data["nombre"],$data["apellido"]))
			{
				$template .= "<div>";// style='margin-left:13px;'
				if($data["en_calidad"] && !isset($disabled["calidad"])){
					$this->bind("calidad", $data["en_calidad"]);
					$c = $this->row("SELECT * FROM calidades_conferencistas WHERE ID_calidad=:calidad");
					$template .= $c["calidad"].": ";
				}
				if($data["apellido"] && !isset($disabled["apellido"])){
					if($data["profesion"] && !isset($disabled["profesion"])){
						$template .= $data["profesion"]." ";
					}
					$template .= $data["nombre"]." <b>".$data["apellido"]."</b>";
				}
				/*if($data["pais"] && $data["pais"]!=247 && !isset($disabled["pais"]))
					$template .= " (".$this->getPais($data["pais"])["Pais"].")";*/
				if($data["institucion"] && !isset($disabled["institucion"]))
					$template .= " (".$this->getInstitution($data["institucion"])["Institucion"].")";
				if($template)
					$template .= "</div>";
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

    public function templateConfTXT($data, $campos_anteriores = array())
    {
		if($campos_anteriores != array()){
			$rol_anterior = $campos_anteriores["rol"];
			$titulo_anterior = $campos_anteriores["titulo_conf"];
		}else{
			$rol_anterior = "";
			$titulo_anterior = "";
		}
        $getConf = $this->getConferencistaID($data["id_conf"]);
        $getRol = $this->getRolID($data["en_calidad"]);
        $txt = "";
		
		//Titulo del conferencista
		$puede_mostrar_titulo = false;
		if($titulo_anterior != $data["titulo_conf"]){
			$puede_mostrar_titulo = true;
		}
		/*if(count($getRol) > 0){
			if($titulo_anterior != $data["titulo_conf"]){
				$puede_mostrar_titulo = true;
			}
		}else
			$puede_mostrar_titulo = true;*/
		if($data["titulo_conf"] && $puede_mostrar_titulo)
			$txt .= "<div class='titulo_conf'>".$data["titulo_conf"]."</div>";
		
		//Listar al Conferencista	
		if($this->hiddenConf($getConf["nombre"],$getConf["apellido"]))
		{
			//Calidad o Rol
			$txt .= "<div class='calidad_conf'>";
				if(count($getRol) > 0){
					if($titulo_anterior != $data["titulo_conf"] || $rol_anterior != $data["en_calidad"] || ($getRol["plural"] == '0')){
						$txt .= $getRol["calidad"];
					}
				}else{
					$txt .= "&nbsp;";
				}
			$txt .= "</div>";
			//Nombre y apellido
			$txt .= "<div class='conferencista'>".$getConf["profesion"]." ".$getConf["nombre"]." ".$getConf["apellido"];//.$getConf["profesion"]." "
			
			if($getConf["institucion"])
				$txt .= " <i> - ".$this->getInstitution($getConf["institucion"])["Institucion"]."</i>";
			if($getConf["pais"] && $getConf["pais"]!=247)
				$txt .= " <i>(".$this->getPais($getConf["pais"])["Pais"].")</i>";
			if($getConf["cargo"])
				$txt .= " <span style='font-size: 13px;'>- ".$getConf["cargo"]."</span>";
			if($data["observaciones_conf"])
				$txt .= " <a href='#' class='ver_mas_conf' data-id='".$data["id_conf"]."'>[ver]</a>";
			if($getConf["cv_extendido"]){
				$txt .= " <a href='' class='ver_cv_conf' data-id='".$data["id_conf"]."'>[cv]</a>";
			}
			if(!$data["mostrar_ponencia"] && $getConf["archivo_presentacion"])
				$txt .= " <a href='cv/".$getConf["archivo_presentacion"]."' target='_blank'>[presentación]</a>";
			if($data["observaciones_conf"])
				$txt .= " <div class='div_obs_conf' data-id='".$data["id_conf"]."'>".$data["observaciones_conf"]."</div>";
			if($getConf["cv_extendido"])
				$txt .= " <div class='div_cv_conf' data-id='".$data["id_conf"]."'>".$getConf["cv_extendido"]."</div>";
			$txt .= "</div>";
		}
        return $txt;
    }
	
	public function templateConfTXTMail($data, $con_mail = false)
    {
        $getConf = $this->getConferencistaID($data["id_conf"]);
        $getRol = $this->getRolID($data["en_calidad"]);
        $txt = "";
        if($data["titulo_conf"])
            $txt .= "<div class='titulo_conf'><strong>".$data["titulo_conf"]."</strong></div>";
		if($this->hiddenConf($getConf["nombre"],$getConf["apellido"]))
		{
			$txt .= "<div style='font-family: Candara,Calibri,Segoe,Segoe UI,Optima,Arial,sans-serif; font-size: 13px;'>";
				$txt .= "<div style='margin-left: 126px; margin-right: 15px; margin-top: 2px; width: 92px; float: left; clear: left;'>";
				if($getRol["calidad"])
					$txt .= $getRol["calidad"].": ";
				$txt .= "</div>";
				$txt .= "<div style='width: 615px; float: left;'>";
					$txt .= "".$getConf["profesion"]." ".$getConf["nombre"]." ".$getConf["apellido"];
					if($getConf["institucion"])
						$txt .= " <i> - ".$this->getInstitution($getConf["institucion"])["Institucion"]."</i>";
					if($getConf["pais"] && $getConf["pais"]!=247)
						$txt .= " <i>(".$this->getPais($getConf["pais"])["Pais"].")</i>";
					if($con_mail)
						$txt .= " <i>(".$getConf["email"].")</i>";
				$txt .= "</div>";
			$txt .= "</div>";
		}
        return $txt;
    }
	
	public function templateTlTXT($data,$color="")
	{
		//$getConf = $this->getConferencistaID($data["id_conf"]);
		$Hora_inicio = substr($data["Hora_inicio"],0,2);
		$Minutos_inicio = substr($data["Hora_inicio"],3,2);
		
		$Hora_fin = substr($data["Hora_fin"],0,2);
		$Minutos_fin = substr($data["Hora_fin"],3,2);
		$txt = "<div class='trabajo'>";
			/*$txt .= "<div class='hora_tl' style='margin-top:2px'>";
				if($this->canEdit())
					$txt .= " <input type='text' name='hora_inicio' class='editar_hora_tl' style='width:25px' value='$Hora_inicio'>:<input  type='text' name='minutos_inicio' class='editar_hora_tl' style='width:25px' value='$Minutos_inicio'> - <input type='text' name='hora_fin' style='width:25px' value='$Hora_fin' class='editar_hora_tl'>:<input type='text' name='minutos_fin' style='width:25px' value='$Minutos_fin' class='editar_hora_tl'><input type='hidden' name='id_tl' style='width:25px' value='".$data["id_trabajo"]."' class='editar_hora_tl'>";
				else if($data["Hora_inicio"]!="00:00:00" && $data["Hora_fin"]!="00:00:00")
					$txt .= "<span style='font-size:11px'>".$Hora_inicio.":".$Minutos_inicio." - ".$Hora_fin.":".$Minutos_fin."</span>";
				else
					$txt .= "&nbsp;";
			$txt .= "</div>";*/
			if(!$this->_imp){
				$txt .= "<div class='datos'>";

                    if ($data["modalidad"]){
                        $modalidad = $this->getModalidadByID($data["modalidad"]);
                        if (isset($modalidad["modalidad_es"])){
                            $txt .= "<i>".$modalidad["modalidad_es"]."</i>";
                        }
                    }
                    if ($data["area_tl"]){
                        $txt .= " | <i>".$this->getAreasTLID($data["area_tl"])."</i>";
                    }
                    if ($data["linea_transversal"]){
                        $linea_transversal = $this->getLineaTransversalByID($data["linea_transversal"]);
                        if (isset($linea_transversal["linea_transversal_es"])){
                            $txt .= " | <i>".$linea_transversal["linea_transversal_es"]."</i>";
                        }
                    }


                    if($data["tipo_tl"]){
                        $tipo_tl = $this->getTipoTLByID($data["tipo_tl"]);
                        $txt .= " | <i>".$tipo_tl["tipoTL_es"]."</i>";
                    }
                    if($data["tematica_tl"]){
                        $tematica_tl = $this->getTematicaTLByID($data["tematica_tl"]);
                        $txt .= " | <i>".$tematica_tl["nombre"]."</i>";
                    }

					if($data["id_crono"]){
						$txt .= " | ".$this->getTLubicacion($data["id_crono"]);
					}

					if($data["idioma"])
						$txt .= " | <i>".$data["idioma"]."</i>";
			}else{
				$txt .= "<div class='datos_imp'>";
			}
				
			$txt .= "</div>";
			$txt .= "<div style='clear: left;'></div>";
			
            $txt .= "<div class='titulo'>";	
				if($_SESSION["usuario"] && isset($_GET["filtro_palabra_clave"]))
	                $txt .= " <input type='checkbox' name='id_trabajos[]' value='".$data["id_trabajo"]."' style='outline:solid 3px ".$this->getColorEstados($data["estado"])."'> ";
				$elipsis = "";	
				$txt .= " <strong>".$data["titulo_tl"]." (#".$data["numero_tl"].")</strong>";
				//<span style='background-color:$color'>".$data["numero_tl"]."</span>
            $txt .= "</div>";

            $txt .= "<div class='clear'></div>";
            //var_dump($this->templateAutoresTL($data));
            $txt .= "<div class='autores'>";
                $txt .= $this->templateAutoresTL($data);
            $txt .= "</div>";
			
			$txt .= "<div class='clear'></div>";
			
            $txt .= "<div class='resumen-link'>";
				if($data["resumen"] || $data["resumen2"] || $data["resumen3"] || $data["resumen4"] || $data["resumen5"] || $data["resumen6"] || $data["resumen7"] || $data["resumen8"])
	                $txt .= "<a href='#' class='display-resumen-link'>[ver]</a>";
				if($this->canEdit()){
					if($data['archivo_tl'])
						$txt .= " <a href='tl/".$data['archivo_tl']."' target='_blank'>[descargar]</a>";
					$txt .= " <a href='abstract/login.php?id=".base64_encode($data['id_trabajo'])."' target='_blank'>[editar]</a>";
				}
            $txt .= "</div>";

            

            $txt .= "<div class='resumen'>";
				if($data["resumen"]){
					$txt .= "<b>Trabajo Completo en ESPAÑOL:</b>".BR;
					$txt .= $data["resumen"].BR;
				}
				
				if($data["resumen2"]){
					$txt .= "<b>Obra Completa em PORTUGUÊS:</b>".BR;
					$txt .= $data["resumen2"].BR;
				}
				
				if($data["resumen3"]){
					$txt .= "<b>Bibliografía:</b>".BR;
					$txt .= $data["resumen3"].BR.BR;
				}
				
				if($data["resumen4"]){
					$txt .= "<b>Bibliografía:</b>".BR;
					$txt .= $data["resumen4"].BR.BR;
				}
				
				/*if($data["resumen5"]){
					$txt .= "<b>CONCLUSIONES:</b>".BR;
					$txt .= $data["resumen5"].BR.BR;
				}*/
				//$txt .= "@@@@";
				/*if($data["resumen6"]){
					$txt .= "<b>Content of the session:</b>".BR;
					$txt .= $data["resumen6"].BR.BR;
				}
				
				if($data["resumen7"]){
					$txt .= "<b>Method and extent of audience participation:</b>".BR;
					$txt .= $data["resumen7"].BR.BR;
				}
				
				if($data["resumen8"]){
					$txt .= "<b>Proposed content area and why it is important to participants:</b>".BR;
					$txt .= $data["resumen8"];
				}*/
				
            $txt .= "</div>";
			$txt .= "<div class='clear'></div>";
			$txt .= "<div class='divider'></div>";
        $txt .= "</div>";
		return $txt;
	}
	
	public function templateTlProgramaTXT($data, $color="", $mail = false)
	{
		$txt = "<div class='trabajo_programa'>";
			/*if(!$this->_imp)
				$txt .= "<div class='datos'>";
			else
				$txt .= "<div class='datos_imp'>";
					if($data["id_crono"] && !$this->_imp)
						$txt .= $this->getTLubicacion($data["id_crono"]);
						
					if($data["tipo_tl"]){
						$tipo_tl = $this->getTipoTLByID($data["tipo_tl"]);
						$txt .= " | <i>".$tipo_tl["tipoTL_es"]."</i>";
					}
					if($data["area_tl"]){
						$area_tl = $this->getAreasTLID($data["area_tl"]);
						$area_recortada = substr($area_tl, 0, 40);
						if(strlen($area_tl) > 40)
							$area_recortada .= "...";
						$txt .= " | <i>".$area_recortada."</i>";
					}	
					if($data["tematica_tl"]){
						$tematica_tl = $this->getTematicaTLByID($data["tematica_tl"]);
						$txt .= " | <i>".$tematica_tl["nombre"]."</i>";
					}
					
					if($data["idioma"])
						$txt .= " | <i>".$data["idioma"]."</i>";
				
			$txt .= "</div>";*/
			if(($data["titulo_tl"] != "Defina el título de su exposición." && $data["titulo_tl"] != "Defina el t&iacute;tulo de su exposici&oacute;n.") || ($mail === true)){
				$txt .= "<div class='titulo'>";	
					if($_SESSION["usuario"] && isset($_GET["filtro_palabra_clave"]))
						$txt .= " <input type='checkbox' name='id_trabajos[]' value='".$data["id_trabajo"]."' style='outline:solid 3px ".$this->getColorEstados($data["estado"])."'> ";
					$elipsis = "";
					$txt .= " <strong>".$data["titulo_tl"];
					if($_SESSION["admin"] && ($mail === false)){
						$txt .= " (#".$data["numero_tl"].")";
					}
					$txt .= "</strong>";
					//<span style='background-color:$color'>".$data["numero_tl"]."</span>
				$txt .= "</div>";
			}

            $txt .= "<div class='clear'></div>";
			
			/*bind
			consulta
			
			foreach(){
				
				//Calidad o Rol
				$txt .= "<div class='calidad_conf'>&nbsp;</div>";
				//Nombre y apellido
				$txt .= "<div class='conferencista'>".$getConf["nombre"]." ".$getConf["apellido"];//.$getConf["profesion"]." "
				
				if($getConf["institucion"])
					$txt .= " <i> - ".$this->getInstitution($getConf["institucion"])["Institucion"]."</i>";
			}*/
			$txt .= "<div>";
            	$txt .= $this->templateProgramaAutoresTL($data, false, "", $mail);
			$txt .= "</div>";
			
			$txt .= "<div class='clear'></div>";
			
			$tiene_resumen = $data["resumen"] || $data["resumen2"] || $data["resumen3"] || $data["resumen4"] || $data["resumen5"] || $data["resumen6"] || $data["resumen7"] || $data["resumen8"];
			
			
			if($mail === false){
				$txt .= "<div class='resumen-link'>";
					//if($tiene_resumen)
						$txt .= "<a href='#' class='display-resumen-link'>[ver]</a>";
					if($this->canEdit()){
						if($data['archivo_tl'])
							$txt .= " <a href='tl/".$data['archivo_tl']."' target='_blank'>[descargar]</a>";
						$txt .= " <a href='abstract/login.php?id=".base64_encode($data['id_trabajo'])."' target='_blank'>[editar]</a>";
					}
				$txt .= "</div>";
			

            
			//if($tiene_resumen){
				$txt .= "<div class='resumen'>";
					if($data["resumen"]){
						$txt .= "<b>Trabajo Completo en ESPAÑOL:</b>".BR;
						$txt .= $data["resumen"].BR;
					}
					
					if($data["resumen2"]){
						$txt .= "<b>Obra Completa em Português:</b>".BR;
						$txt .= $data["resumen2"].BR;
					}
					
					if($data["resumen3"]){
						$txt .= "<b>Bibliografía:</b>".BR;
						$txt .= $data["resumen3"].BR.BR;
					}
					
					if($data["resumen4"]){
						$txt .= "<b>Bibliografía:</b>".BR;
						$txt .= $data["resumen4"].BR.BR;
					}
					/*
					if($data["resumen5"]){
						$txt .= "<b>CONCLUSIONES:</b>".BR;
						$txt .= $data["resumen5"].BR.BR;
					}*/
					//$txt .= "@@@@";
					/*if($data["resumen6"]){
						$txt .= "<b>Content of the session:</b>".BR;
						$txt .= $data["resumen6"].BR.BR;
					}
					
					if($data["resumen7"]){
						$txt .= "<b>Method and extent of audience participation:</b>".BR;
						$txt .= $data["resumen7"].BR.BR;
					}
					
					if($data["resumen8"]){
						$txt .= "<b>Proposed content area and why it is important to participants:</b>".BR;
						$txt .= $data["resumen8"];
					}*/
					
				$txt .= "</div>";
			//} //endif $tiene_resumen
			}//endif $mail === false
			$txt .= "<div class='clear'></div>";
			//$txt .= "<div class='divider'></div>";
        $txt .= "</div>";
		return $txt;
	}
	
	public function templateTlCronoTXT($data,$vista="crono")
	{
		//$getConf = $this->getConferencistaID($data["id_conf"]);
		$txt = "<div align='left' style='font-size:11px;padding-left:3px'>";
			if($vista=="todos"){
				$txt .= $this->templateAutoresTL($data, true, "todos");
				$txt .= " <span>(#<b>".$data["numero_tl"]."</b>)</span>";
			}else{
				$txt .= "- ";
				if($data["Hora_inicio"]!="00:00:00")
					$txt .= substr($data["Hora_inicio"],0,5)." - ".substr($data["Hora_fin"],0,5)." ";
				if(strlen($data["titulo_tl"])>100)
					$elipsis = "...";
				$txt .= substr($data["titulo_tl"],0,100).$elipsis." (#<b>".$data["numero_tl"]."</b>) <br>";
				$txt .= $this->templateAutoresTL($data, true, "crono");
			}

        $txt .= "</div>";
		return $txt;
	}
	
	public function templateProgramaAutoresTL($data, $presentador=false, $crono="", $mail = false)
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
			$institucion[$key] = $row["Institucion"];
			$email[$key] = $row["Mail"];
			$pais[$key] = $row["Pais"];
			$lee[$key] = $row["lee"];
			$inscripto[$key] = $row["inscripto"];
			$profesion[$key] = $row["Profesion"];
			$rol[$key] = $row["rol_crono"];
			$id_autor[$key] = $row["ID_Personas"];
            if($institucion[$key] == 'Otra'){
                array_push($arrayPersonas, array($row["Institucion_otro"], $apellido[$key], $nombre[$key], $lee[$key], $inscripto[$key], $profesion[$key], $pais[$key], $rol[$key], $id_autor[$key], $email[$key]));
                array_push($arrayInstituciones , $row["Institucion_otro"]);
            } else{
                array_push($arrayPersonas, array($institucion[$key], $apellido[$key], $nombre[$key], $lee[$key], $inscripto[$key], $profesion[$key], $pais[$key], $rol[$key], $id_autor[$key], $email[$key]));
                array_push($arrayInstituciones , $institucion[$key]);
            }
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
			$se_puede_editar_rol = false;
			if($_SESSION["admin"]){
				$se_puede_editar_rol = true;
			}
			if($arrayPersonas[$i][7] != NULL){
				$rol_autor = $this->getRolID($arrayPersonas[$i][7]);
				if($rol_anterior){
					if(($rol_autor["calidad"] == $rol_anterior["calidad"]) && ($rol_autor["plural"] == 1 && $rol_anterior["plural"] == 1)){
						$txt_rol = "&nbsp;";
					}else{
						$txt_rol = $rol_autor["calidad"];
					}
				}else{
					$txt_rol = $rol_autor["calidad"];
				}
			}else{
				$txt_rol = "&nbsp;";
			}
			if($i>0){
				if(!$presentador){
					//$gestionAutores .= "; ";
					$gestionAutores .= "<br>";
				}
			}else{
				$primerAutor .= '<span class="txt_autor">';
					if($se_puede_editar_rol && $mail === false){
						$primerAutor .= '<a href="?page=asignarRol&id_autor='.$arrayPersonas[$i][8].'" target="_blank" style="color: black;">'.$arrayPersonas[$i][2]." <b>".$arrayPersonas[$i][1].'</b></a>';
					}else{
						$primerAutor .= $arrayPersonas[$i][2]." <b>".$arrayPersonas[$i][1] . "</b>";
					}
				$primerAutor .= '</span>';
			}
			if($arrayPersonas[$i][0]!=""){
				$claveIns = (array_search($arrayPersonas[$i][0] ,$arrayInstitucionesUnicas))+1;
			}else{
				$claveIns = "";
			}

			$gestionAutores .= "<div class='calidad_conf'>";
				$gestionAutores .= '<span class="txt_rol">'.$txt_rol.'</span>';
			$gestionAutores .= "</div>";
			
			$gestionAutores .= "<div class='conferencista'>";
				//if($arrayPersonas[$i][4] && $_SESSION["admin"] && $crono!="todos" && !$presentador)
					//$gestionAutores .= '<div class="no-hover circle-green" style="display:inline-block"></div> ';
				
				if($arrayPersonas[$i][3]==1){
					//$gestionAutores .= "<u>";
				}
				if(!$presentador){
					//$gestionAutores .= $arrayPersonas[$i][1] . ", " . $arrayPersonas[$i][2];
					$gestionAutores .= '<span class="txt_autor">';
						if($se_puede_editar_rol && $mail === false){
							$gestionAutores .= '<a href="?page=asignarRol&id_autor='.$arrayPersonas[$i][8].'" target="_blank" style="color: black;">'.$arrayPersonas[$i][5]." ".$arrayPersonas[$i][2]." ".$arrayPersonas[$i][1].'</a>';
						}else{
							//$arrayPersonas[$i][5]
							$gestionAutores .= $arrayPersonas[$i][5]." ".$arrayPersonas[$i][2]." ".$arrayPersonas[$i][1];
						}
					$gestionAutores .= '</span>';
				}
				if($arrayPersonas[$i][3]==1){
					//$gestionAutores .= "</u>";
					if($presentador){
						$gestionAutores .= '<span class="txt_autor">';
							if($se_puede_editar_rol && $mail === false){
								$gestionAutores .= '<a href="?page=asignarRol&id_autor='.$arrayPersonas[$i][8].'" target="_blank" style="color: black;">'.$arrayPersonas[$i][5]." ".$arrayPersonas[$i][2]." ".$arrayPersonas[$i][1].'</a>';
							}else{
								$gestionAutores .= $arrayPersonas[$i][5]." ".$arrayPersonas[$i][2]. " <b>".$arrayPersonas[$i][1] . "</b>; ";
							}
						$gestionAutores .= '</span>';
					}
					$helper++;
					//$gestionAutores .= $primerAutor;
				}
				if($helper==1 && $i==(count($sql)-1) && $presentador)
					$gestionAutores .= $primerAutor;
				if(!$presentador){
					//$gestionAutores .= "<sup>" . $claveIns . "</sup>";
					$gestionAutores .= " - <span class='autor_institucion'>".$this->getInstitution($arrayPersonas[$i][0])["Institucion"]."</span>";
					/*$gestionAutores .= " <span class='autor_pais' style='font-style: italic;'>(".$this->getPais($arrayPersonas[$i][6])["Pais"].")</span>";*/
					if($mail !== false){
						$gestionAutores .= " <span class='autor_mail' style='font-style: italic;'>(".$arrayPersonas[$i][9].")</span>";
					}
				}
			$gestionAutores .= "</div>";
			
			$rol_anterior = $rol_autor;
		}
		//$gestionAutores = trim($gestionAutores,"; ");
		//$gestionAutores = trim($gestionAutores,"<br>");
		/*if(!$presentador){
			
			//$gestionAutores .="<div class='autor_institucion'>";
			for ($i=0; $i < count($arrayInstitucionesUnicasNuevaClave); $i++){
				$gestionAutores .= "<i>";
				$gestionAutores .=  ($i+1) . " - " . $this->getInstitution($arrayInstitucionesUnicas[$i])["Institucion"] . ". ";
				$gestionAutores .= "</i>";
			}
			//$gestionAutores .="</div>";
		}*/
			
				
			
		
		return $gestionAutores;
		
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
            $institucion[$key] = $row["Institucion"];
			$email[$key] = $row["Mail"];
			$pais[$key] = $row["Pais"];
			$lee[$key] = $row["lee"];
			$inscripto[$key] = $row["inscripto"];
            if($institucion[$key] == 'Otra'){
                array_push($arrayPersonas, array($row["Institucion_otro"], $apellido[$key], $nombre[$key], $lee[$key],
                    $inscripto[$key]));
                array_push($arrayInstituciones , $row["Institucion_otro"]);
            } else{
                array_push($arrayPersonas, array($institucion[$key], $apellido[$key], $nombre[$key], $lee[$key], $inscripto[$key]));
                array_push($arrayInstituciones , $institucion[$key]);
            }
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
				$primerAutor .= $arrayPersonas[$i][2]." <b>".$arrayPersonas[$i][1] . "</b>";
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
				$gestionAutores .=  $arrayPersonas[$i][1] . ", " . $arrayPersonas[$i][2];
			}
			if($arrayPersonas[$i][3]==1){
				$gestionAutores .= "</u>";
				if($presentador)
					$gestionAutores .= $arrayPersonas[$i][2]. " <b>".$arrayPersonas[$i][1] . "</b>; ";
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
				$gestionAutores .=  ($i+1) . " - ";
				$institution = $this->getInstitution($arrayInstitucionesUnicas[$i]);
                $gestionAutores .= $institution["Institucion"];
				/*if (empty($institution)){
                    $gestionAutores .= $arrayInstitucionesUnicas[$i];
                } else {
                    $gestionAutores .= $institution["Institucion"];
                }*/
                $gestionAutores .= ". ";
				$gestionAutores .= "</i>";
			}
			$gestionAutores .="</div>";
		}
		
		return $gestionAutores;
		
	}

	public function programaExtendido($crono,$dia_,$sala_,$helper, $trabajos_como_conferencistas = false)
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
			echo  "<span class='extendido_dia_sala'>".utf8_encode(strftime("%A %d",strtotime($this->helperDate($crono["start_date"],0,10))))."</span> ".BR.PHP_EOL;
		endif;
		//SALA
		if($crono['section_id']!=$sala_ || $this->helperDate($crono["start_date"],0,10)!=$dia_):
			echo  "<span class='extendido_dia_sala'>".$crono["name"]."</span>".PHP_EOL;
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
		echo  "<div class='extendido_hora_actividad'>";
			/*if($this->_imp){
				//echo $this->showUbicacion($crono["start_date"],$crono["end_date"], $crono["section_id"]);
			}else{
				echo $this->helperDate($crono["start_date"],-8,-3)." - ".$this->helperDate($crono["end_date"],-8,-3);
			}*/
			
			//echo "<span>";
			echo "<div class='div_hora_actividad'>";
				echo $this->helperDate($crono["start_date"],-8,-3)." - ".$this->helperDate($crono["end_date"],-8,-3);
			echo "</div>";
			//echo "</span>";
		if($tipo_actividad["tipo_actividad"]){
			//echo " <i>";
			echo "<div class='div_tipo_actividad'>";
				echo $tipo_actividad["tipo_actividad"];
			echo "</div>";
			//echo "</i>";
		}
		echo  "</div>".PHP_EOL;
		echo "<div style='clear: left;'></div>";
		//TITULO ACTIVIDAD
		echo "<div class='extendido_titulo_actividad'>";
			echo $crono["titulo_actividad"];
		echo "</div>";
		//TRABAJOS LIBRES
		$getCronoTL = $this->getCronoTL($crono["id_crono"]);
		foreach($getCronoTL as $cronoTL):
			if($trabajos_como_conferencistas)
				echo $this->templateTlProgramaTXT($cronoTL,$tipo_actividad["color_actividad"]);
			else
				echo $this->templateTlTXT($cronoTL,$tipo_actividad["color_actividad"]).BR;
		endforeach;
		//CONFERENCISTAS
		$campos_anteriores = array();
		$getCronoConf = $this->getCronoConferencistas($crono["id_crono"]);
		foreach($getCronoConf as $cronoConf):
			echo $this->templateConfTXT($cronoConf, $campos_anteriores).BR;
			$campos_anteriores = array(
				"rol" => $cronoConf["en_calidad"],
				"titulo_conf" => $cronoConf["titulo_conf"]
			);
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
					$html .= '<td bgcolor="#97C6F9" style="width: 20%; vertical-align: middle;">';
						$html .= 'Actividad '.$i;
					$html .= '</td>';
					$html .= '<td bgcolor="#97C6F9" style="vertical-align: middle;">';
						$html .= $this->showUbicacion($act["start_date"], $act["end_date"], $act["section_id"]);
					$html .= '</td>';
					$html .= '<td bgcolor="#97C6F9" align="right">';
						/*if ($_SESSION["admin"]){
							
							$html .= '<input type="button" class="descargar_certificado_participacion" value="Descargar constancia de participación" data-conf="'.$id_conf.'" data-actividad="'.$act["id_crono"].'" style="background-color: #97C6F9; border: 0px;">';
							//$html .= '<a href="certificados/conferencista/participante.php?act='.urlencode(base64_encode($act["id_crono"])).'&conf='.urlencode(base64_encode($id_conf)).'" target="_blank">Descargar constancia de participación</a>';
						} else {
							
							$html .= '&nbsp;';
						}*/
						$html .= '&nbsp;';
					$html .= '</td>';
				$html .= '</tr>';
				$html .= '<tr>';
					$html .= '<td colspan="3" bgcolor="#D7E9FD">Título: ';
						$html .= $act["titulo_actividad"];
					$html .= '</td>';
				$html .= '</tr>';
				
				if($this->isAdmin()){
					$html .= '<tr>';
						$html .= '<td colspan="3" bgcolor="#D7E9FD">Rol: ';
								$html .= $this->getRolID($act["en_calidad"])["calidad"];
						$html .= '</td>';
					$html .= '</tr>';
				}
				
				$html .= '<tr>';
					$html .= '<td colspan="3" bgcolor="#D7E9FD">T&iacute;tulo de ponencia: ';
						$html .= '<textarea name="titulo_conf[]" class="form-control" style="height:40px;">'.$act["titulo_conf"].'</textarea>';
						//$html .= $act["titulo_conf"];
					$html .= '</td>';
				$html .= '</tr>';
				$html .= '<tr>';
					$html .= '<td colspan="3" bgcolor="#D7E9FD">Resumen: ';
						$html .= '<textarea name="observaciones_conf[]" class="form-control">'.$act["observaciones_conf"].'</textarea>';
						//$html .= $act["observaciones_conf"];
					$html .= '</td>';
				$html .= '</tr>';
				$html .= '<br><input type="hidden" name="id_cc[]" value="'.base64_encode($act["id"]).'">';
				
			$html .= '</table>';
			++$i;
		}
		
		return $html;
	}
	
	public function actividadConferencistaCertificado($id_conf){
		$this->bind("id_conf", $id_conf);
		$actividad = $this->query("SELECT * FROM crono_conferencistas as cc JOIN cronograma as c USING(id_crono) WHERE cc.id_conf=:id_conf");
		$i = 1;
		$html = "";
		foreach($actividad as $act){
		
			$html .= '<table style="width:100%;padding:10px" class="table nborder table-condensed">';
				$html .= '<tr>';
					$html .= '<td bgcolor="#97C6F9" style="width: 20%; vertical-align: middle;">';
						$html .= 'Actividad '.$i;
					$html .= '</td>';
					$html .= '<td bgcolor="#97C6F9" style="vertical-align: middle;">';
						$html .= $this->showUbicacion($act["start_date"], $act["end_date"], $act["section_id"]);
					$html .= '</td>';
					$html .= '<td bgcolor="#97C6F9" align="right">';
							
							$html .= '<input type="button" class="descargar_certificado_participacion" value="Descargar constancia de participación" data-conf="'.$id_conf.'" data-actividad="'.$act["id_crono"].'" style="background-color: #97C6F9; border: 0px;">';
							
					$html .= '</td>';
				$html .= '</tr>';
				$html .= '<tr>';
					$html .= '<td colspan="3" bgcolor="#D7E9FD" style="font-size: 24px;">';
						$html .= $act["titulo_actividad"];
					$html .= '</td>';
				$html .= '</tr>';
				
				if($this->isAdmin()){
					
					$html .= '<tr>';
						$html .= '<td colspan="3" bgcolor="#D7E9FD" style="font-size: 24px;">Rol: ';
								$html .= $this->getRolID($act["en_calidad"])["calidad"];
						$html .= '</td>';
					$html .= '</tr>';
				}
				
			$html .= '</table>';
			++$i;
		}
		
		return $html;
	}
	
	public function programaExtendidoMail($crono,$dia_,$sala_,$helper, $con_mail = false)
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

		$html .=  "<div class='extendido_hora_actividad' style='border-top:4px solid ".$tipo_actividad["color_actividad"]."; padding:2px'>";
			//$html .= "<span>";
			$html .= "<div class='div_hora_actividad'>";
				if($this->_imp)
					$html .= $this->showUbicacion($crono["start_date"],$crono["end_date"], $crono["section_id"]);
				else
					$html .= $this->helperDate($crono["start_date"],-8,-3)." - ".$this->helperDate($crono["end_date"],-8,-3);
			$html .= "</div>";
			//$html .= "</span>";
			
			if($tipo_actividad["tipo_actividad"]){
				//echo " <i>";
				$html.= "<div class='div_tipo_actividad'>";
					$html.= $tipo_actividad["tipo_actividad"];
				$html.= "</div>";
				//echo "</i>";
			}
			
		$html .= "</div>".PHP_EOL;
		$html .= "<div style='clear: left;'></div>";
		//TITULO ACTIVIDAD
		$html.= "<div class='extendido_titulo_actividad'>";
			$html.= $crono["titulo_actividad"];
		$html.= "</div>";

		/*if($crono["titulo_actividad"])
			$html .= " - <b>".$crono["titulo_actividad"]."</b>";
		$html .=  "</div>";*/
		//TRABAJOS LIBRES
		$getCronoTL = $this->getCronoTL($crono["id_crono"]);
		foreach($getCronoTL as $cronoTL):
			$html .= $this->templateTlProgramaTXT($cronoTL,$tipo_actividad["color_actividad"], true);
			//$html .=  $this->templateTlTXT($cronoTL,$tipo_actividad["color_actividad"]);
		endforeach;
		//CONFERENCISTAS
		$getCronoConf = $this->getCronoConferencistas($crono["id_crono"]);
		foreach($getCronoConf as $cronoConf):
			$html .= $this->templateConfTXTMail($cronoConf, $con_mail);
		endforeach;
		$html .= "<div class='clear'></div>";
//		$html .= "<div class='casillero_pie titulo_conf'>".$crono["casillero_pie"]."</div>";
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
							$html .= '<option value="'.$ubicado['id_crono'].'" '.$chktl.'>'.$this->showUbicacion($ubicado["start_date"],$ubicado["end_date"],$ubicado["section_id"]).' - '.$ubicado["titulo_actividad"].'</option>';//$this->getTematicaID($ubicado["tematica"])["Tematica"]
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