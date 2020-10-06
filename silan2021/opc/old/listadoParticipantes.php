<?
require("inc/sesion.inc.php");

$imgCoorActivo=1;
 
if (!isset($_SESSION["registrado"])){
	$_SESSION["registrado"]=false;
}
//include('inc/sesion.inc.php');

include('conexion.php');
include("inc/validarVistas.inc.php");
require "clases/listadoParticipantes.php";
$persona = new listadoPersonas;

?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script src="js/listadoParticipantes.js"></script>
<script src="js/ajax.js"></script>
<script src="js/menuEdicion.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script src="js/slide.js" type="text/javascript"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">

<!--
.personas {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	background-color: #F0F0F0;
	width: 100%;
	margin: 1px;
	padding: 4px;
	border: 1px solid #999999;
	position:relative;
}
.personasTL {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	background-color:#E8DBE8;
	width: 100%;
	margin: 1px;
	padding: 4px;
	border: 1px solid #999999;
	position:relative;
}
#Guardando{
	background-color: #FFBFBF;
	margin: 5px;
	padding: 5px;
	height: 20px;
	width: 150px;
	border: 1px solid #FF0000;
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 16px;
	font-weight: bold;
	font-style: italic;
	text-align: center;
	position:absolute;
	left:0px;
	
	visibility:hidden;
top: expression( ( 0 + ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ) ) + 'px' );


}
body > #Guardando { position: fixed; left: 0px; top: 0px; }

