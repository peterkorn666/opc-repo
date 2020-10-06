<?php
	require_once('../codebase/connector/scheduler_connector.php');
	require_once('../codebase/connector/db_pdo.php');
	include ('../codebase/connector/crosslink_connector.php');
	include ('../codebase/config.php');

	//$confs = new CrossOptionsConnector($res, $dbtype);
	//$confs->options->render_table("conferencistas","id_conf","id_conf(value),nombre(label)");
	//$confs->link->render_table("crono_conferencistas","id_crono", "id_crono,id_conf");

	$condicion_fecha="1=1"; // definir condicion para que los elementos que obtengo estén en las fechas que se muestran
	
	//Conferencistas
	/*$confs = new OptionsConnector($res, $dbtype);
	$sqlConfs="SELECT * FROM `crono_conferencistas` as cc INNER JOIN conferencistas as c ON cc.id_conf=c.id_conf";
	$confs->render_sql($sqlConfs,"id_crono","id_crono,id_conf,titulo_conf,en_calidad,en_crono,nombre,apellido,pais,institucion");*/
	
	//Trabajos Libres
	$tls = new OptionsConnector($res, $dbtype);
	$sqlTls="SELECT t.id_trabajo,t.id_crono,t.numero_tl,t.titulo_tl,c.id_crono FROM trabajos_libres as t JOIN cronograma as c ON t.id_crono=c.id_crono ORDER BY t.orden";
	$tls->render_sql($sqlTls,"id_crono","id_trabajo,id_crono,numero_tl,titulo_tl");

	//Salas
	$salas = new OptionsConnector($res, $dbtype);
	$salas->render_sql("SELECT salaid as value, name as label, orden FROM salas ORDER BY orden","salaid","value,label");

	//Tipos actividades
	$tipo_actividades = new OptionsConnector($res, $dbtype);
	$sqlTP="SELECT t.id_tipo_actividad,t.tipo_actividad,c.id_crono FROM tipo_de_actividad as t JOIN cronograma as c ON t.id_tipo_actividad=c.tipo_actividad";
	$tipo_actividades->render_sql($sqlTP,"id_tipo_actividad","tipo_actividad,id_crono");


	//Conferencistas
	$confs = new OptionsConnector($res, $dbtype);
	$confs->render_sql("SELECT * FROM crono_conferencistas as cc JOIN conferencistas as c ON cc.id_conf=c.id_conf JOIN cronograma as g ON cc.id_crono=g.id_crono ORDER BY cc.id","id_crono","id_crono, id_conf, nombre, apellido, institucion, pais");
	
	$scheduler = new SchedulerConnector($res, $dbtype);
	$scheduler->enable_live_update('actions_table');
	
	function escape($string)
	{
		global $scheduler;
		return $scheduler->sql->escape($string);
	}
	
	function getLastCronoID(){
		global $res;
		$query = $res->prepare("SELECT id_crono FROM cronograma ORDER BY id_crono DESC LIMIT 1");
		$query->execute();
		$data = $query->fetch(PDO::FETCH_ASSOC);
		if($data["id_crono"]=="")
			$data["id_crono"] = 0;
		  return $data["id_crono"];
	}
	
	function control_confs($action){
		global $scheduler;
		$lightbox = $action->get_value("lightbox");
		if($lightbox){
			$conf_json = json_decode($action->get_value("confs"));
			$status = $action->get_status();
			if($action->get_value("id_crono")==0)
				$id_crono = getLastCronoID();
			else
				$id_crono = $action->get_value("id_crono");
			if($id_crono)
			{
				if(is_array($conf_json))
				{
						//reset confs
						$scheduler->sql->query("DELETE FROM crono_conferencistas WHERE id_crono='$id_crono'");
						foreach($conf_json as $conf)
						{
							if(isset($conf->titulo))
							{
								if($conf->id_crono==$id_crono || $id_crono)
								{
									$scheduler->sql->query("INSERT INTO crono_conferencistas (id_conf,id_crono,en_calidad,titulo_conf,observaciones_conf,mostrar_ponencia, en_crono) VALUES ('".escape($conf->id_conf)."','".$id_crono."','".escape($conf->calidad)."','".escape($conf->titulo)."','".escape($conf->observaciones_conf)."', '".escape($conf->mostrar_ponencia)."', '".escape($conf->en_crono)."')");
								}
							}
							
							/*else
							{
								$scheduler->sql->query("UPDATE crono_conferencistas SET en_calidad='".escape($conf->calidad)."', titulo_conf='".escape($conf->titulo)."', en_crono='".escape($conf->en_crono)."' WHERE id_conf='".escape($conf->id_conf)."' AND id_crono='".$id_crono."'");
							}*/
						}
				}
			}
		}
	}

	function update_trabajos($action){
		global $scheduler;
		$lightbox = $action->get_value("lightbox");
		if($lightbox){
			LogMaster::log("##### TRABAJOS ####");
			$id_crono = $action->get_value("id_crono");
			LogMaster::log("ID CRONO: ".$id_crono);
			$id_trabajo = $action->get_value("id_trabajo");
			//Update Trabajos
			if(!$action->get_value("id_crono"))
				$id_crono = getLastCronoID();
			else
				$id_crono = $action->get_value("id_crono");
			LogMaster::log("ID TRABAJO: ".$id_trabajo);
			//LIMPIAR TODOS LOS TRABAJOS DEL CASILLERO POR SI ELIMINO ALGUNO
			$scheduler->sql->query("UPDATE trabajos_libres SET id_crono=0,orden=0 WHERE id_crono='".$scheduler->sql->escape($id_crono)."'");	
			if($id_trabajo){
				if(strpos($id_trabajo,',') !== false)
				{
					$id_trabajo = explode(",",$id_trabajo);
					foreach($id_trabajo as $orden => $ids)
						$scheduler->sql->query("UPDATE trabajos_libres SET id_crono='".$scheduler->sql->escape($id_crono)."',orden='$orden' WHERE id_trabajo='".$scheduler->sql->escape($ids)."'");
				}else{
					$scheduler->sql->query("UPDATE trabajos_libres SET id_crono='".$scheduler->sql->escape($id_crono)."', orden='1' WHERE id_trabajo='".$scheduler->sql->escape($id_trabajo)."'");
				}
			}
			
			
			$action->success();
			LogMaster::log("//// TRABAJOS /////");
		}		
	}
	
	//$scheduler->set_options("conferencistas", $confs->options);	
	//$scheduler->set_options("id_trabajo", $tls->options);
	$scheduler->set_options("salas", $salas);
	$scheduler->set_options("confs", $confs);
	$scheduler->set_options("trabajos_libres_list", $tls);
	$scheduler->set_options("tipos_actividades_list", $tipo_actividades);
	
	$scheduler->enable_log("log.txt",true);
	$scheduler->event->attach("afterProcessing","update_trabajos");
	$scheduler->event->attach("afterProcessing","control_confs");
	
	$scheduler->render_table("cronograma","id_crono","start_date,end_date,text,section_id,titulo_actividad,tipo_actividad,area,tematica,casillero_pie");

?>