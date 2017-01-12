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
--添加后台用户</title>
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
    <form action="<?php echo  site_url("sys_admin/add") ; ?>?action=doadd&showpage=1" method="post">
    <div class="formtitle"><span>添加后台用户</span></div>
     
    <ul class="forminfo">

    <li><label>用户名字</label><input name="username" type="text" class="dfinput" /><i class="">请输入用户名称</i></li>
    <li><label>用户昵称</label><input name="nick" type="text" class="dfinput" /><i class="">请输入用户昵称</i></li>      
    <li><label>密码</label><input name="passwd" type="text" class="dfinput" /><i class="">请输入密码</i></li>   
   	<li><label style="width:130px">是否是超级管理员</label>
   	 <input type="radio" name="super_admin" value="1" onclick="super_admin_(1);"/> 是
           <input type="radio" name="super_admin" value="0" onclick="super_admin_(0);" checked/> 不是
   	<i class="">请输入用户名称</i></li>   
   	<li id="group_"><label>用户组</label>
   	<select name="gid" >
				<?php 
					if(isset($list) && $list){
						foreach($list as $k_=>$v_){
					
				?>
				<option value="<?php echo $v_['id'];?>"><?php echo $v_['rolename'];?></option>
				<?php 
						}	
					}
				?>
			</select>
   	<i class="">请选择用户组</i></li>   
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
			if(!check_username()){
				return false ;
			}if(!check_nick()){
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
        $("input[name='nick']").blur(function(){
            check_nick() ;
        });
		$("input[name='passwd']").blur(function(){
			check_passwd() ;
		});
	}) ; 

	//检查用户名称
	function check_passwd(){
		var v = $("input[name='passwd']") ; 
		if(v.val() == '' || v.val().length <6 ){
			v.next("i").attr("class" ,"wrong").html("密码必须大于6小于32"); 
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
    function check_nick(){
        var v = $("input[name='nick']") ; 
        if(v.val() == '' ){
            v.next("i").attr("class" ,"wrong").html("请输入用户昵称"); 
            return false ;
        }else{
            v.next("i").attr("class" ,"correct").html("昵称正确");
            
            return true ; 
        }
        
    }   
	function super_admin_(type){
		if(type == 1 ){
			$("#group_").hide();
		}else{
			$("#group_").show();
		}
	}	
</script>
