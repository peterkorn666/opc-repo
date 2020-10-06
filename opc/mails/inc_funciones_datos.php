<?
// genera el icono para ordenar
function orden($campo,$columna=null,$direccion=null) {
        global $o,$od; // $o = numero de columna  a usar , $od direccion 1=asc 2=desc
        $resultado="";
        if ($columna==null  && isset($o)) {
            $columna=$o;
        }
        if ($direccion==null && isset($od)) {
            $direccion=$od;
        }
        $nuevoOrden="1";
        if ($campo==$columna && $direccion==1) {
            $nuevoOrden="2";
        }
        $resultado.= '<a href="#" onClick="return cambiarOrden(' . $campo . ',' . $nuevoOrden . ');">';
        if ($nuevoOrden==2) {
                $resultado.= '<img src="img/o_desc.gif" width="11" height="10" border="0" align="middle">';
        } else {
                $resultado.= '<img src="img/o_asc.gif" width="11" height="10" border="0" align="middle">';
        }
        $resultado.= '</a>';
        return $resultado;
}

// sentencia order by
function orderBy($arrayOrden=null,$columna=null,$direccion=null) {
 global $orden,$o,$od; // $orden = array con ordenes , $o = numero de columna  a usar , $od direccion 1=asc 2=desc
        if ($arrayOrden==null  && isset($orden)) {
            $arrayOrden=$orden;
        }
        if ($columna==null  && isset($o)) {
            $columna=$o;
        }
        if ($direccion==null && isset($od)) {
            $direccion=$od;
        }
 $resultado="";
 if ($columna>0) {
    $resultado.=" ORDER BY " . $arrayOrden[$o];
         if ($direccion==2) {
            $resultado.=" DESC";
         }
 }
 return $resultado;
}


// da el valor de la tabla de configuracion
function valorConfiguracion($clave) {
        global $conexion;
        $mensaje="";
        $rs=null;
        buscarDatos("configuracion","Valor","Clave='$clave'",$rs, $mensaje,$conexion);
        if ($rs && mysqli_num_rows($rs)>0) {
            $rowConf=mysqli_fetch_array($rs);
                return $rowConf["Valor"];
        } else {
                return "";
        }
}



// carga los valores por defecto
// en general los deja vacíos
// pero se pueden especificar otros valores
function valoresPorDefecto(&$campos,$porDefecto) {
  $keys=array_keys($campos);
  for ($i=0;$i<count($keys);$i++) {
  if (array_key_exists ( $keys[$i], $porDefecto )) {
          $campos[$keys[$i]]=$porDefecto[$keys[$i]];
        } else {
        $campos[$keys[$i]]="";
        }
  }
}

// lee los parametros del get y post
function leerParametros(&$campos,$porDefecto) {
  $keys=array_keys($campos);
  for ($i=0;$i<count($keys);$i++) {
  if (array_key_exists ( $keys[$i], $porDefecto )) {
          $campos[$keys[$i]]=leerParametro($keys[$i],$porDefecto[$keys[$i]]);
        } else {
          $campos[$keys[$i]]=leerParametro($keys[$i]);
        }
        }
}



function agregarRegistro(&$mensaje,$tabla,$campoClave,$campos,$conexion) {
        $resultado=false;
  $nombresCampos="";
  $valores="";
  $keys=array_keys($campos);
  for ($i=0;$i<count($keys);$i++) {
          if ($nombresCampos!="") {
               $nombresCampos .= ",";
          }
        $nombresCampos .=  $keys[$i];
          if ($valores!="") {
               $valores .= ",";
          }
        $valores .=  "'" . $campos[$keys[$i]] . "'";
        }

        $sql="INSERT INTO " . $tabla . "(" . $nombresCampos . ") VALUES (" . $valores . ")";

        $ins=mysqli_query($conexion,$sql);
        if (mysqli_error()) {
            $mensaje = "La base de datos devolvió el error: ". mysqli_error();
        } else {
                $id=mysqli_insert_id($conexion);
                if ($id>0) {
                        $resultado=$id;
                        $mensaje = "El nuevo registro tiene el id: " . $id;
                } else {
                        $agregados=mysqli_affected_rows($conexion);
                        if ($agregados>0) {
                                $resultado=true;
                                $mensaje = "$agregados Registro(s) agregados";
                        }
                }
        }
        return $resultado;
}

