<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo isset($this->site_config['web_site_name'])?$this->site_config['web_site_name']:'';?>-------咨询管理</title>
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
  
    <li>新闻咨询管理</li>
    </ul>
    </div>
    
    <div class="rightinfo">
 	<div class="tools">
    
    	<ul class="toolbar">
        	<li class="click"><span><img src="<?php echo  _IMGPATH_ ;?>t01.png" /></span><a href="<?php echo site_url("news/add") ; ?>" target="">添加咨询文章</a></li>
        </ul>

    </div>
    
  <ul class="seachform" style="margin-left:4%">
    
    <li><label>类型：</label>
    <select name="typeid"  id="typeid">
    <option>请选择</option>
   		<?php 
   			if(isset($list) && $list){
   			 	foreach ($list as $k => $v ){
   			
   		?>
   		<option value="<?php echo $v['id'] ; ?>"><?php echo $v['html'] ; ?><?php echo $v['typename'] ; ?></option>
   		<?php } }?>
    </select>
    
    </li>

   <li><label>名称：</label>
   <input class="scinput" type="text" name="title" id="title">
   </li>
 
   <li><label>状态：</label>
   <select name="status" id="status">
   	<option value="all">请选择</option>
   	<option value="1">开启</option>
   	<option value="0">关闭</option>
   </select>
   </li>
     <li><label>属性：</label>
    <select name="flag"  id="flag">
    <option value="">请选择</option>
   		<?php 
   			
   			 	foreach (config_item("content_att")as $kk => $vv ){
   			
   		?>
   		<option value="<?php echo $kk ; ?>"><?php echo $vv ; ?></option>
   		<?php } ?>
    </select>
    
    </li>
    <li><label>&nbsp;</label><input name="" onclick="search()" type="button" class="scbtn" value="查询"/></li>
    </ul>
    <table class="tablelist">
    	<thead>
    	<tr>
        <th>编号<i class="sort" field="id" orderby = "desc"  style="cursor:pointer" ><img src="<?php echo  _IMGPATH_ ;?>/px.gif" /></i></th>
        <th style="width:360px">名称</th>
        <th >缩略图</th>
        <th>关键词</th>
        <th>权重</th>
        <th >添加日期</th>
        <th >添加者</th>
        <th >类型</th>
        <th >点击量</th>
        <th  style="width:143px">状态</th>
        
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
	
	var url="<?php echo site_url("news/index");?>?inajax=1";
	var data_ = {
		'page':page,
		'time':<?php echo time();?>,
		'action':'ajax_data' , 
		'typeid':$("select[name='typeid']").val() , 
		'title':$("input[name='title']").val() , 
		'status':$("select[name='status']").val() ,
		'flag':$("select[name='flag']").val() 
		
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
				shtml+='<td>'+list[i]['title']+list[i]['flag']+'</td>';
				shtml+='<td>'+list[i]['image']+'</td>';
				shtml+='<td>'+list[i]['keysword']+'</td>';
				shtml+='<td >'+list[i]['weight']+'</td>';
				shtml+='<td>'+list[i]['create_date']+'</td>';
				shtml+='<td>'+list[i]['addperson']+'</td>';
				shtml+='<td>'+list[i]['typename']+'</td>';
				shtml+='<td>'+list[i]['click']+'</td>';
				if(list[i]['status'] == 1 ){
					shtml+='<td attr-id='+list[i].id+'  class="onoff" style="text-indent:0;"><label for="1" class="cb-enable selected" title="开启" style="margin-left:11px;"><span>开启</span></label><label for="0" class="cb-disable" title="关闭"><span>关闭</span></label></td>';
				
				}else{
					shtml+='<td attr-id='+list[i].id+'  class="onoff"  style="text-indent:0;"><label for="1" class="cb-enable " title="开启" style="margin-left:11px;"><span>开启</span></label><label for="0" class="cb-disable selected" title="关闭"><span>关闭</span></label></td>';
				
				}
				shtml+='<td><a href="javascript:void(0)" onclick="del(this ,'+list[i]['id']+' )" >删除</a>&nbsp;&nbsp;<a href="<?php echo site_url('news/edit')?>?id='+list[i]['id']+'" >编辑</a></td>';
				shtml+='</tr>';
			}
			$("#result_").html(shtml);
			$("#page_string").html(msg.resultinfo.obj);
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
function ajax_data(p){
	page = p  ; 
	common_request();
}
function search(){
	page = 1 ;
	common_request();
}
function del(o  , id ){
	$.layer({
	    shade: [0],
	    area: ['auto','auto'],
	    dialog: {
	        msg: '删除数据 ， 此操作不可恢复！',
	        btns: 2,                    
	        type: 4,
	        btn: ['确定','取消'],
	        yes: function(){
	        	$.ajax({
	        		type: "POST",
	        		url: "<?php echo site_url("news/del")?>?inajax=1" ,
	        		data: {id:id},
	        		cache:false,
	        		dataType:"json",
	        		async:false,
	        		success: function(msg){
	        			if(msg['resultcode'] == 1 ){
							$("#tr_"+id).remove();
		        		}else{
		        			layer.msg(msg.resultinfo.errmsg);
			        	}
	        			layer.close(loadding_0);
	        		},
	        		beforeSend:function(){
	        			 loadding_0 = layer.load('数据正在处理。。。。。。'); 
	        		},
	        		error:function(){
	        			layer.msg('服务器繁忙请稍后');
	        			return false ;
	        		}
	        		});
	        }, no: function(){
	        	
	        }
	    }
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
					url: "<?php echo site_url("news/edit") ; ?>?inajax=1" ,
					data: {action:"dostatus"  , field:"status" , value:value , id:id},
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

</script> 


