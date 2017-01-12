<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>左边菜单</title>
<link href="<?php echo _CSSPATH_ ; ?>style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="<?php echo _JSPATH_ ;?>jquery.js"></script>

<script type="text/javascript">
$(function(){	
	//导航切换
	$(".menuson li").click(function(){
		$(".menuson li.active").removeClass("active")
		$(this).addClass("active");
	});
	
	$('.title').click(function(){
		var $ul = $(this).next('ul');
		//$('dd').find('ul').slideUp();
		if($ul.is(':visible')){
			$(this).next('ul').slideUp();
		}else{
			$(this).next('ul').slideDown();
		}
	});
})	
</script>


</head>

<body style="background:#f0f9fd;">
	<div class="lefttop"><span></span>后台系统</div>
    <?php 
    	if(isset($nav) && $nav ){
    		foreach($nav as $nav_key => $nav_val) {
				
    ?>
    <dl class="leftmenu" id="menu_<?php echo $nav_val['id']; ?>"  <?php if($nav_key > 0 ){?>style="display:none" <?php }?>>
     <?php 
    		if(isset($nav_val['items']) && $nav_val['items']){
				foreach($nav_val['items'] as $items_key => $items_vv ){
						if(substr($items_vv['url'],-1) == '/'){
							$items_vv['url']= substr($items_vv['url'],0,-1) ;
						}
						if(!in_array($items_vv['url'] , $this->_url_data) && $this->isJudgeUrl ){
							continue ;
						}
    ?>
    <dd>
    <div class="title">
    <span><img src="<?php echo _IMGPATH_ ; ?>leftico01.png" /></span><?php echo $items_vv['name'];?>
    </div>
    	<ul class="menuson">
    		<?php if(isset($items_vv['items']) && $items_vv['items']){
    			foreach($items_vv['items'] as $last_key => $last_val){
					
					if(substr($last_val['url'],-1) == '/'){
						$last_val['url']= substr($last_val['url'],0,-1) ;
					}
					if(!in_array($last_val['url'] , $this->_url_data)  && $this->isJudgeUrl){
								continue ;
					}
    		?>
    	<li><cite></cite><a href="<?php echo site_url($last_val['url']);?>" target="rightFrame"><?php echo $last_val['name'];?></a><i></i></li>
    	<?php 
		    	}
		    }
    	?>
        
        </ul>    
    </dd>
    <?php 
			}
		}
	?>
    </dl>
    <?php 
    	}
    }	
    ?>
</body>
</html>
