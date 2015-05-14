var express = require('express'),
	app = express();

app.use(require('morgan')("default"));	
app.use(express.static(__dirname));

app.listen(8100,function(){
	console.log('http://localhost:8100')
});