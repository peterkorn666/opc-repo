<form name="form1" method="post" action="">
  <table width="300" border="00" cellpadding="5" cellspacing="0" bgcolor="#CCCCCC">
    <tr bgcolor="#FFFFFF">
      <td width="64" bgcolor="#CCCCCC"><font size="2">Profesi&oacute;n:</font></td>
      <td width="345" bgcolor="#CCCCCC"><font size="2">
        <script>llenarArrayProfesiones('<?=$row["Profesion"]?>')</script>
        <script>llenarProfesiones();</script>
        <input name="nombre_2" type="text" id="nombre_2" style="width:170px">
      </font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td width="64" bgcolor="#CCCCCC"><font size="2">Nombre:</font></td>
      <td bgcolor="#CCCCCC">&nbsp;</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td width="64" bgcolor="#CCCCCC"><font size="2">Apellidos:</font></td>
      <td bgcolor="#CCCCCC">&nbsp;</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td width="64" bgcolor="#CCCCCC"><font size="2">Cargo:</font></td>
      <td bgcolor="#CCCCCC"><font size="2">
        <input name="apellidos_" type="text" id="apellidos_" style="width:170px">
      </font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td width="64" bgcolor="#CCCCCC"><font size="2">Instituci&oacute;n:</font></td>
      <td bgcolor="#CCCCCC"><font size="2">
        <input name="apellidos_2" type="text" id="apellidos_2" style="width:170px">
      </font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td bgcolor="#CCCCCC"><font size="2">Pa&iacute;s:</font></td>
      <td bgcolor="#CCCCCC"><font size="2">
        <input name="apellidos_3" type="text" id="apellidos_3" style="width:170px">
      </font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td bgcolor="#CCCCCC"><font size="2">E-mail:</font></td>
      <td bgcolor="#CCCCCC"><font size="2">
        <input name="mail" type="text" id="mail" style="width:170px">
      </font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td bgcolor="#CCCCCC">&nbsp;</td>
      <td bgcolor="#CCCCCC">        <input type="submit" name="Submit" value="Aceptar">
      <input type="submit" name="Submit2" value="Cancelar"></td>
    </tr>
  </table>

</form>
