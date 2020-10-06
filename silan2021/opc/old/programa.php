<?php
session_start();
header('Content-Type: text/html; charset=iso-8859-1');
//include('inc/sesion.inc.php');
include('conexion.php');
include("inc/validarVistas.inc.php");
require ("clases/trabajosLibres.php");
$trabajos = new trabajosLibre();

$sePuedeImprimir=true;
$imprimir = "";

$tit_act_sin_hora = "Actividad sin horarios";

$dia_ = $_GET["Dia"];
$sala_ = $_GET["Sala"];

if($dia_==""){
	$sqlDia = "SELECT Dia_orden FROM congreso WHERE Dia_orden<>'' ORDER BY Dia_orden ASC LIMIT 1;";
	$queryDia = mysql_query($sqlDia, $con) or die(mysql_error());
	$rowDia = mysql_fetch_array($queryDia);
	
	$dia_ = $rowDia["Dia_orden"];
}

if($sala_==""){
	$sqlSala = "SELECT Sala_orden FROM congreso where Dia_orden='" . $dia_ . "' order by Sala_orden Desc;";
	$querySala = mysql_query($sqlSala, $con) or die(mysql_error());
	$rowSala = mysql_fetch_array($querySala);
	
	$sala_ = $rowSala["Sala_orden"];
}

function getNombreDia($dia_orden){
	global $con;
	
	if($dia_orden==""){
		$dia_orden = 2;
	}
	
	$sql = "SELECT * FROM dias WHERE Dia_orden='$dia_orden'";
	$query = mysql_query($sql,$con);
	$row = mysql_fetch_array($query);
	return $row["Dia"];
}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>CAU 2014</title>
<link type="text/css" rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
<style type="text/css">
body{
	background-color:#E5EEF4;
}
.container{
	background-color:white;
}
.container .rowBtns{
	text-align:center;
	margin-left:90px;
}
.container .rowBtns div{
	margin:5px;
}
.container .rowBtns div a{
	color:white;
	font-weight:bold;
	display:block;
	padding:10px;
	background-color:#0097B7;
}
.container .rowDias div a{
	background-color:#467DB5;
	color:white;
	font-weight:bold;
	display:block;
	padding:10px;
}
.container .rowDias div a:hover{
	text-decoration:none;
	background-color:#6A9AC9;
}
.container .rowBtns div a:hover{
	text-decoration:none;
	background-color:#1EB1CE;
}
.container .btn_dias{
	text-align:center;
}
.container .rowDias{
	margin-left:60px;
	margin-top:30px;
}
.container .rowDias div:first-child{
	margin-bottom:20px;
}

.titulo_actividad{
	font-size:16px;
	font-weight:bold;
}

.line{
	margin:10px 0 10px 0;
	border-bottom:1px dashed #e5e5e5;
}

.hora_conf{

}

.conferencista{
	margin-bottom:8px;
}


.search{
	margin:20px 0 20px 110px;
}
.search input[type='text']{
	font-size:24px;
	height:auto !important;
}
.search button[type='submit']{
	padding:13px;
	height:auto !important;
}
.programa{
	width:85%;
	margin:0 auto;
}
#loading{
	position:absolute;
	width:1050px;
	height:92%;
	padding:10% 0 0 23%;
	font-size:36px;
	background:url(images/bg_white.png);
	z-index:5;
	display:none;
}
div[class*="resumen_tl"]{
	display:none;
}
div[class*="resumen_tl"] .col-xs-12 div.resumen_container{
	background-color:#FBFAEA;
	border:1px dotted #ff9966;
	padding:10px;
}
.div_resumen{
	font-size:12px;
	border-bottom:1px dashed #666666;
	margin-bottom:5px;
}

</style>
<script type="text/javascript" src="js/jquery.1.4.2.js"></script>
<script type="text/javascript">
$(document).ready(function(e) {
    $(".rowBtns a").click(function(){
		$("#loading").fadeIn("slow");
	})
	$(".ver_resumen").click(function(e){
		e.preventDefault();
		var id = $(this).attr("data-rel");
		$(".resumen_tl"+id).stop(true,true).slideToggle("slow");
	})
});
	
</script>
</head>

<body>
<div class="container">
	<div class="row">
    	<div class="col-xs-6 search">
        	<form action="<?=$_SERVER["PHP_SELF"]?>" method="post">
                <div class="input-group">
                  <input type="text" name="buscar" value="<?=$_POST["buscar"]?>" class="form-control">
                  <span class="input-group-btn">
                    <button type="submit" class="btn btn-success">Buscar</button>
                  </span>
                </div><!-- /input-group -->
            </form>
        </div>
        <div class="col-xs-6"></div>
    </div>
	<div class="row rowBtns">
    	<div class="col-xs-2"><a href="?type=plenaria&Dia=2">Plenaria</a></div>
        <div class="col-xs-2"><a href="?type=cc">Curso CAUREP</a></div>
        <div class="col-xs-2"><a href="?type=s">SIUP</a></div>
        <div class="col-xs-2"><a href="?type=cp">Cursos Paralelos</a></div>
        <div class="col-xs-2"><a href="?type=t">Trabajos</a></div>
    </div>
