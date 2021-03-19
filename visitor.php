<?php
include_once('config/config.php');
include_once('include/admin.class.php');
if($aid>0){
$adm = new adm();
if($uuid == ''){
    $uuid = uniqid();
}
$url = 'http://' . $_SERVER['HTTP_HOST'] ."/covid-qr/visitor.php?aid=$aid&act=registor";

if($action=='signup'){    
    if(strtolower($_POST['randomCode']) == $_SESSION['CAPTCHA_CODE'] && $_POST['aid'] > 0){
        if($past = $adm->getVisitorUuidFromAidTelName($aid, $usertel, $username)){
            $uuid = $past['uniqid'];            
        }else{
            $adm->addVisitor($aid, $_POST);
            $uuid = $_POST['uuid'];            
        }
        header("Location: ?aid=$aid&uuid=$uuid&act=done");
        exit;
    }else{
        header("Location: ?aid=$aid&act=error");
        exit;
    }
}

$sm = new kl_smarty();
$sm->assign('adm', $adm);
$sm->assign('uuid', $uuid);
$sm->assign('aid', $aid);
$sm->assign('act', $act);
$sm->assign('url', $url);
$sm->assign('encodeurl', urlencode($url));
$sm -> display('visitor.html');
}else{
    header('Location: index.php');
    exit;
}
?>