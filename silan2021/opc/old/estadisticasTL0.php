<?php
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");

if (!isset($_SESSION["registrado"])){
	$_SESSION["registrado"]=false;
}

include('inc/sesion.inc.php');
include('conexion.php');
include("inc/validarVistas.inc.php");

include ("clases/graficas/jpgraph.php");
include ("clases/graficas/jpgraph_pie.php");
include ("clases/graficas/jpgraph_pie3d.php");

require ("clases/trabajosLibres.php");
$trabajos = new trabajosLibre;


function remplazar($cual){
		  	
	return  $cual;
	
}
$rechazado = "Rechazados";
?>
<style>
.link {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	text-decoration: none;
	color:#6600CC;
}
.link:hover {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	text-decoration: none;
	color:#0000FF;
}
.pais{
font-family:Arial, Helvetica, sans-serif;
color:#000033;
font-size:11px;
text-decoration:none;
}
#abcTL {
	background-color: #F7F4F7;
	padding: 2px;
	border: 1px solid #333333;
	margin: 2px;
}
</style>
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function mOvr(src,clrOver) {
	if (!src.contains(event.fromElement)) {
		src.style.cursor = 'hand';
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
	document.location.href = src;
}
function desSeleccionarTodo(){
		
		tdPais.className="solapa_NO_selecionada";	
		tdArea.className="solapa_NO_selecionada";
		tdAutor.className="solapa_NO_selecionada";	
		
		document.getElementById('divPais').style.display='none';
		document.getElementById('divArea').style.display='none';
		document.getElementById('divAutor').style.display='none';
}


function seccion(cual){
	
	desSeleccionarTodo()

	if(cual == "pais"){
		tdPais.className="solapa_selecionada";	
		document.getElementById('divPais').style.display='inline';
	}
	
	if(cual == "area"){
		tdArea.className="solapa_selecionada";
		document.getElementById('divArea').style.display='inline';
		
	}
	if(cual == "autor"){
		tdAutor.className="solapa_selecionada";	
		document.getElementById('divAutor').style.display='inline';
		
	}
	
	
}

</script>
<script src="js/menuEdicion.js"></script>
<script src="js/trabajos_libres.js"></script>
<link href="estiloBordes.css" rel="stylesheet" type="text/css">
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" bgproperties="fixed" marginwidth="0" marginheight="0">
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#FFFFFF">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php"; ?></td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="2">
      <tr>
        <td width="31%" height="30" align="center" valign="middle" bordercolor="#FF0000" bgcolor="#FFCACA" class="menu_sel"><b>[<?=$trabajos->cantidadInscriptoTL_estado("0");?>] </b><a href="estadoTL.php?estado=0">No revisados y registros On-line</a></td>
        <td width="19%" height="30" align="center" valign="middle" bordercolor="#0099CC" bgcolor="#79DEFF" class="menu_sel"><b>[<?=$trabajos->cantidadInscriptoTL_estado("1");?>]</b> <a href="estadoTL.php?estado=1">En revisi&oacute;n</a></td>
        <td width="25%" height="30" align="center" valign="middle" bordercolor="#006600" bgcolor="#82E180" class="menu_sel"><b>[<b><?=$trabajos->cantidadInscriptoTL_estado("2");?>
        </b>]</b> <a href="estadoTL.php?estado=2">Aprobados</a></td>
        <td width="25%" height="30" align="center" valign="middle" bordercolor="#333333" bgcolor="#999999" class="menu_sel"><b>[<?=$trabajos->cantidadInscriptoTL_estado("3");?>] </b><a href="estadoTL.php?estado=3">Rechazados</a></td>
      </tr>
    </table>
      <br>
      <p align="center"><strong><font color="#666666" size="3" face="Arial, Helvetica, sans-serif">Estadisticas de trabajos libres </font></strong></p>
      <table width="700" border="0" align="center" cellpadding="4" cellspacing="0" class="solapa_pie">
        <tr>
          <td width="145"></td>
          <td width="179"  id="tdPais"  class="solapa_selecionada"><div align="center"><a href="#" onClick="seccion('pais')">Por País</a></div></td>
          <td width="2"></td>
          <td width="179" id="tdArea" class="solapa_NO_selecionada"><div align="center"><a href="#"  onClick="seccion('area')">Por Áreas</a></div></td>
          <td width="2"></td>
          <td width="179" id="tdAutor" class="solapa_NO_selecionada"><div align="center"><a href="#"  onClick="seccion('autor')">Por Autor</a></div></td>
          <td width="147"></td>
        </tr>
      </table>
	  
	  
      <div id="divPais">
        <?
		
		
		
		$arrayPais = array();
		
		$sql = "SELECT * FROM trabajos_libres Order BY numero_tl ASC";
		$rs = mysql_query($sql,$con);
		while ($row = mysql_fetch_array($rs)){
			
			$sql2 = "SELECT ID_participante FROM trabajos_libres_participantes WHERE ID_trabajos_libres ='".$row["ID"]."' Order BY ID ASC LIMIT 1";
			$rs2 = mysql_query($sql2,$con);
			while ($row2 = mysql_fetch_array($rs2)){
			
				$sql3= "SELECT Pais FROM personas_trabajos_libres WHERE ID_Personas='". $row2["ID_participante"]."';";
				$rs3 = mysql_query($sql3,$con);
				while ($row3 = mysql_fetch_array($rs3)){
				
								array_push($arrayPais, array($row3["Pais"], $row["tipo_tl"], $row["estado"]));
				
				}
			}
		}
		
		/*me quedo con los paises unicos*/
		$arraySoloPaises = array();
		for($i=0; $i<count($arrayPais);$i++){
			array_push($arraySoloPaises, $arrayPais[$i][0]);
		}
		$arraySoloPaises = array_unique($arraySoloPaises);
		sort($arraySoloPaises);
		/********************************/
		
		
		
		/*me quedo con los tipos de TL unicos*/
		$arraySoloTipos = array();
		for($i=0; $i<count($arrayPais);$i++){
			array_push($arraySoloTipos, $arrayPais[$i][1]);
		}
		$arraySoloTipos = array_unique($arraySoloTipos);
		sort($arraySoloTipos);
		array_push($arraySoloTipos,$rechazado);
		/***********************************/
		
		?>
        <br>
        <table border="0" align="center" cellpadding="4" cellspacing="1" bordercolor="#CCCCCC" class="textos">
          <tr>
            <td width="200" bordercolor="#666666"><strong>Pais</strong> / <font color="#003366">Tipo de trabajo</font> </td>
            <?
		   foreach($arraySoloTipos as $i){
			
			$bg = '#ffffff';
			
			if($i==""){
				$i="Sin definir";
				
			}
			if($i == $rechazado){
				$bg = '#999999';
			}
			
			echo "<td  align='center'  bgcolor='$bg'><font color='#003366'><b>$i</b></font></td>";
		
		  }
	?>
          </tr>
          <?
		$arrayCantidadAreas = array();
		$arrayCantidadPorAreas = array();
		$arrayCantidadPorPais = array();
		
		foreach($arraySoloPaises as $i){
		  ?>
          <tr>
            <td width="200" bordercolor="#666666" bgcolor="#FFFFFF"><strong>
              <?=$i?>
              </strong></td>
            <?
			$cuantosPais = 0;
			foreach($arraySoloTipos as $u){
			
				
				$cuantosTipoTL = 0;
				
			
				for($e=0; $e<count($arrayPais);$e++){
			
					if(($i == $arrayPais[$e][0]) && ($u == $arrayPais[$e][1])  && ($arrayPais[$e][2]!=3)){
					
						$cuantosTipoTL = $cuantosTipoTL + 1;
						$cuantosPais = $cuantosPais + 1;
					}
					
					
					
					if(($i == $arrayPais[$e][0]) && ($u == $rechazado) && ($arrayPais[$e][2]==3)){
					
						$cuantosTipoTL = $cuantosTipoTL + 1;
						$cuantosPais = $cuantosPais + 1;
					
					}
					
				
				}
			
				
				$bg = '#ffffff';
				if($u == $rechazado){
					$bg = '#999999';
				}
				
			
				echo "<td align='center'  bgcolor=$bg>$cuantosTipoTL</td>";
				array_push($arrayCantidadAreas , array($u, $cuantosTipoTL));
			
			}
			echo "<td bordercolor='#666666' bgcolor='#FFFFcc' >Total: <b>$cuantosPais</b></td>";
			array_push($arrayCantidadPorPais, $cuantosPais);
			?>
          </tr>
          <?
			}
			?>
          <tr>
            <td></td>
            <?
			
			
			$valorTotal = 0;
			 foreach($arraySoloTipos as $u){
				
				$valorArea = 0;
	
				
				 for($e=0; $e<count($arrayCantidadAreas);$e++){
				 
					  if($arrayCantidadAreas[$e][0]==$u){
					  
						 $valorArea = $valorArea + $arrayCantidadAreas[$e][1];
						 $valorTotal =  $valorTotal + $arrayCantidadAreas[$e][1];
					  }
				 
				 }
				 
				array_push($arrayCantidadPorAreas,  $valorArea);
				echo "<td  align='center' bordercolor='#666666' bgcolor='#ccccff' >Total: <b>$valorArea</b></td>"; 
			 
			 }
			echo "<td  align='center' bordercolor='#666666' bgcolor='#ff6600' >Total: <b>$valorTotal</b></td>"; 
			  ?>
          </tr>
        </table>
        <div>
          
            <?
	
				$data = $arrayCantidadPorPais;
				$graph = new PieGraph(700,400,"auto");
				$graph->title->Set("Porcentaje de trabajos libres por País");
				$graph->title->SetColor("darkblue");
				$graph->legend->Pos(0.05,0.2);
				$p1 = new PiePlot3d($data);
				$p1->SetTheme("sand");
				$p1->SetCenter(0.38);
				$p1->SetSize(230);
				$p1->SetAngle(50);
				$p1->SetStartAngle(45);
				$p1->SetEdge("navy");
				$p1->SetLegends($arraySoloPaises);
				$graph->Add($p1);
				$graph->Stroke("img/img1.php");		
				
	
		
		?>
         
				<div align="center">
				   <br>
					 <img align="middle" src="img/img1.php" />
				</div>
		  
		   </div>
	   </div>
	  
	  
      <div id="divArea" style="display:none">
	 
	   <?
	   
	    $arrayArea = array();
	   
	    $sql = "SELECT * FROM trabajos_libres";
		$rs = mysql_query($sql,$con);
		while ($row = mysql_fetch_array($rs)){


			if($row["area_tl"]==""){
				$area_tl = "_Sin area";
			}else{
				$area_tl = $row["area_tl"];
			}

			array_push($arrayArea, array($area_tl, $row["tipo_tl"], $row["estado"]));
			
		}
		
		/*me quedo con los paises unicos*/
		$arraySoloAreas = array();
		for($i=0; $i<count($arrayArea);$i++){
			array_push($arraySoloAreas, $arrayArea[$i][0]);
		}
		$arraySoloAreas = array_unique($arraySoloAreas);
		sort($arraySoloAreas);
		/********************************/

		
		/*me quedo con los tipos de TL unicos*/
		$arraySoloTipos = array();
		for($i=0; $i<count($arrayArea);$i++){
			array_push($arraySoloTipos, $arrayArea[$i][1]);
		}
		$arraySoloTipos = array_unique($arraySoloTipos);
		sort($arraySoloTipos);
		array_push($arraySoloTipos,$rechazado);
		/***********************************/
		
		?>
        <br>
        <table border="0" align="center" cellpadding="4" cellspacing="1" bordercolor="#CCCCCC" class="textos">
          <tr>
            <td width="200px" bordercolor="#666666"><strong>Area</strong> / <font color="#003366">Tipo de trabajo</font> </td>
            <?
		   foreach($arraySoloTipos as $i){
			
			$bg = '#ffffff';
			
			if($i==""){
				$i="Sin definir";
				
			}
			if($i == $rechazado){
				$bg = '#999999';
			}
			
			echo "<td  align='center'  bgcolor='$bg'><font color='#003366'><b>$i</b></font></td>";
		
		  }
	     ?>
          </tr>
          <?
		$arrayCantidadTipo = array();
		$arrayCantidadPorTipo  = array();
		$arrayCantidadPorAreas = array();
		
		foreach($arraySoloAreas as $i){
		  ?>
          <tr>
            <td width="200" bordercolor="#666666" bgcolor="#FFFFFF"><strong>
              <?=$i?>
              </strong></td>
            <?
			$cuantosTipo = 0;
			foreach($arraySoloTipos as $u){
			
				
				$cuantosTipoTL = 0;
				
			
				for($e=0; $e<count($arrayArea);$e++){
			
					if(($i == $arrayArea[$e][0]) && ($u == $arrayArea[$e][1])  && ($arrayArea[$e][2]!=3)){
					
						$cuantosTipoTL = $cuantosTipoTL + 1;
						$cuantosTipo = $cuantosTipo + 1;
					}
					
					
					
					if(($i == $arrayArea[$e][0]) && ($u == $rechazado) && ($arrayArea[$e][2]==3)){
					
						$cuantosTipoTL = $cuantosTipoTL + 1;
						$cuantosTipo = $cuantosTipo + 1;
					
					}
					
				
				}
			
				
				$bg = '#ffffff';
				
				if($u == $rechazado){
					$bg = '#999999';
				}
				
			
				echo "<td align='center'  bgcolor=$bg>$cuantosTipoTL</td>";
				array_push($arrayCantidadTipo  , array($u, $cuantosTipoTL));
			
			}
			echo "<td bordercolor='#666666' bgcolor='#FFFFcc' >Total: <b>$cuantosTipo</b></td>";
			array_push($arrayCantidadPorAreas , $cuantosTipo);
			?>
          </tr>
          <?
			}
			?>
          <tr>
            <td></td>
            <?
			
			$valorTotal = 0;
			
			foreach($arraySoloTipos  as $u){
				
				$valorTipo  = 0;
	
				 for($e=0; $e<count($arrayCantidadTipo);$e++){
				 
					  if($arrayCantidadTipo [$e][0]==$u){
					  
						 $valorTipo = $valorTipo + $arrayCantidadTipo [$e][1];
						 $valorTotal =  $valorTotal + $arrayCantidadTipo [$e][1];
					 
					  }
				 
				 }
				 
				array_push($arrayCantidadPorTipo ,  $valorTipo);
				echo "<td  align='center' bordercolor='#666666' bgcolor='#ccccff'>Total: <b>$valorTipo</b></td>"; 
			 
			}
			
			echo "<td  align='center' bordercolor='#666666' bgcolor='#ff6600'>Total: <b>$valorTotal</b></td>"; 
			
			?>
	      </tr>
        </table>
			<?
			    $data = $arrayCantidadPorAreas;
				$graph = new PieGraph(700,550,"auto");
				$graph->title->Set("Porcentaje de trabajos libres por Areas");
				$graph->title->SetColor("darkblue");
				$graph->legend->Pos(0.01,0.98,"left", "bottom");


				$p1 = new PiePlot3d($data);
				$p1->SetTheme("pastel");
				$p1->SetCenter(345, 180);
				$p1->SetSize(230);
				$p1->SetAngle(50);
				$p1->SetStartAngle(45);
				$p1->SetEdge("navy");
				$p1->SetLegends($arraySoloAreas);
				$graph->Add($p1);		
				$graph->Stroke("img/img3.php");
				
			?>
			
			<div align="center">
            <br><img align="middle" src="img/img3.php" /><br>
			 </div>
	  </div>
	  
	  
      <div id="divAutor" style="display:none">
	     
		 <br>

		  <div align="center" id="abcTL">
      							<?
								
								$indice = $_GET["indice"];
								
								if($indice==""){
									$indice = "A";
								}
								
								$abc = Array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","Ñ","O","P","Q","R","S","T","U","V","W","X","Y","Z");
							
								foreach($abc as $i){
								
									if($indice == $i){
										$estIndice = "style='background-color:#ff9933;'";
									}else{
										$estIndice = "";
									}
								?>
								 <a href="?indice=<?=$i?>"  class="linkIndice" <?=$estIndice?>>&nbsp;<?=$i?>&nbsp;</a>-
							    <?
					 			}
								if($indice == "" || $indice =="Todos"){
									$estIndice = "style='background-color:#ff9933;'";
								}else{
									$estIndice = "";
								}
					  ?>
				    <a href="?indice=Todos" class="linkIndice" <?=$estIndice?>>&nbsp;Todos&nbsp;</a>
				</div>
				
				
				
				
	   <?
		
		if($indice == "Todos"){
			$indice = "%";
		}
		
		$arrayAutor = array();
		
		$sql = "SELECT * FROM trabajos_libres Order BY numero_tl ASC";
		$rs = mysql_query($sql,$con);
		while ($row = mysql_fetch_array($rs)){
			
			$sql2 = "SELECT ID_participante FROM trabajos_libres_participantes WHERE ID_trabajos_libres ='".$row["ID"]."' Order BY ID ASC";
			$rs2 = mysql_query($sql2,$con);
			while ($row2 = mysql_fetch_array($rs2)){
			
				$sql3= "SELECT * FROM personas_trabajos_libres WHERE Apellidos like '".$indice."%' and ID_Personas='". $row2["ID_participante"]."';";
				$rs3 = mysql_query($sql3,$con);
				while ($row3 = mysql_fetch_array($rs3)){
				
								array_push($arrayAutor, array(($row3["Apellidos"]  .  ", " . $row3["Nombre"]), $row["tipo_tl"], $row["estado"]));
				
				}
			}
		}
		
		/*me quedo con los Autores unicos*/
		$arraySoloAutores = array();
		for($i=0; $i<count($arrayAutor);$i++){
			array_push($arraySoloAutores, $arrayAutor[$i][0]);
		}
		$arraySoloAutores = array_unique($arraySoloAutores);
		sort($arraySoloAutores);
		/********************************/
		
		
		
		/*me quedo con los tipos de TL unicos*/
		$arraySoloTipos = array();
		for($i=0; $i<count($arrayAutor);$i++){
			array_push($arraySoloTipos, $arrayAutor[$i][1]);
		}
		$arraySoloTipos = array_unique($arraySoloTipos);
		sort($arraySoloTipos);
		array_push($arraySoloTipos,$rechazado);
		/***********************************/
		
		?>
        <br>
        <table border="0" align="center" cellpadding="4" cellspacing="1" bordercolor="#CCCCCC" class="textos">
          <tr>
            <td width="200" bordercolor="#666666"><strong>Autor</strong> / <font color="#003366">Tipo de trabajo</font> </td>
            <?
		   foreach($arraySoloTipos as $i){
			
			$bg = '#ffffff';
			
			if($i==""){
				$i="Sin definir";
				
			}
			if($i == $rechazado){
				$bg = '#999999';
			}
			
			echo "<td  align='center'  bgcolor='$bg'><font color='#003366'><b>$i</b></font></td>";
		
		  }
	?>
          </tr>
          <?
		$arrayCantidadAreas = array();

		
		foreach($arraySoloAutores as $i){
		  ?>
          <tr>
            <td width="200" bordercolor="#666666" bgcolor="#FFFFFF"><strong>
              <?=$i?>
              </strong></td>
            <?
			$cuantosAutor = 0;
			foreach($arraySoloTipos as $u){
			
				
				$cuantosTipoTL = 0;
				
			
				for($e=0; $e<count($arrayAutor);$e++){
			
					if(($i == $arrayAutor[$e][0]) && ($u == $arrayAutor[$e][1])  && ($arrayAutor[$e][2]!=3)){
					
						$cuantosTipoTL = $cuantosTipoTL + 1;
						$cuantosAutor = $cuantosAutor + 1;
					}
					
					
					
					if(($i == $arrayAutor[$e][0]) && ($u == $rechazado) && ($arrayAutor[$e][2]==3)){
					
						$cuantosTipoTL = $cuantosTipoTL + 1;
						$cuantosAutor = $cuantosAutor + 1;
					
					}
					
				
				}
			
				
				$bg = '#ffffff';
				if($u == $rechazado){
					$bg = '#999999';
				}
				
			
				echo "<td align='center'  bgcolor=$bg>$cuantosTipoTL</td>";
				array_push($arrayCantidadAreas , array($u, $cuantosTipoTL));
			
			}
			echo "<td bordercolor='#666666' bgcolor='#FFFFcc' >Total: <b>$cuantosAutor</b></td>";
			?>
          </tr>
          <?
			}
			?>
          <tr>
            <td></td>
  
          </tr>
        </table>
	  </div>

	  </td>
  </tr>
</table>
<?
if($_GET["indice"] != ""){

echo "<script>seccion('autor')</script>";
}
?>