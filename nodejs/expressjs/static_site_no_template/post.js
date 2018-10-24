var express = require('express'); //returns a method
var app = express();
var path = require('path');
var fs = require('fs');
var port = 80;

//Accessable files/dir for the app
app.use('/appAssets', express.static(__dirname + '/assets'));

//For parsing request body in json format it's by default disabled 
app.use(express.json());

//Home page
app.get('/', function(request, response){
	response.sendFile('form.html', {root: path.join(__dirname, './allPages')}); //Path is an object and its property is join 
});

//Processing post data
app.post('/process.html', function(request, response){
	var username = request.body.username;
	var password = request.body.password;
	response.send(username);
});

//To check server is runnig or not running 
app.listen(port, function(){
	console.log("Server is listening on : " + port);
});