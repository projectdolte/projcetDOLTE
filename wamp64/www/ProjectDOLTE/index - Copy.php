<!-- PHP code to get client's IP address and append it to the log file (along with date and time)-->
<?PHP
    $ip = getenv("REMOTE_ADDR");
	date_default_timezone_set('US/Eastern');
    $date = date("d") . " " . date("F") . " " . date("Y") . " " . date("H:i:s");
    $intofile = $ip . "        " . $date . "<br>" . PHP_EOL;
    $hfile = fopen("logfile.txt", "a+");
    fwrite($hfile, $intofile);
    fclose($hfile);
?>





<!DOCTYPE html>
<html>


<!-- Clear IP Log file ajax funtion -->
<head>
<script type = "text/javascript">
function clearLog() {
$.ajax( { type : 'POST',
          data : { },
          url  : 'clearLogFile.php',              // <=== CALL THE PHP FUNCTION HERE.
          success: function ( data ) {
            //alert( "Cleared log file" );               // <=== VALUE RETURNED FROM FUNCTION.
			location.reload();	//refresh the page
          },
          error: function ( xhr ) {
            alert( "Error - Couldn't clear log file" );
          }
        });
}

</script>
</head>




<body>



<h2>Spectacular Pepe</h2>


<!-- Make a canvas to put image onto -->
<canvas id="canvas"> </canvas>

<!-- Script to get the image and add it to the HTML page every 33ms (30fps)-->
<script type="text/JavaScript">
//var url = "pepe.jpg"; //url to load image from
var url = "frame.jpg"; //url to load image from
var fps = 2.0;
var refreshInterval = Math.round((1.0 / fps) * 1000); //in ms
var drawDate = true; //draw date string
var img;

function init() {
    var canvas = document.getElementById("canvas");
    var context = canvas.getContext("2d");
	
	var height = 720;
	var width = 1280;
	
    img = new Image();
	var downloadingImage = new Image();
    img.onload = function() {
		//this.src = downloadingImage.src;
		
        canvas.setAttribute("width", img.width)	//set size to actual image size
        canvas.setAttribute("height", img.height)
		//canvas.setAttribute("width", width)	//set size 720p
        //canvas.setAttribute("height", height)
        context.drawImage(this, 0, 0);
        if(drawDate) {
            var now = new Date();
            var text = now.toLocaleDateString() + " " + now.toLocaleTimeString();
            var maxWidth = 100;
            var x = img.width-10-maxWidth;	//auto set size 
            var y = img.height-10;
            context.strokeStyle = 'black';
            context.lineWidth = 2;
            context.strokeText(text, x, y, maxWidth);
            context.fillStyle = 'white';
            context.fillText(text, x, y, maxWidth);
        }
    };
    refresh();
}


function refresh(){
    //img.src = url + "?t=" + new Date().getTime();
	var d = new Date();
	img.src = url + "?" + d.getMilliseconds();
/* 	downloadingImage.onload = function(){
		//img.src = this.src;
		this.src = url + "?t=" + new Date().getTime();
	}; */
	//downloadingImage.src = url + "?t=" + new Date().getTime();
    setTimeout("refresh()",refreshInterval);
	//document.getElementById('imageID1').innerHTML="<img src=\'" + img.src + "\'>";
}


</script>




<!-- Import jQuery -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"> </script>





<!-- Try to show logged IP address on website -->

<?PHP
            $IP=$_SERVER['REMOTE_ADDR'];
            echo "<strong>Your IP Address <em>$ip</em> has Been Logged</strong>";
?>






<!-- Load image update method -->
<body onload="JavaScript:init();">











<script>
// requestAnim shim layer by Paul Irish
    window.requestAnimFrame = (function(){
      return  window.requestAnimationFrame       || 
              window.webkitRequestAnimationFrame || 
              window.mozRequestAnimationFrame    || 
              window.oRequestAnimationFrame      || 
              window.msRequestAnimationFrame     || 
              function(/* function */ callback, /* DOMElement */ element){
                window.setTimeout(callback, 1000 / 60);
              };
    })();
  

// example code from mr doob : http://mrdoob.com/lab/javascript/requestanimationframe/

var canvas, context, toggle;

var imgurl = "frame.jpg";
var img;

init();
animate();

function init() {

    canvas = document.createElement( 'canvas' );
    canvas.width = 512;
    canvas.height = 512;
	
	//New code
	img.src = url;
	canvas.width = 640;	//set size to actual image size
    canvas.height = 480;


    context = canvas.getContext( '2d' );

    document.body.appendChild( canvas );

}

function animate() {
    requestAnimFrame( animate );
    draw();

}

function draw() {

    var time = new Date().getTime() * 0.002;
	
	
	
	
	img.src = imgurl + "?" + time;
	context.drawImage(img,
						0, 0, 640, 480,
						0, 0, 640, 480);

	
	
/*     var x = Math.sin( time ) * 192 + 256;
    var y = Math.cos( time * 0.9 ) * 192 + 256;
    toggle = !toggle;

    context.fillStyle = toggle ? 'rgb(200,200,20)' :  'rgb(20,20,200)';
    context.beginPath();
    context.arc( x, y, 10, 0, Math.PI * 2, true );
    context.closePath();
    context.fill(); */

}
</script>
























<!-- Add a "Clear IP log" button -->
<br></br>
<button onclick="clearLog()">Clear IP Log</button>



<!-- Print out IP log -->
<br></br>
<?php
$data = '<pre>'.file_get_contents("logfile.txt").'</pre>';
echo $data;
?>










</body>
</html> 

