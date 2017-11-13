var MongoClient = require('./cir/application_server/node_modules/mongodb').MongoClient;
var url = "mongodb://localhost:27017/mydb";

MongoClient.connect(url, function(err, db) {
  if (err) throw err;
  db.collection("docs").drop(function(err, delOK) {
    if (err) console.log("'docs' has been deleted already");

    else if (delOK) console.log("Collection 'docs' deleted");
    
    else console.log("Problem deleting 'docs'")

    db.close();
  });
});


 