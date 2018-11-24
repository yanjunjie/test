var express = require('express'); //returns a method
var app = express();
var path = require('path');
var fs = require('fs');
var port = 8080;

//Accessable files/dir for the app
app.use('/appAssets', express.static(__dirname + '/assets')); //1. __dirname is current working directory (root), 2. express.static is built-in middleware function, 3. app.use for setting custom route

//Home page
app.get('/hi/:id', function(req, res){
	//response.sendFile('index.html', {root: path.join(__dirname, './allPages')});
	res.end(req.params.id);
});

//Login
app.get('/login', function(req, res){
	res.sendFile('login.html',{root: path.join(__dirname, './allPages')});
});

//Processing post data
app.post('/login_check', function(req, res){
	var username = req.body.username;
	var password = req.body.password;
	res.send(username);
});

//Next Test
var requestTime = function (req, res, next) {
  req.requestTime = Date.now();
  next();
}

//Make the middleware useable for all routing 
app.use(requestTime)

app.get('/next', function (req, res) {
  var responseText = 'Hello World!<br>'
  responseText += '<small>Requested at: ' + req.requestTime + '</small>'
  res.send(responseText)
});

//Next Test 2
app.get('/next2', function (req, res) {
  var responseText = 'Hello Next!<br>'
  responseText += '<small>Requested at: ' + req.requestTime + '</small>'
  res.send(responseText)
});



//To check server is runnig or not running 
app.listen(port, function(){
	console.log("Server is listening on : " + port);
});
