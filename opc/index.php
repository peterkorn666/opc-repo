<?php
	error_reporting(E_ALL ^ E_NOTICE);
	session_start();
	require_once "class/class.template.php";
	require_once("class/core.php");
	require_once("class/Db.class.php");
	require_once("class/templates.opc.php");
	require("class/util.class.php");
	$util = new Util;
	$core = new core();
	$templates = new templateOPC();
	$config = $core->getConfig();
	// Instantiate the Template class
	$tpl = new AbsTemplate('pages','cache');
	
	//util class
	$tpl->SetVar('util',$util);
	
	//Set mode debug
	$tpl->SetVar('debug',true);
	
	//get all config opc
	$tpl->SetVar('config',$config);
	
	// Set a variable to hold this pages's title
	$tpl->SetVar('page_title', $config["nombre_congreso"]);	
	
	// Set a variable to hold the template's heading
	$tpl->SetVar('title','Programa Extendido');
	
	$tpl->SetVar('core', $core);
	$tpl->SetVar('templates', $templates);
	
	
	
	// Assign the template's content to a variable
	if(!isset($_GET["page"]) && !isset($_GET["filtro_palabra_clave"])){
		if($_SESSION["usuario"])
			$_GET["page"] = "cronograma";
			//$_GET["page"] = "programaExtendido";
		else
			$_GET["page"] = "cronograma";
			//$_GET["page"] = "programaExtendido";
	}
	else if(isset($_GET["filtro_palabra_clave"]))
		$_GET["page"] = "buscarTL";
		
	$tpl->SetVar('current_page', $_GET["page"]);
		
	try
	{
		$data = $tpl->GetPage($_GET["page"],"nocache");
	}catch(Exception $e)
	{
		echo $e->getMessage();
		die();
	}
	if($_GET["p"]=="")
		require("templates/normal.php");
	else
		require("templates/popup.php");
