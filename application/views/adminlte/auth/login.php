<!DOCTYPE html>
<html>
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
</head>
<body class="hold-transition login-page skin-blue login-overlay">
<canvas id="c"></canvas>
<style>
@import url("http://fonts.googleapis.com/css?family=Carrois+Gothic");

@font-face {
  font-family: 'matrix-code';
  src: url('http://neilcarpenter.com/demos/canvas/matrix/font/matrix-code.eot?#iefix') format('embedded-opentype'), 
       url('http://neilcarpenter.com/demos/canvas/matrix/font/matrix-code.woff') format('woff'), 
       url('http://neilcarpenter.com/demos/canvas/matrix/font/matrix-code.ttf')  format('truetype'),
       url('http://neilcarpenter.com/demos/canvas/matrix/font/matrix-code.svg#svgFontName') format('svg');
}

html, body {
    -webkit-font-smoothing: antialiased;
    font: normal 12px/14px "Carrois Gothic", sans-serif;
    width: 100%;
    height: 100%;
    margin: 0;
    overflow: hidden;
    color: #fff;

    -webkit-user-select: none;
       -moz-user-select: none;
        -ms-user-select: none;
            user-select: none; 
}

body {
  background: black;
}

#stats {
    z-index: 100;
}

#info {
    background: rgba(0, 0, 0, 0.7);
    position: fixed;
    bottom: 0;
    left: 0px;
    width: 250px;
    padding: 10px 20px 20px;
    z-index: 100;
    -webkit-transform-origin: bottom center;
       -moz-transform-origin: bottom center;
         -o-transform-origin: bottom center;
            transform-origin: bottom center;
    -webkit-transform: rotate(0deg);
       -moz-transform: rotate(0deg);
         -o-transform: rotate(0deg);
            transform: rotate(0deg);
    -webkit-transition: -webkit-transform .5s ease-in-out;
       -moz-transition:    -moz-transform .5s ease-in-out;
         -o-transition:      -o-transform .5s ease-in-out;
            transition:         transform .5s ease-in-out;
}

#info.closed {
    -webkit-transform: rotate(180deg);
       -moz-transform: rotate(180deg);
         -o-transform: rotate(180deg);
            transform: rotate(180deg);
}

.toggle-info {
    position: absolute;
    display: block;
    height: 10px;
    background: rgba(0, 0, 0, 0.8);
    width: 290px;
    left: 0;
    text-align: center;
    padding: 3px 0 7px;
    text-decoration: none;
    color: white;
    text-shadow: none;
}
.toggle-info:hover {
  background: rgb(0, 0, 0);
}

#close {
    top: -20px;
}

#open {
    bottom: -20px;
    -webkit-transform: rotate(-180deg);
       -moz-transform: rotate(-180deg);
         -o-transform: rotate(-180deg);
            transform: rotate(-180deg);
}

button {
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
    border: 0;
    border-radius: 2px;
    padding: 7px 10px;
    box-shadow: 0 0 3px 0px rgba(255,255,255, 0.3);
    cursor: pointer;
}
button:hover {
    background: rgba(255, 255, 255, 0.1);
}

p a {
    color: #fff;
}
p a:hover {
  color: #EFFDEB;
  text-shadow: 0px 0px 5px #75AD61;
}
</style>
<script>
var c = document.getElementById("c");
var ctx = c.getContext("2d");

//making the canvas full screen
c.height = window.innerHeight;
c.width = window.innerWidth;

//chinese characters - taken from the unicode charset
var chinese = "田由甲申甴电甶男甸甹町画甼甽甾甿畀畁畂畃畄畅畆畇畈畉畊畋界畍畎畏畐畑";
//converting the string into an array of single characters
chinese = chinese.split("");

var font_size = 10;
var columns = c.width/font_size; //number of columns for the rain
//an array of drops - one per column
var drops = [];
//x below is the x coordinate
//1 = y co-ordinate of the drop(same for every drop initially)
for(var x = 0; x < columns; x++)
	drops[x] = 1; 

//drawing the characters
function draw()
{
	//Black BG for the canvas
	//translucent BG to show trail
	ctx.fillStyle = "rgba(0, 0, 0, 0.05)";
	ctx.fillRect(0, 0, c.width, c.height);
	
	ctx.fillStyle = "#0F0"; //green text
	ctx.font = font_size + "px arial";
	//looping over drops
	for(var i = 0; i < drops.length; i++)
	{
		//a random chinese character to print
		var text = chinese[Math.floor(Math.random()*chinese.length)];
		//x = i*font_size, y = value of drops[i]*font_size
		ctx.fillText(text, i*font_size, drops[i]*font_size);
		
		//sending the drop back to the top randomly after it has crossed the screen
		//adding a randomness to the reset to make the drops scattered on the Y axis
		if(drops[i]*font_size > c.height && Math.random() > 0.975)
			drops[i] = 0;
		
		//incrementing Y coordinate
		drops[i]++;
	}
}

setInterval(draw, 33);


</script>

<?php // echo analytics_tracking(); ?>
<div class="login-box">
  <div class="login-logo">
    <a href="<?php echo base_url('/'); ?>">CUSTOM FRAMEWORK</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"><?php // echo info_message(); ?></p>

    <form action="<?php echo base_url('/auth/login'); ?>" method="post">
      <div class="form-group has-feedback">
        <input id="identity" name="identity" type="email" class="form-control" placeholder="Email" autocomplete="off">
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
