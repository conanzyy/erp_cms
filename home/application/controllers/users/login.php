<?php
/*用户登录模块*/
class login extends  HomeCommon{
	public function __construct(){
		parent::__construct() ; 
		$this->load->model('M_common');
		$this->load->model('M_user');
	}
	
	public function index(){
		if($this->is_login){
			redirect(site_url("users/index")) ; 
		}
		$this->load->view('users/views_login.php');
	}
	//处理登录
	public function dologin(){
		if($this->is_login){
			redirect(site_url("users/index")) ;
		}
		$username = trim($this->input->post("username" , true ));
		$passwd = trim($this->input->post("passwd" , true ));
		if(empty($username)){
			showmessage("用户名不可以为空"  , "users/login" , 3 , 0 ) ;
		}
		$postData = array(
				'username'=>$username ,
				'passwd'=>$passwd ,
		);
		$res = $this->M_user->userLogin($postData);
		if(!$res['status']){
			show_error($res['message'] , 500 , '登录提示');
		}
		redirect(site_url("users/index"));
	}
	//退出登录
	public function loginout(){
		//删除cookie
		if(isset($_COOKIE['web_user_auth']) && $_COOKIE['web_user_auth']){
			setcookie("web_user_auth" ,"" , time()-config_item("cookie_expire") , config_item("cookie_path") , config_item("cookie_domain") , config_item("cookie_secure"));
		}
		redirect(site_url("users/login"));
	}
}