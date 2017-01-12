<?php
/*
 *广告管理
 *author 王建 
 *time 2014-06-12
 */
if (! defined('BASEPATH')) {
    exit('Access Denied');
}
class Ad extends MY_Controller{
	public $upload_path = '' ;
	public  $v_upload_path ; //访问的路径 
	function Ad(){
		parent::__construct();
		$this->load->model('M_common');
		$this->load->model('M_ad');
		$this->upload_path = config_item("ad_path") ; ; // 广告图片位置
		$this->v_upload_path = base_url().config_item("v_ad_path");  //访问路径
	}
	function index(){
		$action = $this->input->get_post("action");	
		$action_array = array("show","ajax_data");
		$action = !in_array($action,$action_array)?'show':$action ;
		if($action == 'show'){		
			
			$type_array = $this->M_ad->query_ad_type();	
			$data = array(
				'list'=>$type_array
			);						
			$this->load->view(__TEMPLET_FOLDER__."/views_ad",$data);
		}elseif($action == 'ajax_data'){
			$this->ajax_data();
		}
	}
	//ajax get data
	private function ajax_data(){
		$page = intval($this->input->get_post("page" , true ));
		$per_page = 15;//每一页显示的数量
		$search = array() ; 
		$search['typeid'] =verify_id($this->input->get_post("typeid"  , true  ) );
		$search['name'] =trim($this->input->get_post("name"  , true  ) );
		$search['type'] =$this->input->get_post("type"  , true  ) ;
		$search['status'] =$this->input->get_post("status"  , true  ) ;
		$list = $this->M_ad->queryAdList($page , $per_page , $search);
		echo result_to_towf_new($list['list'], 1, '成功', $list['page_sting']) ;
	}
	
