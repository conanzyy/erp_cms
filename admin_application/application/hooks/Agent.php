<?php
class Agent extends CI_Controller {
	function myagent(){
		$this->load->library('user_agent');
		$browser =  $this->agent->browser() ;
		if($browser == 'Internet Explorer' ){
			header("Content-type:text/html;charset=utf-8");
			show_error("此系统不支持IE核心的浏览器，为了有更好的体验效果请更换Chrome 或者是 Firefox 浏览器 " , 500);
		}
	}
}