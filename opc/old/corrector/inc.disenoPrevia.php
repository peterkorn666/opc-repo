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



<center>
<? if($cantidadPalabras > 350){ ?>
<div style="width:500px; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; margin:4px; background:#FFFFFF; padding:10px;" class="texto">
  

<?
	if($cantidadPalabras > 350){ 	
?>
	<div  style="background:#FFE2E1; border:solid 1px #FF0000; padding:5px; margin:5px; color:#FF0000;"><strong>Su resumen es demasiado largo</strong>.  <strong>Reduzcalo</strong>, de otra manera <strong>no será aceptado para enviar  </strong>por el sistema. <br />
	</div>
	<?
	}
}

?>
</div>

                          <div id="contedorTL">
						    <div id="titulo"><? echo remplazar($_SESSION["titulo"]); ?></div>
							 <div id="autores">
                              <?=$gestionAutores?>
                            </div>
                            <div id="texto">
                              <?
		echo remplazar($_SESSION["resumen"]);
	
		?>
                              <br />
							  
                            </div>
                          </div>
</center>

