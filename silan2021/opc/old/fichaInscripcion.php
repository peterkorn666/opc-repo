<?
include('inc/sesion.inc.php');
include "conexion.php";
require "clases/inscripciones.php";
$inscripcion = new inscripciones;
?>

<link href="estilos.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
.borddeAbajo {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #77969F;
}
.Estilo1 {font-family: Arial, Helvetica, sans-serif}
-->
</style>
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CCCCCC">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php"; ?></td>
  </tr>
  <tr>
    <td valign="top"><div align="center">
      <form name="form1" method="post" action="bandejaEntradaInscripciones.php">
        <div align="left">
          <input name="Submit" type="submit" class="botones" value="&lt; Volver a la bandeja de entrada">
          </div>
      <strong><font color="#666666" size="3" face="Arial, Helvetica, sans-serif">Inscripciones congreso</font></strong><strong><font size="4">
          <?
		 

	  	 $lista = $inscripcion->leeoInscripto($_GET["id"]);
		 while ($row = mysql_fetch_object($lista)){
		 ?>
          
          </font>
            </strong>        </form>
      </div>
      <table width="399" border="0" align="center" cellpadding="0" cellspacing="0" class="textos">
	 <tr>
      <td height="30" valign="middle" class="textos"><div align="center"><strong><font size="4"><? echo $row->tituloAcademico . " "  . $row->nombre . " " .  $row->apellido; ?></font></strong><br>
      </div></td>
    </tr>
    <tr>
      <td height="30" valign="bottom" class="textos"><font color="#666666"><strong>ID de inscripci&oacute;n:
            <?=$row->identificador?>
      </strong></font></td>
    </tr>
    <tr>
      <td height="30" valign="middle" class="textos"><strong><font color="#006600">Datos Personales </font></strong></td>
    </tr>
    <tr>
      <td valign="top"><table width="100%" border="0" align="center" cellpadding="4" cellspacing="0" class="textos">
        <tr>
          <td width="147" valign="top" bgcolor="#F4F4F4" class="textos"><strong>Titulo Acad&eacute;mico:</strong></td>
          <td width="236" valign="top" bgcolor="#F4F4F4" class="textos">            <?=$row->tituloAcademico?>          </td>
        </tr>
      <? /*  <tr bgcolor="#EBEBEB">
          <td valign="top" class="textos"><strong>Especialidad:</strong></td>
          <td valign="top" class="textos">            <?=$row->especialidad?>          </td>
        </tr> */ ?>
        <tr bgcolor="#F4F4F4" id="tdNombre" >
          <td valign="top" class="textos"><strong>Nombre:</strong></td>
          <td valign="top" class="textos">            <?=$row->nombre?>          </td>
        </tr>
        <tr bgcolor="#EBEBEB" id="tdApellido">
          <td valign="top" class="textos"><strong>Apellido:</strong></td>
          <td valign="top" class="textos">            <?=$row->apellido?>          </td>
        </tr>
        <tr bgcolor="#F4F4F4">
          <td valign="top" class="textos"><strong>Organizaci&oacute;n o Instituci&oacute;n:</strong></td>
          <td valign="top" class="textos">            <?=$row->institucion?>          </td>
        </tr>
        <tr bgcolor="#EBEBEB" id="tdDireccion">
          <td valign="top" class="textos"><strong>Direcci&oacute;n:</strong></td>
          <td valign="top" class="textos">            <?=$row->direccion?>          </td>
        </tr>
        <tr bgcolor="#F4F4F4" id="tdCiudad">
          <td valign="top" class="textos"><strong>Ciudad:</strong></td>
          <td valign="top" class="textos">            <?=$row->ciudad?>          </td>
        </tr>
        <tr bgcolor="#EBEBEB">
          <td valign="top" class="textos"><strong>Estado : </strong></td>
          <td valign="top" class="textos">            <?=$row->estado?>          </td>
        </tr>
        <tr bgcolor="#F4F4F4">
          <td valign="top" class="textos"><strong>C&oacute;digo Postal:</strong></td>
          <td valign="top" class="textos">            <?=$row->codigoPostal?>          </td>
        </tr>
        <tr bgcolor="#EBEBEB" id="tdPais">
          <td valign="top" class="textos"><strong>Pa&iacute;s:</strong></td>
          <td valign="top" class="textos">            <?=$row->pais?>          </td>
        </tr>
        <tr bgcolor="#F4F4F4">
          <td valign="top" class="textos"><strong>Tel&eacute;fono:</strong></td>
          <td valign="top" class="textos">            <?=$row->telefono?>          </td>
        </tr>
        <tr bgcolor="#EBEBEB" id="tdMail">
          <td valign="top" class="textos"><strong>E-mail.</strong></td>
          <td valign="top" class="textos">            <?=$row->mail?>          </td>
        </tr>
        <tr bgcolor="#F4F4F4">
          <td valign="top" class="textos"><strong>Fax:</strong></td>
          <td valign="top" class="textos">            <?=$row->fax?>          </td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="40" valign="middle"><font color="#006600"><strong>            Tipo y costo de inscripci&oacute;n</strong></font></td>
    </tr>
    <tr>
      <td valign="top"><table width="399" border="0" align="center" cellpadding="0" cellspacing="0" class="texto">
        <tr>
          <td colspan="2" valign="top" bgcolor="#F8EDE9"><div id="divCompa0">
            <table width="100%" border="0" cellpadding="4" cellspacing="0" class="textos">
              <tr id="trCompa0">
                <td colspan="4" bgcolor="#F0D9D0"><strong>Acompa&ntilde;antes:
                    <?=$row->nombreCompa1?>
                </strong></td>
              </tr>
             <?
			if($row->cantidadCompas>0){
			?>
	
              <tr id="trCompa0">
                <td width="12%">Nombre:</td>
                <td width="37%">                  <?=$row->nombreCompa0?>                </td>
                <td width="13%">Apellido:</td>
                <td width="38%">                  <?=$row->apellidoCompa0?>                </td>
              </tr>


		<?
		if($row->cantidadCompas>1){
		?>
		
              <tr id="trCompa0">
                <td>Nombre:</td>
                <td>                  <?=$row->nombreCompa1?>                </td>
                <td>Apellido:</td>
                <td>                  <?=$row->apellidoCompa1?>                </td>
              </tr>
         <?
		}
	}
	?>
            </table>
          </div>
                <div id="divCompa1"></div></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td valign="top"><br /></td>
    </tr>

    <tr>
      <td height="30" valign="middle" bgcolor="#B9D0E3" class="textos"><strong> Tipo y per&iacute;odo de inscripci&oacute;n</strong>:
          <?=$row->tipoInscripcion?> USD      </td>
    </tr>
    <?
	if($row->cantidadCompas>0){

		if($row->cantidadCompas>1){
			$s = "s";
		}else{
			$s = "";
		}
	?>
    <tr>
      <td height="30" valign="middle" bgcolor="#F8EDE9" class="textos"><strong>Per&iacute;odo de inscripci&oacute;n de acompa&ntilde;ante<?=$s?>
     </strong>:
        <?=$row->tipoInscripcionCompas?>      </td>
      tipoInscripcion    </tr>
    <?
	}
	?>
    <tr>
      <td valign="top" class="textos"><div align="right"><br />
              <strong><font color="#FF0000">Valor total deesta inscripci&oacute;n:
                U$S
              <?=$row->valorTotal?>
              </font></strong></div></td>
    </tr>
    <tr>
      <td valign="top"><br /></td>
    </tr>
    <tr>
      <td height="20" valign="top" class="textos"><p><font color="#006600"><strong>Forma de 
        pago</strong></font></p></td>
    </tr>
    <tr>
      <td valign="top" class="textos"><table width="100%" border="0" cellpadding="4" cellspacing="0" bordercolor="#000000" class="Estilo1">
            <tr>
              <td bordercolor="#F4F4F4" bgcolor="#FFFF00" class="textos"><font color="#990000"><strong>
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$row->formaPago?>
              </strong></font></td>
            </tr>
          </table>        </td>
    </tr>
 
    <tr>
      <td valign="top">
	  <? if ($row->comentarios){ ?><table width="100%" border="0" cellpadding="4" cellspacing="0" class="texto">
        <tr>
          <td width="8%" bgcolor="#FFFFCC" class="textos"><br /></td>
          <td width="92%" bgcolor="#FFFFCC" class="textos"><?=str_replace(chr(13),"<br>",$row->comentarios)?></td>
        </tr>
      </table>
	  <? } ?>
          <br /></td>
    </tr>
  </table>
	
	
	<?
	
	  }
	  ?>
	  
    </p></td>
  </tr>
</table>
<script>

function mOvr(cual){
	cual.bgColor= "#ffffff";
}
function mOut(cual,color){
	cual.bgColor= color;
}
function mClk(cual){
	document.location.href = "fichaInscripcion.php?id=" + cual;
	cual.bgColor= color;
}
</script>