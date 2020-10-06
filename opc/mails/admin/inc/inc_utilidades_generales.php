<?PHP
//UTILIDADES GENERALES

function ejecutar() {
	$num_args = func_num_args();
	if ($num_args>0) {
		$args=func_get_args();
		$func=array_shift($args);		
		if (is_callable($func, true,$nombre_a_llamar)){
			//echo "n:" . $nombre_a_llamar;
			if (function_exists($nombre_a_llamar) ) {
				call_user_func_array($func,$args);
			} else {
				if (is_array($func) && count($func)>1 && method_exists($func[0],$func[1])) {
					call_user_func_array($func,$args);
				}
			}
		} 
	}
}

function val($n) {
	if (is_numeric($n)) {
	    return $n;
	}
	else  {
		return floatval($n);
	}
}
// devuelve el nombre de la página actual dada la url
function obtenerPagina($url){
  $i = strrpos($url, "/") + 1;
  $pagina = substr($url, $i);
  return $pagina;
}
// genera los option para días del 1 al 31 en una lista desplegable
// queda seleccionado el día indicado en el parámetro de entrada
function cargarDias($seleccionado) {
  echo "<option value=''> </option>";
  for ($i=1;$i<=31;$i++) {
    echo "<option";
    if ($i==$seleccionado)
      echo " selected='selected' ";
    echo " value = " . $i;
    echo ">" . $i . "</option>";
  }
  return false;
}
// genera los option para mese del 1 al 12 en una lista desplegable
// queda seleccionado el mes indicado en el parámetro de entrada
function cargarMeses($seleccionado) {
  echo "<option value=''> </option>";
  $meses[0]="Enero";
  $meses[1]="Febrero";
  $meses[2]="Marzo";
  $meses[3]="Abril";
  $meses[4]="Mayo";
  $meses[5]="Junio";
  $meses[6]="Julio";
  $meses[7]="Agosto";
  $meses[8]="Setiembre";
  $meses[9]="Octubre";
  $meses[10]="Noviembre";
  $meses[11]="Diciembre";
  for ($i=0;$i<12;$i++) {
    echo "<option";
    if ($i==$seleccionado-1)
      echo " selected='selected' ";
    echo " value = " . ($i+1);
    echo ">" . ($i+1) . "</option>";
  }
  return false;
}
// genera los option para años del rango recibido en una lista desplegable
// queda seleccionado el año indicado en el parámetro de entrada
function cargarAnios($desde,$hasta,$seleccionado) {
  echo "<option value=''> </option>";
  for ($i=$desde;$i<=$hasta;$i++) {
    echo "<option";
    if ($i==$seleccionado)
      echo " selected='selected' ";
    echo " value = " . $i;
    echo ">" . $i . "</option>";

  }
  return false;
}
// carga en una lista desplegable los registros resultantes de la consulta sql
// (primer campo value, segundo campo texto desplegado)
// dejando seleccionado al elemento con valor igual al segundo parametro
function cargarLista($sql,$seleccionado) {
  //Hago la consulta para cargar los registros
  $rs = mysqli_query($sql)
    or die ("Error al realizar la consulta (" . $sql . ")");
  while ($rowRs = mysqli_fetch_array($rs)){
    echo "<option";
    if ($rowRs[0]==$seleccionado)
      echo " selected='selected' ";
    echo " value='" . $rowRs[0] . "'";
    echo ">" . $rowRs[1] . "</option>";
  }
  //Cierro el recordset
  mysqli_free_result($rs);
  return false;
}
function fechaDMY($fechaMYSQL,$separador="/") {
  if (strlen($fechaMYSQL)>=10) {
    return substr($fechaMYSQL,8,2) . $separador . substr($fechaMYSQL,5,2) . $separador . substr($fechaMYSQL,0,4);
  }
  else
  {
    return "";
  }
}
//muestra el valor dado si esta definido
function mv($array,$indice,$valorPorDefecto="",$valorSiNulo=null){
  echo cv($array,$indice,$valorPorDefecto,$valorSiNulo);
}
//devuelve el valor dado si esta definido
function cv($array,$indice,$valorPorDefecto="",$valorSiNulo=null){
  if (arrayKeyExists($indice,$array))
    if ($array[$indice]==null)
      return $valorSiNulo;
    else
      return $array[$indice];
  else
    return $valorPorDefecto;
}
//para versiones menores a 4.1 usar esto, sino array_key_exists
function arrayKeyExists($key, $search) {
  if (is_array($search)) {
    return (sizeof(array_keys(array_keys($search),$key))>1);
  }
  else {
    return false;
  }
}
function scriptsJS(){
  scriptsJSvalidacion();
  scriptsJSnavegacion();
}
function scriptsJSvalidacion(){
?>
<script type="text/javascript">
 function validarFecha(strDate){
   if((strDate.length > 6)||(strDate != '//')){
     var dateregex=/^[ ]*[0]?(\d{4,})\/(\d{1,2})\/(\d{1,2})[ ]*$/;
     var match=strDate.match(dateregex);
     if (match){
       var tmpdate=new Date(match[1],parseInt(match[2],10)-1,match[3]);
       if (tmpdate.getDate()==parseInt(match[3],10) && tmpdate.getFullYear()==parseInt(match[1],10) && (tmpdate.getMonth()+1)==parseInt(match[2],10)){
         return true;
       }
     }
    return false;
    }
    else{
      return true;
    }
 }
 function validarNumero(campo,mensaje) {
   if (isInteger(campo.value)) {
     return "";
   }
   else
   {
     return "\n" + mensaje;
   }
 }
 function isDigit (c)
{   return ((c >= "0") && (c <= "9"))
}
function isInteger (s)
 {
  var i;
  for (i = 0; i < s.length; i++)
  {
    var c = s.charAt(i);
    if (!isDigit(c)) return false;
  }
  return true;
 }
  function derecha(str, n)
  {
    if (n <= 0)
      return "";
    else if (n > String(str).length)
      return str;
    else {
      var iLen = String(str).length;
      return String(str).substring(iLen, iLen - n);
    }
  }
 function armarFecha(campoDia,campoMes,campoAnio) {
  if (campoDia.selectedIndex!=-1) {
    dd= derecha("00" + campoDia.options[campoDia.selectedIndex].value,2);
    if (dd=="00") {
        dd="";
    }
  }
  else {
    dd="";
  }
  if (campoDia.selectedIndex!=-1) {
    mm= derecha("00"+campoMes.options[campoMes.selectedIndex].value,2);
    if (mm=="00") {
        mm="";
    }
  }
  else {
    mm="";
  }
  aa= campoAnio.value;
  return aa + '/' + mm + '/' + dd;
 }
 function comprobarFecha(fecha,mensaje) {
  if(!validarFecha(fecha)){
    return "\n" + mensaje;
  }
  else {
    return "";
  }
 }
 function comprobarFechas(fechaDesde,fechaHasta,mensaje) {
  if (validarFecha(fechaDesde) && validarFecha(fechaHasta) && fechaDesde!="//" && fechaHasta!="//") {
    if (fechaDesde>fechaHasta){
      return "\n" + mensaje;
    }
    else {
      return "";
    }
  }
  else {
    return "";
  }
 }
  function comprobarRangos(campoDesde,campoHasta,mensaje) {
  if (isInteger(campoDesde.value) && isInteger(campoHasta.value)) {
    if (parseInt(campoDesde.value)>parseInt(campoHasta.value)){
      return "\n" + mensaje;
    }
    else {
      return "";
    }
  }
  else {
    return "";
  }
 }
</script>
<?PHP
}
function scriptsJSnavegacion(){
?>
<script type="text/javascript">
 function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
 }
 function abrirSelector(elementos,campo,lista) {
  window.open('selector.php?texto=A&elementos=' + elementos + '&campo=' + campo + '&list=' + lista,'Selector','width=580, height=470,  menubar=no, status=yes, location=no, toolbar=no, scrollbars=no, resizable=yes');
 return false;
 }
 function abrirVentana(url,nombre,ancho,alto) {
  window.open(url,nombre,'width=' + ancho + ', height=' + alto + ',  menubar=no, status=yes, location=no, toolbar=no, scrollbars=no, resizable=yes');
 return false;
 }
