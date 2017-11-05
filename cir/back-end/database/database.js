const mongojs = require('mongojs');
const db = mongojs('mydb');

module.exports.Database = Database;

function Database(collection)
{
	var collection = collection;

	this.getCollectionName = function()
	{
	   return collection.name;
	};

	this.close = function()
	{
	   db.close();
	};

	this.getDocuments = function (aggregateQuery) {
		return function(callback) {
			db.collection(collection.name).aggregate(aggregateQuery, callback);
		}
	}; 

	this.getDocument = function (inputQuery, outputQuery) {
		return function(callback) {
        	db.collection(collection.name).findOne(inputQuery, outputQuery, callback);
		}
	}; 
}
