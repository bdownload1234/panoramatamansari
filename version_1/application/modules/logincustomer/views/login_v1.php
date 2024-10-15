<!DOCTYPE html>
<html lang="en">
<head>
	<title><?=$konf['nama_perusahaan'];?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="<?=base_url('assets/aplikasi/'.konfigMedia('Vavicon')['nama_file']);?>"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url('theme_login/login_v1/');?>vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url('theme_login/login_v1/');?>fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url('theme_login/login_v1/');?>fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url('theme_login/login_v1/');?>vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?=base_url('theme_login/login_v1/');?>vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url('theme_login/login_v1/');?>vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url('theme_login/login_v1/');?>css/util.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url('theme_login/login_v1/');?>css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('<?=base_url('theme_login/login_v1/images/img-01.jpg');?>');">
			<div class="wrap-login100 p-t-100 p-b-30">
				<form class="login100-form validate-form" action="<?=base_url('login/loginadmin');?>" method="POST">
					<div class="login100-form-avatar">
						<img src="<?=base_url('assets/aplikasi/'.konfigMedia('Logo login')['nama_file']);?>" alt="AVATAR">
					</div>

					<span class="login100-form-title p-t-20 p-b-45">
						<?=$konf['nama_perusahaan'];?>
					</span>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Username is required">
						<input class="input100" type="text" name="username" placeholder="Username" autocomplete="off">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Password is required">
						<input class="input100" type="password" name="pass" placeholder="Password" autocomplete="off">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock"></i>
						</span>
					</div>

					<div class="container-login100-form-btn p-t-10">
						<button class="login100-form-btn">
							Login
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>


</body>
</html>