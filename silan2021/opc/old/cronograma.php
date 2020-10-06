<?php
//require("inc/sesion.inc.php");
session_start();
//header('Content-Type: text/html; charset=iso-8859-1');
include('conexion.php');
include('envioMail_Config.php');
require ("clases/class.Traductor.php");
if (!isset($_SESSION["registrado"])){
	$_SESSION["registrado"]=false;
}
$dir = dirname(__FILE__);
include $dir.'/replacePngTags.php';


$tit_act_sin_hora = "Actividad sin horarios";
$estoyEnCrono = "siLoEstoy";

$sePuedeImprimir=true;



$size = GetImageSize($dirBanner);
$altura=$size[1]; 
if(@ereg("MSIE", $_SERVER["HTTP_USER_AGENT"])){
	$suma = 120;
}else{
	if($_SESSION["tipoUsu"]!=4){
		$suma = 95;
	}else{
		$suma = 70;
	}
}

function getInvitado($id,$con){
	$sql = "SELECT * FROM personas WHERE ID_Personas='$id'";
	$query = mysql_query($sql,$con);
	$row = mysql_fetch_object($query);
	$return = "";
	if($row->conferencista_invitado!=""){
		$return = " - ".$row->conferencista_invitado;
	}
	
	return $return;
}

function getViene($id,$casillero,$con){
	$sql = "SELECT * FROM actividades WHERE idPersonaNueva='$id' AND Casillero='$casillero'";
	$query = mysql_query($sql,$con) or die(mysql_error());
	$row = mysql_fetch_object($query);
	$return = "";
	if($_SESSION["LogIn"]=="ok"){
		if($row->confirmado=="1"){
			$return = "<strong style='color:red'>Confirmado</strong>";
		}
	}
	
	return $return;
}

function wordlimit($string, $length = 50, $ellipsis = "...")
{
    $words = explode(' ', $string);
    if (count($words) > $length)
    {
            return implode(' ', array_slice($words, 0, $length)) ." ". $ellipsis;
    }
    else
    {
            return $string;
    }
}

$altoAbsoluto = $altura + $suma;

$traductor = new traductor();
$traductor->setIdioma($_GET["idioma"]);


?>
<meta charset="utf-8">
<link href="estilos.css" rel="stylesheet" type="text/css">
<link href="font_awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
#Detalles{
	background-color:#CCCCFF;
	color:#000000;
	width: 630px;    	
	margin:0 auto 0 auto;
	border: 2px solid #CCC;    	
	padding: 0 20px 0 20px;  
	margin: 1px;
	padding: 1px;
	height: 15px;
	width: 630px;
	border: 1px solid #6633FF
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 11 px;
	font-weight: bold;
	font-style: italic;
	text-align: center;
	position: absolute; 
	/*bottom: 0; */
	margin: 0 auto;

	 top: expression( ( -0 - Detalles.offsetHeight + ( document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight ) + ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ) ) + 'px' );


left: expression( (  ( ignoreMe2 = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft ) ) +( ( document.body.offsetWidth - 630)/2 ) + 'px' );
}


body > #Detalles { text-align: center; position:fixed; top:100; left:100;  }


#x{	
	
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 10 px;
	font-weight: bold;
	text-align: center;
	text-decoration:none;
	color:#000066;
}
#x:hover{
font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 10 px;
	font-weight: bold;
	text-align: center;
	text-decoration:none;
	color:#FF0000;
}


.Estilo1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: italic;
	font-weight: bold;
	color:#990000;
}
#ventanaCrono1 {
	position:absolute;	left:320px;	margin-left:-100px;	top:102px;	width:400px;	height:400px;	
	/*border:solid 2px #000000;*/
	/*background:#FFFFFF;*/
}
#DivContenidoCasilleroGlobo{
width:500px;
height:241px;
overflow:auto;
}
#DivEdicionCasilleroglobo{
height:16px;
width:500px;
font-family:Arial, Helvetica, sans-serif;
font-size:12px;

}
-->
</style>

<script language="JavaScript">

