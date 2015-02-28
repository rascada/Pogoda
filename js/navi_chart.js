var kierunki_wiatru = ["N", "NE", "E", "SE", "S", "SW", "W", "NW"];

 // Tablice dla codziennych
	    var tabAreaRangeT = new Array();
		var tabAreaRangeP = new Array();
		var tabAreaRangeH = new Array();
		var tabWindDouble = new Array();
		var tabWindDirDouble = new Array();
		var tabRain = new Array();
		var tabClouds = new Array();	
// Tablice dla podstawowych
	var pdsAtemp = new Array();
	var pdsOtemp = new Array();
	var pdsDtemp = new Array();
	var pdsHum = new Array(); var pdsPress = new Array();
	var pdsRainTot = new Array(); var pdsRain = new Array();
	var pdsDir = new Array(); var pdsAVDir = new Array();
	var pdsSpeed = new Array(); var pdsGust = new Array();
// Tablice dla prognoz
		var proTemp = new Array(36); var proDew = new Array(36);
		var proDir = new Array(36); var proSpd = new Array(36);
		var proRain = new Array(36); var proSnow = new Array(36);
// Tablice dla 7days
		var sevAtemp = new Array(); var sevOtemp = new Array(); var sevDtemp = new Array();
		var sevHum = new Array(); var sevPress = new Array(); 
		var sevRain = new Array(); var sevRainTot = new Array();
		var sevGust = new Array(); var sevSpeed = new Array(); 
		var sevDir = new Array(); var sevDom = new Array();
		
		
jQuery(document).ready(function($) {
	 getForecastData(); setDailyTemp('chart1');
}); // document.ready

function getForecastData() {
$.ajax({
  url : "reportjson.php?co=prognozy",
  dataType : "json",
  async: true,
  success : function(parsed_json) {
	var Dates = new Array();	
	for(var i=0; i<36; i++) {
	proTemp[i] = new Array(2);
	proDew[i] = new Array(2);
	proDir[i] = new Array(2);
	proSpd[i] = new Array(2);
	proRain[i] = new Array(2);
	proSnow[i] = new Array(2);
	}
		for(var i=0; i<36; i++) {
			proTemp[i][1] = parseInt(parsed_json['all'][i]['temp']);
			proDew[i][1] = parseInt(parsed_json['all'][i]['dew']);
			proDir[i][1] = parseInt(parsed_json['all'][i]['dir']);
			proSpd[i][1] = Math.floor((parseInt(parsed_json['all'][i]['spd'])/3.6)*100)/100;
			proRain[i][1] = parseInt(parsed_json['all'][i]['rain']);
			proSnow[i][1] = parseInt(parsed_json['all'][i]['snow']);
			Dates[i] = parseInt(parsed_json['all'][i]['xTime']);
		}
		
	for(var i=0; i<36; i++) {
	proTemp[i][0] = Dates[i];
	proDew[i][0] = Dates[i];
	proDir[i][0] = Dates[i];
	proSpd[i][0] = Dates[i];
	proRain[i][0] = Dates[i];
	proSnow[i][0] = Dates[i];
	}			
  } // success ajax func
  }).then(function() {
	if(proTemp[7][0].length<=5) getForecastData();
  }); // $.ajax prognozy 36
}

function setMonthlyHum(where_id, month_sel) {
$.ajax({
  url : "reportjson2.php?co=dzienne&mies="+month_sel+"&col=hum",
  dataType : "json",
  async: true,
  success : function(parsed_json) {
		var odebranych = parseInt(parsed_json['tabSize']);
		var Dates = new Array();	
		for(var i=0; i<odebranych; i++) tabAreaRangeH[i] = new Array(3);

			for(var i=0; i<odebranych; i++) {
				tabAreaRangeH[i][1] = parseInt(parsed_json['days'][i]['humL']); 
				tabAreaRangeH[i][2] = parseInt(parsed_json['days'][i]['humH']);		
				Dates[i] =  parseInt(parsed_json['days'][i]['datatime']);
			}
			
		for(var i=0; i<odebranych; i++) tabAreaRangeH[i][0] = Dates[i];		
  } // success ajax func
  }).then(function() {
		$("#"+where_id).highcharts({ 
				chart: {
					type: 'arearange',
					 zoomType: 'x'
				},
				title: {
					text: 'Wilgotność - daleka przeszłość'
				},
				subtitle: {
					text: 'www.pogoda-skalagi.pl'
				},
				xAxis: {
				   type: 'datetime',
				   dateTimeLabelFormats: {
						day: '%e. %b'
					}
				},
				yAxis: {
					title: {
						text: 'Wilgotność'
					},
					opposite: true
				},
				
				tooltip: {
						crosshairs: true,
						shared: true,
						valueSuffix: '%'
				},

				legend: {
						enabled: false
				},
				series: [{
					name: 'Wilgotność',
					data: tabAreaRangeH,
				}]
			});	
  }); // $.ajax
}

