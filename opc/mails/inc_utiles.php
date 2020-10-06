<?php

function cargarCategorias($nombreCampo, $seleccionado,$defaultValue="",$defaultOption="",$atributos="") {
  global $conexion;
  $sql= "SELECT DISTINCT familias.Id, familias.Familia" . ID . " AS Familia, familias.IdPadre, padres.Familia" . ID . " AS Padre";
  $sql.= " FROM familias LEFT JOIN familias AS padres ON familias.IdPadre=padres.Id";
  $sql.= " WHERE familias.IdPadre<>0";
  $sql.= " ORDER BY padres.Orden,familias.Orden";
  $resultado= "<select name=\"$nombreCampo\" $atributos OnChange='JavaScript:if (this.value>0) location.href=\"familia.php?Id=\" + this.value;if (this.value<0) location.href=\"categoria.php?Id=\" + (-this.value);'>";
  if (is_array($defaultValue) && is_array($defaultOption)) {
    for ($i=0;$i<count($defaultValue);$i++) {
      if ($defaultValue[$i] . $defaultOption[$i] !="") {
        $resultado.= "<OPTION value=" . $defaultValue[$i];
        if ($defaultValue[$i]==$seleccionado)
          $resultado.= " SELECTED ";
        $resultado.= ">" . $defaultOption[$i] . "</OPTION>";
      }
    }
  }
  else {
    if ($defaultValue . $defaultOption !="") {
      $resultado.= "<OPTION value=" . $defaultValue;
      if ($defaultValue==$seleccionado)
        $resultado.= " SELECTED ";
      $resultado.= ">" . $defaultOption . "</OPTION>";
    }
  }

  $rs = mysqli_query($conexion,$sql);
  $idPadre=-1;
  while ($rowRs = mysqli_fetch_array($rs)){
         if ($rowRs[2]!=$idPadre) {
              $idPadre=$rowRs[2];
              $resultado.= "<OPTION value=-$idPadre";
              if ($idPadre==$seleccionado)
                 $resultado.= " SELECTED ";
              $resultado.= ">" .  strtr(strtoupper($rowRs[3]),"·ÈÌÛ˙¸Ò","¡…Õ”⁄‹—") . "</OPTION>" ;
         }
         $resultado.= "<OPTION value=" . $rowRs[0];
         if ($rowRs[0]==$seleccionado)
                 $resultado.= " SELECTED ";
         $resultado.= ">- " . $rowRs[1] . "</OPTION>";
  }
  //Cierra el recordset
  mysqli_free_result($rs);
  $resultado.= "</select>";
  return $resultado;



}


// carga en una lista desplegable los registros resultantes de la consulta sql
// (primer campo value, segundo campo texto desplegado)
// dejando seleccionado al elemento con valor igual al segundo parametro
function cargarListBox($sql,$seleccionado, $conexion) {
        //Hace la consulta para cargar los registros
        $rs = mysqli_query($conexion,$sql);
        $resultado="";
        while ($rowRs = mysqli_fetch_array($rs)){
                $resultado.= "<OPTION value=" . $rowRs[0];
                if ($rowRs[0]==$seleccionado)
                        $resultado.= " SELECTED ";
                $resultado.= ">" . $rowRs[1] . "</OPTION>";
        }
        //Cierra el recordset
        mysqli_free_result($rs);
        return $resultado;
}

function campoSelect($nombreCampo,$sql, $seleccionado,$defaultValue="",$defaultOption="",$atributos="") {
  $resultado= "<select name=\"$nombreCampo\" $atributos>";
  if (is_array($defaultValue) && is_array($defaultOption)) {
    for ($i=0;$i<count($defaultValue);$i++) {
      if ($defaultValue[$i] . $defaultOption[$i] !="") {
        $resultado.= "<OPTION value=" . $defaultValue[$i];
        if ($defaultValue[$i]==$seleccionado)
          $resultado.= " SELECTED ";
        $resultado.= ">" . $defaultOption[$i] . "</OPTION>";
      }
    }
  }
  else {
    if ($defaultValue . $defaultOption !="") {
      $resultado.= "<OPTION value=" . $defaultValue;
      if ($defaultValue==$seleccionado)
        $resultado.= " SELECTED ";
      $resultado.= ">" . $defaultOption . "</OPTION>";
    }
  }
  $resultado.=cargarListBox($sql,$seleccionado);
  $resultado.= "</select>";
  return $resultado;
}

function campoCheckBox($nombreCampo,$checkedValue="",$value="",$atributos="") {
  echo "<input type=\"checkbox\"  name=\"$nombreCampo\" $atributos value=$checkedValue ";
  if ($checkedValue==$value) {
    echo "CHECKED";
  }
  echo ">";
}

// carga en una lista desplegable con datos de un array
// (primer campo value, segundo campo texto desplegado)
// dejando seleccionado al elemento con valor igual al segundo parametro
function cargarListBoxArray($arr,$seleccionado) {
  $i=0;
  while ($i*2+1<sizeof($arr)){
    echo "<OPTION value=" . $arr[$i*2];
    if ($arr[$i*2]==$seleccionado) {
      echo " SELECTED ";
    }
    echo ">" . $arr[$i*2+1] . "</OPTION>";
    $i++;
  }
  return false;
}

