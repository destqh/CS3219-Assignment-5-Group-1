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
	<!-- Data Model output section -->
	<div class="w3-container w3-light-grey" style="padding:128px 16px">
		<h3 class="w3-center">JSON File Format</h3>
		<div class="w3-row-padding" style="margin-top:64px">
		    <div class="w3-half">
			    <div class="fileFormat" margin="20">
			    	<pre>
				    {
					"authors":[
						{
							"ids":[String],
							"name":String,
						}
					],
					"id":String,
					"incitations":[String],
					"keyphrases":[String],
					"outcitations":[String],
					"paperabstract": String,
					"pdfurls":[String],
					"s2url": String,
					"title": String,
					"venue": String,
					"year": Int
					}
					</pre>
			    </div>
		    </div>
		</div>
	  	<p></p>
	 </div>
	<div class="w3-container w3-light-grey" style="padding:128px 16px">
	  	<h3 class="w3-center">XML File Format</h3>
		<div class="w3-row-padding" style="margin-top:64px">
		    <div class="w3-half">
			    <div class="fileFormat" margin="20">
				    <pre>
					&lt;papers&gt;
					    &lt;authors&gt;
					        &lt;ids&gt;Int&lt;/ids&gt;
					        &lt;name&gt;String&lt;/name&gt;
					    &lt;/authors&gt;
					    &lt;id&gt;String&lt;/id&gt;
					    &lt;incitations&gt;String&lt;/incitations&gt;
					    &lt;paperabstract&gt;String&lt;/paperabstract&gt;
					    &lt;s2url&gt;String&lt;/s2url&gt;
					    &lt;title&gt;String&lt;/title&gt;
					    &lt;venue&gt;String&lt;/venue&gt;
					    &lt;year&gt;Int&lt;/year&gt;
					&lt;/papers&gt;
					</pre>
			    </div>
		    </div>
		</div>
	  	<p></p>
	</div>
</html>
