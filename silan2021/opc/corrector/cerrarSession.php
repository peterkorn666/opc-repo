<?php
session_start();
unset($_SESSION['corrector']);

header("Location: login.php");
?>