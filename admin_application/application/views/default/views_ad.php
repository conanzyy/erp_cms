<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo isset($this->site_config['web_site_name'])?$this->site_config['web_site_name']:'';?>-------后台操作日志管理</title>
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
  
    <li>广告管理</li>
    </ul>
    </div>
    
    <div class="rightinfo">
 	<div class="tools">
    
    	<ul class="toolbar">
        	<li class="click"><span><img src="<?php echo  _IMGPATH_ ;?>t01.png" /></span><a href="<?php echo site_url("ad/add") ; ?>" target="">添加广告</a></li>
        </ul>

    </div>
    
  <ul class="seachform" style="margin-left:4%">
    
    <li><label>广告位置：</label>
    <select name="typeid"  id="typeid">
    <option>请选择</option>
   		<?php 
   			if(isset($list) && $list){
   			 	foreach ($list as $k => $v ){
   			
   		?>
   		<option value="<?php echo $v['id'] ; ?>"><?php echo $v['typename'] ; ?></option>
   		<?php } }?>
    </select>
    
    </li>

   <li><label>广告名字：</label>
   <input class="scinput" type="text" name="name" id="name">
   </li>
   <li><label>广告类型：</label>
   <select name="type"  id="type">
   	<option value="all">请选择</option>
   	<option value="0">图片广告</option>
   	<option value="1">文字广告</option>
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
    <table class="tablelist">
    	<thead>
    	<tr>
        <th>编号<i class="sort" field="id" orderby = "desc"  style="cursor:pointer" ><img src="<?php echo  _IMGPATH_ ;?>/px.gif" /></i></th>
        <th>广告名字</th>
        <th>广告位置</th>
        <th>广告类型</th>
        <th >链接地址</th>
        <th >开始日期</th>
        <th >结束日期</th>
        <th>状态</th>
        
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
	
	var url="<?php echo site_url("ad/index");?>?inajax=1";
	var data_ = {
		'page':page,
		'time':<?php echo time();?>,
		'action':'ajax_data' , 
		'typeid':$("select[name='typeid']").val() , 
		'name':$("input[name='name']").val() , 
		'status':$("select[name='status']").val() ,
		'type':$("select[name='type']").val() 
		
		
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
				shtml+='<td>'+list[i]['name']+'</td>';
				shtml+='<td>'+list[i]['typename']+'</td>';
				shtml+='<td >'+list[i]['type']+'</td>';
				shtml+='<td>'+list[i]['pic_url']+'</td>';
				shtml+='<td>'+list[i]['begin_date']+'</td>';
				shtml+='<td>'+list[i]['end_date']+'</td>';
				shtml+='<td>'+list[i]['status']+'</td>';
				shtml+='<td><a href="javascript:void(0)" onclick="del(this ,'+list[i]['id']+' )" >删除</a>&nbsp;&nbsp;<a href="<?php echo site_url('ad/edit')?>?id='+list[i]['id']+'" >编辑</a></td>';
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
	        		url: "<?php echo site_url("ad/del")?>?inajax=1" ,
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


</script> 


