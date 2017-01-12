<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo (isset($this->site_config['web_site_name']))?$this->site_config['web_site_name']:'' ;?>____________用户登录</title>
<form action="<?php echo site_url("users/login/dologin")?>" method="post">
<h1>用户登录</h1>
	<div>用户名：<input type="text" name="username" value=""></div>
	<div>密码：<input type="text" name="passwd" value=""></div>

	<div><input type="submit" name="" value="登录"></div>
</form>
<p>
	<a href="<?php echo site_url("users/register")?>">注册</a>
</p>