<?
include('inc/sesion.inc.php');
include('conexion.php');

?>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link href="estilos.css" rel="stylesheet" type="text/css">
<script src="js/busquedaAvanzada.js" type="text/javascript" language="javascript"></script>
<script src="js/menuEdicion.js" type="text/javascript" language="javascript"></script>
<script src="js/en_calidades.js" type="text/javascript" language="javascript"></script>
<script src="js/ajax.js" type="text/javascript" language="javascript"></script>
<?
require("clases/arraysCasillero.php");
$cargarArray = new casillero();
$cargarArray->tipoDeActividades();
$cargarArray->enCalidades();
$cargarArray->paises();
$cargarArray->areas();
?>
<? include "inc/vinculos.inc.php";?>
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#F0E6F0">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php"; ?></td>
  </tr>
  <tr>
    <td valign="top">  <p align="center"><strong><font color="#666666" size="3" face="Trebuchet MS, Arial, Helvetica, sans-serif">Búsqueda Avanzada</font></strong></p>
	
	<form id="form1" name="form1" method="post" action="">
	<center>
     <div style="border:1px solid #999999; width:625px;">	 
	  <table width="625" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="FDF3EA" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:12px">
	    <tr>
          <td bgcolor="#ECF4F9"><strong>Palabra Clave: </strong></td>
	      <td colspan="3" bgcolor="#ECF4F9"><input type="text" name="txtPalabra" id="txtPalabra"  style="width:170px"/>
	        &nbsp;&nbsp;en &nbsp;
	        <label for="rbParticipantes" style="cursor:pointer">Participantes
	          <input type="radio" name="rbBuscarEn" id="rbParticipantes" value="" checked="checked"  />
	          </label>
	        &nbsp;&nbsp;
	        <label for="rbTitulos" style="cursor:pointer">T&iacute;tulos
	          <input type="radio" name="rbBuscarEn" id="rbTitulos" value=""  />
	          </label>
	        &nbsp;&nbsp;&nbsp;
	        <label for="chkAmbos" style="cursor:pointer">Ambos&nbsp;
	          <input type="checkbox" name="chkAmbos" id="chkAmbos" value="" onclick="BuscarEn()" checked="checked" />
	          </label></td>
	      </tr>
        <tr>
          <td width="108" valign="top" bgcolor="#ECF4F9"><strong>Rol / En calidad de:</strong></td>
          <td width="177" valign="top" bgcolor="#ECF4F9">
		  <select name="calidad_[]" size="5" multiple id="calidad_[]"  style="width:170px; font-size:10px" >
            </select></td>
          <td width="58" valign="top" bgcolor="#ECF4F9"><strong>Actividad</strong>:</td>
          <td width="254" valign="top" bgcolor="#ECF4F9"><select name="tipo_de_actividad_[]" size="5" multiple id="tipo_de_actividad_[]"  style="width:250px; font-size:10px" >
            </select></td>
        </tr>
        <tr>
          <td valign="top" bgcolor="#ECF4F9"><strong>Pa&iacute;s:</strong></td>
          <td valign="bottom" bgcolor="#ECF4F9"><select name="pais_[]" size="5" multiple id="pais_[]"  style="width:170px; font-size:10px" >
            </select></td>
          <td valign="top" bgcolor="#ECF4F9"><strong>&Aacute;rea:</strong></td>
          <td bgcolor="#ECF4F9"><select name="area_[]" size="5" multiple id="area_[]"  style="width:250px; font-size:10px" >
            </select></td>
        </tr>
        <tr>
          <td valign="bottom" bgcolor="#ECF4F9"><strong>Mostrar Resultado:</strong></td>
          <td colspan="2" valign="bottom" bgcolor="#ECF4F9"><label for="rbIndividual" style="cursor:pointer">Individual&nbsp;            
            <input type="radio" name="rbMostrar"  id="rbIndividual" value="Individual" />
            </label>
&nbsp;&nbsp;&nbsp;<label for="rbCompleto" style="cursor:pointer">Actividad Completa&nbsp;
<input type="radio" name="rbMostrar"  id="rbCompleto" value="Completa" checked="checked" />
</label></td>
          <td bgcolor="#ECF4F9"><div align="center">
            <input type="button" name="button" value="Buscar" style="width:125px" onclick="ValidarBusqueda(document.form1.txtPalabra.value,EnDondeBusco(), MostrarRes(), ACalidadesSel(), AActividadesSel(),APaisSel(), AAreasSel() )" />
            <input type="reset" name="Submit" value="Limpar criterios"  />
          </div></td>
        </tr>
      </table>	 
	  </div>
	  </center>
	 
	  <center>
	  <div id="DivResultadosMarcar" style="display:none; padding-top:10px">	
	    <div id="Acciones"  style="width:625; background-color:#FEEAD3; border:1px solid #999999; margin-bottom:10px; display:none1">
  <table width="625" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="623"><div align="center"><span>
        <input name="Submit4" type="button" class="botones" value="Preparar env&iacute;o masivo para las actividades seleccionadas" onclick="envioCasillerosFiltrados()" style="width:400px; background-color:#99CCCC" />
      </span></div></td>
      </tr>
  </table>
</div>   
	    <div id="DivResultadoBA" style="width:625px; background-color:#F1F1F2; border:1px solid #999999; text-align:left" >&nbsp;</div>
		
	  <div  style="width:625px; background-color:#FEEAD3; border:1px solid #999999; margin-top:10px;display:none1">
  <table width="625" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="623"><div align="center"><span>
        <input name="Submit4" type="button" class="botones" value="Preparar env&iacute;o masivo para las actividades seleccionadas" onclick="envioCasillerosFiltrados()" style="width:400px; background-color:#99CCCC" />
      </span></div></td>
      </tr>
  </table>
</div>
		</div>
	  </center>
	  </form></td>
  </tr>
</table>


<script>
CargarCalidades();
CargarTiposActividades();
CargarPaises();
CargarAreas();
BuscarEn();
</script>