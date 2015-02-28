function stworzMiarkeLicznik(id,licznik){
    var zakres;
    var divide=true;
    var war =0;
    var dz = 1;
    var num = 0;
    var precise;
    var mH = new Array();
    var m = new Array();
    var numA = new Array();
/*
    var a= 1;
    var b= (var) a;
                    */
    if(licznik==1){zakres=960; precise=55;}//960 - 1015
    if(licznik==2){zakres=0; precise=55;war=35;dz=2;}//0-27
    if(licznik==3){zakres=0;precise=50; war=45; dz=2;divide=false;}//0-100

    for(var i=zakres;i<=precise+zakres;i++){
		num+=4; if(licznik==3) num+=.35;
		m[i]=document.createElement('div');
        document.getElementById('liczPods'+id).appendChild(m[i]);
        mH[i] = m[i].appendChild(document.createElement('div'));
		m[i].style.transform = 'rotate('+ num +'deg)';

        if(i%5==0){
            numA[i] =(mH[i]).appendChild(document.createElement('h3'));
            mH[i].style.height ="1.5em";
			  if(divide)numA[i].innerHTML=Math.floor(i /dz);
              else numA[i].innerHTML=Math.floor(i *dz);
            if(licznik==1){
                numA[i].style.transform= 'rotate(5deg)';
                numA[i].style.fontSize='.9em';
            }
            if(war!=0&&i>=war)numA[i].style.color = 'red'; }
        if(war!=0&&i>=war)mH[i].style.backgroundColor = 'red';
    }
}
function createMScale(id,precise,skok,dodac){
    var mH = new Array();
    var m = new Array();

    for(var i=precise;i>0;i--){
		m[i]=document.createElement('div');
        document.getElementById(id).appendChild(m[i]);
        if(i%skok==0){
          m[i].style.backgroundColor='grey';
          m[i].style.width="1.5em";
          mH[i] =(m[i]).appendChild(document.createElement('h3'));
          mH[i].innerHTML=i*dodac;
        }
    }
}
/***********************************//*Zmienne globalne*//*************************************/

function compassDirScale(num){
    var compass= document.getElementById('compass'+num);
    var div = new Array();
    var text = new Array();
    var textN = ['N','NE','E','SE','S','SW','W','NW'];

    for(var i =0;i<8;i++){
        div[i] = compass.appendChild(document.createElement('div'));
        text[i] = div[i].appendChild(document.createElement('h3'));
        text[i].innerHTML = textN[i];

        div[i].className ='jsCompassDiv';
        text[i].className ='jsCompassLabel';
		if(i>=3 && i<=5) {
            text[i].style.transform='rotate(180deg)';
            text[i].style.marginTop='1%';
		}
        div[i].style.transform='rotate('+i*45+'deg)';
    }

}

function createTempMiar(id,precise,skok){
    var mH = new Array();
    var m = new Array();
    
    var temp = 40;

    for(var i=precise;i>0;i--){
		m[i]=document.createElement('div');
        document.getElementById(id).appendChild(m[i]);
        if(i%skok==0){
          m[i].style.backgroundColor='grey';
          m[i].style.width="3em";
          mH[i] =(m[i]).appendChild(document.createElement('h4'));
          mH[i].innerHTML=temp;
            temp-=5;
        }
    }
}
var width= $(window).width();

$(window).resize(function() {
    width=$(window).width();
});

