<?
$direccion = array("../programa/img/","../programa/cv/","../programa/tl/","../programa/envioTLS/","../programa/arhivosMails/","../programa/img/img.php","../programa/img/img1.php","../programa/img/img2.php","../programa/img/img3.php","../programa/envioTLS/envioMasivoTLS.txt", "../programa/arhivosMails/envioMasivoTLS.txt","envioMasivoAutores.txt","envioMasivoParticipantes.txt","envioMasivoTLS.txt","envioMasivoTrabajos.txt","../programa/abstract/milog.txt");

foreach ($direccion as $dir) {
		chmod($dir, 0777);
		if (substr(sprintf('%o', fileperms($dir)), -4)!="0777") {
			echo "El archivo ".$dir." no cambio de permisos<br>";
		}
		else {
			echo "El archivo ".$dir." cambio de permiso a ".substr(sprintf('%o', fileperms($dir)), -4)."<br>";
		}
}

echo "LOS PERMISOS HAN SIDO CAMBIADOS";

?>