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
# Section: OnlineListOption.php  Function: Maintain Online User List   Modified: 2/28/2019   By: MaSoDo

			// = = = = = = = = = = = = = = = = = = 
			// 		Online List
			// = = = = = = = = = = = = = = = = = =
if(isset($_GET['action']) && $_GET['action'] != 'Online') {
$time=time();
if (isset($_COOKIE['phpqa_user_c'])) {
if(isset($_GET['play'])) $w="Playing Game: $g[0]|$g[gameid]";
if(isset($id)) $w="Viewing Highscores: $gameinfo[game]";
if(isset($_GET['cparea'])) $w="Using AdminCP...";
if(isset($_GET['modcparea'])) $w="Using ModCP...";
if(isset($_GET['action']) && $_GET['action'] == "tournaments") $w="Viewing Tournaments";
if(isset($_GET['action']) && $_GET['action'] == "settings") $w="Updating Arcade Profile...";
if(isset($_GET['action']) && $_GET['action'] == "profile") $w="Viewing A Member Profile";
if(isset($_GET['action']) && $_GET['action'] == "leaderboards") $w="Viewing The Leaderboard";
if(isset($_GET['action']) && $_GET['action'] == "members") $w="Viewing The Members List";
$areyouthere=@mysql_fetch_array(run_query("SELECT name FROM phpqa_sessions WHERE name='$phpqa_user_cookie'"));
if(!$areyouthere) {
global $w; 
run_query("INSERT INTO phpqa_sessions (name,time,location) VALUES ('$phpqa_user_cookie','$time','$w')"); 
} else {
global $w; 
$areyouthere=run_query("UPDATE `phpqa_sessions` SET `time` = '$time', `location` = '$w' WHERE name='$phpqa_user_cookie'");
}
}
// End Collapse #4
echo "</div>";
} else { 
echo "</div>";
if(!isset($_GET['id']) && !isset($_GET['cparea']) && !isset($_GET['modcparea']) && !isset($_GET['play'])) $w="Viewing Arcade Index"; }
echo "<div class='tableborder'><table width='100%' cellpadding='4' cellspacing='1'><tr><td class='arcade1' align='left'><fieldset class=\"search\"><legend>Users Online in the Past ".$settings['online_list_dur']." Minutes: (<a href='?action=Online&method=time'>Last Click</a>, <a href='?action=Online&method=name'>Member Name</a>)</legend><br />";
$online=run_query("SELECT * FROM phpqa_sessions ORDER by time DESC");
	while($g=mysql_fetch_array($online)){ 
global $time;
$HowManyMinutes=floor($time/60)-floor($g['time']/60);
echo "</div>";
if($HowManyMinutes > $settings['online_list_dur']) { 
run_query("DELETE FROM phpqa_sessions WHERE name='".$g['name']."'");
} else {
$where=explode("|", $g['location']);
echo "<a href='index.php?action=profile&user=".$g['name']."' title='".$where[0]." (".$HowManyMinutes." mins ago)'>".$g['name']."</a> ";  } 
}
echo "</fieldset></td></tr></table></div><br />";
echo "<div style='text-align:left; margin-bottom: 10px; margin-left:0px;'><input id='Button1' type='button' value='&#8593; Return to Top of Page &#8593;' onclick='anchorlink(\"top\");' style='font-size:16px; font-weight:bold; color:silver;' /></div>";
?>