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
--站点缓存更新</title>
<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>jquery.js"></script>
<link href="<?php echo _CSSPATH_ ; ?>style.css" rel="stylesheet" type="text/css" />
</head>

<body>

	
    
    <div class="formbody">
    <form action="<?php echo  site_url("cache/index") ; ?>?action=updateCache" method="post">
    <div class="formtitle"><span>网站缓存更新</span></div>
     
    <ul class="forminfo">
    <li ><label>全选:<input type="checkbox" value="" id="all"></label></li>
	<?php 
		if(isset($this->cache_type) && $this->cache_type){
			foreach($this->cache_type as $c_key =>$c_val){
		
	?>
    <li style="margin-bottom:0px ;">
    <label><?php echo $c_val['name'];?></label><input style="width:10px" name="cache[]" value="<?php echo $c_key ;?>" type="checkbox" class="dfinput" />
    </li>   
    <?php 
    	}
    }	
    ?>
 
    <li><label>&nbsp;</label><input name="" type="submit" id="btn" class="btn" value="更新缓存"/></li>
    </ul>
    
    </form>
    </div>


</body>

</html>

<script>
	$(function(){
		$("#all").click(function(){
			var c = $(this).attr("checked") ;
				
		    $("input[name='cache[]']").each(function(){
				$(this).attr("checked" , c ) ; 
			});
		});
		
	
	}) ; 


	
</script>
