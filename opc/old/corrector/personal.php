<?php
session_start();
if($_SESSION["Login"]==""){
	header("Location: login.php");
	die();
}
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");
include("../envioMail_Config.php");
//include("borrarCampos.php");
if($leerRegl == true){
	if(($_SESSION["chkAcepto"]=="")||($_SESSION["chkAcepto"]=="1")){
		$btnHabilitado =  "disabled='disabled'";
	}
}
include "../conexion.php";
include("evaluaciones.php");
require "clases/class.autores.php";
require ("../clases/trabajosLibres.php");
include dirname(__FILE__).'/replacePngTags.php';
echo '<?xml version="1.0" encoding="UTF-8"?>';
$trabajos = new trabajosLibre;
$autoresObj = new autores();
if ($_SESSION["Login"] != "Logueado") {
	header("Location:login.php");
	die();
}
function remlazarColor($cualViejo, $ses){
	if($_GET["error"]==1 && $_SESSION[$ses]==""){
			$color ="#ff0000";
	}else{
		$color = $cualViejo;
	}
return $color;
}


$nombre_evaluadorFiltro = $_POST["nombre_evaluador"];
$area_tl = $_POST["area_tl"];
$numero_tlFiltro = $_POST["numero_tl"];
$estadoTL = $_POST["estadoTL"];
$fecha = $_POST["fecha"];
$resumen_revisado = $_POST["resumen_revisado"];
$trabajo_completo = $_POST["trabajo_completo"];
$estado_tl = $_POST["estado_tl"];
$apremio = $_POST["apremio"];
$ordenFecha = $_POST["ordenFecha"];

$filtro = "";
if($nombre_evaluadorFiltro!=""){
	$filtro .= " AND (ev.nombre LIKE '%$nombre_evaluadorFiltro%' OR ev.clave LIKE '%$nombre_evaluadorFiltro%')";
}

if($numero_tlFiltro!=""){
	$filtro .= " AND e.numero_tl='$numero_tlFiltro'";
}

if($area_tl!="todos" && $area_tl!=""){
	$filtro .= " AND t.area_tl='$area_tl'";
}
if($estadoTL!=""){
	$filtro .= " AND e.estadoEvaluacion='$estadoTL'";
}
if($apremio!=""){
	$filtro .= " AND t.premio='$apremio'";
}
if($fecha!=""){
	$filtro .= " AND e.fecha='$fecha'";
}
if($resumen_revisado!=""){
	if($resumen_revisado=="Si"){
		$filtro .= " AND e.estadoEvaluacion<>''";
	}else{
		$filtro .= " AND e.estadoEvaluacion=''";
	}
}

if($estado_tl!=""){
	$filtro .= " AND t.estado='$estado_tl'";
}

