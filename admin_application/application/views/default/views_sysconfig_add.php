<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>后台系统环境变量添加</title>
    <meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/Css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/Css/bootstrap-responsive.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/assets/css/dpl-min.css" /> 
	<link href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/assets/css/bui-min.css" rel="stylesheet" type="text/css" />

	<script type="text/javascript" src="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/assets/js/jquery-1.8.1.min.js"></script> 	
	<script type="text/javascript" src="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/assets/js/bui-min.js"></script>
	<script type="text/javascript" src="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/Js/validate/validator.js"></script>
    <style type="text/css">
        body {
            padding-bottom: 40px;
        }
        .sidebar-nav {
            padding: 9px 0;
        }

        @media (max-width: 980px) {
            /* Enable use of floated navbar text */
            .navbar-text.pull-right {
                float: none;
                padding-left: 5px;
                padding-right: 5px;
            }
        }


    </style>
</head>
<body>

<form action="<?php echo site_url("sysconfig/add");?>" method="post" class="definewidth m2"  name="myform" id="myform">
<table class="table table-bordered table-hover m10">

    <tr>
        <td class="tableleft">所属组:</td>
        <td>
		<select name="gid">
			<?php 
				if(isset($group) && $group){
					foreach($group as $g_=>$v_){
						if($g_ == $gid){continue ;}
			?>
			<option value="<?php echo $g_ ;?>"><?php echo $v_; ?></option>
			<?php 
				}
			}	
			?>
		</select>
		</td>
    </tr>	
    <tr>
        <td class="tableleft">类型</td>
        <td>
		<select id="type" name="type" >
			<?php 
				if(isset($type) && $type){
					foreach($type as $t1_=>$v1_){
					
			?>
			<option value="<?php echo $t1_ ;?>"><?php echo $v1_; ?></option>
			<?php 
				}
			}	
			?>
		</select>
		</td>
    </tr>  
		<tr>
        <td class="tableleft">参数说明:</td>
        <td><textarea name="info"  required="true"></textarea></td>
    </tr>
	<tr>
        <td class="tableleft">参数值:</td>
        <td><input id="value" type="text" name="value" required="true" />如果类型选择为boolean ,此处的值必须填写Y或者N</td>
    </tr>
    <tr>
        <td class="tableleft">变量名:</td>
        <td><input type="text" name="varname" id="name" required="true" errMsg="请输入变量名字，必须是英文" tip="请输入变量名字，必须是英文"/></td>
    </tr>	


 

    <tr>
        <td class="tableleft"></td>
        <td>
            <button type="submit" class="btn btn-primary" type="button" id="btnSave">保存</button> &nbsp;&nbsp;
			 <a class="btn btn-success" href="<?php echo site_url("sysconfig/index");?>">返回</a> &nbsp;&nbsp;
        </td>
    </tr>
</table>
</form>

</body>
</html>

<script>
var value = ['Y','N'] ;
$(function () {       
		$("#btnSave").click(function(){
			if($("#myform").Valid() == false || !$("#myform").Valid()) {
				return false ;
			}
			var type = $("#type").val();
			if(type == 'boolean'){
				if(!in_array($("#value").val(),value)){
					BUI.Message.Alert('对不起参数的值必须是Y或者N','error');
					return false ;
				}
			}
			
		});
});

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
 
</script>
