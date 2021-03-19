<?php
include_once('config/config.php');
include_once('include/admin.class.php');
$adm = new adm();
if($qrcontent == ''){
    echo 'error,QR Code 掃描內容錯誤';
}else{
    if($adm->scanResult($qrcontent)){
        $tmp = explode('-', $qrcontent);
        $aid=$tmp[1];
        $uid=$tmp[3];
        $v=$adm->getVisitorFromUuid($aid, $uid);
        echo 'ok,' . $v['realname'] . ' ' . substr($v['tel'], 0, -4) . '****';
    }else{
        echo 'error,QR Code 掃描內容錯誤';
    }
}
?>