<?php 
/*
 *后台控制器不需要进行权限控制
 *author 王建 
 */
if (! defined('BASEPATH')) {
    exit('Access Denied');
}
class Common extends MY_Controller{
	
	function Common(){
		parent::__construct();
		
	}
	//广告图 ----上传图片
	public function ad_upload(){
		$type = $this->input->get_post("type" , true );
		$typeArray = array(1);
		if(!in_array($type, $typeArray)){
			echo result_to_towf_new(null, 0, "参数出错", null);
			die();
		}
		$path = config_item("ad_path") ;
		if($type == 1 ){
			//广告
			$path = $path."/".$this->input->get_post("typeid" , true );
		}
		$this->load->library("common_upload");
		$data  = $this->common_upload->upload_path($path,"img") ;
		if(!$data['status']){
			echo result_to_towf_new(null, 0, $data['message'], null);
			die();
		}
		if($type == 1 ){
			//广告图片
			echo result_to_towf_new($this->input->get_post("typeid" , true )."/".$data['pic'], 1, '', null);
			die();
		}
		echo result_to_towf_new($data['pic'], 1, '', null);
	}

}