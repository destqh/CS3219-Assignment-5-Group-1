var MongoClient = require('../node_modules/mongodb').MongoClient;
var url = "mongodb://localhost:27017/mydb";

var lineReader = require('readline').createInterface({
  input: require('fs').createReadStream('./dbdata/papers-2017-10-30-sample.json')
});

var docsCount = 0;
var arrayLines = Array();


console.log("Writing to array...");
lineReader.on('line', function (line) {
  	var json = JSON.parse(line);
  			
  		arrayLines.push(json);
  	
		
	}).on('close', function() {
		console.log("Finish writing to array.");
		MongoClient.connect(url, function(err, db) {
				if (err) throw err;
				
			

				db.collection('docs').insert(arrayLines, function(err2, doc) {
  					if(err2) throw err2;
  					if(doc) {
  						console.log("Successfully imported docs!");
  						db.close();
  					}


				});

			// console.log("Total number of lines: " + arrayLines.length);
			
				// console.log("Successfully imported docs!");

				//db.close();
		

		
	})
		
// db.close();
	});




