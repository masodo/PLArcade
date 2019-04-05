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
# Section: NavShout.php  Function: Cookie-Crumb Trail Navigation   Modified: 4/5/2019   By: MaSoDo
?>
<div class='tableborder'><table width='100%' cellpadding='4' cellspacing='1'><tr><td class='arcade1' align='left'>
<?php
echo "<div class='navigation'><a href='index.php'>Arcade Home</a></div> &#187; ";
if (isset($_GET['play'])) { // Ok, you are playing.
echo "<b>Playing Game.</b>";
} elseif (isset($_GET['id'])) { // Now you're viewing the highscores
echo "<b>Viewing Highscore Tables.</b>";
} elseif (isset($_GET['action']) && $_GET['action'] == "register") { 
echo "<b>Registering!</b>";
} elseif (isset($_GET['action']) && $_GET['action'] == "members") {
echo "<b>Viewing Member List</b>";
} elseif (isset($_GET['action']) && $_GET['action'] == "leaderboards") { // At the leaderboards
echo "<b>Viewing Leaders</b>";
} elseif (isset($_GET['action']) && $_GET['action'] == "HOF") { // At the HOF boards
echo "<b>Viewing Hall of Fame</b>";
} elseif (isset($_GET['cparea'])||isset($_GET['cpiarea'])) {
$cparea_info='';
$cparea_info['tar_import']="*.tar import new FL games";
$cparea_info['tar_importH5']="*.tar import new H5 games";
$cparea_info['addgames']="Add new games";
$cparea_info['idx']="Index";
$cparea_info['cats']="Categories";
$cparea_info['emotes']="Emoticons";
$cparea_info['mysql']="MySQL Toolbox";
$cparea_info['members']="Member Manager";
$cparea_info['bannedIPlist']="banned IP list";
$cparea_info['settings']="Settings";
$cparea_info['games']="Games Manager";
$cparea_info['Email']="Post Office";
$cparea_info['filter']="Word Filters";
$cparea_info['skin']="Skin Control";
$cparea_info['snapshot']="Champion SnapShot";
$cparea_info['affiliates']="Affiliates Manager";
if(isset($_GET['cpiarea'])) {
$_GET['cpiarea']=htmlspecialchars($_GET['cpiarea']);
echo "<div class='navigation'><a href='index.php?cpiarea=idx'>Arcade AdminCP</a></div> &#187; <b><a href='index.php?cpiarea=".$_GET['cpiarea']."'>{$cparea_info[$_GET['cpiarea']]}</a></b>";
}
} elseif (isset($_GET['action']) && $_GET['action'] == 'profile' ) {
echo "<b>Viewing Member Profile</b>";
} else {// Ok. You seem to be in arcade index then.
?>
<?php
if(isset($_GET['shoutbox'])) $limit=0;
if(isset($_GET['shoutbox'])) $show=$num_pages_of;
// Favorite games
// Yep, that's all there is to it.
//Game List Display Logic:
$fav_quer='';
if(isset($_GET['fav'])){
$favs=$acct_setting[5];
$buildfavs=explode(",", $favs);
foreach($buildfavs as $k=>$v) {
$v=htmlspecialchars($v, ENT_QUOTES);
$favslist.="'$v', ";
}
$favslist = substr($favslist, 0, -2);    
$fav_quer="WHERE gameid IN($favslist)";
}
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
$catquer = run_query("(SELECT * FROM phpqa_games ORDER BY rand() LIMIT 1) UNION ALL (SELECT * FROM phpqa_games WHERE ".$_GET['by']." LIKE '%".$_GET['search']."%' ORDER BY id DESC)", 1);
} 
if (!isset($_GET['action'])||isset($_GET['action'])&&$_GET['action']!="search") {
//below added for testing M*S*D
//echo "<script>alert('Not Search: ".$_GET['action']."');</script>";
$catquer = run_query("(SELECT * FROM phpqa_games ORDER BY rand() LIMIT 1) UNION ALL (SELECT * FROM phpqa_games ".$fav_quer."".
(isset($_GET['cat'])?"WHERE gamecat='".$_GET['cat']."' ":"").
(isset($_GET['plat'])?"WHERE platform='".$_GET['plat']."' ":"").
"ORDER BY id DESC LIMIT ".$limit.",".$show.")", 1);
}
$arcadetotalcat = mysql_num_rows($countquer);
$f = @mysql_fetch_array($catquer);
////////Game List Display Logic
echo "<b>Viewing Arcade Index</b></td><td class='arcade1' style='width:1px'><a href='?play=" . $f['gameid'] . "'>Random&nbsp;Game</a>";
}
echo "</td></tr></table></div><div align='center'>";
?>
<br />
