<?
function remplazar($donde){

	$valor = str_replace("<p>", "" , $donde);
	$valor = str_replace("</p>", "" , $valor);

	$valor = str_replace("<u>", "" , $valor);
	$valor = str_replace("</u>", "" , $valor);

	$valor = str_replace("<strong>", "" , $valor);
	$valor = str_replace("</strong>", "" , $valor);

	$valor = str_replace("<span>", "" , $valor);
	$valor = str_replace("</span>", "" , $valor);
	
	$valor = str_replace("'", "´" , $valor);
	$valor = str_replace("\'", "´" , $valor);
	$valor = str_replace("\\'", "´" , $valor);
	$valor = str_replace("\\\'", "´" , $valor);
	$valor = str_replace("\\\\'", "´" , $valor);
	$valor = str_replace("\\\\\'", "´" , $valor);
	$valor = str_replace("\\\\\\'", "´" , $valor);
		
	$valor = str_replace("\´", "´" , $valor);	
	
	$valor = str_replace('<p class="""MsoNormal""">', "" , $valor);	
	$valor = str_replace('<p class="MsoBodyText2">', "" , $valor);	
	$valor = str_replace('<p class="MsoNormal">', "" , $valor);	
	$valor = str_replace('<p align="center" class="MsoNormal">', "" , $valor);	

	$valor = addslashes($valor);

	return $valor;

}

function str_word_count_p($str){

	$valor = split(" ", $str);
	$valor = count($valor);
	
	return $valor;
	
}


include "inc.gestionAutores.php";

if(($gestionAutores == "<br><i></i>")||($gestionAutores == "")){
	?>
	<script>document.location.href='index.php?error=2';</script>
	<?
}

$cantidadPalabras=str_word_count_p(trim($_SESSION["resumen"]));
?>


<? /*
<div style="width:500px; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; margin:4px; background:#FFFFFF; padding:10px;" class="texto">
 if ($cantidadPalabras < 250){ ?>
Cantidad de caracteres usados: <font size="3"><b><?=$cantidadPalabras?></b></font>
<?
}*/
?>
<center>
<?
if($cantidadPalabras > 350){ 	
?>
    <div  style="background:#FFE2E1; border:solid 1px #FF0000; padding:5px; margin:5px; color:#FF0000;width:500px; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif;"><b>Su resumen supera el limite de 3000 caracteres, por lo que no podra ser enviado</b>. Intente acortarlo. Gracias<br />
    </div>
<?
}
?>

     <div id="contedorTL">
		<div id="tema"><?=$_SESSION["tema"]?></div>        
		<div id="titulo"><span style="text-transform: uppercase;"><? echo remplazar($_SESSION["titulo"]); ?></span></div>
		<div id="autores"><?=$gestionAutores?></div>
        <div id="texto"><?		echo remplazar($_SESSION["resumen"]);?><br /></div>
		<div id="texto"><?		echo "<em>Palabras Clave:".remplazar($_SESSION["keywords"])."</em>";?></div>
    </div>
</center>

