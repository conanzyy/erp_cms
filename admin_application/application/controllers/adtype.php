<?php
/*
 *广告类型
 *author  王建 
 */
if (! defined('BASEPATH')) {
    exit('Access Denied');
}
class Adtype extends MY_Controller{
	function Adtype(){
		parent::__construct();
		$this->load->model('M_common');
		$this->load->model('M_adtype');
	}
	function index(){
		$action = $this->input->get_post("action");	
		$action_array = array("show","ajax_data");
		$action = !in_array($action,$action_array)?'show':$action ;
		if($action == 'show'){
			$this->load->view(__TEMPLET_FOLDER__."/views_adtype");
		}elseif($action == 'ajax_data'){
			$this->ajax_data();
		}
		
		
	}
	private function ajax_data(){
		$page = $this->input->get_post("page" , true );	
		$per_page = 15;//每一页显示的数量
		$where = '' ;
		$typename = $this->input->get_post("typename" , true );
		$id = verify_id($this->input->get_post("id" , true ));
		if($typename){
			$where['typename'] = $typename ;
		}
		$where['condition'] = $this->input->get_post("condition" , true );
		$where['id'] = $id ;
		$where['status'] = $this->input->get_post("status" , true );
		
		$data = $this->M_adtype->queryAdtypeList($page , $per_page ,$where);
		
		
		echo result_to_towf_new($data['list'], 1, '成功', $data['page_sting']) ;
	}
	//编辑页面
	function edit(){
		$action = $this->input->get_post("action");		
		$action_array = array("edit","doedit");
		$action = !in_array($action,$action_array)?'edit':$action ;		
		if($action == 'edit'){
			$id = verify_id($this->input->get_post("id"));
			$sql_adtype = "SELECT * FROM {$this->table_}extra_adtype WHERE id = '{$id}'";
			$info = $this->M_common->query_one($sql_adtype);
			if(empty($info)){
				showmessage("暂无数据","adtype/index",3,0);
				exit();
			}	
			$data = array(
				'info'=>$info
			);
			$this->load->view(__TEMPLET_FOLDER__."/views_adtype_edit",$data);		
		}elseif($action == 'doedit'){
			$this->doedit();
		}

	}
	//处理编辑数据
	private function doedit(){
		$id = verify_id($this->input->get_post("id"));
		$field = $this->input->get_post("field" , true );
		$value = $this->input->get_post("value" , true );
		$params = array(
			'id'=>$id , 
			'field'=>$field , 
			'value'=>$value		
		) ;
		$data = $this->M_adtype->edit_ad($params);
		if($data['status']){
			echo result_to_towf_new("", 1, "修改成功", null);
		}else{
			echo result_to_towf_new("", 0, $data['message'], null);
		}
		
	}
	
	
	///广告类别增加
	 function add(){
		$action = $this->input->get_post("action");		
		$action_array = array("add","doadd");
		$action = !in_array($action,$action_array)?'show':$action ;	
		if($action == 'show'){			
			$this->load->view(__TEMPLET_FOLDER__."/views_adtype_add");		
		}elseif($action == 'doadd'){
			$this->doadd();
		}
	}
	//处理增加
	private function doadd(){
		$typename = $this->input->get_post("typename" , true );//typename
		$status = verify_id($this->input->get_post("status" , true )); //状态	

		$params = array(
			'typename'=>$typename,
			'status'=>$status,
			'addtime'=>time(),
			'updatetime'=>time(),
		);
		$array = $this->M_adtype->add_adtype($params);
		if($array['status']){
			$url = site_url("adtype/index") ;
			echo "<script>parent.window.location.href='{$url}';</script>";
			exit();
		}else{
			show_error($array['message'],'500','信息提示');
			exit();
		}
	}

	
	
}