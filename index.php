<!DOCTYPE html>
<html>
<head>
    <!-- liniks -->
    <link href="http://fonts.googleapis.com/css?family=Rajdhani:400,600&amp;subset=latin,latin-ext" rel="stylesheet" type="text/css">
    <!-- scripts -->
<script type="text/javascript" src="js/jquery-2.1.3.js"></script>
<title>Pogoda Skałągi</title>
<link rel="icon" href="img/cloud.ico" type="image/x-icon">
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
session_start();
ini_set( "display_errors", 0);
require_once "dbconnect.php";
$polaczenie = mysql_connect($host,$user,$password);
mysql_query("SET CHARSET utf8");
mysql_query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'"); 
mysql_select_db($database);
$myid = $_SESSION['myid'];
?>
<body onload="refresh()">    
    <!------------------------HEADER------------------------------------>
    <header>      
        <ul id='logoSun'>
            <li></li>
            <li></li>
            <li></li>
        </ul>
            <h3>Ostatnia aktualiazacja: <span id="last">Łącze..</span></h3>
            <h1>Stacja pogodowa Skałągi</h1><br/>            
            <h2>Szkoła Podstawowa - 51°03′N 18°07′E</h2>  
    </header><br/> 

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
    
<div id='fore' class="ramka bigPanel">
    <h3>Raport dnia</h3>
        <p>
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
        </p>
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
<div id='contL'>
<div id='windPanel' class="bigPanel">    
    <h1 class="bigPanelH">Wiatr</h1>
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
                <span class='liczCyf' id='wSpeed' onclick="aktwindclick()">Aktulany<br/>1 m/s
                    <div id='hint'>Kliknij aby zmienić jednostki</div>
                </span>
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
                <span class='liczCyf' id='wPSpeed' onclick="podwindclick()">Aktulany<br/>0 m/s</span>
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
                    <span  class='liczCyf' id='pressval'>0 m/s</span>
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
                    <span  class='liczCyf' id='wilval'>0 m/s</span>
                </div>
            </div>            
        </div>
    </div>
</div>
</div>
<div class='panel' id='panel1'>
    
        
        <div id='fore' class="ramka bigPanel">
            <h3>Prognoza</h3>
            <p>
                <b>Pogoda: </b><br/><span id='weather'></span><br/><hr/>
                <b>Prognoza: </b><br/><span id='forecast'></span>
            </p>
        </div>
    
        <!------------------------slon------------------------------------>
        <div class="ramka bigPanel" id='slon'>
            <h3>Słońce</h3>
                <p>
                    <b>Wschód: </b><span id='sunWsch'>0:00</span><br/>
                    <b>Zachód: </b><span id='sunZch'>0:00</span><hr/>
                    <b>Długość dnia</b> - <span id='dayLen'>0:00</span>
                </p>
        </div>            
        <!------------------------ksiezyc------------------------------------>
        <div class="ramka bigPanel" id='ksi'>
            <h3>Księżyc</h3>
            <div id='ksik'>
            <div>
                <p>
                    <b>Wschód: </b><span id='moonWsch'>0:00</span><br/>
                    <b>Zachód: </b><span id='moonZch'>0:00</span><hr/>
                    <b>Faza księżyca</b> - <span id='moonPhase'>Sprawdzanie</span>
                </p>
            </div>
            <img src='#'/>
            </div>
        </div>
        
        <div id='buttonWykresCont' class="ramka bigPanel">
            <a href="graph.html"><button id='buttonWykres'>Wykresy</button></a>    
            <br/>
            <a href="http://pogoda.snit.rcre.opolskie.pl/" target="_blank"><button id='buttonWykres'>Stacje w okolicy</button></a>
            

        <footer><hr/><br/>SP Skałągi &copy;opyright 2015<br/> Frontend by Damian Martyniak<br/> Backend by Marcin Łacina</footer>    
            </div>
</div>
<!--all-->
</div>

<!--------------------------------------------------niewidzialne divy-------------------------->
<div id="busy" style="z-index: -10; position: absolute; visibility: hidden;">
<div id="flag">
<?php
$Zbusy = mysql_query("SELECT busy FROM sesje WHERE id='$myid'");
$flag = mysql_fetch_array($Zbusy);
echo $flag['busy'];
?>
</div></div>
<div id="podstawowe_p" style="z-index: -10; position: absolute; visibility: hidden;">
<div id="podstawowe_k">
<?php
$dzisiaj = date("Y-m-d");
$zILE = mysql_query("SELECT id FROM podstawowe WHERE date='$dzisiaj'");
$iledzis = mysql_num_rows($zILE);

$dzisSec = $iledzis*300;
$dzisH = (int)($dzisSec/3600);
$dzisM = (int)($dzisSec-$dzisH*3600)/60;
$dzisS = (int)($dzisSec-$dzisH*3600-$dzisM*60);
if($dzisH<10) $dzisH = '0'.$dzisH;
if($dzisM<10) $dzisM = '0'.$dzisM;
if($dzisS<10) $dzisS = '0'.$dzisS;

