const express = require('express');
const bodyParser = require('body-parser');
var upload = require('express-fileupload');
const app = express();
const port = 3000;

//temp only
const mongojs = require('mongojs');
const db = mongojs('mydb');
// var db = new (require('./data_access')).data_access({name: "docs"});
var async = require('async');


var data_retrieval = new (require('./data_retrieval')).data_retrieval();

// change path here
app.use(express.static('/Users/musa/CIR'));

app.use(bodyParser.json());

app.use(upload());

function initResponseHeader(res) {
    res.header("Access-Control-Allow-Origin", "*");
}


app.get('/', (req, res, next) => {
    res.sendFile('/index.html');
});

// http://localhost:3000/api/get-publications-trend-venues/{"venues":["icse","arxiv","ics"]}
//http://localhost:3000/api/get-publications-trend/authors.name/{"authors.name":["wei+wang"]}
app.get('/api/get-publications-trend/:type/:value', (req, res, next) => {

    initResponseHeader(res);

    data_retrieval.getPublicationsTrend(req, res);

});
//localhost:3000/api/get-publications-trend-citation/{"values":["low-density+parity+check+codes+over+gf(q)","mimo-ofdm over an underwater acoustic channel"]}
app.get('/api/get-publications-trend-citation/:titles', (req, res, next) => {
    initResponseHeader(res);

    data_retrieval.getPublicationsTrendCitation(req, res);

});


app.get('/api/get-top-N-X-Y/:N/:X/:Y/:value/', (req, res, next) => {

    initResponseHeader(res);

    data_retrieval.getTopNXY(req, res);    
    

});


app.get('/api/get-citation-network/:title/:type', (req, res, next) => {

    initResponseHeader(res);
    
    data_retrieval.getCitationNetwork(req, res);
});

app.post('/upload',function(req,res){
    
  data_retrieval.postUpload(req, res); 
  
})





app.listen(port, () => {

	console.log('Server.start on port ' + port);
});




module.exports = app;