<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/cir/controller/front_end_controller.php'); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/cir/view/import/import.php'); ?>

<!DOCTYPE html>
<html>
<title>CIR</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/cir/view/css/index.css">
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/cir/view/nav/navbar.php'); ?>
<body>

<!-- Header with full-height image -->
<header class="bgimg-1 w3-display-container w3-grayscale-min" id="home">
	<div class="w3-display-left w3-text-white" style="padding:48px">
		<span class="w3-jumbo w3-hide-small" style="">Start visualizing <br> Conference Information</span><br>
		<span class="w3-large">Correlate and visualize data of conference information</span>
		<p><a href="#help" class="w3-button w3-white w3-padding-large w3-large w3-margin-top w3-opacity w3-hover-opacity-off">Learn more and start today</a></p>
	</div>
	<div class="w3-display-bottomleft w3-text-grey w3-large" style="padding:24px 48px">
		<i class="fa fa-facebook-official w3-hover-opacity"></i>
		<i class="fa fa-instagram w3-hover-opacity"></i>
		<i class="fa fa-snapchat w3-hover-opacity"></i>
		<i class="fa fa-pinterest-p w3-hover-opacity"></i>
		<i class="fa fa-twitter w3-hover-opacity"></i>
		<i class="fa fa-linkedin w3-hover-opacity"></i>
	</div>
</header>

<!-- Help Section -->
<div class="w3-container" style="padding:128px 16px" id="help">
	<h3 class="w3-center">How to start visualization</h3>
	<div class="w3-row-padding w3-center" style="margin-top:64px">
		<div class="w3-quarter">
			<p class="w3-large"></p>
		</div>
		<div class="w3-quarter">
			<p class="w3-center w3-large">Step 1</p>
			<i class="fa fa-desktop w3-margin-bottom w3-jumbo w3-center"></i>
			<p class="w3-large">Upload</p>
			<p><a href="#upload" class="w3-button w3-black" id="team">Upload</a></p>
		</div>
		<div class="w3-quarter">
			<p class="w3-center w3-large">Step 2</p>
			<i class="fa fa-diamond w3-margin-bottom w3-jumbo"></i>
			<p class="w3-large">Start Visualization</p>
			<p><a href="#visualization" class="w3-button w3-black" id="team">Visualization</a></p>
		</div>
		<div class="w3-quarter">
			<p class="w3-large"></p>
		</div>
	</div>
</div>

<!-- Upload Section -->
<div class="w3-container w3-row w3-center w3-dark-grey w3-padding-64" id="upload">
	<p><a href="#visualization" class="w3-button w3-white" id="team" style="font-size:32px">Continue using latest uploaded data</a></p>
	<h3 class="w3-center" style="font-size=48px;background-position:center;">Or </h3>
	<h3 class="w3-center">Upload the file containing conference information(json/xml)</h3>
	<a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo "option=upload_file_format"; ?>" style="background:#000000; color:white;">Guide on file format</a>
	<p></p>
	<form action="http://localhost:3000/upload" method="post" enctype="multipart/form-data" target="myIframe" id="formUpload">
		<input id="inp1" type="file" name="fileToUpload" class="btnBrowseFile" value="Upload" id="fileToUpload"/>
		<p></p>
		<input id="inp2" type="button" onclick="beforeSubmit();" class="w3-button w3-black" value="Upload" />
	</form>
	<iframe srce="" name="myIframe" id="myIframe" style="width:200px;height:50px;"> Iframe not supported by this browser</iframe>


	<h3 class="w3-center">Latest uploaded data statistics</h3>
	<div class="w3-quarter">
		<span class="w3-xxlarge">14+</span>
		<br>Latest Upload filename
	</div>
	<div class="w3-quarter">
		<span class="w3-xxlarge">55+</span>
		<br>Last Uploaded
	</div>
	<div class="w3-quarter">
		<span class="w3-xxlarge">89+</span>
		<br>Number of papers
	</div>
</div>

<!-- Visalization Section -->
<div class="w3-container" style="padding:128px 16px" id="visualization">
	<h3 class="w3-center">Different Visualizations</h3>
	<p class="w3-center w3-large">Choose any of the visualization</p>
	<div class="w3-row-padding w3-grayscale w3-center" style="margin-top:64px;background-position:center;">
		<div class="w3-col l3 m6 w3-margin-bottom" style="width:490px;height:490px">
			<div class="w3-card">
				<a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo "option=viz_timeline_trend"; ?>"><img border="0" src="/cir/view/img/timeline_trend.png" style="width:100%;height:200px;"></a>
				<div class="w3-container">
					<h3>Conference Timeline Trend</h3>
					<p class="w3-opacity">Horizontal bar graph</p>
					<p>A<year>, B<year>, ….., Z<year> i.e. compare different conferences over a range of year <year></p>
				</div>
			</div>
		</div>
		<div class="w3-col l3 m6 w3-margin-bottom" style="width:490px;height:490px">
			<div class="w3-card">
				<a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo "option=viz_citation_network"; ?>"><img border="0" src="/cir/view/img/citation_network.png" style="width:100%;height:200px;"></a>
				<div class="w3-container">
					<h3>Citation Network</h3>
					<p class="w3-opacity">Network Graph</p>
					<p>Display network graph of papers based on in/out citation relationship</p>
				</div>
			</div>
		</div>
		<div class="w3-col l3 m6 w3-margin-bottom" style="width:490px;height:490px">
			<div class="w3-card">
				<a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo "option=viz_top_n_x_of_y"; ?>"><img border="0" src="/cir/view/img/top_n_x_of_y.png" style="width:100%;height:200px;"></a>
				<div class="w3-container">
					<h3>Top N X-of-Y</h3>
					<p class="w3-opacity">Horizontal bar graph/Treemap</p>
					<p>Find top N X of Y. X and Y could be any attribute of papers which make sense. </p>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal for full size images on click-->
<div id="modal01" class="w3-modal w3-black" onclick="this.style.display='none'">
	<span class="w3-button w3-xxlarge w3-black w3-padding-large w3-display-topright" title="Close Modal Image">×</span>
	<div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64">
		<img id="img01" class="w3-image">
		<p id="caption" class="w3-opacity w3-large"></p>
	</div>
</div>

<!-- Footer -->
<footer class="w3-center w3-black w3-padding-64">
  <a href="#home" class="w3-button w3-light-grey"><i class="fa fa-arrow-up w3-margin-right"></i>To the top</a>
  <p>Done by group 1</a></p>
</footer>

<script>

// Modal Image Gallery
function onClick(element) {
  document.getElementById("img01").src = element.src;
  document.getElementById("modal01").style.display = "block";
  var captionText = document.getElementById("caption");
  captionText.innerHTML = element.alt;
}


// Toggle between showing and hiding the sidebar when clicking the menu icon
var mySidebar = document.getElementById("mySidebar");

function w3_open() {
    if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
    } else {
        mySidebar.style.display = 'block';
    }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
}
</script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script>

beforeSubmit = function(){
        if (1 == 1){
			var html_string= "Uploading... please wait...";
			document.getElementById('myIframe').src = "data:text/html;charset=utf-8," + escape(html_string);
			setTimeout(function(){ 
				$("#formUpload").submit();            
			}, 1000);
			

	        }        
    }

</script>
</body>
</html>
