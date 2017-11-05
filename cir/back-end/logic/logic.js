const express = require('express');
var async = require('async');
const bodyParser = require('body-parser');
const app = express();
const port = 3000;

var database = require('./database');
var db = new database.Database({name: "docs"});


// change path here
app.use(express.static('/Users/musa/CIR'));

app.use(bodyParser.json());

function initResponseHeader(res) {
    res.header("Access-Control-Allow-Origin", "*");
}


app.get('/', (req, res, next) => {
    res.sendFile('/index.html');
});