<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache"); 
include "conexion.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link href="estilos.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="js/staff.js"></script>
<script language="javascript" type="text/javascript" src="js/drag.js"></script>
<title>&nbsp;</title>
</head>
<? 
	if($_POST[idPersona]!=""){
		$url="iframe.modificarPersonaStaff.php?id=".$_POST[idPersona];
	}else{
		$url="iframe.modificarPersonaStaff.php";		
	}
?>
<body>
<form name="form2" target="iframeForm" action="<?=$url;?>" method="post">
	  <center>
      <table cellpadding="5px" cellspacing="0px" class="texto" style="width:450px; border:2px; border-color:#000000; border-style:solid; background-color:#FFF" >
    	<tr >
	        <td width="24">
            	<img src="img/variasPersonas.png" width="24" height="24" />
            </td>
        	<td width="402" align="center" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif" ><strong>INGRESE LOS DATOS</strong> <input name="id_staff" type="hidden" id="id_staff" value="<?=$_POST["idStaff"]?>" >
            </td>
            <td width="24">
            	<img src="img/variasPersonas.png" width="24" height="24" />
            </td>
        </tr>
    </table>
    </center>
    <center>
    <table cellpadding="5px" cellspacing="0px" class="texto" style=" font-size:10px;width:450px; border:2px; border-color:#000000; border-style:solid; background-color:#FFF" >
   	  <tr>
        	<td width="152" align="right">
            	Nombre: 
            </td>
            <td width="274" >
            	<input name="nombre" type="text" id="nombre" size="30" value="<?=$_POST["nombre"]?>">
            </td>
        </tr>
        <tr>
        	<td width="152" align="right">
            	Apellido: 
            </td>
            <td width="274" >
            	<input name="apellido" type="text" id="apellido" size="30" value="<?=$_POST["apellido"]?>"/>
            </td>
        </tr>
        <tr>
        	<td width="152" align="right">
            	Telefono: 
            </td>
            <td width="274">
            	<input name="telefono" type="text" id="telefono" size="30" value="<?=$_POST["telefono"]?>"/>
            </td>
        </tr>
        <tr>
        	<td width="152" align="right">
            	Email: 
            </td>
            <td width="274">
            	<input name="email" type="text" id="email" size="30" value="<?=$_POST["email"]?>"/>
            </td>
        </tr>
        <tr>
        	<td width="152" align="right">
            	Pais: 
                <?
$paises = array("", "Abkhazia","Afghanistan","Akrotiri and Dhekelia","Aland","Albania","American Samoa","Andorra","Angola","Anguilla","Antigua and Barbuda","Argentina","Armenia","Aruba","Ascension Island","Australia","Austria","Azerbaijan","Bahamas, The","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia and Herzegovina","Botswana","Brazil","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central African Republic","Chad","Chile","China, People's Republic of","China, Republic of","Christmas Island","Cocos","Colombia","Comoros","Congo, Democratic Republic of","Congo, Republic of","Cook Islands","Costa Rica","Côte d'Ivoire","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","Gabon","Gambia, The","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea-Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Korea, Democratic People's Republic of","Korea, Republic of","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macao","Macedonia, Republic of","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mayotte","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Nagorno-Karabakh","Namibia","Nauru","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Niue","Norfolk Island","Northern Cyprus","Northern Mariana Islands","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Pitcairn Islands","Poland","Portugal","Pridnestrovie","Puerto Rico","Qatar","Romania","Russia","Rwanda","Saint Barthelemy","Saint Helena","Saint Kitts and Nevis","Saint Lucia","Saint Martin","Saint Pierre and Miquelon","Saint Vincent and the Grenadines","Samoa","San Marino","São Tomé and Príncipe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","Somaliland","South Africa","South Ossetia","Spain","Sri Lanka","Sudan","Suriname","Svalbard","Swaziland","Sweden","Switzerland","Syria","Tajikistan","Tanzania","Thailand","Timor-Leste","Togo","Tokelau","Tonga","Trinidad and Tobago","Tristan da Cunha","Tunisia","Turkey","Turkmenistan","Turks and Caicos Islands","Tuvalu","Uganda","Ukraine","United Arab Emirates","UK - United Kingdom","Uruguay", "USA - United States of America", "Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands, British","Virgin Islands, United States","Wallis and Futuna","Western Sahara","Yemen","Zambia","Zimbabwe"); 
?>
            </td>
            <td width="274">
            	
                
              <select name="pais" style="width:75%;"  >
              
				<?
                foreach ($paises as $i){                
					if($_POST["pais"] == $i){
						$sel = "selected";
	                }else{
	    	            $sel = "";
            	    }            
                	
					echo  "<option value='$i' $sel>$i</option>";
                }
                ?>
                </select>
            </td>
        </tr>
                <tr>
        	<td width="152" align="right">
            	Cargo: 
            </td>
            <td width="274">
            	<input name="cargo" type="text" id="cargo" size="30" value="<?=$_POST["cargo"]?>"/>
            </td>
        </tr>
    </table>
     </center>    
   	 <center>
     <table cellpadding="5px" cellspacing="0px" class="texto" style="width:450px; border:2px; border-color:#000000; border-style:solid; background-color:#FFF" >
    	<tr >
        	<td align="center" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif" >
                <input name="guardar" type="submit" class="botones"  value="Guardar"/> 
                &nbsp;&nbsp;
                <input name="cancelar" type="button" class="botones" onclick="javascript:ocultarDiv('divEdicion')" value="Cerrar" />
            </td>
        </tr>
    </table>
    </center>
</form>
<? 
	echo "<script>document.form2.nombre.value='';
	document.form2.apellido.value='';
	document.form2.telefono.value='';
	document.form2.email.value='';
	document.form2.pais.value='';
	document.form2.cargo.value='';</script>\n";	
?>
</body>
</html>