function cerrarDetalles(){
document.getElementById('Detalles').style.visibility='hidden';
}

var activarCasillero = 1;

function mOvr(src,clrOver) {
	if (!src.contains(event.fromElement)) {
		src.style.cursor = 'pointer';
		src.bgColor = clrOver;
	}
}

function mOut(src,clrIn) {
	if (!src.contains(event.toElement)) {
		src.style.cursor = 'default';
		src.bgColor = clrIn;
	}
}

function mClk(src) {
	if(activarCasillero==1){
		document.location.href = src;
	}
}


function sobreCasillero(cual){
	if(activarCasillero==1){
		document.getElementById(cual).style.background= "#ffffff";
		//document.getElementById(cual).style.cursor = 'pointer';
	}
	
 activarCasillero = 1;
}

function fueraCasillero(cual, col){
	
	if(col.substring(0,1) == "#"){
			document.getElementById(cual).style.background= col;
			
	}else{
			document.getElementById(cual).style.background = "url('img/patrones/"+col+"')";
	}
	
}
function activ(){
	activarCasillero = 0;
}
function desactiv(){
	activarCasillero = 1;
}

</script>
<script language="javascript" type="text/javascript" src="js/ajax.js"></script>
<script src="js/ajax.js"></script>
<script src="js/menuEdicion.js"></script>
<script src="js/drag_drop.js"></script>
<?


$dia_ = $_GET["dia_"];
$sala_ = $_GET["sala_"];



?>
<body  bgcolor="#666666"  leftmargin="0" topmargin="0" bgproperties="fixed" marginwidth="0" marginheight="0" style="background-color:#666666;">
<? 
if($_SESSION["tipoUsu"]==1){
	include "inc/vinculos.inc.php";
}
include "menu.php";
 ?>
 
<!-- //Siderbar -->
<div id='container-sidebar'>
	<div id='sidebar-opt'>		
		<div class="btn-group sidebar-opt-buttons" data-toggle="buttons">
                <label class="btn btn-default">
                    <input type="radio" name="option-search" value="1" /> Congreso
                </label> 
                <label class="btn btn-default">
                    <input type="radio" name="option-search" value="2" /> Trabajos Libres
                </label>
         </div>		
		<label style='color:white'>Palabra clave</label>
		<input type="text" class="form-control" name="search_congreso">
	</div>	
	<div id="result_search_congreso" style="overflow:auto">				
	</div>	
</div>
<div id="ajax-state">
	<div id="ajax-state-message">
		Hubo un error al actualizar los conferencistas.
    </div>
</div>
<div id='congreso' style='position:relative'>

<div>

<?php		

