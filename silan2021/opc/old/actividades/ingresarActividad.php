<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");
$aux=$_GET["idP"];
$_GET["idP"]=base64_decode($aux);
$idPersonaNueva = $_GET["idP"];
include "../conexion.php";
include "../cronoTraductor.php";
require("../inc/inc.config.php");

require("../clases/class.baseController.php");
$base = new baseController();

$existe = true;
$arrayActividades = array();
if($_GET["idP"]!=''){
	$sql = "SELECT * FROM personas WHERE ID_Personas = ". $_GET["idP"];
	$rs = mysql_query($sql, $con);
	$existe = mysql_num_rows($rs);
	$row = mysql_fetch_object($rs);
		$dirFoto = $row->dirFoto;
		if ($dirFoto != ""){
			$pict = "&nbsp;<a href='bajando_foto.php?id=" .$dirFoto . "' target='_self'><img src='img/photo.png' width='15' height='17' border='0' alt='Descargar foto'></a>";
			$pict2 = "&nbsp;<a href='bajando_foto.php?id=" .$dirFoto . "' target='_self'><img src='img/down.png' width='15' height='17' border='0' alt='Descargar foto'></a>";
		} else {
			$pict = "";
		}		

		}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--CALENDARIO-->
<link rel="stylesheet" type="text/css" media="all" href="calendario/calendar-blue.css" title="win2k-cold-1" />
<script type="text/javascript" src="calendario/calendar.js"></script>
<? if ($idioma == "Ingles"){?>
<script type="text/javascript" src="calendario/lang/calendar-en.js"></script>
<? }else{?>
<script type="text/javascript" src="calendario/lang/calendar-es.js"></script>
<? }?>
<script type="text/javascript" src="calendario/calendar-setup.js"></script>
<!--CALENDARIO-->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>INGRESO DE ACTIVIDADES</title>
<style type="text/css">
<!--
body {
	background-color: #006699;
	font-family: Arial, Helvetica, sans-serif;
	font-size:12px;
}
-->
</style>
<script>
function ContarPalabras(cual, id){
	if(cual=="curriculum"){
		texto = document.form1.curriculum.value;	
		curriculum = texto.split(' ').length -1;
		document.getElementById("divCurriculum").innerHTML = "Cantidad de palabras: "+curriculum;		
	}else {
		if (cual=="cvAbreviado"){
			texto = document.form1.cvAbreviado.value;	
			curriculum = texto.split(' ').length -1;
			document.getElementById("divCurriculumAb").innerHTML = "Cantidad de palabras: "+curriculum;
		}else { 
			texto = document.getElementById(cual+id).value;	
			cantidad = texto.split(' ').length -1;
			document.getElementById("divDesc"+id).innerHTML = "Cantidad de palabras: "+cantidad;
		}	
	}
}
function validar(vari){
	if(document.form1.Mail.value==""){
		alert("Debe ingresar su dirección electrónica.");
		return;
	}
	/*texto0 = document.form1.cvAbreviado.value;	
	curriculum0 = texto0.split(' ').length -1;
	if(curriculum0>100){
			alert("Su curriculum abreviado excede las 100 palabras.");
			return ;
	}*/
	
	texto = document.form1.curriculum.value;	
	curriculum = texto.split(' ').length -1;
	/*if(curriculum>600){
			alert("Su curriculum excede las 600 palabras.");
			return ;
	}*/
	
	/*for(i=1; i<=vari; i++){
		texto = document.getElementById('Descripcion'+i).value;	
		cual = texto.split(' ').length -1;
		if(cual>600){
				alert("Su resumen número "+i+" excede las 600 palabras.");
				return ;
		}
	}*/
	document.form1.submit();
}
function atras(){
	document.location.href="listado.php";	
}

function todoIngles (){
	document.form1.cambiarIdioma.value = "Ingles";
	document.getElementById("sugIng").style.display = "none";
	document.getElementById("sugEsp").style.display = "block";
	//campos
	for (k=1; k<38; k++){
		document.getElementById("campEsp"+k).style.display = "none";
		document.getElementById("campIng"+k).style.display = "block";
	}
/*	for (k=1; k<38; k++){
		document.getElementById("campIng"+k).style.display = "block";
	}*/

	//menues
	for (k=1; k<4; k++){
		document.getElementById("menuEsp"+k).style.display = "none";
		document.getElementById("menuIng"+k).style.display = "block";
	}
/*	for (k=1; k<4; k++){
		document.getElementById("menuIng"+k).style.display = "block";
	} */
<?
$q ="SELECT count(*) as tope FROM actividades WHERE idPersonaNueva = '".$idPersonaNueva."' ORDER BY id";
$r = mysql_query($q ,$con);
if ($rw = mysql_fetch_array($r)) {
	echo "tope = ".$rw["tope"].";";
} else {
	echo "tope = 1";
}

?>		
	
	for (t=1; t<(tope+1); t++){
		for (k=1; k<6; k++){
			//alert("k vale:"+k);
			document.getElementById("mEsp"+k+"_"+t).style.display = "none";
			document.getElementById("mIng"+k+"_"+t).style.display = "block";
		}
	}
	/*for (t=1; t<(tope+1); t++){
		for (k=1; k<5; k++){
			document.getElementById("mIng"+k+"_"+t).style.display = "block";
		}
	}	*/
}

