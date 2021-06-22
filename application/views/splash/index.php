<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="chrome=1,IE=edge" />
<title><?php echo $splash->post_title; ?></title>
<style>
html {
	height:100%;
}
body {
	background-color:#FFFFFF;
	margin:0;
	height:100%;
}
</style>
<meta name="viewport" content="user-scalable=yes, width=414" />
<?php echo js('jquery-2.2.3.min.js'); ?>
<script>
function redirect(url = '/', sec = 5) {
	setTimeout(function() {
        window.location.href = url
    }, sec*1000);
}
$(document).ready(function(){
<?php echo $splash->post_content; ?>

});
</script>
</head>
<body>
<iframe src="<?php echo base_url($splash_attachment->media_thumbnail_path); ?>" frameborder="0" height="100%" width="100%"></iframe>
<!-- text content for search engines: -->
<div style="display:none" aria-hidden=true>
	<div></div>
</div>
<!-- end text content: -->
</body>
</html>