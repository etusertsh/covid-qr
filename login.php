<?php
include_once('config/config.php');
include_once('include/admin.class.php');


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
if($action=='signout'){
    session_destroy();
    header('Location: index.php');
}
$adm->_db->close();

if($_SESSION['adminrole'] > 0){
    header('Location: admin.php');
    exit;
}
$sm = new kl_smarty();
$sm -> display('login.html');
?>