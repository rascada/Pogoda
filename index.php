<!DOCTYPE html>
<html>
<head>
    <!-- liniks -->
    <link href="http://fonts.googleapis.com/css?family=Rajdhani:400,600&amp;subset=latin,latin-ext" rel="stylesheet" type="text/css">
    <!-- scripts -->
<script type="application/javascript" src="js/jquery-2.1.3.js"></script>
<title>Pogoda Skałągi</title>
<link rel="icon" href="img/cloud.ico" type="image/x-icon"/>
<link type="text/css" rel="stylesheet" href="css/style.css"/>
<meta charset="utf-8" />
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-58565456-1', 'auto');
  ga('send', 'pageview');
</script>
<meta name="description" content="Stacja pogodowa - meteo Skałągi w gminie Wołczyn, powiat Kluczborski, woj. opolskie. Aktualna pogoda, aktualizacja co 5min.">
<meta name="keywords" content="stacja, meteo, pogodowa, pogoda, skałągi, temperatura, wiatr, kluczbork, wołczyn, prognoza, wilgotność, meteorologiczna, szkoła, podstawowa, rcre, opolskie">
</head>
<?php
ini_set( "display_errors", 0);
require_once "upwu.php";
?>
<body>    
    <!------------------------HEADER------------------------------------>
    <header>
        <div id='logo'>
            <div id="logoSunBox">
                <ul id='logoSun'>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div>
            <h1>Stacja pogodowa Skałągi</h1>      
            <h3>Ostatnia aktualiazacja: <span id="last">Łącze..</span></h3><br/>
        </div>      
        <div id='smileyFaceCont' class="ramka bigPanel">
            <div id='smileyFace'>
                <div id='smileyFaceDarken'></div>
                <div id='smileyFaceLighten'></div>
                <div id='eyesCont'>
                    <div class='eye'></div>
                    <div class='eye eye1'></div>
                </div>
                <div id='mouth'></div>                
                <span id='biomet'>Biomet</span>
                <span id='biometOdczyt'>Ładuje..</span>
            </div>
        </div>
    </header>

<div id='all'>

<div id="panel2" class="panel">
    <!------------------------WaterPanel---------------------------------->
<div id='waterPanel' class="bigPanel">  
    <h1 class="bigPanelH">Opady</h1>
    <!-----------------------miarka1----------------------------------->
    <div class='waterTogether'>
        <div class="f">
            <div class="fluid"><span id="aktopad">0<br/>mm/h</span>
                <div class='waterCont'><div class="water" id='water12'></div></div>
                <div id='miarka12' class='miarka1'></div>
            </div>
        </div><p>Aktualne</p>
    </div>    
    <!-----------------------miarka2----------------------------------->
    <div class='waterTogether'>
        <div id='f2' class="f">
            <div class="fluid"><span id="opadd">0<br/>mm</span>
                <div class='waterCont'><div class="water" id='water2'></div></div>
                <div id='miarka2' class='miarka1'></div>
            </div>
        </div><p>24h</p>
    </div>    
</div>
    
	<div class="bigPanel" style="width: 100%; margin-top: 0;">
        <div id="dew" class="ramka bigHeader">
            <h4 class="bigPanelH"><b>Wysokość podstawy chmur: </b><span id='clouds'>0</span> </h4>
        </div>
	</div>
    
</div>
<!------------------------Temperatura------------------------------------>
    <div id='tempPanel' class="bigPanel">
        <h1 class="bigPanelH">Temperatura</h1>
        <h3><span id="tentemp">Tendencja</span></h3><br/>
        <!----------------temp1------------------>
        <div class='termometr'>
            <div class="tempBody">
                    <div class="termMeter">
                        <div id='aTemp' class='termC'></div>
                    </div>
                    <div class="termMeter2">
                        <span id="atemval">°C</span>
                    </div>
                <div class='tempMiarka' id='tempMiarka1'></div>
            </div>
            <p>Aktualna</p>
        </div>
        <!-----------------temp2----------------->
        <div class='termometr'>
            <div class="tempBody">
                <div class="termMeter">
                    <div id='oTemp' class='termC'></div>
                </div>
                <div class="termMeter2">
                    <span id="otemval">°C</span>
                </div>
                <div class='tempMiarka' id='tempMiarka2'></div>
        </div>
            <p>Odczuwalna</p>
        </div>
        <!----------------temp3------------------>
        <div class='termometr'>
            <div class="tempBody">
                <div class="termMeter">
                    <div id='srTemp' class='termC'></div>
                </div>
                <div class="termMeter2">
                    <span id="srtemval">°C</span>
                </div>
                <div class='tempMiarka' id='tempMiarka3'></div>
            </div>
            <p>Średnia</p>
        </div>
        <!------------------------coTera------------------------------------>
        <div id='dew' class="ramka bigHeader">
            <h4 class="bigPanelH"><b>Punkt rosy: </b><span id='dewDeg'>0</span> </h4>
        </div>
    </div>  
