<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加导航</title>
<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>jquery.js"></script>
<link href="<?php echo _CSSPATH_ ; ?>style.css" rel="stylesheet" type="text/css" />
</head>

<body>


    
    <div class="formbody">
    <form action="<?php echo  site_url("nav/edit") ; ?>?action=doedit&showpage=1" method="post">
    <input type="hidden" name="id" value="<?php echo $info['id'];?>">
    <div class="formtitle"><span>添加导航</span></div>
    
    <ul class="forminfo">
    <li><label>导航分类</label>
   <select name="pid">
            <option value="0">一级菜单</option>
            <?php 
            	if($options){           		
            		foreach($options as $row){
						$selected = '';
						if($row['id'] == $info['pid']){
							$selected = "selected='selected'";
						}
            ?>         		
            <option value="<?php echo $row['id'] ?>" <?php echo $selected ;?> <?php if($row['pid'] == 0){echo 'style="background:lightgreen"';}?>><?php echo str_pad("",$row['deep']*3, "-",STR_PAD_RIGHT); ?><?php echo $row['name']; ?></option>
         <?php 
            }

            }         	
        ?> 
             </select>
    <i>请选择分类</i></li>
    <li><label>导航名称</label><input name="name" type="text" class="dfinput" value="<?php echo $info['name'];?>" /><i class="">请输入导航名称</i></li>
    <li><label>排序</label><input name="disorder" type="text" class="dfinput" value="<?php echo $info['disorder'];?>" /><i></i></li>
    <li><label>url地址</label><input name="url" type="text" class="dfinput" value="<?php echo $info['url'];?>" /><i>温馨提示:此处的url地址格式是:控制器/方法/</i></li>
   
    <li><label>状态</label>
    <input type="radio" name="status" value="1" <?php if($info['status'] == 1 ){echo "checked";} ;?>/> 启用
    <input type="radio" name="status" value="0" <?php if($info['status'] == 0 ){echo "checked";} ;?> /> 禁用
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
			if(!check_nav()){
				return false ;
			}else if(!check_disorder()){
				return false ;
			}else if(!check_url()){
				return false ;
			}else{
				return true ; 
			}
			
		});
		$("input[name='name']").blur(function(){
			check_nav() ;
		});
		$("input[name='disorder']").blur(function(){
			check_disorder();
		});
		$("input[name='url']").blur(function(){
			check_url();
		});
	}) ; 

	//检查导航名称
	function check_nav(){
		var v = $("input[name='name']") ; 
		if(v.val() == '' ){
			v.next("i").attr("class" ,"wrong").html("请输入导航名称"); 
			return false ;
		}else{
			v.next("i").attr("class" ,"correct").html("导航名称正确");
			
			return true ; 
		}
		
	}
	//检查排序
	function check_disorder(){
		var v = $("input[name='disorder']") ; 
		if(! /^[0-9]+.?[0-9]*$/.test(v.val()) ){
			v.next("i").attr("class" ,"wrong").html("必须是数字") ; 
			return false ;
		}else{
			v.next("i").attr("class" ,"correct").html("正确") ; 
			return true ;
		}
		
	}
	//检查url地址
	function check_url(){
		var v = $("input[name='url']");
		if(v.val() == '' ){
			v.next("i").attr("class" ,"wrong").html("请输入url地址"); 
			return false ;
		}else{
			v.next("i").attr("class" ,"correct").html("正确");
			return true ; 
		}
		
	}
</script>
