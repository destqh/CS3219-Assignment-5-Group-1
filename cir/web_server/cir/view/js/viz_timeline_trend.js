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
        var valueMap = $('#add_name').serialize();
        var trendType = document.getElementById("trendType").value;
        if (trendType == "title") {
            updateDataTitle(URLToArray(valueMap));
        }
        else
            updateData(URLToArray(valueMap), trendType);
    });
});

function updateDataTitle(valueMap) {
     d3.select("#viz").selectAll('*').remove();

            var isEmpty = false;
            for (index in valueMap) {
                if (valueMap[index] == "")
                    isEmpty = true;
            }
            if (isEmpty) {
                alert("Please input all fields!");
                return;
            }
            var valuesList = new Array();
            for (key in valueMap) {
                valuesList.push(valueMap[key]);
            }

            valuesSet = Array.from(new Set(valuesList));

            if (valuesSet.length != valuesList.length) {
                var r = confirm("There seem to be duplicate entries for more than one field. Are you sure you want to continue?");
                if (r == false) {
                    return false;

                } 
            }
            
            

            var valueJSON = {
                values: valuesSet
            };

    d3.json('http://localhost:3000/api/get-publications-trend-citation/' + JSON.stringify(valueJSON), function(error, dataset) {
    console.log(dataset);
        d3.select("#viz").selectAll('*').remove();
        if (error)  throw error;
        if (dataset.error) {
            alert(dataset.error);
            return;
        }

        visData(dataset, "title", valuesSet, valueMap);
    });
}

function updateData(valueMap, trendType) {
    d3.select("#viz").selectAll('*').remove();

    var isEmpty = false;
    for (index in valueMap) {
        if (valueMap[index] == "")
            isEmpty = true;
    }
    if (isEmpty) {
        alert("Please input all fields!");
        return;
    }
    var valuesList = new Array();
    for (key in valueMap) {
        valuesList.push(valueMap[key]);
    }

    valuesSet = Array.from(new Set(valuesList));

    if (valuesSet.length != valuesList.length) {
        var r = confirm("There seem to be duplicate entries for more than one field. Are you sure you want to continue?");
        if (r == false) {
            return false;

        } 
    }
    
    

    var valueJSON = {
        values: valuesSet
    };

    d3.json('http://localhost:3000/api/get-publications-trend/' + trendType + '/' + JSON.stringify(valueJSON), function(error, dataset) {
        if (error) throw error;
        if (dataset.error) {
            alert(dataset.error);
            return;
        }

        visData(dataset, trendType, valuesSet, valueMap);
    });

}

function visData(dataset, trendType, valuesSet, valueMap) {

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
        if (valuesSet.length == 1) {

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
