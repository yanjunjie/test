/*
var http = require("http");
var port = 3000;
var requestListener = function(request, response){
	response.writeHead(200, {"content-type":"text/html"});
	response.write("<h1>Alhamdulillah</h1>");
	response.end();
};
var server = http.createServer(requestListener); //Server Creation
server.listen(port, function(){ 
	console.log("Server is running on port:" + port); //The web server will run on this port
});

*/

//var express = require('express');
//var app = express();
var app = require('express')(); //server creation

app.get('/bablu', function(request, response){ //response data
	response.send('Hello world!!');
});

app.listen(80, function(){
	console.log("Server is listening on :"+80); //the web server will run on this port
});



