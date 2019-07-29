<?php
//-----------------------------------------------------------------------------------/
//Practical-Lightning-Arcade [PLA] 2.0 (BETA) based on PHP-Quick-Arcade 3.0 © Jcink.com
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
# Section: ArcadeInfo.php  Function: Latest Site Info Block   Modified: 7/29/2019   By: MaSoDo
?>
<br />
<?php
$anysent = 0;
$MyMess = '';
$alertstyle = '';
$alertlink = '';
$forumnote = '';
if (isset($_COOKIE['phpqa_user_c'])) {
$MyMess = $_COOKIE['phpqa_user_c'];

$checkmessages=run_iquery("SELECT id FROM PLA_users where username = '".$MyMess."'"); 
$checkmess= mysqli_fetch_array($checkmessages);
$checkmess_for = $checkmess['id'];
$anysent=mysqli_num_rows(run_iquery("SELECT status FROM PLA_pun_pm_messages WHERE receiver_id = '".$checkmess_for."' AND status = 'sent'"));
if($anysent > 0){ $AlertMe='yes'; $alertstyle='border:lime dotted;'; $alertlink='color:lime;'; $forumnote=' (<b>PM</b>)'; }
if ($_COOKIE['phpqa_user_c'] == 'Admin') {
$checkOmessages=run_iquery("SELECT id FROM PLA_users where username = '".$adminplayas."'"); 
$checkOmess= mysqli_fetch_array($checkOmessages);
$checkOmess_for = $checkOmess['id'];
$anyOsent=mysqli_num_rows(run_iquery("SELECT status FROM PLA_pun_pm_messages WHERE receiver_id = '".$checkOmess_for."' AND status = 'sent'"));
if($anyOsent > 0){ $AlertMe='yes'; $alertstyle='border:solid orange;'; $alertlink='color:orange;'; $forumnote=' (<b>PM</b> alt)'; }
}
}
?>
<table align="center" width="1200" cellpadding="4" cellspacing="1">
<tr>
<td colspan="3" class="arcade1" align="center">
<?php
if (!isset($_COOKIE['phpqa_user_c'])) {
// begin nav buttons
?>
<div style="width: 100%; text-align: center; margin-left: auto; margin-right: auto;"><a name="Login"></a><div class="navigation">Logged off: [ <a href="javascript:tog('login_form')">Login</a> ]</div><div class="navigation">[ <a href="index.php?action=register#registration">Register</a> ] </div><div class="navigation"><a href="index.php?action=leaderboards">Leaderboard</a></div><div class="navigation"><a href="index.php?action=HOF">Hall of Fame</a></div><div class="navigation"><a href="javascript:tog('search');">Search</a></div><div class="navigation"><a href="index.php?action=members">Members</a></div><div class="navigation"><a href="/FORUM">Forum</a></div>
<div style="display:none" id="login_form" name="tog_collect"><br /><br /><br /><form method="post" action="?action=login"> Name: <input type="text" name="userID" style="font-size: 80%;" /> <font style="font-size: 80%;"></font> Pass: <input type="password" name="pword" style="font-size: 80%;" /> <input type="submit" value="Login" style="font-size: 80%;" /><br /><input type="checkbox" name="cookiescheck" />Remember Login? | <a href="index.php?action=register#registration"><b>Register to play!</b></a><br /><a href="index.php?action=forgotpass"><i>Forgot Password?</i></a></form></div></div>
<?php
} else {

$checkChamps = mysqli_num_rows(run_iquery("SELECT username FROM phpqa_leaderboard WHERE username = '$phpqa_user_cookie'"));
echo "<div style='width: 100%; text-align: center; margin-left: auto; margin-right: auto;'><div  class='navigation'>Logged in: <A href='index.php?action=profile&amp;user=$phpqa_user_cookie'>$phpqa_user_cookie</a> Total Wins: $checkChamps </div><div class='navigation'><a href='index.php?action=settings'>Settings</a>";
if ($exist[6]=="Admin") {
echo " (<a href='index.php?cpiarea=idx'><b>Admin CP</b></a>) &middot; (<a href='index.php?modcparea=idx'><b>Mod CP</b></a>)";
}
if ($exist[6]=="Moderator") {
echo " (<a href='index.php?modcparea=idx'><b>Mod CP</b></a>)";
}
echo"</div><div  class='navigation'>[ <a href='index.php?action=logout'>Log Out</a> ]</div><div  class='navigation'><a href='index.php?fav=1'>Favorites</a></div><div  class='navigation'><a href='index.php?action=leaderboards'>Leaderboard</a></div><div  class='navigation'><a href='index.php?action=HOF'>Hall of Fame</a></div><div  class='navigation'><a href='javascript:tog(\"search\")'>Search</a></div><div  class='navigation'><a href='index.php?action=members'>Members</a></div><div  class='navigation' style='".$alertstyle."' ><a href='/FORUM' style='".$alertlink."'>Forum$forumnote</a></div></div>";
}
// end nav buttons
?>
</td>
</tr></table>
<div style="display:none; width:250px; margin-left:auto; margin-right:auto;" class='tableborder' id="search" name="tog_collect"><br />Search The Arcade<br /><br /><form method="get">Term: <input type="text" name="search" value="" /><br />Search By: <select name="by"><?php foreach(Array('game'=>'Game Name','gameid'=>'Game ID','about'=>'Game desc','Champion_name'=>'Champion Name') as $k=>$v) echo "<option value='$k'>$v</option>";?></select><br />In Category: <select size="1" name="searchcat"><option value='All' selected="selected">All</option><?php 