function todoEspanol(){
	document.form1.cambiarIdioma.value = "Espanol";
	document.getElementById("sugIng").style.display = "block";
	document.getElementById("sugEsp").style.display = "none";
	//campos
	for (k=1; k<38; k++){
		document.getElementById("campEsp"+k).style.display = "block";
		document.getElementById("campIng"+k).style.display = "none";
	}
	/*for (k=1; k<38; k++){
		document.getElementById("campIng"+k).style.display = "none";
	}*/
	//menues
	for (k=1; k<4; k++){
		document.getElementById("menuEsp"+k).style.display = "block";
		document.getElementById("menuIng"+k).style.display = "none";
	}
	/*for (k=1; k<4; k++){
		document.getElementById("menuIng"+k).style.display = "none";
	}*/
	
	<?
	$q ="SELECT count(*) as tope FROM actividades WHERE idPersonaNueva = '".$idPersonaNueva."' ORDER BY id";
	$r = mysql_query($q ,$con);
	if ($rw = mysql_fetch_array($r)) {
		echo "tope = ".$rw["tope"].";";
	} else {
		echo "tope = 1";
	}
	
	?>
	for (t=1; t<(tope+1); t++){
		for (k=1; k<6; k++){
			document.getElementById("mIng"+k+"_"+t).style.display = "none";
			document.getElementById("mEsp"+k+"_"+t).style.display = "block";
		}
	}
	/*for (t=1; t<(tope+1); t++){
		for (k=1; k<5; k++){
			document.getElementById("mEsp"+k+"_"+t).style.display = "block";
		}
	}*/
	
}
/*
function cambiarIdioma() {
	document.form1.cambiarIdioma.value = document.form1.curriculum.value;
}*/
function mostrarDiv(cual) {
	document.getElementById(cual).style.display='block';
}
function ocultarDiv(cual) {
	document.getElementById(cual).style.display='none';
}
</script>
<script src="../js/jquery.1.4.2.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function(e) {
		$("#cnlcarga").live("click",function(){			
			$("#dirFoto").val("");
			$("#texto_archivo_usuario").html("");
		})
        $("#photo").click(function(){
			$("#dirFoto").click();
		})
		$("#dirFoto").live("change",function(){
			$("#texto_archivo_usuario").html($("#dirFoto").val()+" <img src='../imagenes/cerrar.png' id='cnlcarga' width='11' title='Cancelar subida'>");
		})
		
		
		//Ponencias
	
        $(".ponencia_btn").click(function(){
			$("#ponencia_file"+$(this).attr("id")).click();
		})
		
		
		$(".ponencia_file").live("change",function(){
			$("#txt_ponencia"+$(this).attr("data-id")).html("<b>(</b>"+$("#ponencia_file"+$(this).attr("data-id")).val()+"<b>)</b>");
		})
		
    });
</script>
</head>
<body style="background-image:url(../../imagenes/fondo.gif); background-repeat:repeat;">
<center>
<form action="ingresarActividadEnviar.php" method="post" name="form1" id="form1" enctype="multipart/form-data" >

  <table width="800" border="0" align="center" cellpadding="2" cellspacing="0">    
    <tr>
      <td colspan="5" align="center" bgcolor="#006699"><div id="campEsp37"></div><div id="campIng37" style="display:none;"><img src="programa/imagenes/banner_opc_eng.jpg" width="689" height="106" /></div></td>
      </tr>
    </table>
  <img src="../../images/banner.jpg" /><br /><input type="hidden" name="cambiarIdioma" value="<?=$idioma?>"/>
<?
if($_SESSION["LogIn"]=="ok"){?>
    <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFEBD7">
   	  <tr>
        <td width="244" bgcolor="#FFCC99" style="padding:3px"><em><strong>Comentarios internos del administrador</strong></em></td>
      	<td width="447" bgcolor="#FFCC99" style="padding:3px"><em><strong>Informaci&oacute;n:</strong></em></td>
      	<td width="109" align="right" bgcolor="#FFCC99" style="padding:3px"><strong>ID:&nbsp;<?=$row->ID_Personas?>
      	</strong></td>
   	  </tr>
      	<tr>
      	  <td valign="top" align="center"><textarea name="comentarios"  id="comentarios"  style="width:90%; font-size:12px; " <? if ($idioma!="Ingles"){ echo "rows='7'"; } else { echo "rows='7'"; } ?> ><?=$comentarios;?></textarea></td>
   	      <td colspan="2" valign="top" style="padding:0px"><table width="100%" border="0" cellspacing="0" cellpadding="3">
   	        <tr>
   	          <td width="28%" bgcolor="#FFEBD7">   	            Confirmado que viene: </td>
   	          <td width="20%" align="left" bgcolor="#FFEBD7"><input type="radio" name="actividad_confirma_viene" value="1" <? if($row->actividad_confirma_viene=='1'){ echo "checked";}?> />
   	            S&iacute;
   	            <input type="radio" name="actividad_confirma_viene" value="0" <? if($row->actividad_confirma_viene=='0'){ echo "checked";}?> />
   	            No</td>
   	          <td width="25%" align="right" bgcolor="#FFEBD7">&Aacute;rea</td>
   	          <td width="27%" bgcolor="#FFEBD7"><span style="padding:3px">
   	            <select name="actividad_areas" style="width:90%">
   	              <option value='' >Seleccione</option>
				  <?php
				  	$queryAreas = $base->areasActividad();
					while($rowAreas = mysql_fetch_object($queryAreas)){
						if($rowAreas->id==$row->actividad_areas){
							$chkArea = "selected";
						}
						echo "<option value='$rowAreas->id' $chkArea>$rowAreas->area_abr</option>";
						$chkArea = "";
					}
					
				  ?>
                  <option value='7' <? if(7==$row->actividad_areas){echo "selected";} ?>>Protocolar</option>
                  <option value='8' <? if(8==$row->actividad_areas){echo "selected";} ?>>Varias &aacute;reas</option>
                  <option value='9' <? if(9==$row->actividad_areas){echo "selected";} ?>>Congreso</option>
                </select>
   	            </span></td>
            </tr>
   	        <tr>
   	          <td bgcolor="#FFEBD7">Internacional:</td>
   	          <td bgcolor="#FFEBD7"><input type="radio" name="actividad_internacional" value="1" <? if($row->actividad_internacional=='1'){ echo "checked";}?> />
   	            S&iacute;
   	            <input type="radio" name="actividad_internacional" value="0" <? if($row->actividad_internacional=='0'){ echo "checked";}?> />
   	            No</td>
   	          <td align="right" bgcolor="#FFEBD7">Presento Ponencia:</td>
   	          <td bgcolor="#FFEBD7"><input type="radio" name="actividad_tienePonenecia" value="1" <? if($row->actividad_tienePonenecia=='1'){ echo "checked";}?> />
S&iacute;
<input type="radio" name="actividad_tienePonenecia" value="0" <? if($row->actividad_tienePonenecia=='0'){ echo "checked";}?> />
No</td>
            </tr>
            <? /* } */ ?>
         <!--     <tr>
              <td bgcolor="#FFEBD7" valign="top" align="">Titulo: </td>
              <td colspan="2" bgcolor="#FFEBD7"><input type="text" name="ponencia" style="width:265px" value="<?=$ponencia?>"/></td>
            </tr>
           <tr>
              <td bgcolor="#FFEBD7">Foto:</td>
              <td bgcolor="#FFEBD7">&nbsp;</td>
             </tr>-->
          </table></td>
      	</tr>
    </table>
      <br />
<? }?>
<br />

