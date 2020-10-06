<?php
session_start();
if($_SESSION['cliente']['id_cliente'])
	header("Location: cuenta.php");
else
	header("Location: login.php");