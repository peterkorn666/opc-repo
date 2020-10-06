<?
include('inc/sesion.inc.php');
include('conexion.php');
?>
<link href="estilos.css" rel="stylesheet" type="text/css">

<script src="js/recuadros.js"></script>
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "inc/vinculos.inc.php";?>
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CCCCCC">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php";?></td>
  </tr>
  <tr>
    <td valign="top"><div align="center"><font color="#666666" size="3"><strong><br>
      Crear recuadro </strong></font><br>
        <form name="form1" method="post" action="altaRecuadroEnviar.php">
          <table width="100%" height="100" border="1" cellpadding="5" cellspacing="2" bordercolor="#CCCCCC">
            <tr valign="top">
              <td width="52%" rowspan="2" bordercolor="#000000" bgcolor="#000000"><table width="380" border="0" cellpadding="5" cellspacing="0">
                  <tr valign="top" bordercolor="#FFFFFF">
                    <td bgcolor="#CCCCCC"><font size="2" class="crono_trab">Antes de agregar un recuadro compruebe que no exista en la lista </font></td>
                  </tr>
                  <tr valign="top" bordercolor="#FFFFFF">
                    <td bgcolor="#CCCCCC"><font color="#333333" size="2">D&iacute;a:</font><font size="2">
<select name="dia_" id="dia_">
                      <?
$sql = "SELECT * FROM dias ORDER by Dia_orden ASC";
$rs = mysql_query($sql,$con);

while ($row = mysql_fetch_array($rs)){

?>
                      <option value="<? echo $row["Dia_orden"]; ?>"><? echo $row["Dia"]; ?></option>
                      <?
}
?>
                    </select>
                    </font><font size="2">&nbsp;
                    </font></td>
                  </tr>
                  <tr>
                    <td bgcolor="#CCCCCC"><font size="2"><font color="#333333">Sala:</font>
                          <select name="sala_" id="sala_">
                            <?
$sql = "SELECT * FROM salas ORDER by Sala_orden ASC";
$rs = mysql_query($sql,$con);

while ($row = mysql_fetch_array($rs)){
?>
                            <option value="<? echo $row["Sala_orden"]; ?>"><? echo $row["Sala"]; ?></option>
                            <?
}
?>
                          </select>
                    </font></td>
                  </tr>
                  <tr>
                    <td bgcolor="#CCCCCC"><table width="100%"  border="0" cellspacing="2" cellpadding="0">
                        <tr>
                          <td><font color="#333333" size="2">Este recuadro se expandira</font>
                              <?
$sql = "SELECT * FROM salas ORDER by Sala_orden ASC";
$rs = mysql_query($sql,$con);
$exp = 0;
while ($row = mysql_fetch_array($rs)){
$exp = $exp + 1;

if($exp==1){
	$selectExp="checked";
}else{
	$selectExp="";
}
?>
                              <font color="#990000" style=" font-size:10; ">
                              <?=$exp?>
                              </font>
                              <input name="seExpandira" type="radio" value="<?=$exp?>"  <? echo $selectExp;?>  onClick="activarSeLlamara(<?=$exp?>)">
&nbsp;&nbsp;
          <?
}
?>
          <font color="#333333" size="2">Sala/s </font></td>
                        </tr>
                        <tr>
                        </tr>
                      </table>
                  </tr>
                  <tr valign="top" bordercolor="#FFFFFF">
                    <td bgcolor="#CCCCCC"><font size="2"><font color="#333333">Hora inicio:</font>
                        <select name="hora_inicio_" id="hora_inicio_">
                          <?
$sql = "SELECT * FROM horas ORDER by Hora ASC";
$rs = mysql_query($sql,$con);

while ($row = mysql_fetch_array($rs)){
?>
                          <option value="<? echo $row["Hora"]; ?>"><? echo $row["Hora"]; ?></option>
                          <?
}
?>
                        </select>
&nbsp;<font color="#333333">Hora fin:</font>
<select name="hora_fin_" id="hora_fin_">
  <?
$sql = "SELECT * FROM horas ORDER by Hora ASC";
$rs = mysql_query($sql,$con);

while ($row = mysql_fetch_array($rs)){
?>
  <option value="<? echo $row["Hora"]; ?>"><? echo $row["Hora"]; ?></option>
  <?
}
?>
</select>
<input name="tipo_de_actividad_" type="hidden" id="tipo_de_actividad_" value="Recuadro">
</font></td>
                  </tr>
                  <tr valign="top" bordercolor="#FFFFFF">
                    <td bgcolor="#CCCCCC"><div align="right"><font size="2">
                        <input name="Submit" type="submit" class="botones" value="Agregar recuadro">
                    </font></div></td>
                  </tr>
              </table></td>
              <td width="48%" height="10" bordercolor="#999999" bgcolor="#666666"><font color="#FFFFFF" size="2"><strong>Recuadros Existentes:</strong></font></td>
            </tr>
            <tr valign="top">
              <td width="48%" height="100%" bordercolor="#999999" bgcolor="#FFFFCC"><font size="2">
                <?
	$sql = "SELECT * FROM recuadros  ORDER by Dia_orden, Sala_orden, Hora_inicio ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
		
		$sql2 = "SELECT * FROM dias WHERE Dia_orden=" . $row["Dia_orden"] .";";
		$rs2 = mysql_query($sql2,$con);
		while ($row2 = mysql_fetch_array($rs2)){
			$diaNombre = $row2["Dia"];
		}
		$sql3 = "SELECT * FROM salas WHERE Sala_orden=" . $row["Sala_orden"] .";";
		$rs3 = mysql_query($sql3,$con);
		while ($row3 = mysql_fetch_array($rs3)){
			$salaNombre = $row3["Sala"];
		}
		echo  "<a href='javascript:eliminar(" .  $row["ID"] . ")'><img src='img/eliminar.png' border='0'  alt='Eliminar este Recuadro'></a> ";
		echo $diaNombre  . " en " . $salaNombre . " de " . $row["Hora_inicio"] . " a " . $row["Hora_fin"] . "<br>";
	}
	  ?>
              </font></td>
            </tr>
          </table>
        </form>
        <table width="80%"  border="0" cellspacing="3" cellpadding="3">
          <tr>
            <td width="21%"><img src="img/recuadrosCrono.png" width="150" height="172"></td>
            <td width="79%"><div align="center"><font size="2">Los recuadros son solo elementos visuales que ayudan a comprender el grupo de varios casilleros </font></div></td>
          </tr>
        </table>
        </div></td>
  </tr>
</table>
