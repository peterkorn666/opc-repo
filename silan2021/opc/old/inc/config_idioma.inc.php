<?
if($_GET["idioma"]!=""){
	$_SESSION["idioma__"] = $_GET["idioma"];
} else {
	$_SESSION["idioma__"] = "";
}
if($_SESSION["idioma__"] == "ing"){
	$visitas__ = "Visited: ";
	$log_in__ = "<< Log in";
	$log_out__ = '<font color="#FFFFCC"  style="font-size: 9px">&nbsp;</font><font  style="font-size: 11px"><span class="Estilo5">User: <b>'.$_SESSION["usuario"].'</b></span><b>    </b></font><font  style="font-size: 10px" color="#999999">&nbsp;|&nbsp;</font>&nbsp;<a href="cerrar_session.php" class="menu_ses" style="font-size: 10px">Log out&nbsp;&nbsp;</a>';
	$ingresar_modificar__ = "Add or Modify:";
	$actividad_casillero__ = "Activity";
	$esquema__ = "General Configuration Congress<br />
<a href='../?page=tipoActividadesManager' style='font-size:9px; text-decoration:none'>Activity Type | </a><a href='../?page=calidadCasilleroManager' style='font-size:9px; text-decoration:none'>Roles | </a><a href='altaPais.php' style='font-size:9px; text-decoration:none'>Countries</a>";
	$participantes__ = "Lecturers, Coordinators";
	$trabajos__ = "Scientific Papers";
	$autores__ = "Authors";
	$mail_masivo__ = "Masive eMail to:";
	$contacto_tls__ ="Paper Contacts";
	$autores_tls__ = "Paper Authors";
	$conf_coord__ = "Lecturers/Coordinators";
	$inscriptos__ = "Registered";
	$actividades__ = "Coordinators tab";
	$busqueda_avanzada_congreso__ = "Advanced Search in Congress";
	$busqueda_avanzada_trabajos__ = "Advanced Search in Papers";
	$estadisticas__ = "Stats";
	$excel__ = "Excel Document";
	$listado_trabajos__ = "Papers List";
	$listado_autores__ = "Authors List";
	$listado_congreso__ = "Congress List";
	$listado_inscriptos__ = "People List";
	$menu_tradicional__ = "Go to previous menu";
	$txt_buscar__ = "Search";
	$txt_buscar_con__ = "Search in Congress";
	$txt_buscar_tra__ = "Search in Papers";
	$cartas_predefinidas_ = "Preset Load Letter";
}else{
	$visitas__ = "Visitas al sitio: ";
	$log_in__ = "<< Iniciar Sesi&oacute;n";
	$log_out__ = '<font color="#FFFFCC"  style="font-size: 9px">&nbsp;</font><font  style="font-size: 11px"><span class="Estilo5">Usuario: <b>'.$_SESSION["usuario"].'</b></span><b>    </b></font><font  style="font-size: 10px" color="#999999">&nbsp;|&nbsp;</font>&nbsp;<a href="cerrar_session.php" class="menu_ses" style="font-size: 10px">Salir</a>';
	$ingresar_modificar__ = "Ingresar o Modificar:";
	$actividad_casillero__ = "Crear Actividad";
	$esquema__ = "Configuraci&oacute;n general del Congreso<br />
<a href='../?page=tipoActividadesManager' style='font-size:9px; text-decoration:none'>Tipo de Actividad | </a><a href='../?page=calidadCasilleroManager' style='font-size:9px; text-decoration:none'>Roles | </a><a href='altaPais.php' style='font-size:9px; text-decoration:none'>Paises</a>";
	$participantes__ = "Conferencistas, Coordinadores";
	$trabajos__ = "Trabajos Cient&iacute;ficos";
	$autores__ = "Autores";
	$mail_masivo__ = "eMail masivo a:";
	$contacto_tls__ ="Contactos de Trabajos";
	$autores_tls__ = "Autores de Trabajos";
	$conf_coord__ = "Conferencistas/Coordinadores";
	$actividades__ = "Ficha de Conferencistas";
	$inscriptos__ = "Inscriptos";
	$busqueda_avanzada_congreso__ = "B&uacute;squeda Avanzada en Congreso";
	$busqueda_avanzada_trabajos__ = "B&uacute;squeda Avanzada en Trabajos";
	$estadisticas__ = "Estad&iacute;sticas";
	$excel__ = "Formato Excel";
	$listado_trabajos__ = "Listado de Trabajos";
	$listado_autores__ = "Listado de Autores";
	$listado_congreso__ = "Listado de Todo el Congreso";
	$listado_inscriptos__ = "Lista de Personas";
	$menu_tradicional__ = "Ir al men&uacute; tradicional";
	$txt_buscar__ = "Buscar";
	$txt_buscar_con__ = "Buscar en Congreso";
	$txt_buscar_tra__ = "Buscar en Trabajos";
	$cartas_predefinidas_ = "Cargar Carta Predefinida";

}

?>