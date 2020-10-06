<?
include "../envioMail_Config.php";
require "../clases/class.phpmailer.php";
$mailOBJ = new phpmailer();

$diahora = date("d-m-Y_H-i-s");

$asunto = $congreso."_".$diahora;		
$cuerpo = $diahora.'<br />Respaldo de Base de datos de '.$congreso.'.';

		$mailOBJ->From    		= "respaldogega@gmail.com";
		$mailOBJ->FromName 		= $congreso;
		$mailOBJ->Subject = $asunto;
		$mailOBJ->IsHTML(true);
		$mailOBJ->Body    = $cuerpo;
		$mailOBJ->Timeout=120;
		$mailOBJ->AddAttachment($_GET["archivo"]);
		$arrayMails = array('respaldogega@gmail.com');
		
		foreach($arrayMails as $cualMail){
			$mailOBJ->ClearAddresses();
			$mailOBJ->AddAddress($cualMail);
			if(!$mailOBJ->Send()){
				echo "<script>alert('Ocurrio un error al enviar el e-mail');</script>";
			}
		}
?>
<script>
alert("Se ha respaldado correctamente la base de datos.");
close();
</script>