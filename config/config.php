<?php
session_start();
extract($_GET);
extract($_POST);

include_once('smarty3/Smarty.class.php');

class kl_smarty extends Smarty {
	function __construct() {
		parent::__construct();
		$web_path = '/var/www/html/covid-qr/';
		$this->left_delimiter = '<!--{';
		$this->right_delimiter='}-->';
		$this->template_dir = $web_path . 'templates/';
		$this->compile_dir = '/tmp/';
		$this->config_dir = $web_path . 'config/';
		$this->cache_dir = '/dev/shm/';
		$this->autoload_filters = array('output' => array('trimwhitespace'));
	}
}
//variables

?>