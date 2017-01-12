<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo isset($this->site_config['web_site_name'])?$this->site_config['web_site_name']:'';?>-------角色管理</title>
<link href="<?php echo _CSSPATH_ ; ?>style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>jquery.js"></script>
<script src="<?php echo _JSPATH_ ; ?>layer/lib.js"></script>
<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>layer/layer.min.js"></script>


<script type="text/javascript">
$(document).ready(function(){
  $(".click").click(function(){
  $(".tip").fadeIn(200);
  });
  
  $(".tiptop a").click(function(){
  $(".tip").fadeOut(200);
});

  $(".sure").click(function(){
  $(".tip").fadeOut(100);
});

  $(".cancel").click(function(){
  $(".tip").fadeOut(100);
});

});
</script>


</head>


<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">数据表</a></li>
    <li><a href="#">基本内容</a></li>
    </ul>
    </div>
    
    <div class="rightinfo">
    
    <div class="tools">
    
    	<ul class="toolbar">
        <li class="click" onclick="add()"><span><img src="<?php echo  _IMGPATH_ ;?>t01.png" /></span>添加</li>
        </ul>
        
   
    
    </div>
    
    
    <table class="tablelist">
    	<thead>
    	<tr>
        <th><input name="" type="checkbox" value="" checked="checked"/></th>
        <th>编号<i class="sort"><img src="<?php echo  _IMGPATH_ ;?>/px.gif" /></i></th>
        <th>角色名称</th>
        <th>添加日期</th>
        <th>状态</th>
        <th>缓存文件路径</th>
     	 <th>修改日期</th>
        <th>操作</th>
        </tr>
        </thead>
        <tbody id="result_">

              
        </tbody>
    </table>
    
   
    <div class="pagin" id="page_string">
    	
     
    </div>
    
    

    
    
    
    
    </div>
    
    <script type="text/javascript">
	$('.tablelist tbody tr:odd').addClass('odd');
	</script>

</body>

</html>

<script>
var loadding_0  ;
$(function () {
	common_request(1);
});
function common_request(page){
	var url="<?php echo site_url("role/index");?>?inajax=1";
	var data_ = {
		'page':page,
		'time':<?php echo time();?>,
		'action':'ajax_data'
	} ;
	$.ajax({
	type: "POST",
	url: url ,
	data: data_,
	cache:false,
	dataType:"json",
	// async:false,
	success: function(msg){
		var shtml = '' ;
		var list = msg.resultinfo.list;
		
		if(msg.resultcode<0){
			layer.msg('没有权限执行此操作');
			return false ;
		}else if(msg.resultcode == 0 ){
			layer.msg('服务器繁忙请稍后');
			return false ;
		}else{
		
			for(var i in list){
				shtml+='<tr>';
				shtml+= '<td><input name="" type="checkbox" value="'+list[i].id+'" /></td>' ;
				shtml+= '<td>'+list[i].id+'</td>' ;
				//shtml+='<td><a href="javascript:void(0)" title="查看所在的用户" onclick="preview_user('+list[i].id+',\''+list[i].rolename+'\')">'+list[i]['rolename']+'</a></td>';
				shtml+='<td>'+list[i]['rolename']+'</td>';
				shtml+='<td>'+list[i]['addtime']+'</td>';
				shtml+='<td>'+list[i]['status']+'</td>';
				shtml+='<td>'+list[i]['cache_file']+'</td>';
				shtml+='<td>'+list[i]['filemtime']+'</td>';
				shtml+='<td><a href="<?php echo site_url('role/edit');?>?id='+list[i].id+'" class="tablelink">设置权限</a>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="del_role('+list[i].id+',this)" class="icon-remove"></a></td>';
				shtml+='</tr>';
			}
			$("#result_").html(shtml);
			$("#page_string").html(msg.resultinfo.obj);
		}
		layer.close(loadding_0);
	},
	beforeSend:function(){
		 loadding_0 = layer.load('数据正在加载中。。。。。。'); 
	},
	error:function(){
		layer.msg('服务器繁忙请稍后');
		return false ;
	}
	});
}
function ajax_data(page){
	common_request(page);
}
//添加角色
function add(){
	$.layer({
	    type: 2,
	    shadeClose: false,
	    title: false,
	    closeBtn: [0, true],
	    shade: [0.8, '#000'],
	    border: [1],
	    offset: ['20px',''],
	    area: ['720px','460px'],
	    iframe: {src: "<?php echo site_url("role/add");?>?showpage=1"}
	}); 
}


</script> 
