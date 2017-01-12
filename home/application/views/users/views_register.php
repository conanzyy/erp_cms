<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo (isset($this->site_config['web_site_name']))?$this->site_config['web_site_name']:'' ;?>____________用户注册</title>
<form action="<?php echo site_url("users/register/doregister")?>" method="post">
<h1>用户注册</h1>
	<div>用户名：<input type="text" name="username" value=""></div>
	<div>密码：<input type="text" name="passwd" value=""></div>
	<div>确认密码：<input type="text" name="repasswd" value=""></div>
	<div><input type="submit" name="" value="提交注册"></div>
</form>
<p>
	<a href="<?php echo site_url("users/login")?>">用户登录</a>
</p>