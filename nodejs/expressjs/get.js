var express = require('express'); //returns a method
var app = express();
var path = require('path');
var fs = require('fs');
var port = 80;

let courses = [
	{id:1, name:'Javascript'},
	{id:2, name:'PHP'},
	{id:3, name:'MySQL'},
];

//Accessable files/dir for the app
app.use('/appAssets', express.static(__dirname + '/assets'));

//Home page
app.get('/', function(request, response){
	var name = request.query.name;
	response.end(name);
});

app.get('/app/test/:id', (request, response)=>{
	const course = courses.find(c=>c.id===parseInt(request.params.id));
	if(!course)
		response.status(404).send('The page you are trying is not found');
	else
		response.send('ID: '+JSON.stringify(course.id)+', Name: '+course.name);
});

//To check server is runnig or not running 
app.listen(port, function(){
	console.log("Server is listening on : " + port);
});