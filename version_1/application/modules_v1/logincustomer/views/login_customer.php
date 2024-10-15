<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?=base_url('theme_login/customer/');?>fonts/icomoon/style.css">

    <link rel="stylesheet" href="<?=base_url('theme_login/customer/');?>css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=base_url('theme_login/customer/');?>css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="<?=base_url('theme_login/customer/');?>css/style.css">

    <title>Customer Pesona Tamansari</title>
  </head>
  <body>
  

  <div class="d-lg-flex half">
    <div class="bg order-1 order-md-2" style="background-image: url('<?=base_url('theme_login/customer/');?>images/Gerbang_Utama.jpg');"></div>
    <div class="contents order-2 order-md-1">

      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-7">
            <h3>Login to <strong>Customer</strong></h3>
            <p class="mb-4">Login Customer PESONA TAMANSARI. <br>
          PAstikan anda telah menerima user dan password aktivasi dari admin kami. </p>
          <form class="login100-form validate-form" action="<?=base_url('logincustomer/login');?>" method="POST">
              <div class="form-group first">
                <label for="username">Email</label>
                <input type="text" class="form-control" name="email" id="email">
              </div>
              <div class="form-group last mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="pass" id="pass">
              </div>
              
              <div class="d-flex mb-5 align-items-center">
                <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                  <input type="checkbox" checked="checked"/>
                  <div class="control__indicator"></div>
                </label>
              </div>

              <input type="submit" value="Log In" class="btn btn-block btn-primary">

            </form>
          </div>
        </div>
      </div>
    </div>

    
  </div>
    
    

    <script src="<?=base_url('theme_login/customer/');?>js/jquery-3.3.1.min.js"></script>
    <script src="<?=base_url('theme_login/customer/');?>js/popper.min.js"></script>
    <script src="<?=base_url('theme_login/customer/');?>js/bootstrap.min.js"></script>
    <script src="<?=base_url('theme_login/customer/');?>js/main.js"></script>
  </body>
</html>