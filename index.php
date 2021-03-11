<?php
include_once('config/config.php');
include_once('include/admin.class.php');

$adm = new adm();
//echo uniqid();
$sm = new kl_smarty();
$sm->assign('adm', $adm);
//$sm->assign('mtype', $mtype);
//$sm->assign('micon', $micon);
//$sm->assign('semesteryear', $semesteryear);
$sm -> display('index.html');
?>