var express = require('express'); //returns a method
var app = express();
var path = require('path');
var fs = require('fs');
var port = 80;

//Accessable files/dir for the app
app.use('/appAssets', express.static(__dirname + '/assets'));

//Home page
app.get('/', function(request, response){
	response.sendFile('index.html', {root: path.join(__dirname, './allPages')});
});

//Any page
app.get(/^(.+)$/, function(request, response){
	try{
		if (fs.statSync(path.join(__dirname, './allPages/', request.params[0]+'.html')).isFile()) {
			response.sendFile(request.params[0]+'.html', {root: path.join(__dirname, './allPages')});
		}else{
			response.sendFile('404.html',{root: path.join(__dirname, './allPages')});
		}
	}catch(err){
		console.log(err);
		response.sendFile('404.html',{root: path.join(__dirname, './allPages')});
	}

});

//To check server is runnig or not running 
app.listen(port, function(){
	console.log("Server is listening on : " + port);
});