function createView(tryb) {
	if(tryb) {
		$.ajax({
				type: "POST",
				url: "session.php",
				dataType: "text",
				async: true,
				data: { changedayrep: "first" },
				success: function(response) { dzien = response.split("|"); }
				}).then(function() {
					refhourly(0);
					if( (dzien[16].indexOf("Mozilla")==-1 && dzien[16].indexOf("Chrome")==-1) || dzien[16].indexOf("Trident")!=-1) alert('Używasz niewspieranej przez tę stronę przeglądarki. Zalecamy używanie Chrome, Firefox lub Opery w najnowszej wersji.');
					refdayrep(false); refresh(); 
		});
	} else {
		var rekordy=0;
			$.ajax({
				type: "GET",
				url: "session.php",
				dataType: "json",
				async: true,
				data: { checkhighslows: "ok" },
				success: function(resp) {
					rekordy=resp;
				}
			}).then(function() {
				if(rekordy['temp']['low']!="none") {
						$("#tempPanel").prop("title", rekordy['temp']['low']);
					}
					if(rekordy['temp']['high']!="none") {
						$("#tempPanel").prop("title", rekordy['temp']['high']);
					}
					if(rekordy['hum']['low']!="none") {
						$("#wilPanel").prop("title", rekordy['hum']['low']);
					}
					if(rekordy['hum']['high']!="none") {
						$("#wilPanel").prop("title", rekordy['hum']['high']);
					}
					if(rekordy['press']['low']!="none") {
						$("#cisPanel").prop("title", rekordy['press']['low']);
					}
					if(rekordy['press']['high']!="none") {
						$("#cisPanel").prop("title", rekordy['press']['high']);
					}
					if(rekordy['other']['wind']!="none") {
						$("#windPanel").prop("title", rekordy['other']['wind']);
					}
					if(rekordy['other']['rain']!="none") {
						$("#waterPanel").prop("title", rekordy['other']['rain']);
					}	
			});
	}
		
}

$(window).load(function() {
		setTimeout(function() { createView(true); }, 1000);
		setTimeout(function() { createView(false); }, 4000);
});

$(document).mousemove(function(event) {
//      $('#hint').css('left',event.pageX).css('top',event.pageY-$('#hint').height());
});
/*
    kompas
    0 - compassArr1
    1 - compassArrSpan1
    2 - compassArr2
    3 - compassArrSpan1

    wiatr
    4 - aktualny
    5 - podmuch

    6 - cis
    7 - wilg
*/

var widoczny="#all";
function setTab(tab){
    switch(tab) {  
        case 1: {
			$(widoczny).fadeOut(500,function(){
				$('#all').fadeIn(500);      
				widoczny="#all";			
			});         
        } break;
		case 2: {
			$(widoczny).fadeOut(500,function(){            
				$('#wykresy').fadeIn(500);
				widoczny="#wykresy";
			});             
		} break;  
		case 3: {
			$(widoczny).fadeOut(500,function(){
				$('#mapki').fadeIn(500);      
				widoczny="#mapki";			
			});     			
		}
	}
}

var animCache = {};
animCache[0]=225;
animCache[2]=225;
animCache[1]=135;
animCache[3]=135;
animCache[4]=-113;
animCache[5]=-113;
animCache[6]=-113;
animCache[7]=-113;

function rotate(what,from,to,additionalTransform){
    $({deg: from}).animate({deg: to}, {
        duration: 3500,
        step: function(now){$('#'+what).css('transform',additionalTransform+ " rotate(" + now + "deg)");}
    });
}

function ludek(biom){/*
    var mouth = document.getElementById('mouth');
    if(podstawowe[21].charAt(0) == 'K'){
      mouth.style.transform = 'scale(.5) rotate(0deg)';
      mouth.style.borderRadius = '50%';
      mouth.style.marginTop = '3%';
    }else if(podstawowe[21].charAt(0) == 'N'){
      mouth.style.transform = 'scale(.5) rotate(180deg)';
      mouth.style.borderRadius = '50%';
      mouth.style.marginTop = '15%';
    }else{
      mouth.style.transform = 'scale(.5) rotate(0deg)';
      mouth.style.borderRadius = '0%';
      mouth.style.marginTop = '-2%';
    }*/
    $('#biometOdczyt').text(biom);
}
function tenCol(tend,id,gradient){
    var col;
    var col1;
    var col2;
    var per1 ='';
    var per2 ='';

    if(tend.toLowerCase().charAt(0) == 'r'){
        col1='#5f0 '
        col2 = '#8f0 )';
    }else if(tend.toLowerCase().charAt(1) == 't'){
        col1='#777 ';
        col2 = '#333 )';
    }else{
        col1='#00aeee ';
        col2 = 'lightgrey )';
    }
    if(gradient){
        per1='5%';
        per2='50%';
        col2='#444 ';
    }
    col=col1+per1 +','+col2+per2;
    if(gradient)
    $('#'+id).css('background','radial-gradient('+col);
    else
    $('#'+id).css('background','linear-gradient(to bottom left,'+col);
}
function fillWithWater(perc){
    document.getElementById('humPercWater').style.background='linear-gradient(#07f '+perc+'%,transparent 10%)';
}
function compass(num,procent) {
    if(procent>=90 && procent<=270 ) pRotate=135;
    else pRotate=-45;
    procent += 45;

    var chosen1 = 0;
    var chosen2 = 1;

    if(num==2){chosen1=2;chosen2=3;}

    if(animCache[chosen1] != procent){
        rotate('cm'+num,animCache[chosen1],procent,"scale(0.85)");
        rotate('cmL'+num,animCache[chosen2],pRotate,'');
        animCache[chosen1]=procent;
        animCache[chosen2]=pRotate;
    }
}
function wind(num,speed){
    var start=-113;
    if(num==3)for(var i=0;i<speed-960;i++)start+= 112/27.5;
    else if(num==4)for(var i=0;i<speed;i++)start+=111/50;
    else for(var i=0;i<speed;i++)start+=112/13.5;

    rotate('strz'+num,animCache[num+3],start,'');
    animCache[num+3]=start;
}

