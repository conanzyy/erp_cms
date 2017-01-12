<?php
class Index extends UsersCommon{
	function __construct(){
		parent::__construct(); //这个地方必须写主要是继承父类的所有方法
	}
	//用户中心
	function index(){
		$this->load->view('users/views_center.php');
	}
}