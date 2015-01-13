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
</head>
<?php
ini_set( "display_errors", 0);
require_once "dbconnect.php";
$polaczenie = mysql_connect($host,$user,$password);
mysql_query("SET CHARSET utf8");
mysql_query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'"); 
mysql_select_db($database);
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
    <h3>Rekordy dnia</h3>
        <p>
            <b>Podmuch wiatru</b> -<span id="windDayBlow"> 0 m/s</span><br/>
            <b>Opady (mm/h)</b> -<span id="rainDay">0 mm</span><br/>
            <b>Temperatura: </b>  
                <b>min:</b> <span id='tempDayMin'>0</span> <b>max:</b><span id='tempDayMax'>0</span><br/>
            <b>Wilgotność: </b>  
                <b>min:</b> <span id='wilDayMin'>0%</span> <b>max:</b><span id='wilDayMax'>0%</span><br/>
            <b>Ciśnienie: </b>  
                <b>min: </b> <span id='cisDayMin'>0 hPa</span> <b>max:</b><span id='cisDayMax'>0 hPa</span><br/>
        </p>
</div>
</div>
<!------------------------Temperatura------------------------------------>
    <div id='tempPanel' class="bigPanel">
        <h1 class="bigPanelH">Temperatura</h1>
        <h3><span id="tentemp">Tendencja</span></h3><br/>
        <!----------------temp1------------------>
        <div class='termometr'>
            <div class="termMeter">
                <div id='aTemp' class='termC'></div>
            </div>
            <div class="termMeter2">
                <span id="atemval">°C</span>
            </div>
            <img height='500px' width="100px" src="img/termometer.png">
                <p>Aktualna</p>
            </img>
        </div>
        <!-----------------temp2----------------->
        <div class='termometr'>
            <div class="termMeter">
                <div id='oTemp' class='termC'></div>
            </div>
            <div class="termMeter2">
                <span id="otemval">°C</span>
            </div>
            <img height='500px' width="100px" src="img/termometer.png">
                <p>Odczuwalna</p>
            </img>
        </div>
        <!----------------temp3------------------>
        <div class='termometr'>
            <div class="termMeter">
                <div id='srTemp' class='termC'></div>
            </div>
            <div class="termMeter2">
                <span id="srtemval">°C</span>
            </div>
            <img height='500px' width="100px" src="img/termometer.png">
                <p>Średnia</p>
            </img>
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
                <span class='liczCyf' id='wSpeed'>Aktulany<br/>1 m/s</span>
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
                <span class='liczCyf' id='wPSpeed'>Aktulany<br/>0 m/s</span>
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
                <div class='licznik'>
                    <div id='strz3' class='strz'></div>
                    <div class='dot'></div>
                    <div class='liczPods' id='liczPods3'></div>  
                    <span  class='liczCyf' id='pressval'>0 m/s</span>
                </div>
                <span class='liczPod'>Aktualna</span>
            </div>
        </div>
    </div>
    <!----------------------------wilgotność-------------------------------------------->
    <div class="bigPanel" id='wilPanel'>
        <h1 class='bigPanelH'>Wilgotność</h1>
        <div id='wilgCont'>
            <div class='licznikCont'>
                <div class='licznik'>
                    <div id='strz4' class='strz'></div>
                    <div class='dot'></div>
                    <div class='liczPods' id='liczPods4'></div>  
                    <span  class='liczCyf' id='wilval'>0 m/s</span>
                </div>
                <span class='liczPod'>Aktualna</span>
            </div>            
        </div>
    </div>
</div>
</div>
    <!------------------------slon------------------------------------>
