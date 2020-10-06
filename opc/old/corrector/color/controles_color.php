<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Colores de actividad </strong></font></div></td>
  </tr>
  <tr>
    <td>
	  <div align="center">
	    <?
	$fila_1 = Array("#FFFFFF","#FFEAEA","#FFBFBF","#FF9595","#FF6A6A","#FF4040","#FFEED5","#FFDDAA","#FFCC80","#FFBB55","#FFAA2B");
	$fila_2 = Array("#E9E9E9","#FFFFD5","#FFFFAA","#FFFF80","#FFFF55","#FFFF2B","#E4F1E2","#CAE3C6","#B0D5AA","#96C78D","#7BB971");
	$fila_3 = Array("#CCCCCC","#EAFFFE","#BFFFFC","#95FFFA","#6AFFF8","#00E1D6","#D5E4FF","#AAC8FF","#80ACFF","#5591FF","#2B75FF");
	$fila_4 = Array("#999999","#ECD5FF","#D9AAFF","#C680FF","#B355FF","#9F2BFF","#FFD5F0","#FFAAE1","#FF80D2","#FF55C4","#FF2BB5");
	$fila_5 = Array("#666666","#F1EAE2","#E3D6C6","#D5C1AA","#C7AB8D","#B99771","#F0F2E1","#E1E6C4","#D1D9A6","#C1CC88","#B3BF6A");
	foreach($fila_1 as $col){
	?>
	    <input name="" type="button" style="border-color:#000000;background-color:<?=$col?>; width:25; height:25;" onclick="tirar_color('<?=$col?>')"/>
        <?
	 }
	 ?>	 
     </div></td>
  </tr>
  <tr>
    <td height="3">	<div align="center"></div></td>
  </tr>
  <tr>
    <td>
		<div align="center">
		  <?
	
	foreach($fila_2 as $col){
	?>
		  <input name="button" type="button" style="border-color:#000000;background-color:<?=$col?>; width:25; height:25;" onclick="tirar_color('<?=$col?>')"/>
	      <?
	 }
	 ?>	
       </div></td>
  </tr>
  <tr>
    <td height="3"><div align="center"></div></td>
  </tr>
  <tr>
    <td><div align="center">
      <?
	
	foreach($fila_3 as $col){
	?>
      <input name="button" type="button" style="border-color:#000000;background-color:<?=$col?>; width:25; height:25;" onclick="tirar_color('<?=$col?>')"/>
      <?
	 }
	 ?>    
    </div></td>
  </tr>
  <tr>
    <td height="3"><div align="center"></div></td>
  </tr>
  <tr>
    <td><div align="center">
      <?
	
	foreach($fila_4 as $col){
	?>
      <input name="button" type="button" style="border-color:#000000;background-color:<?=$col?>; width:25; height:25;" onclick="tirar_color('<?=$col?>')"/>
      <?
	 }
	 ?>
    </div></td>
  </tr>
  <tr>
    <td height="3"><div align="center"></div></td>
  </tr>
  <tr>
    <td>		<div align="center">
      <?
	
	foreach($fila_5 as $col){
	?>
      <input name="button" type="button" style="border-color:#000000;background-color:<?=$col?>; width:25; height:25;" onclick="tirar_color('<?=$col?>')"/>
       <?
	 }
	 ?>	
    </div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="30"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Dise&ntilde;os de actividad </strong></font></div></td>
  </tr>
  <tr>
  <td><table width="320" border="0" align="center" cellpadding="1" cellspacing="0">
    <tr>
      <td><?
  		$carpeta = "img/patrones";

		$abroDirectorio = opendir($carpeta);
		while ($archivo = readdir($abroDirectorio)){
		if ($archivo != "." && $archivo != ".." && $archivo != "Thumbs.db" ) {
		?>
        <input name="button2" type="button" style="width:41; height:40; border:2 solid #000000; border-color:#000000; margin-bottom: 5px; background:url(img/patrones/<?=$archivo?>)" onclick="tirar_diseno('<?=$archivo?>')" />
        </input>
        <?
		}
		}
  ?></td>
    </tr>
  </table></td>
  </tr>
</table>
<input name="colorRGB" type="hidden" />