if($trabajo_completo!=""){
	if($trabajo_completo=="Si"){
		$filtro .= " AND t.archivo_trabajo_comleto<>''";
	}else{
		$filtro .= " AND t.archivo_trabajo_comleto=''";
	}
}
if($ordenFecha!=""){
	$orden = " ORDER BY fecha $ordenFecha";
}else{
	$orden = " ORDER BY t.area_tl,e.numero_tl;";
}

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=utf8_encode($congreso)?> - Papers Evaluation</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="js/funciones.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#tn").click(function(event){
		   event.preventDefault();
		   if($("input:checkbox").is(":checked")){
				$("input:checkbox").attr("checked",false);
		   }else{
				$("input:checkbox").attr("checked",true);
		   }

	});
});
</script>
</head>
<body>
<center>
<br>
<img src="<?=$rutaBanner?>"><br>&nbsp;
<table width="900" align="center" cellpadding="5px" cellspacing="0" style="border:2px; border-color:#333; border-style:solid">
  <tr>
    <td align="left" valign="top" bordercolor="#000000" bgcolor="#FFFFFF" class="texto" style="font-size:13px;" height="40px">Usuario: <strong><?=$_SESSION["nombreEvaluador"]?></strong><br><a href="cerrarSession.php">Cerrar Sessi&oacute;n</a>
    </td>
    <td width="261" rowspan="2" align="right" valign="top" bordercolor="#000000" bgcolor="#FFFFFF" class="texto" style="font-size:13px;">
      <?
	 	if($_SESSION["nivel"]==1){
	?>
      <form id="form_filtro" name="filtro" action="" method="post">
        <table width="100%" border="0" cellspacing="2" cellpadding="1" style="font-size:12px">
          <tr>
            <td>Evaluador</td>
            <td><input type="text" name="nombre_evaluador" value="<?=$nombre_evaluadorFiltro?>"></td>
            </tr>
          <tr>
            <td>N&uacute;mero</td>
            <td><input type="text" name="numero_tl" value="<?=$numero_tlFiltro?>"></td>
            </tr>
          <tr>
            <td>APTO<br>
              NO APTO</td>
            <td>
              <select name="estadoTL">
                <option value="">Todos</option>
                <option value="APTO" <? if($estadoTL=="APTO"){echo "selected";} ?>>APTO</option>
                <option value="NO APTO" <? if($estadoTL=="NO APTO"){echo "selected";} ?>>NO APTO</option>
                </select>
              </td>
            </tr>
          <tr>
            <td>Estado</td>
            <td><select name="estado_tl">
              <option value="">Todos</option>
              <option value="0" <? if($estado_tl=="0"){echo "selected";} ?>>Recibidos</option>
              <option value="1" <? if($estado_tl=="1"){echo "selected";} ?>>En Revision</option>
              <option value="2" <? if($estado_tl=="2"){echo "selected";} ?>>Aprobados</option>
              <option value="4" <? if($estado_tl=="4"){echo "selected";} ?>>Notificados</option>
              <option value="3" <? if($estado_tl=="3"){echo "selected";} ?>>Rechazados</option>
              </select></td>
            </tr>
          <tr>
            <td>&Aacute;rea de Trabajo</td>
            <td><select name="area_tl" style="width:100%">
              <option value="todos">Todos</option>
              <?php
				$grupos = $con->query("SELECT * FROM areas_trabjos_libres ORDER BY id");
				while($row = $grupos->fetch_array()){
					if($row["id"]==$area_tl)
						$chk = "selected";
					echo "<option value='{$row["id"]}' $chk>{$row["Area_es"]}</option>";
					$chk = "";
				}
			  ?>
            </select></td>
          </tr>
          <tr>
            <td>Resumen Revisado</td>
            <td>Si <input type="radio" name="resumen_revisado" value="Si" <? if($resumen_revisado=="Si"){echo "checked";} ?>> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No        <input type="radio" name="resumen_revisado" value="No" <? if($resumen_revisado=="No"){echo "checked";} ?>></td>
            </tr>
          <!--<tr>
            <td>Trabajo Completo</td>
            <td>Si <input type="radio" name="trabajo_completo" value="Si" <? /*if($trabajo_completo=="Si"){echo "checked";}*/ ?>> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No        <input type="radio" name="trabajo_completo" value="No" <? /*if($trabajo_completo=="No"){echo "checked";}*/ ?>></td>
            </tr>-->
          <tr>
            <td>Fecha</td>
            <td>
              <?
			$sqlFecha = "SELECT DISTINCT(fecha) FROM evaluaciones WHERE fecha<>''";
			$queryFecha = $con->query($sqlFecha);
		  ?>
              <select name="ordenFecha">
                <option value=""></option>
                <option value='asc' <? if($ordenFecha=="asc"){echo "selected";} ?>>ascendiente</option>
                <option value='desc' <? if($ordenFecha=="desc"){echo "selected";} ?>>descendiente</option>
                </select>
              </td>
            </tr>
          <tr>
            <td colspan="2"><input type="submit" value="Filtrar" style="width:100px">
              &nbsp;
  <input type="button" onClick="limpiarFiltro()" value="Limpiar Filtro" style="width:100px"></td>
            </tr>
          </table>
        </form>
      <?
		}
	?>
    </td>
    <td width="262" rowspan="2" align="right" valign="top" bordercolor="#000000" bgcolor="#FFFFFF" class="texto" style="font-size:13px;"><span class="texto" style="font-size:13px;">
      <? if ($_SESSION["nivel"]==2){?>
      <!--<a href="misEvaluacionesXLS.php" target="_blank">Ver mis evaluaciones</a> <br>-->
      <? }else if($_SESSION["nivel"]==3){?>
      <a href="misEvaluacionespremioXLS.php" target="_blank">Ver mis evaluaciones</a>
      <? }else{ ?>
      <a href="../todoslasEvaluacionesXLS.php" target="_blank">Todas las evaluaciones</a>
      <? } ?>
       <?
		if($_SESSION["nivel"]==1){
	?>
   <br> <a href="evaluadores.php" target="_blank">Asignar trabajos a los evaluadores</a>
   <br>
 <a href="crearEvaluador.php" target="_blank">Agregar un evaluador</a>
    <?
		}
	?>
    </span></td>
  </tr>
  <tr>
    <td align="left" valign="top" bordercolor="#000000" bgcolor="#FFFFFF" class="texto" style="font-size:13px;">
    <?php
	if($_SESSION["nivel"]==1){
		$sqlTrabajos = "SELECT * FROM trabajos_libres ORDER BY area_tl";
		$queryTrabajos = $con->query($sqlTrabajos);
		if(!$queryTrabajos){
			die($con->error);
		}
		$trabajosTotal = $queryTrabajos->num_row;
		/*$sqlAsignNoEval = "SELECT * FROM evaluaciones WHERE estadoEvaluacion=''";
		$queryAsignNoEval = mysql_query($sqlAsignNoEval,$con) or die(mysql_error());
		$sinEvaluar = mysql_num_rows($queryAsignNoEval);
		$sqlAceptados = "SELECT * FROM evaluaciones WHERE estadoEvaluacion='Aceptado sin correcciones'";
		$queryAceptados = mysql_query($sqlAceptados,$con) or die(mysql_error());
		$TLaceptados = mysql_num_rows($queryAceptados);
		$sqlCorreccion = "SELECT * FROM evaluaciones WHERE estadoEvaluacion='Aceptado con correcciones'";
		$queryCorreccion = mysql_query($sqlCorreccion,$con) or die(mysql_error());
		$TLcorreccion = mysql_num_rows($queryCorreccion);
		$sqlRechazado = "SELECT * FROM evaluaciones WHERE estadoEvaluacion='Rechazado'";
		$queryRechazado = mysql_query($sqlRechazado,$con) or die(mysql_error());
		$TLrechazado = mysql_num_rows($queryRechazado);*/
		
		
  	?>
    <table width="100%" border="0" cellspacing="2" cellpadding="1" style="font-size:12px">
      <tr>
        <td width="24%" bgcolor="#FFFFFF">Recibidos</td>
        <td colspan="4" bgcolor="#FFFFFF"> &nbsp;<strong>
          <?=$trabajosTotal?>
        </strong></td>
        </tr>
      <!--<tr>
        <td align="center" bgcolor="#FFFFFF">Sin asignar</td>
        <td width="29%" align="center" bgcolor="#FFFFFF">Asignados<br>
no evaluados</td>
        <td width="22%" align="center" bgcolor="#FFFFFF">Aceptado sin correcciones</td>
        <td width="25%" align="center" bgcolor="#FFFFFF">Aceptado con correcciones</td>
        <td width="25%" align="center" bgcolor="#FFFFFF">Rechazado</td>
        </tr>
      <tr>
        <td align="center" bgcolor="#FFFFFF" id="tlSinAsignar"></td>
        <td align="center" bgcolor="#FFFFFF"><strong>
          <?=$sinEvaluar?>
        </strong></td>
        <td align="center" bgcolor="#FFFFFF"><strong>
          <?=$TLaceptados?>
        </strong></td>
        <td align="center" bgcolor="#FFFFFF"><strong>
          <?=$TLcorreccion?>
        </strong></td>
        <td align="center" bgcolor="#FFFFFF"><strong>
          <?=$TLrechazado?>
        </strong></td>
        </tr>-->
    </table>
    <?
	}
	     if($_SESSION["nivel"]!=1){
        	$sqlT = "SELECT * FROM evaluaciones as ev JOIN trabajos_libres as tr ON ev.numero_tl=tr.numero_tl WHERE ev.idEvaluador ='".$_SESSION["idEvaluador"]."' ORDER BY tr.area_tl;";
		  }else{
					$sqlT = "SELECT * FROM evaluaciones as e JOIN trabajos_libres as t ON e.numero_tl=t.numero_tl JOIN evaluadores as ev ON e.idEvaluador=ev.id WHERE 1=1 $filtro $orden";
		  }
		  //echo $sqlT;

		$rsT = $con->query($sqlT);
		if(!$rsT){
			die($con->error);
		}
		$cantConsulta = $rsT->num_row;
		$i = 0;
		$cant = 1;
		$tlViejo = "";
	?>
    </td>
    </tr>
  <!--<tr style="font-size:12px">
    <td colspan="3" align="left" bordercolor="#000000" bgcolor="#FFFFFF">
    <?
		/*if($_SESSION["nivel"]==1){
			echo "Trabajos sin asignar: ";*/
	?>
    

    <?
			/*$tlS = 0;
			while($rowTrabajos = mysql_fetch_object($queryTrabajos)){
				$sqlTrabajosLibres = "SELECT DISTINCT(numero_tl) FROM evaluaciones WHERE numero_tl='$rowTrabajos->numero_tl'";
				$queryTrabajosLibres = mysql_query($sqlTrabajosLibres,$con) or die(mysql_error());
				$existe = mysql_num_rows($queryTrabajosLibres);
				if($existe==0){
					$tlS = $tlS+1;

					if($rowTrabajos->area_tl!=$areas_viejo){
						echo "<br><br><span style='color:red'>".$trabajos->areaID($rowTrabajos->area_tl)->Area_es."<br></span> ";
					}
					//if($rowTrabajos->area_tl==$areas_viejo){
						if($rowTrabajos->estado==3)
							echo "<span style='color:gray'>";
								echo $rowTrabajos->numero_tl." - ";
						if($rowTrabajos->estado==3)
							echo "</span>";
				//	}
					if($rowTrabajos->area_tl!=$areas_viejo){
						//echo "<br>";
					}

					$areas_viejo = $rowTrabajos->area_tl;
				}
			}
		}*/
		?>
    </td>
    </tr>-->
  <tr><td colspan="3"  rowspan="2" valign="top" bordercolor="#000000" bgcolor="#FFFFFF" align="center">
  <form name="form1">
		<? if($_SESSION["nombreEvaluador"]!=""){?>
		<table width="98%" border="0" cellspacing="1" cellpadding="3" style="border:solid 1px #999999; font-size:12px; background-color:#666">
		  <tr>
		    <td colspan="18" align="left" valign="middle" bgcolor="#FFFFFF" style="font-size:15px">
            <?php
				if($_SESSION["nivel"]==1){
			?>
           <div style="float:left"> Resultados encontrados: <span id="cantResultados"><?=$cantConsulta?></span></div>
           <div style="float:left; margin-left:30px"> Mover seleccionados a: 
           	<select name="moverA">
            	<option value=""></option>
               	 <option value="0">Recibidos</option>
                  <option value="1">En Revision</option>
                  <option value="2">Aprobados</option>
                  <option value="4">Notificados</option>
                  <option value="3">Rechazados</option>
            </select>
            <input type="button" value="Mover" onClick="moverTrabajos()">
           </div>
		     <div style="float:right"> <a href="#" onClick="envioMasivoTrabajos()">Preparar mail a contactos de trabajos</a></div></td>

		   <?
			}
			?>
		    </tr>
		  <tr>
		    <td colspan="22" align="center" valign="middle" bgcolor="#028DC8" style="color:#FFF"><strong>Trabajos para evaluar:</strong></td>
	      </tr>
		  <tr style="font-size:11px">
          <?
			if($_SESSION["nivel"]==1){
		  ?>
		    <td width="25" align="center" valign="middle" bgcolor="#DBF4FF"><a href="#" id="tn">X</a></td>
          <?
			}
		  ?>
		    <td align="center" valign="middle" bgcolor="#DBF4FF">Nro.</td>
            <?
            if($_SESSION["nivel"]==1 or $_SESSION["nivel"]==2){
			?>
            <td align="center" valign="middle" bgcolor="#DBF4FF">Fecha asignado</td>
		    <?
			}
			?>
            <?
			if($_SESSION["nivel"]==1){
			?>
            <td align="center" valign="middle" bgcolor="#DBF4FF">Nombre del Evaluador</td>
            <td align="center" valign="middle" bgcolor="#DBF4FF">Trabajo completo</td>
            <?
		    }
			?>
            <?
			if($_SESSION["nivel"]==1 or $_SESSION["nivel"]==2){
			?>
		    <td align="center" valign="middle" bgcolor="#DBF4FF">Resumen<br>
 Revisado</td>
 			<td align="center" valign="middle" bgcolor="#DBF4FF">¿Es autor del trabajo?</td>
            <?
			}
			?>
            <?
			if($_SESSION["nivel"]==1){
			?>
            <td align="center" valign="middle" bgcolor="#DBF4FF">Comentarios del evaluador</td>
            <?
			}
			if($_SESSION["nivel"]==1 or $_SESSION["nivel"]==2){
			?>
            <td align="center" valign="middle" bgcolor="#DBF4FF">Evaluación</td>
            <?
			}
			if($_SESSION["nivel"]==1){
			?>
		    <td align="center" valign="middle" bgcolor="#DBF4FF">Fecha evaluado</td>
             <?
		    }
			if($_SESSION["nivel"]==1){
			?>
            <td align="center" valign="middle" bgcolor="#DBF4FF">Estado</td>
            <?
		    }
			?>
             <td align="center" valign="middle" bgcolor="#DBF4FF">&nbsp;</td>
	      </tr>
		  <?
		  
        while ($row = $rsT->fetch_array()){
		/*	$selectEvaluador = "SELECT * FROM evaluadores WHERE id='".$row["idEvaluador"]."'";
			$queryEvaluador = mysql_query($selectEvaluador,$con);
			$rowEvaluador = mysql_fetch_object($queryEvaluador);*/
			if ($row["opcion"]!=""){$bg = "F4F4F4";}else{$bg = "FFF";}
			if($i==0){
				$cant = 0;
				$numeroTLV = $row["numero_tl"];
				$archivo_tl = $row["archivo_tl"];
			}

			if(($numeroTLV == $row["numero_tl"]) && ($_SESSION["nivel"]==1)){
				if($row["puntajeTotal"]>10){
					$cant = $cant+1;
				}
					$abr_tl = $row["abr_tl"]." ".$row["numeracion"];
					$nmTL = $row["numero_tl"];
					$tpTL = $row["tipo_tl"];
					$total += $row["puntajeTotal"];
				//$cant = $cant+1;
			}

		  if(($numeroTLV != $row["numero_tl"]) && ($_SESSION["nivel"]==1)){

		  ?>
		  <?
		  	$cant = 1;
		  } ?>
		<?
		if(($tlViejo!=$row["numero_tl"] && trim($areaV)!=trim($row["area_tl"]))){
		?>
         <tr>
         	<td colspan="17" bgcolor="#DBF4FF"><strong>
         	  <?=$trabajos->areaID($row["area_tl"])->Area_es?>
         	</strong></td>
         </tr>
         <?
		}
		$tlViejo = $row["numero_tl"];
		$areaV = $row["area_tl"];
		 ?>

		  <tr>
          <?
			if($_SESSION["nivel"]==1){
		  ?>
		    <td align="center" bgcolor="#F4F4F4" ><input type="checkbox" name="tl[]" value="<?=$row["ID"]?>"></td>
          <?
			}
		  ?>
		    <td align="center" bgcolor="#F4F4F4"><?=$row["numero_tl"]?></td>
            <?
            if($_SESSION["nivel"]==1 or $_SESSION["nivel"]==2){
			?>
        <td align="center" nowrap bgcolor="#F4F4F4"><?=$row["fecha_asignado"]?></td>
			<?
			}
			?>
            <?
			if($_SESSION["nivel"]==1){
			?>
            <td bgcolor="#F4F4F4"><?=$row["nombre"]?></td>
            <td bgcolor="#F4F4F4" align="center" valign="middle"><?php
			if ($row["archivo_tl"]!=""){
			echo "<strong>Si</strong>";
			} else {
			echo "No";
			}
			?></td>
            <?
		    }
            if($_SESSION["nivel"]==1 or $_SESSION["nivel"]==2){
			?>
		    <td align="center" bgcolor="#F4F4F4" ><?
			if ($row["estadoEvaluacion"]!="" || $row["ev_global"]!=""){
			echo "<strong>Si</strong>";
			} else {
			echo "No";
			}
			?></td>
            <td align="center" bgcolor="#F4F4F4"><?=$row["evaluar_trabajo"]?></td>
			<?
			}
			if($_SESSION["nivel"]==1){
			?>
            <td bgcolor="#F4F4F4"><?=$row["comentarios"]?></td>
            <?
			}
			if($_SESSION["nivel"]==1 or $_SESSION["nivel"]==2){
			?>
        <td align="center" bgcolor="#F4F4F4"><?php 
		if ($row["estadoEvaluacion"]!=""){
			echo $row["estadoEvaluacion"];
		}else if ($row["ev_global"]!=""){
			echo $row["ev_global"];
		}else{
			echo '';
		}
		?></td>
        <?
			}
			if($_SESSION["nivel"]==1){
		?>
		    <td align="center" bgcolor="#F4F4F4" nowrap><?php
			 if(!empty($row["fecha"])) {
			 	if ($row["fecha"] != "0000-00-00")
			 		echo $row["fecha"];
				else
					"No evaluado";
			 }
			 ?></td>
        <?
		    }
		if($_SESSION["nivel"]==1){
			switch($row["estado"]){
				case 0:
					$BGestadoTL = "#FFCACA";
					$textoEstado = "Recibido";
				break;
				case 1:
					$BGestadoTL = "#79DEFF";
					$textoEstado = "En Revisi&oacute;n";
				break;
				case 2:
					$BGestadoTL = "#82E180";
					$textoEstado = "Aprobado";
				break;
				case 3:
					$BGestadoTL = "#999999";
					$textoEstado = "Rechazado";
				break;
				case 4:
					$BGestadoTL = "#E074DD";
					$textoEstado = "Notificado";
				break;
			}
		?>
        <td align="center" bgcolor="<?=$BGestadoTL?>"><?=$textoEstado?></td>
        <?
		    }

				if($_SESSION["nivel"]!=1){
			?>
		    		<td align="center" bgcolor="#F4F4F4" ><input type="button" style=" padding:2px; font-family:'Trebuchet MS', Arial; font-size:11px; border:1px #333 solid; background-color:#EAFCFF; cursor:pointer;" value="Evaluar" onClick="evaluar('<?=$row["numero_tl"]?>',0,null);" name="btnEvaluar"></td>
      <?
				}else if($_SESSION["nivel"]==1){
			?>
            		<td width="95" align="center" bgcolor="#F4F4F4" ><input type="button" style=" padding:2px; font-family:'Trebuchet MS', Arial; font-size:11px; border:1px #333 solid; background-color:#EAFCFF; cursor:pointer;" value="Ver Trabajo" onClick="evaluar('<?=$row["numero_tl"]?>',1,'<?=$row["idEvaluador"]?>');" name="btnEvaluar"></td>
      <?
				}
			?>
	      </tr>

          <?
          if(($numeroTLV != $row["numero_tl"]) && ($_SESSION["nivel"]==1)){
			 $total = $row["puntajeTotal"];
		  }
		  $numeroTLV = $row["numero_tl"];

		  $i++;
		  } ?>

          <?
			if(($numeroTLV == $row["numero_tl"]) && ($_SESSION["nivel"]==1)){
				$total += $row["puntajeTotal"];
				$abr_t = $row["abr_tl"]." ".$row["numeracion"];
				$nmTL = $row["numero_tl"];
				$tpTL = $row["tipo_tl"];

			}

		  if(($numeroTLV != $row["numero_tl"]) && ($_SESSION["nivel"]==1)){

		  ?>
		 <?  } ?>
		</table>
        </form>
		<?

		}?>
	  </td>
    </tr>
