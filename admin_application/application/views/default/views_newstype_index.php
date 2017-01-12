<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo isset($this->site_config['web_site_name'])?$this->site_config['web_site_name']:'';?>-------新闻类别管理</title>
<link href="<?php echo _CSSPATH_ ; ?>style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>jquery.js"></script>
<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>select-ui.min.js"></script>
<script src="<?php echo _JSPATH_ ; ?>layer/lib.js"></script>
<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>layer/layer.min.js"></script>
<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>admin.js"></script>
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
  
    <li>新闻类别管理</li>
    </ul>
    </div>
    
    <div class="rightinfo">
 	<div class="tools">
    
    	<ul class="toolbar">
        	<li class="click"><span><img src="<?php echo  _IMGPATH_ ;?>t01.png" /></span><a href="javascript:void(0)" onclick="add_type(0)">添加顶层栏目</a></li>
        </ul>

    </div>
    

    <table class="tablelist">
    	<thead>
    	<tr>
        <th>编号<i class="sort" field="id" orderby = "desc"  style="cursor:pointer" ><img src="<?php echo  _IMGPATH_ ;?>/px.gif" /></i></th>
        <th>新闻类别</th>
        <th>父级ID</th>
        <th >排序</th>
        <th >seo标题</th>
        <th>关键词</th>
        <th>描述</th>
        <th>操作</th>
        
        </tr>
        </thead>
        <tbody id="result_">

              
        </tbody>
    </table>
    
   
    <div class="pagin" id="page_string">
    </div>
    

    </div>
  

</body>

</html>

<script>
var loadding_0  ;
var page = 1 ;

$(function () {
	common_request();
});
function common_request(){
	
	var url="<?php echo site_url("newstype/index");?>?inajax=1";
	var data_ = {
		'page':page,
		'time':<?php echo time();?>,
		'action':'ajax_data' 

	} ;
	//console.dir(data_);
	$.ajax({
	type: "POST",
	url: url ,
	data: data_,
	cache:false,
	dataType:"json",
	async:false,
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
				shtml+='<tr id="tr_'+list[i].id+'">';
				shtml+= '<td>'+list[i].id+'</td>' ;
				shtml+='<td>'+list[i]['html']+list[i]['typename']+list[i]['num']+'</td>';
				shtml+='<td >'+list[i]['pid']+'</td>';
				shtml+='<td>'+list[i]['disorder']+'</td>';
				shtml+='<td>'+list[i]['seotitle']+'</td>';
				shtml+='<td>'+list[i]['keywords']+'</td>';
				shtml+='<td>'+list[i]['description']+'</td>';
				shtml+='<td><a href="javascript:void(0)" onclick="add_type('+list[i]['id']+')" >添加栏目</a>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="edit_type('+list[i]['id']+')" >编辑</a></td>';
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
var __add  ; 
function add_type(id){
	__add = $.layer({
	    type: 2,
	    shadeClose: true,
	    title: "添加栏目",
	    closeBtn: [0, true],
	    shade: [0.8, '#000'],
	    border: [1],
	    offset: ['20px',''],
	    area: ['720px','560px'],
	    iframe: {src: "<?php echo site_url("newstype/add");?>?showpage=1&pid="+id}
	}); 
}
var __edit;
function edit_type(id){
	__edit = $.layer({
	    type: 2,
	    shadeClose: true,
	    title: "修改栏目",
	    closeBtn: [0, true],
	    shade: [0.8, '#000'],
	    border: [1],
	    offset: ['20px',''],
	    area: ['720px','560px'],
	    iframe: {src: "<?php echo site_url("newstype/edit");?>?showpage=1&id="+id}
	}); 
}
function close_add_div(){
	layer.close(__add);
}
function close_edit_div(){
	layer.close(__edit);
}
</script> 


