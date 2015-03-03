<?php
session_start();
ini_set( "display_errors", 0);
require_once "dbconnect.php";
$polaczenie = mysql_connect($host,$user,$password);
mysql_query("SET CHARSET utf8");
mysql_query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'"); 
mysql_select_db($database);
$_SESSION['dziennyto'];
$_SESSION['foreto'];
$_SESSION['godzto'];

if( isset($_POST['wezpodstawowe']) ) {

	if($_POST['wezpodstawowe']=="nml") {
	$dzisiaj = date("Y-m-d");
	$zILE = mysql_query("SELECT id FROM podstawowe WHERE date='$dzisiaj'");
	$iledzis = mysql_num_rows($zILE);

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
	
	$jsdate=$dir['date']." ".$dir['time'];
	$jsatemp=$dir['atemp']; $jsotemp=$dir['otemp']; $jsrtemp=$dir['srtemp']; $jsdew=$dir['dew']."°C";
	$jspress=$dir['cisnie']; $jshum=$dir['wilgo']; 
	$jsgust=$dir['podmuch']; $jspeed=$dir['swind']; $jbfw=$dir['bfw']; $jsdom=$dir['domdirwind']; $jsdir=$dir['dirwind'];
	$jsrain=$dir['deszcz']; $jsraint=$dir['dobopad']; 
	$jstrendp=$dir['tencisn']."  ".$dir['tencisnval']."hPa/h";
	$jstrendt=$dir['tentemp']." ".$dir['tentempval']."°C/h";
	$jsbio = $dir['biomet'];
	
	if($ostSec>$nowSec-460 && $iledzis>0) { 
	$online="<span style='color: darkgreen;'>Stacja jest online!</span>";
	$secNextRef = (strtotime($jsdate)+155) - strtotime(date("Y-m-d H:i:s"));
	} else $secNextRef=" --";
	
echo<<<END
{
		"sectoref": "$secNextRef",
		"onoff": "$online",
		"datetime": "$jsdate",
		"atemp": "$jsatemp",
		"otemp": "$jsotemp",
		"srtemp": "$jsrtemp",
		"trendtemp": "$jstrendt",
		"dew": "$jsdew",
		"press": "$jspress",
		"trendpress": "$jstrendp",
		"hum": "$jshum",
		"gust": "$jsgust",
		"speed": "$jspeed",
		"bfw": "$jbfw",
		"domdir": "$jsdom",
		"dir": "$jsdir",
		"rain": "$jsrain",
		"raint": "$jsraint",
		"biomet": "$jsbio"
}
END;
	}
}

