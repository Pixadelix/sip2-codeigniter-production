<html>
<head>
<script>
(function (global, factory) {
	typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() :
	typeof define === 'function' && define.amd ? define(factory) :
	(global.Stats = factory());
}(this, (function () { 'use strict';

/**
 * @author mrdoob / http://mrdoob.com/
 */

var Stats = function () {

	var mode = 0;

	var container = document.createElement( 'div' );
	container.style.cssText = 'position:fixed;top:0;left:0;cursor:pointer;opacity:0.9;z-index:10000';
	container.addEventListener( 'click', function ( event ) {

		event.preventDefault();
		showPanel( ++ mode % container.children.length );

	}, false );

	//

	function addPanel( panel ) {

		container.appendChild( panel.dom );
		return panel;

	}

	function showPanel( id ) {

		for ( var i = 0; i < container.children.length; i ++ ) {

			container.children[ i ].style.display = i === id ? 'block' : 'none';

		}

		mode = id;

	}

	//

	var beginTime = ( performance || Date ).now(), prevTime = beginTime, frames = 0;

	var fpsPanel = addPanel( new Stats.Panel( 'FPS', '#0ff', '#002' ) );
	var msPanel = addPanel( new Stats.Panel( 'MS', '#0f0', '#020' ) );

	if ( self.performance && self.performance.memory ) {

		var memPanel = addPanel( new Stats.Panel( 'MB', '#f08', '#201' ) );

	}

	showPanel( 0 );

	return {

		REVISION: 16,

		dom: container,

		addPanel: addPanel,
		showPanel: showPanel,

		begin: function () {

			beginTime = ( performance || Date ).now();

		},

		end: function () {

			frames ++;

			var time = ( performance || Date ).now();

			msPanel.update( time - beginTime, 200 );

			if ( time > prevTime + 1000 ) {

				fpsPanel.update( ( frames * 1000 ) / ( time - prevTime ), 100 );

				prevTime = time;
				frames = 0;

				if ( memPanel ) {

					var memory = performance.memory;
					memPanel.update( memory.usedJSHeapSize / 1048576, memory.jsHeapSizeLimit / 1048576 );

				}

			}

			return time;

		},

		update: function () {

			beginTime = this.end();

		},

		// Backwards Compatibility

		domElement: container,
		setMode: showPanel

	};

};

Stats.Panel = function ( name, fg, bg ) {

	var min = Infinity, max = 0, round = Math.round;
	var PR = round( window.devicePixelRatio || 1 );

	var WIDTH = 80 * PR, HEIGHT = 48 * PR,
			TEXT_X = 3 * PR, TEXT_Y = 2 * PR,
			GRAPH_X = 3 * PR, GRAPH_Y = 15 * PR,
			GRAPH_WIDTH = 74 * PR, GRAPH_HEIGHT = 30 * PR;

	var canvas = document.createElement( 'canvas' );
	canvas.width = WIDTH;
	canvas.height = HEIGHT;
	canvas.style.cssText = 'width:80px;height:48px';

	var context = canvas.getContext( '2d' );
	context.font = 'bold ' + ( 9 * PR ) + 'px Helvetica,Arial,sans-serif';
	context.textBaseline = 'top';

	context.fillStyle = bg;
	context.fillRect( 0, 0, WIDTH, HEIGHT );

	context.fillStyle = fg;
	context.fillText( name, TEXT_X, TEXT_Y );
	context.fillRect( GRAPH_X, GRAPH_Y, GRAPH_WIDTH, GRAPH_HEIGHT );

	context.fillStyle = bg;
	context.globalAlpha = 0.9;
	context.fillRect( GRAPH_X, GRAPH_Y, GRAPH_WIDTH, GRAPH_HEIGHT );

	return {

		dom: canvas,

		update: function ( value, maxValue ) {

			min = Math.min( min, value );
			max = Math.max( max, value );

			context.fillStyle = bg;
			context.globalAlpha = 1;
			context.fillRect( 0, 0, WIDTH, GRAPH_Y );
			context.fillStyle = fg;
			context.fillText( round( value ) + ' ' + name + ' (' + round( min ) + '-' + round( max ) + ')', TEXT_X, TEXT_Y );

			context.drawImage( canvas, GRAPH_X + PR, GRAPH_Y, GRAPH_WIDTH - PR, GRAPH_HEIGHT, GRAPH_X, GRAPH_Y, GRAPH_WIDTH - PR, GRAPH_HEIGHT );

			context.fillRect( GRAPH_X + GRAPH_WIDTH - PR, GRAPH_Y, PR, GRAPH_HEIGHT );

			context.fillStyle = bg;
			context.globalAlpha = 0.9;
			context.fillRect( GRAPH_X + GRAPH_WIDTH - PR, GRAPH_Y, PR, round( ( 1 - ( value / maxValue ) ) * GRAPH_HEIGHT ) );

		}

	};

};

return Stats;

})));
</script>
<style>
@import url("http://fonts.googleapis.com/css?family=Carrois+Gothic");