function actualizarRegistro($id, &$mensaje,$tabla,$campoClave,$campos,$conexion) {
  $resultado=false;
  $keys=array_keys($campos);
  $sql="";
  for ($i=0;$i<count($keys);$i++) {
          if ($sql!="") {
               $sql .= ",";
          }
        $sql .=  $keys[$i] . "=" ."'" . $campos[$keys[$i]] . "'";
        }

        $sql="UPDATE " . $tabla . " SET " . $sql;
        $sql.=" WHERE ". condicionCampoClave($id,$campoClave);
        $upd=mysqli_query($conexion,$sql);
        if (mysqli_error()) {
            $mensaje = "La base de datos devolvió el error: ". mysqli_error();
        } else {
                $resultado=true;
                $registrosAfectados=mysqli_affected_rows($conexion);
                if ($registrosAfectados>0) {
                        $mensaje = "$registrosAfectados Registro(s) modificado";
                }
                else {
                        $mensaje = "No se modificó ningún registro";
                }
        }
        return $resultado;
}

function condicionCampoClave($id,$campoClave){
         $resultado="1=2";
         if (count($id)==count($campoClave)) {
             if (count($id)==1) {
                $resultado=$campoClave . "='". $id ."'";
             } else {
                 $resultado="";
                 for ($i=0;$i<count($id);$i++) {
                       if ($resultado!="") {
                            $resultado.=" AND ";
                       }
                       $resultado.=$campoClave[$i]."='". $id[$i] ."'";
                 }
           }
         }
         return "(" .  $resultado . ")";
}

function leerDatos($id, &$mensaje, $tabla,$campoClave,&$campos,$conexion ) {
  $resultado=false;
  $keys=array_keys($campos);
  $sql="";
  for ($i=0;$i<count($keys);$i++) {
          if ($sql!="") {
               $sql .= ",";
          }
        $sql .=  $keys[$i] ;
        }

        $sql="SELECT " . $sql . " FROM ". $tabla;
        $sql.=" WHERE " .condicionCampoClave($id,$campoClave);

        $sel=mysqli_query($conexion,$sql);
        if (mysqli_error()) {
            $mensaje = "La base de datos devolvió el error: ". mysqli_error();
        } else {
                if ($sel) {
                        if (mysqli_num_rows($sel)>0) {
                                  $datos=mysqli_fetch_array($sel);
                              $keys=array_keys($campos);
                                  for ($i=0;$i<count($keys);$i++) {
                                          if (array_key_exists ( $keys[$i], $datos )) {
                                                  $campos[$keys[$i]]=$datos[$keys[$i]];
                                                } else {
                                                  $campos[$keys[$i]]="";
                                                }
                                        }
                                  $resultado=true;
                        }else {
                                $mensaje = "No se encontró ningún registro ";
                        }
                }
        }
        return $resultado;
}


function buscarDatos($tabla,$campos,$condiciones,&$rs, &$mensaje,$conexion) {
  $encontrados=-1;

  if (count($campos)==1) {
      $keys=array($campos);
  } else {
          $keys=array_keys($campos);
  }
  $sql="";
  for ($i=0;$i<count($keys);$i++) {
          if ($sql!="") {
               $sql .= ",";
          }
        $sql .=  $keys[$i] ;
        }

        $sql="SELECT " . $sql . " FROM ". $tabla;
        if ($condiciones!="") {
                $sql.=" WHERE " . $condiciones;
        }

        $rs=mysqli_query($conexion,$sql);
        if (mysqli_error()) {
            $mensaje = "La base de datos devolvió el error: ". mysqli_error();
        } else {
                if ($rs) {
                        $encontrados=mysqli_num_rows($rs);
                        if ($encontrados>0) {
                                $mensaje = "$encontrados Registro(s) encontrado(s)";
                        }else {
                                $mensaje = "No se encontró ningún registro ";
                        }
                }
        }
        return $encontrados;
}

function borrarRegistro($id, &$mensaje,$tabla,$campoClave,$conexion) {
  $resultado=false;

        $sql="DELETE FROM " . $tabla;
        $sql.=" WHERE " . condicionCampoClave($id,$campoClave);
        $del=mysqli_query($conexion,$sql);
        if (mysqli_error()) {
            $mensaje = "La base de datos devolvió el error: ". mysqli_error();
        } else {
                $eliminados=mysqli_affected_rows($conexion);
                if ($eliminados>0) {
                                                $mensaje = "$eliminados Registros eliminado(s)";
                        $resultado=true;
                }
                else {
                        $mensaje = "No se eliminó ningún registro";
                }
        }
        return $resultado;
}
?>