$catquery=run_iquery("SELECT * FROM phpqa_cats ORDER BY displayorder");while ($catlist= mysqli_fetch_array($catquery)) echo  "<option value='$catlist[0]'>$catlist[1]</option>"; 
?></select><br /><input type="submit" value="search" name="action" /></form></div>
<div align="center">
<?php // Begin Collapse #1 
if (isset($settings["show_stats_table"])&&$settings["show_stats_table"]=='1') { 
echo "<div style='text-align:center; margin-bottom: 5px; margin-top: 5px;'><a title='Open/Close Arcade Site Info - News Section'><image id='btn1' src='$imgloc/$collimg1' onclick='return CollapseExpand1()' style='font-size:16px; font-weight:bold; color:silver;' /></a></div><div id='MyDiv1' class='" . $collapset1 . "'>";
}
?>
<div class="tableborder">
<?php 
if (isset($settings["show_stats_table"])&&$settings["show_stats_table"]=='1') { 
if (!isset($acct_setting[3]) || $acct_setting[3] !="No") {
if (isset($settings["enable_logo"])&&$settings["enable_logo"]==1){
echo "<table width='100%' cellpadding='4' cellspacing='1'><tr><td width='100%' align='center' class='headertableblock'>".$arcgreet."</td></tr></table>";
}
$settings['ng_num']!=''?$ngnum = $settings['ng_num']:$ngnum = 20;
$settings['ls_num']!=''?$lsnum = $settings['ls_num']:$lsnum = 14;
$settings['bp_num']!=''?$bpnum = $settings['bp_num']:$bpnum = 10;
?>
<table width="100%" cellpadding="4" cellspacing="1">
<tr><a name="logtop"></a>
<td width="16%" align="center" class="headertableblock">Newest Games</td>
<td width="50%" align="center" class="headertableblock">Latest Scores</td>
<td width="16%" align="center" class="headertableblock">Bestest Players</td>
<td width="16%" align="center" class="headertableblock">Hottest Games</td>
<?php 
} else {
echo "<td width='10%' align='center' class='headertableblock'>".$arcgreet." <br />(Enable \"Arcade Header\" in your settings for latest news!)</td>";
}
}else {
echo "<td width='10%' align='center' class='headertableblock'>".$arcgreet."</td>";
}
?>
</tr>

