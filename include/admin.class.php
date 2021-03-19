<?php
include_once('db.class.php');
class adm {
	public $_db;
	
	function adm(){
		$this->_db = new db();
	}
	function login($name, $pw){
		return $this->_db->login($name, $pw);
	}
	function getAllUsers(){
		$sql = "Select * From user Order By privilege desc, id";
		$res = $this->_db->query($sql, 'id');
		return $res;
	}	
	function getUserFromStatus($stat){
		if(inarray($stat, array('0','1'))){
			$sql = "Select * From user Where status='$stat' Order By privilege desc, id";
			$res=$this->_db->query($sql,'id');
			return $res;
		}else{
			return false;
		}
	}
	function getUserFromId($id){
		if($id>0){
			$sql = "Select * From user Where id='$id' Limit 1";
			$res=$this->_db->query($sql);
			return $res[0];
		}else{
			return false;
		}
	}
	function addUser($param){
		if(is_array($param)){
			$sql = "Insert Into user (name, pw, realname, office, email, tel, privilege) Values ('" . $param['newname'] . "', MD5('" . $param['newpassword'] . "'), '" . $param['newrealname'] . "', '" . $param['newoffice'] . "', '" . $param['newemail'] . "', '" . $param['newtel'] . "', '" . $param['newprivilege'] . "')";
			//echo $sql;
			return $this->_db->query2($sql);
		}else{
			return false;
		}
	}
	function setUserStatus($stat, $uid){
		$sql = "Update user Set status='$stat' Where id='$uid' Limit 1";
		//echo $sql;
		return $this->_db->query2($sql);
	}
	function changeUserData($param, $uid){
		if($uid>0){
			if($param['pwdcheck'] == '1' && $param['newpassword'] != ''){
				$sql = "Update user Set pw=MD5('" . $param['newpassword'] . "') Where id='$uid' Limit 1";
				$this->_db->query2($sql);
			}
			$sql = "Update user Set realname='" . $param['newrealname'] . "', office='" . $param['newoffice'] . "', email='" . $param['newemail'] . "', tel='" . $param['newtel'] . "', privilege='" . $param['newprivilege'] . "' Where id='$uid' Limit 1";
			return $this->_db->query2($sql);
			//print_r($param);
			//exit;
		}else{
			return false;
		}
	}
	function addActivity($param, $type){
		print_r($param);
		switch($type){
			case '1':
				$sql = "Insert Into activity (name, type, qrduration, creator, openflag, ps) Values ('" . $param['ActivityName'] . "', '1', '" . $param['QrDuration'] . "','" . $_SESSION['adminid'] . "','" . $param['ActivityOpen'] . "','" . $param['ActivityPs'] . "')";				
				return $this->_db->query2($sql);
				break;
			case '2':
				$sql = "Insert Into activity (name, type, closedate, creator, openflag, ps) Values ('" . $param['ActivityName'] . "', '2', '" . $param['ActivityClose'] . "','" . $_SESSION['adminid'] . "','" . $param['ActivityOpen'] . "','" . $param['ActivityPs'] . "')";				
				return $this->_db->query2($sql);
				break;
			default: 
				return false;
		}

	}
	function getAllActivity(){
		$sql = "Select A.*, B.name As username From activity As A Inner Join user As B On A.creator=B.id Order By A.openflag desc, A.type desc, A.closedate desc";		
		$res = $this->_db->query($sql, 'id');
		return $res;
	}
	function getActivityNameFromId($id){
		if($id>0){
			$sql = "Select A.name, A.ps, B.office, B.tel, B.email From activity As A Inner Join user As B On A.creator=B.id Where A.id='$id' Limit 1";
			$res = $this->_db->query($sql);
			//print_r($res[0]);
			return $res[0];
		}else{
			return false;
		}
	}
	function getActivityFromAdminid($uid){
		$sql = "Select * From activity Where creator='$uid' Order By openflag desc, type desc, closedate desc";
		$res = $this->_db->query($sql, 'id');
		return $res;
	}
	function getOpenActivityFromType($type){
		if($type>0){
			$sql = "Select * From activity Where type='$type' And openflag='1' Order By id Desc";
			//echo $sql;
			$res = $this->_db->query($sql, 'id');
			//print_r($res);
			return $res;
		}else{
			return false;
		}
	}
	function setActivityOpen($flag, $aid){
		$sql = "Update activity Set openflag='$flag' Where id='$aid' Limit 1";
		return $this->_db->query2($sql);
	}
	function getActivityFromId($aid){
		if($aid > 0){
			$sql = "Select * From activity Where id='$aid' Limit 1";
			$res = $this->_db->query($sql);
			if($_SESSION['adminrole'] == '2' || ($_SESSION['adminrole']=='1' && $res[0]['creator']==$_SESSION['adminid'])){
				return $res[0];
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	function getActivityLimitFromId($aid){
		if($aid > 0){
			$sql = "Select id, name, type, closedate, qrduration From activity Where id='$aid' Limit 1";
			$res = $this->_db->query($sql);
			return $res[0];			
		}else{
			return false;
		}
	}
	function changActivity($param, $aid){
		if($aid>0){
			$sql="Update activity Set name='" . $param['ActivityName'] . "',closedate=" . ($param['ActivityClose']=='' ? 'NULL' : "'" . $param['ActivityClose'] . "'") . ", qrduration='" . ($param['QrDuration']=='' ? '1' : $param['QrDuration']) . "', ps='" . $param['ActivityPs'] . "' Where id='$aid' Limit 1";
			//echo $sql;
			//exit;
			return $this->_db->query2($sql);
		}else{
			return false;
		}
	}
	function addVisitor($aid, $param){
		if($aid>0){
			$act = $this->getActivityLimitFromId($aid);
			//print_r($act);
			$type = $act['type'];
			$closedate = $act['closedate'];
			$qrduration = $act['qrduration'];
			if($type == '1'){
				$qrclose = date('Y-m-d', strtotime("+$qrduration day"));
				$sql = "Insert Into vistor (aid, realname, tel, email, uniqid, expiredate, num) Values ('" . $param['aid'] . "', '" . $param['username'] . "', '" . $param['usertel'] . "', '" . $param['useremail'] . "', '" . $param['uuid'] . "','" . $qrclose . "', '" . $param['usernum'] . "')";
				return $this->_db->query2($sql);
				//echo $sql;
			}else{
				$sql = "Insert Into vistor (aid, realname, tel, email, uniqid, expiredate, num) Values ('" . $param['aid'] . "', '" . $param['username'] . "', '" . $param['usertel'] . "', '" . $param['useremail'] . "', '" . $param['uuid'] . "','" . $closedate . "', '" . $param['usernum'] . "')";
				return $this->_db->query2($sql);
				//echo $sql;
			}
		}else{
			return false;
		}
	}
	function getVisitorUuidFromAidTelName($aid, $tel, $name){
		if($aid > 0 && $tel != '' && $name != ''){
			$sql = "Select id, uniqid From vistor Where aid='$aid' And tel='$tel' And realname='$name' Limit 1";
			echo $sql;
			$res = $this->_db->query($sql);
			return $res[0];
		}else{
			return false;
		}
	}
	function getVisitorFromUuid($aid, $uuid){
		if($aid>0 && $uuid != ''){
			$sql = "Select * from vistor Where aid='$aid' And uniqid='$uuid' Limit 1";
			$res = $this->_db->query($sql);
			//echo $sql;
			//print_r($res[0]);
			return $res[0];
		}else{
			return false;
		}
	}
	function scanResult($str){		
		$tmp = explode('-', $str);
		$aid = $tmp[1];
		$uid = $tmp[2];
		$uuid = $tmp[3];
		$sql = "Insert Into scanrecord (aid, fullcode, uniqid) Values ('$aid', '$str', '$uuid')";
		
		$this->_db->query2($sql);
		$act = $this->getActivityLimitFromId($aid);
		if($act['type']=='1'){
			$deadtime = date('Y-m-d', strtotime('+28 day'));
		}else{
			$deadtime = date('Y-m-d', strtotime($act['closedate'] . ' +28 day'));
		}
		$sql = "Update vistor Set deadtime='$deadtime' Where id='$uid' And uniqid='$uuid' Limit 1";
		//echo $sql;
		$this->_db->query2($sql);
		return true;
	}
}