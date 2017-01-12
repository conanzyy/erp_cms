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
--添加导航</title>
<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>jquery.js"></script>
<link href="<?php echo _CSSPATH_ ; ?>style.css" rel="stylesheet" type="text/css" />
</head>

<body>

	
    
    <div class="formbody">
    <form action="<?php echo  site_url("role/add") ; ?>?action=doadd&showpage=1" method="post">
    <div class="formtitle"><span>添加角色</span></div>
     <div class="tips">
    <span><img src="<?php echo _IMGPATH_ ; ?>tip.png" alt="友情提示" /></span>
    <b>添加完成之后，点击修改才可以进行编辑控制组的权限</b> 
    
    </div>
    <ul class="forminfo">

    <li><label>角色名称</label><input name="rolename" type="text" class="dfinput" /><i class="">请输入角色名称</i></li>   
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
		$("#btn").live("click" , function(){
			if(!check_rolename()){
				return false ;
			}else if(!check_disorder()){
				return false ;
			}else if(!check_url()){
				return false ;
			}else{
				return true ; 
			}
			
		});
		$("input[name='rolename']").blur(function(){
			check_rolename() ;
		});
	
	}) ; 

	//检查导航名称
	function check_rolename(){
		var v = $("input[name='rolename']") ; 
		if(v.val() == '' ){
			v.next("i").attr("class" ,"wrong").html("请输入角色名称"); 
			return false ;
		}else{
			v.next("i").attr("class" ,"correct").html("角色名称正确");
			
			return true ; 
		}
		
	}
	
</script>
