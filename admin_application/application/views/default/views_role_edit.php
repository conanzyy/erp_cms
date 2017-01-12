<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo isset($this->site_config['web_site_name'])?$this->site_config['web_site_name']:'';?>
--编辑<?php echo $info['rolename'];?>权限</title>
<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>jquery.js"></script>
<link href="<?php echo _CSSPATH_ ; ?>style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.dfperm {
    background: url("../images/inputbg.gif") repeat-x scroll 0 0 rgba(0, 0, 0, 0);
    border-color: #A7B5BC #CED9DF #CED9DF #A7B5BC;
    border-style: solid;
    border-width: 1px;
    height: 32px;
    line-height: 32px;
    text-indent: 10px;
    width: 140px;
}
</style>
</head>

<body>

	
    
    <div class="formbody">
    <form action="<?php echo  site_url("role/edit") ; ?>?action=doedit&showpage=1" method="post">
    <input type="hidden" name="id" value="<?php echo $info['id'];?>">
    <div class="formtitle"><span>编辑角色----<?php echo $info['rolename'];?></span></div>
     
    <ul class="forminfo">

    <li><label>角色名称</label><input name="rolename" value="<?php echo $info['rolename'];?>" type="text" class="dfinput" /><i class="">请输入角色名称</i></li>   
    <li><label>状态</label>
    <input type="radio" name="status" value="1" <?php if($info['status'] == 1 ){echo "checked";}?>/> 启用
    <input type="radio" name="status" value="0" <?php if($info['status'] == 0 ){echo "checked";}?>/> 禁用
    </li>
    <li><label>权限如下：</label>
    	
    </li>
    <?php 
    		if(isset($list) && $list){
				$perm_array = array();
				$perm_array = unserialize($info['perm']);
				$perm_array = empty($perm_array)?array():$perm_array;
				//print_r($perm_array);
					
    ?>
   <div>
       



   </div>
    <?php 
    	 }	
    ?>
-------------------------------------------------
     <?php echo makeNavRole($list ,$perm_array);?>
    <li><label>&nbsp;</label><input name="" type="submit" id="btn" class="btn" value="确认保存"/></li>
    </ul>
    
    </form>
    </div>


</body>

</html>

<script>
	$(function(){
		$("#btn").live("click" , function(){
			if(!check_rolename()){
				return false ;
			}else if(!check_disorder()){
				return false ;
			}else if(!check_url()){
				return false ;
			}else{
				return true ; 
			}
			
		});
		$("input[name='rolename']").blur(function(){
			check_rolename() ;
		});
	
	}) ; 

	//检查导航名称
	function check_rolename(){
		var v = $("input[name='rolename']") ; 
		if(v.val() == '' ){
			v.next("i").attr("class" ,"wrong").html("请输入角色名称"); 
			return false ;
		}else{
			v.next("i").attr("class" ,"correct").html("角色名称正确");
			
			return true ; 
		}
		
	}
	/*$("input[name='role[]']").bind("click" , function(){
		//alert($(this).val());
		var path = $(this).attr("path");
		var id = $(this).attr("attrid") ; 
		var parent_id = $(this).attr("parent-id");
		var s = path+"-"+id ; 
		$("input[id^='"+s+"']").attr("checked" , this.checked) ; 
		//修改他的上级选中状态,为选中状态
		var pathArray = path.split("-");
		for(var kk = 0 ; kk<pathArray.length ; kk++){
			$("input[attrid='"+pathArray[kk]+"']").attr("checked" , true) ; 
		}
		
	});
    */
function check_box(o){
    var flag = $(o).find("input").attr("checked");
    if(flag){
       $(o).find("input").attr("checked" , false ); 
    }else{
        $(o).find("input").attr("checked" , true  ); 
    }
    
}	
</script>

<?php 
    function makeNavRole($items , $perm_array){
        static $str = '' ;
       if(isset($items) && $items ){
            foreach($items as $k => $v ){
                $checked = '' ;

                $float = '' ;
                $color = '#CED9DF' ;
                if(in_array( $v['url'], $perm_array)){
                    $checked = 'checked'; 
                    $color = 'red' ;   
                }
                $list = explode("-" , $v['path']);
                $count = count($list) ;
                $margin_left = $count*4+3;

                if($count == 4 ){
                    $float = 'float:left; ';
                }else{
                     $float = 'clear:both';
                 }
                
                $str.="<div style='{$float};width:190px ;border:solid 1px;border-color:{$color}; height:30px;line-height:30px;padding-left:4px;margin:4px;margin-left:{$margin_left}px;cursor:pointer' onclick='check_box(this)'><input $checked type='checkbox'name='role[]' value='{$v['url']}'>{$v['name']}</div>";

                if(isset($v['items']) && $v['items'] ){
                    makeNavRole($v['items'],$perm_array);
                }
                
            }
       }
       return $str ;
    }
?>
