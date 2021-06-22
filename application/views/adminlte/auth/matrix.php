﻿<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Matrix Rain</title>
	<!-- Note: running this exported project from disk may not work exactly like preview, since browsers block some features on the file:// protocol.  Once you've uploaded it to a server, it should work OK. -->
	
	<!-- Allow fullscreen mode on iOS devices. (These are Apple specific meta tags.) -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densitydpi=device-dpi" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta name="HandheldFriendly" content="true" />

    <!-- All margins and padding must be zero for the canvas to fill the screen. -->
	<style type="text/css">
		* {
			padding: 0;
			margin: 0;
		}
		body {
			background: #000;
			color: #fff;
			overflow: hidden;
		}
		canvas {
			position: fixed;
		}
    </style>
</head> 
 
<body> 
	<div id="fb-root"></div>
	
	<!-- The canvas must be inside a div called c2canvasdiv -->
	<div id="c2canvasdiv">
	
		<!-- The canvas the project will render to.  If you change its ID, don't forget to change the
		ID the runtime looks for in the jQuery events above (ready() and cr_sizeCanvas()). -->
		<canvas id="c2canvas" width="960" height="640">
			<!-- This text is displayed if the visitor's browser does not support HTML5.
			You can change it, but it is a good idea to link to a description of a browser
			and provide some links to download some popular HTML5-compatible browsers. -->
			<h1>Your browser does not appear to support HTML5.  Try upgrading your browser to the latest version.  <a href="http://www.whatbrowser.org">What is a browser?</a>
			<br/><br/><a href="http://www.microsoft.com/windows/internet-explorer/default.aspx">Microsoft Internet Explorer</a><br/>
			<a href="http://www.mozilla.com/firefox/">Mozilla Firefox</a><br/>
			<a href="http://www.google.com/chrome/">Google Chrome</a><br/>
			<a href="http://www.apple.com/safari/download/">Apple Safari</a><br/>
			<a href="http://www.google.com/chromeframe">Google Chrome Frame for Internet Explorer</a><br/></h1>
		</canvas>
		
	</div>
	
	<!-- Pages load faster with scripts at the bottom -->
	
	<!-- Construct 2 exported games require jQuery.  To save bandwidth, by default
	this is set to grab it off the Google content delivery network (CDN). Fall back to local if not available. -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script>window.jQuery || document.write("<script src='jquery-1.7.1.min.js'>\x3C/script>")</script>


	
    <!-- The runtime script.  You can rename it, but don't forget to rename the reference here as well.
    This file will have been minified and obfuscated if you enabled "Minify script" during export. -->
	<!--script src="c2runtime.js"></script-->

    <script>
		// Size the canvas to fill the browser viewport.
		jQuery(window).resize(function() {
			cr_sizeCanvas(jQuery(window).width(), jQuery(window).height());
		});
		
		window.addEventListener('orientationchange', cr_sizeCanvas, false);
	
		// Start the Construct 2 project running on window load.
		jQuery(document).ready(function ()
		{			
			// Create new runtime using the c2canvas
			cr.createRuntime("c2canvas");
			
			cr_sizeCanvas(jQuery(window).width(), jQuery(window).height());
		});
		
		// Pause and resume on page becoming visible/invisible
		function onVisibilityChanged() {
			if (document.hidden || document.mozHidden || document.webkitHidden || document.msHidden)
				cr_setSuspended(true);
			else
				cr_setSuspended(false);
		};
		
		document.addEventListener("visibilitychange", onVisibilityChanged, false);
		document.addEventListener("mozvisibilitychange", onVisibilityChanged, false);
		document.addEventListener("webkitvisibilitychange", onVisibilityChanged, false);
		document.addEventListener("msvisibilitychange", onVisibilityChanged, false);
		
    </script>
</body> 
</html> 