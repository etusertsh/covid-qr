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
			$sql = "Update user Set realname='" . $param['newrealname'] . "', office='" . $param['newoffice'] . "', email='" . $param['newemail'] . "', tel='" . $param['newtel'] . "', privilege='" . $param['newprivilege'] . "' Where id='$uid' Limit 1";
			return $this->_db->query2($sql);
		}else{
			return false;
		}
	}
}