</script>
<?PHP
}


// carga en una lista desplegable los registros resultantes de la consulta sql
// (primer campo value, segundo campo texto desplegado)
// dejando seleccionado al elemento con valor igual al segundo parametro
function cargarListBox($sql,$seleccionado, $conexion) {
        //Hace la consulta para cargar los registros
        $rs = mysqli_query($conexion,$sql);
        $resultado=cargarListBoxRS($rs,$seleccionado);
        //Cierra el recordset
        mysqli_free_result($rs);
        return $resultado;
}

function cargarListBoxRS($rs,$seleccionado) {
	$resultado="";
	$rs->irAFila(0);
	while ($rowRs = $rs->darSiguienteFila()){
			$resultado.= "<option";
			if ($rowRs[0]==$seleccionado) {
				$resultado.= " selected ='selected' ";
			}
			$resultado.= " value='" . $rowRs[0] . "'";
			$resultado.= ">" . $rowRs[1] . "</option>";
	}
	return $resultado;
}

function xcargarListBoxRS($rs,$seleccionado) {
	$resultado="";
	mysqli_data_seek($rs,0);
	while ($rowRs = mysqli_fetch_array($rs)){
			$resultado.= "<option";
			if ($rowRs[0]==$seleccionado) {
				$resultado.= " selected ='selected' ";
			}
			$resultado.= " value='" . $rowRs[0] . "'";
			$resultado.= ">" . $rowRs[1] . "</option>";
	}
	return $resultado;
}

