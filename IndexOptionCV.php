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
# Section: IndexOption.php  Function: Display Games Index   Modified: 7/26/2019   By: MaSoDo

	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	//		  Favorites
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
if (isset($_GET['action']) && $_GET['action'] == "fav") {
vsess();
$_GET['game'] = htmlspecialchars($_GET['game'], ENT_QUOTES);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Incompatible Function Block #1
$game_exist=mysql_fetch_array(run_query("SELECT `id` FROM phpqa_games WHERE gameid='{$_GET['game']}'"));
if($game_exist[0]) {
//Adding?
if(isset($_GET['favtype']) && $_GET['favtype'] == "add") { 
global $acct_setting;
message("Added to favorites. Refresh to see changes.");
$acct_setting[5].="{$_GET['game']},"; 
} else { 
global $acct_setting;
// Removing
message("Removed game from favorites. Refresh to see changes.");
$acct_setting[5]=str_replace("{$_GET['game']},", "", $acct_setting[5]); 
}
run_query("UPDATE `phpqa_accounts` SET `settings` = '$acct_setting[0]|$acct_setting[1]|$acct_setting[2]|$acct_setting[3]|$acct_setting[4]|$acct_setting[5]' WHERE name='$phpqa_user_cookie'");
} else {
message("Game not found.");
}
}
//END Incompatible Function Block #1
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	//		  Game index display
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
global $catquer;
if (!isset($_GET['action'])&&!isset($_GET['do'])||isset($_GET['action'])&&$_GET['action']!='settings') {
if (!empty($catquer)) {
//Begin Collapse #4
echo "<div style='text-align:center; margin-bottom: 5px; margin-top: 5px;'><a title='Open/Close The Games Index'><img id='btn4' src='" . $imgloc . "/" . $collimg4 . "' type='button' alt='&#8595; Games: Collapse/Expand &#8595;' onclick='return CollapseExpand4()' style='font-size:16px; font-weight:bold; color:silver;' /></a></div><div id='MyDiv4' class='" . $collapset4 . "'>";
require "./PageMakerT.php";
	while($g=mysql_fetch_array($catquer)){ 
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Incompatible Function Block #2
	$CHMP = run_query("SELECT `avatar`,`group` FROM `phpqa_accounts` WHERE `name` = '" . $g['Champion_name'] . "'");
        $CHMPimg=mysql_fetch_array($CHMP);
	// Select from the scores table....
$CheckScoring = $g['scoring'];
$showcat=mysql_fetch_array(run_query("SELECT cat FROM phpqa_cats WHERE id='{$g['gamecat']}'"));	
//END Incompatible Function Block #2
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if ($g['gamecat'] != '2' || (isset($exist[6])&&$exist[6] == "Admin")) {

if ($g['platform'] == 'H5') { 
echo "<div class='tableborder'><table width='100%' cellpadding='4' cellspacing='1' class='gameview'><tr><td width='5%' align='center' class='headertableblock'></td><td width='60%' align='center' class='headertableblock'>$g[1]</td>";
if ($g['gamecat'] != '20' && $g['gamecat'] != '16') {
echo "<td width='20%' align='center' class='headertableblock'>Top Score</td>";
}
echo "</tr><tr><td class='arcade1' valign='top' align='center'><a href='index.php?play=".$g['gameid']."#playzone'><img height='60' width='60' alt='".$g['gameid']."' border='0' src='".$gamesloc."/pics/".$g['gameid'].".gif' /></a><br /></td><td class='arcade1'  align='center'><a href='./index.php?plat=".$g['platform']."' title='".$g['platform']."'><img src='".$arcurl."/".$imgloc."/HTML5.png'  height='25' width='25' alt='HTML5 Game' style='float:left; margin-left:10px; clear: both;' /></a><br /><a href='./index.php?cat=".$g['gamecat']."' title='".$showcat[0]."'><img src='".$arcurl."/".$catloc."/".$showcat[0].".png'  height='25' width='25' alt='".$showcat[0]."' style='float:left; margin-left:10px; margin-top:15px; clear: both;' /></a>".$g['about']."<br /><br />";
} else {
	echo "<div class='tableborder'><table width='100%' cellpadding='4' cellspacing='1' class='gameview'><tr><td width='5%' align='center' class='headertableblock'></td><td width='60%' align='center' class='headertableblock'>".$g[1]."</td>";
	if ($g['gamecat'] != '16') {
	echo "<td width='20%' align='center' class='headertableblock'>Top Score</td>";
	}
	echo "</tr><tr><td class='arcade1' valign='top' align='center'><a href='index.php?play=".$g['gameid']."#playzone'><img height='60' width='60' alt='".$g['gameid']."' border='0' src='".$gamesloc."/pics/".$g['gameid'].".gif' /></a><br /></td><td class='arcade1'  align='center'><a href='./index.php?plat=".$g['platform']."' title='".$g['platform']."'><img src='".$arcurl."/".$imgloc."/flash.png' height='25' width='25' alt='Flash Game' style='float:left; margin-left:10px; clear: both;' /><br /><a href='./index.php?cat=".$g['gamecat']."' title='".$showcat[0]."'><img src='".$arcurl."/".$catloc."/".$showcat[0].".png'  height='25' width='25' alt='".$showcat[0]."' style='float:left; margin-left:10px; margin-top:15px; clear: both;' /></a>".$g['about']."<br /><br />";
}
if ($CheckScoring == 'LO') {
echo "<a title='Lowest Score Wins This Game'><img src='$arcurl/$imgloc/low.png'  height='21' width='25' alt='Lowest Score Wins This Game' style='float: left; margin-left:40px; margin-right:-65; margin-top:-15px;' /></a>";
}
echo "<div style='text-align: center; margin-bottom: -20px;'>";
if(isset($_COOKIE['phpqa_user_c']) || $settings['allow_guests']) { echo "<a href='index.php?play=".$g['gameid']."#playzone' class='navigation'> Play </a><a href='index.php?fullscreen=".$g['gameid']."' class='navigation'> Full </a>"; } else { echo " <a href='#logtop' onclick='javascript:tog(\"login_form\")' class='navigation'>Login to play</a> "; }
if (isset($exist[6])&&$exist[6] == "Admin") { echo "<a href='index.php?cpiarea=addgames&method=edit&game=".$g['gameid']."' title='Edit Game Settings' class='navigation'>EDIT</a>";} 
$fav_action='';
$DL_action='';
if(isset($_COOKIE['phpqa_user_c'])) {
$fav_action="<a href='index.php?action=fav&game=".$g['gameid']."&favtype=add&akey=".$key."&fav=1' title='Add Game To Favorites'><img src='".$imgloc."/favorite.png' alt='[Add to favorites]' width='25' height='25' /></a>";
if(isset($_GET['fav'])) $fav_action="<a href='index.php?action=fav&game=".$g['gameid']."&favtype=remove&akey=".$key."&fav=1' title='Remove Game From Favorites'><img src='".$imgloc."/remove.png' alt='[Remove favorite]' width='25' height='25' /></a>";
}
if ((isset($exist[6])&&$exist[6] == "Admin") || (isset($exist[6])&&$exist[6] ==  "Affiliate")) { 
    if (((null !== $showcat[0] && $showcat[0] == "Testing") || (null !== $g['exclusiv']) && $g['exclusiv'] == 1) && ($exist[6] ==  "Affiliate")){
        if($g['exclusiv'] == 1){
        $DL_action="<a title='Exclusive Game - Sorry, No Download'><img src='".$arcurl."/".$imgloc."/exclusiv.png' height='25' width='25' alt='Exclusive Game - Sorry, No Download' /></a>";
        }} else {
$DL_action="<a href='GetGame.php?GID=".$g['gameid']."' title='Download Game TAR'><img src='".$arcurl."/".$imgloc."/DL.png' height='25' width='25' alt='Download Game .tar' /></a>&nbsp;";
}}
echo "</div><div class='viewedtimes' style='float: right;'>".$DL_action.$fav_action."</div></td>";
if ($g['gamecat'] != '20' && $g['gamecat'] != '16') {
echo "<td class='arcade1' valign='top' align='center'><img alt='image' src='".$crowndir."/crown1.gif' /><br /><b>".str_replace('-', '', $g['Champion_score'])."</b><br /><b>".($g['Champion_name']?"<a href='index.php?action=profile&amp;user=".$g['Champion_name']."' class='".$CHMPimg['group']."Look'>".$g['Champion_name']."</a></b>":"------------</b>")."<p><a href='index.php?id=".$g['gameid']."'>View Highscores</a></p></td></tr></table></div><br />";
}}}
}}	
?>
