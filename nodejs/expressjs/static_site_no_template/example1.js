var express = require('express'); //returns a method
var app = express();
var path = require('path');
var fs = require('fs');
var port = 80;

//Accessable files/dir for the app
app.use('/appAssets', express.static(__dirname + '/assets')); //1. __dirname is current working directory (root), 2. express.static is built-in middleware function, 3. app.use for setting custom route

//Home page
app.get('/hi/:id', function(req, res){
	//response.sendFile('index.html', {root: path.join(__dirname, './allPages')});
	res.end(req.params.id);
});

//To check server is runnig or not running 
app.listen(port, function(){
	console.log("Server is listening on : " + port);
});