<!------------------------Wiatr------------------------------------>
<div id='contL' style="border: 0; margin-top: 2em;">
<div id='windPanel' class="bigPanel" style="margin-top: 0;">    
    <h1 class="bigPanelH" id="windBfw">Wiatr</h1>
    <!-----------------------compass1---------------------------------->
    <div class='compassCont'>
        <div  id='compass1' class="compass">
            <div class="compArr" id="cm1">
                <span class="compArrDeg" id="cmL1">0</span>
            </div>                  
            <div class='licznikKomp'>
              <div id='strz1' class='strz'></div>
              <div class='dot'></div>
              <div class='liczPods' id='liczPods1'></div>  
                <span class='liczCyf labelek' id='wSpeed' onclick="aktwindclick()">Ładuje..</span>
            </div>  
        </div><br/>  
        <span class="compassSpan"  id="aktDirVal">Aktualny</span>
    </div>  
    <!-----------------------compass2---------------------------------->
    <div class='compassCont'>
        <div  id='compass2' class="compass">
            <div class="compArr" id="cm2">
                <span class="compArrDeg" id="cmL2">0</span>
            </div>  
            <div class='licznikKomp'>
              <div id='strz2' class='strz'></div>
              <div class='dot'></div>
              <div class='liczPods' id='liczPods2'></div>  
                <span class='liczCyf labelek' id='wPSpeed' onclick="podwindclick()">Ładuje..</span>
            </div>
        </div><br/>
        <span class="compassSpan"  id="domDirVal">Dominujący</span>
    </div> <br/>
</div><br/>
    <!----------------------------ciśnienie-------------------------------------------->
<div id='contL2'>
    <div class="bigPanel" id='cisPanel'>
        <h1 class='bigPanelH'>Ciśnienie</h1>
        <div id='cisnienieCont'>
            <div class='licznikCont'>
                <div id='cisLicznik' class='licznik'>
                    <div id='strz3' class='strz'></div>
                    <div class='dot'></div>
                    <div class='liczPods' id='liczPods3'></div>  
                    <span  class='liczCyf' id='pressval'>Ładuje..</span>
                </div>
            </div>
        </div>
    </div>
    <!----------------------------wilgotność-------------------------------------------->
    <div class="bigPanel" id='wilPanel'>
        <h1 class='bigPanelH'>Wilgotność</h1>
        <div id='wilgCont'>
            <div class='licznikCont'>
                <div class='licznik'>
                    <div id='humPercWater'></div>
                    <div id='strz4' class='strz'></div>
                    <div class='dot'></div>
                    <div class='liczPods' id='liczPods4'></div>  
                    <span  class='liczCyf' id='wilval'>Ładuje..</span>
                </div>
            </div>            
        </div>
    </div>
    
</div>
</div>
<div class='panel' id='panel1'>
    <div id='allFore'>
        <div id='prognoza' class="ramka bigPanel">
            <h3>Prognoza - trzydniowa</h3>
            <div id='weatherUndergroundCont'>
                   <span id='weather'>Ładuje...</span>
                    <img name='forecast' id='foreIcon' />
                   <span id='forecast'>Ładuje...</span>
			         <a href="http://www.wunderground.com/personal-weather-station/dashboard?ID=IOPOLSKI10" target="_blank"><img id='wuIcon' src="img/wu.png"/></a>        
            <div class='arrowContainer'>
                <div id='RRArrow' style='transform: scale(.7)rotate(180deg);' onclick="jschangefore(true)"><div class='RaportArrow'></div></div>
                <div id='RLArrow' style='transform: scale(.7);' class="weatherArrowsL" onclick="jschangefore(false)"><div class='RaportArrow'></div></div>
            </div>
            </div>

        </div>
        
        <div id='fore36Cont'class="ramka bigPanel">
            <h3>Prognoza - 36 godzinna</h3>
            
            <img id='bigforeimg' name="bigforeimg"/>
            <div class="fore36Heading">
                <div class='arrowContainer'>
                    <div id='RRArrow' style='transform: scale(.7)rotate(180deg);' onclick="refhourly(2)"><div class='RaportArrow'></div></div>
                    <div id='RLArrow' style='transform: scale(.7);' class="weatherArrowsL" onclick="refhourly(1)"><div class='RaportArrow'></div></div>
                </div>
                <span id="bigforetime"></span>
                <span id="bigforedate"></span>
            </div>
            <div class="fore36Data">
                <span class="fore36Text" id="bigforetext"></span>
                <span class="fore36Text">Temp: <span id="bigforetemp"></span></span>
                <span class="fore36Text">Pkt. rosy: <span id="bigforedew"></span></span>
                <span class="fore36Text">Wiatr: <span id="bigforewdir"></span>
                <span id="bigforewspd"></span></span>
                <span class="fore36Text">Deszcz: <span id="bigforerain"></span></span>
                <span class="fore36Text">Śnieg: <span id="bigforesnow"></span></span>
            </div>
        </div>
        
        
    </div>