<table width="800" border="0" align="center" cellpadding="2" cellspacing="0">
<tr>
    <td colspan="4" bgcolor="#AEDCF7">
<div id="sugIng" onClick="todoIngles();" style="font-size:13px; color:#003399; text-decoration:underline; text-align:center; cursor:pointer;">Click here for english version</div>
<div id="sugEsp" onClick="todoEspanol();" style="font-size:13px; color:#003399; text-decoration:underline; text-align:center; cursor:pointer; display:none">Click aqu&iacute; para cambiar a espa&ntilde;ol</div>    </td>
    </tr>
    <tr>
    <td colspan="4" bgcolor="#AEDCF7" align="center">
    <div id="menuEsp1"><strong><em>Escriba sus datos personales tal como desea que aparezcan en el Programa Final del Congreso
</em></strong></div>
    <div id="menuIng1" style="display:none;"><strong><em>Enter your personal data in the way you wish to appear in the Final Program of the Congress</em></strong></div>    </td>
    </tr>
    <tr>
    <td align="right" bgcolor="#E2F8FE">
    <div id="campEsp1" >Profesi&oacute;n:&nbsp;</div>
    <div id="campIng1" style="display:none;" >Profession:&nbsp;</div>    </td>
    <td width="304" align="left" bgcolor="#E2F8FE"><input type="text" name="profesion" style="width:250px" value="<?=$row->profesion?>"/></td>
    <td width="141" align="right" bgcolor="#E2F8FE">
    <div id="campEsp2" >Correo electr&oacute;nico:&nbsp;</div>
    <div id="campIng2" style="display:none;" >E-mail:&nbsp;</div>    </td>
    <td width="261" align="left" bgcolor="#E2F8FE"><input type="text" name="email" style="width:95%"  value="<?=$row->email?>" /></td>
    </tr>
  <tr>
    <td width="78" align="right" bgcolor="#E2F8FE">
    <div id="campEsp3" >Nombres:&nbsp;</div>
    <div id="campIng3" style="display:none;" >Names:&nbsp;</div>    </td>
    <td align="left" bgcolor="#E2F8FE"><input type="text" name="nombre" style="width:250px" value="<?=$row->nombre?>" /></td>
    <td align="right" bgcolor="#E2F8FE"><div id="campEsp4" >Tel&eacute;fono:&nbsp;</div>
    <div id="campIng4" style="display:none;" >Phone:&nbsp;</div>    </td>
    <td align="left" bgcolor="#E2F8FE"><input type="text" name="telefono" style="width:95%" value="<?=$row->tel?>"/></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#E2F8FE">
    <div id="campEsp5" >Apellido:&nbsp;</div>
    <div id="campIng5" style="display:none;" >Surname:&nbsp;</div>    </td>
    <td align="left" bgcolor="#E2F8FE"><input type="text" name="apellido" style="width:250px"  value="<?=$row->apellido?>"/></td>
    <td align="right" bgcolor="#E2F8FE">
    <div id="campEsp6" > Cargo / Instituci&oacute;n:&nbsp;</div>
    <div id="campIng6" style="display:none;" >Position / Institution Spanish:</div></td>
    <td align="left" bgcolor="#E2F8FE"><input type="text" name="institucion" style="width:95%" value="<?=$row->institucion?>"/>
      <!--<input type="text" name="Cargos" style="width:300px" value="<?=$Cargos?>"/>--></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#E2F8FE"><div id="campEsp7" >Ciudad:&nbsp;</div></td>
    <td align="left" bgcolor="#E2F8FE"><input type="text" name="ciudad" style="width:250px" value="<?=$row->ciudad?>"/></td>
    <td align="right" bgcolor="#E2F8FE">&nbsp;</td>
    <td rowspan="3" align="center" bgcolor="#E2F8FE">
        <?php
	  	if($dirFoto!=""){
			$photo = $dirFoto;
		}else{
			$photo = "../imagenes/nophoto.jpg";
		}
	  ?>
        <img src="<?=$photo?>" style="max-height:150px; max-width:120px" />
        </td>
  </tr>
  <tr>
    <td width="78" align="right" bgcolor="#E2F8FE"><?
	 $paises = array("","Abkhazia","Afghanistan","Akrotiri and Dhekelia","Aland","Albania","American Samoa","Andorra","Angola","Anguilla","Antigua and Barbuda","Argentina","Armenia","Aruba","Ascension Island","Australia","Austria","Azerbaijan","Bahamas, The","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia and Herzegovina","Botswana","Brazil","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central African Republic","Chad","Chile","China, People´s Republic of","China, Republic of","Christmas Island","Cocos","Colombia","Comoros","Congo, Democratic Republic of","Congo, Republic of","Cook Islands","Costa Rica","C&ocirc;te d'Ivoire","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","Gabon","Gambia, The","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea-Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Korea, Democratic People's Republic of","Korea, Republic of","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macao","Macedonia, Republic of","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mayotte","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Nagorno-Karabakh","Namibia","Nauru","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Niue","Norfolk Island","Northern Cyprus","Northern Mariana Islands","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Pitcairn Islands","Poland","Portugal","Pridnestrovie","Puerto Rico","Qatar","Romania","Russia","Rwanda","Saint Barthelemy","Saint Helena","Saint Kitts and Nevis","Saint Lucia","Saint Martin","Saint Pierre and Miquelon","Saint Vincent and the Grenadines","Samoa","San Marino","S&atilde;o Tom&eacute; and Pr&iacute;ncipe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","Somaliland","South Africa","South Ossetia","Spain","Sri Lanka","Sudan","Suriname","Svalbard","Swaziland","Sweden","Switzerland","Syria","Tajikistan","Tanzania","Thailand","Timor-Leste","Togo","Tokelau","Tonga","Trinidad and Tobago","Tristan da Cunha","Tunisia","Turkey","Turkmenistan","Turks and Caicos Islands","Tuvalu","Uganda","Ukraine","United Arab Emirates","UK - United Kingdom","Uruguay", "USA - United States of America", "Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands, British","Virgin Islands, United States","Wallis and Futuna","Western Sahara","Yemen","Zambia","Zimbabwe");
	 ?>
      <div id="campEsp9" >Pa&iacute;s:&nbsp;</div>
      <div id="campIng9" style="display:none;" >Country:&nbsp;</div>    </td>
    <td align="left" bgcolor="#E2F8FE">
      <select name="pais" style="width:250px;" >
        <?
	 foreach ($paises as $i){

		if($row->pais == $i){
			$sel = "selected";
		}else{
			$sel = "";
		}

	echo  "<option value='".$i."' $sel>$i</option>";
	}
	 ?>
        </select></td>
    <td rowspan="2" align="center" bgcolor="#E2F8FE">
      <div style="width:170px; cursor:pointer">
        <fieldset style="background:#FAFAFA; padding:0px">
          <div style="padding: 10px 10px 0 10px; font-size: 12px;"  id="photo">
            <?php
			if($dirFoto==""){
				$txtFoto = "CARGAR";
			}else{
				$txtFoto = "CAMBIAR";
			}
			?>
            HAGA CLICK AQU&Iacute; PARA <?=$txtFoto?> SU FOTO
            </div>
          <div id="texto_archivo_usuario" style="margin-top:5px; margin-bottom:5px;"></div>
          
          </fieldset>
        </div>
      <input style="width:99%; height:30px; visibility:hidden" name="dirFoto" type="file" id="dirFoto"  />
      <input type="hidden" name="dirFoto_vieja" value="<?=$dirFoto?>" />
      </td>
    </tr>
    <tr>
      <td align="right" valign="top" bgcolor="#E2F8FE"><div id="campIng12" style="display:none;" >Paper:&nbsp;</div>
        Comentarios</td>
      <td align="left" valign="top" bgcolor="#E2F8FE"><textarea name="comentarios2" style="width:90%;" rows="5"><?=$row->actividad_comentarios?></textarea></td>
      </tr>
    <tr>
      <td align="right" bgcolor="#E2F8FE">Curriculum</td>
      <td align="left" bgcolor="#E2F8FE">
      	<input type="file" name="archivo_cv" />
        <input type="hidden" value="<?=$row->archivo_cv?>" name="dirCv_vieja" />
      </td>
      <td colspan="2" align="left" valign="bottom" bgcolor="#E2F8FE"><?php if(!empty($row->archivo_cv)){echo "<a href='../".$row->archivo_cv."' target='_blank'>Descargar curriculum aqu&iacute;</a>";} ?></td>
    </tr>
    <tr style="display:none">
      <td align="right" bgcolor="#E2F8FE">&nbsp;</td>
      <td align="left" bgcolor="#E2F8FE">&nbsp;</td>
      <td colspan="2" align="left" valign="bottom" bgcolor="#E2F8FE"><div id="campEsp15" >Cargue aqu&iacute; su presentaci&oacute;n escrita. M&aacute;ximo 2000Kb</div><div id="campIng15" style="display:none;" >Load here your speech. Maximum 2.000Kb</div><br />
        <div id="campEsp13" > 
          <? if ($dirFoto!='') { ?>
          
          Ud ya tiene una ponencia adjunta <?=$pict2?><!--<a href='<?=$dirFoto?>' target='_blank' >descargar</a>-->
          <? } ?></div>
        <div id="campIng13" > 
          <? if ($dirFoto!='') { ?>
          You have already uploaded a paper <?=$pict2?><!--<a href='<?=$dirFoto?>' target='_blank' >download</a>-->
        <? } ?></div>   </td>
    </tr>
    </table>
