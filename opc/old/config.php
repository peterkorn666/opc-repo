<?
include('inc/sesion.inc.php');
include('conexion.php');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Configuración del sistema</title>
<style type="text/css">
<!--
.Estilo4 {text-decoration: none; font-style: normal; font-weight: bold;}
-->
</style>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#CCCCCC">

  <div align="center">
   <b><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">Configuraci&oacute;n del sisitema </font></b><font color="#FFFFFF"><br>
   </font></div>
  <br>
  <?  include("adminUsuarios.php"); ?>
  <form name="form1" method="post" action="configEnviar.php" style="display:inline;">
 
    <table width="100%"  border="1" cellpadding="2" cellspacing="0" bordercolor="#000000" bgcolor="#FFFFFF">
      <tr>
        <td bordercolor="#000000" bgcolor="#CCCCCC"><table width="100%"  border="0" cellspacing="2" cellpadding="4">
            <tr>
              <td width="43%" valign="middle" bgcolor="#EEF0F3"><font color="#333333" size="2" face="Arial, Helvetica, sans-serif"><strong>Nombre del Congreso:</strong></font></td>
              <td width="65%" valign="middle" bgcolor="#FFFFCC"><label>
                     <?
					$sqlNC = "SELECT nombre_congreso, mail_contacto FROM config;";
					$rsNC = mysql_query($sqlNC, $con);
					while ($rowNC = mysql_fetch_array($rsNC)){
					$nombre_congreso = $rowNC["nombre_congreso"];
					$mail_contacto = $rowNC["mail_contacto"];					
					}?>
				<input name="nombre_congreso" type="text" value="<?=$nombre_congreso;?>" size="25">
              </label></td>
            </tr>
            <tr>
              <td width="43%" valign="middle" bgcolor="#EEF0F3"><font color="#333333" size="2" face="Arial, Helvetica, sans-serif"><strong>Mail remitente:</strong></font></td>
              <td valign="middle" bgcolor="#FFFFCC"><input name="mail_contacto" type="text" value="<?=$mail_contacto;?>" size="25"></td>
            </tr>


        </table></td>
      </tr>
    </table>
  
    <table width="100%"  border="1" cellpadding="2" cellspacing="0" bordercolor="#000000" bgcolor="#FFFFFF">
      <tr>
        <td bordercolor="#000000" bgcolor="#CCCCCC"><table width="100%"  border="0" cellspacing="2" cellpadding="4">
        
            <tr>
              <td valign="middle" bgcolor="#EEF0F3"> <font size="2" face="Arial, Helvetica, sans-serif">
                <?     
			$sql = "SELECT ordenTL FROM config limit 1;";
			$rs = mysql_query($sql, $con);
			while ($row = mysql_fetch_array($rs)){
				if($row["ordenTL"]==0){
					$sel0 = "checked";
					$sel1 = "";
				}else{
					$sel0 = "";
					$sel1 = "checked";
				}
			}
		?>
                <input name="ordenTL_" type="radio" value="0"  <?=$sel0?>>
              Ordenar los trabajos libres por su codigo</font></td>
            </tr>
            <tr>
              <td valign="middle" bgcolor="#EEF0F3"><font size="2" face="Arial, Helvetica, sans-serif">
                <input name="ordenTL_" type="radio" value="1" <?=$sel1?>>
              Ordenar los trabajos libres por su propio horario de inicio <em><font size="1">(deben tener todos los trabajos horarios de lo contrario se ubicaran primeros lo que no posean horario)</font></em></font></td>
            </tr>
        </table></td>
      </tr>
    </table>
    <table width="100%"  border="1" cellpadding="2" cellspacing="0" bordercolor="#000000" bgcolor="#FFFFFF">
  
 <tr>
      <td bordercolor="#000000" bgcolor="#CCCCCC"><table width="100%"  border="0" cellspacing="2" cellpadding="4">
        <tr>
          <td colspan="2" valign="middle"><font color="#333333" size="2" face="Arial, Helvetica, sans-serif"><strong>Permisos para el p&uacute;blico (no administradores)</strong></font></td>
          </tr>
        <tr>
          <td width="148" valign="middle" bgcolor="#EEF0F3"><div align="center"> <font size="2" face="Arial, Helvetica, sans-serif">
            <?     
			$sql = "SELECT VerCurriculums FROM config;";
			$rs = mysql_query($sql, $con);
			while ($row = mysql_fetch_array($rs)){
				if($row["VerCurriculums"]==1){
					$verCurriculums = "checked";
				}else{
					$verCurriculums = "";
				}
			}
		?>	 
            <input name="verCurriculums" type="checkbox" id="verCurriculums" value="1" <?=$verCurriculums?> >
            </font></div></td>
                <td width="826" bgcolor="#FFFFCC"><font size="2" face="Arial, Helvetica, sans-serif"><a href="altaRecuadro.php" class="Estilo4"> &nbsp;</a>Permitir descargar los curriculum de los participantes</font></td>
          </tr>
        <tr>
          <td valign="middle" bgcolor="#EEF0F3"><div align="center"> <font size="2" face="Arial, Helvetica, sans-serif">
            <?     
			$sql = "SELECT VerTL FROM config;";
			$rs = mysql_query($sql, $con);
			while ($row = mysql_fetch_array($rs)){
				if($row["VerTL"]==1){
					$verlt = "checked";
				}else{
					$verlt = "";
				}
			}
		?>
            <input name="verTL" type="checkbox" id="verTL" value="1" <?=$verlt?>>
            </font></div></td>
                <td bgcolor="#FFFFCC"><font size="2" face="Arial, Helvetica, sans-serif"><a href="altaRecuadro.php" class="Estilo4"> &nbsp;</a>Permitir descargar los trabajos libres </font></td>
          </tr>
        <tr>
          <td height="26" valign="middle" bgcolor="#EEF0F3"><div align="center"> <font size="2" face="Arial, Helvetica, sans-serif">
            <?     
			$sql = "SELECT VerMails FROM config;";
			$rs = mysql_query($sql, $con);
			while ($row = mysql_fetch_array($rs)){
				if($row["VerMails"]==1){
					$verMails = "checked";
				}else{
					$verMails = "";
				}
			}
		?>
            <input name="verMails" type="checkbox" id="verMails" value="1" <?=$verMails?>>
            </font></div></td>
                <td bgcolor="#FFFFCC"><font size="2" face="Arial, Helvetica, sans-serif"><a href="altaRecuadro.php" class="Estilo4"> &nbsp;</a>Permitir Ver los mail de los participantes</font></td>
          </tr>
      </table></td></tr>
  </table>
  <table width="100%" height="100"  border="1" cellpadding="2" cellspacing="0" bordercolor="#000000" bgcolor="#CCCCCC">
    <tr>
      <td bordercolor="#000000"><table width="100%"  border="0" cellspacing="2" cellpadding="4">
          <tr>
            <td valign="middle" nowrap><div align="left"><font color="#333333" size="2" face="Arial, Helvetica, sans-serif"><strong>Visualizaciones</strong></font></div></td>
          </tr>
          <tr>
            <td valign="middle" nowrap bgcolor="#FFFFCC"><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">Alto de carga horaria para el cronograma</font><font size="2" face="Arial, Helvetica, sans-serif"><a href="altaRecuadro.php" class="Estilo4">&nbsp;</a>
                      <?     
