<?php
session_start();
if($_SESSION["Login"]==""){
	header("Location: login.php");
	die();
}
header('Content-Type: text/html; charset=UTF-8');
require("../conexion.php");
require("../clases/trabajosLibres.php");
$trabajos = new trabajosLibre();
require("../envioMail_Config.php");
$rg = "";
if($_POST["tematicas"]!="")
{
	//$rg = " AND tematicas RLIKE '\"[[:<:]]".$_POST["tematicas"]."[[:>:]]\"'";
	$rg = " AND tematicas RLIKE '\"[[:<:]]".$_POST["tematicas"]."[[:>:]]\"'";
}
if($_GET["sn"]==1){
	$rg = " AND acepta_evaluador is NULL";
}
$sql = "SELECT * FROM evaluadores WHERE nivel<>1 $rg ORDER BY id ASC";
$query = $con->query($sql);
if(!$query){
	die($con->error);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Adjudicar trabajos</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(e) {
   $(".trabajos").live("keyup",function(){
		if(this.value==" "){
			this.value = "";
			return false;
		}
		var caracter = /^([0-9])*$/;
		if (!this.value.match(caracter)){
			this.value = "";
			return false;
		}
   });
   $("#tn").click(function(event){
	   event.preventDefault();	 
	   if($("input:checkbox").is(":checked")){
	   		$("input:checkbox").attr("checked",false);
	   }else{
		    $("input:checkbox").attr("checked",true);
	   }
	   
   });
   
   $("#frameclose").live("click",function(event){
	   event.preventDefault();
	   $(".frame").css("display","none");
	   $("#banner").css("margin-top","0px");
   })
   
   $(".envioMail").live("click",function(event){
	   event.preventDefault();
	   $(".trabajos").remove();
	   $("#form1").removeAttr("target","frame");
	   $("#form1").attr("action","envio/index.php");
	   $("#form1").submit();
   })
   
   $(".elimiarTL").live("click",function(event){
	   event.preventDefault();
	   var numero_tl = this.id.split("/");
	   if(confirm("\xBFQuiere eliminar el trabajo "+numero_tl[0]+" para este evaluador?")){
		   $("#framediv").css("display","block");
		   $("#form1").attr("target","frame");
		   $("#form1").attr("action","eliminarTLevaluadores.php?key="+this.id);
		   $("#form1").submit();
	   }
   })
  
var $top1 = $('#persist').offset().top + 20;   
var $mid1 =  Math.floor($(window).height() / 2);
  
$(window).scroll(function(){   

		if ($(window).scrollTop()>$top1){
		 $('#persist').addClass('floater');
		}else{
		 $('#persist').removeClass('floater');
		}
		 
});
 
  
});
</script>
</head>

