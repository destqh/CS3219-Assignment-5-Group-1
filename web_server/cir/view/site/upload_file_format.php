<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/cir/controller/front_end_controller.php'); ?>

<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/cir/view/import/import.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Conference Information Retrieval</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="//d3plus.org/js/d3.js"></script>
    <script src="//d3plus.org/js/d3plus.js"></script>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/cir/view/nav/navbar.php'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>
<!-- Visulization input section -->
<div class="w3-container w3-light-grey" style="padding:128px 16px">
  <h3 class="w3-center">JSON File Format</h3>
  <div class="w3-row-padding" style="margin-top:64px">
    <div class="w3-half">
	    <div class="fileFormat" margin="20">
		    <pre> {
			<br>"authors":[
			<br>	{
			<br>		"ids":[String],
			<br>		"name":String,
			<br>	}
			<br>],
			<br>"id":String,
			<br>"incitations":[String],
			<br>"keyphrases":[String],
			<br>"outcitations":[String],
			<br>"paperabstract": String,
			<br>"pdfurls":[String],
			<br>"s2url": String,
			<br>"title": String,
			<br>"venue": String,
			<br>"year": Int
			<br>}
			</pre>
	    </div>
    </div>
  </div>
  <p></p>
</div>
</body>
</html>