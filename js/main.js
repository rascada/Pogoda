var podstawowe = [
	"podstawowe",

	"temperatureCurrent",
	"temperatureReal",
	"temperatureDewPoint",
	"temperatureTrend",
	"temperatureAvg",

	"humidity",

	"pressureCurrent",
	"pressureTrend",

	"rainCurrent",
	"rainSum",

	"windCurrentSpeed",
	"windCurrentDir",
	"windGustSpeed",
	"windGustDir"
];

(function(){
	$.getJSON('json/podstawowe.json', function(data){
	var i = 0;
		$.map(data,function(val){
			if(typeof val === "object"){ 
				$.map( val, function(val){ 
					changeText(podstawowe[i++],val);
				});
			}else changeText(podstawowe[i++],val);
		});
	});
}());

(function(){
	$.getJSON('json/forecast/3day.json',function(data){
		var forecast3d = data.forecast.txt_forecast.forecastday;
		console.log( forecast3d );
 		changeText('forecast3dFct').innerHTML = forecast3d[0].fcttext_metric;
		changeText('forecast3dTitle').innerHTML = forecast3d[0].title;
		changeText('forecast3dIcon').src = forecast3d[0].icon_url;
	});
}());

(function(){
	$.getJSON('json/forecast/36hours.json',function(data){
		var forecast36h = data.hourly_forecast;
		console.log( forecast36h );
	});
}());

//Gdy do changeText podamy tylko jeden argument to zwróci nam złapany element po podanym id.

function changeText(id, val){
	var elem = document.getElementById(id);
	if(arguments.length == 1){
		console.log(elem)
		return elem;
	}
	else{
		console.log("changeText",id+': '+val);
		if(elem)
			elem.innerHTML= val.toString();
		switch(id){
		case 'temperatureCurrent':
			changeText(podstawowe[1]+'Sensor').style.height = (val*2.9+13)+'%';
		case 'windCurrentDir':
			val += 45;
			changeText('windCurrentDirSensor').style.transform = 'rotate('+ val +'deg)';
			break;
		case 'windGustDir':
			val += 45;
			changeText('windGustDirSensor').style.transform = 'rotate('+ val +'deg)';
			break;
		}
	}
}