function miarka(id,water,p){
	if(water!=1) water--;
    var waterP=37.5;
    for(var i=0;i<water;i++)waterP+= ($('.waterCont').height()-37.5)/p;
    $('#'+id).animate({ height: waterP+'px'});
}

function temp(id, C){    
    var temp =14.65;
    temp-=.35*C;
    
    $('#'+id).css('height',temp+'em');                    
                    }

compassDirScale(1);
compassDirScale(2);
createMScale('miarka12',30,5,1);
createMScale('miarka2',30,5,2);
createTempMiar('tempMiarka1',70,5);
createTempMiar('tempMiarka2',70,5);
createTempMiar('tempMiarka3',70,5);
stworzMiarkeLicznik(1,2);
stworzMiarkeLicznik(2,2);
stworzMiarkeLicznik(3,1);
stworzMiarkeLicznik(4,3);
///PHP
var ak_kmph=true;
var pod_kmph=true;
var nextRef=120;
var intNextRef;
var dzien = new Array();
/*
dzien:
0 - [czas max temp] [wartość max temp]
1 - [czas max wilgotnosci] [wartość max wilgotnosci]
2 - [czas max cisnienia] [wartość max cisnienia]
3 - [dominujący kierunek wiatru]
4 - [czas max wiatr] [predkosc max wiatr]
5 - [czas max powiew] [predkosc max powiew]
6 - [czas max opadu] [wartosc max opadu]
7 - [wschód słońa]
8 - [zachód słońa]
9 - [długość dnia]
10 - [wschód księżyca]
11 - [zachód księżyca]
12 - [faza księżyca]
13 - [czas min temp] [wartość min temp]
14 - [czas min wilgotnosci] [wartość min wilgotnosci]
15 - [czas min cisnienia] [wartość min cisnienia]
16 - Info o przeglądarce
17 - Wysokość chmur
18 - Z kiedy dzienny raport
19 - Świt
20 - Zmierzch
21 - Prognoza str
22 - Prognoza dzien tyg
23 - Prognoza img url
24 - flaga lewy koniec 
25 - flaga prawy koniec 
id in html

sunWsch
sunZch
moonWsch
moonZch

tempDayMin - tempDayMax
wilDayMin - wilDayMax
cisDayMin - cisDayMax

dayLen - długość dnia
moonPhase - faza księżyca
forecast - prognoza pogody
windDayBlow  -rekord podmuchu
rainDay - deszcz mm/h
dewDeg - punkt rosy

cmL1 - aktualny kierunek wiatru
cmL2 - dominujący kierunek wiatru
*/


