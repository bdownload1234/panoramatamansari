<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?=$konf['nama_perusahaan'];?></title>
	<link rel="stylesheet" type="text/css" href="theme_login/login_v2/blur-background-login-form.css">
	<link href="<?=base_url('berkas_user/vavicon.png');?>" rel="icon" sizes="16x16" type="image/gif" />
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
					<input type="Password" name="pass" placeholder="••••••••">
					<input type="submit" name="submit" value="Sign In">
				</form>
			</div>
		</div>
	</div>
</body>
</html>