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
# Section: acpi Place: mysql - Administrator Control Panel   Modified: 7/26/2019   By: MaSoDo

{
$goquery1 = '';
$goquery2 = '';
$goquery3 = '';
$goquery4 = '';

//Hall of fame scores reset
if(isset($_POST['HOFwipe'])&&$_POST['HOFwipe']=='1'){
if(isset($_POST['RESETH'])&&isset($_POST['RESETH'])=='yes'){
vsess();

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Incompatible Function Block #1
$goquery1=run_query("UPDATE `phpqa_games` set `HOF_name` = '', `HOF_score` = '' WHERE `HOF_score` > 0;");
if($goquery1) { 
echo '<script>alert(\'Hall of Fame has been RESET\');</script>'; 
} else { echo '<script>alert(\'Query Failed!\');</script>';; 
echo mysql_error();
}}else {
echo '<script>alert(\'You Must Check the Confirmation Box to Reset HOF Scores!\');</script>';
}}
//END Incompatible Function Block #1
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//Game champion scores reset
if(isset($_POST['CHAMPwipe'])&&$_POST['CHAMPwipe']=='1'){
if(isset($_POST['RESETC'])&&isset($_POST['RESETC'])=='yes'){
vsess();

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Incompatible Function Block #2
$goquery2=run_query("UPDATE `phpqa_games` set `Champion_name` = '', `Champion_score` = '' WHERE `Champion_score` > 0;");
if($goquery2){
sleep(15); 
$goquery3=run_query("TRUNCATE TABLE `phpqa_scores`");
if($goquery3){
sleep(3);
$goquery4=run_query("TRUNCATE TABLE `phpqa_leaderboard`");
if($goquery4){
echo '<script>alert(\'Arcade has been RESET\');</script>';
}}} else { 
echo '<script>alert(\'Query Failed!\');</script>'; 
echo mysql_error();
}}else {
echo '<script>alert(\'You Must Check the Confirmation Box to Reset Arcade Scores!\');</script>';
}}

//Clear-out Shouts reset

if(isset($_POST['dowhat']) && $_POST['dowhat'] == "WipeShout") {
	vsess();
	if(isset($_POST['WipeShouts']) && $_POST['WipeShouts'] == "yes")
	 {
	 $goquery=run_query('TRUNCATE TABLE phpqa_shoutbox;');
	 if($goquery) { echo '<script>alert(\'Shoutbox Cleared!\');</script>'; } else { echo '<script>alert(\'Query Failed!\');</script>';; 
	 echo mysql_error();
}

} else {
echo '<script>alert(\'You Must Check the Confirmation Box to Clear Shouts!\');</script>';
}}
if(isset($_POST['querymysql']) && $_POST['querymysql'] == "Run Query") {
$thequery=$_POST['thequery'];
	vsess();
$goquery=run_query($thequery);
}
echo "<a href='".$phpmyadminloc."' target='_blank' title='phpMyAdmin database access'><img src='".$imgloc."/phpMyAdmin.gif' alt='phpMyAdmin' style='margin-bottom:20px; margin-top:-20px;' /></a>";
?>
<div class='tableborder'><table width='100%' cellpadding='5' cellspacing='1'><tr><td class='headertableblock' align='center' colspan=9><b>Query</b></td></tr><td class='arcade1' align='center'><form action='' method='POST'>
<input type='hidden' name='akey' value='<?php echo $key; ?>'>
<textarea cols=40 rows=2 wrap='OFF' name='thequery'></textarea><br />
<input type='Submit' name='querymysql' value='Run Query'>
<br />
<?php
if(isset($_POST['querymysql'])) {
if($goquery) { echo "Query Executed Successfully"; } else { echo "Query failed."; 
echo mysql_error();
}
//END Incompatible Function Block #2
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

}
?>
</td></table></div><br />
<form action='' method='POST'>
<div class='tableborder'><table width=100% cellpadding='4' cellspacing='1'><td width='60%' align='center' class='headertableblock' colspan='2'>MySQL Database Manager</td>
<?php
$dbs = array('phpqa_accounts','phpqa_cats','phpqa_games','phpqa_leaderboard','phpqa_scores','phpqa_shoutbox');
foreach ($dbs as $k=>$v){
if ($v == 'phpqa_shoutbox'){
echo "<tr><td class='arcade1' align='left'><b>$v</b> &nbsp; Confirm Here to Clear Shouts: <input type='checkbox' name='WipeShouts' value='yes'></td><td class='arcade1' align='left' width='1%'><b><input type='checkbox' name='$v' value='$v'></b></td></tr>";
} else {
echo "<tr><td class='arcade1' align='left'><b>$v</b></td><td class='arcade1' align='left' width='1%'><b><input type='checkbox' name='$v' value='$v'></b></td></tr>";
}}
?>
<tr><td class='arcade1' align='center' colspan='2'><b>Action:</b> <select size="1" name="dowhat">
<option value='optimize'>Optimize</option><option value='repair'>Repair</option><option value='check'>Check</option><option value='dump'>View Dump</option><option value='WipeShout'>Clear Shouts</option></td></tr>
<tr><td class='headertableblock' colspan='2'><div align=center><input type='Submit' name='runsql' value='Run'></div></td></tr>
</table>
</div>
<br />
</form>
<div class='tableborder'>
<table width="100%" cellpadding="5" cellspacing="1"><tr><td class="headertableblock" align="center" colspan=9><b>Scores Reset</b></td></tr><tr><td class="arcade1" align="center"><form action="" method="POST">Confirm Here to perform this action: <input type="checkbox" name="RESETH" value="yes"> &nbsp; <input type="Submit" name="HOF_reset" value="Hall of Fame RESET"><input type="hidden" name="HOFwipe" value="1"></form></td></tr>
<tr><td class="arcade1" align="center"><form action="" method="POST">Confirm Here to perform this action: <input type="checkbox" name="RESETC" value="yes"> &nbsp;  <input type="Submit" name="Champ_reset" value="Arcade Scores RESET"> &nbsp; </td></tr>
<input type="hidden" name="CHAMPwipe" value="1"></form></table>
</div><br />
<div class='tableborder'><table width='100%' cellpadding='5' cellspacing='1'><tr><td class='headertableblock' align='center' colspan=9><b>Full Backup</b></td></tr><td class='arcade1' align='center'><form action='' method='POST'>

<?php
foreach ($dbs as $k=>$v){
echo "<input type='hidden' name='$v' value='a'>";
}
?>
<input type='hidden' name='dowhat' value='dump'><input type='Submit' name='' value='Generate Complete Database Backup'>
</td></table></div><br />
<?php
$dowhat = isset($_POST['dowhat']);
$tablearray = isset($_POST['dbselect']);
print_r($tablearray);
if (isset($_POST['dowhat']) && $_POST['dowhat'] == 'dump'||isset($_GET['dowhat']) && $_GET['dowhat'] =="downloaddump") {
?>
<div class='tableborder'><table width='100%' cellpadding='5' cellspacing='1'><tr><td class='headertableblock' align='center' colspan=9><b>SQL (dump) Backup</b></td></tr><td class='arcade1' align='center'><br />Below is a copy of your arcade table(s) that can be imported onto your hosts PhpMYadmin. To keep this backup, <b>copy</b> the entire text in the area below into a notepad file and save it, or <a href='?cpiarea=mysql&amp;dowhat=downloaddump'>download</a> it.
<?php
echo "<textarea cols=100 rows=50 wrap='OFF'>";
if (isset($_GET['dowhat'])&&$_GET['dowhat']=="downloaddump") {
header("Content-type:text/plain");
header("Content-disposition:attachment;filename=\"phpqa_mysql_dump.sql\"");
ob_clean();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Incompatible Function Block #3
$q=run_query("SHOW TABLES LIKE 'phpqa_%'");
while($s=mysql_fetch_array($q)) $tables[]=$s[0];
foreach($tables as $v){
$q=mysql_fetch_array(run_query("SHOW CREATE TABLE $v"));
echo "\n\n--$v's Table Structure:\n".$q[1]."\n\n";
$q=run_query("SELECT * FROM $v");
echo "--$v's Dump:\n";
while($r=mysql_fetch_assoc($q)) echo "INSERT INTO $v(`".implode("`,`",array_keys($r))."`) VALUES ('".implode("','",$r)."')\n";
}
if (isset($_GET['dowhat'])&&$_GET['dowhat']=="downloaddump") die();
echo "</textarea></td></table></div><br />";
} elseif($dowhat=="optimize") {
foreach ($dbs as $k=>$v){
if (isset($_POST[$v])) {
$optcheck = mysql_fetch_array(run_query("OPTIMIZE TABLE `$v`"));
if ($optcheck) { message("Table <b>$v</b> optimized. Status: $optcheck[Msg_text]"); } else { message("Table <b>$v</b> failed to be optimized. Try repairing it. $optcheck[Msg_text]"); }
}
}
} elseif($dowhat=="repair") {
foreach ($dbs as $k=>$v){
if ($_POST[$v]) {
$optcheck = mysql_fetch_array(run_query("REPAIR TABLE `$v`"));
if ($optcheck) { message("Table <b>$v</b> Repaired. Status: $optcheck[Msg_text]"); } else { message("Table <b>$v</b> failed to be repaired."); }
}
}
} elseif($dowhat=="check") {
foreach ($dbs as $k=>$v){
if ($_POST[$v]) {
$optcheck = mysql_fetch_array(run_query("CHECK TABLE `$v`"));
if ($optcheck) { message("Table <b>$v</b> Checked. Status: $optcheck[Msg_text]"); } else { message("Table <b>$v</b> failed to be checked."); }
}
//END Incompatible Function Block #3
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

}
}
echo "<div class='tableborder'><form action='' method='POST'><table width='100%' cellpadding='5' cellspacing='1'><tr><td class='headertableblock' align='center' colspan=9>Epoch Converter</td></tr><tr><td class='arcade1' align='center'><iframe src='acpi/epoch.php' width='535' height='180' scrollbars='no'></iframe></td></tr></table></div><br />";
} ?>
