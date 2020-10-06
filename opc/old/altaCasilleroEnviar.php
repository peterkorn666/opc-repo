<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");

include('conexion.php');
include('clases/class.Casillero.php');
//
function remplazarTexto($cual){	
	$valor = str_replace("\n", "<br>" , $cual);
	return  $valor;
}

//$_POST = array_map("utf8_encode",$_POST);
$casillero = new casillero();
	
$casillero->respaldarActividades($_POST["casilleroViejo"]);

//$para_atras = $_POST["para_atras"];
//
$arraySala = $_POST["sala_"];
//

$area_ = $_POST["area_"];
$tematica_ = $_POST["tematica_"];

$tipo_de_actividad_ = $_POST["tipo_de_actividad_"];
$titulo_de_actividad_ = trim($_POST["titulo_de_actividad_"]);
$titulo_de_actividad_ing = trim($_POST["titulo_de_actividad_ing"]);
$resumen_actividad = trim($_POST["resumen_actividad"]);


$notaAdmin = trim($_POST["notaAdmin"]);



if($titulo_de_actividad_ == "Ingrese aquí el Titulo de la actividad"){
	$titulo_de_actividad_ = "";
}

if($titulo_de_actividad_ing == "Ingrese aquí el Titulo de la actividad"){
	$titulo_de_actividad_ing = "";
}

$trabajo = $_POST["trabajo"];
$trabajo_ing = $_POST["trabajo_ing"];
$en_calidad = $_POST["en_calidad"];
$persona = $_POST["persona"];
$observaciones = $_POST["observaciones"];

$mostrarOPC = $_POST["mostrarOPC"];
$participa = $_POST["participa"];
$archivoPonencia = $_POST["archivoPonencia"];
$confirmado = $_POST["confirmado"];
$comentarios = $_POST["comentarios"];
$desdeSistema = $_POST["desdeSistema"];

$en_crono = $_POST["en_crono"];

$tl = $_POST["trabajo_libre_"];

if($tl != 1){
	$sql = "UPDATE trabajos_libres SET ID_casillero = '0' WHERE ID_casillero='".$_POST["casilleroViejo"]."';";
	mysql_query($sql, $con);
}


$agruparSalas = $_POST["agruparSalas"];



$dia_ = $_POST["dia_"];
$sql = "SELECT * FROM dias where Dia='$dia_';";
$rs = mysql_query($sql, $con);
while ($row = mysql_fetch_array($rs)){
	$dia_ = $row["Dia"];
	$dia_orden_ = $row["Dia_orden"];
}

$hora_inicio_ = $_POST["hora_inicio_"];
$hora_fin_ = $_POST["hora_fin_"];

$ingresar=true;



$sql_ = "SELECT sala_agrupada FROM congreso where sala_agrupada = '".$_POST["casilleroViejo"]."' limit 1;";
$rs_ = mysql_query($sql_,$con);
$estabanAgrupadas = mysql_num_rows($rs_);


if($agruparSalas==1 || $estabanAgrupadas>0){
	$filtroSalas = "and sala_agrupada <> '" . $_POST["casilleroViejo"] . "'";
}else{
	$filtroSalas = "";
}

/*verificco que no exista el casillero*/
$sql = 	"SELECT * FROM congreso where Casillero<>'" . $_POST["casilleroViejo"] . "' $filtroSalas  and  Dia='$dia_' and Hora_inicio = '$hora_inicio_ ' and (";

$definiOR = 0;
foreach($arraySala as $sala){

	if($definiOR == 1){
		$sql .= " or ";
	}
	$definiOR = 1;

	$sql .= " Sala = '$sala' " ;

}
$sql .= ");";

$rs = mysql_query($sql,$con) or die(mysql_error());


if(mysql_num_rows($rs)>=1){

	$ingresar = false;
	casillero_fallo(substr($hora_inicio_, 0, -3), $dia_, $para_atras);

}

if($agruparSalas==1){
	$seExpande = count($arraySala);
	$salasAnidadas = 1;
}else{
	$seExpande = 1;
	$salasAnidadas = 0;
}



