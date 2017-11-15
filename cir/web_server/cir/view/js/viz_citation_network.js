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
    var visualization = d3plus.viz()
    .container("#viz")
    .type("rings")
    .data(dataset.data)
    .id("id")
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

var form = document.getElementById('title');

form.addEventListener('submit', function(e) {
    e.preventDefault(); // don't submit
    var title = document.getElementById("myVal").value;

    var citationType = form.elements["citationType"].value;
    console.log(citationType);
    console.log(title);
        
    if (title && citationType) 
        updateData(title, citationType);
    else
        alert("Please fill in all inputs");
});

function updateData(title, citationType) {
    d3.select("#viz").selectAll('*').remove();

// var title = "Low-density parity check codes over GF(q)";
    d3.json('http://localhost:3000/api/get-citation-network/' + title + '/' + citationType, function(error, dataset) {
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

    var colors = ["#C70039" ,  "#D0CA4C", "#000000  "];
    var colorMap = colors.slice(0,levelSize);


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

  
