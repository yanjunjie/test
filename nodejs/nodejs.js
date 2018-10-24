/*
var requestListener = function(request, response){
	response.writeHead(200, {"content-type":"text/html"});
	response.write("<h1>Alhamdulillah</h1>");
	response.end();
};
*/

var http = require("http");
var about = require("./bab");
var port = 3000;

http.createServer(function(request, response){
	response.writeHead(200, {"content-type":"text/html"});
	response.write(about.name);
	about.myFun();
	response.end();
}).listen(port);
console.log("Server is working on :" + port);