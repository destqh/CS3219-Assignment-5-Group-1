<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/cir/controller/front_end_controller.php'); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/cir/view/import/bootstrap.php'); ?>
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
    <div class="w3-container w3-light-grey" style="padding:28px 16px">
        <div align="center" class="w3-row-padding" style="margin-top:64px; background-color: #C0C0C0;">
            <form name="form" id="form" style="width:1000px; text-align: center; ">
                <div class="col-md-12 btn-margin btn-margin">
                    <h1>Top N X of Y</h1>
                    <div  style="display: inline-block;">
                        <h4> Type of Visualization: </h4>
                    </div>
                    <div  style="display: inline-block;">
                        <select id="visType" name="visType" class="w3-select" style="width:150px;height:32px;">
                            <option value="barChart">Bar Chart</option>
                            <option value="treeMap">Tree Map</option>
                        </select>
                     </div>
                </div>
                <div class="col-md-12 btn-margin">
                    <div class="col-md-2 btn-margin">    
                        <input id="N" type="integer" onkeypress='return event.charCode >= 48 && event.charCode <= 57' placeholder="top N" style="width:150px; text-align: center">
                    </div>
                    <div class="col-md-2 btn-margin">  
                        <select id="X" class = "dropbtn" style="width:150px;height:32px;"></select><br>
                    </div>
                    <div class="col-md-2 btn-margin"> 
                        <span style="font-size: 20px;"> FOR </span>
                    </div>
                    <div class="col-md-2 btn-margin"> 
                        <select id="Y" class = "dropbtn" style="width:150px;height:32px;"></select>
                    </div>
                    <div class="col-md-3 btn-margin"> 
                        <input type="text2"  id="myVal" placeholder="Enter Y here" style="width:208px;height:32px;">
                    </div>
                </div>
                <div class="col-md-12 btn-margin">  
                    <button class="btn btn-info btn-margin" type="submit" name="Submit" id="submit" value="Visualise">Visualize</button>
                </div>
                
            </form>
        </div>
    </div>

    <h1 align="center">
        <p id = "d3Title"> </p>
    </h1>
    <!-- create container element for visualization -->
    <div id="viz"></div>
    <script src="/cir/view/js/viz_top_n_x_of_y.js"></script>
</html>

<style>
.btn-info{
    color: #fff !important;
    background-color: #000000 !important;
    border-color: #000000 !important; 
}

.btn-info:hover,  .btn-info:active{
    color: #000000 !important; 
    background-color: #C0C0C0 !important;
    border-color: #000000 !important;
}

.btn-margin {
    margin-top: 10px;
    margin-bottom: 10px;
}

input, input[placeholder]{
    text-align:center;
}
</style>