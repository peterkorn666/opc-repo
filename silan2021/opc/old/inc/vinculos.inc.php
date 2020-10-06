<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!--LINKS-->
<link rel="stylesheet" href="css/slide.css" type="text/css" media="screen" />


<!--LINKS-->
<?
if ($_SESSION["registrado"]==true){ ?>
    <div id="toppanel">
        <div id="panel">
            <div class="content clearfix">
                <table width="100%" cellspacing="1" cellpadding="2" bgcolor="#F2F2F2">
                    <tr style="font-family:Arial Narrow; font-size:13px">
                        <td width="19%" align="center" valign="middle" bgcolor="#F2F2F2"><? if($paginaINFOlink!=""){?><img src="images/web.png" width="25" height="26" /><? }else{echo "&nbsp;";}?>
                            <? if($paginaINFOlink!=""){?>
                            <a href="<?=$paginaINFOlink?>" target="_blank"><strong>WEB</strong></a><? }else{echo "&nbsp;";}?></td>
                        <td width="19%" align="center" valign="middle" bgcolor="#F2F2F2"><img src="images/mail.png" width="25" height="19"><strong>Env&iacute;o de E-mails</strong></td>
                        <td width="13%" align="center" valign="middle" bgcolor="#F2F2F2"><img src="images/excel.png" width="25" height="25"><strong>Descargar Excel</strong></td>
                        <td width="11%" align="center" valign="middle" bgcolor="#F2F2F2"><img src="images/buscar.png" width="22" height="22"><strong>B&uacute;squeda</strong></td>
                        <td colspan="4" align="center" valign="middle" bgcolor="#D6D6D6"><img src="images/lapiz.png" width="24" height="24" align="absmiddle"><strong>&nbsp;Crear o modificar</strong><a href="javascript:Abrir_ventana('respaldo/respaldo.php')" class="menu_sel" ></a></td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" bgcolor="#FFFFFF"><? if($abstract!=""){?><img src="images/flecha.png">&nbsp;<a href="<?=$abstract?>" target="_blank">Abstract</a><? }else{echo "&nbsp;";}?></td>
                        <td align="left" valign="top" bgcolor="#FFFFFF"><img src="images/flecha.png">&nbsp;<a href="envioMail_trabajosLibres.php">Contactos de Trabajos</a></td>
                        <td align="left" valign="top" bgcolor="#FFFFFF"><img src="images/flecha.png">&nbsp;<a href="todoslostrabajosXLS.php">Trabajos</a></td>
                        <td align="left" valign="top" bgcolor="#FFFFFF"><img src="images/flecha.png">&nbsp;<a href="estadoTL.php?estado=cualquier&vacio=true">Trabajos</a></td>
                        <td width="13%" align="left" valign="top" bgcolor="#EAEAEA"><img src="images/flecha.png">&nbsp;<a href="altaDia.php">D&iacute;as</a></td>
                        <td width="13%" align="left" valign="top" bgcolor="#EAEAEA"><img src="images/flecha.png">&nbsp;<a href="altaActividad.php">Tipos de actividad</a></td>
                        <td width="12%" align="left" valign="top" bgcolor="#EAEAEA"><img src="images/flecha.png">&nbsp;<a href="altaCasillero.php">Casillero</a></td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" bgcolor="#FFFFFF"><img src="images/flecha.png"> <span style="
	padding-left:10px; font-family:Arial Narrow; font-size:13px">Inscripci&oacute;n</span> <? if($fichaEs!=""){?>&nbsp;<a href="<?=$fichaEs?>" target="_blank"> Espa&ntilde;ol</a><? }else{echo "&nbsp;";}?> <? if($fichaEn!=""){?>&nbsp;<a href="<?=$fichaEn?>" target="_blank">Ingl&eacute;s</a><? }else{echo "&nbsp;";}?></td>
                        <td align="left" valign="top" bgcolor="#FFFFFF"><img src="images/flecha.png">&nbsp;<a href="envioMail_Autores_trabajosLibres.php">Autores de Trabajos</a></td>
                        <td align="left" valign="top" bgcolor="#FFFFFF"><img src="images/flecha.png">&nbsp;<a href="todoslosautoresXLS.php">Autores</a></td>
                        <td align="left" valign="top" bgcolor="#FFFFFF"><img src="images/flecha.png">&nbsp;<a href="buscar_avanzada.php">Congreso</a></td>
                        <td align="left" valign="top" bgcolor="#EAEAEA"><img src="images/flecha.png">&nbsp;<a href="altaSala.php">Salas</a></td>
                        <td align="left" valign="top" bgcolor="#EAEAEA"><img src="images/flecha.png">&nbsp;<a href="altaArea.php">&Aacute;reas</a></td>
                        <td align="left" valign="top" bgcolor="#EAEAEA"><img src="images/flecha.png">&nbsp;<a href="altaPersonas.php">Conferencista</a></td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" bgcolor="#FFFFFF"><? if($consulta!=""){?><img src="images/flecha.png">&nbsp;<a href="<?=$consulta?>" target="_blank">Consulta de inscriptos</a><? }else{echo "&nbsp;";}?></td>
                        <td align="left" valign="top" bgcolor="#FFFFFF"><img src="images/flecha.png">&nbsp;<a href="envioMail_listadoParticipantes.php">Conferencistas/Coordinadores</a></td>
                        <td align="left" valign="top" bgcolor="#FFFFFF"><img src="images/flecha.png">&nbsp;<a href="todosencongresoXLS.php">Todo el Congreso</a></td>
                        <td align="left" valign="top" bgcolor="#FFFFFF"><img src="images/flecha.png">&nbsp;<a href="listadoParticipantes.php">Participantes</a></td>
                        <td align="left" valign="top" bgcolor="#EAEAEA"><img src="images/flecha.png">&nbsp;<a href="altaHora.php">Horarios</a></td>
                        <td align="left" valign="top" bgcolor="#EAEAEA"><img src="images/flecha.png">&nbsp;<a href="altaTematica.php">Tem&aacute;ticas</a></td>
                        <td align="left" valign="top" bgcolor="#EAEAEA"><img src="images/flecha.png">&nbsp;<a href="altaTrabajosLibres.php">Trabajos</a></td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" bgcolor="#FFFFFF"><? if($alojamiento!=""){?><img src="images/flecha.png">&nbsp;<a href="<?=$alojamiento?>" target="_blank">Alojamiento</a><? }else{echo "&nbsp;";}?></td>
                        <td align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
                        <td align="left" valign="top" bgcolor="#FFFFFF"><img src="images/flecha.png">&nbsp;<a href="todaslaspersonasXLS.php">Personas</a></td>
                        <td align="left" valign="top" bgcolor="#FFFFFF"><img src="images/flecha.png">&nbsp;<a href="actividades/listado.php">Ficha de Conferencistas</a></td>
                        <td align="left" valign="top" bgcolor="#EAEAEA"><img src="images/flecha.png">&nbsp;<a href="altaInstitucion.php">Instituciones</a></td>
                        <td align="left" valign="top" bgcolor="#EAEAEA"><img src="images/flecha.png">&nbsp;<a href="altaPais.php">Pa&iacute;ses</a></td>
                        <td align="left" valign="top" bgcolor="#EAEAEA"><img src="images/flecha.png">&nbsp;<a href="altaPersonasTL.php">Autores</a></td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
                        <td align="left" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
                        <td align="left" valign="top" bgcolor="#FFFFFF"><img src="images/database.png" alt="" width="25" height="25" />&nbsp;<a href="javascript:Abrir_ventana('respaldo/respaldo.php')" class="menu_sel" ><strong>Respaldar</strong></a></td>
                        <td align="left" valign="top" bgcolor="#FFFFFF"><img src="images/estadistica.png" width="23" height="26" />&nbsp;<a href="estadisticasTL.php"><strong>Estad&iacute;sticas</strong></a></td>
                        <td align="left" valign="top" bgcolor="#EAEAEA"><img src="images/flecha.png">&nbsp;<a href="altaRubro.php">Rubros</a> <img src="img/nuevo.png"/></td>
                        <td align="left" valign="top" bgcolor="#EAEAEA"><img src="images/flecha.png">&nbsp;<a href="altaStaff.php">Staff</a> <img src="img/nuevo.png"/></td>
                        <td align="left" valign="top" bgcolor="#EAEAEA"><img src="images/flecha.png">&nbsp;<a href="altaGestionSala.php">Tareas</a> <img src="img/nuevo.png" /></td>
                    </tr>
                </table></div>
        </div>
        <!-- /login -->
        <!-- The tab on top -->
        <div class="tab">
            <ul class="login">
                <li class="left">&nbsp;</li>
                <li>&nbsp;</li>
                <li class="sep"></li>
                <li id="toggle">
                    <!--<a id="open" class="open" href="#">Men&uacute;</a>
                    <a id="close" style="display: none;" class="close" href="#">Ocultar</a>-->
                    <a class="open" href="../">Volver</a>
                </li>
                <li class="right">&nbsp;</li>
            </ul>
        </div>
        <!-- / top -->
    </div> <br />

<? }?>
<script>
    function Abrir_ventana (pagina) {
        var opciones="toolbar=no,location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=508, height=365, top=85, left=140";
        window.open(pagina,"",opciones);
    }
</script>