if( isset($_POST['changedayrep']) || isset($_POST['changeforecast']) ) {
	
	if($_POST['changedayrep']=="left") {
		if((int)$_SESSION['dziennyto']>1) $_SESSION['dziennyto']--;
		if($_SESSION['dziennyto']==1) $lend = true;
		
		if($_SESSION['dziennyto']==4) $_SESSION['dziennyto']=3;
		
	} else if($_POST['changedayrep']=="right") {
	
	$Zrozmiar = mysql_query("SELECT id FROM daytime");
	$rozmiar = mysql_num_rows($Zrozmiar);
	
	if($_SESSION['dziennyto'] <= $rozmiar) $_SESSION['dziennyto']++;
	if($_SESSION['dziennyto']==$rozmiar+1) $rend = true;
	
	if($_SESSION['dziennyto']==4) $_SESSION['dziennyto']=5;
	
	}
	
	if($_POST['changeforecast']=="left") {
		if((int)$_SESSION['foreto']>2) $_SESSION['foreto']--;
		if($_SESSION['foreto']==2) $lend = true;
	} else if($_POST['changeforecast']=="right") {
		if($_SESSION['foreto'] < 9) $_SESSION['foreto']++;
		if($_SESSION['foreto']==9) $rend = true;
	}

$dziennytolocal = $_SESSION['dziennyto'];
$Ztimes = mysql_query("SELECT * FROM daytime WHERE id='$dziennytolocal'");
if($_POST['changedayrep']=="first") {
	$Ztimes = mysql_query("SELECT * FROM daytime ORDER BY id DESC LIMIT 1");
	$timer = mysql_fetch_array($Ztimes); 
	$_SESSION['dziennyto']=$timer['id'];
	$_SESSION['foreto']='2';
	$_SESSION['godzto']='2';
	
	$br = $_SERVER['HTTP_USER_AGENT']; $dd = date("Y-m-d H:i:s"); $ip = $_SERVER['REMOTE_ADDR'];
	$qCheck = mysql_query("SELECT count(1) AS ile FROM browser WHERE brows='$br'");
	$check = mysql_fetch_assoc($qCheck);
		if($check['ile']==0) mysql_query("INSERT INTO browser SET brows='$br', data='$dd', ip='$ip' ");
		else mysql_query("UPDATE browser SET data='$dd', ip='$ip' WHERE brows='$br'");	
} else $timer = mysql_fetch_array($Ztimes); 
$id = $timer['id'];
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
$switt = explode(":", $blue['swit']);
$zmierzcht = explode(":", $blue['zmierzch']);

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
$swit = $switt[0].":".$switt[1];
$zmier = $zmierzcht[0].":".$zmierzcht[1];
$dbdata = $timer['ddata'];

$selId = $_SESSION['foreto'];
$Qprognozy = mysql_query("SELECT * FROM prognozy WHERE id='$selId'");
if($_POST['changedayrep']=="first") $Qprognozy = mysql_query("SELECT * FROM prognozy WHERE id=2");
$prognoza = mysql_fetch_array($Qprognozy);

$lendS = 'false';
if($lend) $lendS='true';

$rendS = 'false';
if($rend) $rendS='true';

echo "<b>".$dat['tempmax']."°C</b> (".$tmpH.") | <b>".$dat['hummax']."%</b> (".$wilH.") | <b>".$dat['pressmax']."hPa</b> (".$cisH.") |".$oth['domdir']."|".$mPow." <b>".$oth['mspeed']."m/s</b>| <b>".$oth['mpowiew']."m/s</b> (".$mPow.") |<b>".$oth['mopad']."</b> (".$mOpa.") |".$wschs."|".$zachs ."|".$dlugdzien."|".$wschk."|".$zachk."|".$blue['moonph']."| <b>".$dat['tempmin']."°C</b> (".$tmpL.") | <b>".$dat['hummin']."%</b> (".$wilL.") |<b>".$dat['pressmin']."hPa</b> (".$cisL.")|".$_SERVER['HTTP_USER_AGENT']."|".$oth['chmury']."|".$dbdata."|".$swit."|".$zmier."|".$prognoza['strprog']."|".$prognoza['dzientyg']."|".$prognoza['imgurl']."|".$lendS."|".$rendS;
}

if( isset($_POST['gethourlyforecast']) ) {
	if($_POST['gethourlyforecast']=="left") {
		if($_SESSION['godzto']>2) $_SESSION['godzto']--;
		if($_SESSION['godzto']==2) $lend = true;
	} else if($_POST['gethourlyforecast']=="right") {
		if($_SESSION['godzto']<37) $_SESSION['godzto']++;
		if($_SESSION['godzto']==37) $rend = true;
	}

$lendS = 'false';
if($lend) $lendS='true';

$rendS = 'false';
if($rend) $rendS='true';
	
	$hourid = $_SESSION['godzto'];
	$queryHourly = mysql_query("SELECT * FROM godzinna WHERE id='$hourid'");
	if($_POST['gethourlyforecast']=='false') $queryHourly = mysql_query("SELECT * FROM godzinna WHERE id=2");
	$godzinna = mysql_fetch_array($queryHourly);
	echo $godzinna['godz'].":00|".$godzinna['dtyg']."|".$godzinna['dmon']."|".$godzinna['napis']."|".$godzinna['temp']."|".$godzinna['dewp']."|".$godzinna['wdir']."|".$godzinna['wspd']."|".$godzinna['rain']."|".$godzinna['snow']."|".$godzinna['imgurl']."|".$lendS."|".$rendS;
}

