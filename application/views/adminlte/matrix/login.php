
<style>

.checkbox.icheck div {
	margin-right: 10px;
}

.enjoy-css {
	font-size: 18px;
	line-height: 40px;
  display: inline-block;
  cursor: pointer;
  
  
  border: 1px solid #0f9b0f;
  -webkit-border-radius: 15px;
  border-radius: 3px;
  color: rgb(255, 255, 255);
  -o-text-overflow: clip;
  text-overflow: clip;
  background: -webkit-linear-gradient(-90deg, rgb(90,190,87) 0, rgb(53,146,56) 100%), rgb(90, 190, 87);
  background: -moz-linear-gradient(180deg, rgb(90,190,87) 0, rgb(53,146,56) 100%), rgb(90, 190, 87);
  background: linear-gradient(180deg, rgb(90,190,87) 0, rgb(53,146,56) 100%), rgb(90, 190, 87);
  -webkit-background-origin: padding-box;
  background-origin: padding-box;
  -webkit-background-clip: border-box;
  background-clip: border-box;
  -webkit-background-size: auto auto;
  background-size: auto auto;
  -webkit-box-shadow: 0 2px 1px 0 rgba(0,0,0,0.3) ;
  box-shadow: 0 2px 1px 0 rgba(0,0,0,0.3) ;
  text-shadow: 0 1px 2px rgb(50,114,40) ;
}

.enjoy-css:hover {
  background: rgb(90, 190, 87);
  -webkit-box-shadow: 0 2px 4px 0 rgba(0,0,0,0.11) ;
  box-shadow: 0 2px 4px 0 rgba(0,0,0,0.11) ;
  -webkit-transition: all 150ms cubic-bezier(0.42, 0, 0.58, 1);
  -moz-transition: all 150ms cubic-bezier(0.42, 0, 0.58, 1);
  -o-transition: all 150ms cubic-bezier(0.42, 0, 0.58, 1);
  transition: all 150ms cubic-bezier(0.42, 0, 0.58, 1);
}

.enjoy-css:active, .enjoy-css:focus {
  outline: none !important;
  border: 1px solid rgba(90,190,87,0.2);
  background: rgba(77,168,74,1);
  -webkit-box-shadow: 0 3px 0 0 rgba(0,0,0,0.1) inset;
  box-shadow: 0 3px 0 0 rgba(0,0,0,0.1) inset;
  -webkit-transition: none;
  -moz-transition: none;
  -o-transition: none;
  transition: none;
}

.blink_me {
	text-shadow: 0 0 10px rgba(0,255,0,.8) , 0 0 20px rgba(0,255,0,.8) , 0 0 30px rgba(0,255,0,1);
}

</style>

<script>

</script>

<body text="#0f0" bgcolor="#000" nload="g()"  class="hold-transition skin-blue">

<div class="matrix-page">
	<div class="matrix-overlay"></div>
</div>

<div class="login-box">
	<div class="login-logo ">
		<a href="<?php echo base_url('/'); ?>"><span class="blink_me">Restricted</span></a>
	</div>
	<!-- /.login-logo -->
	<div class="login-box-body">
		<div class="login-box-msg"><?php echo (isset($message) ? $message : ''); ?></div>

		<form action="<?php echo base_url('/auth/login'); ?>" method="post" autocomplete="off">
			<div class="form-group has-feedback">
				<input id="identity" name="identity" type="email" class="form-control" placeholder="Email" autocomplete="off">
				<span class="fa fa-envelope form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
				<input id="password" name="password" type="password" class="form-control" placeholder="Password">
				<span class="fa fa-lock form-control-feedback"></span>
			</div>
			<div class="col-xs-">
				<button type="submit" class="tn enjoy-css tn-primary btn-block tn-flat">Sign In</button>
			</div>
      
			<div class="checkbox icheck">
				<label>
					<input id="remember" name="remember" type="checkbox" value="1"> Remember Me
				</label>
			</div>
		</form>
		<a href="<?php echo base_url('auth/forgot_password'); ?>">I forgot my password</a><br>
	</div>
	<!-- /.login-box-body -->
</div>
<!-- /.login-box -->

