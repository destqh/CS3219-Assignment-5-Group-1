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
            <form name="title" id="title" style="width:1000px; text-align: center; ">
                <div class="col-md-12 btn-margin">
                    <h1>Citation Network Graph</h1>
                    <div  style="display: inline-block;">
                        <h4> Type of citation: </h4>
                    </div>
                    <div  style="display: inline-block;">
                        <select id="trendType" name="citationType" class="w3-select" style="width:150px;height:32px; font-size:16px;">
                            <option value="incitations">In Citations</option>
                            <option value="outcitations">Out Citations</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <p><input class="w3-input w3-border btn-margin" type="text" id="myVal" placeholder="Enter title here" required name="title"></p>
                    </div>
                    <p><button class="btn btn-info btn-margin" type="submit" name="Submit" id="submit" value="Visualise">Visualize</button></p>
                </div>
            </form>
        </div>
    </div>

    <!-- create container element for visualization -->
    <div id="viz" style="width:auto; height:auto;"></div>
    <script src="/cir/view/js/viz_citation_network.js"></script>
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
</style>