<?php
if($_GET["type"]=="plenaria" && $_GET["filtro"]==""){
?>    
	<div class="row rowDias">
    	<div class="col-xs-12"><h1>PLENARIA <small><?=getNombreDia($_GET["Dia"])?></small></h1> </div>
    	<?php
			$sqlsDias = mysql_query("SELECT DISTINCT(Dia),Dia_orden FROM congreso WHERE Dia_orden<>'' AND Dia_orden<>1 ORDER BY Dia_orden ASC",$con) or die(mysql_error());
			while($rowsDia = mysql_fetch_array($sqlsDias)){
		?>
    			<div class="col-xs-2 btn_dias"><a href="?type=plenaria&Dia=<?=$rowsDia["Dia_orden"]?>"><?=$rowsDia["Dia"]?></a></div>
        <?php
			}
		?>
    </div>
<?php
}
		
		switch($_GET["type"]){
			case "plenaria":
				$where = "Dia_orden='".$_GET["Dia"]."' AND (Sala_orden='1' or Sala_orden='3')";
			break;
			case "cc":
				$where = "(Dia_orden='1' or Dia_orden='2') AND Sala_orden='5'";
			break;
			case "s":
				$where = "Sala='SIUP Río - C'";
			break;
			case "cp":
				$where = "Tipo_de_actividad='Curso Paralelo'";
			break;
			case "t":
				$where = "Tipo_de_actividad='Presentación de Videos' OR Tipo_de_actividad='Presentación de E-Poster' OR Tipo_de_actividad='Presentación de trabajos Orales' OR Tipo_de_actividad='Sesión Científica SIUP'";
			break;
			default:
				$where = "Dia_orden='2' AND Sala_orden='1'";
			break;
		}
		
		
		$sql = "SELECT * FROM congreso where $where ORDER by Casillero, Orden_aparicion ASC";
		
		if($_POST["buscar"]!=""){
			if(strpos($_POST["buscar"]," ") !== false){
				$busqueda = explode(" ",$_POST["buscar"]);
				$where = "WHERE ";
				$i = 0;
				foreach($busqueda as $b){
					$where .= ($i==0?"":" OR ")." Nombre LIKE '%$b%'";
					 $where .= " OR Apellidos LIKE '%$b%'";
					 $i++;
				}
				
			}else{
				$where = "WHERE Nombre LIKE '%".$_POST["buscar"]."%' OR Apellidos LIKE '%".$_POST["buscar"]."%'";
			}
			
			//Buscar en conferencistas
			$sqlConf = "SELECT * FROM personas %s";
			$sqlConf = sprintf($sqlConf,$where);
			$queryConf = mysql_query($sqlConf,$con) or die(mysql_error());			
			$rowConf = mysql_fetch_array($queryConf);
			
			$sql = "SELECT * FROM congreso $where ORDER by Casillero, Orden_aparicion ASC";
		}
        $rs = mysql_query($sql,$con) or die(mysql_error());
        
		
		//Div Crono
		echo "<div class='programa'>";
		echo '<div id="loading">Cargando...</div>';
		$tA = 0;
		while ($row = mysql_fetch_array($rs)){
        	$_SESSION["buscar"] = false;
			
			if(($row["Trabajo_libre"]==1) && ($tA==0)){
				$sqlAutoresT = "SELECT * FROM trabajos_libres ORDER BY numero_tl";
				$queryAutoresT = mysql_query($sqlAutoresT,$con) or die(mysql_error());
				
				while($rowAutoresT = mysql_fetch_array($queryAutoresT)){
					$sqlAutoresL = "SELECT * FROM trabajos_libres_participantes as l JOIN personas_trabajos_libres as p ON l.ID_participante=p.ID_Personas WHERE ID_trabajos_libres='".$rowAutoresT["ID"]."'";
					$queryAutoresL = mysql_query($sqlAutoresL,$con) or die(mysql_error());
					while($rowAutoresL = mysql_fetch_array($queryAutoresL)){
						$nombreAutores[$rowAutoresT["ID"]][] = $rowAutoresL["Nombre"];
						$apellidoAutores[$rowAutoresT["ID"]][] = $rowAutoresL["Apellidos"];
						$institucionAutores[$rowAutoresT["ID"]][] = $rowAutoresL["Institucion"];
						$leeAutores[$rowAutoresT["ID"]][] = $rowAutoresL["lee"];
						$inscriptoAutores[$rowAutoresT["ID"]][] = $rowAutoresL["inscripto"];
					}
				}
				
				
				$tA++;
			}
        	require("inc/programaExtendido.php");
			
        }
		
		echo "</div>";
?>
</div>
</body>
</html>
<?php
$_SESSION["paraImprimir"]=$imprimir;
?>