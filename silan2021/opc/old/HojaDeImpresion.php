<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");
?>
<style>
	.CronoDia{
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
		font-weight: bold;
		color: #000000;
	}
	.CronoSala{
		font-size: 10px;
		font-weight: bold;
		color: #FFFFFF;
		font-family: Arial, Helvetica, sans-serif;
	}
	.CronoHora{
		font-family: Arial, Helvetica, sans-serif;
		font-size: 9px;
		color: #000000;
		text-align: right;
	}
	.CronoTipoAct{
		font-family: Arial, Helvetica, sans-serif;
		font-size: 9px;
		font-weight: bold;
		color: #000000;
	}
.CronoTituloAct{
		font-family: Arial, Helvetica, sans-serif;
		font-size: 11px;
		text-align: justify;
}
.CronoAutor{
		font-family: Arial, Helvetica, sans-serif;
		font-size: 11px;
		text-align: justify;
}
.ProgramaDia{
	

}
.ProgramaHora{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.ProgramaTipoAct{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
}
.ProgramaSala{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px; 
}
.ProgramaAreaTematica{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 8px;
}
.ProgramaTituloTrabajo{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
}
.ProgramaAutor{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	text-indent: 100px;

}
	.botones_tl {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	text-decoration: none;
	background-color:#BFAFC7;
}
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 11px;
}
.textos {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
</style>
<? 
function reemplazar($cual){
	//borro todo lo feo
	$cual = str_replace('<p align="justify">', "" , $cual);
	return $cual;
}

?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?
echo reemplazar($_SESSION["paraImprimir"]);
?>
</body>
<script language="javascript">
// window.print() ; 
</script>