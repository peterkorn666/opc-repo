<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache"); 

$tiempoDeVida_cookie = time() + 3600;

setcookie ("nombres", implode(",", $_SESSION["nombre"]) , $tiempoDeVida_cookie);
setcookie ("apellidos", implode(",", $_SESSION["apellido"]) , $tiempoDeVida_cookie);
setcookie ("instituciones", implode(",", $_SESSION["institucion"]), $tiempoDeVida_cookie);
setcookie ("mails", implode(",", $_SESSION["mail"]) , $tiempoDeVida_cookie);
setcookie ("paises", implode(",", $_SESSION["pais"]) , $tiempoDeVida_cookie);
setcookie ("ciudades", implode(",", $_SESSION["ciudad"]) , $tiempoDeVida_cookie);
setcookie ("lees", implode(",", $_SESSION["lee"]) , $tiempoDeVida_cookie);
setcookie ("inscriptos", implode(",", $_SESSION["inscripto"]) , $tiempoDeVida_cookie);

setcookie ("emailContacto", $_POST["emailContacto"] , $tiempoDeVida_cookie);
setcookie ("ApellidoContacto", $_POST["ApellidoContacto"] , $tiempoDeVida_cookie);
setcookie ("NombreContacto", $_POST["NombreContacto"] , $tiempoDeVida_cookie);
setcookie ("InstContacto", $_POST["InstContacto"] , $tiempoDeVida_cookie);
setcookie ("paisContacto", $_POST["paisContacto"] , $tiempoDeVida_cookie);
setcookie ("ciudadContacto", $_POST["ciudadContacto"] , $tiempoDeVida_cookie);
setcookie ("telContacto", $_POST["telContacto"] , $tiempoDeVida_cookie);

setcookie ("titulo", $_POST["titulo"] , $tiempoDeVida_cookie);
setcookie ("tema", $_POST["tema"] , $tiempoDeVida_cookie);
setcookie ("resumen", $_POST["resumen"] , $tiempoDeVida_cookie);

echo "<script>parent.document.getElementById('Guardando').style.visibility='hidden';</script>"
?>