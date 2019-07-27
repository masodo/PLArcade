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
# Section: OnlineListOption.php  Function: Maintain Online User List   Modified: 7/27/2019   By: MaSoDo

			// = = = = = = = = = = = = = = = = = = 
			// 		Online List
			// = = = = = = = = = = = = = = = = = =
$time=time();
if (isset($_COOKIE['phpqa_user_c'])) {
if(isset($_GET['play'])) $w="Playing Game: ".$g['game']."";
if(isset($_GET['id'])) $w="Viewing Highscores: ".$gameinfo['game']."";
if(isset($_GET['cparea'])) $w="Using AdminCP...";
if(isset($_GET['modcparea'])) $w="Using ModCP...";
if(isset($_GET['action']) && $_GET['action'] != 'Online') {
if(isset($_GET['action']) && $_GET['action'] == "tournaments") $w="Viewing Tournaments";
if(isset($_GET['action']) && $_GET['action'] == "settings") $w="Updating Arcade Profile...";
if(isset($_GET['action']) && $_GET['action'] == "profile") $w="Viewing A Member Profile";
if(isset($_GET['action']) && $_GET['action'] == "leaderboards") $w="Viewing The Leaderboard";
if(isset($_GET['action']) && $_GET['action'] == "members") $w="Viewing The Members List";
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//UpdatedFunction Block #1
$areyouthere=@mysqli_fetch_array(run_iquery("SELECT name FROM phpqa_sessions WHERE name='".$phpqa_user_cookie."'"));
if(!$areyouthere) {
global $w; 
run_iquery("INSERT INTO phpqa_sessions (name,time,location) VALUES ('$phpqa_user_cookie','$time','$w')"); 
} else {
global $w; 
$areyouthere=run_iquery("UPDATE `phpqa_sessions` SET `time` = '$time', `location` = '$w' WHERE name='$phpqa_user_cookie'");
}
//END UpdatedFunction Block #1
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// End Collapse #4
echo "</div>";
} else { 
echo "</div>";
}
if(!isset($_GET['id']) && !isset($_GET['cparea']) && !isset($_GET['modcparea']) && !isset($_GET['play'])) $w="Viewing Arcade Index"; 
echo "<div class='tableborder'><table width='100%' cellpadding='4' cellspacing='1'><tr><td class='arcade1' align='left'><fieldset class=\"search\"><legend>Users Online in the Past ".$settings['online_list_dur']." Minutes: (<a href='./index.php?action=Online&method=time' target='_top'>Last Click</a>, <a href='./index.php?action=Online&method=name' target='_top'>Member Name</a>) <span class='adminLook'>Administrator</span>  <span class='moderatorLook'>Moderator</span>  <span class='memberLook'>Member</span>  <span class='affiliateLook'>Affiliate</span> </legend><br />";

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//UpdatedFunction Block #2
$online=run_iquery("SELECT * FROM phpqa_sessions ORDER by time DESC");
	while($g=mysqli_fetch_array($online)){ 
	$onnow = run_iquery("SELECT `group` FROM `phpqa_accounts` WHERE `name` = '" . $g['name'] . "'");
        $onnowGrp=mysqli_fetch_array($onnow);
$time = time();
$lasttime = ($g['time']);
$HowManyMinutes=round(abs($lasttime-$time) / 60,2);
echo "</div>";
if($HowManyMinutes > $settings['online_list_dur']) { 
run_iquery("DELETE FROM phpqa_sessions WHERE name='".$g['name']."'");
//END UpdatedFunction Block #2
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

} else {
$where=($g['location']);
if ($where=='')$where="Viewing Arcade Index";
echo "<a href='index.php?action=profile&user=".$g['name']."' title='".$where." (".$HowManyMinutes." mins ago)' class='".$onnowGrp['group']."Look'>".$g['name']."</a> ";  } 
}
echo "</fieldset></td></tr></table></div><br />";
echo "<div style='text-align:left; margin-bottom: 10px; margin-left:0px;'><input id='Button1' type='button' value='&#8593; Return to Top of Page &#8593;' onclick='anchorlink(\"top\");' style='font-size:16px; font-weight:bold; color:silver;' /></div>";
?>
