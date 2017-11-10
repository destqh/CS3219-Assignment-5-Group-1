var activities = document.getElementById("Y");
activities.addEventListener("change", function() {
    $('#myVal').attr('placeholder', 'Enter ' + $("#Y option:selected").text() + ' here');
});

<!-- dynamic input fields by reading the json file -->
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