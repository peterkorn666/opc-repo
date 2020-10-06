<?php
session_start();
header('Content-Type: text/html; charset=iso-8859-1');
include('conexion.php');
require ("clases/trabajosLibres.php");
$trabajos = new trabajosLibre();

$sePuedeImprimir=true;
$imprimir = "";

$tit_act_sin_hora = "Actividad sin horarios";



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
	-webkit-box-shadow: 0px 3px 48px -6px rgba(64,63,63,0.8);
-moz-box-shadow: 0px 3px 48px -6px rgba(64,63,63,0.8);
box-shadow: 0px 3px 48px -6px rgba(64,63,63,0.8);
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
	margin:20px 0 20px 260px;
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

.found{
	background-color:yellow;
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
		
		
		$sql = "SELECT * FROM congreso where Dia_orden='2' AND Sala_orden='12' ORDER by Casillero, Orden_aparicion ASC";
		$sin_resultados = true;
		if($_POST["buscar"]!=""){
			if(strpos($_POST["buscar"]," ") !== false){
				$busqueda = explode(" ",$_POST["buscar"]);
				$where = "WHERE ";
				$i = 0;
				foreach($busqueda as $b){
	     			 $where .= ($i==0?"":" OR ")." p.Nombre LIKE '%$b%'";
					 $where .= " OR p.Apellidos LIKE '%$b%'";
					 $where .= " OR t.titulo_tl LIKE '%$b%'";
					 $i++;
					 $busqueda_string[] = mb_strtolower($b, 'UTF-8');
				}
				$busqueda_string = array_unique($busqueda_string);
			}else{
				$where = "WHERE (p.Nombre LIKE '%".$_POST["buscar"]."%' OR p.Apellidos LIKE '%".$_POST["buscar"]."%') OR t.titulo_tl LIKE '%".$_POST["buscar"]."%'";
				$busqueda_string[] = mb_strtolower($_POST["buscar"], 'UTF-8');				
			}
			
			//Buscar en personas_trabajos_libres
			$sqlPers = "SELECT *, t.ID as ID_tl FROM personas_trabajos_libres as p JOIN trabajos_libres_participantes as l ON p.ID_Personas=l.ID_participante JOIN trabajos_libres as t ON l.ID_trabajos_libres=t.ID %s";
			$sqlPers = sprintf($sqlPers,$where);
			$queryPers = mysql_query($sqlPers,$con) or die(mysql_error());			
			
			while($rowPers = mysql_fetch_array($queryPers)){
				if($rowPers["tipo_tl"]=="Poster"){
					$ID_Casilleros[] = $rowPers["ID_casillero"];
					$trabajos_busqueda[] = $rowPers["ID_tl"];
				}
			}
			
			if(count($ID_Casilleros)>0){
				$ID_Casilleros = array_unique($ID_Casilleros);
				$whereT = "WHERE ";
				$t = 0;
				foreach($ID_Casilleros as $ids){
					$whereT .= ($t==0?"":" OR ")." Casillero='$ids'";
					$t++;
				}
				$sql = "SELECT * FROM congreso $whereT AND Sala_orden=12 ORDER by Casillero, Orden_aparicion ASC";
				$sin_resultados = false;
			}
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
        	require("inc/programaExtendidoPosters.php");
			
        }
		
		echo "</div>";
?>
</div>
</body>
</html>