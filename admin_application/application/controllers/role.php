<?php
/*
 *角色配置
 *author  王建 
 */
if (! defined('BASEPATH')) {
    exit('Access Denied');
}
class Role extends MY_Controller{
	private $perm_data = array(); //角色权限数组
	public $nav_color = array(
			0=>'black' ,
			1=>'#3E4452' ,
			2=>'green' ,
			3=>"red" ,
			4=>'#056DAE',
	) ;
	function Role(){
		parent::__construct();
		$this->load->model('M_common');
		$this->load->model('M_role');
		
	}
	function index(){
		$action = $this->input->get_post("action");	
		$action_array = array("show","ajax_data","preview_user");
		$action = !in_array($action,$action_array)?'show':$action ;
		if($action == 'show'){
			$this->load->view(__TEMPLET_FOLDER__."/views_role");
		}elseif($action == 'ajax_data'){
			$this->ajax_data();
		}elseif($action == "preview_user"){
			$this->preview_user();
		}
		
		
	}
	private function ajax_data(){
		$page = intval($this->input->get_post("page" , true ));
		$list = $this->M_role->queryRoleList($page ,10 );
		//print_r($list);
		
		echo result_to_towf_new($list['list'], 1, '成功', $list['page_sting']) ;
	}
	//编辑页面
	function edit(){
		$action = $this->input->get_post("action");		
		$action_array = array("edit","doedit");
		$action = !in_array($action,$action_array)?'edit':$action ;		
		if($action == 'edit'){
			$id = verify_id($this->input->get_post("id"));
			$info  = $this->M_role->queryRoleById($id);
			/* print_r(unserialize($info['perm']));
			echo "<hr>"; */
			if(empty($info)){
				showmessage("暂无数据","role/index",3,0);
				exit();
			}
			$this->load->model('M_nav');
			$result =$this->M_nav->queryNav("items" , " AND status in (1)" );
			
			$data = array(
				'list'=>$result,
				'info'=>$info
			);
			$this->load->view(__TEMPLET_FOLDER__."/views_role_edit",$data);		
		}elseif($action == 'doedit'){
			$this->doedit();
		}

	}
	
	//处理编辑数据
	private function doedit(){
		$id = verify_id($this->input->get_post("id" , true ));
		$status = verify_id($this->input->get_post("status" , true ));
		$role_array = $this->input->get_post("role" , true );
		$rolename = $this->input->get_post("rolename" , true );
		$data = array(
			'id'=>$id , 
			'status'=>$status , 
			'rolename'=>$rolename,
			'role_array'=>$role_array		
		) ;
		$statusArray = $this->M_role->updateRole($data) ; 
		if($statusArray['status']){
			showmessage("修改成功","role/index",3,1);
			exit();
		}
		showmessage($statusArray['message'],"role/index",3,0 , "?id={$id}");
		exit();
	}
	
	///角色增加
	 function add(){
		$action = $this->input->get_post("action");		
		$action_array = array("add","doadd");
		$action = !in_array($action,$action_array)?'show':$action ;	
		if($action == 'show'){			
			$this->load->view(__TEMPLET_FOLDER__."/views_role_add");		
		}elseif($action == 'doadd'){
			$this->doadd();
		}
	}
	//处理增加
	private function doadd(){
		$rolename =$this->input->get_post("rolename" , true );//rolename
		$status = verify_id($this->input->get_post("status" , true )); //状态	
		if(empty($rolename)){
			show_error("角色名称不能为空",'500','信息提示');
			exit();
		}
		
		$data = array(
			'rolename'=>$rolename,
			'status'=>$status,
			'addtime'=>date("Y-m-d H:i:s",time())
		);
		$data = $this->M_role->addRole($data);
		$url = site_url("role/index") ;
		if($data['status']){
			echo "<script>parent.window.location.href='{$url}';</script>";
		}else{
			show_error($data['message'],'500','信息提示');
			exit ;
		}
		
	}
	

	
	//预览所在用户组的用户
	private function preview_user(){
		$id = verify_id($this->input->get_post("id"));
		if($id<=0){
			echo "参数传递错误"; 
			exit();
		}
		$list = $this->M_common->querylist("SELECT id,username,status FROM {$this->table_}common_system_user where gid = '{$id}' ");
		if($list){
			foreach($list as $k=>$v){
				$status = ($v['status'] == 1 )?"<font color='green'>正常</font>":'<font color="red" >禁止</font>' ;
				echo "<li style=\"text-decoration:none; display:block ; width:100px; height:30px; padding:2px; float:left; border:solid 1px #F0F0F0 ;  text-align:center;line-height:30px; margin-left:3px\">";
				echo $v['username']."【".$status."】";
				echo "</li>";
			}
		}else{
			echo "暂无用户";
		}
	}
}