<body>
<form method="post" name="form1" id="form1">
<table width="900" border="0" cellspacing="0" cellpadding="5" align="center" id="tablaevaluadores">
  <tr>
    <td align="center"><div class="frame" id="framediv" align="right" style="display:none"><a href="#" id="frameclose">cerrar</a><iframe name="frame" width="390" id="frame" frameborder="0" title="Click para cerrar" ></iframe><div style="clear:both"></div></div><img src="<?=$rutaBanner?>" alt="banner" width="900"/></td>
  </tr>
   <?php
  	$sqlTrabajos = "SELECT * FROM trabajos_libres WHERE estado<>3 ORDER BY area_tl";
	$queryTrabajos = $con->query($sqlTrabajos);
	if(!$queryTrabajos){
		die($con->error);
	}
  ?>
  <tr>
    <td bgcolor="#FFFFFF">Trabajos sin asignar: 
    	<?
			$tlS = 0;
			while($rowTrabajos = $queryTrabajos->fetch_object()){
				$sqlTrabajosLibres = "SELECT DISTINCT(numero_tl) FROM evaluaciones WHERE numero_tl='$rowTrabajos->numero_tl'";
				$queryTrabajosLibres = $con->query($sqlTrabajosLibres);
				if(!$queryTrabajosLibres){
					die($con->error);
				}
				$existe = $queryTrabajosLibres->num_rows;
				if($existe==0){
					$tlS = $tlS+1;
					
					if($rowTrabajos->area_tl!=$areas_viejo){
						echo "<br><br><span style='color:red'>".$trabajos->areaID($rowTrabajos->area_tl)->Area_es."<br></span> ";
					}
					//if($rowTrabajos->area_tl==$areas_viejo){
						echo $rowTrabajos->numero_tl." - ";//($rowTrabajos->contacto_pais)
				//	}
					if($rowTrabajos->area_tl!=$areas_viejo){
						//echo "<br>";
					}
					
					$areas_viejo = $rowTrabajos->area_tl;
				}
			}
		?>
    </td>
    </tr>
    <tr>
    	<td colspan="3" bgcolor="#FFFFFF">
        	<!--Filtrar por áreas<br />
        	<select name="tematicas" onchange="form1.submit()">
            	<option value=""></option>
                <?php
				$sqlT = $con->query("SELECT * FROM areas_trabjos_libres ORDER BY id");
				while($row = $sqlT->fetch_array())
				{
					$chkt = "";
					if($row["id"]==$_POST["tematicas"])
						$chkt = "selected";
					echo '<option value="'.$row["id"].'" '.$chkt.'>'.$row["Area_es"].'</option>';
				}
				?>
            </select>-->
        </td>
    </tr>
  <tr>
    <td bgcolor="#FFFFFF">
    <table width="100%" border="0" cellspacing="2" cellpadding="1">
      <tr>
        <td colspan="13" align="center" valign="top"> <table width="900" border="0" cellspacing="2" cellpadding="1">
          <tr>
            <td width="17"><a href="#" id="tn">X</a></td>
            <td width="27"><strong>ID</strong></td>
            <td width="143"><strong>Nombre</strong></td>
            <td width="143"><strong>Trabajos Nuevos</strong></td>
            <td width="122">Adjudicar por &aacute;rea</td>
            <td width="122"><strong>Trabajos<br />
              adjudicados</strong></td>
            <td width="124"><strong>Trabajos<br />
              Revisados</strong></td>
            <td width="48"><strong>Clave</strong></td>
            <td width="95"><a href="#" class="envioMail">Enviar Email</a></td>
          </tr>