<div class='panel' id='panel1'>
        <div class="ramka bigPanel" id='slon'>
            <h3>Słońce</h3>
                <p>
                    <b>Wschód: </b><span id='sunWsch'>0:00</span>
                    <b>Zachód: </b><span id='sunZch'>0:00</span><br/>
                    <b>Długość dnia</b> - <span id='dayLen'>0:00</span>
                </p>
        </div>    
    
        <div id='buttonWykresCont' class="ramka bigPanel">
            <button id='buttonWykres'>Wykresy</button>
        </div>
    
        <div id='fore' class="ramka bigPanel">
            <h3>Prognoza</h3>
            <p><b><span id='forecast'>Przewiduje</span></b></p>
        </div>
        <!------------------------ksiezyc------------------------------------>
        <div class="ramka bigPanel" id='ksi'>
            <h3>Księżyc</h3>
            <div id='ksik'>
            <div>
                <p>
                    <b>Wschód: </b><span id='moonWsch'>0:00</span>
                    <b>Zachód: </b><span id='moonZch'>0:00</span><br/>
                    <b>Faza księżyca</b> - <span id='moonPhase'>Sprawdzanie</span>
                </p>
            </div>
            <img src='#'/>
            </div>
        </div>
    
    
<footer class="bigPanel">&copy;opyright 2015<br/> Frontend by Damian Martyniak<br/> Backend by Marcin Łacina</footer>    
    
</div>
<!--all-->
</div>
<!--------------------------------------------------niewidzialne divy-------------------------->
<div id="podstawowe_p" style="z-index: -10; position: absolute; visibility: hidden;">
<div id="podstawowe_k">
<?php
$dzisiaj = date("Y-m-d");
$zILE = mysql_query("SELECT id FROM podstawowe WHERE date='$dzisiaj'");
$iledzis = mysql_num_rows($zILE);

$ostatni = explode(":", $dir['time']);
$online = "Stacja jest offline!";
$nowdate = date("H:i");
$now = explode (":", $nowdate);
if($ostatni[0]==$now[0] && $now[1]<$ostatni+8) $online="Stacja jest online!";

$zap = mysql_query("SELECT * FROM podstawowe ORDER BY id DESC LIMIT 1");
$dir = mysql_fetch_array($zap); 
echo $dir['date']." ".$dir['time']."|".$dir['atemp']."|".$dir['wilgo']."|".$dir['cisnie']."|".$dir['srtemp']."|".$dir['podmuch']."|".$dir['swind']."|".$dir['dirwind']."|".$dir['domdirwind']."|".$dir['otemp']."|".$dir['bfw']."|".$dir['dobopad']."|".$dir['deszcz']."|".$dir['tencisn']."  ".$dir['tencisnval']."hPa/h |".$dir['tentemp']." ".$dir['tentempval']."°C/h |".$dir['progno']."|".$dir['zamb']."|".$dir['dew']."°C"."|".$iledzis."|".$online;
?>
</div>
</div>
<!-----------------------------niewidzialne dzielenie divów-------------------------->
<div id="dayrep_p" style="z-index: -10; position: absolute; visibility: hidden;">
<div id="dayrep_k">
<?php
$dzis = date("Y-m-d");
$Ztimes = mysql_query("SELECT * FROM daytime WHERE ddata='$dzis' ");
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

$tmpH = $tmpHt[0].":".$tmpHt[1];
$tmpL = $tmpLt[0].":".$tmpLt[1];
$wilH = $wilHt[0].":".$wilHt[1];
$wilL = $wilLt[0].":".$wilLt[1];
$cisH = $cisHt[0].":".$cisHt[1];
$cisL = $cisLt[0].":".$cisLt[1];
$mPow = $powiewMtt[0].":".$powiewMtt[1];
$mOpa = $opadMtt[0].":".$opadMtt[1];

echo $tmpH." <b>".$dat['tempmax']."</b>|".$wilH." <b>".$dat['hummax']."</b>|".$cisH." <b>".$dat['pressmax']."</b>|".$oth['domdir']."|".$mPow." <b>".$oth['mspeed']."</b>|".$mPow." <b>".$oth['mpowiew']."</b>|".$mOpa." <b>".$oth['mopad']."</b>|".$blue['sunrise']."|".$blue['sunset']."|".$blue['daylen']."|".$blue['moonrise']."|".$blue['moonset']."|".$blue['moonph']."|".$tmpL." <b>".$dat['tempmin']."</b>|".$wilL." <b>".$dat['hummin']."</b>|".$cisL." <b>".$dat['pressmin']."</b>";
?>
</div>
</div>
<script type="text/javascript" src="js/script.js"></script>
</body>
</html>
