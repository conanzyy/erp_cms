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
--网站用户添加</title>
<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>jquery.js"></script>
<link href="<?php echo _CSSPATH_ ; ?>style.css" rel="stylesheet" type="text/css" />
<script src="<?php echo _JSPATH_ ; ?>layer/lib.js"></script>
<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>layer/layer.min.js"></script>  
<script type="text/javascript" src="<?php echo _JSPATH_  ; ?>DatePicker/WdatePicker.js"></script>
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
    <form action="<?php echo  site_url("member/add") ; ?>?action=doadd&showpage=1" method="post">
    <div class="formtitle"><span>添加网站用户</span></div>
     
    <ul class="forminfo">

    <li><label>用户名字</label><input name="username" type="text" class="dfinput" /><i class="">请输入用户名称</i></li>   
    <li><label>密码</label><input name="passwd" type="text" class="dfinput" /><i class="">请输入密码</i></li>   
   <li><label>过期日期</label><input type='text' class="dfinput" name='expire' onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"><i>如果不选表示永不过期</i></li>
    <li><label>状态</label>
    <input type="radio" name="status" value="1" checked/> 启用
    <input type="radio" name="status" value="0"/> 禁用
    </li>
    <li><label>&nbsp;</label><input name="" type="submit" id="btn" class="btn" value="确认保存"/></li>
    </ul>
    
    </form>
    </div>


</body>

</html>

<script>
	$(function(){
		$("#btn").on("click" , function(){
			if(!check_username()){
				return false ;
			}else if(!check_passwd()){
				return false ;
			}else{
				return true ; 
			}
			
		});
		$("input[name='username']").blur(function(){
			check_username() ;
		});
		$("input[name='passwd']").blur(function(){
			check_passwd() ;
		});
	}) ; 

	//检查用户名称
	function check_passwd(){
		var v = $("input[name='passwd']") ; 
		if(v.val() == '' || v.val().length <6 ||  v.val().length > 16){
			v.next("i").attr("class" ,"wrong").html("密码必须大于6小于16"); 
			return false ;
		}else{
			v.next("i").attr("class" ,"correct").html("密码正确");
			
			return true ; 
		}
		
	}
	function check_username(){
		var v = $("input[name='username']") ; 
		if(v.val() == '' ){
			v.next("i").attr("class" ,"wrong").html("请输入用户名称"); 
			return false ;
		}else{
			v.next("i").attr("class" ,"correct").html("用户名称正确");
			
			return true ; 
		}
		
	}	

</script>
