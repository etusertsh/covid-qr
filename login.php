<?php
include_once('config/config.php');
include_once('include/admin.class.php');

if($_SESSION['adminrole'] > 0){
    header('Location: admin.php');
    exit;
}
$adm = new adm();
//action
if($action == 'signup'){
    if($_POST['a'] !='' && $_POST['b'] != ''){
        if($adm->login($_POST['a'], $_POST['b'])){
            header('location: admin.php');
            exit;
        }else{
            header('location: index.php');
            exit;
        }
    }else{
        header('Location: index.php');
        exit;
    }
}
$adm->_db->close();
$sm = new kl_smarty();
$sm -> display('login.html');
?>