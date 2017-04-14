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


<!-- Restart Python webcam server ajax function -->
<script type = "text/javascript">
function restartPyServer() {
$.ajax( { type : 'POST',
          data : { },
          url  : 'restartPyServer.php',              // <=== CALL THE PHP FUNCTION HERE.
          success: function ( data ) {
            //alert( "Restarting Python webcam server" );               // <=== VALUE RETURNED FROM FUNCTION.
			//location.reload();	//refresh the page
			alert(data)
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
<canvas id="canvas2" width=640 height=480></canvas>

<br>




<!-- Import jQuery -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"> </script>









<!-- Draw webcam frame -->
<p id="results">Results:</p>
<canvas id="canvas" width=300 height=300></canvas>


<script>
var stop = false;
var frameCount = 0;
var $results = $("#results");
var fps, fpsInterval, startTime, now, then, elapsed;

var canvas = document.getElementById("canvas2");
var context = canvas.getContext("2d");
var imgsrc = "frame.jpg";
var img;
var currFrame = 0;
var wantedfps = 30;

startAnimating(wantedfps);

function startAnimating(fps) {
    fpsInterval = 1000 / fps;
    then = Date.now();
    startTime = then;
    console.log(startTime);
    animate();
}


function animate() {

    // stop
    if (stop) {
        return;
    }

    // request another frame

    requestAnimationFrame(animate);

    // calc elapsed time since last loop

    now = Date.now();
    elapsed = now - then;

    // if enough time has elapsed, draw the next frame

    if (elapsed > fpsInterval) {

        // Get ready for next frame by setting then=now, but...
        // Also, adjust for fpsInterval not being multiple of 16.67
        then = now - (elapsed % fpsInterval);

        // draw stuff here
		img = new Image();
		//img.src = imgsrc + currFrame.toString() + '.jpg' + "?" + now;
		img.src = imgsrc + "?" + now;
		img.onload = function(){
			context.drawImage(this, 0, 0);
		}

/* 		currFrame = currFrame + 1;
		
		if(currFrame >= wantedfps){
			currFrame = 0;
		} */
		
		
        // TESTING...Report #seconds since start and achieved fps.
        var sinceStart = now - startTime;
        var currentFps = Math.round(1000 / (sinceStart / ++frameCount) * 100) / 100;
        $results.text("Elapsed time= " + Math.round(sinceStart / 1000 * 100) / 100 + " secs @ " + currentFps + " fps.");

    }
}
</script>










<!-- Try to show logged IP address on website -->

<?PHP
            $IP=$_SERVER['REMOTE_ADDR'];
            echo "<strong>Your IP Address <em>$ip</em> has Been Logged</strong>";
?>














<!-- Add a "Clear IP log" button -->
<br></br>
<button onclick="clearLog()">Clear IP Log</button>



<!-- Add a "Restart Python server" button 

<button onclick="restartPyServer()">Restart Python Server</button>
-->


<!-- Print out IP log -->
<br></br>
<?php
$data = '<pre>'.file_get_contents("logfile.txt").'</pre>';
echo $data;
?>










</body>
</html> 

