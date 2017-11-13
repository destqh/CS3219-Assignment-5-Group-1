module.exports.data_retrieval = data_retrieval;

const COLLECTION_NAME = "docs";
var db = new (require('./data_access')).data_access({name: COLLECTION_NAME});
var async = require('async');
var fs = require('fs');
const xml = require("xml-parse");
var xml2js = require('xml2js');
var readLine = require('readline');
var parser = new xml2js.Parser();

function data_retrieval()
{
    const AUTHOR = "author";
    const AUTHOR_NAME = "authors.name";
    const VENUE = "venue";
    const CITING_PAPER = "citingPaper";
    const CITED_PAPER = "citedPaper";
    const TYPE_XML = "text/xml";
    const TYPE_JSON = "application/json";
    const ENCODING_TYPE = "utf8";
    const XML_ROOT_OPENING_TAG = "<root>";
    const XML_ROOT_CLOSING_TAG = "</root>";
    const NEW_LINE = "\n";


    this.getPublicationsTrend = (req, res) => {

        var typeOfTrend = req.params.type;
        var data = JSON.parse(req.params.value);''
        var inputValues = data.values;
        var inputQuery = [];
        var projectQuery = [];

        for (var i = 0; i < inputValues.length; i++) {
            inputValues[i] = replacePlusSignWithSpace(inputValues[i].toLowerCase());
            var typeOfTrendObj = {};
            var projectObj = { "_id": 0, "year": "$_id", "count": "$count" };
            var matchType = typeOfTrend;

            if (typeOfTrend == AUTHOR) 
                matchType = AUTHOR_NAME;
            
            typeOfTrendObj[matchType] = inputValues[i];
            projectObj[typeOfTrend] = inputValues[i];

            inputQuery[i] = { $match: typeOfTrendObj };
            projectQuery[i] = { $project: projectObj };
        }

        var groupQuery = { $group: { _id: "$year", count: { $sum: 1 } } };
        var matchQuery = { $match: { count: { $gt: 0 } } };
        var sortQuery = { $sort: { _id: 1 } };

        var threadQueries = [];
        var query = [];

        for (var i = 0; i < inputValues.length; i++) {
            if (typeOfTrend == AUTHOR) {
                query[i] = pipelineQuery([{ "$unwind": "$authors" }, inputQuery[i], groupQuery, matchQuery, sortQuery, projectQuery[i]]);
            }
            else {
                query[i] = pipelineQuery([inputQuery[i], groupQuery, matchQuery, sortQuery, projectQuery[i]]);
            }
        }

        for (var i = 0; i < query.length; i++) {
            threadQueries[i] = db.getDocuments(query[i]);
        }
        async.parallel(threadQueries, function(err, results){
            if(err) throw err;
            var finalResults = [];
            for(var i = 0; i < inputValues.length; i++) {
                if (results[i].length == 0) {
                    res.json({ "error": typeOfTrend + " " + "'" + inputValues[i] + "'" + " not found!"});
                    return;
                }
                finalResults = combineTwoArrays(finalResults, results[i]);

            }
            res.json(finalResults);
        });   
    }

    this.getPublicationsTrendCitation = (req, res) => {
        var data = JSON.parse(req.params.titles);
        var titles = data.values;

        var threadQueries = [];
        var validPapers = [];

        for (var i = 0; i < titles.length; i++) {
            titles[i] = replacePlusSignWithSpace(titles[i].toLowerCase());

            var inputQuery = { "title": titles[i] };
            var outputQuery = { "incitations": 1, "_id": 0, "id": 1};

            threadQueries.push(db.getDocument(inputQuery, outputQuery));
        }

        async.series(threadQueries, function(err, results) {
            if (err) throw err;
            for(var i = 0; i < results.length; i++) {
                if (results[i] == null) {
                    res.json({ "error": "title " + "'" + titles[i] + "'" + " not found!"});
                    return;
                }
                if (results[i].length == 0) {
                    res.json({ "error": "title " + "'" + titles[i] + "'" + " not found!"});
                    return;
                }
            }

            var inCitationsCountArray = [];
            var threadQueries = [];
            var query = [];
            var totalInCitationsCount = 0;

            for(var i = 0; i < results.length; i++) {
                totalInCitationsCount += results[i].incitations.length;
                inCitationsCountArray.push(totalInCitationsCount);
            }
            
            for (var i = 0; i < results.length; i++) {
                var citeResult = results[i];
                
                for (var j = 0; j < citeResult.incitations.length; j++) {
                    query.push({id: citeResult.incitations[j]});
                }
                for (var j = 0; j < citeResult.incitations.length; j++) {
                    threadQueries.push(db.getDocument(query[j], {}));
                }        
            }

            async.series(threadQueries, function(err, results){
                var arrYear = [];
                var arrCount = [];
                var counter = 0;
                var citationCount = 0;

                for(var index = 0; index < results.length; index++) {
                    if (results[index] != null) {
                        if (results[index].authors != undefined) {
                            if (results[index].year != undefined) {
                                arrYear.push(results[index].year);
                                citationCount++;
                            }
                        }
                    }
                    
                    if (index == inCitationsCountArray[counter] - 1) {
                        arrCount.push(citationCount);
                        counter++;
                        citationCount = 0;
                    }
                }

                var data = new Array();
                var index = 0;
                
                for(var i = 0; i < titles.length; i++) {
                    var temp = arrYear.slice(index, index + arrCount[i]);
                    data.push(temp);
                    index = index + arrCount[i];
                }
                var json = [];

                for(indexTitle in data) {
                    var mapYear = {};
                    var arrYear = data[indexTitle];

                    for (var index = 0; index < arrYear.length; index++) {
                        mapYear[arrYear[index]] = 0;
                    }

                    for (var index = 0; index < arrYear.length; index++) {
                        if(mapYear[arrYear[index]] != undefined) {
                            mapYear[arrYear[index]] =  mapYear[arrYear[index]] + 1;
                        }
                    }

                    var title = titles[indexTitle];
                    for(key in mapYear) {
                        var year = parseInt(key);
                        if (year)
                            json.push({title:title, year:key, count:mapYear[key]});
                    }

                }
                res.json(json);

            });


        });
    }

    this.getTopNXY = (req, res) => {
        var Y = req.params.Y;
        var X = req.params.X;
        var typeObjY = {};
        var typeObjX = {};
       
        typeObjY[Y] = req.params.value.toLowerCase();
        typeObjX["_id"] = 0;
        var query = [];
        var inputQuery = { $match: typeObjY };
        var sizeQuery = {};
        if (X == CITED_PAPER) {
            sizeQuery["$size"] = "$incitations";
        }

        if (X == CITING_PAPER) {
            sizeQuery["$size"] = "$outcitations";
        }

        if (X == CITED_PAPER || X == CITING_PAPER) {
            typeObjX[X] = "$title";
            typeObjX["count"] = sizeQuery;
            var projectQuery = { "$project": typeObjX };
            var sortQuery = { "$sort": { "count": -1 } };
            query = [inputQuery, projectQuery, sortQuery];
        }

        if (X == AUTHOR) {
            var groupQuery = { $group: { _id: "$authors.name", year: { $push : "$year" }, count: { $sum: 1 } } };
            var sortQuery = { $sort: { count: -1 } };
            var projectQuery = { $project: { _id: 0, "author": "$_id", count: "$count", year:"$year" } };
            var unwindQuery = { "$unwind": "$authors" };
            query = [inputQuery,unwindQuery,groupQuery, sortQuery, projectQuery];
        }
        if (X == VENUE) {
            var matchQuery = { $match: { venue: { $exists: true, $ne: "" } } };
            var groupQuery = { $group: { _id: "$venue", count: { $sum: 1 }, year: { $push : "$year" } } };
            var sortQuery = { $sort: { count: -1 } };
            var matchQuery2 = { $match: { count: { $gt: 0 } } };
            var projectQuery = { $project: { _id: 0, venue: "$_id", count: "$count", year:"$year" } };
            query = [inputQuery, matchQuery, groupQuery, matchQuery2, sortQuery, projectQuery];
        }
            
        var threadQueries = [db.getDocuments(query)];

        async.parallel(threadQueries, function(err, results){
            var topPapers = results[0].slice(0, req.params.N);
            res.json(topPapers);
        });
    }

    this.getCitationNetwork = (req, res) => {
        var title = req.params.title.toLowerCase();
        var visType = req.params.type;
        var inputQuery = { "title": title };

        var outputQuery = { "_id" : 0, "id" : 1, "year": 1 };
        outputQuery[visType] = 1;


        var map = new Object();
        var inGraph = new Array();

        var threadQueryLevelOne = [db.getDocument(inputQuery, outputQuery)];

        async.parallel(threadQueryLevelOne, function(err, resultDatum) {
            if (err) throw err;

            var datum = resultDatum[0];
            console.log(datum);
        
            if (!datum) {
                res.json(inGraph);
                return;
            }

            var query = [];
            var threadQueryLevelTwo = [];
            var threadQueryLevelThree = [];

            for (var i = 0; i < datum[visType].length; i++) {
                query[i] = {id: datum[visType][i]};
            }
            for (var i = 0; i < query.length; i++) {
                threadQueryLevelTwo[i] = db.getDocument(query[i], {});
            }

            var count = 0;
            var mapId = {};
            var inGraph = [];
            var indexArray = [];
            var totalCitationLength = 0;
            var data = [];

            data.push({"id": title, "title": title, "level": 1, "year":datum.year});

            async.parallel(threadQueryLevelTwo, function(err, levelTwoResults){
                for(index in levelTwoResults) {
                    if (levelTwoResults[index] != null) {
                        if (levelTwoResults[index].authors != undefined) {
                            count ++;

                            var secondLevel = levelTwoResults[index];
                            var secondLevelId = secondLevel.id;

                            if (visType == "incitations")
                                inGraph.push({"source": secondLevel.title, "target": title});
                            else
                                inGraph.push({"source": title, "target": secondLevel.title});

                            data.push({"id": secondLevel.title, "title":secondLevel.title, "level":2, "year": secondLevel.year});

                            if (secondLevel[visType].length > 0) {
                                if (indexArray.length == 0) {
                                    indexArray.push({index:0, id:secondLevel.id, title: secondLevel.title });
                                    totalCitationLength += secondLevel[visType].length;
                                }
                                else {
                                    indexArray.push({index:totalCitationLength, id:secondLevel.id, title: secondLevel.title});
                                    totalCitationLength += secondLevel[visType].length;

                                }
                                var secondQuery = [];

                                for (var i = 0; i < secondLevel[visType].length; i++) {
                                    secondQuery.push({id: secondLevel[visType][i]});
                                }
                                for (var i = 0; i < secondQuery.length; i++) {
                                    threadQueryLevelThree.push(db.getDocument(secondQuery[i], {}));
                                }
                            }          
                        }
                    }
                }
                var secondCount = 0;
                var targetId = null;
                async.parallel(threadQueryLevelThree, function(err, levelThreeResults){
                    for(index in levelThreeResults) {
                        if (levelThreeResults[index] != null) {
                            if (levelThreeResults[index].authors != undefined) {
                                for(i in indexArray) {
                                    if (index < indexArray[i].index) {
                                        targetId = indexArray[i-1].title;
                                        break;
                                    }
                                }
                                var thirdLevel = levelThreeResults[index];
                                var thirdLevelId = thirdLevel.id;

                                secondCount ++;
                                var notExist = true;
                                if (targetId != null) {
                                    if (visType == "incitations")
                                        inGraph.push({"source": thirdLevel.title, "target": targetId});
                                    else 
                                        inGraph.push({"source": targetId, "target": thirdLevel.title});
                                }
                                for(index in data) {
                                    if (data[index].id == thirdLevel.title) {
                                        notExist = false;
                                        break;
                                    }
                                }

                                if (notExist) {
                                    data.push({"id": thirdLevel.title, "title":thirdLevel.title, "level":3, "year": thirdLevel.year});
                                }

                            }
                        }
                    }
                    res.json({data: data, connections:inGraph});

                });      
                
            });
            
        });
    }

    this.getAllAuthors = (req,res) => {
        var groupQuery = { $group: { _id: "$authors.name", count: { $sum: 1 } } };
            var projectQuery = { $project: { _id: 0, "value": "$_id"} };
            var unwindQuery = { "$unwind": "$authors" };
            query = [unwindQuery,groupQuery, projectQuery];

        var arrTask = [db.getDocuments(query)];
        async.series(arrTask, function(err, results)
                        {
                            if(err) throw err;
                            res.json(results[0]);
                        });

    }

    this.postUpload = (req,res) => {

        if (req.files.fileToUpload) {
            var file = req.files.fileToUpload, fileName = file.name, fileType = file.mimetype;

            if (fileType == TYPE_XML) {
                fs.readFile(fileName, ENCODING_TYPE, function(err, data) {
                    
                    var xmlData = XML_ROOT_OPENING_TAG + NEW_LINE + data + NEW_LINE + XML_ROOT_CLOSING_TAG;

                    parser.parseString(xmlData, function (err, result) {

                        var papersJson = normalize(result.root.papers);
                        var collectionName = COLLECTION_NAME;
                        var arrTask = [db.deleteDocument(collectionName), db.insertDocument(papersJson, collectionName)];
                        async.series(arrTask, function(err, results)
                        {
                            if(err) throw err;
                            console.log("Successfully imported " + collectionName + '.xml !');
                            // db.close(); 
                            res.send("<center>" + 'Uploaded ' + fileName  + ' successfully! <a target=\"_parent\" href=\"http://localhost:8080/index.php#visualization\">Click here to choose visualization</a>' + "</center>");
                        });
                    });
                });
    
            }

            if (fileType == TYPE_JSON) {
                var uploadpath = __dirname + '/' + fileName;

                file.mv(uploadpath,function(err){
                    if (err) {
                        console.log("File Upload Failed!",fileName,err);
                        res.send("<center>" + "File Upload Failed. Please Try Again." + "</center>");
                    }
                    else {
                        console.log("File Uploaded!",fileName);
                        importData(fileName,res);      
                    }

                });
            }

            if (fileType != TYPE_JSON && fileType != TYPE_XML) {
                res.send("<center>" + "Your file is not in json/xml format. Please use json/xml format." + "</center>")
                res.end();
            }
        
        }

        else {
            res.send("<center>" + "No File selected. Please choose a file to upload." + "</center>");
            res.end();
        };

    }

    function normalize(json) {
        var normalizeDatumArray = new Array();

        for (var i = 0; i < json.length; i++) {
            var normalizeDatum = {};
            var datum = json[i];
            if (datum.authors) {
                normalizeDatum['authors'] = [];
                for (var j = 0; j < datum.authors.length; j++) {
                    normalizeDatum['authors'].push({ ids: arrayToLowerCase(datum.authors[j].ids), name: datum.authors[j].name[0].toLowerCase() });
                }
            }

            normalizeDatum.id = datum.id[0].toLowerCase();

            if (datum.incitations) {
                normalizeDatum.incitations = arrayToLowerCase(datum.incitations);
            }

            if (datum.outcitations) {
                normalizeDatum.outcitations = arrayToLowerCase(datum.outcitations);
            }

            if (datum.paperabstract) {
                normalizeDatum.paperabstract = datum.paperabstract[0].toLowerCase();
            }

            if (datum.s2url) {
                normalizeDatum.s2url = datum.s2url[0].toLowerCase();
            }

            normalizeDatum.title = datum.title[0].toLowerCase();

            if (datum.venue) {
                normalizeDatum.venue = datum.venue[0].toLowerCase();
            }

            if (datum.year) {
                normalizeDatum.year = parseInt(datum.year[0]);
            }

            if (datum.keyphrases) {
                normalizeDatum.keyphrases = arrayToLowerCase(datum.keyphrases);
            }
            normalizeDatumArray.push(normalizeDatum);
   
        }

        return normalizeDatumArray;
    }

    function arrayToLowerCase(array) {
        var lowerCaseArray = new Array(); 
        for (var i = 0; i < array.length; i++) {
            lowerCaseArray.push(array[i].toLowerCase());
        }
        return lowerCaseArray;
    }

    function importData(fileName,res) {
        var lineReader = readLine.createInterface({
          input: fs.createReadStream(fileName)
        });

        var docsCount = 0;
        var arrayLines = Array();
        var collectionName = COLLECTION_NAME;

        console.log("Writing to array...");

        lineReader.on('line', function (line) {
            var lowerCaseLine = line.toLowerCase();
            var json = JSON.parse(lowerCaseLine);
            
            arrayLines.push(json);
            
        }).on('close', function() {
            console.log("Finish writing to array.");

            var arrTask = [db.deleteDocument(collectionName), db.insertDocument(arrayLines, collectionName), db.createIndex(collectionName)];
            async.series(arrTask, function(err, results)
            {
                if(err) throw err;
                console.log("Successfully imported " + collectionName + '.json !');

                var groupQuery = { $group: { _id: "$authors.name", count: { $sum: 1 } } };
                var projectQuery = { $project: { _id: 0, "value": "$_id"} };
                var unwindQuery = { "$unwind": "$authors" };
                query = [unwindQuery,groupQuery, projectQuery];

                var arrTask = [db.getDocuments(query)];
                async.series(arrTask, function(err, results)    {
                    if(err) throw err;
                    var content = results[0];

                    var file = fs.createWriteStream('allAuthors.json');
                    file.on('error', function(err) { /* error handling */ });
                    content.forEach(function(v) { 
                        if(v.value.indexOf("�") == -1)
                            file.write(JSON.stringify(v, 'utf8')+ ',' + '\n'); 
                    });
                    file.end();
                    
                    console.log("The file was saved!");
                    res.send('<center>' + 'Uploaded ' + fileName  + ' successfully! <a target=\"_parent\" href=\"http://localhost:8080/index.php#visualization\">Click here to choose visualization</a>' + '</center>');
                    fs.unlinkSync(fileName); 
              
                });
                        
            });
                                              
        });

    }

    function pipelineQuery(queries) {
        var pipeline = new Array();
        for(var i = 0; i < queries.length; i++) {
            pipeline.push(queries[i]);
        }
        return pipeline;
    }
    function combineTwoArrays(array1, array2) {
        if (array1 == null)
            return array2;
        if (array2 == null)
            return array1;

        if (array1.length == 0) 
            return array2;

        var result = array1;
        for(var i = 0; i < array2.length; i++) {
            result.push(array2[i]);
        }
        return result;
    }

    function replacePlusSignWithSpace(string) {
        return string.replace(/\+/g, " ");
    }
}