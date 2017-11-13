var MongoClient = require('../cir/application_server/node_modules/mongodb').MongoClient;
var url = "mongodb://localhost:27017/mydb";

MongoClient.connect(url, function(err, db) {
  if (err) throw err;
  db.createCollection("docs", function(err, res) {
    if (err) throw err;
    console.log("Collection 'docs' created!");
    db.close();
  });
});