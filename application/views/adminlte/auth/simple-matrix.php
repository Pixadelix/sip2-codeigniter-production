
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin Pixadelix | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
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
<style>
@font-face {
  font-family: 'matrix-code';
  src: url('/www/app/assets/static/adminlte/fonts/matrix-code.eot?#iefix') format('embedded-opentype'), 
       url('/www/app/assets/static/adminlte/fonts/matrix-code.woff') format('woff'), 
       url('/www/app/assets/static/adminlte/fonts/matrix-code.ttf')  format('truetype'),
       url('/www/app/assets/static/adminlte/fonts/matrix-code.svg#svgFontName') format('svg');
}

div.matrix pre {
	font-family: 'matrix-code';
	font-weight: 700;
	ont-size: 20px;
    -webkit-font-smoothing: antialiased;
    width: 100%;
    height: 100%;
    margin: 0;
    color: #0f0;
	z-index: 998;
	/* overflow: hidden; */
}
pre {
	background-color: inherit !important;
	margin: 0;
	padding: 0;
	border: 0;
	line-height: 1;
	overflow: hidden;
	text-shadow: 0 0 2px rgba(0,255,0,.8) , 0 0 4px rgba(0,255,0,.8) , 0 0 18px rgba(0,255,0,1);
	
	font-size: inherit;
}

.login-logo a, a, .icheck, p.login-box-msg, p {
	color: #0f0;
}

* {
	margin:0;
	padding:0;
	overflow:hidden;
	-webkit-user-select: none;
       -moz-user-select: none;
        -ms-user-select: none;
            user-select: none; 
}

div.matrix {
	width: 1em;
	position:absolute;
	line-height:1;
	
}

.login-box {
	overflow: hidden;
	z-index: 9999;
}

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

.login-overlay {
	background-color: rgba(0,0,0,.7);
	width: 100%;
	height: 100%;
}

</style>

<script>
w = window;
n = w.innerWidth;
m = w.innerHeight;
d = document;
q = "px";

function z(a, b) {
    return Math.floor(Math.random() * (b - a) + a)
}
f = " 0123456789";
for (i = 0; i < 45; i++) {
	f += String.fromCharCode(i + 65393);
	console.log(f);
}

function g() {
    for (i = 0; i < 90; i++) {
        r = d.createElement("div");
        r.className = 'matrix';
        for (j = z(20, 50); j; j--) {
            x = d.createElement("pre");
            y = d.createTextNode(f[z(0, 46)]);
			console.log(y);
            x.appendChild(y);
            x.style.opacity = 0;
            r.appendChild(x)
        }
        r.id = "r" + i;
        r.t = z(-99, 0);
        with(r.style) {
            left = z(0, n) + q;
            top = z(-m, 0) + q;
            fontSize = z(10, 35) + q;
			console.log(fontSize);
        }
        d.body.appendChild(r);
        setInterval("u(" + i + ")", z(60, 120))
    }
}

function u(j) {
    e = d.getElementById("r" + j);
    c = e.childNodes;
    t = e.t + 1;
    if ((v = t - c.length - 50) > 0) {
        if ((e.style.opacity = 1 - v / 32) == 0) {
            for (f in c)
                if (c[f].style) c[f].style.opacity = 0;
            with(e.style) {
                left = z(0, n) + q;
                top = z(-m / 2, m / 2) + q;
                opacity = 1
            }
            t = -50
        }
    }
    e.t = t;
    if (t < 0 || t > c.length + 12) return;
    for (f = t; f && f > t - 12; f--) {
        s = 1 - (t - f) / 16;
        if (f < c.length && c[f].style) {
            c[f].style.opacity = s;
        }
    }
}
</script>

<body text="#0f0" bgcolor="#000" onload="g()"  class="hold-transition skin-blue">

<div class="login-page">
	<div class="login-overlay"></div>
</div>

<div class="login-box">
	<div class="login-logo">
		<a href="<?php echo base_url('/'); ?>">CUSTOM FRAMEWORK</a>
	</div>
	<!-- /.login-logo -->
	<div class="login-box-body">
		<p class="login-box-msg"><?php echo (isset($message) ? $message : ''); ?></p>

		<form action="<?php echo base_url('/auth/login'); ?>" method="post">
			<div class="form-group has-feedback">
				<input id="identity" name="identity" type="email" class="form-control" placeholder="Email">
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