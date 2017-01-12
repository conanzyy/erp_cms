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
--修改用户---<?php echo $info['username'];?>密码</title>
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
#choose span{
	float:left ; 
	width:150px ; 
	padding:3px ; 
	border:solid 1px #A7B5BC;
	margin-left:2px ;
	margin-top:2px ;
}
</style>
</head>

<body>

	
    
    <div class="formbody">
    <form action="<?php echo  site_url("sys_admin/passwd") ; ?>?action=doedit&showpage=1" method="post">
    <input type="hidden" name="id" value="<?php echo $info['id'];?>">
    <div class="formtitle"><span>用户 <?php echo $info['username'];?> 密码修改</span></div>
     
    <ul class="forminfo">

    <li><label>用户名字</label><input disabled name="username" value="<?php echo $info['username'];?>" type="text" class="dfinput" /><i class=""></i></li>   
    <li><label>新密码</label><input  name="password" type="text" class="dfinput" /><i class="">请输入新的密码</i></li>   

  

    <li><label>&nbsp;</label><input name="" type="submit" id="btn" class="btn" value="确认保存"/></li>
    </ul>
    
    </form>
    </div>


</body>

</html>

<script>
<?php
		$perms_ = '[' ;
		if(isset($perm_array_exists) && $perm_array_exists){
			foreach($perm_array_exists as $k1=>$v1){
				$perms_.='\''.$k1.'\',';
			}
			$perms_ = rtrim($perms_,",");
		}
		$perms_.=']';
?>
var exists_perms = <?php echo $perms_ ;?> ;
	$(function(){
		$("#btn").live("click" , function(){
			if(!check_username()){
				return false ;
			}else{
				return true ; 
			}
			
		});
		$("input[name='username']").blur(function(){
			check_username() ;
		});
		
	}) ; 


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
	function super_admin_(type){
		if(type == 1 ){
			$("#group_").hide();
		}else{
			$("#group_").show();
		}
	}	

	$('#select1').dblclick(function(){ //绑定双击事件
		var value = $("option:selected",this).val(); //获取选中的值
		var text = $("option:selected",this).text() ;
		text = text.replace(/-/g,"");
	
		if(value && !in_array(value,exists_perms)){
			$("#choose").append("<span><font color='green' >"+text+"</font><input type='checkbox' value='"+value+"' name='p[]' checked='true' onclick='del_o(this)'></span>&nbsp;");
			exists_perms.push(value);
			
		}
});

//判断元素是不是在数组里面
function in_array(needle, haystack) {
	if(typeof needle == 'string' || typeof needle == 'number') {
		for(var i in haystack) {
			if(haystack[i] == needle) {
					return true;
			}
		}
	}
	return false;
}
//删除checkbox
function del_o(o){
	o = $(o);//转化为jquery对象
	if(!o.is(":checked")){
		o.parent().remove();
	}
}
</script>
