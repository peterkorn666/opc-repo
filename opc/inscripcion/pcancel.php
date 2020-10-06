<?php
//require_once('config.php');
/*
 * PayPal IPN IPs (it can change in future)
 * https://ppmts.custhelp.com/app/answers/detail/a_id/92
 * search: notify.paypal.com (IPN delivery) 
*/
/*if(!in_array($_SERVER['REMOTE_ADDR'], array('173.0.81.1','173.0.81.33','66.211.170.66')))
{
	echo 'wrong IP';
	exit;
}*/
session_start();
if($_REQUEST["custom"]=="")
{
	header("Location: index.php");
	die();
}
$data["request"] = $_REQUEST;
require("conexion.php");
$sql  = $db->prepare("INSERT INTO paypal_ipn (id_inscripto,data) VALUES (?,?)");
$sql->bindValue(1,base64_decode($_REQUEST["custom"]));
$sql->bindValue(2,json_encode($data));
$sql->execute();


$receiverMail = $_REQUEST['receiver_email']; // ots admin mail
$status = $_REQUEST['payment_status']; // payment status, we add only when is 'Completed'
$currency = $_REQUEST['mc_currency']; // money currency, like USD or EUR
$gross = $_REQUEST['mc_gross']; // amount of money, like: 10.00
$payerMail = $_REQUEST['payer_email']; // player mail
$accountID = $_REQUEST['custom']; // user account ID
$transactionID = $_REQUEST['txn_id']; // transaction ID

$sql = $db->prepare("UPDATE inscriptos SET paypal_status=? WHERE id=?");
$sql->bindValue(1,$status);
$sql->bindValue(2,base64_decode($_REQUEST["custom"]));
$sql->execute();
?>