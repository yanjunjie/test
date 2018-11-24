var express = require('express'); //returns a method
var app = express();
var cookieParser = require('cookie-parser');
var session = require('express-session');
var serveStatic = require('serve-static');
var bodyParser = require('body-parser');
var events = require('events');
var path = require('path');
var fs = require('fs');

var port = 80;
var eventEmitter = new events.EventEmitter();

//Useable the POST request for the app
//app.use(bodyParser()); 
app.use(bodyParser.urlencoded({
	extended:true
}));
app.use(bodyParser.json());
app.use(cookieParser('hi this is secret key'));
app.use(session({secret:"aldsfj",resave:false,saveUninitialized:true}));
//app.use(express.static(__dirname + './assets'));
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

//Cookie Set/Write
app.get('/',function(req, res){
	//Coockie Set
	res.cookie('cookie1', 'This is my first cookie', {signed:true, maxAge: 1000*60*60*24*7, httpOnly: true});
	//console.log('Cookies: ', req.cookies); //Remember cookie presents on response object
	//console.log('Signed Cookies: ', req.signedCookies);

	res.end('Cookie has been set');
});

//Cookies Read
app.get('/readCookies',function(req, res){
	//Read the cookies
	//console.log(req.cookies);
	res.send(req.signedCookies['cookie1']);
});

//Remove Cookies
app.get('/removeCookies',function(req, res){
	//Read the cookies
	res.clearCookie('cookie1');
	res.send("Cookie has been cleared");
});

//Set session
app.get('/setSes',function(req, res){
	req.session.username = 'bablu'; //Remember session presents on request object
	req.session.password = 'secret';
	res.end('Session has been set');
});

//Read session
app.get('/readSes',function(req, res){
	res.send(req.session.username);
});

//Destroy session
app.get('/destroySes',function(req, res){
	req.session.destroy();
	res.send('Session has been destroyed');
});

//Destroy separate session
app.get('/deleteSes',function(req, res){
	delete req.session.username;
	req.session.username=null;
	res.send('Username session property has been deleted');
});





//To check server is runnig or not running 
app.listen(port, function(){
	console.log("Server is listening on : " + port);
});
