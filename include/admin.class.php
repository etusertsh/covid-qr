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
}