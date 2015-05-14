var express = require('express'),
	app = express();

app.use(require('morgan')("combined"));	
app.use(express.static(__dirname));

app.listen(8100,function(){
	console.log('serwer ruszył::http://localhost:8100')
});