$sqla = "SELECT AltoDeCrono FROM config;";
$rsa = mysql_query($sqla, $con);
while ($rowa = mysql_fetch_array($rsa)){
	$alto_po_carga_horaria = $rowa["AltoDeCrono"];
	$alto_po_carga_horaria_Imp = $rowa["AltoDeCronoImp"];
}
		?>
                      <input name="altoCrono" type="text" id="altoCrono" value="<?=$alto_po_carga_horaria?>" size="1">
                      <font size="1"> px.</font> </font></div></td>
          </tr>
          <tr>
            <td valign="middle" bgcolor="#FFFFCC"><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">Alto de carga horaria para la impresi&oacute;n del cronograma<a href="altaRecuadro.php" class="Estilo4">&nbsp;</a>
                      <?     
$sqla = "SELECT AltoDeCrono, AltoDeCronoImp FROM config;";
$rsa = mysql_query($sqla, $con);
while ($rowa = mysql_fetch_array($rsa)){
	$alto_po_carga_horaria = $rowa["AltoDeCrono"];
	$alto_po_carga_horaria_Imp =  $rowa["AltoDeCronoImp"];
}
		?>
                      <input name="altoCronoImp" type="text" id="altoCronoImp" value="<?=$alto_po_carga_horaria_Imp?>" size="1">
                      <font size="1">px.</font><br>
                      <font color="#666666">(Recomendado 21px) </font><br>
            </font></div></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <br>
  <div align="center">
    <input name="Submit" type="submit" class="botones" style="width:100%" value="  Guardar  ">
  </div>
</form>
</body>
</html>