<tr>
<?php
if (!isset($_GET['pplay'])) {
if (isset($settings["show_stats_table"])&&$settings["show_stats_table"]=='1') { 
if (!isset($acct_setting[3]) || $acct_setting[3] !="No") {
?>
<td class="arcade1" valign="top" align="left">

<?php

$newgames = run_iquery("SELECT gameid,game,id,gamecat FROM phpqa_games ORDER by id DESC LIMIT 0,$ngnum");
	while($g=mysqli_fetch_array($newgames)){ 
	if (($g[3] != '23')&&($g[3] != '2')){
	
echo "<img height='20' width='20' src='arcade/pics/$g[0].gif' alt='$g[1]' /><a href=\"index.php?play=$g[0]#playzone\">$g[1]</a><br />";
}}
?>
</td>
<td class="arcade1" valign="top" align="center">

<table><td align="left">
<?php

	$selectfrom = run_iquery("SELECT * FROM phpqa_scores ORDER BY phpdate DESC LIMIT 0,$lsnum");
	while($s=mysqli_fetch_array($selectfrom)){ 
  $VstatG = "";
  $bigname = "";
  $bigtag = "";
  $gameinfo = run_iquery("SELECT Champion_name,Champion_score FROM phpqa_games WHERE gameid = '$s[6]'");
  $g=mysqli_fetch_array($gameinfo);
    if ($s[2]==$g[1]) {
        $VstatG = "<img src='$imgloc/rd_star.gif' height='10' width='10' alt='*' /><b>";
        $bigname = "Y";
        $bigtag = "</b>";
} else {$VstatG = "<div style='display:inline-block;width:10px;height:10px;'></div>";}
$thisGuy = $s[1];
$findGroup = run_iquery("SELECT `group` FROM phpqa_accounts WHERE name = '".$thisGuy."'");
$thisGroup = mysqli_fetch_array($findGroup);
//$parse_stamp = gmdate($datestamp, $s[5]+3600*$settings['timezone']);
$parse_stamp = date($datestamp, $s[5]);
echo "$VstatG<a href='index.php?action=profile&amp;user=".$s[1]."' class='".$thisGroup[0]."Look'>".$s[1]."</a>" . $bigtag . " scored <i>" . str_replace('-', '', $s[2]) . "</i> in <a href='index.php?id=".$s[6]."#playzone'><i>$s[7]</i></a> on ".$parse_stamp."<hr>";
}
?>
</td></table>
</td>
<td class="arcade1" valign="top" nowrap="nowrap" align="left">

<?php

$scoreboard = run_iquery("SELECT phpqa_accounts.name,phpqa_accounts.avatar,phpqa_accounts.group, COUNT(phpqa_leaderboard.username) AS champions FROM phpqa_accounts
LEFT JOIN phpqa_leaderboard ON phpqa_accounts.name = phpqa_leaderboard.username
GROUP BY phpqa_leaderboard.username
ORDER BY champions DESC LIMIT 0,".$bpnum."");
$scoresC=mysqli_fetch_array($scoreboard);
if (!$scoresC['avatar'])$scoresC['avatar']=$avatarloc.'/man.gif';
echo "<div><table width='100%' cellpadding='5' cellspacing='1'>";
echo "<tr><td width='100%' align=center class='headertableblock' style='font-size:14px'>Arcade Champion</td></tr>";
echo "<tr><td class='arcade1'><div style='font-size:12px; color: gold; padding:3px; background-color:navy;' align='center'>with <b>".$scoresC['champions']."</b> wins!</div><div align='center' style='font-size:20px'><i><a href=\"index.php?action=profile&amp;user=".$scoresC['name']."\"><img src='".$scoresC['avatar']."' height='75px' /><br /><img alt='image' src='$crowndir/crown1.gif' /><span class='".$scoresC['group']."Look'>".$scoresC['name']."</span><img alt='image' src='$crowndir/crown1.gif' /></a></i></div><hr /></td></tr>";
echo "</table><div style='position:absolute;display:none;margin-top:-100px;margin-left:-110px;' id='champboxpopup'><img /></div></div>";
$trop = 1;
while($scores=mysqli_fetch_array($scoreboard)){
$trophy = '';
$trop = $trop + 1;
if ($trop == 2) { $trophy = "<img src='$crowndir/crown2.gif' />"; }
if ($trop == 3) { $trophy = "<img src='$crowndir/crown3.gif' />"; }
if ($scores['avatar'] == ''){ $scores['avatar'] = $avatarloc.'/man.gif'; }
echo"<span style='font-size: 14px; line-height:175%'>&nbsp;<a href='index.php?action=profile&amp;user=" . $scores['name'] . "' onmouseover=\"s=document.getElementById('champboxpopup');s.style.display='';s.getElementsByTagName('img')[0].src='" . $scores['avatar'] . "';\" onmousemove=\"s=document.getElementById('champboxpopup').style;s.top=document.body.scrollTop+2+event.clientY;s.left=document.body.scrollLeft+event.clientX;\" onmouseout=\"document.getElementById('champboxpopup').style.display='none'\"  class='".$scores['group']."Look'><i>" . $scores['name'] . "</i></a>&nbsp;</span>(<b>" . $scores['champions'] . "</b> Wins) &nbsp;" . $trophy . " <br /><hr />";
}
?>
</td>
<td class="arcade1" valign="top" align="left">

<?php

$hotgames = run_iquery("SELECT gameid,game,id,gamecat,times_played FROM phpqa_games ORDER by times_played DESC LIMIT 0,$ngnum");
	while($hg=mysqli_fetch_array($hotgames)){ 
	if ($hg[3] != '2') {
echo "<img height='20' width='20' src='arcade/pics/$hg[0].gif' alt='$hg[1]' style='margin-left:5px;' /><a href=\"index.php?play=$hg[0]#playzone\">$hg[1]</a> (".$hg['times_played'].")<br />";
}}
}// End acct based check for big table
} // End check for big table
} // end play check
?>

</td>

</tr></table>
</div>
<?php // End Collapse #1 
if (isset($settings["show_stats_table"])&&$settings["show_stats_table"]=='1') { 
echo "</div>";
}
?>
