<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>产品添加</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/Css/style.css" />   
	<script type="text/javascript" src="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/assets/js/jquery-1.8.1.min.js"></script> 	
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

<div class="form-inline definewidth m20" >
   <a  class="btn btn-primary" id="addnew" href="<?php echo site_url("product/index");?>">产品列表</a>
</div>

<?php echo form_open_multipart('product/add');?>
<input type="hidden" name="action" value="doadd">
<table class="table table-bordered table-hover m10">
<input type="hidden" name="typename" id="typename">
    <tr>
        <td class="tableleft">产品名称</td>
        <td><input type="text" name="title" id="rolename" required="true" errMsg="请输入产品名称" tip="请输入产品名称"/></td>
    </tr>
    <tr>
        <td class="tableleft">产品类别</td>
        <td>
			<select name="typeid" onchange="_type()" id="typeid">
				<option value="0">请选择</option>
				<?php 
					if(isset($category_data) && $category_data){
						foreach($category_data as $c_key=>$c_val){
					
				?>
				<option value="<?php echo isset($c_val['id'])?$c_val['id']:'' ;?>"><?php echo str_repeat("&nbsp;",isset($c_val['deep'])?$c_val['deep']*5:0) ;?><?php echo isset($c_val['name'])?$c_val['name']:'' ;?></option>
				<?php 
					}
				}	
				?>
			</select>
		</td>
    </tr>	
    <tr>
        <td class="tableleft">产品图片</td>
        <td><input type="file" name="image" id="image" /></td>
    </tr> 
    <tr>
        <td class="tableleft">地址</td>
        <td><input type="text" name="url" id="" /></td>   
    <tr>
        <td class="tableleft">权重</td>
        <td><input type="text" name="weight" id="image" /></td>
    </tr>
    <tr>
        <td class="tableleft">介绍</td>
        <td><textarea name="introduce"></textarea></td>
    </tr>              
    <tr>
        <td class="tableleft">状态</td>
        <td>
            <input type="radio" name="status" value="1" checked/> 启用
            <input type="radio" name="status" value="0"/> 禁用
        </td>
    </tr>
    <tr>
        <td class="tableleft"></td>
        <td>
            <button type="submit" class="btn btn-primary" type="button" id="btnSave">保存</button> &nbsp;&nbsp;
        </td>
    </tr>
</table>
</form>
</body>
</html>
<script>
$(function () {       
		$("#btnSave").click(function(){
			if($("#myform").Valid() == false || !$("#myform").Valid()) {
				return false ;
			}
		});
});
function _type(){
	$("#typename").val($("#typeid option:selected").text());
}
 
</script>
