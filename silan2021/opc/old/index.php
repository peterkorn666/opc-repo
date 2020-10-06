<?
header("Location: seleccionar_panel_simple.php");
include "envioMail_Config.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$congreso?> - Programa on-line</title>
<link href="index.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects"></script>
<script type="text/javascript" src="js/lightbox.js"></script>
</head>

<body>



<div id="contendorGrande">
<h1><?=$congreso?> - Programa on-line</h1>
<h3><?=$fechaLugarCongreso?></h3>
<div id="contenedor1">
	<div class="img">
   <a href="<?=$programaOnline?>cronograma.php">
    <img src="imagenes/cronograma.gif" /></a></div>
	<div class="textos">
        <h2>Cronograma</h2>

    El cronograma proporciona una vista r�pida a las actividades del congreso.<br />
Nos muestra las sesiones detallando t�tulo y coordinadores, diferenciadas por colores seg�n el �rea asignada.<br />
Con un solo click sobre alguna de las actividades en el cronograma se puede visualizar con m�s detalle los intengrantes y sus presentaciones.</div>
<div class="bt_ingresar"><a href="<?=$programaOnline?>cronograma.php"><span>ingesar</span></a></div>
</div>

<div id="contenedor2">
	<div class="img">
   <a href="<?=$programaOnline?>programaExtendido.php">
    <img src="imagenes/programa_extendido.gif" /></a></div>
	<div class="textos">
         <h2>Programa extendido</h2>

    Este modo de presentaci�n de la informaci�n, la denominamos "Desarrollado" o "Programa Extendido".
En la parte superior de la pantalla, est�n localizados los d�as y salas correspondientes al congreso, donde con un simple click usted obtiene el detalle de las actividades de los mismos de manera extendida.</div>
<div class="bt_ingresar"><a href="<?=$programaOnline?>programaExtendido.php"><span>ingesar</span></a></div>
</div>

<div id="contenedor3">
	<div class="img">
    <a href="<?=$programaOnline?>listadoParticipantes.php?indice=A&indiceTL=A">
    <img src="imagenes/participantes.gif" /></a></div>
	<div class="textos">
         <h2>Listado de participantes</h2>

    Si desea conocer la participaci�n de alguien en particular o la suya propia puede recurrir al listado de participantes (Conf./Coord.)
que muestra las personas que intervienen en el congreso. Para facilitar la b�squeda, se divisan 2 listados: uno para los coordinadores, conferencistas, panelistas, etc; y otro para los autores y coautores de trabajos.
Al hacer un click sobre el participante deseado, nos despliega, de modo extendido, todas las actividades en las cuales participa.</div>
<div class="bt_ingresar"><a href="<?=$programaOnline?>listadoParticipantes.php?indice=A&indiceTL=A"><span>ingesar</span></a></div>
</div>

<div id="contenedor4">
    <div class="img">
    <a href="<?=$programaOnline?>programaExtendido.php">
    <img src="imagenes/buscar.gif" /></a></div>
	<div class="textos">
         <h2>Buscador</h2>

    En la esquina superior derecha, usted dispone de un BUSCADOR. El mismo busca la/s palabra/s ingresadas en todos los campos de nuestra base de datos, como por ejemplo: nombre, apellido, t�tulos, d�as, salas, horarios, c�digos de trabajos, etc.
El resultado se presenta de manera extendida.</div>
<div class="bt_ingresar"><a href="<?=$programaOnline?>programaExtendido.php"><span>ingesar</span></a></div>
</div>

<div id="imprimir">
<img src="imagenes/ico_imprimir.gif" width="58" height="18" />
<p>En la parte superior de la p&aacute;gina, cerca del buscador, usted dispone de un boton, IMPRIMIR, el cual le presenta de manera &quot;amigable&quot; la informaci&oacute;n actual de su pantalla. Con solo copiar y pegar puede mandar la informaci&oacute;n por mail o pegarla en un documento de texto.</p>
</div>

</div>
</body>
</html>
