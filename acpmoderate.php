<?php
//-----------------------------------------------------------------------------------/
//Practical-Lightning-Arcade [PLA] 1.0 (BETA) based on PHP-Quick-Arcade 3.0 © Jcink.com
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
# Section: acpmoderate.php  Function: Moderator Control Panel   Modified: 3/11/2019   By: MaSoDo
if(isset($_REQUEST['modcpcheck'])) {
echo "<script type='text/javascript'>alert('Die Request')</script>"; 
die();
}
if(isset($_COOKIE['modcpcheck'])) {
echo "<script type='text/javascript'>alert('Die Cookie')</script>"; 
die();
}
if($modcpcheck !="ok") die("You cannot access this area directly.");
if(isset($_GET['shoutdel'])) { if(!is_numeric($_GET['shoutdel'])) die(); }
if(isset($_POST['score_m'])) {
global $score_m;
$score_m = $_POST['score_m'];
}
if(isset($_GET['shoutdel'])) {
$shoutnumber = $_GET['shoutdel'];
if(is_numeric($shoutnumber)) {
vsess();
run_query("DELETE FROM `phpqa_shoutbox` WHERE `id` = '".$shoutnumber."'");
}
}
if (isset($_POST['dowhat_m'])&&$_POST['dowhat_m']=='comment') {
global $score_m;
for($x=0;$x<=count($score_m)-1;$x++){
if(!is_numeric($score_m[$x])) die();
vsess();
run_query("UPDATE `phpqa_scores` SET `comment` = '' WHERE id='".$score_m[$x]."'");
}
}
if (isset($_POST['dowhat_m'])&&$_POST['dowhat_m']=='erase') {
global $score_m;
vsess();
for($x=0;$x<=count($score_m)-1;$x++){
if(!is_numeric($score_m[$x])) die();
$id = htmlspecialchars($_GET['id'], ENT_QUOTES);
// Is this person a champ?
$whoischamp = mysql_fetch_array(run_query("SELECT `Champion_name`,`Champion_score` FROM `phpqa_games` WHERE `gameid` = '".$id."'"));
$score_being_deleted = mysql_fetch_array(run_query("SELECT `username`,`thescore` FROM `phpqa_scores` WHERE `id` = '".$score_m[$x]."'"));
	// Erase them from the scoreboards, the games, and leaderboard for this game 	if thats true.
	if($whoischamp['Champion_name'] == $score_being_deleted['username'] && $whoischamp['Champion_score'] == $score_being_deleted['thescore']) {
	$yeahchamphappened='yes';
global $id;
	run_query("DELETE FROM `phpqa_leaderboard` WHERE `gamename` = '".$id."'");
	run_query("UPDATE `phpqa_games` SET `Champion_name` = '',`Champion_score` = '' WHERE gameid='".$id."'");
	}
	run_query("DELETE FROM `phpqa_scores` WHERE `id` = '".$score_m[$x]."'");
	}
	// If a person who was a champion was erased... when all erasing is finished, see who is the champ or even if there is one.
	if(isset($yeahchamphappened) == "yes") {
	$whoisitnow = mysql_fetch_array(run_query("SELECT `username`,`thescore` FROM `phpqa_scores` WHERE `gameidname` = '".$id."' ORDER by `thescore` DESC"));
if($whoisitnow[0] != "") {
global $id;
	run_query("UPDATE `phpqa_games` SET `Champion_name` = '".$whoisitnow[0]."' WHERE `gameid`='".$id."'");
	run_query("UPDATE `phpqa_games` SET `Champion_score` = '".$whoisitnow[1]."' WHERE `gameid`='".$id."'");
run_query("INSERT INTO `phpqa_leaderboard` (`username`, `thescore`,`gamename`) VALUES ('".$whoisitnow[0]."', '".$whoisitnow[1]."','".$id."');");
}
}
}
if(isset($_GET['modcparea'])) {
// =================================== \\
// 		Visuals
// ==================================== \\
message("Welcome to the Moderators CP, <b>".$phpqa_user_cookie."</b>.");
echo "<div align='center'><div class='tableborder'><table width=100%% cellpadding='4' cellspacing='1'><td width='60%' align=center class=headertableblock>Options</td><tr><td class=arcade1 valign='top'><div align='left'> » <a href='?modcparea=find'>Lookup Tools</a> <br /> » <a href='?modcparea=IPscan'>IP Scanner/WHOIS</a><br /></div></td></table></div><br>";
?>
<?php
if(isset($_GET['modcparea'])&&$_GET['modcparea']=="find") {
?>
<div class='tableborder'><table width=100% cellpadding='4' cellspacing='1'><tr><td width=30% align=center class=headertableblock>Look up</td></tr><tr><td class='arcade1' align='center'>
Lookup tool searches the scores tables in the database. Find all scores, and comments, by an IP address, or by a member.<br />
<form action='' method='POST'>
<input type='hidden' name='akey' value='<?php echo $key; ?>'>
Search for: <input type='text' name='tool'><br />
					Search By: <select name="choice">
					<option value="ip">IP Address</option>
					<option value="username">User Name</option>
					<option value="thescore">Score</option>
					<option value="comment">Comment</option>
					</select>
<input type='submit' name='' value='Look Up'>
</form>
</td></table></div><br />
<?php
$choice = htmlspecialchars(isset($_POST['choice']), ENT_QUOTES);
$choice = str_replace(" ", "___", $choice);
$tool=htmlspecialchars(isset($_POST['tool']), ENT_QUOTES);
if(isset($_POST['tool'])) {
$selectfrom=run_query("SELECT * FROM phpqa_scores WHERE ".$choice."='".$tool."' ORDER BY phpdate DESC");
	while($g=mysql_fetch_array($selectfrom)){ 
$parse_stamp = date($datestamp, "".$g[5]."");
echo "<div class='tableborder'><table width='100%' cellpadding='5' cellspacing='1' class='highscore'><tr><td width='2%' class='headertableblock' align='center'>Username</td><td width='15%' class='headertableblock' align='center'>Score</td><td width='30%' class='headertableblock' align='center'>Comments</td><td width='30%' class='headertableblock' align='center'>Time &amp; Date</td><td width='20%' class='headertableblock' align='center'>IP Address</td><td width='10%' class='headertableblock' align='center'>ScoreBoard</td>";
echo "<tr><td class='arcade1' align='center'><a href='index.php?action=profile&amp;user=".$g[1]."'>".$g[1]."</a></td><td class='arcade1' align='center'>".$g[2]."</td><td class='arcade1' width='40%' align='center'>".$g['comment']."</td><td class='arcade1' width='20%' align='center'>".$parse_stamp."</td>";
echo "<td width='20%' class='arcade1' align='center'><a href='?modcparea=IPscan&serv=".$g[3]."'>".$g[3]."</a></td><td width='20%' class='arcade1' align='center'><a href='index.php?id=".$g['gameidname']."'>".$g['gameidname']."</a></td>";
echo "</tr>";
echo "</table></div><br /></form>";
}
}
}
if($_GET['modcparea']=="IPscan") {
?>
<div align='center'><div class='tableborder'><table width=100%% cellpadding='5' cellspacing='1'><tr><td class=headertableblock colspan=9><b><font size=-5>IP Scan</font></b></td></tr><td class=arcade1 align=left>
<?php
if (isset($_GET['serv'])) {
$serv=htmlspecialchars($_GET['serv'], ENT_QUOTES);
echo "IP Scan on ( <b>".$serv."</b> )<br><br>";echo "Scanning...<br><br>";
$host = @gethostbyaddr($serv);
echo "Scanned IP Host Information: <b>".$host."</b><br><br>";
echo "<form action=http://ws.arin.net/cgi-bin/whois.pl method=post><input type=hidden size=33 maxlength=55 name=queryinput value='".$serv."'><br><input type=submit value='WHOIS'></form>";
}
?>
<form action='' method='GET'>
<input type='hidden' name='akey' value='<?php echo $key; ?>'>
<input type=hidden name=modcparea value=IPscan><input type=text name=serv><input type=submit value=Scan></form>
<br></div></td></table></div><br />
<?php
}
?>
<div class='tableborder'><table width=100% cellpadding='4' cellspacing='1'><tr><td width=30% align=center class=headertableblock>Banned IP addresses</td></tr><tr><td class='arcade1' align='center'>Ban one IP below per line. You can also range ban by only putting part of the IP, e.g. 123.45.67.89 -> 123.45
<?php
if (isset($_POST['editban'])) {
	vsess();
$ArcadeCSSOpen = fopen("./".$textloc."/banned.txt","w");
fputs($ArcadeCSSOpen,htmlspecialchars($_POST['cssforarcade'], ENT_QUOTES));
}
?>
 	<form method=post action="?modcparea=idx">
	<input type='hidden' name='akey' value='<?php echo $key; ?>'>
<textarea rows="5" cols="60" name="cssforarcade">
<?php
// Implode CSS
print (implode("",file("./".$textloc."/banned.txt")));
?>
</textarea><br /><input type="submit" value="Edit Banned IPs" name="editban">
	</form></td></tr></table></div><br />
<?php
}
?>
