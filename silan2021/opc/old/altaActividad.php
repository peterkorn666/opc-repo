<?
include "inc/sesion.inc.php";
include('conexion.php');
?>

<link href="estilos.css" rel="stylesheet" type="text/css">

<script src="js/tipo_de_actividad.js"></script>
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<? if ($_GET["sola"]!=1){?>
<? include "inc/vinculos.inc.php";?>
<table width="770" align="center" cellpadding="2" cellspacing="5" bgcolor="#CCCCCC">
  <tr>
    <td valign="top" bgcolor="#666666"><? include "menu.php";?></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F0E6F0" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:16px"><div align="center"><br>
        <strong>Alta </strong></font><br>
        Tipo de actividad<br>
        <br>

  <table width="100%" border="0" cellpadding="0" cellspacing="2">
    <tr valign="top">
      <td width="50%" height="10" rowspan="2" valign="top" bordercolor="#000000" >
	 <? }?>
	<form name="form1" method="post" action="altaActividadEnviar.php"><table width="100%" height="100%" style=" border:1px; border-style:solid; border-color:#333; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:11px" cellpadding="4" cellspacing="0" bgcolor="#ECF4F9" >
        <tr valign="top">
          <td height="10"  class="crono_trab" >Antes de agregar una actividad compruebe que no exista en la lista </td>
        </tr>
        <tr valign="top">
          <td height="10" ><input name="actividad_" type="text" id="actividad_" size="55" style=" width:370;" ></td>
        </tr>
        <tr valign="top">
          <td height="10"  class="crono_trab">Ahora agregue la traducci&oacute;n a ingl&eacute;s de la misma </td>
        </tr>
         <tr valign="top">
          <td height="10" ><input name="actividad_ing" type="text" id="actividad_ing" size="55" style=" width:370;" ></td>
        </tr>
        <tr valign="top">
          <td height="10" align="center" >
		    <div align="center">
		      <?
		include "color/controles_color.php"
		?>
		          </div></td>
        </tr>
        <tr valign="top">
          <td><div align="right"><font size="2">
              <input name="Submit" type="button"  onClick="Validar()" value="Agregar actividad" style="width:150px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:13px">
          </font></div></td>
        </tr>
      </table>   
	  
	   <input name="sola" type="hidden" value="<?=$_GET["sola"]?>">
	</form>  
	        <? if ($_GET["sola"]!=1){?> 
        </td>
      <td width="50%">
          <table width="100%" height="auto" style="border:1px; border-style:solid; border-color:#333; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:13px" cellpadding="4" cellspacing="0" bgcolor="#FEFFEA" >
              <tr>
                <td valign="top"><strong>Tipos de actividad Existentes:</strong><br>
        <table width="100%" cellpadding="3" cellspacing="1" bgcolor="#333333" style=" font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:11px">
                <?
            $sql = "SELECT * FROM tipo_de_actividad ORDER by Tipo_de_actividad ASC";
            $rs = mysql_query($sql,$con);
            while ($row = mysql_fetch_array($rs)){
            /*LLENO ARRAY PARA VER QUE NO EXISTA*/
            echo "<script>arrayActividadNuevo.push('" . $row["Tipo_de_actividad"] ."')</script>\n ";
            ?>
           <tr>
            <td width="17" align="center" bgcolor="#FFFFFF"><? echo  "<a href='modificarActividad.php?id=" . $row["ID_Tipo_de_actividad"]  . "'><img src='img/modificar.png' border='0' alt='Modificar esta actividad'></a>";?></td>
            <td width="17" align="center" bgcolor="#FFFFFF"><? echo  "<a href='javascript:eliminar(" .  $row["ID_Tipo_de_actividad"] . ")'><img src='img/eliminar.png' border='0'  alt='Eliminar esta actividad'></a> ";
            
                 if(substr($row["Color_de_actividad"],0,1)=="#"){ 	
                    $Color_de_actividad = "background-color:" . $row["Color_de_actividad"] . "; ";				
                 }else{	  	
                    $Color_de_actividad = "background-image:url(img/patrones/" . $row["Color_de_actividad"] . ");";
                 }
            ?></td>
            
            
                          <td width="6" <? if($row["Color_de_actividad"]!=""){echo "bordercolor='#000000'";}?> style="<?=$Color_de_actividad?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="287" bgcolor="#FFFFFF"><? echo $row["Tipo_de_actividad"] ." / ". $row["Tipo_de_actividad_ing"];?></td>
            </tr>
              <?
            }
              ?>
              </table></td>
              </tr>
          </table>
      </td>
    </tr>
  </table>
<br>
    </div></td>
  </tr>
</table>
<? }?>
<script>form1.actividad_.focus();</script>