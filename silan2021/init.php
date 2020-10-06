<?php
/**
 * Created by PhpStorm.
 * User: Hansz
 * Date: 20/6/2016
 * Time: 0:13
 */
$GLOBALS['config'] = array(
    "config"=>array("name" => "SILAN 2020"),
	"debug" => true,
    "mysql" => array(
        "host" => "mysql.gegamultimedios.net", //127.0.0.1
        "user" => "silan2020", //root
        "password" => "Kdw3w3#w2", //password
        "db" => "silan2020",
        "port" => "3306", //3306
    ),
    "remember" => array(
        "expiry" => 604800,
    ),
    "session" => array (
        "token_name" => "token_sm",
        "cookie_name"=>"cookie_sm",
        "session_name"=>"session_sm"
    ),
);

if($_SERVER["SERVER_NAME"] == "localhost" || $_SERVER["SERVER_NAME"] == "ctpu.loc"){
	$GLOBALS['config'] = array(
		"debug" => true,
		"mysql" => array(
			"host" => "127.0.0.1", //127.0.0.1
			"user" => "root", //root
			"password" => "", //password
			"db" => "silan2020",
			"port" => "3306", //3306
		)
	);
}

@session_start();

spl_autoload_register(function($class){
    require 'class/'.$class.'.class.php';
});