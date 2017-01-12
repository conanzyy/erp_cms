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
--后台用户权限设置和修改用户</title>
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
    <form action="<?php echo  site_url("sys_admin/edit") ; ?>?action=doedit" method="post">
    <input type="hidden" name="id" value="<?php echo $info['id'];?>">
    <div class="formtitle"><span>后台用户权限设置</span></div>
     
    <ul class="forminfo">

    <li><label>用户名字</label><input name="username" value="<?php echo $info['username'];?>" type="text" class="dfinput" /><i class="">请输入用户名称</i></li>   
     <li><label>用户昵称</label><input name="nick" value="<?php echo $info['nick'];?>" type="text" class="dfinput" /><i class="">请输入用户昵称</i></li>   
   	<li><label style="width:130px">是否是超级管理员</label>
   	 <input type="radio" name="super_admin" value="1" onclick="super_admin_(1);"/> 是
           <input type="radio" name="super_admin" value="0" onclick="super_admin_(0);" checked/> 不是
   	<i class="">请输入用户名称</i></li> 
   	<li id="group"><label>用户所属组：</label>
   	<select name="gid">
				<?php 
					if(isset($list) && $list){
						foreach($list as $k_=>$v_){
					
				?>
				<option value="<?php echo $v_['id'];?>" <?php if($info['gid'] == $v_['id']){echo "selected='selected'";}?>><?php echo $v_['rolename'];?></option>
				<?php 
						}	
					}
				?>
	</select>
   	</li>  
   	<li id="group_"><label>权限组：</label>
   	<div style="float:left ; width:320px">
   	<select name="gid" style="width:300px ; height:500px" size="310" id="select1">
				<?php 
				
					if(isset($options) && $options){
						foreach($options as $k_=>$v_){
					
				?>
				<option value="<?php echo isset( $v_['url'] )?$v_['url']:''; ?>"><?php echo str_repeat("----", $v_['deep']). $v_['name'];?></option>
				<?php 
						}	
					}
				?>
			</select>
			</div>
		<div id="choose" style="float:right ; width:680px">
			<div>已经添加的权限组：</div>
			<?php 

				if(isset($perm_array_exists) && $perm_array_exists){
					foreach($perm_array_exists as $p_=>$v_ ){
						echo "<span><font color='red'>".$v_."</font><input type='checkbox' name='p[]' value='{$p_}' checked='checked' onclick=\"del_o(this)\"></span>";
					}
				}
			?>
		</div>
   	</li>   
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