	//添加广告数据
	function add(){	
			
		$action = $this->input->get_post("action");		
		$action_array = array("add","doadd");
		$action = !in_array($action,$action_array)?'add':$action ;	
		if($action == 'add'){
			$typeid = $this->input->get_post("typeid"  , true );
			$this->load->helper(array('form', 'url'));					
			$result = $this->M_ad->query_ad_type();//广告类别
			$data = array(
				'ad_type'=>$result,
				'typeid'=>$typeid
			);		
			$this->load->view(__TEMPLET_FOLDER__."/views_ad_add",$data);		
		}elseif($action =='doadd'){			
			$this->doadd();
		}
	}
	//get params
	private function get_params(){
		
		return array(
			'name'=>$this->input->get_post("name",true) , 
			'ad_type'=>verify_id($this->input->get_post("ad_type",true)) , //广告分类 位置
			'type'=>verify_id($this->input->get_post("type",true)) , 
			'pic_des'=>$this->input->get_post("pic_des",true),
			'pic_url'=>$this->input->get_post("pic_url",true) , 
			'words'=>$this->input->get_post("words",true),
			'begin_date'=>(stripos(($this->input->get_post("begin_date",true)), "-") !== false )?strtotime($this->input->get_post("begin_date",true)):0 , 
			'end_date'=>(stripos(($this->input->get_post("end_date",true)), "-") !== false )?(strtotime($this->input->get_post("end_date",true))):0 , 
			'status'=>verify_id($this->input->get_post("status",true)) , 
			'attr_1'=>$this->input->get_post("attr_1",true) , 
			'attr_2'=>$this->input->get_post("attr_2",true)
		);
	}
	//处理添加
	private function doadd(){	
		$data = $this->get_params() ; 
		if($data['name'] == "" ){
			showmessage("广告名称不能为空","ad/add",3,0,"");
			exit();
		}
		$this->load->library("common_upload");
		$pic = '' ;
		$pic2 = '' ;
		if(isset($_FILES['pic']) && $_FILES['pic']['name']){
			$data_1  = $this->common_upload->upload_path($this->upload_path."/".$data['ad_type'],"pic") ;
			if(!$data_1['status']){
				showmessage($data_1['message'],"ad/add",3,0,"");
				exit();
			}
			$pic = $data['ad_type']."/".$data_1['pic'];
		}
		if(isset($_FILES['pic2']) && $_FILES['pic2']['name']){
			$data_1  = $this->common_upload->upload_path($this->upload_path."/".$data['ad_type'],"pic2") ;
			if(!$data_1['status']){
				showmessage($data_1['message'],"ad/add",3,0,"");
				exit();
			}
			$pic2 = $data['ad_type']."/".$data_1['pic'];
		}
		$data['addtime'] = time(); 
		$data['add_person'] = $this->visitor['username']  ; 
		$data['pic'] = $pic ;
		$data['pic2'] = $pic2 ;
		
		$array = $this->M_common->insert_one("{$this->table_}extra_ad",$data);
		if($array['affect_num']>=1){
			write_action_log($array['sql'],$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),1,"添加广告为{$data['name']}成功");
			header("Location:".site_url("ad/index"));
		}else{
			write_action_log($array['sql'],$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),0,"添加广告为{$data['name']}失败");		
			showmessage("服务器繁忙","ad/add",3,0,"");
			exit();
		}
	}
	//编辑页面
	function edit(){
		$action = $this->input->get_post("action");		
		$action_array = array("edit","doedit");
		$action = !in_array($action,$action_array)?'edit':$action ;		
		if($action == 'edit'){
			$this->load->helper(array('form', 'url'));			
			$id = verify_id($this->input->get_post("id" , true ));//数据
			$info_ = $this->M_ad->query_ad_one($id);
			if(empty($info_)){
				showmessage("参数错误","ad/index",3,0);
				exit();
			}		
			
			
			$type_array = $this->M_ad->query_ad_type();			
			$data = array(
					'info'=>$info_,	
					'id'=>$id,
					'ad_type'=>$type_array		
			);				
			$this->load->view(__TEMPLET_FOLDER__."/views_ad_edit",$data);	
			
		}elseif($action == 'doedit'){
			$this->doedit();
		}

	}
	//处理编辑数据
	private function doedit(){
		$data = $this->get_params() ; 
		$id = verify_id($this->input->get_post("id" , true ));
		if($data['name'] == "" ){
			showmessage("广告名称不能为空","ad/edit",3,0,"?id={$id}");
			exit();
		}
		$ad_array = $this->M_common->query_one("SELECT `pic`,`pic2` FROM `{$this->table_}extra_ad` WHERE id = '{$id}' LIMIT 1  ") ;
		$is_update_pic = '' ; 
		$is_update_pic2 = '' ;
		$this->load->library("common_upload");
		$pic = '' ;
		$pic2 = '' ;
		if(isset($_FILES['pic']) && $_FILES['pic']['name']){
			$data_1  = $this->common_upload->upload_path($this->upload_path."/".$data['ad_type'],"pic") ;
			if(!$data_1['status']){
				showmessage($data_1['message'],"ad/edit",3,0,"?id={$id}");
				exit();
			}
			$pic = $data['ad_type']."/".$data_1['pic'];
			$is_update_pic = " `pic` = '{$pic}' ," ;
			$data['pic'] = $pic ; 
		}
		if(isset($_FILES['pic2']) && $_FILES['pic2']['name']){
			$data_1  = $this->common_upload->upload_path($this->upload_path."/".$data['ad_type'],"pic2") ;
			if(!$data_1['status']){
				showmessage($data_1['message'],"ad/edit",3,0,"?id={$id}");
				exit();
			}
			$pic2 = $data['ad_type']."/".$data_1['pic'];
			$data['pic2'] = $pic2 ; 
		}
		 
		
		//$sql_= "SELECT a.* FROM {$this->table_}extra_ad as a where a.id = '{$id}' limit 1 ";					
		$info_ = $this->M_ad->query_ad_one($id);
		if(!$info_){
			showmessage("暂无数据","ad/edit",3,0,"?id={$id}");
			exit();
		}

		$sql_edit = $this->M_ad->update_ad($data , $id);
		if(!$sql_edit){
			write_action_log($sql_edit,$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),0,"修改广告为{$this->name}失败");
			showmessage("服务器繁忙，或者你没有修改任何数据","ad/edit",3,0,"?id={$id}");
		}else{
			if(isset($ad_array['pic']) && $ad_array['pic'] && file_exists($this->upload_path)."/".$ad_array['pic'] && $pic ){
				@unlink($this->upload_path."/".$ad_array['pic']);
			}
			if(isset($ad_array['pic2']) && $ad_array['pic2'] && file_exists($this->upload_path)."/".$ad_array['pic2'] && $pic2 ){
				@unlink($this->upload_path."/".$ad_array['pic2']);
			}
			write_action_log($sql_edit,$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),1,"修改广告为{$this->name}成功");
			header("Location:".site_url("ad/index"));
		}
	
	}
	//删除
	public function del(){
		$id = verify_id($this->input->get_post("id" , true ));
		if(!$id){
			echo result_to_towf_new("", 0, "请选择删除", null);
			die();
		}
		$re = $this->M_ad->del_ad($id);
		if($re['status']){
			echo result_to_towf_new("", 1, "删除成功", null);
		}else{
			echo result_to_towf_new("", 0, $re['message'], null);
		}
			
	}
	
}
//file end