if(!isset($_SESSION["LocalizadoCrono"])){

	$sql = "SELECT Crono, ultimoIngreso  FROM estadisticas LIMIT 1;";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
		$ultimoValor = $row["Crono"];
		$ultimoIngreso = $row["ultimoIngreso"];
	}

	$nuevoValor	= $ultimoValor + 1;

	if($ultimoIngreso == 10){
		$ultimoIngreso = 1;
	}else{
		$ultimoIngreso = $ultimoIngreso + 1;
	}

	$sql1 = "UPDATE estadisticas SET Crono= $nuevoValor, Tiempo = '" . date("d/m/Y  H:i") . "',ultimoIngreso=  $ultimoIngreso  LIMIT 1 ;";
	mysql_query($sql1,$con);

	$sql2 = "UPDATE estadisticasUltimos10 SET  WHERE ID=$ultimoIngreso  LIMIT 1 ;";
	mysql_query($sql2,$con);

	$_SESSION["LocalizadoCrono"]=true;

}
//$_SESSION["paraImprimir"]=$paraImprimi;
//echo $altoAbsoluto;
?>
<script language="javascript" type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<script src="js/slide.js" type="text/javascript"></script>
<script type="text/javascript">
function cargarCrono(dia,sala)
{
	$.ajax({
	  url: 'casillero.php',
	  type: 'GET',
	  data: 'dia_='+dia+'&sala_='+sala,
	  success: function(data) {
		$('#congreso').html(data);
		 position_updated = false; //flag bit
		/*$(".sort_conferencistas").sortable({ 
            handle : 'i', 
			cursor: "move",
   			helper: "clone",
			//connectWith: ".sort_conferencistas",
			scroll:false,
			start: function(event,ui){
				$(".div_casillero").css("overflow","");
				$(".trabajos_crono").hide();
				$(".sort_conferencistas").css({"border":"1px solid","padding":"2px"});
			},
            update : function (event,ui) { 
				position_updated = !ui.sender; //if no sender, set sortWithin flag to true
                var $lis = $(this).children('li');
				$("#ajax-state").fadeIn("fast");
				$(".cargando-ajax").fadeIn("fast");
				//alert(ui.item.closest("ul").data("casillero"));
				$lis.each(function() {
					var $li = $(this);
					var order = $(this).index() + 1;
					$("#ajax-state-message").load("confOrder-ajax.php?nuevo_id="+$li.data("id")+"&order="+order,function(msg){
						if(msg=="Conferencistas actualizados correctamente.")
						{
							$("#ajax-state #ajax-state-message").removeClass();
							$("#ajax-state #ajax-state-message").addClass("success");
						}
						else
						{
							$("#ajax-state #ajax-state-message").removeClass();
							$("#ajax-state #ajax-state-message").addClass("error");
						}
					});
				});
               //$("#info").load("process-sortable.php?"+order); 
            } ,
       		stop: function(event, ui) {
				if (position_updated) {
					position_updated = false;
				}
				$(".div_casillero").css("overflow","auto");
				setTimeout(function(){$("#ajax-state").fadeOut("fast")},1000);
				setTimeout(function(){$(".cargando-ajax").fadeOut("fast");},1000);
				setTimeout(function(){$("#ajax-state #ajax-state-message").removeClass()},1500);
				$(".sort_conferencistas").css({"border":"0px solid","padding":"0px"});
				$(".trabajos_crono").show();
				
			},
			receive: function(event, ui) {
				//$("#info").load("process-sortable.php?"+order); 
				$("#ajax-state").fadeIn("fast");
				$(".cargando-ajax").fadeIn("fast");
				
				id = ui.item.data("id");
				id_viejo = ui.sender.closest("ul").data("casillero");
				id_nuevo = ui.item.closest("ul").data("casillero");
				
				var $lis = $(this).children('li');
				$("#ajax-state-message").load("confOrder-ajax.php?id="+id+"&nuevo_casillero="+id_nuevo+"&viejo_casillero="+id_viejo+"&id_persona="+ui.item.data("persona"),function(msg){
					if(msg=="Conferencistas actualizados correctamente.")
					{
						$("#ajax-state #ajax-state-message").removeClass();
						$("#ajax-state #ajax-state-message").addClass("success");
					}
					else
					{
						$("#ajax-state #ajax-state-message").removeClass();
						$("#ajax-state #ajax-state-message").addClass("error");
					}
				});
				$lis.each(function() {
					var $li = $(this);
					var order = $(this).index() + 1;
					$("#ajax-state-message").load("confOrder-ajax.php?nuevo_id="+$li.data("id")+"&order="+order,function(msg){
						if(msg=="Conferencistas actualizados correctamente.")
						{
							$("#ajax-state #ajax-state-message").removeClass();
							$("#ajax-state #ajax-state-message").addClass("success");
						}
						else
						{
							$("#ajax-state #ajax-state-message").removeClass();
							$("#ajax-state #ajax-state-message").addClass("error");
						}
					});
				})
			}

        }).disableSelection();*/
		
	  },
	  error: function(e) {
		//called when there is an error
		//console.log(e.message);
	  }
	});
}
var dia_ = '<?=$dia_?>',
sala_ = '<?=$sala_?>';
$(document).ready(function(e) {
    cargarCrono(dia_,sala_);
});
</script>
<script language="javascript" type="text/javascript" src="js/cronograma.js"></script>