<div id='raportDniaRamka' class="ramka bigPanel">
    <div class='arrowContainer'>
        <div id='RRArrow' onclick="jschangeday(true)"><div class='RaportArrow'></div></div>
        <div id='RLArrow' onclick="jschangeday(false)"><div class='RaportArrow'></div></div>
    </div>
    <h3>Raport dnia - <span id="daydate">Ładuje...</span></h3>
        <div id='raportDnia'>  
            <div id='raportDniaA'>
                <div class='minMaxBG grey'>
                    <div class='minMax '>
                      <b>Słońce </b>
                    </div>
                    <div class='minMax '>                                
                        <b>Brzask: </b><span id='sunBrz'>0:00</span><br/>
                        <b>Wschód: </b><span id='sunWsch'>0:00</span><br/>   
                        <b>Zachód: </b><span id='sunZch'>0:00</span><br/>         
                        <b>Zmierzch: </b><span id='sunZm'>0:00</span><br/>
                    </div>
                </div>  
                <div class="grey">
                    <b>Długość dnia</b> - <span id='dayLen'>0:00</span>
                </div>
                <div class='minMaxBG grey'>
                    <div class='minMax '>
                      <b>Księżyc </b>
                    </div>
                    <div class='minMax '>
                        <b>Wschód: </b><span id='moonWsch'>0:00</span><br/>
                        <b>Zachód: </b><span id='moonZch'>0:00</span><br/>
                    </div>
                </div>
                <div class='minMaxBG grey'>
                    <div class='minMax '>                        
                        <b>Faza księżyca</b><br/> <span id='moonPhase'>Sprawdzanie</span>
                    </div>
                    <div class='minMax '>  
                        <div id='moonDiv'>  
                        </div>              
                    </div>
                </div>  
            </div>
            <div id='raportDniaA'>            
                <div class="grey">
                    <b>Wiatr</b> <br/>
                    <b>Podmuch</b> -<span id="windDayBlow"> 0 m/s</span><br/>
                    <b>Dominujący kierunek</b> - <span id="windDayDom"> </span><br/>
                </div>
                <div class="grey">
                    <b>Opady (mm/h)</b> -<span id="rainDay">0 mm</span><br/>
                </div>
                <div class='minMaxBG grey'>
                    <div class='minMax'>
                        <b>Temperatura </b>  
                    </div><div class='minMax '>
                        <b>max:</b><span id='tempDayMax'>0</span><br/>
                        <b>min:</b> <span id='tempDayMin'>0</span><br/>
                    </div>
                </div>
                <div class='minMaxBG grey'>
                    <div class='minMax '>
                        <b>Wilgotność </b>  
                    </div><div class='minMax '>
                        <b>max:</b><span id='wilDayMax'>0%</span><br/>
                        <b>min:</b> <span id='wilDayMin'>0%</span><br/>
                    </div>
                </div>
                <div class='minMaxBG grey'>
                    <div class='minMax '>
                      <b>Ciśnienie </b>
                    </div><div class='minMax '>
                        <b>max:</b><span id='cisDayMax'>0 hPa</span><br/>
                        <b>min: </b> <span id='cisDayMin'>0 hPa</span><br/>
                    </div>
                </div>
            </div>
        </div>
</div>
    
        <div id='buttonWykresCont' class="ramka bigPanel">            
            <h3>Menu</h3>
            <a href="graph.html"><button id='buttonWykres'>Wykresy</button></a><!--     
            --><a href="#"><button id='buttonWykres' onclick="javascript: alert('Strona w budowie!');">Statystyki</button></a><!--     
            --><br/><a href="http://pogoda.snit.rcre.opolskie.pl/" target="_blank"><button id='buttonWykres'>Stacje w okolicy</button></a>
            

        <footer><hr/>SP Skałągi &copy;opyright 2015<br/> Frontend by Damian Martyniak<br/> Backend by Marcin Łacina<hr/> <div style="font-size: .83em; color: black;">Wspierane przeglądarki: <br/>Chrome i Firefox w najnowszych wersjach.<br/>Wkrótce też najnowszy IE.</footer>
            </div>
</div>
<!--all-->
</div>

<div id='hint'>Zmień jednostki</div>

<script type="application/javascript" src="js/script.js"></script>
</body>
</html>
