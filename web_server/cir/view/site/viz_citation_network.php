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
  <h3 class="w3-center">Citation Network</h3>
  <div class="w3-row-padding" style="margin-top:64px">
    <div class="w3-half">
    <form name="title" id="title" style="float:left">
    <div class="visType" margin="20">
        <p><select id="trendType" name="visType" class="w3-select" style="width:650px">
            <option value="incitations">In Citations</option>
            <option value="outcitations">Out Citations</option>
            </select>
        </p>
	    <p><input class="w3-input w3-border" type="text" id="myVal" placeholder="Enter title" required name="title"></p>
		<p><button class="w3-button w3-black" type="submit" name="Submit" id="submit" value="Visualise">Visualize</button></p>
     </div>
        </form>
    </div>
  </div>
</div>

<!-- create container element for visualization -->
<div id="viz" style="width:auto; height:auto;"></div>
<script src="/cir/view/js/viz_citation_network.js"></script>