<br />
<table width="800"ccellpadding="0" cellspacing="0" <? if(!$config["actividad_alojamiento"])echo "style='display:none'";?>>    
            <tr>
              <td colspan="10" align="center" valign="top" bgcolor="#AEDCF7"><em><strong>
 <div id="campEsp8" >Alojamiento y traslados</div>
    <div id="campIng8" style="display:none;" >Accommodation and transfers</div></strong></em></td>
            </tr>
            <tr>
              <td width="9%" valign="top" bgcolor="#E2F8FE">HOTEL:</td>
              <td colspan="2" valign="top" bgcolor="#E2F8FE">
              <input type="text" name="hotel" style="width:90%" value="<?=$row->actividad_hotel?>"/></td>
              <td width="37%" colspan="7" valign="top" bgcolor="#E2F8FE">In:
                <input type="text" name="hotel_in" style="width:123px" value="<?=$row->actividad_hotel_in?>"/>
&nbsp;&nbsp;
              Out:
              <input type="text" name="hotel_out" style="width:123px" value="<?=$row->actividad_hotel_out?>"/></td>
            </tr>
            <tr>
            <td colspan="7" bgcolor="#E2F8FE"><hr  style="color:#333;"/></td>
      </tr>         
<tr>
              <td rowspan="2" valign="top" bgcolor="#E2F8FE"><span style="color:#C30; font-weight:bold"><div id="campEsp16" >ARRIBO</div><div id="campIng16" style="display:none;"  >ARRIVAL</div></span></td>
              <td width="13%" valign="top" bgcolor="#E2F8FE"><div id="campEsp17">Compa&ntilde;ia</div>
