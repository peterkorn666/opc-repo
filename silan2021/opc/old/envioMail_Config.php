<?php
//header('Content-Type: text/html; charset=UTF-8');
$congreso = "PEDIATRÍA 2019";
$fechaLugarCongreso = "";
$mail_congreso = "silan2020montevideo@gmail.com";
$paginaINFO = "click aqu&iacute;";
$paginaINFOlink = "http://silan2020.gegamultimedios.net/";
$paginaPrograma = $paginaINFOlink."opc/";
$paginaAbstract = $paginaPrograma."abstract/";
$abstract = "abstract/";
$fichaEs = "";
$fichaEn = "";
$alojamiento = "";
$consulta = "";
$programaOnline = $paginaPrograma."?page=cronoCompleto";
$tieneBanner = true;
$dirBanner = $paginaPrograma."imagenes/banner.jpg";
$rutaBanner = $paginaPrograma."imagenes/banner.jpg";
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
$cartaEstandar = '<table width="900px" border="0" align="center" cellpadding="10" cellspacing="0" >
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
$cartaEstandarTrabajos = '<table width="900px" border="0" align="center" cellpadding="10" cellspacing="0" >
<tr><td>
<table width="750px" border="0" align="center" cellpadding="20" cellspacing="0">
  <tr>
    <td><div align="center"><img src="<:dirBanner>" alt="<:congreso>" width="750"></div><br />
<div align="center"><font style="font-family: Verdana, Arial, Helvetica, sans-serif;font-weight: bold;color: #990000;">'.$congreso.'</font></div><br />
<div align="left"><br /><:cuerpo><:ubicacion><:pantalla></font></div>
<center>---------------------------------------------------------<br>
	  <!--Por más información <a href="http://www.cicat2016.org">'.$paginaINFO.'</a><br>-->
<br>
<!--Programa Online <a href="'.$programaOnline.'">click aqu&iacute;</a>.-->
	 </center></td>
  </tr>
</table>
</td></tr></table>';
?>