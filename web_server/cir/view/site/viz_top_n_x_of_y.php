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

<script>
    var activities = document.getElementById("Y");
    activities.addEventListener("change", function() {
        $('#myVal').attr('placeholder', 'Enter ' + $("#Y option:selected").text() + ' here');
    });
</script>

    <!-- dynamic input fields by reading the json file -->
<script>
    $.getJSON("../json/topNXY.json", function(json) {
    var X = json.X;
    var Y = json.Y
    var select, option;

    select = document.getElementById('X');
    for (var index in X.values) {
        option = document.createElement('option');
        option.value = X.values[index];
        option.text = X.text[index];
        select.add(option);
    }

    select = document.getElementById('Y');
    for (var index in Y.values) {
        option = document.createElement('option');
        option.value = Y.values[index];
        option.text = Y.text[index];
        select.add(option);
    }

    $('#myVal').attr('placeholder', 'Enter ' + $("#Y option:selected").text() + ' here');

    });
</script>

<script>
    var form = document.getElementById('form');
    form.addEventListener('submit', function(e) {
        e.preventDefault(); 
        var value = document.getElementById("myVal").value;
        var N = document.getElementById("N").value;
        var X = document.getElementById("X").value;
        var Y = document.getElementById("Y").value;
        var visType = form.elements["visType"].value;

        console.log(N);
                    console.log(X);
        console.log(Y);
        console.log(value);

        if (Y && visType) {
            visData(value, N, X, Y, visType);
        }
        else 
            alert("Please fill in all inputs")
           
    });

    function visData(value, N, X, Y, visType) {
        d3.select("#viz").selectAll('*').remove();
        d3.json('http://localhost:3000/api/get-top-N-X-Y/' + N + '/' + X + '/' + Y + '/' + value, function(error, data) {
            if (error || data.length == 0) {
                document.getElementById("d3Title").innerHTML = insertTab() + "No Result Found";
                return;
            }

            console.log(data);    
            document.getElementById("d3Title").innerHTML = insertTab() + "Top " + N + " " + X +  "s for " + "'" + value + "'";
            if (X == "venue" || X == "author") {
                var timeData = [];
                for(index in data) {
                    var datum = data[index];
                    for(yearIndex in datum.year) {
                        var obj = {};
                        obj[X] = datum[X];
                        obj["count"] = 1;
                        obj["year"] = datum.year[yearIndex];
                        timeData.push(obj);
                    }
                }
                console.log(timeData);
                data = timeData;
            }
            if (visType == "treeMap") {
                var visualization = d3plus.viz()
                    .container("#viz")     
                    .data(data)     
                    .type("tree_map")       
                    .id(["", X]) 
                    .depth(1)              
                    .size("count")         
                    .format({
                        "text": function(text, params) {
                            
                            if (text === "count") {
                              return "Number of Publications";
                            }
                            else {
                              return d3plus.string.title(text, params);
                        }
                        
                    }})       
                    .legend(true)
                    .color(X)
                    .time({"value":"year"})
                    .draw()                
            }

            if (visType == "barChart") {
                var arr = [];
                var tick = Math.floor(data[0].count/10);
                for(var i = 0; i < data[0].count + 1; i++) {
                    arr.push(i*tick);
                }

                var visualization = d3plus.viz()
                 .container("#viz")
                 .data(data)
                 .type("bar")
                 .id(X)
                 .time("year")

                 .y({
                "scale": "discrete",

                   value: X,
                   grid: false
                 })
                 .x({
                   value: "count",
                   ticks: arr
                 })
                 .order({"value": "count", "sort":"asc"})
                 .color(X)
                 .height(20 * data.length + 100)
                 .draw()
            }

            window.scrollTo(0,document.body.scrollHeight);
            $('html,body').animate({scrollTop: document.body.scrollHeight},"fast");
        });
    }

    function insertTab() {
        return "&nbsp;&nbsp;&nbsp;&nbsp;";
    }
</script>
</body>
</html>