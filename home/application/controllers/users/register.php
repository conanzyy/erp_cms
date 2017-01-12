<?php
/*用户注册模块*/
class register extends HomeCommon{
	public function __construct(){
		parent::__construct() ; 
		$this->load->model('M_common');
		$this->load->model('M_user');
	}
	function index(){
		$this->load->view('users/views_register.php');
	}
	//处理注册信息
	public function doregister(){
		$username = trim($this->input->post("username" , true ));
		$passwd = trim($this->input->post("passwd" , true ));
		$repasswd = trim($this->input->post("repasswd" , true ));
		if(empty($username)){
			showmessage("用户名不可以为空"  , "users/register" , 3 , 0 ) ; 
		}
		$postData = array(
			'username'=>$username , 
			'passwd'=>$passwd , 
			'repasswd'=>$repasswd		
		);
		$res = $this->M_user->addUser($postData);
		print_r($res);
	}
}