#msn1{
	background-color: #FFFFCC;
	margin: 2px;
	padding: 2px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	text-align: center;
	font-weight: bold;
}
#abc {
	background-color: #FFFFFF;
	padding: 2px;
	border: 1px solid #333333;
	margin: 2px;
}
#abcTL {
	background-color: #F7F4F7;
	padding: 2px;
	border: 1px solid #333333;
	margin: 2px;
}
.Estilo4 {
	color: #333333;
	font-size: 12px;
}
.Estilo5 {color: #990000}
-->
</style>

<body background="fondo_2.jpg" leftmargin="0" topmargin="0" bgproperties="fixed" marginwidth="0" marginheight="0">
<? include "inc/vinculos.inc.php";?>
<div id="Guardando">
	Guardando...
</div>

<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CCCCCC">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php"; ?></td>
  </tr>
  <tr>
    <td valign="top">
    
    <?
    if($_SESSION["registrado"] == true){
    ?>
	<div id="msn1">
	Utilice la casilla de verifiaci&oacute;n. Con un simple clic le dira al sistema que esa persona se encuentra inscripta en el congreso
	</div>
	<script>
	
	function cerrarMSN1(){
	
		document.getElementById("msn1").style.display="none";
	}
	function mostrarCurriculum(cv){
		document.getElementById("CV_"+cv).style.display = 'block';
	}
	function ocultarCurriculum(cv){
		document.getElementById("CV_"+cv).style.display = 'none';
	}
	setInterval(cerrarMSN1, 10000);
	
	</script>
	<?
    }
	?>
	
	<br>
	<form method="post" name="form1">
	<iframe id="guardarInscripcion" name="guardarInscripcion" style="display:none"></iframe>
	<? 
		$oclt = "";
		$wdht = "50%";
	 if($_SESSION["tipoUsu"]==4){
		 $oclt = "style='display:none'";
		 $wdht = "100%";
		 $txp = " de poster ";
		 $txto = " de poster y oral ";
	 }
	?>
        <table width="100%" border="0" cellspacing="10" cellpadding="2">
          <tr>
		   <? if($persona->canPersonasTOTAL!='0'){
		   ?>
            <td width="50%" height="121" valign="top" <?=$oclt?>>
     
    
     
     <?
	if ($_GET["indice"]=="") {
		$_GET["indice"]='$';
	}
	$lista = $persona->personasCongreso($_GET["indice"]);
	?>
              <div align="center" style="font-size:14px;font-weight: bold; color:#990000; height:30;">
                  Conferencistas y coordinadores<font color="#666666"> (<?=$persona->canPersonasTOTAL?>)</font><br>
				<? if ($_GET["indice"]!='$') {?>
                <span class="Estilo4">Hay [<font color="#990000" ><?=$persona->canPersonas?>
                </font>] participantes que empiezan con <font color="#990000">             
                <?=$_GET["indice"];?></font></span><? }?></div>
             
			 
			    <div align="center" id="abc"  >
                  <?
								$abc = Array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","Ñ","O","P","Q","R","S","T","U","V","W","X","Y","Z");
								foreach($abc as $i){
								
									if($_GET["indice"] == $i){
										$estIndice = "style='background-color:#ff9999;'";
									}else{
										$estIndice = "";
									}
								?>
                  <a href="?indice=<?=$i?>&indiceTL=<?=$_GET["indiceTL"]?>&idioma=<?=$_GET["idioma"]?>"  class="linkIndice" <?=$estIndice?>>&nbsp;<?=$i?>&nbsp;</a>-
			      <?
					 			}
								if($_GET["indice"] =="Todos"){
									$estIndice = "style='background-color:#ff9999;'";
								}else{
									$estIndice = "";
								}
					  ?>
                <a href="?indice=Todos&indiceTL=<?=$_GET["indiceTL"]?>&idioma=<?=$_GET["idioma"]?>" class="linkIndice" <?=$estIndice?>>&nbsp;Todos&nbsp;</a> </div>
		      <?
			  
	while ($row = mysql_fetch_object($lista)){
		
		if ($row->institucion!=""){
			$institucion = " - "  . $row->institucion;
		}else{
			$institucion = "";
		}
		
		if ($row->pais!=""){
			$pais = " ("  . $row->pais . ")";
		}else{
			$pais = "";
		}
		
		if ($row->En_calidad!=""){
			$enCalidad = $row->En_calidad . ": ";
		}else{
			$enCalidad  = "";
		}
		if ($row->profesion!=""){
			$profesion = "(".$row->profesion.")";
			}else{
			$profesion = "";
		}
		
		if ($row->curriculum!=""){
			//if($_SESSION["registrado"] == true || $verCurriculums == true){
			if(1 == 1){				
				$curriculum = "&nbsp;<a href='bajando_cv.php?id=" .  $row->curriculum . "' target='_self'><img src='img/logo_curriculum.gif' width='15' height='17' border='0' alt='Descargar curriculum de " . $row->nombre . " " . $row->apellido . "'></a>";
			}else{
				$curriculum = "";
			}
		}else{
			$curriculum = "";
		}
		
		if ($row->email!=""){
			$mail = "&nbsp;<a href='mailto:" . $row->email  . "'><img src='img/logo_mail.gif' border='0' alt='Enivar mail a esta persona'></a>";
		
			if($_SESSION["registrado"] == true || $verMails== true){
				$mail = "&nbsp;<a href='mailto:" . $row->email  . "'><img src='img/logo_mail.gif' border='0' alt='Enivar mail a esta persona'></a>";
			}else{
				$mail = "";
			}
		}else{
			$mail = "";
		}
	?>
              <div class="personas"  id="persona_<?=$row->ID_Personas?>" onMouseOver="pintar(this.id)" onMouseOut="desPintar(this.id, '#F0F0F0')" onClick="buscar('<?=$row->ID_Personas?>')">
				<?
				if($_SESSION["registrado"] == true){				
					if($row->inscripto==1){
						$fondo = "#009900";
						$sel = "checked";
					}else{
						$fondo =  "#ff0000";
						$sel = "";
					}
				?>			
                <div id='divInscripto<?=$row->ID_Personas?>' style=" margin:2px; background:<?=$fondo?>; height:20px; width:20px; position:absolute; left:0px; top:0px">
                  <input type="checkbox" name="Inscripto<?=$row->ID_Personas?>" value="1"  onMouseOver="setIR_A(0);" onMouseOut="setIR_A(1);"  onClick="actualizarInscripto('programa',<?=$row->ID_Personas?>, this,'divInscripto<?=$row->ID_Personas?>')"  <?=$sel?>>
			     </div>			
			    <?
				   echo "<div style='margin-left:25px;'>";
				  }else{
				    echo "<div>";
				  }
				if($row->curriculumTexto!=""){
					$curriculumTexto =  "<span onMouseOver='mostrarCurriculum(\"".$row->ID_Personas."\")' style='cursor:pointer; font-size:11px; color:#039;font-weight:bold;'><img src='img/cvTexto.png' border='0'></span>"; 
				}else{
					$curriculumTexto =  ""; 
				}
				 echo "<b>" . $row->apellido . ", " . $row->nombre . "</b> <font size='1'>" . $profesion . $institucion . $pais . $curriculum . $mail . "</font> ".$curriculumTexto." </div><div onClick='' id='CV_".$row->ID_Personas."' style='display:none; border:1px #333 solid; padding:5px; width:400px; position:absolute; top:-5; z-index:3; background-color:#fff;'  onMouseOut='ocultarCurriculum(\"".$row->ID_Personas."\")'>".$row->curriculumTexto."</div>"; ?>
			     </div>
            <? 
	}
	?></td>
	<?
	}
	if ($_GET["indiceTL"]=='') {
		$_GET["indiceTL"] = '$';
	}
	$lista2 = $persona->personasTL($_GET["indiceTL"]);
//	if($persona->canPersonasTL>0){
	 if($persona->canPersonasTLTOTAL!=''){
	 ?>
            <td width="<?=$wdht?>" valign="top">
		
                <div align="center" style="font-size:14px;font-weight: bold; color:#990000; height:30;"> Autores y Co-autores<font color="#666666"> (<font color="#666666">
                  <?=$persona->canPersonasTLTOTAL?>
                </font>)</font> <?=$txto?><br>
				<? if ($_GET["indiceTL"]!='$') {?>
                  <span class="Estilo4">Hay [
                      <font color="#990000">
                      <?=$persona->canPersonasTL?>
                      </font>
] autores y co-autores <?=$txp?> que empiezan con<font color="#990000">
<?=$_GET["indiceTL"];?></font></span><? } ?></div>
              
			  
			  
			    <div align="center" id="abcTL">
      							<?
								$abc = Array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","Ñ","O","P","Q","R","S","T","U","V","W","X","Y","Z");
								foreach($abc as $i){
								
									if($_GET["indiceTL"] == $i){
										$estIndice = "style='background-color:#ff9933;'";
									}else{
										$estIndice = "";
									}
								?>
								 <a href="?indice=<?=$_GET["indice"]?>&indiceTL=<?=$i?>"  class="linkIndice" <?=$estIndice?>>&nbsp;<?=$i?>&nbsp;</a>-
							    <?
					 			}
								if($_GET["indiceTL"] =="Todos"){
									$estIndice = "style='background-color:#ff9933;'";
								}else{
									$estIndice = "";
								}
					  ?>
				    <a href="?indice=<?=$_GET["indice"]?>&indiceTL=Todos" class="linkIndice" <?=$estIndice?>>&nbsp;Todos&nbsp;</a>				</div>
				
	<?
	while ($row = mysql_fetch_object($lista2)){
		
		if ($row->Institucion!=""){
			$institucion = " - "  . $row->Institucion;
		}else{
			$institucion = "";
		}
		
		if ($row->Pais!=""){
			$pais = " ("  . $row->Pais . ")";
		}else{
			$pais = "";
		}
		
		if ($row->En_calidad!=""){
			$enCalidad = $row->En_calidad . ": ";
		}else{
			$enCalidad  = "";
		}
		if ($row->Profesion!=""){
			$profesion = "(".$row->Profesion.")";
			}else{
			$profesion = "";
		}
		
		if ($row->Curriculum!=""){
			//if($_SESSION["registrado"] == true || $verCurriculums == true){
			if(1 == 1){
				$curriculum = "&nbsp;<a href='bajando_cv.php?id=" .  $row->Curriculum . "' target='_self'><img src='img/logo_curriculum.gif' width='15' height='17' border='0' alt='Descargar curriculum de " . $row->Nombre . " " . $row->Apellidos . "'></a>";
			}else{
				$curriculum = "";
			}
		}else{
			$curriculum = "";
		}
		
		if ($row->Mail!=""){
			$mail = "&nbsp;<a href='mailto:" . $row->Mail  . "'><img src='img/logo_mail.gif' border='0' alt='Enivar mail a esta persona'></a>";
		
			if($_SESSION["registrado"] == true || $verMails== true){
				$mail = "&nbsp;<a href='mailto:" . $row->Mail  . "'><img src='img/logo_mail.gif' border='0' alt='Enivar mail a esta persona'></a>";
			}else{
				$mail = "";
			}
		}else{
			$mail = "";
		}


	?>
			 <?
			 foreach($persona->trabajosQueTieneLaPersona($row->ID_Personas) as $i){
			  $numTL = $i;
			 			  
			 
			   
			   ?>
			   
                <div class="personasTL"  id="persona_TL_<?=$row->ID_Personas?>_<?=$i?>" onMouseOver="pintar(this.id)"  onMouseOut="desPintar(this.id , '#E8DBE8')"  onClick="buscarTL('<?=$row->ID_Personas?>')">
                  <?
				if($_SESSION["registrado"] == true){
				
				if($row->inscripto==1){
					$fondo = "#009900";
					$sel = "checked";
				}else{
					$fondo =  "#ff0000";
					$sel = "";
				}
				if($_SESSION["tipoUsu"]==1){
				?>
				
				<div id="divInscriptoTL<?=$row->ID_Personas?>" style="margin:2px; background:<?=$fondo?>; height:20px; width:20px; position:absolute; left:0px; top:0px">
                  <input name="InscriptoTL<?=$row->ID_Personas?>" type="checkbox" onMouseOver="setIR_A(0)" onMouseOut="setIR_A(1)" value="1"  onClick="actualizarInscripto('tl',<?=$row->ID_Personas?>, this,'divInscriptoTL<?=$row->ID_Personas?>')" <?=$sel?>>
				</div>
				  
                  <?
				}
				  echo "<div style='margin-left:25px;'>";
				  }else{
				    echo "<div>";
				  }
				
				$lee = $persona->buscarSiLee($row->ID_Personas,$i);
				
				if ($lee == '1'){
					$subra1 = "<u>";
					$subra2 = "</u>";
			   }else{
			   		$subra1 = "";
					$subra2 = "";
			   }
				 echo "<b>".$subra1. $row->Apellidos . ", " . $row->Nombre .$subra2. "</b>  <font size='1'>" . $profesion . $institucion . $pais . $curriculum;
				 if($_SESSION["tipoUsu"]!=4){
				 	echo $mail;
				 }
				 echo " </font></div>";
              ?>
			
			  <div  align="right" style=" position:relative;font-family:Arial, Helvetica, sans-serif; color:#333333; font-size:9; margin-top:5px; padding:2px;">
			<font color='#660000'>Participación en el trabajo: <strong style="font-size:12px"><?=$numTL?></strong></font> 
			 
			  <? /*
			  if(count($persona->trabajosQueTieneLaPersona($row->ID_Personas))>1){
			      echo "<font color='#333333'>Participación en los trabajos:</font> ";
			  }else{
				  echo "";
			  }
			  
			  echo  implode (", ", $persona->trabajosQueTieneLaPersona($row->ID_Personas)); */
			   ?>
			   </div>
			 </div>
			   <?

			  }
			 }
			?>	</td>
            <?
		  }
		  ?>
		  </tr>
          <tr>
            <td height="0" valign="top">&nbsp;</td>
            <td valign="top">&nbsp;</td>
          </tr>
        </table>
	  </form>
    </td>
  </tr>
</table>

 <?
if(!isset($_SESSION["LocalizadoListado"])){
	
  $sql = "SELECT Listado FROM estadisticas LIMIT 1;";
  $rs = mysql_query($sql,$con);
  while ($row = mysql_fetch_array($rs)){
  	$ultimoValor = $row["Listado"];
  }
  
  $nuevoValor	= $ultimoValor + 1;
  
  $sql1 = "UPDATE estadisticas SET Listado= $nuevoValor, Tiempo = '" . date("d/m/Y  H:i") . "' LIMIT 1 ;";
  mysql_query($sql1,$con);
  
  $_SESSION["LocalizadoListado"]=true;
}
?>