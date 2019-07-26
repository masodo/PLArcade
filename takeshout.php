<?php
//-----------------------------------------------------------------------------------/
//Practical-Lightning-Arcade [PLA] 2.0 (ALPHA) based on PHP-Quick-Arcade 3.0 © Jcink.com
//Tournaments & JS By: SeanJ. - Heavily Modified by PracticalLightning Web Design
//Michael S. DeBurger [DeBurger Photo Image & Design]
//-----------------------------------------------------------------------------------/
//  phpQuickArcade v3.0.x © Jcink 2005-2010 quickarcade.jcink.com                        
//
//  Version: 3.0.23 Final. Released: Sunday, May 02, 2010
//-----------------------------------------------------------------------------------/
// Thanks to (Sean) http://seanj.jcink.com 
// for: Tournies, JS, and more
// ---------------------------------------------------------------------------------/
# Section: takeshout.php  Function: ajax receiver page for shouts   Modified: 7/26/2019   By: MaSoDo
//-----------------------------------------------------------------------------------/

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Incompatible Function Block #1
function run_query($sql=false, $no_inj_protect=""){
static $queries=Array();
if ($sql) $queries[]=$sql;
// Inject protection, filters queries to stop injections
// don't want it / need something here? Then set the flag to 1.
$sql=preg_replace("/--/i", "", $sql);
if(!$no_inj_protect) {
$sql=preg_replace("/UNION/i", "", $sql);
$sql=preg_replace("/concat/i", "", $sql);
$sql=preg_replace("/pass/i", "", $sql);
}
if($sql !="") $r_q=mysql_query($sql);
$h=htmlspecialchars(mysql_error(), ENT_QUOTES);
if($h) { 
$sql=htmlspecialchars($sql, ENT_QUOTES);	
echo "<script language='Javascript'>
alert('Database Error: ".$h."');
alert('Query used: ".$sql."');
</script>"; 
}
return $sql?$r_q:$queries;
}
require("./arcade_conf.php");
$connect = @mysql_connect($dbhost,$dbuser,$dbpass);
$selection = @mysql_select_db($dbname);
$h=mysql_error();
if (!$connect || !$selection) { 
echo "There was an error with the database. A detailed report of the error is available below.<br /><br /><textarea cols=70 rows=20>$h</textarea><br /><br />You should check your password and database details. If you find that they are correct, but your <br />arcade is still not functioning please contact your hosting provider."; 
die();
}
//END Incompatible Function Block #1
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_COOKIE['PHPSESSID'])) {
$key=htmlspecialchars($_COOKIE['PHPSESSID'], ENT_QUOTES);
}
$ipa = $_SERVER['REMOTE_ADDR'];
if (isset($_COOKIE['phpqa_user_c'])) {
$phpqa_user_cookie = htmlspecialchars($_COOKIE['phpqa_user_c'], ENT_QUOTES);
}
function vsess() {
global $key;
if(isset($_REQUEST['akey']) && $_REQUEST['akey'] != $key) { die("Authorization Mismatch"); }
}
if ($_POST['senttext'] != "") {
Global $ipa, $phpqa_user_cookie; 
$senttext = $_POST['senttext'];
vsess();
$time = time();

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Incompatible Function Block #2
run_query("INSERT INTO `phpqa_shoutbox` (`name`,`shout`,`ipa`,`tstamp`) VALUES ('".$phpqa_user_cookie."','".$senttext."','".$ipa."','".$time."')", 1);
//END Incompatible Function Block #1
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

}
?>