function jschangeday(day) {
	if(day) {
	 	 $.ajax({
			type: "POST",
			url: "session.php",
			dataType: "text",
			async: true,
			data: { changedayrep: "right", },
			success: function(response){                    
				dzien = response.split("|"); 
			}
		}).then(function() {
			// if(dzien[25]=='true') schowaj prawą strzałkę raportu
				refdayrep(true);
		});;
	} else {
	 	 $.ajax({
			type: "POST",
			url: "session.php",
			dataType: "text",
			async: true,
			data: { changedayrep: "left", },
			success: function(response){                    
				dzien = response.split("|"); 
			}
		}).then(function() {
			// if(dzien[24]=='true') schowaj lewą strzałkę raportu
				refdayrep(true);
		});
	}

}

function jschangefore(right) {
	if(right) {
		$.ajax({
				type: "POST",
				url: "session.php",
				dataType: "text",
				async: true,
				data: { changeforecast: "right", },
				success: function(response){                    
					dzien = response.split("|"); 
				}
			}).then(function() {
					// if(dzien[25]=='true') schowaj prawą strzałkę 3dniowej
					refdayrep(true);
			});
	} else {
		$.ajax({
				type: "POST",
				url: "session.php",
				dataType: "text",
				async: true,
				data: { changeforecast: "left", },
				success: function(response){                    
					dzien = response.split("|");  
				}
			}).then(function() {
					// if(dzien[24]=='true') schowaj lewą strzałkę 3dniowej
					refdayrep(true);
			});
	}
}

function refhourly(type) {
var tabhourly="";

if(type==0) {
		$.ajax({
			type: "POST",
			url: "session.php",
			dataType: "text",
			async: true,
			data: { gethourlyforecast: "false", },
			success: function(response) { tabhourly = response.split("|"); }
		}).then(function() {
			document.images['bigforeimg'].src = tabhourly[10]+'?' + Math.random();
			document.getElementById("bigforetime").innerHTML=tabhourly[0];
			document.getElementById("bigforedate").innerHTML=tabhourly[1]+" "+tabhourly[2];
			document.getElementById("bigforetext").innerHTML=tabhourly[3];
			document.getElementById("bigforetemp").innerHTML=tabhourly[4]+"°C";
			document.getElementById("bigforedew").innerHTML=tabhourly[5]+"°C";
			document.getElementById("bigforewdir").innerHTML=tabhourly[6];
			document.getElementById("bigforewspd").innerHTML=tabhourly[7]+"km/h";
			document.getElementById("bigforerain").innerHTML=tabhourly[8]+"mm";
			if(tabhourly[8].indexOf("0")!=-1) document.getElementById("bigforerain").innerHTML="--";
			document.getElementById("bigforesnow").innerHTML=tabhourly[9]+"cm";
			if(tabhourly[9].indexOf("0")!=-1) document.getElementById("bigforesnow").innerHTML="--";
		});
} else if(type==1) {
		$.ajax({
			type: "POST",
			url: "session.php",
			dataType: "text",
			async: true,
			data: { gethourlyforecast: "left", },
			success: function(response) { 
			tabhourly = response.split("|"); 
			// if(tabhourly[11]=="true") schowaj lewą strzałkę 36godz
			}
		}).then(function() {
			document.images['bigforeimg'].src = tabhourly[10]+'?' + Math.random();
			document.getElementById("bigforetime").innerHTML=tabhourly[0];
			document.getElementById("bigforedate").innerHTML=tabhourly[1]+" "+tabhourly[2];
			document.getElementById("bigforetext").innerHTML=tabhourly[3];
			document.getElementById("bigforetemp").innerHTML=tabhourly[4]+"°C";
			document.getElementById("bigforedew").innerHTML=tabhourly[5]+"°C";
			document.getElementById("bigforewdir").innerHTML=tabhourly[6];
			document.getElementById("bigforewspd").innerHTML=tabhourly[7]+"km/h";
			document.getElementById("bigforerain").innerHTML=tabhourly[8]+"mm";
			if(tabhourly[8].indexOf("0")!=-1) document.getElementById("bigforerain").innerHTML="--";
			document.getElementById("bigforesnow").innerHTML=tabhourly[9]+"cm";
			if(tabhourly[9].indexOf("0")!=-1) document.getElementById("bigforesnow").innerHTML="--";
		});
} else if(type==2) {
		$.ajax({
			type: "POST",
			url: "session.php",
			dataType: "text",
			async: true,
			data: { gethourlyforecast: "right", },
			success: function(response) { 
			tabhourly = response.split("|"); 
			// if(tabhourly[12]=="true") schowaj prawą strzałkę 36godz
			}
		}).then(function() {
			document.images['bigforeimg'].src = tabhourly[10]+'?' + Math.random();
			document.getElementById("bigforetime").innerHTML=tabhourly[0];
			document.getElementById("bigforedate").innerHTML=tabhourly[1]+" "+tabhourly[2];
			document.getElementById("bigforetext").innerHTML=tabhourly[3];
			document.getElementById("bigforetemp").innerHTML=tabhourly[4]+"°C";
			document.getElementById("bigforedew").innerHTML=tabhourly[5]+"°C";
			document.getElementById("bigforewdir").innerHTML=tabhourly[6];
			document.getElementById("bigforewspd").innerHTML=tabhourly[7]+"km/h";
			document.getElementById("bigforerain").innerHTML=tabhourly[8]+"mm";
			if(tabhourly[8].indexOf("0")!=-1) document.getElementById("bigforerain").innerHTML="--";
			document.getElementById("bigforesnow").innerHTML=tabhourly[9]+"cm";
			if(tabhourly[9].indexOf("0")!=-1) document.getElementById("bigforesnow").innerHTML="--";
		});
}




}


