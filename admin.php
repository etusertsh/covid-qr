<?php
include_once('config/config.php');
include_once('include/admin.class.php');

if(!$_SESSION['adminrole'] > 0){
    header('Location: index.php');
    exit;
}


$adm = new adm();

if($action=='toadduser' && $_SESSION['adminrole']=='2'){
    if(is_array($_POST)){
        if($adm->addUser($_POST)){
            header('Location: ?work=userlist');
            exit;
        }
        $work='userlist';
    }else{
        header('Location: index.php');
        exit;
    }
}
if($action=='restore' && $uid > 0 && $_SESSION['adminrole']=='2'){
    if($adm->setUserStatus('1', $uid)){
        $work='userlist';
    }else{
        //header('Location: index.php');
        //exit;
    }
}
if($action=='disable' && $uid > 0 && $_SESSION['adminrole']=='2'){
    if($adm->setUserStatus('0', $uid)){
        $work='userlist';
    }else{
        header('Location: index.php');
        exit;
    }
}
if($action=='toedituser' && $_SESSION['adminrole'] > 0 && $uid > 0){
    if($_SESSION['adminrole'] == '1'){
        $_POST['newprivilege'] = '1';
        if($uid != $_SESSION['adminid']){
            header('Location: index.php');
            exit;
        }
    }
    if($adm->changeUserData($_POST, $uid)){
        if($_SESSION['adminrole']=='2'){
            header('Location: ?work=userlist');
            exit;
        }else{
            header('Location: ?work=edituser&uid=' . $_SESSION['adminid']);
            exit;
        }
    }else{
        header('Location: index.php');
        exit;
    }

}
if($action=='toaddactivity1' && $_SESSION['adminrole']>0){

    if($adm->addActivity($_POST, $_POST['ActivityType'])){
        header('Location: ?work=activitylist');
        exit;
    }else{
        header('Location: index.php');
        exit;
    }
    
}
if($action=='restoreact' && $aid > 0 && $_SESSION['adminrole']>0){
    if($adm->setActivityOpen('1', $aid)){
        $work='activitylist';
    }else{
        //header('Location: index.php');
        //exit;
    }
}
if($action=='disableact' && $aid > 0 && $_SESSION['adminrole']>0){
    if($adm->setActivityOpen('0', $aid)){
        $work='activitylist';
    }else{
        header('Location: index.php');
        exit;
    }
}
if($action=='toeditactivity' && $aid>0 && $_SESSION['adminrole']>0){
    if($adm->changActivity($_POST, $aid)){
        header('Location: ?work=activitylist');
        exit;
    }else{
        header('Location: index.php');
        exit;
    }
}
//print_r($_SERVER);
$sm = new kl_smarty();
$sm->assign('adm', $adm);
$sm->assign('work', $work);
$sm->assign('uid', $uid);
$sm->assign('acttype', $acttype);
$sm->assign('aid', $aid);
$sm -> display('admin.html');
?>