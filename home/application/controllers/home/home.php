<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends HomeCommon {

	public function index()
	{
		//$data=  $this->load_ad(23) ;
	//	$this->load->add_package_path(__ROOT__.'include/');
		
		//$this->load->model('M_common');

		//$this->load->model('M_ad');
		//$this->M_ad->read_ad_cache(1);
		/* $data = $this->load_ad(23 , 1) ;
		print_r($data); */
		$this->load->view('home/views_home.php');
	}
	
}