<?php
	while($row = $query->fetch_object()){
		$bg = "";
		if($row->acepta_evaluador=="No")
			$bg = "background-color:red";
?>
      <tr>
        <td width="27" align="center" style="border-bottom:1px dashed black;<?=$bg?>"><input type="checkbox" name="select[]" value="<?=$row->id?>" class="checkbox" /></td>
        <td width="29" style="border-bottom:1px dashed black"><?=$row->id?></td>
        <td width="74" style="border-bottom:1px dashed black"><a href="crearEvaluador.php?key=<?=$row->id?>" target="_blank"><?=$row->nombre?></a></td>
        <td width="196" align="left" style="border-bottom:1px dashed black"><input type="text" maxlength="4" style="width:60px;" name="trabajos<?=$row->id?>[]" class="trabajos" /><div id="moreinput_<?=$row->id?>"></div><img src="imagenes/mas.png" width="16" height="16" alt="mas" onclick="addinput(<?=$row->id?>)" style="cursor:pointer" /></td>
        <td width="123" align="left" valign="top" style="border-bottom:1px dashed black">
        	<select name="por_area<?=$row->id?>" style="width:70px">
            	<option value=""></option>
                <?php
					$sqlG = $con->query("SELECT * FROM areas_trabjos_libres ORDER BY Area_es");
					while($rowG = $sqlG->fetch_array()){
						echo '<option value="'.$rowG["id"].'">'.$rowG["Area_es"].'</option>';
					}
				?>
            </select>
        </td>
        <td width="123" align="left" valign="top" style="border-bottom:1px dashed black" nowrap="nowrap">
        <?
			$sqlEvaluaciones = "SELECT * FROM evaluaciones WHERE idEvaluador='$row->id'";
			$queryEvaluaciones = $con->query($sqlEvaluaciones);
			if(!$queryEvaluaciones){
				die($con->error);
			}
		?>
		<?
		$h = 1;
			while($rowEvaluaciones = $queryEvaluaciones->fetch_object()){
				if($rowEvaluaciones->estadoEvaluacion=="" and $rowEvaluaciones->puntajeTotal==0 and $rowEvaluaciones->ev_global==""){
					echo "<a href='#' class='elimiarTL' id='$rowEvaluaciones->numero_tl/$rowEvaluaciones->idEvaluador'>".$rowEvaluaciones->numero_tl."</a>";
					if($h==2)
					{
						echo "<br>";
						$h = 0;
					}
					if($h!=0)
						echo " - ";
					$h++;
				}
			}
		?></td>
        
        <td width="215" style="border-bottom:1px dashed black">&nbsp;&nbsp;&nbsp;          <?
		$sqlEvaluaciones2 = "SELECT * FROM evaluaciones WHERE idEvaluador='$row->id'";
		$queryEvaluaciones2 = $con->query($sqlEvaluaciones2);
		if(!$queryEvaluaciones2){
			die($con->error);
		}
		$rowEvaluaciones2 = $queryEvaluaciones2->fetch_object();
		
			
			
			$sqlEvaluaciones2 = "SELECT * FROM evaluaciones WHERE idEvaluador='$row->id'";
			$queryEvaluaciones2 = $con->query($sqlEvaluaciones2);
			if(!$queryEvaluaciones2){
				die($con->error);
			}
			while($rowEvaluaciones2 = $queryEvaluaciones2->fetch_object()){
				if($rowEvaluaciones2->estadoEvaluacion!="" or $rowEvaluaciones2->puntajeTotal!=0 or $rowEvaluaciones2->ev_global!=""){
						$sqlTrabajosEstado = "SELECT * FROM trabajos_libres WHERE numero_tl='$rowEvaluaciones2->numero_tl'";
						$queryTrabajosEstado = $con->query($sqlTrabajosEstado);
						$rowTrabajosEstado = $queryTrabajosEstado->fetch_object();
							
							$colorEstado = "#ffff";
							if($rowTrabajosEstado->estado=="3"){
								$colorEstado = "#ccc";
							}
					echo "<a href='#' class='elimiarTL' style='background-color:$colorEstado' id='$rowEvaluaciones2->numero_tl/$rowEvaluaciones2->idEvaluador'>".$rowEvaluaciones2->numero_tl."</a> - ";
				}
			}
		?></td>
        <td width="20" style="border-bottom:1px dashed black"><?=$row->clave?></td>
        <td width="83" style="border-bottom:1px dashed black"><input type="button" value="Guardar" class="guardar" onclick="guardarWork(<?=$row->id?>)" /></td>
        </tr>
<?
	}
?>
    </table>
   </td>
  </tr>
  <tr>
  	<td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
<script type="text/javascript">
function addinput(id){
	var inpt = document.createElement('input');
		inpt.type="text";
		inpt.name="trabajos"+id+"[]";
		inpt.maxLength = 4;
		inpt.className = "trabajos";
		document.getElementById("moreinput_"+id).appendChild(inpt);
}
function guardarWork(id){
	var trabajos = document.form1["trabajos"+id+"[]"];
	var minimo = false;
	for(i=0;i<trabajos.length;i++){
		if(document.form1["trabajos"+id+"[]"][i].value!=""){
			if(document.form1["trabajos"+id+"[]"][i].value.length<4){
				minimo = true;
			}
		}
	}
	
	if(minimo){
		alert("Los campos deben contener 4 numeros");
		return false;
	}
	document.form1.action = "guardarWork.php?id="+id;
	$("#form1").attr("target","frame");
	document.form1.submit();
	document.getElementById("framediv").style.display = "block";
}

</script>