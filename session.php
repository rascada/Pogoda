<?php
session_start();
ini_set( "display_errors", 0);
require_once "dbconnect.php";
$polaczenie = mysql_connect($host,$user,$password);
mysql_query("SET CHARSET utf8");
mysql_query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'"); 
mysql_select_db($database);
$_SESSION['myid'];
$_SESSION['dziennyto'];
$_SESSION['foreto'];
$_SESSION['godzto'];


if( isset($_POST['log']) ) {

	if($_POST['log']=="in") { 
		$time = date("Y-m-d H:i:s");
		mysql_query("INSERT INTO sesje SET busy=1, kiedy='$time' ");
		$Zja = mysql_query("SELECT id FROM sesje ORDER BY id DESC LIMIT 1");
		$ja = mysql_fetch_array($Zja);
		$_SESSION['myid']=$ja['id'];
		$dzisiajdata=date("Y-m-d");
		$Ziddzis=mysql_query("SELECT id FROM daytime WHERE ddata='$dzisiajdata'");
		$iddzis = mysql_fetch_array($Ziddzis);
		$_SESSION['dziennyto']=$iddzis['id'];
		$_SESSION['foreto']='2';
		$_SESSION['godzto']='2';
		if((int)date("H")>20) $_SESSION['foreto']='3';
	} else if($_POST['log']=="out") {
		$sesid=$_SESSION['myid'];
		mysql_query("DELETE FROM sesje WHERE id='$sesid'");
		$dzisiajdata=date("Y-m-d");
		$Ziddzis=mysql_query("SELECT id FROM daytime WHERE ddata='$dzisiajdata'");
		$iddzis = mysql_fetch_array($Ziddzis);
		$_SESSION['dziennyto']=$iddzis['id'];
		$_SESSION['foreto']='2';
		$_SESSION['godzto']='2';
		if((int)date("H")>20) $_SESSION['foreto']='3';
	} else if($_POST['log']=="ok") {
		$sesid=$_SESSION['myid'];
		mysql_query("UPDATE sesje SET busy=0 WHERE id='$sesid'");
	} 
}


if( isset($_POST['wezpodstawowe']) ) {

	if($_POST['wezpodstawowe']=="nml") {
	$dzisiaj = date("Y-m-d");
	$zILE = mysql_query("SELECT id FROM podstawowe WHERE date='$dzisiaj'");
	$iledzis = mysql_num_rows($zILE);

	$dzisSec = $iledzis*300;
	$dzisH = (int)($dzisSec/3600);
	$dzisM = (int)($dzisSec-$dzisH*3600)/60;
	$dzisS = (int)($dzisSec-$dzisH*3600-$dzisM*60);
	if($dzisH<10) $dzisH = '0'.$dzisH;
	if($dzisM<10) $dzisM = '0'.$dzisM;

	$iledzis = $dzisH."godz. ".$dzisM."min.";

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

	$Zlogged = mysql_query("SELECT id FROM sesje");
	$logged = mysql_num_rows($Zlogged);


	if($ostSec>$nowSec-460) $online="<span style='color: darkgreen;'>Stacja jest online!</span>";
	echo $dir['date']." ".$dir['time']."|".$dir['atemp']."|".$dir['wilgo']."|".$dir['cisnie']."|".$dir['srtemp']."|".$dir['podmuch']."|".$dir['swind']."|".$dir['dirwind']."|".$dir['domdirwind']."|".$dir['otemp']."|".$dir['bfw']."|".$dir['dobopad']."|".$dir['deszcz']."|".$dir['tencisn']."  ".$dir['tencisnval']."hPa/h |".$dir['tentemp']." ".$dir['tentempval']."°C/h |NULL|NULL|".$dir['dew']."°C"."|".$iledzis."|".$online."|".$logged."|".$dir['biomet'];

	}
	
	if($_POST['wezpodstawowe']=="busyflag") {
	$Zbusy = mysql_query("SELECT busy FROM sesje WHERE id='".$_SESSION['myid']."'");
	$flag = mysql_fetch_array($Zbusy);
	echo $flag['busy'];
	}
}

if( isset($_POST['changedayrep']) || isset($_POST['changeforecast']) ) {
	
	if($_POST['changedayrep']=="left") {
		if((int)$_SESSION['dziennyto']>1) $_SESSION['dziennyto']--;
		
		if($_SESSION['dziennyto']==4) $_SESSION['dziennyto']=3;
		
	} else if($_POST['changedayrep']=="right") {
	
	$Zrozmiar = mysql_query("SELECT id FROM daytime");
	$rozmiar = mysql_num_rows($Zrozmiar);
	
	if($_SESSION['dziennyto'] <= $rozmiar) $_SESSION['dziennyto']++;
	
	if($_SESSION['dziennyto']==4) $_SESSION['dziennyto']=5;
	
	}
	
	if($_POST['changeforecast']=="left") {
		if((int)$_SESSION['foreto']>2) $_SESSION['foreto']--;
	} else if($_POST['changeforecast']=="right") {
		if($_SESSION['foreto'] < 9) $_SESSION['foreto']++;
	}

$dziennytolocal = $_SESSION['dziennyto'];
$Ztimes = mysql_query("SELECT * FROM daytime WHERE id='$dziennytolocal'");
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
$prognoza = mysql_fetch_array($Qprognozy);



echo "<b>".$dat['tempmax']."°C</b> (".$tmpH.") | <b>".$dat['hummax']."%</b> (".$wilH.") | <b>".$dat['pressmax']."hPa</b> (".$cisH.") |".$oth['domdir']."|".$mPow." <b>".$oth['mspeed']."m/s</b>| <b>".$oth['mpowiew']."m/s</b> (".$mPow.") |<b>".$oth['mopad']."</b> (".$mOpa.") |".$wschs."|".$zachs ."|".$dlugdzien."|".$wschk."|".$zachk."|".$blue['moonph']."| <b>".$dat['tempmin']."°C</b> (".$tmpL.") | <b>".$dat['hummin']."%</b> (".$wilL.") |<b>".$dat['pressmin']."hPa</b> (".$cisL.")|".$_SERVER['HTTP_USER_AGENT']."|".$oth['chmury']."|".$dbdata."|".$swit."|".$zmier."|".$prognoza['strprog']."|".$prognoza['dzientyg']."|".$prognoza['imgurl'];
}

if( isset($_POST['gethourlyforecast']) ) {
	if($_POST['gethourlyforecast']=="left") {
		if($_SESSION['godzto']>2) $_SESSION['godzto']--;
	} else if($_POST['gethourlyforecast']=="right") {
		if($_SESSION['godzto']<37) $_SESSION['godzto']++;
	}
	
	$hourid = $_SESSION['godzto'];
	$queryHourly = mysql_query("SELECT * FROM godzinna WHERE id='$hourid'");
	$godzinna = mysql_fetch_array($queryHourly);
	$miesrok = date("Y-m-");
	echo $godzinna['godz'].":00|".$godzinna['dtyg']."|".$miesrok.$godzinna['dmon']."|".$godzinna['napis']."|".$godzinna['temp']."|".$godzinna['dewp']."|".$godzinna['wdir']."|".$godzinna['wspd']."|".$godzinna['rain']."|".$godzinna['snow']."|".$godzinna['imgurl'];
}	
 
?>