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
# Section: PlayOption.php  Function: Game Play Block   Modified: 7/19/2019   By: MaSoDo
//modified to play HTML5 Games
$play = htmlspecialchars($_GET['play'], ENT_QUOTES);
	$g = mysql_fetch_array(run_query("SELECT * FROM phpqa_games WHERE gameid='".$play."'")); 
	// Patch - 06/01/09
	if($g['game'] == "")  { 
	message("This game doesn't exist / has been deleted."); 
	die(); 
	}
    run_query("UPDATE phpqa_games SET `times_played`=".++$g['times_played']." WHERE gameid='".$play."'");
?>
<br />
<div class='tableborder'><a name='playzone'></a>
<table width='100%' cellpadding='4' cellspacing='1'>
<tr>
<td width='80%' align='center' class='headertableblock'></td>
<td width='10%' align='center' class='headertableblock'><?php echo $g['game']; ?></td>
</tr>
<tr>
<td class='arcade1' valign='middle' align='center'>
<?php 
if (isset($_COOKIE['phpqa_user_c']) || $settings['allow_guests']) { 
if (isset($highscore[0])=="") $highscore[0] = "";
if (isset($highscore[1])=="") $highscore[1] = "------------";
if ($g['remotelink'] == "") {
$swf_resource = "arcade/".$play.".swf";
} else {
$swf_resource = $g['remotelink'];
}
global $phpqa_user_cookie;
$yourscore=mysql_fetch_row(run_query("SELECT thescore FROM phpqa_scores WHERE gameidname='".$play."' AND username='".$phpqa_user_cookie."'"));
$yourscore=$yourscore[0];
$CHMP = run_query("SELECT `avatar` FROM `phpqa_accounts` WHERE `name` = '" . $g['Champion_name'] . "'");
$CHMPimg=mysql_fetch_array($CHMP);
if (!$CHMPimg['avatar'])$CHMPimg['avatar'] = $avatarloc.'/man.gif';

?>
<a name="game"></a>
<?php 
//modified to play HTML5 Games
$CheckPlatform = $g['platform'];
if ($CheckPlatform == 'H5') {
echo "<iframe src='" . $g['remotelink'] . "' scrolling='no' style='overflow: hidden; outline: none; border: 0px; width: " . $g['gamewidth'] . "px; height: " . $g['gameheight'] . "px; overflow: hidden;' id='" . $g['id'] . "' data-id='" . $g['id'] . "' data-gname='" . $g['gameid'] . "'></iframe><div style='width:25px;float:left; margin-top:20px; margin-left:20px;'><a href='/FORUM/post.php?fid=".$ReportID."&REPORT_GAME=".$g['gameid'] . "' target='_blank' title='please report any trouble with this game'><img src='".$imgloc."/redflag.png' /></a></div>";
} else { echo "<div style='width:25px;float:left; margin-top:20px; margin-left:20px;'><a href='/FORUM/post.php?fid=".$ReportID."&REPORT_GAME=".$g['gameid'] . "' target='_blank' title='please report any trouble with this game'><img src='".$imgloc."/redflag.png' /></a></div>";
?>
<object classid=clsid:D27CDB6E-AE6D-11cf-96B8-444553540000 codebase=http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0 align=middle WIDTH=<?php echo $g['gamewidth']; ?> HEIGHT=<?php echo $g['gameheight']; ?>> <param name='movie' value='<?php echo $swf_resource ?>' /><param name=quality value=high /> <param name=allowScriptAccess value=sameDomain /> <param name='menu' value='false' /> <embed src="<?php echo $swf_resource; ?>" quality=high pluginspage=http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash WIDTH=<?php echo $g['gamewidth']; ?> HEIGHT=<?php echo $g['gameheight']; ?> menu='false' type=application/x-shockwave-flash align=middle /></object>
<?php } ?>
<?php if(!isset($_COOKIE['phpqa_user_c'])) { echo "<br />[ You are not logged in. Your score will not be saved. <a href='?action=register'>Register</a> to submit highscores. ]"; } ?>
</td>
<td class='arcade1' valign='top' align='center'>
<a href='javascript:alert("<?php echo $g['about'] ?>");'><img alt='image' border='0' src='arcade/pics/<?php echo $play; ?>.gif' width='80' height='80' /></a>
<br />
<?php if ($g['gamecat'] != '20' && $g['gamecat'] != '16') { ?>
<div id='popup' style='position:absolute;margin-left:auto;margin-right:auto;top:0px;border:1px solid #333;background-color:#DDD;color:#888;display:none;width:150px;'>
<center><b>Highscores</b></center><br />
<ol style="text-align:left">
<?php
$q=run_query("SELECT username,thescore FROM phpqa_scores WHERE gameidname='".$play."' ORDER BY thescore DESC LIMIT 0,10");
while($f=mysql_fetch_array($q)) echo "<li><b>".$f[0]."</b>: ".$f[1]."</li>";
?>
</ol></div>
<a href="index.php?id=<?php echo $g['gameid']; ?>" onmouseover="document.getElementById('popup').style.display=''" onmouseout="document.getElementById('popup').style.display='none'" onmousemove="s=document.getElementById('popup').style;s.top=document.body.scrollTop+event.clientY+2;s.left=document.body.scrollLeft+event.clientX-152;">
<div class="navigation" style="background-color: black; margin-left: 10px; margin-right: 10px; margin-top: 10px; padding: -5px 10px 5px 10px;"><p><i>Game Champion</i></p><p><img src='<?php echo $CHMPimg['avatar'] ?>'  width='50' /></p><img alt='image' src='<?php echo($crowndir) ?>/crown1.gif' />&nbsp;<b style='color: white;'><?php echo $g['Champion_name']; ?></b>&nbsp;<img alt='image' src='<?php echo($crowndir) ?>/crown1.gif' /><br /><?php echo str_replace('-', '', $g['Champion_score']); ?></div></a><p><?php echo $yourscore!=$g['Champion_score']&&$yourscore?"<i>Your Best:</i> " . str_replace('-', '', $yourscore) . "</p>":""; }?>
<br />
<a href="index.php?fullscreen=<?php echo $_GET['play']; ?>" title="Fullscreen Mode" target="_blank"><img src="<?php echo $imgloc; ?>/FullScreen.gif" alt="Fullscreen Mode" /></a><br />
<br />
<?php 
if (isset($exist[6])&&$exist[6] == "Admin") { 
echo "<a href='index.php?cpiarea=addgames&method=edit&game=".$play."' title='Edit Game Settings' class='navigation'>EDIT</a><br />";
}
if ($CheckPlatform != 'H5') {
?>
Width: <a href="javascript:void(0)" onclick="document.getElementById('<?php echo $g['id']; ?>').innerHTML=chsize('width');" title='Change...'><?php echo $g['gamewidth']; ?></a><br />Height: <a href="javascript:void(0)" onclick="document.getElementById('<?php echo $g['id']; ?>').innerHTML=chsize('height')" title='Change...'><?php echo $g['gameheight']; ?></a><br />
<?php 
}
?>
<?php 
$fav_action='';
if(isset($_COOKIE['phpqa_user_c'])) {
$fav_action="<br /><a href='index.php?action=fav&game=".$g['gameid']."&favtype=add&akey=".$key."&fav=1' title='Add Game To Favorites'><img src='".$imgloc."/favorite.png' alt='[Add to favorites]' width='25' height='25' /></a>";
}
$CheckPlatform = $g['platform'];
$CheckScoring = $g['scoring'];
$showcat=mysql_fetch_array(run_query("SELECT cat FROM phpqa_cats WHERE id='{$g['gamecat']}'"));	
if ($CheckPlatform == 'H5') { 
$PlatWord = 'HTML5';
}
if ($CheckPlatform == 'FL') { 
$PlatWord = 'flash';
}
echo "<div style='width:60px; margin-left:auto; margin-right:auto;'>";
echo "<a href='./index.php?plat=".$g['platform']."' title='".$PlatWord." Game'><img src='".$arcurl."/".$imgloc."/".$PlatWord.".png'  height='25' width='25' alt='".$PlatWord." Game' style='float:left; margin-left:0px; margin-top:15px;' /></a>";

if ($g['gamecat'] == '23'){
echo "<script>alert('this game is currently being tested!\\nuse at your own risk\\n(may not score properly)');</script>";
}
echo "<a href='./index.php?cat=".$g['gamecat']."' title='".$showcat[0]."'><img src='".$arcurl."/".$catloc."/".$showcat[0].".png'  height='25' width='25' alt='".$showcat[0]."' style='float:left; margin-left:5px; margin-top:15px;' /></a>";
if ($CheckScoring == 'LO') {
echo "<a title='Lowest Score Wins This Game'><img src='".$arcurl."/".$imgloc."/low.png'  height='21' width='25' alt='Lowest Score Wins This Game' style='margin-left:auto; margin-right:auto; margin-top:15px;' /></a>";
}
echo "</div>";
echo "<div style='position: relative; width:25px; margin-left:auto; margin-right:auto; margin-top: 60px;'>".$fav_action."</br>";
if ((isset($exist[6])&&$exist[6] == "Admin") || (isset($exist[6])&&$exist[6] ==  "Affiliate")) { 
if (((null !== $showcat[0] && $showcat[0] == "Testing") || (null !== $g['exclusiv']) && $g['exclusiv'] == 1) && ($exist[6] ==  "Affiliate")){if($g['exclusiv'] == 1){echo $DL_action="<a title='Exclusive Game - Sorry, No Download'><img src='".$arcurl."/".$imgloc."/exclusiv.png' height='25' width='25' alt='Exclusive Game - Sorry, No Download' /></a>";} else {} } else {
echo "<a href='GetGame.php?GID=".$play."' title='Download Game TAR'><img src='".$arcurl."/".$imgloc."/DL.png' height='25' width='25' alt='Download Game .tar' style='margin-left:auto; margin-right:auto; margin-top:15px;' /></a>";
}}
echo "</div>";
if ($g['gamecat'] != '20' && $g['gamecat'] != '16') {
$HOF = run_query("SELECT `avatar` FROM `phpqa_accounts` WHERE `name` = '" . $g['HOF_name'] . "'");
$HOFimg=mysql_fetch_array($HOF);
if (!$HOFimg['avatar'])$HOFimg['avatar'] = $avatarloc.'/man.gif';
echo "<div class='navigation' style='background-color: black; margin-left: 10px; margin-right: 10px; margin-top: 10px; margin-bottom: 10px; padding: -5px 10px 5px 10px;'><i>Hall of Fame</i><br /><img alt='image' src='" . $HOFimg['avatar'] . "' height='' width='75' alt='" . $g['HOF_name'] . "' style='width:75px ; margin-left:auto; margin-right:auto; margin-top:5px; margin-bottom:5px;'  /><br /><img alt='image' src='" . $crowndir ."/crown1.gif' />&nbsp;<b style='color: white;'>" . $g['HOF_name'] . "</b>&nbsp;<img alt='image' src=' " . $crowndir . "/crown1.gif' /><br /><span style='color:black;'>" . str_replace('-', '', $g['HOF_score']) ."</span></div>";
}} else { 
echo "You must be logged in to play the arcade games. Register an account to play - it's free <a href='index.php?action=register'>Click here</a>!</td><td class='arcade1' valign='top' align='center'>";
}
?>
</td>
</tr>
</table></div>
<br />
