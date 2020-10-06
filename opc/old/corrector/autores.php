<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache"); 
?>
<script src="js/autores.js"></script>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<style>
body{
margin: 0px;
background:#FFFFFF;
}
</style>

<?
require "clases/class.autores.php";
$autoresObj = new autores();

if($autoresObj->cuantosAutores>0){
	$autoresObj->setArrays();
}
?>
<body onLoad="cargaTotal()">
<form id="form1" name="form1" method="post" action="" style="display:inline;">
<div id="divPersonas"></div>

   <table width="350" border="0" align="center" cellpadding="4" cellspacing="0" bgcolor="#FFFFFF" class="textos">

    <tr>

      <td align="right" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td><font size="2"><div  align="center" id="divEliminarCoAutor"></div></font></td>

          <td width="50%" align="center"><font size="2">&nbsp;<a href="#"  name="mas" id="mas" onClick="agregarCoAutor()" style="color:#0000FF;">[+] Agregar 1 Autor más </a></font></td>
        </tr>

      </table></td>
    </tr>
  </table>
</form>
</body>
<?
if($autoresObj->cuantosAutores>0){
	for($i=1; $i<=$autoresObj->cuantosAutores; $i++){
	?>
	<script>
		agregarCoAutor();
	</script>
	<?
	}
	?>
	<script>
		seleccionarCampos(<?=$autoresObj->cuantosAutores?>);
	</script>
<?
}else{
?>
<script>
	agregarCoAutor();
</script>
<?
}
?>