function setMonthlyTemp(where_id, month_sel) {
 $.ajax({
  url : "reportjson2.php?co=dzienne&mies="+month_sel+"&col=temp",
  dataType : "json",
  async: true,
  success : function(parsed_json) {
		var odebranych = parseInt(parsed_json['tabSize']);
		var Dates = new Array();	
		for(var i=0; i<odebranych; i++) tabAreaRangeT[i] = new Array(3);
		
			for(var i=0; i<odebranych; i++) {
				tabAreaRangeT[i][1] = parseFloat(parsed_json['days'][i]['tempL']); 
				tabAreaRangeT[i][2] = parseFloat(parsed_json['days'][i]['tempH']); 
				Dates[i] =  parseInt(parsed_json['days'][i]['datatime']);
			}
		for(var i=0; i<odebranych; i++) tabAreaRangeT[i][0] = Dates[i];		
  } // success ajax func
  }).then(function() {
		$("#"+where_id).highcharts({ 
			chart: {
				type: 'arearange',
				 zoomType: 'x'
			},
			title: {
				text: 'Temperatura - daleka przeszłość'
			},
			subtitle: {
				text: 'www.pogoda-skalagi.pl'
			},
			xAxis: {
			   type: 'datetime',
			   dateTimeLabelFormats: {
					day: '%e. %b'
				}
			},
			yAxis: {
				title: {
					text: 'Temperatura min/max'
				},
				opposite: true
			},
			
			tooltip: {
					crosshairs: true,
					shared: true,
					valueSuffix: '°C'
			},

			legend: {
					enabled: false
			},
			series: [{
				name: 'Zakres temperatur',
				data: tabAreaRangeT,
			}]
		});	
  }); // $.ajax
	
}

function setMonthlyPress(where_id, month_sel) {
 $.ajax({
  url : "reportjson2.php?co=dzienne&mies="+month_sel+"&col=press",
  dataType : "json",
  async: true,
  success : function(parsed_json) {
		var odebranych = parseInt(parsed_json['tabSize']);
		var Dates = new Array();	
		for(var i=0; i<odebranych; i++) tabAreaRangeP[i] = new Array(3);
			for(var i=0; i<odebranych; i++) {
				tabAreaRangeP[i][1] = parseFloat(parsed_json['days'][i]['pressL']); 
				tabAreaRangeP[i][2] = parseFloat(parsed_json['days'][i]['pressH']);
				Dates[i] =  parseInt(parsed_json['days'][i]['datatime']);
			}
		for(var i=0; i<odebranych; i++) tabAreaRangeP[i][0] = Dates[i];
  } // success ajax func
  }).then(function() {
		$("#"+where_id).highcharts({ 
			chart: {
				type: 'arearange',
				 zoomType: 'x'
			},
			title: {
				text: 'Ciśnienie - daleka przeszłość'
			},
			subtitle: {
				text: 'www.pogoda-skalagi.pl'
			},
			xAxis: {
			   type: 'datetime',
			   dateTimeLabelFormats: {
					day: '%e. %b'
				}
			},
			yAxis: {
				title: {
					text: 'Ciśnienie min/max'
				},
				opposite: true
			},
			
			tooltip: {
					crosshairs: true,
					shared: true,
					valueSuffix: 'hPa'
			},

			legend: {
					enabled: false
			},
			series: [{
				name: 'Zakres ciśnienia',
				data: tabAreaRangeP,
			}]
		});
  }); // $.ajax
}