function refdayrep(auto) {
		document.getElementById("daydate").innerHTML=dzien[18];
		document.getElementById("sunWsch").innerHTML=dzien[7];
		document.getElementById("sunBrz").innerHTML=dzien[19];
		document.getElementById("sunZch").innerHTML=dzien[8];
		document.getElementById("sunZm").innerHTML=dzien[20];
		document.getElementById("dayLen").innerHTML=dzien[9];
		document.getElementById("moonWsch").innerHTML=dzien[10];
		document.getElementById("moonZch").innerHTML=dzien[11];
		document.getElementById("moonPhase").innerHTML=dzien[12];

		document.getElementById("tempDayMax").innerHTML=" "+dzien[0];
	    document.getElementById("wilDayMax").innerHTML=" "+dzien[1];
		document.getElementById("cisDayMax").innerHTML=" "+dzien[2];
		document.getElementById("tempDayMin").innerHTML=" "+dzien[13];
	    document.getElementById("wilDayMin").innerHTML=" "+dzien[14];
		document.getElementById("cisDayMin").innerHTML=" "+dzien[15];

		document.getElementById("windDayBlow").innerHTML=" "+dzien[5];
	    document.getElementById("rainDay").innerHTML=" "+dzien[6];
		if(dzien[6].indexOf("0")==3) document.getElementById("rainDay").innerHTML="- (--:--)"; 
		document.getElementById("clouds").innerHTML=dzien[17]+"m";
		document.getElementById("forecast").innerHTML=dzien[21];
		document.getElementById("weather").innerHTML=dzien[22];
		document.images['forecast'].src = dzien[23]+'?' + Math.random();
		var jaki_dzien;
		if(dzien[3]<20 || dzien[3]>=315) jaki_dzien="N->S";
		else if(dzien[3]>=20 && dzien[3]<70) jaki_dzien="NE->SW";
		else if(dzien[3]>=70 && dzien[3]<110) jaki_dzien="E->W";
		else if(dzien[3]>=110 && dzien[3]<160) jaki_dzien="SE->NW";
		else if(dzien[3]>=160 && dzien[3]<215) jaki_dzien="S->N";
		else if(dzien[3]>=215 && dzien[3]<240) jaki_dzien="SW->NE"
		else if(dzien[3]>=240 && dzien[3]<285) jaki_dzien="W->E";
		else if(dzien[3]>=285 && dzien[3]<315) jaki_dzien="NW->SE";
		document.getElementById("windDayDom").innerHTML=jaki_dzien;
 /*   
=======

		if( (dzien[16].indexOf("Mozilla")==-1 && dzien[16].indexOf("Chrome")==-1) || dzien[16].indexOf("Trident")!=-1) alert('Używasz niewspieranej przez tę stronę przeglądarki. Zalecamy używanie Chrome lub Firefox w najnowszej wersji.');

>>>>>>> origin/master
    var data = new Date();
    var tabTime_s = dzien[19].trim().split(":");
    var tabTime_z = dzien[20].trim().split(":");
    var HourRise = parseInt(tabTime_s[0]);
    var HourSet = parseInt(tabTime_z[0]);

    if(data.getHours() <HourRise || data.getHours() >HourSet){
        $('#logoSun li').css('background','#57b7df');
        $('#logoSun li').css('border','.1em solid #57b7df');
        document.body.style.background='linear-gradient(#001848 10em,#444 25em)';
        $('header h1, header h2, header h3').css('box-shadow','.01em .01em .9em #001848');
        $('header h1, header h2, header h3').css('border-color','#57b7df');
        $('#smileyFaceDarken').css('border-color','#47a7bf');
        $('#smileyFace').css('background','#57b7df');
        $('#smileyFaceLighten').css('background','linear-gradient(#87d7ff ,transparent )');
        $('#smileyFaceCont').css('background','transparent');
        $('.bigPanel').css('background','#eee');
        $('#biomet').css('color','#57b7df');
   }*/
        }


