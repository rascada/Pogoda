<?php
session_start();
ini_set( "display_errors", 0);
require_once "dbconnect.php";
$polaczenie = mysql_connect($host,$user,$password);
mysql_query("SET CHARSET utf8");
mysql_query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'"); 
mysql_select_db($database);
$_SESSION['myid'];

if( isset($_POST['log']) ) {

	if($_POST['log']=="in") { 
		mysql_query("INSERT INTO sesje SET busy=1");
		$Zja = mysql_query("SELECT id FROM sesje ORDER BY id DESC LIMIT 1");
		$ja = mysql_fetch_array($Zja);
		$_SESSION['myid']=$ja['id'];
	} else if($_POST['log']=="out") {
	$sesid=$_SESSION['myid'];
	mysql_query("DELETE FROM sesje WHERE id='$sesid'");
	} else if($_POST['log']=="ok") {
	$sesid=$_SESSION['myid'];
	mysql_query("UPDATE sesje SET busy=0 WHERE id='$sesid'");
	}
} 
?>