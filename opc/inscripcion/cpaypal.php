<?php
session_start();
require("conexion.php");
require("clases/lang.php");
$lang = new Language("en");
$sql = $db->prepare("SELECT * FROM inscriptos WHERE id=?");
$sql->bindValue(1,base64_decode($_GET["key"]));
$sql->execute();
$row = $sql->fetch();

$status = $row["paypal_status"];
switch($status)
{
	case "Completed":
		$status = "<span style='color:darkgreen'><strong>".$row["paypal_status"]."</strong></span>";
	break;
	case NULL:
		$status = "Check later or press F5";
	break;
	default:
		$status = "<span style='color:red'><strong>".$row["paypal_status"]."</strong></span>";
	break;
}
?>
<html>
<header>
    <title><?=$lang->set["TXT_TITULO_CONGRESO"]?></title>
    <meta charset="utf-8">
    <link href="estilos.css" type="text/css" rel="stylesheet" />
</header>    
<body>
<?php
require("form_previa.php");
unset($_SESSION["inscripcion"]);
?>
</body>
</html>