function refresh() {
	$.ajax({
		type: "POST",
		url: "session.php",
		dataType: "json",
		async: true,
		data: { wezpodstawowe: "nml", },
		success: function(podstawowe) { 
			var akmph = Math.floor( ((3600*podstawowe['speed'])/1000) * 100)/100;
			var pkmph = Math.floor( ((3600*podstawowe['gust'])/1000) * 100)/100;
			nextRef =  parseInt(podstawowe['sectoref']);
				ludek(podstawowe['biomet']);

					var cmlA = parseInt(podstawowe['dir'])+180;
					if(cmlA>360) cmlA -= 360;
					var cmlB = parseInt(podstawowe['domdir'])+180;
					if(cmlB>360) cmlB -= 360;
					if(cmlA==360) cmlA=0; if(cmlB==360) cmlB=0;
	
					document.getElementById("last").innerHTML=podstawowe['datetime']+"<div>Następna za ok. <span id='nrf'>"+nextRef+"</span>s</div>"+podstawowe['onoff']; 
					document.getElementById("atemval").innerHTML=podstawowe['atemp'];
					temp('aTemp',Math.floor(podstawowe['atemp']));
					document.getElementById("wilval").innerHTML = podstawowe['hum']+"%";
					wind(4, podstawowe['hum']);
					fillWithWater(podstawowe['hum']);
					temp('srTemp',Math.floor(podstawowe['srtemp']));
					document.getElementById("srtemval").innerHTML=podstawowe['srtemp'];
					
					if(pod_kmph) { document.getElementById("wPSpeed").innerHTML="Podmuch <br/>"+pkmph+"km/h"; wind(2, pkmph);  }
					else { document.getElementById("wPSpeed").innerHTML="Podmuch <br/>"+podstawowe['gust']+"m/s"; wind(2, podstawowe['gust']);  }
					
					if(ak_kmph) { document.getElementById("wSpeed").innerHTML="Aktualny <br/>"+akmph+"km/h"; wind(1, akmph);  }
					else { document.getElementById("wSpeed").innerHTML="Aktualny <br/>"+podstawowe['speed']+"m/s"; wind(1, podstawowe['speed']); }
						compass(1, cmlA); 
						document.getElementById("aktDirVal").innerHTML="Akualny: <br/>"+wind_dir_str(podstawowe['dir']);
						
						compass(2, cmlB);
						document.getElementById("domDirVal").innerHTML="Dominujący: <br/>"+wind_dir_str(podstawowe['domdir']);
						
						document.getElementById("windBfw").innerHTML="Wiatr: "+bfwInt_str(parseInt(podstawowe['bfw']));
						
						temp('oTemp',Math.floor(podstawowe['otemp'])); 
						document.getElementById("otemval").innerHTML=podstawowe['otemp'];
						miarka('water2', podstawowe['raint'], 60);
						document.getElementById("opadd").innerHTML=podstawowe['raint']+"<br/>mm";
						miarka('water12', podstawowe['rain'], 30); 
						document.getElementById("aktopad").innerHTML=podstawowe['rain']+"<br/>mm/h";
						wind(3, podstawowe['press']);
						
					document.getElementById("pressval").innerHTML = podstawowe['trendpress']+"<br/>"+podstawowe['press']+"hPa";                
					tenCol(podstawowe['trendpress'],'cisLicznik',true);
		
						document.getElementById("tentemp").innerHTML=podstawowe['trendtemp'];
						tenCol(podstawowe['trendtemp'],'tempPanel h3',false);
		
						document.getElementById("dewDeg").innerHTML=podstawowe['dew'];					
						

						document.getElementById("cmL1").innerHTML = podstawowe['dir']+'°';
						document.getElementById("cmL2").innerHTML =  podstawowe['domdir'] +'°';
			}	
		})	.then(function() {
			if(nextRef!=' --') {
				clearInterval(intNextRef);
				intNextRef = setInterval("nextMinus()", 1000);
			}
		}); // weź podstawowe ajax	
}