if ($ingresar==true){
	

	if($_POST["casilleroViejo"]!=""){

		$sql = "SELECT *  FROM congreso WHERE Casillero='".$_POST["casilleroViejo"]."' LIMIT 1;";
		$rs = mysql_query($sql, $con);
		while ($row = mysql_fetch_array($rs)){
			if($row["sala_agrupada"] !=0){
				$sql2 = "DELETE FROM congreso WHERE Dia='".$row["Dia"]."' and Hora_inicio='".$row["Hora_inicio"]."' and sala_agrupada = '".$_POST["casilleroViejo"]."';";
				mysql_query($sql2, $con) or die(mysql_error());
			}else{
				$sql2 = "DELETE FROM congreso WHERE Casillero='".$_POST["casilleroViejo"]."';";
				mysql_query($sql2, $con) or die(mysql_error());
			}
			$sqlTL = mysql_query("UPDATE trabajos_libres SET ID_casillero = '0', orden='0' WHERE ID_casillero='".$_POST["casilleroViejo"]."'",$con);
		}

	}


	foreach($arraySala as $sala){


		$sql = "SELECT * FROM salas where Sala='$sala';";
		$rs = mysql_query($sql, $con) or die(mysql_error());
		while ($row = mysql_fetch_array($rs)){
			$sala_ = $row["Sala"];
			$sala_orden_ = $row["Sala_orden"];
		}


		/*genero el casillero*/
		$casillero_ = $dia_orden_ . $sala_orden_ . $hora_inicio_;
		$casillero_ = str_replace(":","",$casillero_);


		if($agruparSalas==1){
			$agruparSalas=$casillero_;
		}
		
		$trabajo_libre_Registrado = false;


		for($i=0; $i<count($trabajo); $i++){
			if($trabajo[$i]=="Ingrese aquí el Título del trabajo"){
				$trabajo[$i] = "";
			}
			if($trabajo_ing[$i]=="Ingrese aquí el Título del trabajo"){
				$trabajo_ing[$i] = "";
			}
			if($persona[$i]=="Buscar participante por su apellido, en la base de datos..."){
				$persona[$i] = "";
			}
			$per_prof = "";
			$per_nom = "";
			$per_ape = "";
			$per_carg = "";
			$per_inst = "";
			$per_pais = "";
			$per_mail = "";
			$per_curr = "";
			$per_id = "";
			if($trabajo[$i]!="" || $persona[$i]!="" || $en_calidad[$i]!="" || $i==0){
				if($persona[$i]!=""){						
					$sql_persona = "SELECT * FROM personas where ID_Personas=" . $persona[$i];
					$rs = mysql_query($sql_persona, $con);
					while ($row = mysql_fetch_array($rs)){
						$per_prof = $row["profesion"];
						$per_nom = $row["nombre"];
						$per_ape = $row["apellido"];
						$per_carg = $row["cargo"];
						$per_inst = $row["institucion"];
						$per_pais = $row["pais"];
						$per_mail = $row["email"];
						$per_curr = $row["cv"];
						$per_id = $row["ID_Personas"];
						
					}
					mysql_query($sql_persona, $con);

				}				
				/*setea el trabajo libre en el primer lugar vacio*/
				if($trabajo[$i]=="" && $persona[$i]=="" && $en_calidad[$i]=="" && $i==1){
					$trabajoLibre = 1;
					$tl = 0;
					$trabajo_libre_Registrado = true;				
				}else{
					$trabajoLibre = 0;
				}
				/*inserto en tabla congreso*/	
				$aparicion = $i+1;
				$parametros = array (
					"Casillero"=>$casillero_ ,
					"Orden_aparicion"=>$aparicion ,
					"Dia"=>$dia_ ,
					"Dia_orden"=>$dia_orden_ ,
					"Sala"=>$sala_ ,
					"Sala_orden"=>$sala_orden_ ,
					"resumen_actividad"=>$resumen_actividad ,
					"seExpande"=>$seExpande ,
					"Hora_inicio"=>$hora_inicio_ ,
					"Hora_fin"=>$hora_fin_ ,
					"Area"=>$area_ ,
					"Tematicas"=>$tematica_ ,
					"Tipo_de_actividad"=>$tipo_de_actividad_ ,
					"Titulo_de_actividad"=>$titulo_de_actividad_ ,
					"Titulo_de_actividad_ing"=>$titulo_de_actividad_ing ,
					"Trabajo_libre"=>$trabajoLibre ,
					"Titulo_de_trabajo"=>$trabajo[$i] ,
					"Titulo_de_trabajo_ing"=>$trabajo_ing[$i] ,
					"En_calidad"=>$en_calidad[$i],
					"Profesion"=>$per_prof  ,
					"Nombre"=>$per_nom  ,
					"Apellidos"=>$per_ape  ,
					"Cargos"=>$per_carg  ,
					"Institucion"=>$per_inst  ,
					"Pais"=>$per_pais  ,
					"Mail"=>$per_mail  ,
					"Curriculum"=>$per_curr  ,
					"ID_persona"=>$per_id  ,
					"en_crono"=>$en_crono[$i],
					"sala_agrupada"=>$agruparSalas ,
					"observaciones"=>remplazarTexto($observaciones[$i]) ,					
					"mostrarOPC"=>remplazarTexto($mostrarOPC[$i]) ,
					"participa"=>remplazarTexto($participa[$i]) ,
					"archivoPonencia"=>remplazarTexto($archivoPonencia[$i]) ,
					"confirmado"=>remplazarTexto($confirmado[$i]) ,
					"comentarios"=>remplazarTexto($comentarios[$i]) ,
					"desdeSistema"=>remplazarTexto($desdeSistema[$i]) ,
					"notaAdmin"=>$notaAdmin,
				);
				if($i==0){
					$parametros["orden_tl"] = $_POST["orden_tl"];
					$parametros["Trabajo_libre"] = $tl;
				}
				$resultado = $casillero->persistirCasillero($parametros);
				
			}else if($tl==1 && $trabajo_libre_Registrado==false){
			$parametros = array (
					"Casillero"=>$casillero_ ,
					"Orden_aparicion"=>($i+1) ,
					"Dia"=>$dia_ ,
					"Dia_orden"=>$dia_orden_ ,
					"Sala"=>$sala_ ,
					"Sala_orden"=>$sala_orden_ ,
					"seExpande"=>$seExpande ,
					"Hora_inicio"=>$hora_inicio_ ,
					"Hora_fin"=>$hora_fin_ ,
					"Area"=>$area_ ,
					"Tematicas"=>$tematica_ ,
					"Tipo_de_actividad"=>$tipo_de_actividad_ ,
					"Titulo_de_actividad"=>$titulo_de_actividad_ ,
					"Titulo_de_actividad_ing"=>$titulo_de_actividad_ing ,
					"Trabajo_libre"=>$tl ,
					"Titulo_de_trabajo"=>$trabajo[$i] ,
					"Titulo_de_trabajo_ing"=>$trabajo_ing[$i] ,
					"En_calidad"=>"",
					"Profesion"=>"",
					"Nombre"=>"",
					"Apellidos"=>"",
					"Cargos"=>"",
					"Institucion"=>"",
					"Pais"=>"",
					"Mail"=>"",
					"Curriculum"=>"",
					"ID_persona"=>"",
					"en_crono"=>0,
					"sala_agrupada"=>$agruparSalas ,
					"observaciones"=>remplazarTexto($observaciones[$i]) ,
					"mostrarOPC"=>remplazarTexto($mostrarOPC[$i]) ,
					"participa"=>remplazarTexto($participa[$i]) ,
					"archivoPonencia"=>remplazarTexto($archivoPonencia[$i]) ,
					"confirmado"=>remplazarTexto($confirmado[$i]) ,
					"comentarios"=>remplazarTexto($comentarios[$i]) ,
					"desdeSistema"=>remplazarTexto($desdeSistema[$i]) ,
					"notaAdmin"=>$notaAdmin
				);
				$resultado = $casillero->persistirCasillero($parametros);
		
				
				$tl = 0;
				$trabajo_libre_Registrado = true;
			}

		}
		if($resultado){
			if(count($_POST["tl_id"])>0){
				$hora_inicio = $hora_inicio_;
				for($t=0;$t<count($_POST["tl_id"]);$t++){
					if($t!=0)
						$hora_inicio = date("H:i:s",strtotime("+10 minutes",strtotime($hora_inicio)));
					$hora_fin = date("H:i:s",strtotime("+10 minutes",strtotime($hora_inicio)));	
					
					$ordenTL = ($t+1);
					$sqlTL = "UPDATE trabajos_libres SET ID_casillero='$casillero_', orden='$ordenTL', Hora_inicio='$hora_inicio', Hora_fin='$hora_fin' WHERE ID='".$_POST["tl_id"][$t]."';";
					mysql_query($sqlTL,$con);
				}
				
			}
		}

		if($agruparSalas!=0){
			$seExpande = 0;
		}

	}
}

