<?
header("Content-Disposition: attachment; filename=Inscriptos.xls");
include('inc/sesion.inc.php');
include "conexion.php";
//require "clases/inscripciones.php";

$inscripcion = new inscripciones;


$lista = $inscripcion->listadoparaExcel();
/* encabezados*/
echo '<table width="100%" height="39" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">';

echo '<tr  bgcolor="#CCCCCC">
<td>ID&nbsp;&nbsp;</td>
<td>Código</td>
<td>Fecha de Inscripción</td>
<td>Apellidos</td>
<td>Nombres</td>
<td>Dirección</td>
<td>Ciudad</td>
<td>Código Postal</td>
<td>País</td>
<td>E-Mail</td>
<td>E-Mail Alternativo</td>
<td>Teléfono</td>
<td>Escolaridad</td>
<td>Miembro Sip</td>
<td>No. Miembro</td>
<td>Especialidad</td>
<td>Otros / Especifique</td>
<td>Forma de Pago</td>
<td>Categoria</td>
<td>Tipo de Tarjeta</td>
<td>Nombre</td>
<td>Nombre del titular de la tarjeta</td>
<td>Código de tarjeta</td>
<td>CVV2</td>
<td>Número de la tarjeta</td>
<td>Monto a Pagar</td>
<td>Fecha de Expiracion</td>
<td>Nombre Completo</td>
<td>Número de Boleta de Deposito</td>
<td>Nombre del Banco</td>
<td>Fecha de realización del pago</td>
<td>No. de Transferencia</td>
<td>Nombre Completo</td>
<td>Nombre del Banco</td>
<td>Fecha de Realización del pago</td>
<td>Estatus de Pagado</td>
<td>Observaciones</td>

</tr>';

while ($row = mysql_fetch_object($lista)){
	$pretel="";
	if($row->codTel){
	$pretel="(".$row->codTel.") ";
	}
echo "<tr>
<td>".$row->id."&nbsp;</td>
<td>".$row->codigo."&nbsp;</td>
<td>".$row->fecha."&nbsp;</td>
<td>".$row->apellido."&nbsp;</td>
<td>".$row->nombre."&nbsp;</td>
<td>".$row->direccion."&nbsp;</td>
<td>".$row->ciudad."&nbsp;</td>
<td>".$row->codigoPostal."&nbsp;</td>
<td>".$row->pais."&nbsp;</td>
<td>".$row->mail."&nbsp;</td>
<td>".$row->mailAlternativo."&nbsp;</td>
<td>".$pretel   .$row->tel."&nbsp;</td>
<td>".$row->modoCargo."&nbsp;</td>
<td>".$row->miembro."&nbsp;</td>
<td>".$row->numSocio."&nbsp;</td>
<td>".$row->modoArea."&nbsp;</td>
<td>".$row->otro."&nbsp;</td>
<td>".$row->formaPago."&nbsp;</td>
<td>".$row->categoria."&nbsp;</td>
<td>".$row->nombreTarjeta."&nbsp;</td>
<td>".$row->nombreCompletoTarjeta."&nbsp;</td>
<td>".$row->nombreTitular."&nbsp;</td>
<td>".$row->numeroTarjeta."&nbsp;</td>
<td>".$row->codigoTarjeta."&nbsp;</td>
<td>".$row->numeroTarjeta."&nbsp;</td>
<td>".$row->valorTotal."&nbsp;</td>
<td>".$row->fechaExpiracion."&nbsp;</td>
<td>".$row->nombreCompletoDeposito."&nbsp;</td>
<td>".$row->numeroDeposito."&nbsp;</td>
<td>".$row->codigoPostalTarjeta."&nbsp;</td>
<td>".$row->fechaDeposito."&nbsp;</td>
<td>".$row->numeroTransferencia."&nbsp;</td>
<td>".$row->nombreCompletoTransferencia."&nbsp;</td>
<td>".$row->nombreBanco."&nbsp;</td>
<td>".$row->fechaTransferencia."&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>";
}
echo "</table>";
mysql_free_result($lista);
?>
<? mysql_close() ?>