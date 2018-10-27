var express = require('express'); //returns a method
var app = express();
var port = 80;

var path = require('path');
var fs = require('fs');
var events = require('events');
var eventEmitter = new events.EventEmitter();
var serveStatic = require('serve-static');
var bodyParser = require('body-parser');

//Useable the POST request for the app
//app.use(bodyParser()); 
app.use(bodyParser.urlencoded({
	extended:true
}));
app.use(bodyParser.json());

//Accessable files/dir for the app
app.use('/appAssets', serveStatic(__dirname + '/assets')); //1. __dirname is current working directory (root), 2. express.static is built-in middleware function, 3. app.use for setting custom route

//About us page
app.get('/about/:id', function(req, res){
	res.sendFile('about.html', {root: path.join(__dirname, './allPages')});
	//console.log(path.join(__dirname, 'public')); //base_url/public
	//res.end(req.params.id);
});

//Login Form
app.get('/login', function(req, res){
	res.sendFile('login.html', {root: path.join(__dirname, './allPages')});
});

//POST Request/Login Form Action
app.post('/login_check', function(req, res){
	res.send(JSON.stringify(req.body));
	/*if(req.body.username =='admin' && req.body.pass=='...')
	{
		//Do action
	}
	else
	{
		//throw error
	}*/

});

//File Reading Asynchronously
fs.readFile('./allPages/about.html','utf8', function(error, data){
	//console.log(data);
});

//File Reading Synchronously
let data = fs.readFileSync('./allPages/about.html','utf8');
//console.log(data);

//File Writing Asynchronously
fs.writeFile('./allPages/test.html', 'Hello Test', 'utf8', function(err){
	if(err) throw err;
	//console.log('File written');
});

//File Writing Synchronously
fs.writeFileSync('./allPages/testSync.html', 'Hello Sync Test', 'utf8');

//Events and eventEmitter
eventEmitter.on('myCustomEvent', function(arg1, arg2){
	//console.log(arg1 + arg2);
});
//document.querySelector('yourTag').onclick=function(){...}
setTimeout(function(){
	eventEmitter.emit('myCustomEvent', 'String1 ', 'and String2');
}, 2000);

//To check server is runnig or not running 
app.listen(port, function(){
	console.log("Server is listening on : " + port);
});