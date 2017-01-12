<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo isset($this->site_config['web_site_name'])?$this->site_config['web_site_name']:'';?>
--后台用户密码修改</title>
<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>jquery.js"></script>
<link href="<?php echo _CSSPATH_ ; ?>style.css" rel="stylesheet" type="text/css" />
<style>
.forminfo li{
	float:left
	
}
select {
    opacity: 0.89;
	width:180px ; 
	border:solid 1px ; 
	border-color:#A7B5BC #CED9DF #CED9DF #A7B5BC  ;
	height:31px ; 
	padding:5px
}
</style>
</head>

<body>

	
    
    <div class="formbody">
    <form action="<?php echo  site_url("sys_admin/edit_passwd") ; ?>?action=doedit" method="post">
    <div class="formtitle"><span>后台用户密码修改</span></div>
     
    <ul class="forminfo">

    <li><label>密码</label><input name="password" type="password" class="dfinput" /><i class="">请输入密码</i></li>   
      <li><label>确认密码</label><input name="repassword" type="password" class="dfinput" /><i class="">请再次输入密码</i></li>   
  
   
    <li><label>&nbsp;</label><input name="" type="submit" id="btn" class="btn" value="确认保存"/></li>
    </ul>
    
    </form>
    </div>


</body>

</html>

<script>
	$(function(){
		$("input[name='password']").val('');
		$("input[name='repassword']").val('');
		
		$("#btn").live("click" , function(){
			if(!check_passwd()){
				return false ;
			}else{
				return true ; 
			}
			
		});
		
		$("input[name='password']").blur(function(){
			check_passwd() ;
		});
		$("input[name='repassword']").blur(function(){
			check_passwd() ;
		});
	}) ; 

	//检查用户名称
	function check_passwd(){
		var v1 = $("input[name='password']") ; 
		var v2 = $("input[name='repassword']") ; 
		if(v1.val() == '' || v1.val().length <6 ){
			v1.next("i").attr("class" ,"wrong").html("密码必须大于6小于32"); 
			return false ;
		}else if(v1.val() != v2.val() ){
			v2.next("i").attr("class" ,"correct").html("密码不一样");
			
			return false ; 
		}else{
			return true ; 
		}
		
	}
	
</script>