$casillero->reasignarActividades($casillero_);
/*Modificaciones*/
$sqlM = "INSERT INTO modificaciones (Tiempo,Cambio, Usuario) VALUES ";

if($para_atras==2){
	$sqlM .= "('" . date("d/m/Y  H:i")  . "','Se modifico el casillero del día $dia_ en la sala $sala_ de $hora_inicio_ a $hora_fin_ ' , '" .  $_SESSION["usuario"] . "');";
}else{
	$sqlM .= "('" . date("d/m/Y  H:i")  . "','Se creo el casillero para el día $dia_ en la sala $sala_ de $hora_inicio_ a $hora_fin_', '". $_SESSION["usuario"] . "');";

}
mysql_query($sqlM, $con);
//




/*una ves ingresado redirecciono*/
if ($ingresar==true){

	echo "<script>\n";

	if($para_atras==2){
		echo "window.history.go(-3)\n";
	}else{
		echo "document.location.href='cronograma.php?dia_=$dia_orden_';\n";
	}
	echo "</script>";

}


/*si falla*/
function casillero_fallo($hora,$dia,$atras){

	echo "<script>\n";
	echo "alert('No se han podido ingresar los datos porque ya existe una hora de inicio $hora para el dia $dia en una o varias salas seleccionadas')\n";

	if($atras==2){
		echo "window.history.go(-2)\n";
	}else{
	 	echo "window.history.go(-1)\n";
	}

	echo "</script>\n";
}

?>