<div id="campIng17" style="display:none;">Airline Company: </div></td>
              <td width="29%" valign="top" bgcolor="#E2F8FE"><input type="text" name="comp_ll" style="width:90%" value="<?=$row->actividad_hotel_compania?>"/></td>
              <td width="12%" valign="top" bgcolor="#E2F8FE"><div id="campEsp18">Vuelo: </div><div id="campIng18" style="display:none;">Flight number: </div></td>
              <td colspan="3" valign="top" bgcolor="#E2F8FE"><input type="text" name="vuelo_ll" style="width:90%" value="<?=$row->actividad_hotel_vuelo?>"/></td>
      </tr>
            <tr>
              <td valign="top" bgcolor="#E2F8FE"><div id="campEsp19">Fecha:</div><div id="campIng19" style="display:none;">Date:</div></td>
              <td valign="top" bgcolor="#E2F8FE"><input type="text" name="fecha_ll" id="campo_fecha"  value="<?=$row->actividad_hotel_fecha_llegada?>"/>    <input type="button" id="lanzador" value="..." /></td>
              <td valign="top" bgcolor="#E2F8FE"><div id="campEsp20">Hora:</div><div id="campIng20" style="display:none;">Time:</div></td>
              <td colspan="3" valign="top" bgcolor="#E2F8FE"><select name="hora_ll" style="width:90%">
                <option value='' >&nbsp;</option>
                <? for ($i=0; $i<24; $i++){	?>
                <option value='<?=$i?>:00' <? if ($row->actividad_hotel_hora=="$i:00"){echo "selected"; }?>>
                  <?=$i?>
                  :00</option>
                <option value='<?=$i?>:15' <? if ($row->actividad_hotel_hora=="$i:15"){echo "selected"; }?>>
                  <?=$i?>
                  :15</option>
                <option value='<?=$i?>:30' <? if ($row->actividad_hotel_hora=="$i:30"){echo "selected"; }?>>
                  <?=$i?>
                  :30</option>
                <option value='<?=$i?>:45' <? if ($row->actividad_hotel_hora=="$i:45"){echo "selected"; }?>>
                  <?=$i?>
                  :45</option>
                <? }	?>
              </select></td>
            </tr>

            <tr>
            <td colspan="7" bgcolor="#E2F8FE"><hr  style="color:#333;"/></td>
      </tr>
            <tr>
              <td width="9%" rowspan="2" valign="top" bgcolor="#E2F8FE"><span style="color:#C30; font-weight:bold"><div id="campEsp36">PARTIDA</div><div id="campIng36" style="display:none;">DEPARTURE</div></span></td>
              <td width="13%" valign="top" bgcolor="#E2F8FE"><div id="campEsp24">Compa&ntilde;ia:</div><div id="campIng24" style="display:none;">Airline Company:</div></td>
              <td width="29%" valign="top" bgcolor="#E2F8FE"><input type="text" name="comp_sal" style="width:90%" value="<?=$row->actividad_hotel_partida_compania?>"/></td>
              <td width="12%" valign="top" bgcolor="#E2F8FE"><div id="campEsp25">Vuelo:</div><div id="campIng25" style="display:none;">Flight number:</div></td>
              <td width="37%" colspan="3" valign="top" bgcolor="#E2F8FE"><input type="text" name="vuelo_sal" style="width:90%" value="<?=$row->actividad_hotel_vuelo_salida?>"/></td>
            </tr>
            <tr>
              <td valign="top" bgcolor="#E2F8FE"><div id="campEsp26">Fecha:</div><div id="campIng26" style="display:none;">Date:</div></td>
              <td valign="top" bgcolor="#E2F8FE"><input type="text" name="fecha_sal" id="campo_fecha2"  value="<?=$row->actividad_hotel_fecha_salida?>"/>
      <input type="button" id="lanzador2" value="..." /></td>
              <td valign="top" bgcolor="#E2F8FE"><div id="campEsp27">Hora:</div><div id="campIng27" style="display:none;">Time:</div></td>
              <td colspan="3" valign="top" bgcolor="#E2F8FE"><select name="hora_sal" style="width:90%">
                <option value='' >&nbsp;</option>
                <? for ($i=0; $i<24; $i++){	?>
                <option value='<?=$i?>:00' <? if ($row->actividad_hotel_hora_salida=="$i:00"){echo "selected"; }?>>
                  <?=$i?>
                  :00</option>
                <option value='<?=$i?>:15' <? if ($row->actividad_hotel_hora_salida=="$i:15"){echo "selected"; }?>>
                  <?=$i?>
                  :15</option>
                <option value='<?=$i?>:30' <? if ($row->actividad_hotel_hora_salida=="$i:30"){echo "selected"; }?>>
                  <?=$i?>
                  :30</option>
                <option value='<?=$i?>:45' <? if ($row->actividad_hotel_hora_salida=="$i:45"){echo "selected"; }?>>
                  <?=$i?>
                  :45</option>
                <? }	?>
              </select></td>
            </tr>

            <tr>
              <td colspan="5" valign="top" bgcolor="#E2F8FE"><hr  style="color:#333;"/></td>
      </tr>
            <tr>
              <td colspan="2" align="left" valign="middle" bgcolor="#E2F8FE"><div id="campEsp31">&iquest;Viaja con acompa&ntilde;ante?</div><div id="campIng31" style="display:none;">Traveling with someone?</div></td>
              <td width="61" align="left" valign="middle" bgcolor="#E2F8FE"><input type="radio" name="compa" onclick="ocultarDiv('compaDiv')" value="No" <? if($row->actividad_hotel_tiene_acomp=='No'){ echo "checked";}?>/> No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" onclick="mostrarDiv('compaDiv')" name="compa" value="Si" <? if($row->actividad_hotel_tiene_acomp=='Si'){ echo "checked";}?>/>
              Si</td>
              <td width="557" align="left" valign="middle" bgcolor="#E2F8FE"><div id="campIng32" style="display:none;width:50px">Yes</div></td>
              <td bgcolor="#E2F8FE">&nbsp;</td>
            </tr>
    </table>
    <div id="compaDiv" style="display:none">
