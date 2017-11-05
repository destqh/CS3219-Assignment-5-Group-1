const express = require('express');
const bodyParser = require('body-parser');
const mongojs = require('mongojs');
const db = mongojs('mydb', ['docs']);

const app = express();

const port = 3000;

// Fetch Top N Authors in a venue
app.get('/api/top-authors', (req, res, next) => {
	var inputQuery = { "venue": new RegExp(req.query.venue, 'i')};
	var outputQuery = { "authors.name": 1, "_id": 0 };

	db.docs.find(inputQuery, outputQuery).toArray(function(err, results) {
		if (err) {
			res.send(err);
		}
		
		var map = new Object();
		results.forEach(function(result) { 
			result.authors.forEach(function(author) {
				if (!map[author.name]) {
					map[author.name] = 0;
				}
				map[author.name]++;
			});
		});
		
		var authorList = new Array();
		Object.keys(map).forEach( (key) => {
			authorList.push({name: key, count: map[key]})
		});
		
		authorList.sort( (a, b) => { 
			return a.count>b.count? -1:a.count<b.count? 1:0; 
		});
		
		res.json(authorList.slice(0, req.query.rank));
	});
});


app.listen(port, () => {
	console.log('Server started on port ' + port);
});

module.exports = app;
