const mongojs = require('mongojs');
const db = mongojs('mydb');

module.exports.data_access = data_access;

function data_access(collection)
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

	
	this.insertDocument = function (data, collectionName) {
		return function(callback) {
			db.collection(collectionName).insert(data, callback);
		}
	}; 

	this.deleteDocument = function (collectionName) {
		return function(callback) {
			db.collection(collectionName).remove({}, callback);
		}
	}; 
}
