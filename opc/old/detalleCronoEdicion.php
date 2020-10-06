
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<script>
function mClk(src) {
		document.location.href = src;
}
</script>
</head>

<body>


<div style="border-top:1px solid #999999;">
	<div style="width:25%; float:right" align="right">
	<a class="linkIndice" href="javascript:mClk('programaExtendido.php?casillero=<?=$_POST["casillero"]?>&sala_=<?=$_POST["sala"]?>&dia_=<?=$_POST["dia"]?>')" >Ver Extendido</a> &nbsp; <a class="linkIndice" href="javascript:OcultarDiv('ventanaCrono')">Cerrar</a></div>
	<?

if($_POST["status"] == "1"){
?>
			  <div style="width:75%; float:left" align="left"><a style="text-decoration:none" href="javascript:modificar_casillero(<?=$_POST["casillero"]?>)">Editar</a>&nbsp;&nbsp;
			  <a style="text-decoration:none" href="javascript:eliminar_casillero(<?=$_POST["eliminar"]?>,'0',<?=$_POST["salagrupo"]?>)">Eliminar</a>
	</div>
<?
}
?>	
</div>

</body>
</html>
