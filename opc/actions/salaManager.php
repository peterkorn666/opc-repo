<?php
/**
 * User: Hansz
 * Date: 1/4/2016
 * Time: 16:15
 */
$sala = new CM('salas','salaid');
$_POST['sala_visible'] = ($_POST['sala_visible']?$_POST['sala_visible']:"0");
if($_POST['key']){
	if($_POST['name']==""){
		header('Location: ../?page=salaManager&status=error');
		die();
	}
	$sala->name = $_POST['name'];
	$sala->orden = $_POST['orden'];
	$sala->visible = $_POST['sala_visible'];
	$sala->salaid = base64_decode($_POST['key']);
	if($sala->Save())
		header('Location: ../?page=salaManager&status=ok');
	else
		header('Location: ../?page=salaManager&status=error');
}else if($_GET['del']){
	$crono = new CM('cronograma','section_id');
	$crono->section_id = base64_decode($_GET['del']);
	$all = $crono->search();
	foreach($all as $c){
		$cronoConfs = new CM('crono_conferencistas','id_crono');
		$cronoConfs->id_crono = $c['id_crono'];
		$cronoConfs->Delete();
	}
	$sala->salaid = base64_decode($_GET['del']);
	$sala->Delete();
	$crono->section_id = base64_decode($_GET['del']);
	$crono->Delete();
	header('Location: ../?page=salaManager&status=dok');
}else if(empty($_POST['key']) && empty($_GET['del'])){
	if($_POST['name']==""){
		header('Location: ../?page=salaManager&status=error');
		die();
	}
	$sala->name = $_POST['name'];
	$sala->orden = $_POST['orden'];
	$sala->visible = $_POST['sala_visible'];
	if($sala->Create())
		header('Location: ../?page=salaManager&status=ok');
	else
		header('Location: ../?page=salaManager&status=error');
}