function setMonthlyWind(where_id, month_sel) {
 $.ajax({
  url : "reportjson2.php?co=dzienne&mies="+month_sel+"&col=wind",
  dataType : "json",
  async: true,
  success : function(parsed_json) {
		var odebranych = parseInt(parsed_json['tabSize']);
		var Dates = new Array();	
		for(var i=0; i<odebranych; i++) {
		tabWindDouble[i] = new Array(2);
		tabWindDirDouble[i] = new Array(2);
		}
			for(var i=0; i<odebranych; i++) {	
				tabWindDouble[i][1] = parseFloat(parsed_json['days'][i]['wind']);
				tabWindDirDouble[i][1] = parseInt(parsed_json['days'][i]['windd']);
				Dates[i] =  parseInt(parsed_json['days'][i]['datatime']);
			}
		for(var i=0; i<odebranych; i++) {
		tabWindDouble[i][0] = Dates[i];
		tabWindDirDouble[i][0] = Dates[i];
		}			
  } // success ajax func
  }).then(function() {
		$('#'+where_id).highcharts({
				startOnTick: true,
				chart: {
					zoomType: 'xy'
				},
				title: {
					text: 'Wiatr - daleka przeszłość'
				},
				subtitle: {
					text: 'www.pogoda-skalagi.pl'
				},
				xAxis: [{
					type: 'datetime'
				}],
				yAxis: [{ // Primary yAxis
					labels: {
						formatter: 
							function() {
							var idx=0;
							if(this.value<40) idx=0;
							if(this.value>40) idx=1;
							if(this.value>60) idx=2;
							if(this.value>90) idx=3;
							if(this.value>150) idx=4;
							if(this.value>195) idx=5;
							if(this.value>225) idx=6;
							if(this.value>270) idx=7;
							if(this.value>315) idx=0;
								var value = kierunki_wiatru[idx];
								return value !== 'undefined' ? value : this.value;
							},
						style: {
							color: Highcharts.getOptions().colors[1]
						}
					},
					title: {
						text: 'Kierunek  0°-N',
						style: {
							color: Highcharts.getOptions().colors[1]
						}
					},
					min: 0,
					max: 360,
					tickInterval: 45
				}, { // Secondary yAxis
					gridLineWidth: 0,
					title: {
						text: 'Prędkość',
						style: {
							color: Highcharts.getOptions().colors[1]
						}
					},
					labels: {
						format: '{value} '+"m/s",
						style: {
							color: Highcharts.getOptions().colors[1]
						}
					},
					opposite: true
				}],
				tooltip: {
					shared: true,
					crosshairs: true
				},
				legend: {
					layout: 'vertical',
					align: 'left',
					x: 1010,
					verticalAlign: 'top',
					y: 30,
					floating: true,
					backgroundColor: '#FFFFFF'
				},
				series: [{
					name: 'Kierunek',
					type: 'spline',
					data: tabWindDirDouble,
					marker: {
						enabled: false
					},
					dashStyle: 'shortdot',
					tooltip: {
						valueSuffix: "°"
					}

				}, {
					name: 'Prędkość',
					type: 'spline',
					yAxis: 1,
					data: tabWindDouble,
					tooltip: {
						valueSuffix: "m/s"
					}
				}]
			});	
  });
}