function campoSelect($nombreCampo,$sql, $seleccionado,$defaultValue="",$defaultOption="",$atributos="") {
  $resultado= "<select name=\"$nombreCampo\" $atributos>";
  if (is_array($defaultValue) && is_array($defaultOption)) {
    for ($i=0;$i<count($defaultValue);$i++) {
      if ($defaultValue[$i] . $defaultOption[$i] !="") {
        $resultado.= "<option";
        if ($defaultValue[$i]==$seleccionado)
          $resultado.= " selected ='selected' ";
        $resultado.= " value='" . $defaultValue[$i] ."'";
        $resultado.= ">" . $defaultOption[$i] . "</option>";
      }
    }
  }
  else {
    if ($defaultValue . $defaultOption !="") {
      $resultado.= "<option";
      if ($defaultValue==$seleccionado)
        $resultado.= " selected ='selected' ";
      $resultado.= " value='" . $defaultValue ."'";
      $resultado.= ">" . $defaultOption . "</option>";
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

// carga en una lista desplegable con datos de un array asociativo
// (clave es el value y el valor es el texto de la opcioon)
// dejando seleccionado al elemento con valor igual al segundo parametro
function cargarListBoxArrayAsociativo($arr,$seleccionado) {
  $i=0;
  $resultado="";
	foreach($arr as $k => $v) {
	    $resultado.= "<option";
	    if ($k==$seleccionado) {
	      $resultado.= " selected ='selected' ";
	    }
	    $resultado.= " value='" . $k . "'";
	    $resultado.= ">" . $v . "</option>";
	}
  return $resultado;
}


// carga en una lista desplegable con datos de un array
// (primer campo value, segundo campo texto desplegado)
// dejando seleccionado al elemento con valor igual al segundo parametro
function cargarListBoxArray($arr,$seleccionado) {
  $i=0;
  $resultado="";
  while ($i*2+1<sizeof($arr)){
    $resultado.= "<option";
    if ($arr[$i*2]==$seleccionado) {
      $resultado.= " selected ='selected' ";
    }
    $resultado.= " value='" . $arr[$i*2] . "'";
    $resultado.= ">" . $arr[$i*2+1] . "</option>";
    $i++;
  }
  return $resultado;
}

function campoSelectArray($nombreCampo,$arr, $seleccionado,$defaultValue="",$defaultOption="",$atributos="") {
  echo "<select name=\"$nombreCampo\" $atributos>";
  if ($defaultValue . $defaultOption !="") {
    echo "<option";
    if ($defaultValue==$seleccionado)
      echo " selected='selected' ";
    echo " value='" . $defaultValue . "'";
    echo ">" . $defaultOption . "</option>";
  }  
  cargarListBoxArray($arr,$seleccionado);
  echo "</select>";
}


?>