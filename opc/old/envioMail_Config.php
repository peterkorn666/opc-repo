<?php
//header('Content-Type: text/html; charset=UTF-8');
$congreso = "FEPAL 2020";
$fechaLugarCongreso = "";
$mail_congreso = "fepal2020@gmail.com";
$paginaINFO = "click aqu&iacute;";
$paginaINFOlink = "http://fepal2020.programacientifico.info/opc/";
$paginaPrograma = "http://fepal2020.programacientifico.info/opc/";
$paginaAbstract = "http://fepal2020.programacientifico.info/opc/abstract/";
$abstract = "abstract/";
$fichaEs = "";
$fichaEn = "";
$alojamiento = "";
$consulta = "";
$programaOnline = "http://fepal2020.programacientifico.info/opc/?page=cronoCompleto";
$tieneBanner = true;
$dirBanner = "http://fepal2020.programacientifico.info/opc/imagenes/banner.jpg";
$rutaBanner = "http://fepal2020.programacientifico.info/opc/imagenes/banner.jpg";
/*$cartaEstandar = '<table width="750"  align="center" cellpadding="10" cellspacing="0" bordercolor="#000000"  style="border-bottom:1px  #000000 solid;border-right:1px  #000000 solid; border-left:1px  #000000 solid;">
  <tr bgcolor="#FFFFFF">
    <td bgcolor="#FFFFFF" align="center"><img src="<:dirBanner>" width="900" /></td></tr>
  <tr bgcolor="#FFFFFF">
    <td bgcolor="#FFFFFF">	
<div align="justify"><br><:cuerpo><br /></div>
<div align="justify"><br><:participaciones><br /></div>
	 <table width="100%" border="0" cellspacing="0" cellpadding="0" style="text-align:center; font-family:Arial, Helvetica, sans-serif">
  <tr>
    <td colspan="3">&nbsp; </td>
    </tr>
</table>
<br /><br />
</center></td>
</tr>
</table>';*/
//900, 750
$cartaEstandar = '
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Candara" rel="stylesheet" type="text/css">
</head>
<body>
	<table width="1000px" border="0" align="center" cellpadding="10" cellspacing="0" style="font-family: Candara,Calibri,Segoe,Segoe UI,Optima,Arial,sans-serif;">
		<tr><td>
		<table width="900px" border="0" align="center" cellpadding="20" cellspacing="0">
		  <tr>
			<td><div align="center"><img src="<:dirBanner>" alt="<:congreso>" width="900"></div><br />
		<div align="center"><font size="3" style="font-family: Candara, Verdana, Arial, Helvetica, sans-serif;font-weight: bold; color: #990000;">'.$congreso.'</font></div><br />
		<div align="left"><br /><:cuerpo></font></div>
		<center>---------------------------------------------------------<br><br>
		</center></td>
		  </tr>
		</table>
		</td></tr>
	</table>
</body>
</html>';
$cartaEstandarAutores = '<table width="900px" border="0" align="center" cellpadding="10" cellspacing="0" >
<tr><td>
<table width="750px" border="0" align="center" cellpadding="20" cellspacing="0">
  <tr>
    <td><div align="center"><img src="<:dirBanner>" alt="<:congreso>" width="750"></div><br />
<div align="center"><font style="font-family: Verdana, Arial, Helvetica, sans-serif;font-weight: bold;color: #990000;">'.$congreso.'</font></div><br />
<div align="left"><br /><:cuerpo></font></div>
<center>---------------------------------------------------------<br><br>
</center></td>
  </tr>
</table>
</td></tr></table>';
$cartaEstandarTrabajos = '
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Candara" rel="stylesheet" type="text/css">
</head>
<body>
	<table width="900px" border="0" align="center" cellpadding="10" cellspacing="0" style="font-family: Candara,Calibri,Segoe,Segoe UI,Optima,Arial,sans-serif;">
	<tr><td>
	<table width="750px" border="0" align="center" cellpadding="20" cellspacing="0">
	  <tr>
		<td><div align="center"><img src="<:dirBanner>" alt="<:congreso>" width="750"></div><br />
	<div align="center"><font size="3" style="font-family: Candara, Verdana, Arial, Helvetica, sans-serif;font-weight: bold;color: #990000;">'.$congreso.'</font></div><br />
	<div align="left"><br /><:cuerpo><:ubicacion><:pantalla></font></div>
	<center>---------------------------------------------------------<br>
		  <!--Por m�s informaci�n <a href="http://www.montevideo2020.fepal.org">'.$paginaINFO.'</a><br>-->
	<br>
	<!--Programa Online <a href="'.$programaOnline.'">click aqu&iacute;</a>.-->
		 </center></td>
	  </tr>
	</table>
	</td></tr></table>
</body>
</html>';

$cartaEstandarInscriptos = '<table width="900px" border="0" align="center" cellpadding="10" cellspacing="0" >
<tr><td>
<table width="750px" border="0" align="center" cellpadding="20" cellspacing="0">
  <tr>
    <td><div align="center"><img src="<:dirBanner>" alt="<:congreso>" width="750"></div><br />
<div align="center"><font style="font-family: Verdana, Arial, Helvetica, sans-serif;font-weight: bold;color: #990000;">'.$congreso.'</font></div><br />
<div align="left"><br /><:cuerpo></font></div>
<center>---------------------------------------------------------<br>
<br>
	 </center></td>
  </tr>
</table>
</td></tr></table>';
?>