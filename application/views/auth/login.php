<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SIPv2.0.0 MEDIAVISTA | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <style>
  .login-logo, .login-logo a {
	font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;
  }
  .login-page {
	  background: #fff !important;
  }
  .login-box-body {
	  box-shadow: 1px 1px 3px 1px rgba(0, 0, 0, 0.25)
  }
  </style>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url('/assets/static/adminlte/css/bootstrap.min.css'); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('/assets/static/adminlte/css/AdminLTE.min.css'); ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url('/assets/static/adminlte/plugins/iCheck/all.css'); ?>">
  
  <link rel="shortcut icon" href="/favico.ico">
  
  <link rel="stylesheet" href="<?php echo base_url('/assets/static/adminlte/css/skins/_all-skins.min.css'); ?>">
  
  <link rel="stylesheet" href="<?php echo base_url('/assets/static/adminlte/css/admin.pixadelix.css'); ?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page skin-blue">
<?php // echo analytics_tracking(); ?>
<div class="login-box">
  <div class="login-logo">
	<img src="/assets/static/img/logo-200x50.png"><br/>
    <a href="<?php echo base_url('/'); ?>">
		<b>SIP</b>v2.0.0
	</a>
	
  </div>

  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"><?php // echo info_message(); ?></p>

    <form action="<?php echo base_url('/auth/login'); ?>" method="post">
      <div class="form-group has-feedback">
        <input id="identity" name="identity" type="email" class="form-control" placeholder="Email">
        <span class="fa fa-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input id="password" name="password" type="password" class="form-control" placeholder="Password">
        <span class="fa fa-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input id="remember" name="remember" type="checkbox" value="1"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <a href="<?php echo base_url('auth/forgot_password'); ?>">I forgot my password</a><br>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url('/assets/static/adminlte/js/jquery-2.2.3.min.js'); ?>"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url('/assets/static/adminlte/js/bootstrap.min.js'); ?>"></script>
<!-- iCheck -->
<script src="<?php echo base_url('/assets/static/adminlte/js/icheck.min.js'); ?>"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-purple',
      radioClass: 'iradio_square-purple',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
