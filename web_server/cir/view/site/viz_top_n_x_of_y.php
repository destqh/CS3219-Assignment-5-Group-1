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

<body>

    <!-- Visulization input section -->
<div class="w3-container w3-light-grey" style="padding:128px 16px">
  <h3 class="w3-center">Top N X of Y</h3>
  <div class="w3-row-padding" style="margin-top:64px">
    <div class="w3-half">
    <form name="form" id="form" style="float:left">
        <div class="visType" margin="20">
            <p><select id="visType" name="visType" class="w3-select" style="width:650px">
                <option value="barChart">Bar Chart</option>
                <option value="treeMap">Tree Map</option>
            </select></p>
             </div>
                <p style="display:inline">
            <input id="N" type="integer" onkeypress='return event.charCode >= 48 && event.charCode <= 57' placeholder="top N" style="width:208;height:32px;">
            <select id="X" class = "dropbtn" style="width:208;height:32px;"></select></p><br>
           <p> of </p>
            <p> 
                <select id="Y" class = "dropbtn" style="width:208;height:32px;"></select>
                <input type="text2"  id="myVal" placeholder="Enter Y here" style="width:208;height:32px;">
            </p>
            <p><button class="w3-button w3-black" type="submit" name="Submit" id="submit" value="Visualise">Visualize</button></p>
        </form>
    </div>
  </div>
</div>

<h1 align="center">
    <p id = "d3Title"> </p>
</h1>

<!-- create container element for visualization -->
<div id="viz"></div>
<script src="/cir/view/js/viz_top_n_x_of_y.js"></script>
</body>
</html>