</table>
<br>&nbsp;
</center>
</body>
</html>
<script language="javascript" type="text/javascript">
function bajarTL(cual){
	document.location.href= "../bajando_tl.php?id=" + cual;
}
function evaluar(nro,ver,evaluador){
	if(ver==0){
		document.form1.method = "POST";
		document.location.href = "AUTOR_codigo_enviar2.php?txtCod="+nro;
	}else{
		document.form1.method = "POST";
		document.location.href = "vistaGestor.php?txtCod="+nro+"&ver="+ver+"&evaluador="+evaluador;
	}
}

function vermas(id){
	document.getElementById(id).style.height = "";
	document.getElementById(id+"_a").href = "javascript:vermenos("+id+")";
}
function vermenos(id){
	document.getElementById(id).style.height = "30px";
	document.getElementById(id+"_a").href = "javascript:vermas("+id+")";
}

function limpiarFiltro(){
	document.filtro["nombre_evaluador"].value = "";
	document.filtro["numero_tl"].value = "";
	document.filtro["area_tl"].selectedIndex = 0;
	document.filtro["estado_tl"].selectedIndex = 0;
	document.filtro["resumen_revisado"][0].checked = false;
	document.filtro["resumen_revisado"][1].checked = false;
	document.filtro["trabajo_completo"][0].checked = false;
	document.filtro["trabajo_completo"][1].checked = false;
	document.filtro["ordenFecha"].selectedIndex = 0;
}
function envioMasivoTrabajos(){
 document.form1.method = "POST";
 document.form1.action = "../envioMail_trabajosLibres.php";
 document.form1.submit();
}

function moverTrabajos(){
 document.getElementsByName("form1").method = "POST";
 document.getElementsByName("form1").action = "../moverTL.php?c=1";
 document.getElementsByName("form1").submit();
}

/*document.getElementById("tlSinAsignar").innerHTML = "<strong><?=$tlS?></strong>";*/
/*$(document).ready(function(e) {
	$("#form_filtro").submit(function(){
		$("#cantResultados").html("<?php echo $cantConsulta;?>");
		//document.getElementById("cantResultados").innerHTML = "<?=$cantConsulta?>";
	});
});*/
</script>
