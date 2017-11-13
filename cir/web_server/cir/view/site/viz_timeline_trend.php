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

<!--     <script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
 --><!--   <script type="text/javascript" src="../js/jquery.autocomplete.min.js"></script>
 --> 

</head>
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
<body onload="setTimeout(function(){window.scrollTo(0,document.body.scrollHeight)}, 1000);">

    <!-- Visulization input section -->
<div class="w3-container w3-light-grey" style="padding:28px 16px">
    <div align="center" class="w3-row-padding" style="margin-top:64px; background-color: #C0C0C0;">
<!--         <div class="w3-half">
 -->        <div class="form-group" style="width:500px; text-align: center; ">

                <form name="add_name" id="add_name">
                    <div class="col-md-12">
                        <h1>Conference Timeline Trend</h1>
                        <div  style="display: inline-block;">
                        <h4> Attribute: </h4>
                        </div>
                        <div  style="display: inline-block;">

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
<!--         </div>
 -->    </div>
</div>

<div id="viz"></div>

<script>
        $('#inputText').attr('placeholder', 'Enter ' + $("#trendType option:selected").text() + ' here');
        var activities = document.getElementById("trendType");
        activities.addEventListener("change", function() {
            $('#inputText').attr('placeholder', 'Enter ' + $("#trendType option:selected").text() + ' here');

            var add_name = document.getElementById("add_name");
            var elements = add_name.getElementsByTagName('input');
            for(var i = 0; i < elements.length; i++) {
                if (elements[i].type == "text") {
                    elements[i].placeholder = 'Enter ' + $("#trendType option:selected").text() + ' here';
                }
            }
        });

  
  

</script>

<script>
    function URLToArray(url) {
        var request = {};
        var pairs = url.substring(url.indexOf('?') + 1).split('&');
        for (var i = 0; i < pairs.length; i++) {
            if (!pairs[i])
                continue;
            var pair = pairs[i].split('=');
            request[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1]);
        }
        return request;
    }

    $(document).ready(function() {
        var i = 1;
        $('#add').click(function() {
            i++;
            var inputTextID = "inputText" + i;
            var enterText = 'Enter ' + $("#trendType option:selected").text() + ' here';
            $('#dynamic_field').append(
                '<div id="row' + i + '">' +
                '<div class="col-md-10">' +
                '<input id="' + inputTextID + '" type="text" name="name' + i + '" placeholder="' + enterText + '" class="form-control name_list biginput" style="margin-top:10px" />' +
                '</div>' +
                '<div class="col-md-2">' +
                ' <button type="button" name="remove" id="' + i + '" class="btnRemove btn-info" style="margin-top:10px">X</button>' +
                ' </div>' +
                '</div>'
            );
             
        });
        $(document).on('click', '.btnRemove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();

        });
        $('#submit').click(function() {
            var venueMap = $('#add_name').serialize();
            var trendType = document.getElementById("trendType").value;
            if (trendType == "title") {
                updateDataTitle(URLToArray(venueMap));
            }
            else
                updateData(URLToArray(venueMap), trendType);
        });
    });

    function updateDataTitle(venueMap) {
         d3.select("#viz").selectAll('*').remove();

                var isEmpty = false;
                for (index in venueMap) {
                    if (venueMap[index] == "")
                        isEmpty = true;
                }
                if (isEmpty) {
                    alert("Venue field/s cannot be empty!");
                    return;
                }
                var venuesList = new Array();
                for (key in venueMap) {
                    venuesList.push(venueMap[key]);
                }

                venuesSet = Array.from(new Set(venuesList));

                if (venuesSet.length != venuesList.length) {
                    var r = confirm("There seem to be duplicate entries for more than one venue. Are you sure you want to continue?");
                    if (r == false) {
                        return false;

                    } 
                }
                
                

                var venueJSON = {
                    values: venuesSet
                };

    d3.json('http://localhost:3000/api/get-publications-trend-citation/' + JSON.stringify(venueJSON), function(error, dataset) {
        console.log(dataset);
            d3.select("#viz").selectAll('*').remove();
            if (error)  throw error;
            if (dataset.error) {
                alert(dataset.error);
                return;
            }

            visData(dataset, "title", venuesSet, venueMap);
        });
    }
    function updateData(venueMap, trendType) {
        d3.select("#viz").selectAll('*').remove();

        var isEmpty = false;
        for (index in venueMap) {
            if (venueMap[index] == "")
                isEmpty = true;
        }
        if (isEmpty) {
            alert("Venue field/s cannot be empty!");
            return;
        }
        var venuesList = new Array();
        for (key in venueMap) {
            venuesList.push(venueMap[key]);
        }

        venuesSet = Array.from(new Set(venuesList));

        if (venuesSet.length != venuesList.length) {
            var r = confirm("There seem to be duplicate entries for more than one venue. Are you sure you want to continue?");
            if (r == false) {
                return false;

            } 
        }
        
        

        var venueJSON = {
            values: venuesSet
        };

        d3.json('http://localhost:3000/api/get-publications-trend/' + trendType + '/' + JSON.stringify(venueJSON), function(error, dataset) {
            if (error) throw error;
            if (dataset.error) {
                alert(dataset.error);
                return;
            }

            visData(dataset, trendType, venuesSet, venueMap);
    });

    }

    function visData(dataset, trendType, venuesSet, venueMap) {

                var map = new Object();
                var min = Infinity,
                    max = -Infinity,
                    x;
                for (x in dataset) {
                    if (dataset[x].year < min) min = dataset[x].year;
                    if (dataset[x].year > max) max = dataset[x].year;
                }

                var values = new Array();;

                for (var x = 0; x < dataset.length; x++) {
                    values.push(dataset[x][trendType]);
                }
                for (var i = min; i <= max; i++) {
                    map[i] = new Array();
                }

                console.log(min);
                console.log(max);
                for (var x = 0; x < dataset.length; x++) {
                    
                    map[dataset[x].year].push(dataset[x][trendType]);
                }

                
                var uniqueValues = Array.from(new Set(values));
                


                for (var i = min; i <= max; i++) {
                    if (venuesSet.length == 1) {

                        if(map[i].length == 0) {
                            var obj = {};
                            obj['year'] = i;
                            obj['count'] = 0;
                            obj[trendType] = uniqueValues[0];
                            dataset.push(obj);

                        }
                    }
                    else {
                        Array.prototype.diff = function(a) {
                            return this.filter(function(i) {
                                return a.indexOf(i) < 0;
                            });
                        };
                        if (uniqueValues.diff(map[i]).length != 0) {
                            for (var j = 0; j < uniqueValues.diff(map[i]).length; j++) {

                                var obj = {};
                                obj['year'] = i;
                                obj['count'] = 0;
                                obj[trendType] = uniqueValues.diff(map[i])[j]
                                dataset.push(obj);
                            }

                        }
                    }
                }

          
            console.log("DATASET: " + JSON.stringify(dataset));

            var visualization = d3plus.viz()
                .container("#viz")
                .data(dataset)
                .type("line")
                .id(trendType)
                .y("count")
                .x("year")
                .time({"value": "year"})
                .draw();

            window.scrollTo(0,document.body.scrollHeight);
            $('html,body').animate({scrollTop: document.body.scrollHeight},"fast");
    }
</script>
</body>
</html>