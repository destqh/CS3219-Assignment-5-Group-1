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
                        <h1>Provide information</h1>
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
            $('#dynamic_field').append(
                '<div id="row' + i + '">' +
                '<div class="col-md-8">' +
                '<input type="text" name="name' + i + '" placeholder="Enter your value" class="form-control name_list" style="margin-top:10px" />' +
                '</div>' +
                '<div class="col-md-4">' +
                ' <button type="button" name="remove" id="' + i + '" class="btnRemove" style="margin-top:10px">X</button>' +
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
            console.log(trendType);
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
                    console.log(venueMap[key]);
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
                console.log(JSON.stringify(venueJSON));

    d3.json('http://localhost:3000/api/get-publications-trend-citation/' + JSON.stringify(venueJSON), function(error, dataset) {
            d3.select("#viz").selectAll('*').remove();

            if (dataset.error || error) {
                alert(dataset.error);
                return;
            }
            console.log(dataset);

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
            console.log(venueMap[key]);
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
        console.log(JSON.stringify(venueJSON));

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

        console.log("DATASET:" + JSON.stringify(dataset));
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
                    console.log("INPUT : " + JSON.stringify(dataset[x]));
                }
                for (var i = min; i <= max; i++) {
                    map[i] = new Array();
                }
                for (var x = 0; x < dataset.length; x++) {
                    map[dataset[x].year].push(dataset[x][trendType]);
                }

                
                var uniqueValues = Array.from(new Set(values));


                for (var i = min; i <= max; i++) {
                    if (venuesSet.length == 1) {

                        if(map[i] == undefined) {
                            var obj = {};
                            obj['year'] = i;
                            obj['count'] = 0;
                            obj[trendType] = Object.values(venueMap)[0]
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

          
            console.log("DATASET : " + JSON.stringify(dataset));

           
            console.log(dataset);

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
            console.log(document.body.scrollHeight);
    }
</script>
</body>
</html>