// *** Min/max na miesiąc - sprawdzenie rekordów ***
if( isset($_GET['checkhighslows']) ) {
	$tL = "none"; $tH = "none"; $pL = "none"; $pH = "none";
	$hL = "none"; $hH = "none"; $wN = "none"; $rN = "none";
	
	$terazMiesiac = date("Y-m-");
	$queryRecTime = mysql_query("SELECT id FROM montime WHERE lupdate LIKE '$terazMiesiac%'");
	if(mysql_num_rows($queryRecTime)>0) {
		$RecTime = mysql_fetch_assoc($queryRecTime);
		$queryRecVal = mysql_query("SELECT * FROM mondata WHERE id=".$RecTime['id']);
		$RecVal = mysql_fetch_assoc($queryRecVal);

		$terazDzien = date("Y-m-d");
		$queryDayCheckID = mysql_query("SELECT id FROM daytime WHERE ddata='$terazDzien'");
		$DayCheckID = mysql_fetch_assoc($queryDayCheckID); $DayCheckID = $DayCheckID['id'];
		$queryDayCheckData = mysql_query("SELECT * FROM daydata WHERE id='$DayCheckID'");
		$queryDayCheckOther = mysql_query("SELECT * FROM dayother WHERE id='$DayCheckID'");
		$DayCheckData = mysql_fetch_assoc($queryDayCheckData); $DayCheckOther = mysql_fetch_assoc($queryDayCheckOther);

		if($DayCheckData['tempmin']<$RecVal['templ']) {
			$queryKiedyTo = mysql_query("SELECT tempmin FROM daytime WHERE ddata='$terazDzien'");
			$KiedyTo = mysql_fetch_assoc($queryKiedyTo);
			$tL = "Najniższa temperatura w tym miesiącu ".$DayCheckData['tempmin']."°C zanotowana dzisiaj o ".$KiedyTo['tempmin'];
		}

		if($DayCheckData['hummin']<$RecVal['huml']) {
			$queryKiedyTo = mysql_query("SELECT hummin FROM daytime WHERE ddata='$terazDzien'");
			$KiedyTo = mysql_fetch_assoc($queryKiedyTo);
			$hL = "Najniższa wilgotność w tym miesiącu ".$DayCheckData['hummin']."% zanotowana dzisiaj o ".$KiedyTo['hummin'];
		}

		if($DayCheckData['pressmin']<$RecVal['pressl']) {
			$queryKiedyTo = mysql_query("SELECT pressmin FROM daytime WHERE ddata='$terazDzien'");
			$KiedyTo = mysql_fetch_assoc($queryKiedyTo);
			$pL = "Najniższe ciśnienie w tym miesiącu ".$DayCheckData['pressmin']."hPa zanotowane dzisiaj o ".$KiedyTo['pressmin'];
		}

		if($DayCheckData['tempmax']>$RecVal['temph']) {
			$queryKiedyTo = mysql_query("SELECT tempmax FROM daytime WHERE ddata='$terazDzien'");
			$KiedyTo = mysql_fetch_assoc($queryKiedyTo);
			$tH = "Najwyższa temperatura w tym miesiącu ".$DayCheckData['tempmax']."°C zanotowana dzisiaj o ".$KiedyTo['tempmax'];
		}

		if($DayCheckData['hummax']>$RecVal['humh']) {
			$queryKiedyTo = mysql_query("SELECT hummax FROM daytime WHERE ddata='$terazDzien'");
			$KiedyTo = mysql_fetch_assoc($queryKiedyTo);
			$hH = "Najwyższa wilgotność w tym miesiącu ".$DayCheckData['hummax']."% zanotowana dzisiaj o ".$KiedyTo['hummax'];
		}

		if($DayCheckData['pressmax']>$RecVal['pressh']) {
			$queryKiedyTo = mysql_query("SELECT pressmax FROM daytime WHERE ddata='$terazDzien'");
			$KiedyTo = mysql_fetch_assoc($queryKiedyTo);
			$pH = "Najwyższe ciśnienie w tym miesiącu ".$DayCheckData['pressmax']."hPa zanotowane dzisiaj o ".$KiedyTo['pressmax'];
		}

		if($DayCheckOther['mpowiew']>$RecVal['windh']) {
			$wN = "Najsilniejszy podmuch w tym miesiącu ".($DayCheckOther['mpowiew']*3.6)."km/h zanotowany dzisiaj o ".$DayCheckOther['timempowiew'];
		}

		if($DayCheckOther['mopad']>$RecVal['rainh']) {
			$rN = "Największy opad deszczu w tym miesiącu ".$DayCheckOther['mopad']."mm zanotowany dzisiaj o ".$DayCheckOther['timemopad'];
		}
	}

echo<<<END
{
	"temp": {
		"low": "$tL",
		"high": "$tH"
	},
	"hum": {
		"low": "$hL",
		"high": "$hH"
	},
	"press": {
		"low": "$pL",
		"high": "$pH"
	},
	"other": {
		"wind": "$wN",
		"rain": "$rN"
	}
}
END;
	}

if (isset($_GET['otherpws']) && $_GET['otherpws']=="showme" ) {
$qOth = mysql_query("SELECT * FROM niemy WHERE id!=1");

echo '{ "pws": ['; $i=0;
	while( $oth = mysql_fetch_assoc($qOth) ) {
		$id = $oth['kiedy']; $t = $oth['temp'];
		$h = $oth['hum']; $p = $oth['press'];
		$d = $oth['dir']; $s = $oth['spd']; $r = $oth['raint'];
echo<<<END
{
"ostatni": "$id",
"temp": $t,
"hum": $h,
"press": $p,
"dir": $d,
"spd": $s,
"rain": $r
}
END;
if($i++ < 7) echo ",";
	}
echo "] }";
}	

 
?>