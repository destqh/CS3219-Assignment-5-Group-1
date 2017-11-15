<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/cir/controller/front_end_controller.php'); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/cir/view/import/import.php'); ?>

<!DOCTYPE html>
<html>
<title>CIR</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/cir/view/css/index.css">
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/cir/view/nav/navbar.php'); ?>

<style>
	html *
{
font-family: "Comic Sans MS", cursive, sans-serif;
}

</style>
<body>

<!-- Header with full-height image -->
<header class="bgimg-1 w3-display-container w3-grayscale-min" id="home">
	<div class="w3-display-left w3-text-white" style="padding:48px">
		<span class="w3-jumbo w3-hide-small" style="">Start visualizing <br> Conference Information</span><br>
		<span class="w3-large">Correlate and visualize data of conference information</span>
		<p><a href="#help" class="w3-button w3-white w3-padding-large w3-large w3-margin-top w3-opacity w3-hover-opacity-off">Learn more and start today</a></p>
	</div>
	
</header>

<!-- Help Section -->
<div class="w3-container" style="padding:228px 16px" id="help">
	<h3 class="w3-center">How to start visualization</h3>
	<div class="w3-row-padding w3-center" style="margin-top:64px">
		<div class="w3-quarter">
			<p class="w3-large"></p>
		</div>
		<div class="w3-quarter">
			<p class="w3-center w3-large">Step 1</p>
			<i class="fa fa-desktop w3-margin-bottom w3-jumbo w3-center"></i>
			<p class="w3-large">Upload Data</p>
			<p><a href="#upload" class="w3-button w3-black" id="team">Upload</a></p>
		</div>
		<div class="w3-quarter">
			<p class="w3-center w3-large">Step 2</p>
			<i class="fa fa-diamond w3-margin-bottom w3-jumbo"></i>
			<p class="w3-large">Start Visualization</p>
			<p><a href="#visualization" class="w3-button w3-black" id="team">Visualise</a></p>
		</div>
		<div class="w3-quarter">
			<p class="w3-large"></p>
		</div>
	</div>
</div>

<!-- Upload Section -->
<div class="w3-container w3-row w3-center w3-dark-grey w3-padding-64" id="upload" >
	<p><a href="#visualization" class="w3-button w3-white" id="team" style="font-size:32px; margin-top:2em; border: 2px solid;
    border-radius: 25px;">Continue using latest uploaded data</a></p>
	<h3 class="w3-center" style="font-size=48px;background-position:center;margin-top:2em;">Or </h3>
	<h3 class="w3-center" style="margin-top:2em; margin-bottom:1em;">Upload the file containing conference information (json/xml) </h3>
	<a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo "option=upload_file_format"; ?>" style="color:white; ">[Click here for guide on file format]</a>
	<p style="margin-bottom:2em;" ></p>
	<form action="http://localhost:3000/api/upload" method="post" enctype="multipart/form-data" target="myIframe" id="formUpload">
		<input id="inp1" type="file" name="fileToUpload" class="btnBrowseFile" value="Upload" id="fileToUpload"/>
		<p></p>
		<input id="inp2" type="button" onclick="beforeSubmit();" class="w3-button w3-black" value="Upload" />
	</form>
	<div style="text-align:center;"> 
		<iframe srce="" align = "middle" name="myIframe" id="myIframe" style="width:500px;text-align:center; height:60px;visibility: hidden;"> Iframe not supported by this browser</iframe>
	</div>


	
</div>

<!-- Visalization Section -->
<div class="w3-container" style="padding:128px 16px" id="visualization">
	<h3 class="w3-center" style="font-size:32px;">Start Visualising</h3>
	<p class="w3-center w3-large">Choose any of the visualization</p>
	<div class="w3-row-padding w3-grayscale w3-center" style="margin-top:64px;background-position:center;">
		<div class="w3-col l3 m6 w3-margin-bottom" style="width:450px;height:480px">
			<div class="w3-card">
				<a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo "option=viz_timeline_trend"; ?>"><img border="0" src="/cir/view/img/timeline_trend.png" style="width:100%;height:200px;"></a>
				<div class="w3-container">
					<a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo "option=viz_timeline_trend"; ?>"><h3>Conference Timeline Trend</h3></a>
					<p class="w3-opacity">Horizontal line graph</p>
					<p>A<year>, B<year>, ….., Z<year> i.e. compare different conferences over a range of year <year></p>
				</div>
			</div>
		</div>
		<div class="w3-col l3 m6 w3-margin-bottom" style="width:450px;height:480px">
			<div class="w3-card">
				<a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo "option=viz_citation_network"; ?>"><img border="0" src="/cir/view/img/citation_network.png" style="width:100%;height:200px;"></a>
				<div class="w3-container">
					<a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo "option=viz_citation_network"; ?>"><h3>Citation Network</h3></a>
					<p class="w3-opacity">Network Graph</p>
					<p>Display network graph of papers based on in/out citations relationship</p>
				</div>
			</div>
		</div>
		<div class="w3-col l3 m6 w3-margin-bottom" style="width:450px;height:480px">
			<div class="w3-card">
				<a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo "option=viz_top_n_x_of_y"; ?>"><img border="0" src="/cir/view/img/top_n_x_of_y.png" style="width:100%;height:200px;"></a>
				<div class="w3-container">
					<a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo "option=viz_top_n_x_of_y"; ?>"><h3>Top N X-of-Y</h3></a>
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



</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="/cir/view/js/index.js"></script>







</body>
</html>
