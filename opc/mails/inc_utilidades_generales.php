<?php



//UTILIDADES GENERALES

function val($n) {
	if (is_numeric($n)) {
	    return $n;
	}
	else  {
		return floatval($n);
	}

}

// arma la condicion de busqueda de texto para los campos dados  en el formato "campo1,campo2,campo3"
// la condicion final selecciona los registro que contenga alguna de las palabras en alguno de los campos
function condicionTexto($campos,$texto) {
        $texto = trim($texto);
        //Obtengo un array que contiene en cada posición una palabra del string
        $palabras = explode(" ", $texto);
        //Obtengo un array que contiene en cada posición un campo
        $camposArray = explode(",",$campos);
        $cantidadPalabras = sizeof($palabras);
        $cantidadCampos=sizeof($camposArray);
        $condicionFinal = "";
        // para cada campo armo la condicion con cada palabra
        for ($j=0;$j<$cantidadCampos;$j++) {
                if ($condicionFinal!="")
                        $condicionFinal = $condicionFinal . " OR ";

                $condicionCampo="";
                for ($i=0;$i<$cantidadPalabras;$i++){
					if ($palabras[$i]!="") {
                        if ($condicionCampo!="")
                                $condicionCampo = $condicionCampo . " OR ";
                        $condicionCampo = $condicionCampo .  $camposArray[$j] . " LIKE '%" . $palabras[$i] . "%'";					    
					}
                }
				if ($condicionCampo!="") {
	                $condicionFinal = $condicionFinal . " ( " . $condicionCampo . " ) ";				    
				}

        }

        if ($condicionFinal!="")
                $condicionFinal =  " ( " . $condicionFinal . " ) ";
        return $condicionFinal;
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

    echo "<option value = " . $i;

    if ($i==$seleccionado)

      echo " selected ";

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

    echo "<option value = " . ($i+1);

    if ($i==$seleccionado-1)

      echo " selected ";

    echo ">" . ($i+1) . "</option>";

  }

  return false;

}



// genera los option para años del rango recibido en una lista desplegable

// queda seleccionado el año indicado en el parámetro de entrada

function cargarAnios($desde,$hasta,$seleccionado) {

  echo "<option value=''> </option>";

  for ($i=$desde;$i<=$hasta;$i++) {

    echo "<option value = " . $i;

    if ($i==$seleccionado)

      echo " selected ";

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

    echo "<OPTION value=" . $rowRs[0];

    if ($rowRs[0]==$seleccionado)

      echo " SELECTED ";

    echo ">" . $rowRs[1] . "</OPTION>";

  }

  //Cierro el recordset

  mysqli_free_result($rs);



  return false;

}



//lee un parámetro buscándolo primero en el post y luego en el get

function leerParametroPostGet($parametro,$valorPorDefecto="") {

  return leerParametro($parametro,$valorPorDefecto="");

}





function leerParametro($parametro,$valorPorDefecto="") {

global $_POST,$_GET,$_FILES;

  if(isset($_POST[$parametro])){
    if ($_POST[$parametro]!="") {
      return $_POST[$parametro];
    } else {
      return $valorPorDefecto;
    }
  } else  {
    if(isset($_GET[$parametro])){
      if ($_GET[$parametro]!="") {
        return $_GET[$parametro];
      } else {
        return $valorPorDefecto;
      }
    } else {
    	if(isset($_FILES[$parametro])){
	      if ($_FILES[$parametro]!="") {
	        return $_FILES[$parametro];
	      } else {
	        return $valorPorDefecto;
		  }
	    } else {
	      return $valorPorDefecto;
	    }
     }
   }
}



//lee un parámetro buscándolo primero en el post y luego en el get

function leerParametroGetPost($parametro,$valorPorDefecto="") {

global $_POST,$_GET;

  if(!empty($_GET[$parametro])){

    return $_GET[$parametro];

  } else  if(!empty($_POST[$parametro])){

    return $_POST[$parametro];

  } else {

    return $valorPorDefecto;

  }

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

<script language="JavaScript">

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

<?

}





function scriptsJSnavegacion(){

?>

<script language="JavaScript">

 function MM_goToURL() { //v3.0

  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;

  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");

 }



 function abrirSelector(elementos,campo,lista,funcionRetorno) {

  window.open('selector.php?texto=A&elementos=' + elementos + '&campo=' + campo + '&funcionRetorno=' + funcionRetorno + '&list=' + lista,'Selector','width=580, height=470,  menubar=no, status=yes, location=no, toolbar=no, scrollbars=no, resizable=yes');

 return false;

 }



 function abrirVentana(url,nombre,ancho,alto) {

  window.open(url,nombre,'width=' + ancho + ', height=' + alto + ',  menubar=no, status=yes, location=no, toolbar=no, scrollbars=no, resizable=yes');

 return false;

 }

</script>

<?

}

?>