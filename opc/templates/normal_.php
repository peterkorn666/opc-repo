<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $tpl->GetVar('page_title')?></title>
    <?php echo  $tpl->setHeaders($tpl->GetVar('headers'),"css");?>
    <?php echo $tpl->setHeaders($tpl->GetVar('headers'),"js");?>
</head>
<body>
<div class="loading">Loading&#8230;</div>
<?php
if($core->isAdmin()){
?>
<!--TOP PANEL -->
<div id="toppanel">
    <div id="panel">
        <div class="content clearfix"><table cellspacing="1" cellpadding="2" bgcolor="#F2F2F2" width="100%">
                <tbody>
                    <tr>
                        <td bgcolor="#F2F2F2" align="center" width="19%" valign="middle"><img width="25" height="26" src="imagenes/web.png"><a target="_blank" href="<?php echo $config['url_website'] ?>"><strong>WEB</strong></a></td>
                        <td bgcolor="#F2F2F2" align="center" width="19%" valign="middle"><img width="25" height="19" src="imagenes/mail.png"><strong>Envío de E-mails</strong></td>
                        <td bgcolor="#F2F2F2" align="center" width="13%" valign="middle"><img width="25" height="25" src="imagenes/excel.png"><strong>Descargar Excel</strong></td>
                        <td bgcolor="#F2F2F2" align="center" width="11%" valign="middle"><img width="22" height="22" src="imagenes/buscar.png"><strong>Búsqueda</strong></td>
                        <td bgcolor="#D6D6D6" align="center" valign="middle" colspan="4"><img align="absmiddle" width="24" height="24" src="imagenes/lapiz.png"><strong>&nbsp;Crear o modificar</strong><a class="menu_sel" href="javascript:Abrir_ventana('respaldo/respaldo.php')"></a></td>
                    </tr>
                    <tr>
                        <td bgcolor="#FFFFFF" align="left" valign="top"><img src="imagenes/flecha.png">&nbsp;<a target="_blank" href="abstract/">Abstract</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="imagenes/flecha.png">&nbsp;<a target="_blank" href="corrector/">Corrector/Evaluadores</a></td>
                        <td bgcolor="#FFFFFF" align="left" valign="top"><img src="imagenes/flecha.png">&nbsp;<a href="<?php echo $config['url_opc'] ?>envio_mail/trabajos/" target="_blank">Contactos de Trabajos</a></td>
                        <td bgcolor="#FFFFFF" align="left" valign="top"><img src="imagenes/flecha.png">&nbsp;<a href="<?php echo $config['url_opc'] ?>excels/todoslostrabajosXLS.php">Trabajos</a></td>
                        <td bgcolor="#FFFFFF" align="left" valign="top"><img src="imagenes/flecha.png">&nbsp;<a href="<?php echo $config['url_opc'] ?>?page=buscarTL">Trabajos</a></td>
                        <td bgcolor="#EAEAEA" align="left" width="13%" valign="top"><img src="imagenes/flecha.png">&nbsp;<a href="<?=$config["url_opc"]?>?page=salaManager">Salas</a></td>
                        <td bgcolor="#EAEAEA" align="left" width="13%" valign="top"><img src="imagenes/flecha.png">&nbsp;<a href="<?=$config["url_opc"]?>?page=tipoActividadesManager">Tipos de actividad</a></td>
                        <td bgcolor="#EAEAEA" align="left" width="12%" valign="top"><img src="imagenes/flecha.png">&nbsp;<a href="<?=$config["url_opc"]?>admin.php" target="_blank">Casilleros</a></td>
                    </tr>
                    <tr>
                        <!--<td bgcolor="#FFFFFF" align="left" valign="top"><img src="imagenes/flecha.png"> <span style="
        padding-left:10px; font-family:Arial Narrow; font-size:13px">Inscripción</span> &nbsp; &nbsp;</td>-->
        				<td bgcolor="#FFFFFF" align="left" valign="top"><img src="imagenes/flecha.png">&nbsp;<a target="_blank" href="inscripcion/">Inscripción</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="imagenes/flecha.png">&nbsp;<a target="_blank" href="<?php echo $config['url_website'] ?>">Web</a></td>
                        <td bgcolor="#FFFFFF" align="left" valign="top"><img src="imagenes/flecha.png">&nbsp;<a href="<?php echo $config['url_opc'] ?>envio_mail/autores/" target="_blank">Autores de Trabajos</a></td>
                        <td bgcolor="#FFFFFF" align="left" valign="top"><img src="imagenes/flecha.png">&nbsp;<a href="<?php echo $config['url_opc'] ?>excels/todoslosautoresXLS.php">Autores</a></td>
                        <td bgcolor="#FFFFFF" align="left" valign="top"><img src="imagenes/flecha.png">&nbsp;<a href="<?php echo $config['url_opc_viejo'] ?>buscar_avanzada.php">Congreso</a></td>
                        <td bgcolor="#EAEAEA" align="left" valign="top"><img src="imagenes/flecha.png">&nbsp;<a href="<?php echo $config['url_opc_viejo'] ?>altaPais.php">Países</a></td>
                        <td bgcolor="#EAEAEA" align="left" valign="top"><img src="imagenes/flecha.png">&nbsp;<a href="<?php echo $config['url_opc'] ?>?page=areasCasilleroManager">Áreas</a></td>
                        <td bgcolor="#EAEAEA" align="left" valign="top"><img src="imagenes/flecha.png">&nbsp;<a href="<?php echo $config['url_opc'] ?>?page=conferencistasManager">Conferencista</a></td>
                    </tr>
                    <tr>
                        <td bgcolor="#FFFFFF" align="left" valign="top">&nbsp;<a href="old/seleccionar_panel_simple.php" target="_blank">Menú viejo</a> </td>
                        <td bgcolor="#FFFFFF" align="left" valign="top"><img src="imagenes/flecha.png">&nbsp;<a href="<?php echo $config['url_opc'] ?>envio_mail/conferencistas/" target="_blank">Conferencistas/Coordinadores</a></td>
                        <!--<td bgcolor="#FFFFFF" align="left" valign="top"><img src="imagenes/flecha.png">&nbsp;<a href="<?php echo $config['url_opc_viejo'] ?>todosencongresoXLS.php">Todo el Congreso</a></td>-->
                        <td bgcolor="#FFFFFF" align="left" valign="top"><img src="imagenes/flecha.png">&nbsp;<a href="<?php echo $config['url_opc'] ?>excels/inscriptos.php">Inscriptos</a></td>
                        <td bgcolor="#FFFFFF" align="left" valign="top"><img src="imagenes/flecha.png">&nbsp;<a href="<?php echo $config['url_opc'] ?>?page=conferencistasManager">Conferencistas</a></td>
                        <td bgcolor="#EAEAEA" align="left" valign="top"><img src="imagenes/flecha.png">&nbsp;<a href="<?php echo $config['url_opc'] ?>?page=instituciones">Instituciones</a></td>
                        <td bgcolor="#EAEAEA" align="left" valign="top"><img src="imagenes/flecha.png">&nbsp;<a href="<?php echo $config['url_opc'] ?>?page=tematicasCasilleroManager">Temáticas</a></td>
                        <td bgcolor="#EAEAEA" align="left" valign="top"><img src="imagenes/flecha.png">&nbsp;<a href="<?php echo $config['url_opc_viejo'] ?>altaTrabajosLibres.php">Trabajos</a></td>
                    </tr>
                    <tr>
                        <td bgcolor="#FFFFFF" align="left" valign="middle"><a href="<?php echo $config['url_opc'] ?>pages/programaExtendidoImp.php">Programa Extendido Imp.</a> &nbsp;&nbsp; 
                        <a href="<?=$config["url_opc"]?>XML/cronograma.php" target="_blank">XML cronograma</a></td>
                        <td bgcolor="#FFFFFF" align="left" valign="top"><img src="imagenes/flecha.png">&nbsp;<a href="<?php echo $config['url_opc'] ?>envio_mail/inscriptos/" target="_blank">Inscriptos</a></td>
                        <td bgcolor="#FFFFFF" align="left" valign="top"><img src="imagenes/flecha.png">&nbsp;<a href="<?php echo $config['url_opc_viejo'] ?>todaslaspersonasXLS.php">Personas</a></td>
                        <td bgcolor="#FFFFFF" align="left" valign="top"><img src="imagenes/flecha.png">&nbsp;<a href="<?php echo $config['url_opc'] ?>consulta/" target="_blank">Consulta de inscriptos</a></td>
                        <td bgcolor="#EAEAEA" align="left" valign="top"><img src="imagenes/flecha.png">&nbsp;<a href="<?php echo $config['url_opc'] ?>?page=calidadCasilleroManager">Roles/Calidades</a></td>
                        <td bgcolor="#EAEAEA" align="left" valign="top"><img src="imagenes/flecha.png">&nbsp;<a href="<?php echo $config['url_opc'] ?>?page=titulosConferencistaManager">Títulos de conferencista</a></td>
                        <td bgcolor="#EAEAEA" align="left" valign="top"><img src="imagenes/flecha.png">&nbsp;<a href="<?php echo $config['url_opc'] ?>?page=personasTL">Autores</a></td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" bgcolor="#FFFFFF">
                        	<a href="<?=$config["url_opc"]?>admin.php" target="_blank">Admin</a> &nbsp;&nbsp;
                            <a href="<?=$config["url_opc"]?>?page=config">Config</a> &nbsp;&nbsp;
                            <a href="<?=$config["url_opc"]?>?page=claves">Claves</a> &nbsp;&nbsp;
                            <a href="<?=$config["url_opc"]?>XML/programa_dia-hora-sala.php" target="_blank">XML programa</a>
                        </td>
                        <td bgcolor="#FFFFFF" align="left" valign="top"><img src="imagenes/flecha.png">&nbsp;<a href="<?php echo $config['url_opc'] ?>envio_mail/altaCarta.php">Nueva predefinida</a></td>
                        <td bgcolor="#FFFFFF" align="left" valign="top"><img src="imagenes/flecha.png">&nbsp;<a href="<?php echo $config['url_opc'] ?>excels/Congreso_completoXLS.php">Todo el congreso</a></td>
                        <!--<td bgcolor="#FFFFFF" align="left" valign="top"><img width="25" height="25" alt="" src="imagenes/database.png">&nbsp;<a class="menu_sel" href="javascript:Abrir_ventana('respaldo/respaldo.php')"><strong>Respaldar</strong></a></td>-->
                        <td bgcolor="#FFFFFF" align="left" valign="top"><img width="23" height="26" src="imagenes/estadistica.png">&nbsp;<a href="<?php echo $config['url_opc_viejo'] ?>estadisticasTL.php"><strong>Estadísticas</strong></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /login -->
    <!-- The tab on top -->
    <div class="tab">
        <ul class="login">
            <li class="left">&nbsp;</li>
            <li>&nbsp;</li>
            <li class="sep"></li>
            <li id="toggle">
                <a href="#" id="topmenu" class="open">Menú</a>
            </li>
            <li class="right">&nbsp;</li>
        </ul>
    </div>
    <!-- / top -->
</div>
<!-- END TOP PANEL -->
<?php
}

