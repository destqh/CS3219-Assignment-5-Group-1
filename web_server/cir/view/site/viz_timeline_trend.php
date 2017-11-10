<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/cir/controller/front_end_controller.php'); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/cir/view/import/import.php'); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/cir/view/import/bootstrap.php'); ?>

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

<body onload="setTimeout(function(){window.scrollTo(0,document.body.scrollHeight)}, 1000);">

    <!-- Visulization input section -->
<div class="w3-container w3-light-grey" style="padding:128px 16px">
    <h3 class="w3-center">Conference Timeline Trend</h3>
    <div class="w3-row-padding" style="margin-top:64px">
        <div class="w3-half">
            <div class="form-group">
                <form name="add_name" id="add_name">
                    <div class="col-md-8">
                        <select id="trendType" class="w3-select" style="width:455px">
                            <option> venue </option>
                            <option> author </option>
                            <option> title </option>
                        </select>
                    </div> 
                    <div id="dynamic_field" >
                        <div class="col-md-8">
                            <button type="button" name="add" id="add" class="btnAddMore"  style="margin-top:10px">Add</button> 
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="name" placeholder="Enter your vaue" class="form-control name_list" style="margin-top:10px" />
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top:10px">
                        <input type="button" name="submit" id="submit" class="btn btn-info" value="Visualise" style="background-color:#000000;border-radius: 0px;border: none;"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="viz"></div>
<script src="/cir/view/js/viz_timeline_trend.js"></script>
</body>
</html>