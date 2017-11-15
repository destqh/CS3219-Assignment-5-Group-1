<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/cir/controller/front_end_controller.php'); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/cir/view/import/import.php'); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/cir/view/import/bootstrap.php'); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Conference Information Retrieval</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/cir/view/css/viz.css">
        <script src="//d3plus.org/js/d3.js"></script>
        <script src="//d3plus.org/js/d3plus.js"></script>
        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/cir/view/nav/navbar.php'); ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    </head>

        <!-- Visulization input section -->
    <div class="w3-container w3-light-grey" style="padding:28px 16px">
        <div align="center" class="w3-row-padding" style="margin-top:64px; background-color: #C0C0C0;">
            <div class="form-group" style="width:500px; text-align: center; ">
                <form name="add_name" id="add_name">
                    <div class="col-md-12">
                        <h1>Conference Timeline Trend</h1>
                        <div  style="display: inline-block;">
                            <h4> Attribute: </h4>
                        </div>
                        <div style="display: inline-block;">
                            <select id="trendType" class="w3-select" style="width:150px;height:32px; font-size:16px;">
                                <option> venue </option>
                                <option> author </option>
                                <option value="title"> cited paper </option>
                            </select>
                        </div>
                    </div> 
                    <div id="dynamic_field" >
                        <div class="col-md-10" style="display: inline-block;">
                            <input id="inputText" type="text" name="name" placeholder="Enter your value" class="form-control name_list biginput btn-margin"  />
                        </div>
                        <div class="col-md-2" style="display: inline-block;">
                            <button type="button" name="add" id="add" class="btnAddMore btn-info btn-margin" >Add</button> 
                        </div>
                    </div>
                    <div class="col-md-12">
                        <input type="button" name="submit" id="submit" class="btn btn-info btn-margin" value="Visualise" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="viz"></div>
    <script src="/cir/view/js/viz_timeline_trend.js"></script>
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

.side {
   display:inline-block;
   float:left;
}
</style>
