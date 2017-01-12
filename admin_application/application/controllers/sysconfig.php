<?php 
/*
 *系统基本信息配置
 *author 王建 
 */
if (! defined('BASEPATH')) {
    exit('Access Denied');
}
class Sysconfig extends MY_Controller {
	public $sysconfig_cache_path = '' ;
	private $group_ = array() ;
	private $type_ = array();
	function Sysconfig(){
		parent::__construct();
		echo config_item("cccc");
		$this->load->model('M_common');
		$this->load->model('M_sysconfig');
		$this->sysconfig_cache_path = config_item("sysconfig_cache");
		$this->group_ =config_item("web_group");
		$this->type_ = config_item("web_type");
	}

	function index(){
		
		$action_array = array(
			'config','add_config','get_data'
		);
		$action = $this->input->get_post("action");
		$action = (isset($action) && in_array($action,$action_array))?$action:'config';
		if($action == 'config'){
			$list_data = $this->M_sysconfig->query_sysconfig($this->group_);
			$gid = $this->input->get_post("gid" , true );
		
			$data = array(
				'group'=>$this->group_ ,
				'list'=>$list_data,
				'gid'=>$gid, 
				'type'=>$this->type_	
			);
			/* echo "<pre>";
			print_r($this->group_);  */
			//$this->make();
			$this->load->view(__TEMPLET_FOLDER__."/views_sysconfig",$data);			
		}elseif($action == 'get_data'){
			$gid = intval($this->input->get_post("id"));
			//添加系统变量
			$add_data = array(
					'gid'=>$gid,
					'group'=>$this->group_,
					'type'=>$this->type
			);
			$this->load->view(__TEMPLET_FOLDER__."/views_sysconfig_add",$add_data);			
		}
	}
	//function add
	function add(){		
		$gid =verify_id($this->input->get_post("gid" , true ));
		$varname = trim($this->input->get_post("varname" , true ));//varname
		$value = trim($this->input->get_post("value" , true));//value
		$info = trim($this->input->get_post("info" , true ));//info
		$type = $this->input->get_post("type" , true );//type
		$disorder = $this->input->get_post("disorder" , true );//排序
		if(!array_key_exists($type,$this->type_)){
			$type = 'string';
		}
		$data = array(
			'varname'=>$varname,
			'value'=>$value,
			'info'=>$info,
			'type'=>$type,
			'groupid'=>$gid,
			'disorder'=>$disorder
		);
		if(empty($varname)){
			exit('varname is empty');
		}
		if(utf8_str($varname) != 1 ){
			showmessage("变量名称必须是英文","sysconfig/index",3,0,"?gid=1000");
			exit();		
		}
		if($type == 'boolean' && !in_array($value, array('N' , 'Y'))){
			showmessage("变量类型是boolean，值必须是 N或者Y","sysconfig/index",6,0,"?gid=1000");
			exit();
		}
		$status = $this->M_sysconfig->query_isexists_by_varname($varname);
		if($status){
			showmessage("变量名称存在","sysconfig/index",3,0,"?gid=1000");
			exit();
		}
		$status = $this->M_sysconfig->insert_sysconfig($data);
		if($status){
			showmessage("添加成功","sysconfig/index",3,1,"?gid={$gid}");
			exit();
		}
		showmessage("添加失败","sysconfig/index",3,0,"?gid=1000");
		exit();
	}
	
	function edit(){
		$gid =verify_id($this->input->get_post("gid"));
		
		$data = $this->input->post() ;
		/* echo "<pre>";
		print_r($data); */
		$status = $this->M_sysconfig->update_data($data);
		if($status){
			showmessage("修改成功","sysconfig/index",3,1 , "?gid={$gid}");
		}else{
			showmessage("服务器繁忙请稍候","sysconfig/index",3,0 , "?gid={$gid}");
		}
	}
	//系统基本参数删除
	function del(){
		$adminGroup = config_item("super_admin") ;
		if(!in_array($this->visitor['username'], $adminGroup)){
			show_error("no permistion " , 500 , "error page ");
		}
		
		$varname = $this->input->get_post("varname" , true ) ; 
		$gid = $this->input->get_post("gid" , true );
		$varname = str_replace("[]", "", $varname);

		$status = $this->M_sysconfig->del_varname($varname);
		if($status){
			showmessage("删除系统环境变量{$varname}成功","sysconfig/index",3,1 , "?gid={$gid}");
			exit();
		}
		showmessage("删除系统环境变量{$varname}失败","sysconfig/index",3,0 , "?gid={$gid}");
		exit();
	}

}