function setMonthlyRain(where_id, month_sel) {
 $.ajax({
  url : "reportjson2.php?co=dzienne&mies="+month_sel+"&col=rain",
  dataType : "json",
  async: true,
  success : function(parsed_json) {
		var odebranych = parseInt(parsed_json['tabSize']);
		var Dates = new Array();	
		for(var i=0; i<odebranych; i++) {
		tabRain[i] = new Array(2);
		tabClouds[i] = new Array(2);
		}
			for(var i=0; i<odebranych; i++) {
				tabRain[i][1] = parseFloat(parsed_json['days'][i]['rain']);
				tabClouds[i][1] = parseFloat(parsed_json['days'][i]['clouds']);
				Dates[i] =  parseInt(parsed_json['days'][i]['datatime']);
			}
		for(var i=0; i<odebranych; i++) {
		tabRain[i][0] = Dates[i];
		tabClouds[i][0] = Dates[i];
		}			
  } // success ajax func
  }).then(function() {
	$('#'+where_id).highcharts({
			startOnTick: true,
			chart: {
				zoomType: 'x'
			},
			title: {
				text: 'Opady i zachmurzenie - daleka przeszłość'
			},
			subtitle: {
				text: 'www.pogoda-skalagi.pl'
			},
			xAxis: [{
				type: 'datetime'
			}],
			yAxis: [{ // Primary yAxis
				labels: {
					format: '{value}'+"mm",
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
				title: {
					text: 'Opad dobowy',
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
			}, { // Secondary yAxis
				gridLineWidth: 0,
				title: {
					text: 'Wysokość podstawy chmur',
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
				labels: {
					format: '{value} '+"m",
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
				opposite: true,
				min: 0
			}],
			tooltip: {
				shared: true,
				crosshairs: true
			},
			legend: {
				layout: 'vertical',
				align: 'left',
				x: 1010,
				verticalAlign: 'top',
				y: 30,
				floating: true,
				backgroundColor: '#FFFFFF'
			},
			series: [{
				name: 'Opad dobowy',
				type: 'column',
				data: tabRain,
				tooltip: {
					valueSuffix: "mm"
				}

			}, {
				name: 'Wysokość chmur',
				type: 'spline',
				yAxis: 1,
				data: tabClouds,
				tooltip: {
					valueSuffix: "m"
				},
				marker: {
                enabled: false
				}
			}]
	});
  }); // $.ajax
}

function setDailyTemp(where_id) {
  $.ajax({
  url : "reportjson2.php?co=aktualne&col=temp",
  dataType : "json",
  async: true,
  success : function(parsed_json) {
	var odebranych = parseInt(parsed_json['size']);
	var Dates = new Array();	
	
	for(var i=0; i<odebranych; i++) {
	pdsAtemp[i] = new Array(2);
	pdsOtemp[i] = new Array(2);
	pdsDtemp[i] = new Array(2);
	}
		for(var i=0; i<odebranych; i++) {
			pdsAtemp[i][1] = parseFloat(parsed_json['dane'][i]['atemp']); 
			pdsOtemp[i][1] = parseFloat(parsed_json['dane'][i]['otemp']); 
			pdsDtemp[i][1] = parseFloat(parsed_json['dane'][i]['dew']); 
			Dates[i] = parseInt(parsed_json['dane'][i]['xTime']);
		}
	for(var i=0; i<odebranych; i++) {
	pdsAtemp[i][0] = Dates[i];
	pdsOtemp[i][0] = Dates[i];
	pdsDtemp[i][0] = Dates[i];
	}			
  } // success ajax func
  }).then(function() {
		
		$('#'+where_id).highcharts({
		chart: {
			zoomType: 'xy'
		},
		title: {
			text: 'Temperatura - ostatnie 8H'
		},
		subtitle: {
			text: 'www.pogoda-skalagi.pl'
		},
		xAxis: [{
		   type: 'datetime'
		}],
		yAxis: [{ // Primary yAxis
			labels: {
				format: '{value}°C',
				style: {
					color: Highcharts.getOptions().colors[0]
				}
			},
			title: {
				text: 'Temperatura',
				style: {
					color: Highcharts.getOptions().colors[0]
				}
			},
			opposite: true
		}],
		tooltip: {
			shared: true,
			crosshairs: true
		},
		legend: {
			layout: 'vertical',
			align: 'left',
			x: 1020,
			verticalAlign: 'top',
			y: 20,
			floating: true,
			backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
		},
		series: [{
			name: 'Aktualna',
			type: 'spline',
			data: pdsAtemp,
			tooltip: {
				valueSuffix: '  °C'
			}

		}, {
			name: 'Punkt rosy',
			type: 'spline',
			data: pdsDtemp,
			marker: {
				enabled: false
			},
			dashStyle: 'shortdot',
			tooltip: {
				valueSuffix: '  °C'
			}

		}, {
			name: 'Odczuwalna',
			type: 'spline',
			data: pdsOtemp,
			tooltip: {
				valueSuffix: ' °C'
			}
		}]
		});	
		
  }); // $.ajax
}

function setDailyOther(where_id) {
  $.ajax({
  url : "reportjson2.php?co=aktualne&col=other",
  dataType : "json",
  async: true,
  success : function(parsed_json) {
	var odebranych = parseInt(parsed_json['size']);
	var Dates = new Array();	
	
	for(var i=0; i<odebranych; i++) {
	pdsHum[i] = new Array(2);
	pdsPress[i] = new Array(2);
	pdsRainTot[i] = new Array(2);
	pdsRain[i] = new Array(2);
	}
		for(var i=0; i<odebranych; i++) {
			pdsHum[i][1] = parseInt(parsed_json['dane'][i]['hum']); 
			pdsPress[i][1] = parseInt(parsed_json['dane'][i]['press']); 
			pdsRainTot[i][1] = parseFloat(parsed_json['dane'][i]['raint']); 
			pdsRain[i][1] = parseFloat(parsed_json['dane'][i]['rain']); 
			Dates[i] = parseInt(parsed_json['dane'][i]['xTime']);
		}
	for(var i=0; i<odebranych; i++) {
	pdsHum[i][0] = Dates[i];
	pdsPress[i][0] = Dates[i];
	pdsRain[i][0] = Dates[i];
	pdsRainTot[i][0] = Dates[i];
	}			
  } // success ajax func
  }).then(function() {
		
$('#'+where_id).highcharts({
			chart: {
				zoomType: 'xy'
			},
			title: {
				text: 'Wilgotność, ciśnienie i opady - ostatnie 8H'
			},
			subtitle: {
				text: 'www.pogoda-skalagi.pl'
			},
			xAxis: [{
				type: 'datetime'
			}],
			yAxis: [{ // Primary yAxis
				labels: {
					format: '{value}%',
					style: {
						color: Highcharts.getOptions().colors[2]
					}
				},
				title: {
					text: 'Wilgotność',
					style: {
						color: Highcharts.getOptions().colors[2]
					}
				},
				opposite: true

			}, { // Secondary yAxis
				gridLineWidth: 0,
				title: {
					text: 'Opady',
					style: {
						color: Highcharts.getOptions().colors[0]
					}
				},
				labels: {
					format: '{value} mm',
					style: {
						color: Highcharts.getOptions().colors[0]
					}
				},
				min: 0
			}, { // Tertiary yAxis
				gridLineWidth: 0,
				title: {
					text: 'Ciśnienie',
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
				labels: {
					format: '{value} hPa',
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
				opposite: true
			}],
			tooltip: {
				shared: true,
				crosshairs: true
			},
			legend: {
				layout: 'vertical',
				align: 'left',
				x: 935,
				verticalAlign: 'top',
				y: 20,
				floating: true,
				backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
			},
			series: [{
				name: 'Opady',
				type: 'spline',
				yAxis: 1,
				data: pdsRain,
				tooltip: {
					valueSuffix: ' mm'
				}

			}, {
				name: 'Ciśnienie',
				type: 'spline',
				yAxis: 2,
				data: pdsPress,
				marker: {
					enabled: false
				},
				dashStyle: 'shortdot',
				tooltip: {
					valueSuffix: ' hPa'
				}

			}, {
				name: 'Wilgotność',
				type: 'spline',
				yAxis: 0,
				data: pdsHum,
				tooltip: {
					valueSuffix: ' %'
				}
			}]
		});
		
  }); // $.ajax
}

var avg=true;
function setDailyWind(where_id, avg_loc) {
  avg = avg_loc;
  $.ajax({
  url : "reportjson2.php?co=aktualne&col=wind",
  dataType : "json",
  async: true,
  success : function(parsed_json) {
	var odebranych = parseInt(parsed_json['size']);
	var Dates = new Array();	
	
	for(var i=0; i<odebranych; i++) {
	pdsDir[i] = new Array(2);
	pdsAVDir[i] = new Array(2);
	pdsSpeed[i] = new Array(2);
	pdsGust[i] = new Array(2);
	}
		for(var i=0; i<odebranych; i++) {
			pdsDir[i][1] = parseInt(parsed_json['dane'][i]['dirw']); 
			pdsAVDir[i][1] = parseInt(parsed_json['dane'][i]['avgdir']); 
			pdsSpeed[i][1] = parseFloat(parsed_json['dane'][i]['spd']); 
			pdsGust[i][1] = parseFloat(parsed_json['dane'][i]['avgspd']); 
			Dates[i] = parseInt(parsed_json['dane'][i]['xTime']);
		}
	for(var i=0; i<odebranych; i++) {
	pdsDir[i][0] = Dates[i];
	pdsAVDir[i][0] = Dates[i];
	pdsSpeed[i][0] = Dates[i];
	pdsGust[i][0] = Dates[i];
	}			
  } // success ajax func
  }).then(function() {
	
	var dir_loc = new Array(); var spd_loc = new Array();
	if(avg) {
		dir_loc = pdsAVDir; spd_loc = pdsGust;
	} else {
		dir_loc = pdsDir; spd_loc = pdsSpeed;
	}
	
	$('#'+where_id).highcharts({
			startOnTick: true,
			chart: {
				zoomType: 'xy'
			},
			title: {
				text: 'Prędkość i kierunek wiatru - ostatnie 8H'
			},
			subtitle: {
				text: 'www.pogoda-skalagi.pl'
			},
			xAxis: [{
				type: 'datetime'
			}],
			yAxis: [{ // Primary yAxis
				labels: {
					formatter: 
						function() {
						var idx=0;
						if(this.value<40) idx=0;
						if(this.value>40) idx=1;
						if(this.value>60) idx=2;
						if(this.value>90) idx=3;
						if(this.value>150) idx=4;
						if(this.value>195) idx=5;
						if(this.value>225) idx=6;
						if(this.value>270) idx=7;
						if(this.value>315) idx=0;
							var value = kierunki_wiatru[idx];
							return value !== 'undefined' ? value : this.value;
						},
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
				title: {
					text: 'Kierunek  0°-N',
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
				min: 0,
				max: 360,
				tickInterval: 45
			}, { // Secondary yAxis
				gridLineWidth: 0,
				title: {
					text: 'Prędkość',
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
				labels: {
					format: '{value} '+"m/s",
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
				min: 0,
				opposite: true
			}],
			tooltip: {
				shared: true,
				crosshairs: true
			},
			legend: {
				layout: 'vertical',
				align: 'left',
				x: 1010,
				verticalAlign: 'top',
				y: 30,
				floating: true,
				backgroundColor: '#FFFFFF'
			},
			series: [{
				name: 'Kierunek',
				type: 'spline',
				data: dir_loc,
				marker: {
					enabled: false
				},
				dashStyle: 'shortdot',
				tooltip: {
					valueSuffix: "°"
				}

			}, {
				name: 'Prędkość',
				type: 'spline',
				yAxis: 1,
				data: spd_loc,
				tooltip: {
					valueSuffix: "m/s"
				}
			}]
	});	
  }); // $.ajax
}

function setForeTemp(where_id) {
	$('#'+where_id).highcharts({
		chart: {
			zoomType: 'xy'
		},
		title: {
			text: 'Temperatura - prognoza na 36H'
		},
		subtitle: {
			text: 'www.pogoda-skalagi.pl'
		},
		xAxis: [{
		   type: 'datetime'
		}],
		yAxis: [{ // Primary yAxis
			labels: {
				format: '{value}°C',
				style: {
					color: Highcharts.getOptions().colors[0]
				}
			},
			title: {
				text: 'Temperatura',
				style: {
					color: Highcharts.getOptions().colors[0]
				}
			},
			opposite: true
		}],
		tooltip: {
			shared: true,
			crosshairs: true
		},
		legend: {
			layout: 'vertical',
			align: 'left',
			x: 1020,
			verticalAlign: 'top',
			y: 20,
			floating: true,
			backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
		},
		series: [{
			name: 'Temperatura',
			type: 'spline',
			data: proTemp,
			tooltip: {
				valueSuffix: '  °C'
			}

		}, {
			name: 'Punkt rosy',
			type: 'spline',
			data: proDew,
			marker: {
				enabled: false
			},
			dashStyle: 'shortdot',
			tooltip: {
				valueSuffix: '  °C'
			}

		}]
		});	
}

function setForeWind(where_id) {
	$('#'+where_id).highcharts({
			startOnTick: true,
			chart: {
				zoomType: 'x'
			},
			title: {
				text: 'Prędkość i kierunek wiatru - prognoza na 36H'
			},
			subtitle: {
				text: 'www.pogoda-skalagi.pl'
			},
			xAxis: [{
				type: 'datetime'
			}],
			yAxis: [{ // Primary yAxis
				labels: {
					formatter: 
						function() {
						var idx=0;
						if(this.value<40) idx=0;
						if(this.value>40) idx=1;
						if(this.value>60) idx=2;
						if(this.value>90) idx=3;
						if(this.value>150) idx=4;
						if(this.value>195) idx=5;
						if(this.value>225) idx=6;
						if(this.value>270) idx=7;
						if(this.value>315) idx=0;
							var value = kierunki_wiatru[idx];
							return value !== 'undefined' ? value : this.value;
						},
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
				title: {
					text: 'Kierunek  0°-N',
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
				min: 0,
				max: 360,
				tickInterval: 45
			}, { // Secondary yAxis
				gridLineWidth: 0,
				title: {
					text: 'Prędkość',
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
				labels: {
					format: '{value} '+"m/s",
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
				min: 0,
				opposite: true
			}],
			tooltip: {
				shared: true,
				crosshairs: true
			},
			legend: {
				layout: 'vertical',
				align: 'left',
				x: 1010,
				verticalAlign: 'top',
				y: 30,
				floating: true,
				backgroundColor: '#FFFFFF'
			},
			series: [{
				name: 'Kierunek',
				type: 'spline',
				data: proDir,
				marker: {
					enabled: false
				},
				dashStyle: 'shortdot',
				tooltip: {
					valueSuffix: "°"
				}

			}, {
				name: 'Prędkość',
				type: 'spline',
				yAxis: 1,
				data: proSpd,
				tooltip: {
					valueSuffix: "m/s"
				}
			}]
	});	
}

function setForePreci(where_id) {
	$('#'+where_id).highcharts({
		chart: {
			zoomType: 'xy'
		},
		title: {
			text: 'Opady - prognoza na 36H'
		},
		subtitle: {
			text: 'www.pogoda-skalagi.pl'
		},
		xAxis: [{
		   type: 'datetime'
		}],
		yAxis: [{ // Primary yAxis
			labels: {
				format: '{value}mm/cm',
				style: {
					color: Highcharts.getOptions().colors[0]
				}
			},
			title: {
				text: 'Opady deszczu lub śniegu',
				style: {
					color: Highcharts.getOptions().colors[0]
				}
			},
			opposite: true
		}],
		tooltip: {
			shared: true,
			crosshairs: true
		},
		legend: {
			layout: 'vertical',
			align: 'left',
			x: 1020,
			verticalAlign: 'top',
			y: 20,
			floating: true,
			backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
		},
		series: [{
			name: 'Deszcz',
			type: 'spline',
			data: proRain,
			tooltip: {
				valueSuffix: '  mm'
			}

		}, {
			name: 'Śnieg',
			type: 'spline',
			data: proSnow,
			marker: {
				enabled: false
			},
			dashStyle: 'shortdot',
			tooltip: {
				valueSuffix: '  cm'
			}

		}]
		});	
}

function setSevenTemp(where_id) {
	$.ajax({
  url : "reportjson.php?co=7days&col=temp",
  dataType : "json",
  async: true,
  success : function(parsed_json) {
	var odebranych = parseInt(parsed_json['size']);
	var Dates = new Array();	
	for(var i=0; i<odebranych; i++) {
	sevAtemp[i] = new Array(2);
	sevOtemp[i] = new Array(2);
	sevDtemp[i] = new Array(2);
	}
		for(var i=0; i<odebranych; i++) {
			sevAtemp[i][1] = parseFloat(parsed_json['seven'][i]['atemp']); 
			sevOtemp[i][1] = parseFloat(parsed_json['seven'][i]['otemp']); 
			sevDtemp[i][1] = parseFloat(parsed_json['seven'][i]['dew']); 
			Dates[i] =  parseInt(parsed_json['seven'][i]['xTime']);
		}
	for(var i=0; i<odebranych; i++) {
	sevAtemp[i][0] = Dates[i];
	sevOtemp[i][0] = Dates[i];
	sevDtemp[i][0] = Dates[i];
	}			
  } // success ajax func
  }).then(function() {
		$('#'+where_id).highcharts({
		chart: {
			zoomType: 'xy'
		},
		title: {
			text: 'Temperatura - ostatni tydzień'
		},
		subtitle: {
			text: 'www.pogoda-skalagi.pl'
		},
		xAxis: [{
		   type: 'datetime'
		}],
		yAxis: [{ // Primary yAxis
			labels: {
				format: '{value}°C',
				style: {
					color: Highcharts.getOptions().colors[0]
				}
			},
			title: {
				text: 'Temperatura',
				style: {
					color: Highcharts.getOptions().colors[0]
				}
			},
			opposite: true
		}],
		tooltip: {
			shared: true,
			crosshairs: true
		},
		legend: {
			layout: 'vertical',
			align: 'left',
			x: 1020,
			verticalAlign: 'top',
			y: 20,
			floating: true,
			backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
		},
		series: [{
			name: 'Aktualna',
			type: 'spline',
			data: sevAtemp,
			tooltip: {
				valueSuffix: '  °C'
			}

		}, {
			name: 'Punkt rosy',
			type: 'spline',
			data: sevDtemp,
			marker: {
				enabled: false
			},
			dashStyle: 'shortdot',
			tooltip: {
				valueSuffix: '  °C'
			}

		}, {
			name: 'Odczuwalna',
			type: 'spline',
			data: sevOtemp,
			tooltip: {
				valueSuffix: ' °C'
			}
		}]
		});	
  }); // $.ajax podstawowe-aktualne
	
}

function setSevenOther(where_id) {
	$.ajax({
  url : "reportjson.php?co=7days&col=other",
  dataType : "json",
  async: true,
  success : function(parsed_json) {
	var odebranych = parseInt(parsed_json['size']);
	var Dates = new Array();	
	for(var i=0; i<odebranych; i++) {
	sevHum[i] = new Array(2);
	sevPress[i] = new Array(2);
	sevRainTot[i] = new Array(2);
	sevRain[i] = new Array(2);
	}
		for(var i=0; i<odebranych; i++) {
			sevHum[i][1] = parseInt(parsed_json['seven'][i]['hum']);		
			sevPress[i][1] = parseInt(parsed_json['seven'][i]['press']);
			sevRainTot[i][1] = parseFloat(parsed_json['seven'][i]['raint']);
			sevRain[i][1] = parseFloat(parsed_json['seven'][i]['rain']);
			Dates[i] =  parseInt(parsed_json['seven'][i]['xTime']);
		}
	for(var i=0; i<odebranych; i++) {
	sevHum[i][0] = Dates[i];
	sevPress[i][0] = Dates[i];
	sevRainTot[i][0] = Dates[i];
	sevRain[i][0] = Dates[i];
	}			
  } // success ajax func
  }).then(function() {
		$('#'+where_id).highcharts({
			chart: {
				zoomType: 'xy'
			},
			title: {
				text: 'Wilgotność, ciśnienie i opady - ostatni tydzień'
			},
			subtitle: {
				text: 'www.pogoda-skalagi.pl'
			},
			xAxis: [{
				type: 'datetime'
			}],
			yAxis: [{ // Primary yAxis
				labels: {
					format: '{value}%',
					style: {
						color: Highcharts.getOptions().colors[2]
					}
				},
				title: {
					text: 'Wilgotność',
					style: {
						color: Highcharts.getOptions().colors[2]
					}
				},
				opposite: true

			}, { // Secondary yAxis
				gridLineWidth: 0,
				title: {
					text: 'Opady',
					style: {
						color: Highcharts.getOptions().colors[0]
					}
				},
				min: 0,
				labels: {
					format: '{value} mm',
					style: {
						color: Highcharts.getOptions().colors[0]
					}
				}

			}, { // Tertiary yAxis
				gridLineWidth: 0,
				title: {
					text: 'Ciśnienie',
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
				labels: {
					format: '{value} hPa',
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
				opposite: true
			}],
			tooltip: {
				shared: true,
				crosshairs: true
			},
			legend: {
				layout: 'vertical',
				align: 'left',
				x: 935,
				verticalAlign: 'top',
				y: 20,
				floating: true,
				backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
			},
			series: [{
				name: 'Opady',
				type: 'spline',
				yAxis: 1,
				data: sevRainTot,
				tooltip: {
					valueSuffix: ' mm'
				}

			}, {
				name: 'Ciśnienie',
				type: 'spline',
				yAxis: 2,
				data: sevPress,
				marker: {
					enabled: false
				},
				dashStyle: 'shortdot',
				tooltip: {
					valueSuffix: ' hPa'
				}

			}, {
				name: 'Wilgotność',
				type: 'spline',
				yAxis: 0,
				data: sevHum,
				tooltip: {
					valueSuffix: ' %'
				}
			}]
		});
  }); // $.ajax
  
}

function setSevenWind(where_id, avg_loc) {
	avg = avg_loc;
	$.ajax({
  url : "reportjson.php?co=7days",
  dataType : "json",
  async: true,
  success : function(parsed_json) {
	var odebranych = parseInt(parsed_json['size']);
	var Dates = new Array();	
	for(var i=0; i<odebranych; i++) {
	sevDir[i] = new Array(2);
	sevDom[i] = new Array(2);
	sevSpeed[i] = new Array(2);
	sevGust[i] = new Array(2);
	}
		for(var i=0; i<odebranych; i++) {
			sevDir[i][1] = parseInt(parsed_json['seven'][i]['dir']);
			sevDom[i][1] = parseInt(parsed_json['seven'][i]['domdir']);
			sevSpeed[i][1] = parseFloat(parsed_json['seven'][i]['speed']);
			sevGust[i][1] = parseFloat(parsed_json['seven'][i]['gust']);
			Dates[i] =  parseInt(parsed_json['seven'][i]['xTime']);
		}
	for(var i=0; i<odebranych; i++) {
	sevDir[i][0] = Dates[i];
	sevDom[i][0] = Dates[i];
	sevSpeed[i][0] = Dates[i];
	sevGust[i][0] = Dates[i];
	}			
  } // success ajax func
  }).then(function() {
	var dir_loc = new Array(); var spd_loc = new Array();
	if(avg) { dir_loc = sevDom; spd_loc = sevGust; } 
	else { dir_loc = sevDir; spd_loc = sevSpeed; }

	$('#'+where_id).highcharts({
			startOnTick: true,
			chart: {
				zoomType: 'x'
			},
			title: {
				text: 'Prędkość i kierunek wiatru - ostatni tydzień'
			},
			subtitle: {
				text: 'www.pogoda-skalagi.pl'
			},
			xAxis: [{
				type: 'datetime'
			}],
			yAxis: [{ // Primary yAxis
				labels: {
					formatter: 
						function() {
						var idx=0;
						if(this.value<40) idx=0;
						if(this.value>40) idx=1;
						if(this.value>60) idx=2;
						if(this.value>90) idx=3;
						if(this.value>150) idx=4;
						if(this.value>195) idx=5;
						if(this.value>225) idx=6;
						if(this.value>270) idx=7;
						if(this.value>315) idx=0;
							var value = kierunki_wiatru[idx];
							return value !== 'undefined' ? value : this.value;
						},
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
				title: {
					text: 'Kierunek  0°-N',
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
				min: 0,
				max: 360,
				tickInterval: 45
			}, { // Secondary yAxis
				gridLineWidth: 0,
				title: {
					text: 'Prędkość',
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
				labels: {
					format: '{value} '+"m/s",
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
				min: 0,
				opposite: true
			}],
			tooltip: {
				shared: true,
				crosshairs: true
			},
			legend: {
				layout: 'vertical',
				align: 'left',
				x: 1010,
				verticalAlign: 'top',
				y: 30,
				floating: true,
				backgroundColor: '#FFFFFF'
			},
			series: [{
				name: 'Kierunek',
				type: 'spline',
				data: dir_loc,
				marker: {
					enabled: false
				},
				dashStyle: 'shortdot',
				tooltip: {
					valueSuffix: "°"
				}

			}, {
				name: 'Prędkość',
				type: 'spline',
				yAxis: 1,
				data: spd_loc,
				tooltip: {
					valueSuffix: "m/s"
				}
			}]
	});	
  });
}

Highcharts.setOptions({
		lang: {
		months: ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec", "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień"],
		shortMonths: ["Sty", "Lut", "Mar", "Kwi", "Maj", "Czer", "Lip", "Sie", "Wrze", "Paź", "Lis", "Gru"],
		weekdays: ["Niedziela", "Poniedziałek", "Wtorek", "Środa", "Czwartek", "Piątek", "Sobota"]
		},
        chart: {
            backgroundColor: {
                linearGradient: [100, 200, 300, 400],
                stops: [
                    [0, '#bfc910'],
                    [1, '#ffffdd']
                    ]
            },
            borderWidth: 2,
            plotBackgroundColor: 'rgba(255, 255, 255, .9)',
            plotShadow: true,
            plotBorderWidth: 1
        }
 });	