<?
include('inc/sesion.inc.php');
?>
<link href="estilos.css" rel="stylesheet" type="text/css">
<?
include('conexion.php');
?>
<script language="javascript">
   function Validar(){
	  if(form1.actividad_.value==""){alert("Por Favor, Ingrese una actividad.");form1.actividad_.focus();return;}
	  form1.submit();
	}
	
	function eliminar(cual){
 		
		var return_value = confirm("¿Esta seguro que desea eliminar esta actividad?");
		
		 if ( return_value == true ) {
			 document.location.href = "eliminarActividad.php?id=" + cual;
		 }
		 
	 }
	 
 function tirar_color(cual){
		
		
		form1.colorRGB.value = cual
		document.form1.actividad_.style.background = cual
	
		
	}
	function tirar_diseno(cual){

		form1.colorRGB.value = cual
		document.form1.actividad_.style.background = "url(img/patrones/" + cual + ")";
	
	}
	
</script>

<?
	$sql = "SELECT * FROM tipo_de_actividad WHERE ID_Tipo_de_actividad = " . $_GET["id"];
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
	 echo "<script language='javascript'>\n";
	 echo "function arranque(){\n";
	 echo "form1.colorRGB.value='". $row["Color_de_actividad"] . "';\n";
	 echo "celda.bgColor='". $row["Color_de_actividad"] . "';\n";
	 echo  "}";
	 echo  "</script>";
	}

?>
<meta charset="utf-8">
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="arranque()">
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php"; ?></td>
  </tr>
  <tr>
    <td valign="top" align="center" bgcolor="#F0E6F0"><div align="center" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:16px"><br>
        <strong>&nbsp;Modificar</strong><br>
Tipo de actividad</div>
      <form name="form1" method="post" action="modificarActividadEnviar.php">
  <table width="100%" border="0" cellpadding="0" cellspacing="2">
          <tr valign="top">
		 		  <?
				  $sql = "SELECT * FROM tipo_de_actividad WHERE ID_Tipo_de_actividad = " . $_GET["id"];
				  $rs = mysql_query($sql,$con);
				  while ($row = mysql_fetch_array($rs)){
				  $actividad_viejo = $row["Tipo_de_actividad"];
				  $actividad_ing_viejo = $row["Tipo_de_actividad_ing"];
				  ?>
		  
            <td width="50%" rowspan="2"><table width="100%"  border="0" cellpadding="5" cellspacing="0">
                <tr valign="top" bordercolor="#FFFFFF">
                  <td class="crono_trab">Modificara:&nbsp;<?
				  echo $row["Tipo_de_actividad"];
				  ?>
				  </td>
                </tr>
                <tr valign="top" bordercolor="#FFFFFF">
                  <td><font size="2">
				  <?				  
				  if(substr($row["Color_de_actividad"],0,1)=="#"){				  	
					$Color_de_actividad = "background-color:" . $row["Color_de_actividad"] . "; ";					
				  }else{				  	
					$Color_de_actividad = "background-image:url(img/patrones/" . $row["Color_de_actividad"] . ");";
				  }
				  ?>				  
                   <input name="actividad_" type="text" id="actividad_" value="<?=$row["Tipo_de_actividad"]?>" style="width:370;<?=$Color_de_actividad?>">
                  </font></td>
                </tr>
                 <tr valign="top" bordercolor="#FFFFFF">
                  <td><font size="2">
                  <input name="actividad_ing" type="text" id="actividad_ing" value="<?=$row["Tipo_de_actividad_ing"]?>" style="width:370;<?=$Color_de_actividad?>">
                  </font>
              <?  } ?>                  
                  </td>
                  </tr>
                <tr valign="top">
                  <td height="10"><?
					include "color/controles_color.php"
					?>                  </td>
                </tr>
                <tr valign="top" bordercolor="#FFFFFF">
                  <td><div align="right"><font size="2">
                      <input name="Submit" type="button" class="botones" onClick="Validar()" value="Modificar actividad">
                  </font></div></td>
                </tr>
            </table></td>
            <td width="50%" bordercolor="#999999" bgcolor="#666666"><strong>Tipos de actividad Existentes:</strong></td>
          </tr>
          <tr valign="top">
            <td width="50%" bordercolor="#999999" bgcolor="#FFFFCC"><font size="2">
              <table width="100%"  border="1" cellpadding="0" cellspacing="2" bordercolor="#FFFFCC">
                <?
	$sql = "SELECT * FROM tipo_de_actividad ORDER by Tipo_de_actividad ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
	?>
                <tr>
                  <td width="1"><? echo  "<a href='modificarActividad.php?id=" . $row["ID_Tipo_de_actividad"]  . "'><img src='img/modificar.png' border='0' alt='Modificar esta actividad'></a>";?></td>
                  <td width="1"><? echo  "<a href='javascript:eliminar(" .  $row["ID_Tipo_de_actividad"] . ")'><img src='img/eliminar.png' border='0'  alt='Eliminar esta actividad'></a> ";
				  
				    if(substr($row["Color_de_actividad"],0,1)=="#"){
				  	
					$Color_de_actividad = "background-color:" . $row["Color_de_actividad"] . "; ";
					
				  }else{
				  	
					$Color_de_actividad = "background-image:url(img/patrones/" . $row["Color_de_actividad"] . ");";
				  }
				  ?></td>
                  <td width="18" <? if($row["Color_de_actividad"]!=""){echo "bordercolor='#000000'";}?> style="<?=$Color_de_actividad?>">&nbsp;</td>
                  <td><font size="2"><? echo $row["Tipo_de_actividad"];?></font></td>
                </tr>
                <?
	}
	  ?>
              </table>
            </font></td>
          </tr>
        </table>
		 <input name="actividad_viejo" type="hidden" id="actividad_viejo" value="<?=$actividad_viejo?>">
         <input name="actividad_ing_viejo" type="hidden" id="actividad_ing_viejo" value="<?=$actividad_ing_viejo?>">
		
      </form>
    <strong><font color="#666666" size="3"></font></strong></td>
  </tr>
</table>
