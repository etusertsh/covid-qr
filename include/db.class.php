<?php
class db {
	public $_dbconn;
	function db() {
		$this->_dbconn = new mysqli('localhost','qrcodeuser','qrcodepassword','covid-qr');
		if($this->_dbconn->connect_errno){
			echo $this->dbconn->connect_error;
		}
		$this->_dbconn->query('set names utf8');
		$this->_dbconn->set_charset("utf8");
	}
	function query($sql, $recindex = ''){
		$rec = array();
		$rs = $this->_dbconn->query($sql);
		if($rs->num_rows > 0){		
			while($temprs = $rs->fetch_assoc()){
				if($recindex == ''){
					$rec[] = $temprs;
				}else{
					$rec += array($temprs[$recindex] => $temprs);
				}
			}
			$rs->free();
			return $rec;
		}else{
			return false;
		}
		return false;
	}
	function login($name, $pw){
		$name = mysqli_real_escape_string($this->_dbconn,$name);
		$pw = mysqli_real_escape_string($this->_dbconn,$pw);
		$sql = "Select id, realname From user Where name='$name' And pw=MD5('$pw') Limit 1";
		echo $sql;
		$rs = $this->_dbconn->query($sql);
		if($rs->num_rows > 0){
			$temprs = $rs->fetch_assoc();
			$_SESSION['adminrole'] = $temprs['privilege'];
			$_SESSION['adminid'] = $temprs['id'];
			$_SESSION['adminname'] = $temprs['realname'];
			$rs->free();
			return true;
			exit;
		}else{
			return false;
			exit;
		}
		exit;
	}
	function query2($sql){
		$result = $this->_dbconn->query($sql);
		return $result;
	}
	function real_escape_string($sql){
		return $this->_dbconn->real_escape_string($sql);
	}
	function num_rows($sql){
		$rs = $this->_dbconn->query($sql);
		return $rs->num_rows;
	}
	function get_insert_id(){
		return $this->_dbconn->insert_id;
	}
	function close(){
		$this->_dbconn->close();
	}
}
?>