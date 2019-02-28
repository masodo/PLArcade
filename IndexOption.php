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
# Section: IndexOption.php  Function: Display Games Index   Modified: 2/28/2019   By: MaSoDo

	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	//		  Favorites
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
if (isset($_GET['action']) && $_GET['action'] == "fav") {
vsess();
$_GET['game'] = htmlspecialchars($_GET['game'], ENT_QUOTES);
$game_exist=mysql_fetch_array(run_query("SELECT `id` FROM phpqa_games WHERE gameid='{$_GET['game']}'"));
if($game_exist[0]) {
//Adding?
if(isset($_GET['favtype']) && $_GET['favtype'] == "add") { 
message("Added to favorites. Refresh to see changes.");
$acct_setting[5].="{$_GET['game']},"; 
} else { 
// Removing
message("Removed game from favorites. Refresh to see changes.");
$acct_setting[5]=str_replace("{$_GET['game']},", "", $acct_setting[5]); 
}
run_query("UPDATE `phpqa_accounts` SET `settings` = '$acct_setting[0]|$acct_setting[1]|$acct_setting[2]|$acct_setting[3]|$acct_setting[4]|$acct_setting[5]' WHERE name='$phpqa_user_cookie'");
} else {
message("Game not found.");
}
}
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	//		  Game index display
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
global $catquer;
if (!isset($_GET['action'])||isset($_GET['action'])&&$_GET['action']!='settings') {
//if (!empty($catquer)&&isset($_GET['action'])&&$_GET['action']!='settings') {
if (!empty($catquer)) {
//echo "<script>alert('Hello World!');</script>";
//Begin Collapse #4
echo "<div style='text-align:center; margin-bottom: 5px; margin-top: 5px;'><a title='Open/Close The Games Index'><img id='btn4' src='" . $imgloc . "/" . $collimg4 . "' type='button' alt='&#8595; Games: Collapse/Expand &#8595;' onclick='return CollapseExpand4()' style='font-size:16px; font-weight:bold; color:silver;' /></a></div><div id='MyDiv4' class='" . $collapset4 . "'>";


	while($g=mysql_fetch_array($catquer)){ 
	// Select from the scores table....
	
$CheckScoring = $g['scoring'];
if ($g['gamecat'] != '2') {
$showcat=mysql_fetch_array(run_query("SELECT cat FROM phpqa_cats WHERE id='{$g['gamecat']}'"));	
if ($g['platform'] == 'H5') { 
echo "<div class='tableborder'><table width='100%' cellpadding='4' cellspacing='1' class='gameview'><tr><td width='5%' align='center' class='headertableblock'></td><td width='60%' align='center' class='headertableblock'>$g[1]</td>";
if ($g['gamecat'] != '20' && $g['gamecat'] != '16') {
echo "<td width='20%' align='center' class='headertableblock'>Top Score</td>";
}
echo "</tr><tr><td class='arcade1' valign='top' align='center'><a href='index.php?play=".$g['gameid']."'><img height='60' width='60' alt='".$g['gameid']."' border='0' src='".$gamesloc."/pics/".$g['gameid'].".gif' /></a><br /></td><td class='arcade1'  align='center'><a href='./index.php?plat=".$g['platform']."' title='".$g['platform']."'><img src='".$arcurl."/".$imgloc."/HTML5.png'  height='25' width='25' alt='HTML5 Game' style='float:left; margin-left:10px; clear: both;' /></a><br /><a href='./index.php?cat=".$g['gamecat']."' title='".$showcat[0]."'><img src='".$arcurl."/".$catloc."/".$showcat[0].".png'  height='25' width='25' alt='".$showcat[0]."' style='float:left; margin-left:10px; margin-top:15px; clear: both;' /></a>".$g['about']."<br /><br />";
} else {
	echo "<div class='tableborder'><table width='100%' cellpadding='4' cellspacing='1' class='gameview'><tr><td width='5%' align='center' class='headertableblock'></td><td width='60%' align='center' class='headertableblock'>".$g[1]."</td>";
	if ($g['gamecat'] != '16') {
	echo "<td width='20%' align='center' class='headertableblock'>Top Score</td>";
	}
	echo "</tr><tr><td class='arcade1' valign='top' align='center'><a href='index.php?play=".$g['gameid']."'><img height='60' width='60' alt='".$g['gameid']."' border='0' src='".$gamesloc."/pics/".$g['gameid'].".gif' /></a><br /></td><td class='arcade1'  align='center'><a href='./index.php?plat=".$g['platform']."' title='".$g['platform']."'><img src='".$arcurl."/".$imgloc."/flash.png' height='25' width='25' alt='Flash Game' style='float:left; margin-left:10px; clear: both;' /><br /><a href='./index.php?cat=".$g['gamecat']."' title='".$showcat[0]."'><img src='".$arcurl."/".$catloc."/".$showcat[0].".png'  height='25' width='25' alt='".$showcat[0]."' style='float:left; margin-left:10px; margin-top:15px; clear: both;' /></a>".$g['about']."<br /><br />";
}
if ($CheckScoring == 'LO') {
echo "<a title='Lowest Score Wins This Game'><img src='$arcurl/$imgloc/low.png'  height='21' width='25' alt='Lowest Score Wins This Game' style='float: left; margin-left:40px; margin-right:-65; margin-top:-15px;' /></a>";
}
if(isset($_COOKIE['phpqa_user_c']) || $settings['allow_guests']) { echo "<a href='index.php?play=".$g['gameid']."' class='navigation'> Play </a>"; } else { echo " <a href='#logtop' onclick='javascript:tog(\"login_form\")' class='navigation'>Login to play</a> "; }

$fav_action='';
if(isset($_COOKIE['phpqa_user_c'])) {
$fav_action="<br /><a href='index.php?action=fav&game=".$g['gameid']."&favtype=add&akey=".$key."&fav=1' title='Add Game To Favorites'><img src='".$imgloc."/favorite.png' alt='[Add to favorites]' width='25' height='25' /></a>";
if(isset($_GET['fav'])) $fav_action="<br /><a href='index.php?action=fav&game=".$g['gameid']."&favtype=remove&akey=".$key."&fav=1' title='Remove Game From Favorites'><img src='".$imgloc."/remove.png' alt='[Remove favorite]' width='25' height='25' /></a>";
}

echo "<div class='viewedtimes'>".$fav_action."</div></td>";
if ($g['gamecat'] != '20' && $g['gamecat'] != '16') {
echo "<td class='arcade1' valign='top' align='center'><img alt='image' src='".$crowndir."/crown1.gif' /><br /><b>".str_replace('-', '', $g['Champion_score'])."</b><br /><b>".($g['Champion_name']?"<a href='index.php?action=profile&amp;user=".$g['Champion_name']."'>".$g['Champion_name']."</a></b>":"------------</b>")."<p><a href='index.php?id=".$g['gameid']."'>View Highscores</a></p></td>";
}
echo "</tr></table></div><br />";
}}
	}}
?>