$arrayVistasAnchas = array(
	"personasTL"
);
$width = "";
foreach($arrayVistasAnchas as $ava){
	if($tpl->GetVar("current_page")==$ava)
		$width = "style='width: 1200px;'";
}
?>
<div id="container" <?=$width?>>
	<div id="banner">
    	<table width="580" border="0" cellspacing="5" cellpadding="1">
          <tr>
            <td><img src="<?=$config["banner_congreso"]?>" style="width: 580px; height: 100px;" /></td>
            <td>
            	<div id="login" class="col-xs-12" style="margin-top:20px;padding: 0px">
			<?php if(empty($_SESSION['usuario'])){ ?>
            	<div class="btnlogin"><a href="#">login</a></div>
                <form action="<?=$config["url_opc"]?>actions/?page=login" method="post">
                    <div class="col-xs-4 input-login lgnhidden" style="padding-right: 0px; width:110px">
                        <input type="text" name="usuario" class="form-control input-sm">
                    </div>
                    <div class="col-xs-4 input-login lgnhidden" style="width:120px">
                        <div class="input-group">
                            <input type="password" name="clave" class="form-control input-sm">
                            <span class="input-group-btn">
                                <button class="btn btn-default"  type="submit"><span class="glyphicon glyphicon-off"></span></button>
                            </span>
                        </div><!-- /input-group -->
                    </div>
                </form>
            <?php }else{
				echo '<div class="col-xs-4" style="padding-right: 0px; width:274px">';
                	echo 'Usuario: <b>'.strtoupper($_SESSION['usuario']).'</b> <a href="'.$config['url_opc'].'?page=logout">salir</a>';
				echo '</div>';
            } ?>
        </div>
        <?php
		//if($core->isAdmin()){
		?>
        <div id="buscador" class="col-xs-6" style="width:275px;">
            <form action="<?=$config["url_opc"]?>?page=buscarProgramaExtendido" method="post">
                <div class="input-group">
                    <input type="text" name="buscador" class="form-control" value="<?=$_POST["buscador"]?>" placeholder="Buscar...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">buscar</button>
                    </span>
                </div><!-- /input-group -->
            </form>
        </div>
        <?php
		//}
		?>
        <div class="col-xs-6" style="width: 275px;  float: left;padding: 0px" align="center">
        					<a href="<?=$config["url_opc"]?>?page=programaExtendido">Programa</a> | &nbsp;
        	 				<a href="<?=$config["url_opc"]?>?page=cronograma">Crono</a> | &nbsp;
							<?php
                            if($core->isAdmin()){
							?>
                            	<a href="<?php echo $config['url_opc'] ?>pages/programaExtendidoImp.php" target="_blank">Descargar programa</a> | &nbsp;
                            <?php
							}
							?>
							<a href="<?=$config["url_opc"]?>?page=cronoCompleto">Todos los días</a>
                            
        </div>
    
            </td>
          </tr>
        </table>

    	</div>
        
    <div class="clear"></div>
    <div id="resultados" style="margin:5px 10px 10px 91px"></div>

<?php
	// Output template's content
	//if ($_SESSION["admin"])
		echo $data;
?>
</div>
</body>
</html>