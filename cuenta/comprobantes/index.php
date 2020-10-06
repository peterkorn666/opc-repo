<?php
if(file_exists($_GET['file'])){
	header('Location: '.$_GET['file']);
	die();
}
echo '<a href="../" style="text-decoration:none"><h2 align="center" style="color:red">Su comprobante no se ha guardado correctamente.<br>Intente cargarlo nuevamente desde su cuenta.</h2></a>';