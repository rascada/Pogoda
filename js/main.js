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
	var i = -1;
		$.map(data,function(val){
			if(typeof val === "object"){
				$.map(val,function(val){
					i++;changeText(podstawowe[i],val);
				});
			}else{
				i++;changeText(podstawowe[i],val);
			}
		});
	});
}());

function changeText(id, val){
	console.log("changeText",id+': '+val);
	var elem = document.getElementById(id);
	if(elem)
		elem.innerHTML= val.toString();
}