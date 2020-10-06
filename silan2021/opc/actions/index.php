<?php
/**
 * User: Hansz
 * Date: 1/4/2016
 * Time: 16:20
 */
session_start();
require("../class/easyCRUD.class.php");
require("../class/cruds.php");
require("../class/core.php");
$core = new Core();
$config = $core->getConfig();
try{
	include($_GET['page'].'.php');
}catch(Exception $e){
	header('../');
}