<table width="800" border="0" align="center" cellpadding="3" cellspacing="0">
    <tr>
        <td width="353" valign="top" bgcolor="#E2F8FE"><div id="campEsp33">Indique en nombre completo de su acompa&ntilde;ante</div><div id="campIng33" style="display:none;">Provide name and last name of the person you are traveling with</div></td>
        <td width="435" colspan="2" bgcolor="#E2F8FE"><input type="text" name="nombre_acompa" style="width:350px" value="<?=$nombre_acompa?>"/></td>
    </tr>



            <tr>
              <td width="21%" valign="middle" bgcolor="#E2F8FE"><div id="campEsp34">&iquest;Lleva su propia port&aacute;til?</div><div id="campIng34" style="display:none;">Bringing your own Notebook?</div></td>
              <td width="79%" colspan="2" valign="middle" bgcolor="#E2F8FE"><input type="radio" name="notebook" value="PC" <? if($row->actividad_hotel_tiene_portatil=='PC'){ echo "checked";}?>/> 
                PC
                  <input type="radio" name="notebook" value="MAC" <? if($row->actividad_hotel_tiene_portatil=='MAC'){ echo "checked";}?>/> 
              MAC</td>
      </tr>
            <tr>
              <td colspan="3" align="center" valign="middle" bgcolor="#E2F8FE"><div id="campEsp35">Si usted hace su presentación con su propio <strong>portátil MAC </strong>por favor, <strong>recuerde traer adaptadores adecuados</strong>.</div><div id="campIng35" style="display:none;">If you make your presentation using your own <strong>MAC Notebook</strong> please remember to <strong>bring suitable adaptors</strong>.</div></td>
      </tr>
    </table>
    </div>
<br />
<table width="800" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr>
    <td colspan="5" height="10"></td>
  </tr>
  <tr>
    <td colspan="5" bgcolor="#AEDCF7">
    <div id="menuEsp2"><em><strong>Curriculum abreviado</strong></em> que se leer&aacute; en el momento de su disertaci&oacute;n (hasta 100 palabras en cada idioma) </div>
    <div id="menuIng2" style="display:none;"><strong>Brief Curriculum</strong> to be read at the time of his dissertation (up to 100 words in each language) </div>
    </td>
  </tr>
  <tr>
    <td colspan="5" align="left" bgcolor="#E2F8FE" style="padding:5px">
    <div id="divCurriculumAb"  align="left">Cantidad de palabras: 0</div>
        <textarea name="cvAbreviado" id="cvAbreviado"  style="width:100%; font-size:12px" onkeyup="ContarPalabras('cvAbreviado', '1');" rows="3"><?=$row->cv?></textarea>       </td>
  </tr>
  <tr>
    <td colspan="5" height="10"></td>
  </tr>
  <tr>
    <td colspan="5" bgcolor="#AEDCF7">
    <div align="left" id="menuEsp3"><em><strong>Curriculum extendido</strong></em> (hasta 600 palabras) </div>
    <div align="left" id="menuIng3" style="display:none"><strong>Extended Curriculum</strong> (up to 600 words) </div>
    </td>
  </tr>
  <tr>
    <td colspan="5" bgcolor="#E2F8FE"><div id="divCurriculum"  align="left">Cantidad de palabras: 0</div></td>
  </tr>
  <tr>
    <td colspan="5" bgcolor="#E2F8FE" align="left" style="padding:10px"><input name="curriculum" type="text" id="curriculum" style="width:100%; font-size:12px" onkeyup="ContarPalabras('curriculum', '1')" value="<?=$row->actividad_cv_extendido?>" /></td>
  </tr>
  </table>