function aktwindclick() {
ak_kmph = !ak_kmph;
refresh();
}

function podwindclick() {
pod_kmph = !pod_kmph;
refresh();
}

function setMap(what) {
	var buf_cont = document.getElementById("mapCont").innerHTML;
	document.getElementById("mapCont").style.fontSize="1.8em";
	document.getElementById("mapCont").innerHTML = "Ładuje...";
	switch(what) {
		case 0: { 
		document.images['obrazmapy'].src = 'http://icons.wxug.com/data/640x480/2xi_pl_st.gif?' +  Math.random(); 
		} break;
		case 1: { 
		document.images['obrazmapy'].src = 'http://icons.wxug.com/data/640x480/2xi_pl_hi.gif?' + Math.random(); 
		} break;
		case 2: { 
		document.images['obrazmapy'].src = 'http://icons.wxug.com/data/640x480/2xi_pl_wc.gif?' + Math.random(); 
		} break;
		case 3: { 
		document.images['obrazmapy'].src = 'http://icons.wxug.com/data/640x480/2xi_pl_dp.gif?' + Math.random(); 
		} break;
		case 4: { 
		document.images['obrazmapy'].src = 'http://icons.wxug.com/data/640x480/2xi_pl_rh.gif?' + Math.random(); 
		} break;
		case 5: { 
		document.images['obrazmapy'].src = 'http://icons.wxug.com/data/640x480/2xi_pl_vs.gif?' + Math.random(); 
		} break;
		case 6: { 
		document.images['obrazmapy'].src = 'http://icons.wxug.com/data/640x480/2xi_pl_ws.gif?' + Math.random(); 
		} break;
	}
	setTimeout(function() { 	document.getElementById("mapCont").style.fontSize="1em"; document.getElementById("mapCont").innerHTML=buf_cont; },  1370);
}

function bfwInt_str(bNumb) {
	switch(bNumb) {
		case 0: return 'Cisza'; break;
		case 1: return 'Powiew'; break;
		case 2: return 'Słaby'; break;
		case 3: return 'Łagodny'; break;
		case 4: return 'Umiarkowany'; break;
		case 5: return 'Dość silny'; break;
		case 6: return 'Silny'; break;
		case 7: return 'Bardzo silny'; break;
		case 8: return 'Sztorm'; break;
		case 9: return 'Silny sztorm'; break;
		case 10: return 'Bardzo silny sztorm'; break;
		case 11: return 'Wczesny huragan'; break;
		case 12: return 'Huragan'; break;
	}
}

function wind_dir_str(a) {
	var jaki_='';
	if(a<20 || a>=320) jaki_="z północy";
	else if(a>=20 && a<70) jaki_="z północnego wschodu";
	else if(a>=70 && a<110) jaki_="ze wschodu";
	else if(a>=110 && a<160) jaki_="z południowego wschodu";
	else if(a>=160 && a<215) jaki_="z południa";
	else if(a>=215 && a<240) jaki_="z południowego zachodu"
	else if(a>=240 && a<285) jaki_="z zachodu";
	else if(a>=285 && a<320) jaki_="z północnego zachodu";
	return jaki_;
}

function nextMinus() {
	nextRef--;
	document.getElementById("nrf").innerHTML=nextRef;
	if(nextRef<1) refresh();
}