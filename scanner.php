<?php
include_once('config/config.php');
include_once('include/admin.class.php');
if($aid > 0){
    $adm = new adm();
    $sm = new kl_smarty();
    $sm->assign('adm', $adm);    
    $sm->assign('aid', $aid);
    $sm -> display('scanner.html');
}else{
    header('Location: index.php');
}
?>