<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo isset($this->site_config['web_site_name'])?$this->site_config['web_site_name']:'';?>-------用户管理</title>
<link href="<?php echo _CSSPATH_ ; ?>style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>jquery.js"></script>
<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>select-ui.min.js"></script>
<script src="<?php echo _JSPATH_ ; ?>layer/lib.js"></script>
<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>layer/layer.min.js"></script>
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

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li>首页</li>
  
    <li>后台用户管理</li>
    </ul>
    </div>
    
    <div class="rightinfo">
    
    <div class="tools">
    
    	<ul class="toolbar">
        <li class="click" onclick="add()"><span><img src="<?php echo  _IMGPATH_ ;?>t01.png" /></span>添加后台用户</li>
        </ul>

    </div>
    
  <ul class="seachform" style="margin-left:4%">
    
    <li><label>用户名：</label><input name="username" type="text" class="scinput" />
    <select name="condition"  id="condition">
   		 <option value="">请选择</option>
    	<option value="1">模糊查询</option>
    	<option value="2">模糊查询</option>
    </select>
    
    </li>
    <li><label>昵称：</label><input name="nick" type="text" class="scinput" />

   
    
    <li><label>&nbsp;</label><input name="" onclick="search()" type="button" class="scbtn" value="查询"/></li>
    </ul>
    <table class="tablelist">
    	<thead>
    	<tr>
        <th><input name="" type="checkbox" value="" checked="checked"/></th>
        <th>编号<i class="sort" field="id" orderby = "desc"  style="cursor:pointer" ><img src="<?php echo  _IMGPATH_ ;?>/px.gif" /></i></th>
        <th>用户名</th>
        <th>昵称</th>
        <th >添加日期   <i class="sort" field="addtime" orderby = "desc"  style="cursor:pointer" ><img src="<?php echo  _IMGPATH_ ;?>/px.gif" /></i></th>
        <th>状态   <i class="sort" field="status" orderby = "desc"  style="cursor:pointer" ><img src="<?php echo  _IMGPATH_ ;?>/px.gif" /></i></th>
        <th>用户组</th>
     	 <th>是否是管理员</th>
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
var page = 1 ;
var field = "id" ; //  哪个字段排序
var orderby = "desc" ; //升序还是降序
$(function () {
	common_request();
});
function common_request(){
	var url="<?php echo site_url("sys_admin/index");?>?inajax=1";
	var data_ = {
		'page':page,
		'time':<?php echo time();?>,
		'action':'ajax_data' , 
		'username':$("input[name='username']").val() , 
        'nick':$("input[name='nick']").val() , 
		'condition':$("#condition").val() , 
		'field':field , 
		'orderby':orderby
	} ;
	//console.dir(data_);
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
				shtml+='<td>'+list[i]['username']+'</td>';
                shtml+='<td>'+list[i]['nick']+'</td>';
				shtml+='<td >'+list[i]['addtime']+'</td>';
				shtml+='<td>'+list[i]['status']+'</td>';
				shtml+='<td>'+list[i]['gid']+'</td>';
				shtml+='<td>'+list[i]['super_admin']+'</td>';
				shtml+='<td><a href="<?php echo site_url('sys_admin/edit');?>?id='+list[i].id+'" class="tablelink">设置权限</a>&nbsp;&nbsp;  <a href="javascript:void(0)" onclick="passwd('+list[i].id+',this)" class="tablelink">密码修改</a>&nbsp;&nbsp;</td>';
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
function ajax_data(p){
	page = p  ; 
	common_request();
}
function search(){
	page = 1 ;
	common_request();
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
	    iframe: {src: "<?php echo site_url("sys_admin/add");?>?showpage=1"}
	}); 
}

$(".tablelist i.sort").each(function(){
	$(this).click(function(){
		field = $(this).attr("field");
		orderby = $(this).attr("orderby");
		$(this).attr("orderby" , ((orderby == 'asc' )?'desc':'asc') )  ;
		page = 1 ;  
		common_request() ; 
	});
});
//密码修改
function passwd(id , o ){
	$.layer({
	    type: 2,
	    shadeClose: false,
	    title: false,
	    closeBtn: [0, true],
	    shade: [0.8, '#000'],
	    border: [1],
	    offset: ['20px',''],
	    area: ['720px','460px'],
	    iframe: {src: "<?php echo site_url("sys_admin/passwd");?>?showpage=1&id="+id}
	}); 
}
</script> 


