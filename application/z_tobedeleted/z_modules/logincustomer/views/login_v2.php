<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?=konf()['nama_perusahaan'];?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="<?=base_url('assets/aplikasi/'.konfigMedia('Vavicon')['nama_file']);?>"/>
	<link rel="stylesheet" type="text/css" href="<?=base_url();?>theme_login/login_v2/blur-background-login-form.css">
	<link href="http://infiniteiotdevices.com/images/logo.png" rel="icon" sizes="16x16" type="image/gif" />
</head>
<body> 
	<div class="bg"></div>
	<div class="container">
			<div class="formBox">
				<h1>Login Pengguna</h1>
				<form action="<?=base_url('login/loginadmin');?>" method="POST">
					<p>Username</p>
					<input type="text" name="username" placeholder="Username">
					<p>Password</p>
					<input type="password" name="pass" placeholder="••••••••">
					<input type="submit" name="submit" value="Sign In">
				</form>
			</div>
		</div>
	</div>
</body>
</html>