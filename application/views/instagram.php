<link rel="stylesheet" href="<?php echo base_url('/assets/static/css/jquery.simplyscroll.css'); ?>">
<!--link rel="stylesheet" href="http://destinationsmagazine.com/wp-content/themes/destinations/css/jquery.simplyscroll.css"-->

<script src="<?php echo base_url('/assets/static/adminlte/js/jquery-2.2.3.min.js'); ?>"></script>
<script src="<?php echo base_url('/assets/static/js/instafeed.js'); ?>"></script>
<script src="<?php echo base_url('/assets/static/js/jquery.simplyscroll.js'); ?>"></script>
<!--script src="http://destinationsmagazine.com/wp-content/themes/destinations/js/jquery.simplyscroll.min.js"></script-->

<div class="container-fluid no-padding">
	<div class="row-fluid">
		<div class="col-sm-12 no-padding">
			<div id="instafeed-container"><ul id="instafeed"></ul></div>
		</div>
	</div><!-- .row-fluid -->
</div><!-- .container-fluid -->
<?php
/*
{
	"access_token": "3470759226.496a687.656916a996144a67821299b50a7660bd",
	"user": {
		"username": "yusar.chavik",
		"bio": "",
		"website": "",
		"profile_picture": "https://scontent.cdninstagram.com/t51.2885-19/s150x150/13531830_215553315506043_1344919264_a.jpg",
		"full_name": "Yusar Chavik",
		"id": "3470759226"
	}
}
*/

?>
<script type="text/javascript">
(function ($) {
$(function () { //on DOM ready 
    var feed = new Instafeed({
        get: 'user',
		//tagName: 'awesome',
        userId: '3470759226', //'1783172423',
        clientId: '496a68786ba74183b4d878904a8a0f21', //accessToken: '1783172423.6a7999e.9200a29876eb4124aeb8e73352c4f86e',
		accessToken: '3470759226.496a687.656916a996144a67821299b50a7660bd',
        resolution: 'low_resolution',
        limit: '20',
        template: '<li><a href="{{link}}" target="_blank"><img src="{{image}}" width="260" height="260" border="0" /></a></li>'
    });
    feed.run();
    $("#instafeed").simplyScroll({
        startOnLoad: true,
        auto: true,
        speed: 3,
        pauseOnHover: true,
        pauseOnTouch: true
    });
});
})(jQuery);
</script>


<style>
html, body {
	margin: 0;
}
#instafeed {
	padding: 30px;
}
#instafeed.simply-scroll-list li {
	position: relative;
}
/*
#instafeed.simply-scroll-list li:nth-child(3) { left: -40px; }
#instafeed.simply-scroll-list li:nth-child(5) { left: -80px; }
#instafeed.simply-scroll-list li:nth-child(7) { left: -120px; }
#instafeed.simply-scroll-list li:nth-child(9) { left: -160px; }
#instafeed.simply-scroll-list li:nth-child(11) { left: -200px; }
#instafeed.simply-scroll-list li:nth-child(13) { left: -240px; }
#instafeed.simply-scroll-list li:nth-child(15) { left: -280px; }
#instafeed.simply-scroll-list li:nth-child(17) { left: -320px; }
#instafeed.simply-scroll-list li:nth-child(19) { left: -360px; }
#instafeed.simply-scroll-list li:nth-child(21) { left: -400px; }
*/
#instafeed.simply-scroll-list li:nth-child(2n)
{
	padding-top: 20px;
}
/*
#instafeed.simply-scroll-list li:nth-child(2) { left: -20px; }
#instafeed.simply-scroll-list li:nth-child(4) { left: -60px; }
#instafeed.simply-scroll-list li:nth-child(6) { left: -100px; }
#instafeed.simply-scroll-list li:nth-child(8) { left: -140px; }
#instafeed.simply-scroll-list li:nth-child(10) { left: -180px; }
#instafeed.simply-scroll-list li:nth-child(12) { left: -220px; }
#instafeed.simply-scroll-list li:nth-child(14) { left: -260px; }
#instafeed.simply-scroll-list li:nth-child(16) { left: -300px; }
#instafeed.simply-scroll-list li:nth-child(18) { left: -340px; }
#instafeed.simply-scroll-list li:nth-child(20) { left: -380px; }
*/

#instafeed.simply-scroll-list li { transform: rotate(2.75deg); }
#instafeed.simply-scroll-list li:nth-child(2n) { transform: none; }
#instafeed.simply-scroll-list li:nth-child(3n) { transform: rotate(-2.5deg); }
#instafeed.simply-scroll-list li:nth-child(4n) { transform: rotate(3.5deg); }
#instafeed.simply-scroll-list li:nth-child(5n) { transform: rotate(-5.5deg); }


.simply-scroll {
	width:100%;
	height:260px;
	margin-bottom:0;
}
.simply-scroll .simply-scroll-clip {
	width:100%;
	height:360px;
}

.simply-scroll .simply-scroll-list li {
	width: 260px;
	height: 260px;
}
/* image border frame */
/*
.simply-scroll .simply-scroll-list li img {
	padding: 5px;
	background-color: rgba(0,0,0,.2);
}
*/
</style>