@font-face {
  font-family: 'matrix-code';
  src: url('http://neilcarpenter.com/demos/canvas/matrix/font/matrix-code.eot?#iefix') format('embedded-opentype'), 
       url('/www/app/assets/static/adminlte/fonts/matrix-code.woff') format('woff'), 
       url('/www/app/assets/static/adminlte/fonts/matrix-code.ttf')  format('truetype'),
       url('/www/app/assets/static/adminlte/fonts/matrix-code.svg#svgFontName') format('svg');
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
</head>
  
  <body>
		
		<div id="info">
			<p><strong>Matrix code rain</strong></p> 
			<p>Experiment write up <a href="http://neilcarpenter.com/labs/matrix-rain" target="_blank">here</a>.</p>
      
      <!--
      this doesn't work in CodePen for some reason
			<button id="snapshot">Take snapshot</button>
      -->			

			<a href="#" class="toggle-info" id="open">Show info</a>
			<a href="#" class="toggle-info" id="close">Hide info</a>			
		</div>
		
		<canvas id="canvas"></canvas>
		
	</body>
  
  <a href="https://github.com/neilcarpenter/Matrix-code-rain" id="ribbon" target="_blank"><img style="position: absolute; top: 0; right: 0; border: 0; z-index: 50;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_red_aa0000.png" alt="Fork me on GitHub"></a>
<script>
/*

  Matrix code rain

  Demo write up here: http://neilcarpenter.com/labs/matrix-rain

  Uses matrix font: http://www.dafont.com/matrix-code-nfi.font
  and stats.js: https://github.com/mrdoob/stats.js/

  If FPS is super low, try making browser window narrower - crap, I know, will work on it!

*/


// http://paulirish.com/2011/requestanimationframe-for-smart-animating/
// http://my.opera.com/emoller/blog/2011/12/20/requestanimationframe-for-smart-er-animating
 
// requestAnimationFrame polyfill by Erik MÃƒÆ’Ã‚Â¶ller
// fixes from Paul Irish and Tino Zijdel
 
(function() {
    var lastTime = 0;
    var vendors = ['ms', 'moz', 'webkit', 'o'];
    for(var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
        window.requestAnimationFrame = window[vendors[x]+'RequestAnimationFrame'];
        window.cancelAnimationFrame = window[vendors[x]+'CancelAnimationFrame']
                                   || window[vendors[x]+'CancelRequestAnimationFrame'];
    }
 
    if (!window.requestAnimationFrame)
        window.requestAnimationFrame = function(callback, element) {
            var currTime = new Date().getTime();
            var timeToCall = Math.max(0, 16 - (currTime - lastTime));
            var id = window.setTimeout(function() { callback(currTime + timeToCall); },
              timeToCall);
            lastTime = currTime + timeToCall;
            return id;
        };
 
    if (!window.cancelAnimationFrame)
        window.cancelAnimationFrame = function(id) {
            clearTimeout(id);
        };
}());

// stats
var stats = new Stats();
stats.setMode(0);
stats.domElement.style.position = 'absolute';
stats.domElement.style.left = '0px';
stats.domElement.style.top = '0px';
document.body.appendChild( stats.domElement );


var M = {

  settings: {
		COL_WIDTH: 20,
		COL_HEIGHT: 25,
		VELOCITY_PARAMS: {
			min: 4,
			max: 8
		},
		CODE_LENGTH_PARAMS: {
			min: 20,
			max: 40
		}
	},

	animation: null,

	c: null,
	ctx: null,

	lineC: null,
	ctx2: null,

	WIDTH: window.innerWidth,
	HEIGHT: window.innerHeight,

	COLUMNS: null,
	canvii: [],

	// font from here http://www.dafont.com/matrix-code-nfi.font
	font: '30px matrix-code',
	letters: ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '$', '+', '-', '*', '/', '=', '%', '"', '\'', '#', '&', '_', '(', ')', ',', '.', ';', ':', '?', '!', '\\', '|', '{', '}', '<', '>', '[', ']', '^', '~'],
	
	codes: [],

	createCodeLoop: null,
	codesCounter: 0,

	init: function () {
		M.c = document.getElementById( 'canvas' );
		M.ctx = M.c.getContext( '2d' );
		M.c.width = M.WIDTH;
		M.c.height = M.HEIGHT;

		M.ctx.shadowBlur = 0;
		M.ctx.fillStyle = '#000';
		M.ctx.fillRect(0, 0, M.WIDTH, M.HEIGHT);
		M.ctx.font = M.font;

		M.COLUMNS = Math.ceil(M.WIDTH / M.settings.COL_WIDTH);

		for (var i = 0; i < M.COLUMNS; i++) {
			M.codes[i] = [];
			M.codes[i][0] = {
				'open': true,
				'position': {'x': 0, 'y': 0},
				'strength': 0
			};
		}

		M.loop();

		M.createLines();

		M.createCode();

		// not doing this, kills CPU
		// M.swapCharacters();

		window.onresize = function () {
			window.cancelAnimationFrame(M.animation);
			M.animation = null;
			M.ctx.clearRect(0, 0, M.WIDTH, M.HEIGHT);
			M.codesCounter = 0;

			M.ctx2.clearRect(0, 0, M.WIDTH, M.HEIGHT);

			M.WIDTH = window.innerWidth;
			M.HEIGHT = window.innerHeight;
			M.init();
		};
	},

	loop: function () {
		M.animation = requestAnimationFrame( function(){ M.loop(); } );
		M.draw();

		stats.update();
	},

	// this used to be used straight after createCode, without using createCanvii - it allowed
	// the characters within the code streams to be easily changable, but caused huge perf issues
	// OLDdraw: function() {

	// 	var codesLen = M.codes.length;
	// 	var codeLen;
	// 	var x;
	// 	var y;
	// 	var text;
	// 	var velocity;
	// 	var columnIndex;
	// 	var strength;
	// 	var fadeStrength;

	// 	M.ctx.shadowColor = 'rgba(0, 0, 0, 0.5)';
	// 	M.ctx.fillStyle = 'rgba(0, 0, 0, 0.5)';
	// 	M.ctx.fillRect(0, 0, M.WIDTH, M.HEIGHT);

	// 	M.ctx.globalCompositeOperation = 'source-over';

	// 	for (var i = 0; i < codesLen; i++) {
			
	// 		velocity = M.codes[i][0].velocity;
	// 		M.codes[i][0].position.y += velocity;

	// 		y = M.codes[i][0].position.y;
	// 		x = M.codes[i][0].position.x;
	// 		codeLength = M.codes[i].length;
	// 		strength = M.codes[i][0].strength;

	// 		for (var j = 1; j < codeLength; j++) {
	// 			text = M.codes[i][j];

	// 			if (j < 5) {
	// 				M.ctx.shadowColor = 'hsl(104, 79%, 74%)';
	// 				M.ctx.shadowOffsetX = 0;
	// 				M.ctx.shadowOffsetY = 0;
	// 				M.ctx.shadowBlur = 10;
	// 				M.ctx.fillStyle = 'hsla(104, 79%, ' + (100 - (j * 5)) + '%, ' + strength + ')';
	// 			} else if (j > (codeLength - 4)) {
	// 				fadeStrength = j / codeLength;
	// 				fadeStrength = 1 - fadeStrength;

	// 				M.ctx.shadowOffsetX = 0;
	// 				M.ctx.shadowOffsetY = 0;
	// 				M.ctx.shadowBlur = 0;
	// 				M.ctx.fillStyle = 'hsla(104, 79%, 74%, ' + (fadeStrength + 0.3) + ')';
	// 			} else {
	// 				M.ctx.shadowOffsetX = 0;
	// 				M.ctx.shadowOffsetY = 0;
	// 				M.ctx.shadowBlur = 0;
	// 				M.ctx.fillStyle = 'hsla(104, 79%, 74%, ' + strength + ')';
	// 			}

	// 			// M.ctx.fillStyle = 'hsl(104, 79%, ' + (M.codes[i][0].strength * 74) + '%)';
	// 			M.ctx.fillText(text, x, (y - (j * M.settings.COL_HEIGHT)));

	// 			if ((j === codeLength - 1) && (y - ((j + 1) * M.settings.COL_HEIGHT) > M.HEIGHT)) {
	// 				columnIndex = M.codes[i][0].position.x / M.settings.COL_WIDTH;
	// 				M.codes[columnIndex][0].open = true;
	// 				M.codes[columnIndex][0].position.y = 0;
	// 			}
	// 		}
	// 	}

	// },
	
	draw: function() {

		var velocity, height, x, y, c, ctx;

		// slow fade BG colour
		M.ctx.shadowColor = 'rgba(0, 0, 0, 0.5)';
		M.ctx.fillStyle = 'rgba(0, 0, 0, 0.5)';
		M.ctx.fillRect(0, 0, M.WIDTH, M.HEIGHT);

		M.ctx.globalCompositeOperation = 'source-over';

		for (var i = 0; i < M.COLUMNS; i++) {
			
			// check member of array isn't undefined at this point
			if (M.codes[i][0].canvas) {
				velocity = M.codes[i][0].velocity;
				height = M.codes[i][0].canvas.height;
				x = M.codes[i][0].position.x;
				y = M.codes[i][0].position.y - height;
				c = M.codes[i][0].canvas;
				ctx = c.getContext('2d');

				M.ctx.drawImage(c, x, y, M.settings.COL_WIDTH, height);

				if ((M.codes[i][0].position.y - height) < M.HEIGHT){
					M.codes[i][0].position.y += velocity;
				} else {
					M.codes[i][0].position.y = 0;
				}

			}
		}

	},

	createCode: function() {

		if (M.codesCounter > M.COLUMNS) {
			clearTimeout(M.createCodeLoop);
			return;
		}

		var randomInterval = M.randomFromInterval(0, 100);
		var column = M.assignColumn();

		if (column) {
			
			var codeLength = M.randomFromInterval(M.settings.CODE_LENGTH_PARAMS.min, M.settings.CODE_LENGTH_PARAMS.max);
			var codeVelocity = (Math.random() * (M.settings.VELOCITY_PARAMS.max - M.settings.VELOCITY_PARAMS.min)) + M.settings.VELOCITY_PARAMS.min;
			var lettersLength = M.letters.length;

			M.codes[column][0].position = {'x': (column * M.settings.COL_WIDTH), 'y': 0};
			M.codes[column][0].velocity = codeVelocity;
			M.codes[column][0].strength = M.codes[column][0].velocity / M.settings.VELOCITY_PARAMS.max;

			for (var i = 1; i <= codeLength; i++) {
				var newLetter = M.randomFromInterval(0, (lettersLength - 1));
				M.codes[column][i] = M.letters[newLetter];
			}

			M.createCanvii(column);

			M.codesCounter++;

		}

		M.createCodeLoop = setTimeout(M.createCode, randomInterval);

	},

	createCanvii: function(i) {

		var codeLen = M.codes[i].length - 1;
		var canvHeight = codeLen * M.settings.COL_HEIGHT;
		var velocity = M.codes[i][0].velocity;
		var strength = M.codes[i][0].strength;
		var text, fadeStrength;

		var newCanv = document.createElement('canvas');
		var newCtx = newCanv.getContext('2d');

		newCanv.width = M.settings.COL_WIDTH;
		newCanv.height = canvHeight;

		for (var j = 1; j < codeLen; j++) {
			text = M.codes[i][j];
			newCtx.globalCompositeOperation = 'source-over';
			newCtx.font = '30px matrix-code';

			if (j < 5) {
				newCtx.shadowColor = 'hsl(104, 79%, 74%)';
				newCtx.shadowOffsetX = 0;
				newCtx.shadowOffsetY = 0;
				newCtx.shadowBlur = 10;
				newCtx.fillStyle = 'hsla(104, 79%, ' + (100 - (j * 5)) + '%, ' + strength + ')';
			} else if (j > (codeLen - 4)) {
				fadeStrength = j / codeLen;
				fadeStrength = 1 - fadeStrength;

				newCtx.shadowOffsetX = 0;
				newCtx.shadowOffsetY = 0;
				newCtx.shadowBlur = 0;
				newCtx.fillStyle = 'hsla(104, 79%, 74%, ' + (fadeStrength + 0.3) + ')';
			} else {
				newCtx.shadowOffsetX = 0;
				newCtx.shadowOffsetY = 0;
				newCtx.shadowBlur = 0;
				newCtx.fillStyle = 'hsla(104, 79%, 74%, ' + strength + ')';
			}

			newCtx.fillText(text, 0, (canvHeight - (j * M.settings.COL_HEIGHT)));
		}

		M.codes[i][0].canvas = newCanv;

	},

	swapCharacters: function() {
		var randomCodeIndex;
		var randomCode;
		var randomCodeLen;
		var randomCharIndex;
		var newRandomCharIndex;
		var newRandomChar;

		for (var i = 0; i < 20; i++) {
			randomCodeIndex = M.randomFromInterval(0, (M.codes.length - 1));
			randomCode = M.codes[randomCodeIndex];
			randomCodeLen = randomCode.length;
			randomCharIndex = M.randomFromInterval(2, (randomCodeLen - 1));
			newRandomCharIndex = M.randomFromInterval(0, (M.letters.length - 1));
			newRandomChar = M.letters[newRandomCharIndex];
		
			randomCode[randomCharIndex] = newRandomChar;
		}

		M.swapCharacters();
	},

	createLines: function() {
		M.linesC = document.createElement('canvas');
		M.linesC.width = M.WIDTH;
		M.linesC.height = M.HEIGHT;
		M.linesC.style.position = 'absolute';
		M.linesC.style.top = 0;
		M.linesC.style.left = 0;
		M.linesC.style.zIndex = 10;
		document.body.appendChild(M.linesC);

		var linesYBlack = 0;
		var linesYWhite = 0;
		M.ctx2 = M.linesC.getContext('2d');

		M.ctx2.beginPath();

		M.ctx2.lineWidth = 1;
		M.ctx2.strokeStyle = 'rgba(0, 0, 0, 0.7)';

		while (linesYBlack < M.HEIGHT) {

			M.ctx2.moveTo(0, linesYBlack);
			M.ctx2.lineTo(M.WIDTH, linesYBlack);

			linesYBlack += 5;
		}

		M.ctx2.lineWidth = 0.15;
		M.ctx2.strokeStyle = 'rgba(255, 255, 255, 0.7)';

		while (linesYWhite < M.HEIGHT) {

			M.ctx2.moveTo(0, linesYWhite+1);
			M.ctx2.lineTo(M.WIDTH, linesYWhite+1);

			linesYWhite += 5;
		}

		M.ctx2.stroke();
	},

	assignColumn: function() {
		var randomColumn = M.randomFromInterval(0, (M.COLUMNS - 1));

		if (M.codes[randomColumn][0].open) {
			M.codes[randomColumn][0].open = false;
		} else {
			return false;
		}

		return randomColumn;
	},

	randomFromInterval: function(from, to) {
		return Math.floor(Math.random() * (to - from+ 1 ) + from);
	},

	snapshot: function() {
		window.open(M.c.toDataURL());
	}

};

function eventListenerz() {
	var controlToggles = document.getElementsByClassName('toggle-info');
	var controls = document.getElementById('info');
	var snapshotBtn = document.getElementById('snapshot');

	function toggleControls(e) {
		e.preventDefault();
		controls.className = controls.className === 'closed' ? '' : 'closed';
	}

	for (var j = 0; j < 2; j++) {
		controlToggles[j].addEventListener('click', toggleControls, false);
	}

	snapshotBtn.addEventListener('click', M.snapshot, false);

}

window.onload = function() {

	M.init();

	eventListenerz();

};
</script>
	
</html>