<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $tpl->GetVar('page_title')?></title>
<style type="text/css">
	body{
		background-color: white !important;
	}
</style>
<?php 
echo  $tpl->setHeaders($tpl->GetVar('headers'),"css");
echo $tpl->setHeaders($tpl->GetVar('headers'),"js");
?>

</head>

<body>
<?php
echo $data;
?>
</body>
</html>