<?php
/*
 *后台操作日志
 *author 王建 
 */
if (! defined('BASEPATH')) {
    exit('Access Denied');
}
class Log extends MY_Controller{
	function Log(){
		parent::__construct();
		$this->load->model('M_common');
		$this->load->model('M_log');
	}
	function index(){
		$action = $this->input->get_post("action");	
		$action_array = array("show","ajax_data");
		$action = !in_array($action,$action_array)?'show':$action ;
		if($action == 'show'){
			//查询所有的log表数据，生成select
			$table_array = $this->M_log->log_table();
			
			$data['table'] = $table_array ;
			$this->load->view(__TEMPLET_FOLDER__."/views_log_list",$data);
		}elseif($action == 'ajax_data'){
			$this->ajax_data();
			
		}
		
		
	}

	private function ajax_data(){
		$data = array();
		$data = array(
			'log_person'=>trim($this->input->get_post('log_person' , true )) , 
			'log_url'=>trim($this->input->get_post('log_url' , true )) ,
			'status'=>$this->input->get_post('status' , true ) ,
			'table'=>trim($this->input->get_post('table' , true )) ,
		);
		$page = verify_id($this->input->get_post("page" , true ));
		
		$list = $this->M_log->queryLogList($page ,50 ,$data);
		echo result_to_towf_new($list['list'], 1, '成功', $list['page_sting']) ;
	}

	

	
}