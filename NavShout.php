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
# Section: NavShout.php  Function: Cookie-Crumb Trail Navigation   Modified: 7/1/2019   By: MaSoDo
?>
<div class='tableborder'><table width='100%' cellpadding='4' cellspacing='1'><tr><td class='arcade1' align='left'>
<?php
echo "<div class='navigation'><a name='registration'></a><a href='index.php'>Arcade Home</a></div>";
if (isset($_GET['play'])) { // Ok, you are playing.
echo "<div class='navigation'>&#187; <b>Playing Game.</b></div>";
} elseif (isset($_GET['id'])) { // Now you're viewing the highscores
echo "<div class='navigation'>&#187; <b>Viewing Highscore Tables.</b></div>";
} elseif (isset($_GET['action']) && $_GET['action'] == "register") { 
echo "<div class='navigation'>&#187; <b>Registering!</b></div>";
} elseif (isset($_GET['action']) && $_GET['action'] == "members") {
echo "<div class='navigation'>&#187; <b>Viewing Member List</b></div>";
} elseif (isset($_GET['action']) && $_GET['action'] == "leaderboards") { // At the leaderboards
echo "<div class='navigation'>&#187; <b>Viewing Leaders</b></div>";
} elseif (isset($_GET['action']) && $_GET['action'] == "HOF") { // At the HOF boards
echo "<div class='navigation'>&#187; <b>Viewing Hall of Fame</b></div>";
} elseif (isset($_GET['cparea'])||isset($_GET['cpiarea'])) {
$cparea_info='';
$cparea_info['tar_import']="*.tar import new FL games";
$cparea_info['tar_importH5']="*.tar import new H5 games";
$cparea_info['addgames']="Add new games";
$cparea_info['idx']="Index";
$cparea_info['cats']="Categories";
$cparea_info['emotes']="Emoticons";
$cparea_info['mysql']="MySQL Toolbox";
$cparea_info['JSbeauty']="JavaScript Beautify";

$cparea_info['members']="Member Manager";
$cparea_info['bannedIPlist']="banned IP list";
$cparea_info['settings']="Settings";
$cparea_info['games']="Games Manager";
$cparea_info['Email']="Post Office";
$cparea_info['filter']="Word Filters";
$cparea_info['skin']="Skin Control";
$cparea_info['editor']="Skin Editor";
$cparea_info['snapshot']="Champion SnapShot";
$cparea_info['affiliates']="Affiliates Manager";
if(isset($_GET['cpiarea'])) {
$_GET['cpiarea']=htmlspecialchars($_GET['cpiarea']);
echo "<div class='navigation'><a href='index.php?cpiarea=idx'>Arcade AdminCP</a></div> <div class='navigation'>&#187; <b><a href='index.php?cpiarea=".$_GET['cpiarea']."'>{$cparea_info[$_GET['cpiarea']]}</a></b></div>";
}
} elseif (isset($_GET['action']) && $_GET['action'] == 'profile' ) {
echo "<div class='navigation'> &#187; <b>Viewing Member Profile</b></div>";
} else {// Ok. You seem to be in arcade index then.
?>
<?php
// Favorite games
// Yep, that's all there is to it.
//Game List Display Logic:
$fav_quer='';
if(isset($_GET['fav'])){
global $acct_setting;
if(!isset($acct_setting[5])){
echo "<script>alert('You have no saved favorites!');</script>";
} else {
$favs=$acct_setting[5];
$buildfavs=explode(",", $favs);
foreach($buildfavs as $k=>$v) {
$v=htmlspecialchars($v, ENT_QUOTES);
$favslist.="'$v', ";
}
$favslist = substr($favslist, 0, -2);    
$fav_quer="WHERE gameid IN($favslist)";
}}
$countquer = run_query("SELECT gamecat FROM phpqa_games ".$fav_quer."".(isset($_GET['cat'])?" WHERE gamecat='".$_GET['cat']."'":""));

    // Patch - 06/01/09
if(isset($_GET['search'])){
	$_GET['search']=htmlspecialchars($_GET['search'], ENT_QUOTES);
}

if(isset($_GET['searchcat']) && $_GET['searchcat'] != 'All' ){
	$_GET['searchcat']=intval($_GET['searchcat']);
}

//#####Not sure why this was patched?//
    // Patch - 04/20/2009
//if(isset($_GET['by']) || isset($_GET['by']) && $_GET['by'] == '') {
//echo "<script>alert('BY= \'".$_GET['by']."\'');</script>";
//if($_GET['by'] != 'game' || $_GET['by'] !='gameid' || $_GET['by'] !='about' || 
//$_GET['by'] !='Champion_name' || $_GET['by']=='') { 
//$_GET['by']='game';
//}
//}
if (isset($_GET['action'])&&$_GET['action']=="search") {
//below added for testing M*S*D
////echo "<script>alert('Finding: WHERE ".$_GET['by']." LIKE \'%".$_GET['search']."%\'');</script>";
$catquer = run_query("(SELECT * FROM phpqa_games ORDER BY rand() LIMIT 1) UNION ALL (SELECT * FROM `phpqa_games` WHERE ".$_GET['by']." LIKE '%".$_GET['search']."%' ORDER BY `id` DESC)", 1);
} 
if (!isset($_GET['action'])||isset($_GET['action'])&&$_GET['action']!="search") {
//below added for testing M*S*D
//echo "<script>alert('Not Search: ".$_GET['action']."');</script>";
global $SortOrd, $SortDir;
$catquer = run_query("(SELECT * FROM phpqa_games ORDER BY rand() LIMIT 1) UNION ALL (SELECT * FROM phpqa_games ".$fav_quer."".
(isset($_GET['cat'])?"WHERE gamecat='".$_GET['cat']."' ":"").
(isset($_GET['plat'])?"WHERE platform='".$_GET['plat']."' ":"").
"ORDER BY `".$SortOrd."` ".$SortDir." LIMIT ".$limit.",".$show.")", 1);
}
$arcadetotalcat = mysql_num_rows($countquer);
$f = @mysql_fetch_array($catquer);
$playrandg = '';
$findNG = '';
if (($f['gamecat'] != 2)&&($f['gamecat'] != 2)){
$playrang = $f['gameid'];
} else { 
$findNG = run_query("SELECT `gameid` FROM phpqa_games WHERE `gamecat` != '2' AND `gamecat` != '23' ORDER by id DESC LIMIT 0,1");
$FNG = mysql_fetch_array($findNG);
$playrang = $FNG[0];
}

////////Game List Display Logic
if(isset($settings['enable_24hr'])&&$settings['enable_24hr']==1){
echo "<div class='navigation'> &#187; <b>Viewing Arcade Index</b></div> <div style='width:300px; float:right; margin-right:50px; text-align: right;'>Arcade Time: <b>" . date('G:i') ."</b><br />Local Time: <script>nowtime(24)</script></div></td><td class='arcade1' style='width:1px'><div class='navigation'><a href='?play=" . $playrang . "#playzone'><b>Random&nbsp;Game</b></a></div>";
} else {
echo "<div class='navigation'> &#187; <b>Viewing Arcade Index</b></div> <div style='width:300px; float:right; margin-right:50px; text-align: right;'>Arcade Time: <b>" . date('g:i A') ."</b><br />Local Time: <script>nowtime()</script></div></td><td class='arcade1' style='width:1px'><div class='navigation'><a href='?play=" . $playrang . "#playzone'><b>Random&nbsp;Game</b></a></div>";
}}
echo "</td></tr></table></div><div align='center'>";
?>
<br />
