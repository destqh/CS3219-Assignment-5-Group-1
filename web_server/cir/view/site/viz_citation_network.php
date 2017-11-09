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

        <p>
          <button class="w3-button w3-black" type="submit" name="Submit" id="submit" value="Visualise">Visualize</button>
        </p>
        </div>
        </form>
    </div>
  </div>
</div>

<!-- create container element for visualization -->
<div id="viz" style="width:auto; height:auto;"></div>

<script>
  
    var form = document.getElementById('title');

    form.addEventListener('submit', function(e) {
        e.preventDefault(); // don't submit
        var title = document.getElementById("myVal").value;

        var visType = form.elements["visType"].value;
        console.log(visType);
        console.log(title);
            
        if (title && visType) 
            updateData(title, visType);
        else
            alert("Please fill in all inputs");
    });

    function updateData(title, visType) {
        d3.select("#viz").selectAll('*').remove();

 // var title = "Low-density parity check codes over GF(q)";
        d3.json('http://localhost:3000/api/get-citation-network/' + title + '/' + visType, function(error, dataset) {
        if (error || dataset.length == 0) {
        	alert("No Result!");
        	return;
        }
        console.log(dataset.connections);
        console.log(dataset.data);
        var level = [];
        for (key in dataset.data) {
            level.push(dataset.data[key].level);
        }
        var levelSize = Array.from(new Set(level)).length;

        var colors = ["#C70039" ,  "#D0CA4C", "#3941A5  "];
        var colorMap = colors.slice(0,levelSize);

    //                 var visualization = d3plus.viz()
    // .container("#viz")  // container DIV to hold the visualization
    // .type("network")    // visualization type
    // .data(dataset.data)  // sample dataset to attach to nodes
    // .edges(dataset.connections) // list of node connections
    // .id("id")   
    // .edges({"arrows": true}) 
    // .size(4)
    // .color("level")
    // .legend({ "icons": false })
   

        var visualization = d3plus.viz()
        .container("#viz")
        .type("rings")
        .data(dataset.data)
        .id("id")
        // .size("value")
        .edges(dataset.connections)
        .focus(dataset.data[0].id)
        .color("level")
        .edges({"arrows": true}) 
        .color({
         heatmap: colorMap, 

        range: colorMap, // the colors used for all positive or all negative domains
        })
        .tooltip(["title","year"]) 
        .descs({
            "title": "What title it was",  // key referring to data will use string as description
            "year": "What year it was"   // multiple descriptions possible
            })
        .draw();

        window.scrollTo(0,document.body.scrollHeight);
        $('html,body').animate({scrollTop: document.body.scrollHeight},"fast");
   });
}

  // instantiate d3plus
  
</script>