<br />
<? 
$var = 1;
$sqlAct = "SELECT * FROM congreso WHERE ID_persona = '".$idPersonaNueva."' GROUP BY Dia_orden, Hora_inicio, Titulo_de_actividad ORDER BY Dia_orden, Sala, Hora_inicio;";
$rsAct = mysql_query($sqlAct,$con);

$sqlActividad ="SELECT * FROM actividades WHERE idPersonaNueva = '".$idPersonaNueva."' ORDER BY id";
$rsActividad = mysql_query($sqlActividad ,$con);
while($RowA[] = mysql_fetch_array($rsActividad));
//var_dump($RowA);
$ra = 0;
while($rowAct = mysql_fetch_array($rsAct)){ 
$sqlConf = "SELECT * FROM congreso WHERE Casillero = '".$rowAct["Casillero"]."' ORDER BY Orden_aparicion";
$queryConf = mysql_query($sqlConf,$con);


//if($rowAct["Titulo_de_actividad"]!=$Titulo){

?>
	<table width="800" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr>
    <td bgcolor="#AEDCF7">&nbsp;</td>
    <td width="473" bgcolor="#AEDCF7">
    <div align="left" id="mEsp1_<?=$var;?>"><em><strong>Actividad 
      <?=$var.":";?>
      <? if($rowAct["Tematicas"]!=""){echo "<span style='color:#990000'>".$rowAct["Tematicas"]."</span>&nbsp;&nbsp; - &nbsp;&nbsp;";} if($rowAct["Titulo_de_trabajo"]!=""){echo $rowAct["Titulo_de_trabajo"];}?>
    </strong></em></div>
    <div align="left" id="mIng1_<?=$var;?>" style="display:none"><strong>Activity 
      <?=$var;?>
      <? if($rowAct["Titulo_de_trabajo_ing"]!=""){echo ": ".$rowAct["Titulo_de_trabajo_ing"];}?>
    </strong></div></td>
    <td colspan="3" align="right" bgcolor="#AEDCF7">
    <div id="mEsp4_<?=$var;?>" ><? if($rowAct["En_calidad"]!=""){ echo "Rol:";}?> <strong><?=$rowAct["En_calidad"];?></strong></div>
	<div id="mIng4_<?=$var;?>" style="display:none;" ><? if($rowAct["En_calidad"]!=""){ echo "Role:";}?> <strong><?=$arrCalidad[$rowAct["En_calidad"]];?></strong></div>
   
	</td>
  </tr>
  <tr>
    <td bgcolor="#E2F8FE">&nbsp;</td>
    <td colspan="2" bgcolor="#E2F8FE">
      <div align="left" id="mEsp5_<?=$var;?>"><strong>
        
        
        D&iacute;a: <?=$rowAct["Dia"]?>
  &nbsp;&nbsp; </strong><strong>
    <?
	 $sqlVarSal = "SELECT DISTINCT c.Sala, s.Sala_ing FROM congreso c, salas s  WHERE c.ID_persona = '".$idPersonaNueva."' AND c.Dia_orden = '".$rowAct["Dia_orden"]."' AND c.Hora_inicio = '".$rowAct["Hora_inicio"]."' AND c.Titulo_de_actividad = '".$rowAct["Titulo_de_actividad"]."' AND c.Sala_orden = s.Sala_orden ORDER BY c.Sala_orden;";

	$rsVarSal = mysql_query($sqlVarSal ,$con) or die(mysql_error());
	
	echo "Sala: ";
	while($rowVarSal = mysql_fetch_array($rsVarSal)){ 
		echo $rowVarSal["Sala"];
		echo "  ";
	}
	?>
    </strong><strong>
      &nbsp;&nbsp;&nbsp;
      <?="Hora: ".substr($rowAct["Hora_inicio"],0,-3)." a ".substr($rowAct["Hora_fin"],0,-3)?>
      </strong></div>
      
    </td>
    <td bgcolor="#E2F8FE">
      <input type="hidden" name="idActiv<?=$var?>" value="<?=$RowA[$ra]["id"]?>" />
      <input type="hidden" name="casilero_<?=$var?>" value="<?=$rowAct["Casillero"]?>" />
      <input type="hidden" name="Tituloactividad<?=$var?>" value="<?=$rowAct["Titulo_de_actividad"]?>" />
      <input type="hidden" name="TituloactividadIng<?=$var?>" value="<?=$rowAct["Titulo_de_actividad_ing"]?>" />
      <input type="hidden" name="Titulotrabajo<?=$var?>" value="<?=$rowAct["Titulo_de_trabajo"]?>" />
      <input type="hidden" name="TitulotrabajoIng<?=$var?>" value="<?=$rowAct["Titulo_de_trabajo_ing"]?>" />
      <? if($_SESSION["LogIn"]=="ok"){?>
      <div style="background-color:#FFCC99">
        <input type="checkbox" name="confirmado<?=$var?>" value="1" <? if($RowA[$ra]["confirmado"]==1){ echo "checked";}?>/>
        confirmado</div>
      <? }?></td>
    </tr>
    <tr bgcolor="#FDDBDB">
      <td valign="top" bgcolor="#E2F8FE">&nbsp;</td>
      <td colspan="3" valign="top" bgcolor="#E2F8FE" style="color:#990000"><strong>
        <?=str_replace("<br>", " ", $rowAct["Titulo_de_actividad"]);?>
      </strong></td>
    </tr>
    <tr bgcolor="#FDDBDB">
      <td valign="top" bgcolor="#E2F8FE">&nbsp;</td>
      <td colspan="3" valign="top" bgcolor="#E2F8FE"><?php
	  	//echo $sqlConf."//";
	  	while($row = mysql_fetch_object($queryConf)){
			$sqlPers = "SELECT * FROM personas WHERE ID_Personas='$row->ID_persona'";
		//	echo $sqlPers;
			$queryPers = mysql_query($sqlPers,$con) or die(mysql_error());
			$rowPers = mysql_fetch_object($queryPers);
			
			echo "<div style='padding-left:20px;'>";
			echo "<span style='color:#403E0B'><strong>".$row->Titulo_de_trabajo."</strong></span>";
				echo "<div style='padding-left:20px'>";
					echo "$row->En_calidad <strong>".$rowPers->profesion." ".$row->Nombre." ".$row->Apellidos."</strong> <i>$rowPers->pais - $rowPers->institucion</i> <strong>- $rowPers->email</strong>";
				echo "</div>";
			echo "</div>";
		}
	  ?></td>
      </tr>
    <tr bgcolor="#FDDBDB">
    <td valign="top" bgcolor="#E2F8FE">&nbsp;</td>
    <td colspan="3" valign="top" bgcolor="#E2F8FE">Comentarios:
      <input type="text" name="coment<?=$var?>" id="coment<?=$var?>" style="width:72%" value="<?=$RowA[$ra]["coment"]?>"/></td>
    </tr>
  <tr>
    <td width="10" valign="top" bgcolor="#E2F8FE">
    <!--<div align="left" id="mEsp4_<?=$var;?>">Resumen:</div>
    <div align="left" id="mIng4_<?=$var;?>" style="display:none">Abstract:</div> &nbsp; -->   </td>
    <td colspan="2" valign="top" bgcolor="#E2F8FE">
      <!--<textarea name="Descripcion<?=$var?>"  id="Descripcion<?=$var?>"  style="width:95%; font-size:12px; font:Arial, Helvetica, sans-serif" rows="4" onkeyup="ContarPalabras('Descripcion','<?=$var?>')"><?=str_replace("<br />", "", $RowA[$ra]["Descripcion"])?>
    </textarea>-->
      
      <!--<div id="divDesc<?=$var?>"  align="left">Cantidad de palabras: 0</div>--></td>
    <td width="108" colspan="-1" valign="top" bgcolor="#E2F8FE"><? if($_SESSION["LogIn"]=="ok"){?>
      <div style="background-color:#FFCC99"><input type="checkbox" name="ubicado<?=$var?>" value="1" <? if($RowA[$ra]["ubicado"]==1){ echo "checked";}?>/>Ubicado</div>
      <? 
	}
	$Titulo = $rowAct["Titulo_de_actividad"];
	?></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#E2F8FE">&nbsp;</td>
    <td colspan="3" valign="top" bgcolor="#E2F8FE">Ponencia:&nbsp;&nbsp; <span id='<?=$var?>' class="ponencia_btn" style="padding:5px;background:#FAFAFA; border:1px solid">Si aplica, haga click aqui para cargar su ponencia <span id="txt_ponencia<?=$var?>"><?=($RowA[$ra]["archivoPonencia"]!=""?"<strong><a href='ponencias/".$RowA[$ra]["archivoPonencia"]."' target='_blank'>(Ya tiene una ponencia)</a></strong>":"")?></span></span><input type="file" style="visibility:hidden" name="ponencia_file<?=$var?>" id="ponencia_file<?=$var?>" class="ponencia_file" data-id="<?=$var?>" />
    <input type="hidden" name="ponencia_vieja<?=$var?>" value="<?=$RowA[$ra]["archivoPonencia"]?>" />
    </td>
    </tr>
    </table>
<br />
<? //}
$ra++;
$var = $var+1;
}
?>
<input type="hidden" name="variable" value="<?=$ra;?>" />
<input type="hidden" name="idPersonaSistema" id="idPersonaSistema" value="<?=$_GET["idP"]?>" >
<input type="hidden" name="idPersonaNueva" id="idPersonaNueva" value="<?=$idPersonaNueva?>" > 
<input type="hidden" name="entradas" id="entradas" value="<?=$entradas?>" >
<input type="hidden" name="id" id="id" value="<?=$id?>" >
<br />
<? if($_SESSION["LogIn"]=="ok"){?>
	<input type="button" onclick="atras()" name="volverListado" value="Volver al listado" style="width:130px"/>
<? }?>
<input type="submit" name="Submit" value="Enviar" style="width:130px"/>
</form>
</center>
</body>
<?
echo "<script>";
if($transporte=='No'){ 
echo "mostrarDiv('traslado');";
}
if($transporte2=='No'){ 
echo "mostrarDiv('traslado2');";
}
if($compa=='Si'){ 
echo "mostrarDiv('compaDiv');";
}
echo "ContarPalabras('cvAbreviado', '1');";
echo "ContarPalabras('curriculum', '1');";
/*for($i=1; $i<=$var; $i++){
	echo "ContarPalabras('Descripcion', '".$i."');";
}*/
if ($idioma == "Ingles"){
echo "todoIngles();";
} 
if ($idioma == "Espanol"){
echo "todoEspanol();";
} 


echo "</script>";
?>
<script type="text/javascript">
Calendar.setup({
inputField : "campo_fecha", // id del campo de texto
ifFormat : "%Y-%m-%d", // formato de la fecha que se escriba en el campo de texto
button : "lanzador" // el id del botón que lanzará el calendario
});
Calendar.setup({
inputField : "campo_fecha2", // id del campo de texto
ifFormat : "%Y-%m-%d", // formato de la fecha que se escriba en el campo de texto
button : "lanzador2" // el id del botón que lanzará el calendario
});
</script>
</html>