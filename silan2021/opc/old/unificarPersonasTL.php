<?
include('inc/sesion.inc.php');
include('conexion.php');
?>
<link href="estilos.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<?
require("clases/personas.php");

$persona = new personas();


?>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CCCCCC">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php"; ?></td>
  </tr>
  <tr>
    <td valign="top"><p align="center"><strong><font color="#666666" size="3" face="Arial, Helvetica, sans-serif"><br>
    </font><font color="#666666" size="3">Unificar Autores Trabajos Libres</font></strong>      </p>
      <p align="left" class="textos"><a href="javascript: history.back()"></a></p>
      <form name="form1" method="post" action="unificarPersonasTLEnviar.php">
	  
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
            <td colspan="2" class="textos">Se unificar&aacute;n todas las personas que aparecen en la lista por la que ustede seleccione.</td>
          </tr>
        	<?
			$lista = $persona->selectUnificarTL($_POST["uni"]);
			while($row = mysql_fetch_object($lista)){
			
				if ($row->Institucion!=""){
					$sqlI = mysql_query("SELECT * FROM instituciones WHERE ID_Instituciones='".$row->Institucion."'",$con);
					$rowI = mysql_fetch_array($sqlI);
					$institucion = " - "  . $rowI["Institucion"];
				}else{
					$institucion = "";
				}
		
		
		if ($row->Pais!=""){
			$sqlP = mysql_query("SELECT * FROM paises WHERE ID_Paises='".$row->Pais."'",$con);
			$rowP = mysql_fetch_array($sqlP);
			$pais = " ("  . $rowP["Pais"] . ")";
		}else{
			$pais = "";
		}
		if ($row->Profesion!=""){
			$profesion = " (".$row->Profesion.")";
			}else{
			$profesion = "";
		}

		if ($row->Curriculum!=""){
			$curriculum = "&nbsp;<a href='bajando_cv.php?id=" .  $row->Curriculum . "' target='_self'><img src='img/logo_curriculum.gif' width='15' height='17' border='0' alt='Descargar curriculum de " .$row->Nombre. " " . $row->Apellidos. "'></a>";
		}else{
			$curriculum = "";
		}
		if ($row->Mail!=""){
			$mail = "&nbsp;<a href='mailto:" . $row->Mail  . "'><img src='img/logo_mail.gif' border='0' alt='Enivar mail a esta persona'></a>";
		}else{
			$mail = "";
		}
			
			
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
		  
            <td width="18"><input name="uniSel" type="radio" value="<?=$row->ID_Personas?>" <?=$sel_1?>></td>
            <td width="576" class="textos">
			  <?
				  echo " <b>" . $row->Apellidos . ", " . $row->Nombre . "</b> " . $institucion . $profesion . $pais . $curriculum . $mail . "<br>";
				  ?>		  </td>
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
