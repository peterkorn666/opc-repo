<?
include('inc/sesion.inc.php');
include('conexion.php');
?>
<link href="estilos.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CCCCCC">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php"; ?></td>
  </tr>
  <tr>
    <td valign="top"><p align="center"><strong><font color="#666666" size="3" face="Arial, Helvetica, sans-serif"><br>
    </font><font color="#666666" size="3">Unificar Instituciones </font></strong></p>
      <p align="left" class="textos"><a href="javascript: history.back()"></a></p>
      <form name="form1" method="post" action="unificarInstitucionesEnviar.php">
	  
	  <?
	  foreach($_POST["uni"] as $i){
	  ?>
	  <input name="uni[]" type="hidden" value="<?=$i?>">
	  <?
	  }
	  ?>
	  
        <table width="600" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td colspan="2"><a href="javascript: history.back()">Volver atras sin hacer cambios </a></td>
          </tr>
          <tr>
            <td colspan="2" class="textos">Se unificar&aacute;n todas las instituciones que aparecen en la lista por la que ustede seleccione.</td>
          </tr>
        	<?
		$filtro = " WHERE ID_Instituciones = ";		
		for ($i=0; $i<count($_POST["uni"]); $i++){			
			if($i>0){				
				$filtro .= " or ID_Instituciones = ";				
			}			
			$filtro .= " '" . $_POST["uni"][$i] ."' " ;			
		}		
		$sql = "SELECT * FROM instituciones $filtro ORDER by Institucion ASC";
		$rs = mysql_query($sql,$con);
		while($row=mysql_fetch_array($rs)){
			
			if ($colorfila == 0){
				$color= "#B9BBC4";
				$colorfila=1;
			}else{
				$color="#DADAE0";
				$colorfila=0;
			}	
			if($sqlPrimer!=1){
				$sel_1 = "checked";
				$sqlPrimer=1;
			}else{
			 	$sel_1 = "";
			}
			?>
			
		  <tr bgcolor="<?=$color?>">
		  
            <td width="18"><input name="uniSel" type="radio" value="<?=$row["ID_Instituciones"]?>" <?=$sel_1?>></td>
            <td width="576" class="textos">
			  <? echo $row["Institucion"];
			  	?>		 
			 </td>
          </tr>
		 
		  <?
		  }
		  ?>  
		   <tr>
		    <td colspan="2"><input name="Submit" type="submit" class="botones" value="Aceptar y Unificar" style=" width:100%"></td>
	      </tr>
        </table>
        <br>
      </form>      <p align="center"><strong><font color="#666666" size="3" face="Arial, Helvetica, sans-serif"><br></font></strong></p>	</td>
  </tr>
</table>
