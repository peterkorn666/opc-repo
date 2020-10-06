<?
header("Content-Disposition: attachment; filename=GraficaAutor.xls");
include('inc/sesion.inc.php');
require("conexion.php");
$indice = "%";
		
		$arrayAutor = array();
		
		$sql = "SELECT * FROM trabajos_libres Order BY numero_tl ASC";
		$rs = mysql_query($sql,$con) or die(mysql_error());
		while ($row = mysql_fetch_array($rs)){
			
			$sql2 = "SELECT ID_participante FROM trabajos_libres_participantes WHERE ID_trabajos_libres ='".$row["ID"]."' Order BY ID ASC";
			$rs2 = mysql_query($sql2,$con) or die(mysql_error());
			while ($row2 = mysql_fetch_array($rs2)){
			
				$sql3= "SELECT * FROM personas_trabajos_libres WHERE Apellidos like '".$indice."%' and ID_Personas='". $row2["ID_participante"]."';";
				$rs3 = mysql_query($sql3,$con) or die(mysql_error());
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
		  echo "<td  align='center'  bgcolor='$bg'><font color='#003366'><b>Total</b></font></td>";
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
			echo "<td bordercolor='#666666' bgcolor='#FFFFcc' ><b>$cuantosAutor</b></td>";
			?>
          </tr>
          <?
			}
			?>
        </table>