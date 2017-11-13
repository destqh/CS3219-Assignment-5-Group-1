var MongoClient = require('./cir/application_server/node_modules/mongodb').MongoClient;
var url = "mongodb://localhost:27017/mydb";

MongoClient.connect(url, function(err, db) {
  	if (err) throw err;
 	db.collection('docs').find({}).toArray(function (err, docs) {
  		if (err) throw err;
    	console.log(docs.length);
    	db.close();
	}); 
});