$iledzis = $dzisH.":".$dzisM.":".$dzisS;

$zap = mysql_query("SELECT * FROM podstawowe ORDER BY id DESC LIMIT 1");
$dir = mysql_fetch_array($zap); 

$online = "<span style='color: red;'>Stacja jest offline!</span>";
$nowdate = date("H:i:s");
$ostatni = $dir['time'];
$os = explode(":", $ostatni); 
$no = explode(":", $nowdate);

$os[0] = (int)$os[0]; $os[1] = (int)$os[1]; $os[2] = (int)$os[2];
$no[0] = (int)$no[0]; $no[1] = (int)$no[1]; $no[2] = (int)$no[2];

$os[0] *= 3600;
$os[1] *= 60;
$no[0] *= 3600;
$no[1] *= 60;

$ostSec = $os[0]+$os[1]+$os[2];
$nowSec = $no[0]+$no[1]+$noS[2];


if($ostSec>$nowSec-360 && $iledzis>0) $online="<span style='color: darkgreen;'>Stacja jest online!</span>";

echo $ostSec."  ".$nowSec;
echo $dir['date']." ".$dir['time']."|".$dir['atemp']."|".$dir['wilgo']."|".$dir['cisnie']."|".$dir['srtemp']."|".$dir['podmuch']."|".$dir['swind']."|".$dir['dirwind']."|".$dir['domdirwind']."|".$dir['otemp']."|".$dir['bfw']."|".$dir['dobopad']."|".$dir['deszcz']."|".$dir['tencisn']."  ".$dir['tencisnval']."hPa/h |".$dir['tentemp']." ".$dir['tentempval']."°C/h |".$dir['progno']."|".$dir['zamb']."|".$dir['dew']."°C"."|".$iledzis."|".$online;
?>
</div>
</div>
<!-----------------------------niewidzialne dzielenie divów-------------------------->
<div id="dayrep_p" style="z-index: -10; position: absolute; visibility: hidden;">
<div id="dayrep_k">
<?php
$Ztimes = mysql_query("SELECT * FROM daytime ORDER BY id DESC LIMIT 1");
$timer = mysql_fetch_array($Ztimes); $id = $timer['id'];
$Zdat = mysql_query("SELECT * FROM daydata WHERE id='$id'");
$dat = mysql_fetch_array($Zdat); 
$Zother = mysql_query("SELECT * FROM dayother WHERE id='$id'");
$oth = mysql_fetch_array($Zother); 
$Zblue = mysql_query("SELECT * FROM dayblue WHERE id='$id'");
$blue = mysql_fetch_array($Zblue); 

$tmpHt = explode(":", $timer['tempmax']);
$tmpLt = explode(":", $timer['tempmin']);
$wilHt = explode(":", $timer['hummax']);
$wilLt = explode(":", $timer['hummin']);
$cisHt = explode(":", $timer['pressmax']);
$cisLt = explode(":", $timer['pressmin']);
$powiewMtt = explode(":", $oth['timempowiew']);
$opadMtt = explode(":", $oth['timemopad']);
$wschst = explode(":", $blue['sunrise']);
$zachst = explode(":", $blue['sunset']);
$dlugdzient = explode(":", $blue['daylen']);
$wschkt = explode(":", $blue['moonrise']);
$zachkt = explode(":", $blue['moonset']);

$tmpH = $tmpHt[0].":".$tmpHt[1];
$tmpL = $tmpLt[0].":".$tmpLt[1];
$wilH = $wilHt[0].":".$wilHt[1];
$wilL = $wilLt[0].":".$wilLt[1];
$cisH = $cisHt[0].":".$cisHt[1];
$cisL = $cisLt[0].":".$cisLt[1];
$mPow = $powiewMtt[0].":".$powiewMtt[1];
$mOpa = $opadMtt[0].":".$opadMtt[1];
$wschs = $wschst[0].":".$wschst[1];
$zachs = $zachst[0].":".$zachst[1];
$dlugdzien = $dlugdzient[0].":".$dlugdzient[1];
$wschk = $wschkt[0].":".$wschkt[1];
$zachk = $zachkt[0].":".$zachkt[1];


echo "<b>".$dat['tempmax']."°C</b> (".$tmpH.") | <b>".$dat['hummax']."%</b> (".$wilH.") | <b>".$dat['pressmax']."hPa</b> (".$cisH.") |".$oth['domdir']."|".$mPow." <b>".$oth['mspeed']."m/s</b>| <b>".$oth['mpowiew']."m/s</b> (".$mPow.") |<b>".$oth['mopad']."</b> (".$mOpa.") |".$wschs."|".$zachs ."|".$dlugdzien."|".$wschk."|".$zachk."|".$blue['moonph']."| <b>".$dat['tempmin']."°C</b> (".$tmpL.") | <b>".$dat['hummin']."%</b> (".$wilL.") |<b>".$dat['pressmin']."hPa</b> (".$cisL.")";
?>
</div>
</div>

<script type="text/javascript" src="js/script.js"></script>
</body>
</html>
