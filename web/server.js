var express = require('express'),
	fs = require('fs'),
	stylus = require('stylus'),
	app = express();

app.use(require('morgan')("combined"));	
app.use(express.static(__dirname));

app.listen(8100,function(){
	console.log('serwer ruszył - http://localhost:8100');
});

fs.writeFile('index.html',require('jade').renderFile('views/index.jade'),function(err){
		if(err)console.log(err.stack);
		console.log('index.html skompilowany');
	});
fs.readFile('views/main.styl',function(err,file){
	if(err)console.log(err.stack);
	fs.writeFile('css/main.css',stylus.render(file.toString()),function(){
		console.log('main.css skompilowany');
	});
});