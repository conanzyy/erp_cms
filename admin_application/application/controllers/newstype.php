<?php
/*
 *新闻类别
 *author 王建 
 *time 2014-05-18
 */
 
if (! defined('BASEPATH')) {
    exit('Access Denied');
}
class Newstype extends MY_Controller{
	private $category_modeldata_cache; 
	private $category_ ; 

	function Newstype(){
		parent::__construct();
		$this->load->model('M_common');
		$this->load->model('M_news');
	}
	function index(){
		$action = $this->input->get_post("action");	
		$action_array = array("show","ajax_data",'query_pid_by_id');
		$action = !in_array($action,$action_array)?'show':$action ;
		if($action == 'show'){
			$this->load->view(__TEMPLET_FOLDER__."/views_newstype_index");
		}elseif($action == 'ajax_data'){
			$this->ajax_data();
		}elseif($action == 'query_pid_by_id'){
			$pid = $this->query_pid_by_id();
			echo $pid ;
		}		
	}
	//ajax get data
	private function ajax_data(){
		$page = intval($this->input->get_post("page" , true ));
		$list = $this->M_news->queryNewsTypeList($page , 500 );
		echo result_to_towf_new($list['list'], 1, '成功', $list['page_string']) ;
	}
	//添加联动模型数据
	function add(){		
		$action = $this->input->get_post("action" , true );		
		$action_array = array("add","doadd");
		$action = !in_array($action,$action_array)?'add':$action ;	
		if($action == 'add'){	
			$pid = verify_id($this->input->get_post("pid")) ;
			$typename =( $this->M_news->getTypeName($pid) == '' )?"顶层栏目": $this->M_news->getTypeName($pid);			
			$this->load->view(__TEMPLET_FOLDER__."/views_newstype_add",array('pid'=>$pid , 'typename' => $typename ));		
		}elseif($action =='doadd'){
			$this->doadd();
		}
	}
	//处理添加
	private function doadd(){	
		$typename = trim($this->input->get_post("typename" , true)) ; 
		$seotitle = trim($this->input->get_post("seotitle" , true) ); 
		$keywords = trim($this->input->get_post("keywords" , true ));
		$description =trim($this->input->get_post("description" , true)) ;
		$disorder = verify_id($this->input->get_post("disorder" , true ));//排序
		$pid = verify_id($this->input->get_post("pid" , true )) ;
		$data = array(
			'disorder'=>$disorder,
			'pid'=>$pid,
			'typename'=>$typename,
			'seotitle'=>$seotitle,
			'keywords'=>$keywords,
			'description'=>$description , 
			'status'=>1			
		);
		$array = $this->M_news->insertNewType($data);
		if($array['status']){
			echo result_to_towf_new('', 1, $array['message'], null);
			die();
		}else{
			echo result_to_towf_new('', 0,$array['message'], null);
			die() ;
		}
	}
	//编辑页面
	function edit(){
		$action = $this->input->get_post("action" , true );		
		$action_array = array("edit","doedit");
		$action = !in_array($action,$action_array)?'edit':$action ;		
		if($action == 'edit'){
			$result = $this->M_news->make_option_data();//新闻类别
			$id = verify_id($this->input->get_post("id"));//数据			
			$info_ = $this->M_news->getNewsTypeData($id);
			if(empty($info_)){
				show_error("暂无数据" , "500" , "系统提示");
			}			
			$data = array(
					'info'=>$info_,						
					'id'=>$id	,
					'category'=>$result	
			);				
			$this->load->view(__TEMPLET_FOLDER__."/views_newstype_edit",$data);	
			
		}elseif($action == 'doedit'){
			$this->doedit();
		}

	}
	//处理编辑数据
	private function doedit(){
		$typename = trim($this->input->get_post("typename" , true)) ; 
		$seotitle = trim($this->input->get_post("seotitle" , true) ); 
		$keywords = trim($this->input->get_post("keywords" , true ));
		$description =trim($this->input->get_post("description" , true)) ;
		$disorder = verify_id($this->input->get_post("disorder" , true ));//排序
		$id = verify_id($this->input->get_post("id" , true )) ;
		$pid = verify_id($this->input->get_post("pid" , true )) ;
		$data = array(
			'disorder'=>$disorder,
			'pid'=>$pid,
			'typename'=>$typename,
			'seotitle'=>$seotitle,
			'keywords'=>$keywords,
			'description'=>$description , 
			'status'=>1			
		);
	
		$array = $this->M_news->editNewsType($data , $id );
		if($array['status']){
			echo result_to_towf_new('', 1, $array['message'], null);
			die();
		}else{
			echo result_to_towf_new('', 0,$array['message'], null);
			die() ;
		}
	}
		
}
//file end