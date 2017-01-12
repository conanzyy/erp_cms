<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo isset($this->site_config['web_site_name'])?$this->site_config['web_site_name']:'';?>-------广告类型管理</title>
<link href="<?php echo _CSSPATH_ ; ?>style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>jquery.js"></script>
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
    <li><a href="#">首页</a></li>
    <li><a href="#">广告位置</a></li>
    
    </ul>
    </div>
    
    <div class="rightinfo">
    
    <div class="tools">
    
    	<ul class="toolbar">
        <li class="click" onclick="add()"><span><img src="<?php echo  _IMGPATH_ ;?>t01.png" /></span>添加</li>
        </ul>

    </div>
    
    <ul class="seachform" style="margin-left:4%">
    
    <li><label>编号：</label>
     <input class="scinput" type="text" name="id" id="id">
    
    </li>

   <li><label>类别名称：</label>
   <input class="scinput" type="text" name="typename" id="typename">
   <select name="condition" id="condition">
  
   	<option value="1">模糊搜索like</option>
   	<option value="2">精确搜索</option>
   </select>
   </li>
  
   <li><label>状态：</label>
   <select name="status" id="status">
   	<option value="all">请选择</option>
   	<option value="1">开启</option>
   	<option value="0">关闭</option>
   </select>
   </li>
    <li><label>&nbsp;</label><input name="" onclick="search()" type="button" class="scbtn" value="查询"/></li>
    </ul>
   
    <div class="tips">
    <span><img src="<?php echo _IMGPATH_ ; ?>tip.png" alt="友情提示" /></span>
    <b><?php echo $this->visitor['username'];?>你好，欢迎使用<?php echo isset($this->site_config['web_site_name'])?$this->site_config['web_site_name']:'' ; ?></b> ,此处是网站常用的广告位置！！请须知</b> 
    
    </div>
    <table class="tablelist">
    	<thead>
    	<tr>
        <th><input name="" type="checkbox" value="" checked="checked"/></th>
        <th>编号</th>
        <th>类别名称</th>
        <th>添加日期</th>
        <th>状态</th>
       
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
    

</body>

</html>

<script>
var loadding_0  ;
$(function () {
	common_request(1);
});
function common_request(page){
	var url="<?php echo site_url("adtype/index");?>?inajax=1";
	var data_ = {
		'page':page,
		'time':<?php echo time();?>,
		'action':'ajax_data' , 
		'id':$("#id").val(),
		'typename':$("#typename").val(),
		'status':$("#status").val(),
		'condition':$("#condition").val()
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
				shtml+='<td><input attr-edit="attr" field="typename" id='+list[i].id+' old-val='+list[i]['typename']+' type="text" style="height:26px"  name="typename" class="scinput" value='+list[i]['typename']+'></td>';
				shtml+='<td>'+list[i]['addtime']+'</td>';
				if(list[i]['status'] == 1 ){
					shtml+='<td attr-id='+list[i].id+'  class="onoff" style="text-indent:0;"><label for="1" class="cb-enable selected" title="开启" style="margin-left:11px;"><span>开启</span></label><label for="0" class="cb-disable" title="关闭"><span>关闭</span></label></td>';
				
				}else{
					shtml+='<td attr-id='+list[i].id+'  class="onoff"  style="text-indent:0;"><label for="1" class="cb-enable " title="开启" style="margin-left:11px;"><span>开启</span></label><label for="0" class="cb-disable selected" title="关闭"><span>关闭</span></label></td>';
				
				}
				
				shtml+='<td>'+list[i]['updatetime']+'</td>';
				shtml+='<td><a href="javascript:void(0)" onclick="useAd('+list[i].id+')" class="tablelink">调用</a>&nbsp;&nbsp;<a href="<?php echo site_url('ad/add');?>?typeid='+list[i].id+'" class="tablelink">添加广告</a></td>';
				shtml+='</tr>';
			}
			$("#result_").html(shtml);
			$("#page_string").html(msg.resultinfo.obj);
			edit_bind() ;
			edit_status_bind() ; 
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
//添加广告类型
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
	    iframe: {src: "<?php echo site_url("adtype/add");?>?showpage=1"}
	}); 
}
function edit_bind(){
	$("#result_ input").each(function(){
		$(this).blur(function(){
			var v = $(this).val();
			if(v == '' ){
				return ; 
			}
			if(v == $(this).attr("old-val")){
				return ;
			}
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("adtype/edit") ; ?>?inajax=1" ,
				data: {action:"doedit"  , field:$(this).attr("field") , value:v , id:$(this).attr("id")},
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
						layer.msg(msg.resultinfo.errmsg);
						return false ;
					}else{
					
						
					}
					layer.close(loadding_0);
				},
				beforeSend:function(){
					 loadding_0 = layer.load('数据正在处理中。。。。。。'); 
				},
				error:function(){
					layer.msg('服务器繁忙请稍后');
					return false ;
				}
				});
		});
	});
}


function edit_status_bind(){
	$("#result_ .onoff label").each(function(){
			$(this).click(function(){
				var id = $(this).parent().attr("attr-id");
				var value = $(this).attr("for");
				var label = $(this) ;
				
				$.ajax({
					type: "POST",
					url: "<?php echo site_url("adtype/edit") ; ?>?inajax=1" ,
					data: {action:"doedit"  , field:"status" , value:value , id:id},
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
							layer.msg(msg.resultinfo.errmsg);
							return false ;
						}else{
						//修改成功
							label.siblings().removeClass("selected");
							label.addClass("selected");
							
						}
						layer.close(loadding_0);
					},
					beforeSend:function(){
						 loadding_0 = layer.load('数据正在处理中。。。。。。'); 
					},
					error:function(){
						layer.msg('服务器繁忙请稍后');
						return false ;
					}
					});
			});
	});
}

//搜索
function search(){
	common_request(1);
}
//调用广告
function useAd(id){
	var pageii = $.layer({
	    type: 1,
	    title: false,
	    area: ['auto', 'auto'],
	    border: [1], //去掉默认边框
	    shade: [1], //去掉遮罩
	    closeBtn: [0, true], //去掉默认关闭按钮
	    shift: 'left', //从左动画弹出
	    page: {
	        html: '<div style="width:420px; height:120px; padding:20px; border:1px solid #ccc; background-color:#eee;"><p>广告调用方式:$this->load_ad('+id+' , 1) ;<br/>必须继承基类：HomeCommon 或者是 UsersCommon 即可 </p><p>1：第一个参数是 广告位置ID</p><p>2：第2个参数是调用的数据条数</p><p>3：返回值是数组的形式！</p></div>'
	    }
	});
}
</script> 
