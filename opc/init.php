<?php
/**
 * Created by PhpStorm.
 * User: Hansz
 * Date: 20/6/2016
 * Time: 0:13
 */
$GLOBALS['config'] = array(
    "name"=> "FEPAL 2020",
	"debug" => false,
    "mysql" => array(
        "host" => "mysql.gegamultimedios.net", //127.0.0.1
        "user" => "fepal2020", //root
        "password" => "smMxJS1G00YNOL", //password
        "db" => "bd_fepal2020",
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
if($_SERVER["SERVER_NAME"] == "localhost"){
	$GLOBALS['config'] = array(
		"name"=> "FEPAL 2020",
		"debug" => true,
		"mysql" => array(
			"host" => "127.0.0.1", //127.0.0.1
			"user" => "root", //root
			"password" => "", //password
			//"db" => "bd_alas2017",
			"db" => "bd_fepal2020",
			"port" => "3306", //3306
		)
	);
}

//session_start();

spl_autoload_register(function($class){
	require 'class/'.$class.'.class.php';
});