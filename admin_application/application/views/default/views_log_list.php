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
  
    <li>后台用户管理</li>
    </ul>
    </div>
    
    <div class="rightinfo">
 
    
  <ul class="seachform" style="margin-left:4%">
    
    <li><label>日志表：</label>
    <select name="table"  id="table">
   		<?php 
   			if(isset($table) && $table){
   				foreach ($table as $k => $v ){
   			
   		?>
   		<option value="<?php echo $v ; ?>"><?php echo $v ; ?></option>
   		<?php } }?>
    </select>
    
    </li>

   <li><label>操作url：</label>
   <input class="scinput" type="text" name="log_url" id="log_url">
   </li>
   <li><label>操作者：</label>
   <input class="scinput" type="text" name="log_person" id="log_person">
   </li>
   <li><label>状态：</label>
   <select name="status" id="status">
   	<option value="all">请选择</option>
   	<option value="1">成功</option>
   	<option value="0">失败</option>
   </select>
   </li>
    <li><label>&nbsp;</label><input name="" onclick="search()" type="button" class="scbtn" value="查询"/></li>
    </ul>
    <table class="tablelist">
    	<thead>
    	<tr>
        <th>编号<i class="sort" field="id" orderby = "desc"  style="cursor:pointer" ><img src="<?php echo  _IMGPATH_ ;?>/px.gif" /></i></th>
        <th>用户名</th>
        <th>操作地址</th>
        <th >添加日期  </th>
        <th >操作ip </th>
        <th>状态</th>
        <th>操作sql</th>
        <th>描述</th>
        
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

$(function () {
	common_request();
});
function common_request(){
	if($("select[name='table']").val()== '' || $("select[name='table']").val()== null){
		layer.msg("暂无数据，没有操作日志表");
		return false ;
	}
	var url="<?php echo site_url("log/index");?>?inajax=1";
	var data_ = {
		'page':page,
		'time':<?php echo time();?>,
		'action':'ajax_data' , 
		'log_person':$("input[name='log_person']").val() , 
		'log_url':$("input[name='log_url']").val() , 
		'status':$("select[name='status']").val() ,
		'table':$("select[name='table']").val()
		
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
				shtml+='<tr>';
				shtml+= '<td>'+list[i].log_id+'</td>' ;
				shtml+='<td>'+list[i]['log_person']+'</td>';
				shtml+='<td>'+list[i]['log_url']+'</td>';
				shtml+='<td >'+list[i]['log_time']+'</td>';
				shtml+='<td>'+list[i]['log_ip']+'</td>';
				shtml+='<td>'+list[i]['log_status']+'</td>';
				shtml+='<td><a href="javascript:void(0)" onclick="getsql(this)" attr_sql="'+list[i]['log_sql_all']+'">'+list[i]['log_sql']+'</a></td>';
				shtml+='<td>'+list[i]['log_message']+'</td>';
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
function getsql(o){
	var sql = $(o).attr("attr_sql");
	sql =str_decode(sql);
	layer.tips(sql, o, {
	    style: ['background-color:#78BA32; color:#fff', '#78BA32'],
	    maxWidth:285,
	    time: 5,
	    closeBtn:[0, true]
	});
	
}


</script> 


