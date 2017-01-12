<?php 
/*
 *后台导航文件
 *author 王建 
 */
if (! defined('BASEPATH')) {
    exit('Access Denied');
}
class Nav extends MY_Controller {
	private $name = '';
	private $url = '';
	private $pid = '';
	private $disorder = '';
	private $status = '' ;
	private $id = '' ;
	private $url_type = '';
	private $collapsed = 0 ; 
	public $nav_color = array(
		0=>'black' ,
		1=>'#3E4452' ,
		2=>'green' , 
		3=>"red" , 		
		4=>'#056DAE',
			
	) ;
	public  $_status_array = array(
		'0'=>'<font color="red">关闭</font>'	,
		'1'=>'<font color="green">开启</font>'
	) ; 
	function Nav(){
		parent::__construct();
		$this->load->model('M_common');
		$this->load->model('M_nav');
		
	}
	//导航列表
	function index(){
		$result =$this->M_nav->queryNav("items" , " AND status in (0,1)" );
		$result = $this->M_nav->getTreeData($result) ;
		/* echo "<pre>";
		print_r($result);  */
		$data = array(
			'list'=>$result
		);
		$this->load->view(__TEMPLET_FOLDER__."/views_nav_list",$data);
	}
	
	
	//function add
	function add(){		
		$action = $this->input->get_post("action");		
		$action_array = array("add","doadd");
		$action = !in_array($action,$action_array)?'show':$action ;	
		if($action == 'show'){		
			$id = intval($this->input->get_post("id"));	
			$result = $this->M_nav->queryNav("childs");
			$options =  getChildren($result);	
			$data['options'] = $options ;
			$data['pid'] = $id ;
			$this->load->view(__TEMPLET_FOLDER__."/views_nav_add",$data);
			
		}elseif($action == 'doadd'){
			$this->doadd();
		}
	}

	//处理添加数据
	private function doadd(){	
		$this->set_field();
		$data = array(
			'pid'=>$this->pid,
			'name'=>$this->name,
			'status'=>$this->status,
			'addtime'=>date("Y-m-d H:i:s",time()),
			'url'=>$this->url,
			'disorder'=>$this->disorder,
		);
		$status = $this->M_nav->insert_nav($data);
		$url = site_url("nav/index") ;
		if($status){
			echo "<script>parent.window.location.href='{$url}';</script>";
		}else{
			exit("服务器繁忙请稍后");
		}
	}
	//编辑导航页面
	public function edit(){
		/* $is_super_admin = is_super_admin();
		if(!$is_super_admin){
			showmessage("对不起你没权限进行修改菜单,请联系管理员","nav/index",3,0);
			die();
		} */
		$action = $this->input->get_post("action");
		$action_array = array("edit","doedit");
		$action = !in_array($action,$action_array)?'edit':$action ;
		if($action == 'edit'){
			$id = verify_id($this->input->get_post("id")); //pid
			$info = $this->M_common->query_one("SELECT * FROM {$this->table_}common_admin_nav WHERE id = '{$id}'");
			if(empty($info)){
				exit("参数错误") ;
			}	
			$result = $this->M_nav->queryNav("childs" , " AND status in (0,1)" );
			$options =  getChildren($result);
			$data = array(
				'info'=>$info,
				'options'=>$options,
			);
			$this->load->view(__TEMPLET_FOLDER__."/views_nav_edit",$data);
		}elseif($action == 'doedit'){
			$this->doedit();
		}
	}
	//处理编辑
	private function doedit(){	
		$this->set_field();	
		$data = array(
				'pid'=>$this->pid,	
				'name'=>$this->name,
				'url'=>$this->url,
				'disorder'=>$this->disorder,
				'status'=>$this->status,
				'id'=>$this->id	
		) ;
		$status = $this->M_nav->edit_nav($data);
		$url = site_url("nav/index") ;
		if($status){
			echo "<script>parent.window.location.href='{$url}';</script>";
		}else{
			exit("服务器繁忙请稍后");
		}
	}
	private function set_field(){
		$this->pid = verify_id($this->input->get_post("pid")); //pid
		$this->id = verify_id($this->input->get_post("id")); //id
		$this->name = dowith_sql(daddslashes(html_escape(strip_tags($this->input->get_post("name")))));//name
		$this->url = daddslashes(html_escape(strip_tags($this->input->get_post("url"))));//url地址
		$this->disorder = verify_id($this->input->get_post("disorder")); //排序
		$this->status = verify_id($this->input->get_post("status")); //状态	
		$this->url_type = verify_id($this->input->get_post("url_type")); //url类型	
		$this->collapsed = verify_id($this->input->get_post("collapsed")); //是否收缩
	}
	//导航删除
	function del(){
		$id = verify_id($this->input->get_post("id"));
		$status = $this->M_nav->delNav($id);
		if($status){
			echo result_to_towf_new(null, 1, "删除 成功", null);
			exit();
		}else{
			echo result_to_towf_new(null, 0, "删除 失败， 服务器繁忙", null);
			exit();
		}
	}
}