function campoSelectArray($nombreCampo,$arr, $seleccionado,$defaultValue="",$defaultOption="",$atributos="") {
  echo "<select name=\"$nombreCampo\" $atributos>";
  if ($defaultValue . $defaultOption !="") {
    echo "<OPTION value=" . $defaultValue;
    if ($defaultValue==$seleccionado)
      echo " SELECTED ";
    echo ">" . $defaultOption . "</OPTION>";
  }
  cargarListBoxArray($arr,$seleccionado);
  echo "</select>";
}

function xmail
($email_address,
$email_cc,
$email_bcc,
$email_from,
$subject,
$msg,
$attach_filepath,
$want_attach)
{

                $header="";

                if($email_from!="") {
                        $header.="From: ".$email_from."\n";
                }
                if($email_cc!="") {
                        $header.="CC: ".$email_cc."\n";
                }
                if($email_bcc!="") {
                        $header.="BCC: ".$email_bcc."\n";
                }
                if($email_from!="") {
                        $header.="nErrors-To: ".$email_from."\n";
                }

       $b = 0;
       $mail_attached = "";
       $boundary = "000XMAIL000";
       if (count($attach_filepath)>0 && $want_attach) {
           for ($a=0;$a<count($attach_filepath);$a++) {
                              if (count($attach_filepath)==1) {
                                  $attach_file=$attach_filepath;
                              }
                           else {
                                            $attach_file=$attach_filepath[$a];
                           }
               if ($fp=fopen($attach_file,"rb")) {
                   $file_name=basename($attach_file);
                   $file_extension="";
                   if (strlen($file_name)>3) {
                       $file_extension=substr($file_name,-3);
                   }
                   //si no hay extension no se deberÌa seguir
                   $content[$b]=fread($fp,filesize($attach_file));
                   $mail_attached.="--".$boundary."\n";
                   switch ($file_extension) {
                            case "jpg":
                                  $mail_attached.="Content-Type: image/jpeg; name=\"$file_name\"\n";
                                                   $mail_attached.="Content-Transfer-Encoding: base64\n"
                                                       ."Content-ID: img$a \n"
                                                       ."Content-Disposition: inline; filename=\"$file_name\"\n\n"
                                                       .chunk_split(base64_encode($content[$b]))."\n";
                            break;
                            case "gif":
                                  $mail_attached.="Content-Type: image/gif; name=\"$file_name\"\n";
                                                   $mail_attached.="Content-Transfer-Encoding: base64\n"
                                                       ."Content-ID: img$a \n"
                                                       ."Content-Disposition: inline; filename=\"$file_name\"\n\n"
                                                       .chunk_split(base64_encode($content[$b]))."\n";
                            break;
                            case "mdb":
                                  $mail_attached.="Content-Type: application/msaccess; name=\"$file_name\"\n";
                                                   $mail_attached.="Content-Transfer-Encoding: base64\n"
                                                       ."Content-Disposition: attachment; filename=\"$file_name\"\n\n"
                                                       .chunk_split(base64_encode($content[$b]))."\n";
                            break;
                   }

                   $b++;
                   fclose($fp);
               } else {
                   echo "no se encontro el archivo " . $attach_file;
               }
           }
           $mail_attached .= "--".$boundary."\n";
           $add_header ="MIME-Version: 1.0\n"
."Content-Type: multipart/mixed; boundary=\"$boundary\";
Message-ID: <".md5($email_from)."@todopeluqueria.com>";
           $mail_content="--".$boundary."\n"
                       ."Content-Type: text/html; charset=\"iso-8859-1\"\n"
                       ."Content-Transfer-Encoding: 8bit\n\n"
                       .$msg."\n\n".$mail_attached;
           return mail($email_address, $subject, $mail_content, $header.$add_header);
       } else {
           return mail($email_address, $subject, $msg, $header);
       }
}

function mostrarLista($elementos,$list) {
global $conexion;
 $resultado="";
 echo "ml" . $conexion;
 switch ($elementos) {
    case "subscriptos":
          if ($list!="") {
             $sqlSeleccionados="SELECT IdSubscripto AS Id, Email AS Item FROM subscriptos WHERE IdSuscripto IN (". $list . ")  ORDER BY Email";
          } else {
             $sqlSeleccionados="";
          }
    break;
    case "envios":
          if ($list!="") {
             $sqlSeleccionados="SELECT IdEnvio AS Id, Asunto AS Item FROM envios ORDER BY Asunto";
          } else {
             $sqlSeleccionados="";
          }
    break;
  }
  if ($sqlSeleccionados!="") {
    $rsSeleccionados = mysqli_db_query(BASE_BD, $sqlSeleccionados, $conexion) or die ("Could not execute query: $sqlSeleccionados. " . mysqli_error());
    while($row = mysqli_fetch_array($rsSeleccionados))
    {
      if ($resultado!=""){
        $resultado.=", ";
      }
      $resultado.=$row["Item"];
    }
  }
  return $resultado;
}

?>